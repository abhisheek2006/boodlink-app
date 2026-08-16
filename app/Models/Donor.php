<?php

namespace App\Models;

use Database\Factories\DonorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donor extends Model
{
    /** @use HasFactory<DonorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_group_id',
        'weight',
        'medical_history',
        'address',
        'city',
        'state',
        'pincode',
        'availability',
        'total_donations',
        'current_badge',
        'current_rank',
        'last_donation_date',
        'next_eligible_date',
        'eligible_again_at',
        'medical_review_required',
        'donation_status',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'total_donations' => 'integer',
            'last_donation_date' => 'date',
            'next_eligible_date' => 'date',
            'eligible_again_at' => 'datetime',
            'medical_review_required' => 'boolean',
        ];
    }

    // ── Relationships ────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function donationSessions(): HasMany
    {
        return $this->hasMany(DonationSession::class);
    }

    public function activeSession(): HasOne
    {
        return $this->hasOne(DonationSession::class)->where('status', 'Active');
    }

    // ── Eligibility helpers ──────────────────────────────────────

    /** Donor's current age in years, or null when no DOB is on file. */
    public function age(): ?int
    {
        return $this->user?->dob?->age;
    }

    /** Whether the donor is within the legal donation age range. */
    public function isAgeEligible(): bool
    {
        $age = $this->age();

        if ($age === null) {
            return false;
        }

        return $age >= (int) config('blood.minimum_age_donate', 18)
            && $age <= (int) config('blood.maximum_age_donate', 65);
    }

    /** Fully eligible to appear in search / receive requests. */
    public function isSearchable(): bool
    {
        return $this->isAgeEligible()
            && $this->availability === 'Available'
            && $this->user->isActiveAccount()
            && ! $this->activeSession()->exists()
            && ($this->next_eligible_date === null || $this->next_eligible_date->isPast());
    }

    public function remainingCooldownDays(): int
    {
        if (! $this->next_eligible_date) {
            return 0;
        }

        return max(0, now()->diffInDays($this->next_eligible_date, false));
    }

    public function badgeForDonationCount(int $count): string
    {
        return match (true) {
            $count >= 25 => 'Platinum Donor',
            $count >= 10 => 'Gold Donor',
            $count >= 5 => 'Silver Donor',
            $count >= 1 => 'Bronze Donor',
            default => 'No Badge',
        };
    }
}
