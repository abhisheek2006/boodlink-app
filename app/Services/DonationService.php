<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\DonationSession;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Centralizes the donor availability / donation-session state machine so
 * controllers stay thin (Rules 1-6 in the project spec).
 */
class DonationService
{
    public const SESSION_MINUTES = 30;
    public const COOLDOWN_DAYS_MALE = 90;
    public const COOLDOWN_DAYS_FEMALE = 120;

    /**
     * Donor accepts a blood request: creates the session, flips the donor
     * to Busy, and closes out any other pending requests aimed at them
     * only insofar as they can no longer be accepted (they simply won't
     * be actionable once Busy, enforced by the eligibility middleware).
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
                'expires_at' => now()->addMinutes(self::SESSION_MINUTES),
                'status' => 'Active',
                'contact_shared' => false,
            ]);

            $donor->update([
                'availability' => 'Busy',
                'donation_status' => 'In Session',
            ]);

            $this->notify($request->patient->user_id, 'Request Accepted', 'A donor has accepted your blood request and a private chat is now open.');

            return $session;
        });
    }

    public function rejectRequest(BloodRequest $request): void
    {
        $request->update(['status' => 'Rejected']);

        $this->notify($request->patient->user_id, 'Request Declined', 'Your blood request was declined. You can search for another donor.');
    }

    public function cancelRequest(BloodRequest $request): void
    {
        $request->update(['status' => 'Cancelled']);
    }

    public function shareContact(DonationSession $session): void
    {
        $session->update(['contact_shared' => true]);

        $this->notify($session->patient->user_id, 'Contact Details Shared', 'The donor has shared their contact details with you.');
    }

    /**
     * Donor clicks "Complete Donation": closes the session, increments the
     * donor's total, recalculates badge/rank, and starts the cooldown.
     */
    public function completeDonation(DonationSession $session): void
    {
        DB::transaction(function () use ($session) {
            $donor = $session->donor;

            $session->update([
                'status' => 'Completed',
                'ended_at' => now(),
                'session_duration' => $session->started_at->diffInSeconds(now()),
            ]);

            $session->bloodRequest->update(['status' => 'Completed']);

            $cooldownDays = $donor->user->gender === 'Female'
                ? self::COOLDOWN_DAYS_FEMALE
                : self::COOLDOWN_DAYS_MALE;

            $newTotal = $donor->total_donations + 1;

            $donor->update([
                'total_donations' => $newTotal,
                'current_badge' => $donor->badgeForDonationCount($newTotal),
                'last_donation_date' => now()->toDateString(),
                'next_eligible_date' => now()->addDays($cooldownDays)->toDateString(),
                'availability' => 'Waiting',
                'donation_status' => 'Cooldown',
            ]);

            $this->recalculateRanks();

            $this->notify($session->patient->user_id, 'Donation Completed', 'Your donation session has been completed. Thank you!');
            $this->notify($donor->user_id, 'Waiting Period Started', "Your cooldown has started. Next eligible: {$donor->next_eligible_date->toFormattedDateString()}.");

            // Send a well-wishing "thank you for donating" email to the donor.
            try {
                $freshDonor = $donor->fresh();
                \Mail::to($freshDonor->user->email)
                    ->send(new \App\Mail\DonationThankYou($freshDonor->user->fresh(), $session));
            } catch (\Throwable $e) {
                // Email failures must never break the donation flow.
            }
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
                'session_duration' => $session->started_at->diffInSeconds(now()),
            ]);

            $session->bloodRequest->update(['status' => 'Cancelled']);

            $donor->update([
                'availability' => 'Available',
                'donation_status' => 'Idle',
            ]);
        });
    }

    /** Called by a scheduled command to flip Waiting donors back to Available once cooldown ends. */
    public function releaseFinishedCooldowns(): int
    {
        $donors = Donor::where('availability', 'Waiting')
            ->whereDate('next_eligible_date', '<=', now()->toDateString())
            ->get();

        foreach ($donors as $donor) {
            $donor->update(['availability' => 'Available', 'donation_status' => 'Idle']);
            $this->notify($donor->user_id, 'Waiting Period Completed', 'Your cooldown has ended. You are now available to donate again.');
        }

        return $donors->count();
    }

    /** Called by a scheduled command to expire sessions that blew past the 30-minute timer without action. */
    public function flagExpiredSessions(): int
    {
        $sessions = DonationSession::where('status', 'Active')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($sessions as $session) {
            $this->notify(
                $session->donor->user_id,
                'Session Timer Reminder',
                'Your donation session has been active for 30 minutes. Please complete or end it.'
            );
        }

        return $sessions->count();
    }

    private function recalculateRanks(): void
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
