<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\Notification;
use App\Services\DonationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BloodRequestController extends Controller
{
    public function __construct(private DonationService $donationService)
    {
    }

    /** Patient: request form for a specific donor. */
    public function create(Donor $donor): View
    {
        return view('patient.request-form', compact('donor'));
    }

    /** Patient: submit a blood request to a chosen donor. */
    public function store(Request $request, Donor $donor): RedirectResponse
    {
        $patient = $request->user()->patient()->firstOrFail();

        if (! $donor->isSearchable()) {
            return back()->withErrors(['donor' => 'This donor is no longer available.']);
        }

        $data = $request->validate([
            'blood_group_id' => ['required', 'exists:blood_groups,id'],
            'units_required' => ['required', 'integer', 'min:1', 'max:4'],
            'emergency_level' => ['required', Rule::in(['Low', 'Medium', 'High', 'Critical'])],
            'reason' => ['required', 'string', 'max:1000'],
            'hospital_name' => ['nullable', 'string', 'max:255'],
            'required_date' => ['nullable', 'date', 'after_or_equal:today'],
            'additional_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $bloodRequest = BloodRequest::create($data + [
            'patient_id' => $patient->id,
            'donor_id' => $donor->id,
            'status' => 'Pending',
        ]);

        Notification::create([
            'user_id' => $donor->user_id,
            'title' => 'New Blood Request',
            'message' => "Patient: {$patient->user->name} - Blood Group: {$bloodRequest->bloodGroup->name} - Emergency: {$bloodRequest->emergency_level}",
        ]);

        return redirect()->route('patient.requests.index')->with('success', 'Blood request sent.');
    }

    /** Patient: list own requests. */
    public function index(Request $request): View
    {
        $patient = $request->user()->patient()->firstOrFail();

        $requests = $patient->bloodRequests()
            ->with(['donor.user', 'bloodGroup'])
            ->latest()
            ->paginate(15);

        return view('patient.requests', compact('requests'));
    }

    /** Patient: cancel a still-pending request. */
    public function cancel(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        abort_unless($bloodRequest->patient->user_id === $request->user()->id, 403);
        abort_unless($bloodRequest->status === 'Pending', 422, 'Only pending requests can be cancelled.');

        $this->donationService->cancelRequest($bloodRequest);

        return back()->with('success', 'Request cancelled.');
    }

    /** Donor: list incoming requests. */
    public function incoming(Request $request): View
    {
        $donor = $request->user()->donor()->firstOrFail();

        $requests = $donor->bloodRequests()
            ->with(['patient.user', 'bloodGroup'])
            ->where('status', 'Pending')
            ->latest()
            ->paginate(15);

        return view('donor.requests', compact('requests'));
    }

    /** Donor: accept a request — starts the session (Rules 1-3). */
    public function accept(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        $donor = $request->user()->donor()->firstOrFail();

        abort_unless($bloodRequest->donor_id === $donor->id, 403);
        abort_unless($bloodRequest->status === 'Pending', 422, 'This request is no longer pending.');

        if ($donor->activeSession()->exists()) {
            return back()->withErrors(['session' => 'You already have an active donation session.']);
        }

        if ($donor->availability !== 'Available') {
            return back()->withErrors(['availability' => 'You are not currently available to accept requests.']);
        }

        $session = $this->donationService->acceptRequest($bloodRequest, $donor);

        return redirect()->route('chat.show', $session)->with('success', 'Request accepted. Chat is now open.');
    }

    /** Donor: reject a request. */
    public function reject(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        $donor = $request->user()->donor()->firstOrFail();

        abort_unless($bloodRequest->donor_id === $donor->id, 403);
        abort_unless($bloodRequest->status === 'Pending', 422, 'This request is no longer pending.');

        $this->donationService->rejectRequest($bloodRequest);

        return back()->with('success', 'Request rejected.');
    }
}
