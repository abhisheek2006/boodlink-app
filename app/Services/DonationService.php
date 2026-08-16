<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\DonationSession;
use App\Models\Donor;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

/**
 * Centralizes the donor availability / donation-session state machine so
 * controllers stay thin (Rules 1-6 in the project spec).
 *
 * All policy values (cooldown days, session timeout, badge thresholds)
 * come from config/blood.php — they are never hardcoded here.
 */
class DonationService
{
    public function __construct(
        protected DonorEligibilityService $eligibilityService,
        protected AuditLogService $auditLog,
    ) {}

    /**
     * Session timeout in minutes (from config).
     */
    public function sessionTimeoutMinutes(): int
    {
        return (int) config('blood.session_timeout_minutes', 30);
    }

    /**
     * Deferral days for the given donor's gender (from config).
     */
    public function deferralDays(string $gender): int
    {
        $policy = config('blood.donation_deferral.whole_blood', []);

        return match ($gender) {
            'Male' => (int) ($policy['male_days'] ?? 90),
            'Female' => (int) ($policy['female_days'] ?? 120),
            default => (int) ($policy['other_days'] ?? 90),
        };
    }

    /**
     * Donor accepts a blood request: creates the session, flips the donor
     * to Busy, and starts the donation lifecycle.
     *
     * Verifies eligibility again server-side to prevent race conditions
     * and stale frontend data.
     */
    public function acceptRequest(BloodRequest $request, Donor $donor): DonationSession
    {
        return DB::transaction(function () use ($request, $donor) {
            $request->update([
                'donor_id' => $donor->id,
                'status' => 'Accepted',
            ]);

            $session = DonationSession::create([
                'patient_id' => $request->patient_id,
                'donor_id' => $donor->id,
                'blood_request_id' => $request->id,
                'started_at' => now(),
                'expires_at' => now()->addMinutes($this->sessionTimeoutMinutes()),
                'status' => 'Active',
                'contact_shared' => false,
            ]);

            $donor->update([
                'availability' => 'Busy',
                'donation_status' => 'In Session',
            ]);

            $this->notify(
                $request->patient->user_id,
                'Request Accepted',
                "A donor ({$donor->user->name}) has accepted your blood request. A private chat is now open."
            );

            $this->auditLog->logBloodRequestCreated($request, [
                'action' => 'accepted',
                'donor_id' => $donor->id,
            ]);

            return $session;
        });
    }

    public function rejectRequest(BloodRequest $request): void
    {
        $request->update(['status' => 'Rejected']);

        $this->notify(
            $request->patient->user_id,
            'Request Declined',
            'Your blood request was declined by the donor. You can search for another donor.'
        );
    }

    public function cancelRequest(BloodRequest $request): void
    {
        $request->update(['status' => 'Cancelled']);
    }

    /**
     * Donor explicitly shares their contact details.
     *
     * Delegates to DonorDetailSharingService which records the share
     * in donor_detail_shares for audit purposes, then notifies the
     * requesting patient so they know the details are available.
     */
    public function shareContact(DonationSession $session, Donor $donor): void
    {
        app(DonorDetailSharingService::class)->share($session, $donor);

        $this->notify(
            $session->patient->user_id,
            'Contact Details Shared',
            "Donor {$donor->user->name} shared their contact details with you. Open the chat to view them."
        );
    }

