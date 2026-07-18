<?php

namespace App\Http\Controllers;

use App\Models\DonationSession;
use App\Services\DonationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DonationSessionController extends Controller
{
    public function __construct(private DonationService $donationService)
    {
    }

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

    /** Donor: reveal contact details to the patient. */
    public function shareContact(DonationSession $session, Request $request): RedirectResponse
    {
        $this->authorizeDonor($session, $request);

        $this->donationService->shareContact($session);

        return back()->with('success', 'Contact details shared with the patient.');
    }

    private function authorizeDonor(DonationSession $session, Request $request): void
    {
        abort_unless($session->donor->user_id === $request->user()->id, 403);
    }
}
