<?php

namespace App\Http\Controllers;

use App\Models\DonationSession;
use App\Models\Donor;
use App\Services\DonationService;
use App\Services\DonorDetailSharingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationSessionController extends Controller
{
    public function __construct(
        protected DonationService $donationService
    ) {}

    /** Donor: mark the donation as completed (Rule 4). One-time action. */
    public function complete(DonationSession $session, Request $request): RedirectResponse
    {
        $this->authorizeDonor($session, $request);

        abort_unless($session->status === 'Active', 422, 'This session has already been closed.');

        $this->donationService->completeDonation($session);

        return redirect()->route('donor.dashboard')->with('success', 'Donation completed. Thank you for saving a life!');
    }

    /** Donor: close the session without a completed donation. */
    public function end(DonationSession $session, Request $request): RedirectResponse
    {
        $this->authorizeDonor($session, $request);

        abort_unless($session->status === 'Active', 422, 'This session has already been closed.');

        $this->donationService->endSession($session);

        return redirect()->route('donor.dashboard')->with('success', 'Session ended.');
    }

    /**
     * Donor: explicitly share their contact details with the patient.
     *
     * Authorization checks:
     * 1. The authenticated user is the donor for this session.
     * 2. The session is still active.
     * 3. Details haven't already been shared (and not revoked).
     */
    public function shareContact(DonationSession $session, Request $request): RedirectResponse
    {
        $donor = $this->authorizeDonor($session, $request);

        abort_unless($session->status === 'Active', 422, 'This session is no longer active.');

        $this->donationService->shareContact($session, $donor);

        return back()->with('success', 'Contact details shared with the patient.');
    }

    /**
     * Donor: revoke previously shared contact details.
     */
    public function revokeContact(DonationSession $session, Request $request, DonorDetailSharingService $sharingService): RedirectResponse
    {
        $donor = $this->authorizeDonor($session, $request);

        $share = $sharingService->getShareForSession($session);

        abort_unless($share, 404, 'No shared details record found for this session.');

        $sharingService->revoke($share, $donor);

        return back()->with('success', 'Contact details revoked.');
    }

    private function authorizeDonor(DonationSession $session, Request $request): Donor
    {
        $donor = $request->user()->donor()->firstOrFail();

        abort_unless($session->donor_id === $donor->id, 403, 'This session does not belong to you.');

        return $donor;
    }

    /** Admin: list all donation sessions. */
    public function adminIndex(Request $request): View
    {
        $query = DonationSession::query()
            ->with(['donor.user', 'bloodRequest.patient.user']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->query('date')) {
            $query->whereDate('started_at', $date);
        }

        $sessions = $query->latest('started_at')->paginate(25)->withQueryString();

        return view('admin.donations', compact('sessions'));
    }

    /** Admin: inspect a single donation session. */
    public function adminShow(DonationSession $session): View
    {
        $session->load([
            'donor.user',
            'bloodRequest.patient.user',
            'bloodRequest.bloodGroup',
            'chatMessages.sender',
        ]);

        return view('admin.donation-detail', compact('session'));
    }
}