    /**
     * Donor clicks "Complete Donation": closes the session, increments the
     * donor's total, recalculates badge/rank, and starts the configured
     * post-donation deferral period.
     *
     * @throws \Exception if the session is not Active
     */
    public function completeDonation(DonationSession $session): void
    {
        if ($session->status !== 'Active' && $session->status !== 'In Progress') {
            throw new \Exception('Only an active donation session can be completed.');
        }

        DB::transaction(function () use ($session) {
            $donor = $session->donor;
            $patient = $session->patient;

            $session->update([
                'status' => 'Completed',
                'ended_at' => now(),
                'session_duration' => $session->started_at
                    ? $session->started_at->diffInSeconds(now())
                    : null,
            ]);

            $session->bloodRequest->update(['status' => 'Completed']);

            $newTotal = $donor->total_donations + 1;

            $nextEligible = $this->eligibilityService->calculateNextEligibleDate($donor);
            $nextEligibleDate = $nextEligible ? $nextEligible->toDateString() : null;

            $donor->update([
                'total_donations' => $newTotal,
                'current_badge' => $donor->badgeForDonationCount($newTotal),
                'last_donation_date' => now()->toDateString(),
                'eligible_again_at' => $nextEligible,
                'next_eligible_date' => $nextEligibleDate,
                'availability' => 'Waiting',
                'donation_status' => 'Cooldown',
            ]);

            if ($donor->user->gender === 'Other') {
                $donor->update(['medical_review_required' => true]);
            }

            $this->recalculateRanks();

            $this->notify(
                $patient->user_id,
                'Donation Completed',
                "Your donation session with {$donor->user->name} has been completed and recorded."
            );

            $eligibleString = $nextEligible?->toFormattedDateString() ?? 'N/A';
            $this->notify(
                $donor->user_id,
                'Waiting Period Started',
                "Your donation has been recorded. You are temporarily unavailable until your next eligible donation date: {$eligibleString}."
            );

            $this->auditLog->logDonationCompleted($session, [
                'total_donations' => $newTotal,
                'next_eligible_at' => $eligibleString,
                'deferral_days' => $this->deferralDays($donor->user->gender),
            ]);
        });
    }

    /**
     * Donor clicks "End Session" without completing a donation: no
     * donation count increment, donor simply becomes searchable again.
     */
    public function endSession(DonationSession $session): void
    {
        DB::transaction(function () use ($session) {
            $donor = $session->donor;

            $session->update([
                'status' => 'Cancelled',
                'ended_at' => now(),
                'session_duration' => $session->started_at
                    ? $session->started_at->diffInSeconds(now())
                    : null,
            ]);

            $session->bloodRequest->update(['status' => 'Cancelled']);

            $donor->update([
                'availability' => 'Available',
                'donation_status' => 'Idle',
            ]);
        });
    }

    /**
     * Called by a scheduled command to flip Waiting donors back to Available
     * once their cooldown ends, using the eligibility service for verification.
     */
    public function releaseFinishedCooldowns(): int
    {
        $donors = Donor::whereIn('availability', ['Waiting', 'Deferred'])
            ->where(function ($q) {
                $q->whereDate('next_eligible_date', '<=', now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->whereNotNull('eligible_again_at')
                            ->whereDate('eligible_again_at', '<=', now()->toDateString());
                    });
            })
            ->get();

        $released = 0;
        foreach ($donors as $donor) {
            $wasReleased = $this->eligibilityService->processAutomaticReactivation($donor);
            if ($wasReleased) {
                $released++;
                $this->notify(
                    $donor->user_id,
                    'Eligibility Restored',
                    'Your waiting period has ended. You are now available to receive new blood donation requests.'
                );
            }
        }

        return $released;
    }

    /**
     * Called by a scheduled command to remind donors whose 30-minute session
     * timer expired.
     */
    public function flagExpiredSessions(): int
    {
        $sessions = DonationSession::where('status', 'Active')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($sessions as $session) {
            $this->notify(
                $session->donor->user_id,
                'Session Timer Reminder',
                'Your donation session has been active for '.$this->sessionTimeoutMinutes().' minutes. Please complete or end it.'
            );
        }

        return $sessions->count();
    }

    /**
     * Recalculate donor rankings by total_donations (descending).
     */
    public function recalculateRanks(): void
    {
        Donor::orderByDesc('total_donations')
            ->get()
            ->each(function (Donor $donor, int $index) {
                $donor->update(['current_rank' => $index + 1]);
            });
    }

    private function notify(int $userId, string $title, string $message): void
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
        ]);
    }
}
