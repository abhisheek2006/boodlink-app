<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Provides ABO & RhD-compatible blood-group lookups.
 *
 * Standard medical compatibility rules:
 *   - O- is the universal donor (every group can receive from it).
 *   - AB+ is the universal recipient (can receive from any group).
 *   - RhD-negative patients can ONLY receive RhD-negative blood.
 */
class BloodCompatibilityService
{
    /** Full ABO × RhD compatibility matrix (recipient → [compatible donors]). */
    protected static array $compatibility = [
        // Universal recipient
        'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
        'AB-' => ['A-', 'B-', 'AB-', 'AB-', 'O-'],

        'A+' => ['A+', 'A-', 'O+', 'O-'],
        'A-' => ['A-', 'O-'],

        'B+' => ['B+', 'B-', 'O+', 'O-'],
        'B-' => ['B-', 'O-'],

        'O+' => ['O+', 'O-'],
        'O-' => ['O-'],
    ];

    /**
     * Get all blood groups that are compatible donors for the given
     * recipient group.
     *
     * @param  string  $recipientGroupName  e.g. "A+"
     * @return array<string> list of compatible donor blood-group names
     */
    public function compatibleDonors(string $recipientGroupName): array
    {
        return Cache::remember(
            "compatible_donors.{$recipientGroupName}",
            now()->addDay(),
            fn () => self::$compatibility[strtoupper($recipientGroupName)] ?? [],
        );
    }

    /**
     * Get all blood groups that can SAFELY receive from the given donor
     * group (reverse lookup).
     */
    public function compatibleRecipients(string $donorGroupName): array
    {
        $donor = strtoupper($donorGroupName);
        $recipients = [];

        foreach (self::$compatibility as $recipient => $donors) {
            if (in_array($donor, $donors, true)) {
                $recipients[] = $recipient;
            }
        }

        return $recipients;
    }

    /** Whether donor can donate to recipient. */
    public function isCompatible(string $donorGroupName, string $recipientGroupName): bool
    {
        return in_array(
            strtolower($donorGroupName),
            array_map('strtolower', $this->compatibleDonors($recipientGroupName)),
            true,
        );
    }

    /** All eight standard blood groups. */
    public function allGroups(): Collection
    {
        return collect(array_keys(self::$compatibility));
    }
}
