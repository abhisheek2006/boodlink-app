<?php

namespace App\Services;

use App\Models\DonationSession;
use App\Models\Donor;
use App\Models\DonorDetailShare;
use Carbon\Carbon;

/**
 * Manages the lifecycle of donor contact-detail sharing.
 *
 * - share(): creates a share record (only allowed when session is active/completed).
 * - getShareForSession(): retrieves the share record (if any).
 * - revoke(): marks the share as revoked by the donor.
 */
class DonorDetailSharingService
{
    public function share(DonationSession $session, Donor $donor): DonorDetailShare
    {
        // Only share while session is in an eligible status.
        $allowed = (array) config('blood.shareable_session_statuses', ['Active', 'Completed']);

        if (! in_array($session->status, $allowed, true)) {
            throw new \UnexpectedValueException(
                'Contact details can only be shared for sessions in status: '.implode(', ', $allowed),
            );
        }

        $share = DonorDetailShare::updateOrCreate(
            ['donation_session_id' => $session->id],
            [
                'donor_id' => $donor->id,
                'patient_id' => $session->patient_id,
                'shared_at' => Carbon::now(),
                'revoked_at' => null,
            ],
        );

        // Keep the session's quick-check flag in sync so the UI (and the
        // admin/patient views) know the contact has actually been shared.
        $session->forceFill(['contact_shared' => true])->save();

        return $share;
    }

    public function getShareForSession(DonationSession $session): ?DonorDetailShare
    {
        return DonorDetailShare::where('donation_session_id', $session->id)->first();
    }

    public function revoke(DonorDetailShare $share, Donor $donor): DonorDetailShare
    {
        if ($share->donor_id !== $donor->id) {
            throw new \UnexpectedValueException('Only the donor who shared these details can revoke them.');
        }

        if (! $share->isActive()) {
            throw new \UnexpectedValueException('These details have already been revoked.');
        }

        $share->forceFill(['revoked_at' => Carbon::now()])->save();

        // Mirror the revocation on the session so the UI stops showing the
        // shared contact immediately.
        if ($share->donationSession) {
            $share->donationSession->forceFill(['contact_shared' => false])->save();
        }

        return $share;
    }
}
