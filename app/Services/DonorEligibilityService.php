<?php

namespace App\Services;

use App\Models\Donor;
use Carbon\Carbon;

/**
 * Central decision engine for donor eligibility.
 *
 * A donor is eligible when ALL of the following are true:
 *   1. Age is within the allowed donation range (Rules 7: 18-65).
 *   2. Not currently in an active donation session (Rules 1, 2).
 *   3. Post-donation cooldown has elapsed (Rule 3).
 *   4. Availability is "Available" or "Idle" (not Busy / Waiting).
 *   5. No medical-review flag (optional safety gate).
 *   6. Weight ≥ minimum threshold.
 */
class DonorEligibilityService
{
    /** Minimum donor weight (kg). */
    public function minimumWeight(): float
    {
        return (float) config('blood.minimum_weight', 50);
    }

    /** Minimum donor age (years). */
    public function minimumAge(): int
    {
        return (int) config('blood.minimum_age_donate', 18);
    }

    /** Maximum donor age (years). */
    public function maximumAge(): int
    {
        return (int) config('blood.maximum_age_donate', 65);
    }

    /** Deferral days for the donor's gender. */
    public function deferralDays(Donor $donor): int
    {
        $gender = $donor->user?->gender ?? 'Other';
        $policy = (array) config('blood.donation_deferral.whole_blood', []);

        return match ($gender) {
            'Male' => (int) ($policy['male_days'] ?? 90),
            'Female' => (int) ($policy['female_days'] ?? 120),
            default => (int) ($policy['other_days'] ?? 90),
        };
    }

    /** The date the donor becomes eligible again after last donation. */
    public function calculateNextEligibleDate(Donor $donor): ?Carbon
    {
        if (! $donor->last_donation_date) {
            return null;
        }

        return $donor->last_donation_date
            ->copy()
            ->addDays($this->deferralDays($donor));
    }

    /**
     * Full eligibility check.
     *
     * @return array{eligible: bool, reason: string|null}
     */
    public function checkEligibility(Donor $donor): array
    {
        // Rule 1: age must be within the allowed donation range (18-65).
        $age = $donor->age();
        if ($age === null) {
            return [
                'eligible' => false,
                'reason' => 'The donor has no date of birth on file and cannot be verified as eligible.',
            ];
        }

        if ($age < $this->minimumAge()) {
            return [
                'eligible' => false,
                'reason' => "The donor is too young to donate. Minimum age is {$this->minimumAge()} years.",
            ];
        }

        if ($age > $this->maximumAge()) {
            return [
                'eligible' => false,
                'reason' => "The donor is over the maximum donation age of {$this->maximumAge()} years.",
            ];
        }

        // Rule 2: donor must not have an active (in-progress) session.
        if ($donor->activeSession()->exists()) {
            return [
                'eligible' => false,
                'reason' => 'The donor already has an active donation session.',
            ];
        }

        // Rule 3: must not be Busy / Waiting.
        if (! in_array($donor->availability, ['Available', 'Idle'], true)) {
            $reason = 'The donor is not currently available.';

            if ($donor->availability === 'Waiting' && $donor->next_eligible_date) {
                $remaining = now()->diffInDays($donor->next_eligible_date, false);
                $reason .= " Eligible again on {$donor->next_eligible_date->toFormattedDateString()} ({$remaining} day(s) left).";
            }

            return ['eligible' => false, 'reason' => $reason];
        }

        // Rule 4: cooldown check via next_eligible_date.
        if ($donor->next_eligible_date && $donor->next_eligible_date->isFuture()) {
            return [
                'eligible' => false,
                'reason' => "The donor is in a cooldown period until {$donor->next_eligible_date->toFormattedDateString()}.",
            ];
        }

        // Rule 5: medical review flag.
        // The donors table migration does not include medical_review_required yet;
        // guard with a column_exists check for forward-compatibility.
        if (
            \Schema::hasColumn('donors', 'medical_review_required')
            && $donor->medical_review_required
        ) {
            return [
                'eligible' => false,
                'reason' => 'The donor requires medical review before donating.',
            ];
        }

        // Weight check (safety gate).
        if ($donor->weight < $this->minimumWeight()) {
            return [
                'eligible' => false,
                'reason' => 'The donor does not meet the minimum weight requirement.',
            ];
        }

        return ['eligible' => true, 'reason' => null];
    }

    /**
     * Boolean convenience used by the donor search filter / request routing.
     *
     * A donor "can receive a blood request" exactly when they pass the full
     * eligibility check above: age within the allowed range, not in an active
     * session, post-donation cooldown elapsed, availability is Available/Idle,
     * no medical-review flag and minimum weight is met.
     */
    public function canReceiveBloodRequest(Donor $donor): bool
    {
        return $this->checkEligibility($donor)['eligible'];
    }

    /**
     * Re-evaluate a donor that is in "Waiting" / "Deferred" state and flip
     * them back to "Available" once the cooldown ends.
     *
     * @return bool whether the donor was reactivated
     */
    public function processAutomaticReactivation(Donor $donor): bool
    {
        // Already available — nothing to do.
        if ($donor->availability === 'Available') {
            return false;
        }

        // Check cooldown has ended.
        $eligibleDate = $donor->next_eligible_date
            ?? $donor->eligible_again_at
            ?? null;

        if ($eligibleDate && $eligibleDate->isFuture()) {
            return false;
        }

        $donor->update([
            'availability' => 'Available',
            'donation_status' => 'Idle',
        ]);

        return true;
    }
}
