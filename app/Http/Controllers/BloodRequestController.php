<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donor;
use App\Models\Notification;
use App\Services\AuditLogService;
use App\Services\BloodCompatibilityService;
use App\Services\DonationService;
use App\Services\DonorEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BloodRequestController extends Controller
{
    public function __construct(
        protected DonationService $donationService,
        protected DonorEligibilityService $eligibilityService,
        protected BloodCompatibilityService $compatibilityService,
    ) {}

    /** Patient: request form for a specific donor. */
    public function create(Donor $donor): View
    {
        $donor->load('bloodGroup', 'user');

        return view('patient.request-form', compact('donor'));
    }

    /**
     * Patient: submit a blood request to a chosen donor.
     *
     * Backend re-checks donor eligibility even if the frontend shows them
     * as available. Never trust stale frontend data.
     */
    public function store(Request $request, Donor $donor): RedirectResponse
    {
        $patient = $request->user()->patient()->firstOrFail();

        $eligibility = $this->eligibilityService->checkEligibility($donor);
        if (! $eligibility['eligible']) {
            return back()->withErrors([
                'donor' => $eligibility['reason'],
            ]);
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

        $this->auditLog('Blood Request Created', $bloodRequest, $patient->user_id, [
            'donor_user_id' => $donor->user_id,
            'units' => $data['units_required'],
            'emergency_level' => $data['emergency_level'],
        ]);

        return redirect()->route('patient.requests.index')->with('success', 'Blood request sent.');
    }

    /** Patient: list own requests. */
    public function index(Request $request): View
    {
        $patient = $request->user()->patient()->firstOrFail();

        $requests = $patient->bloodRequests()
            ->with(['donor.user', 'bloodGroup', 'donationSession'])
            ->latest()
            ->paginate(15);

        return view('patient.requests', compact('requests'));
    }

    /** Patient: cancel a still-pending request. */
    public function cancel(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        abort_unless($bloodRequest->patient->user_id === $request->user()->id, 403);
        abort_unless(
            in_array($bloodRequest->status, ['Pending', 'Accepted']),
            422,
            'Only pending or accepted requests can be cancelled.'
        );

        if ($bloodRequest->status === 'Accepted') {
            $this->donationService->endSession($bloodRequest->donationSession);
        }

        $this->donationService->cancelRequest($bloodRequest);

        $this->auditLog('Blood Request Cancelled', $bloodRequest, $request->user()->id, [
            'donor_user_id' => $bloodRequest->donor->user_id,
        ]);

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

    /**
     * Show a single blood request — role-aware rendering.
     * Donors see the donor detail view; patients see the patient detail view.
     */
    public function show(BloodRequest $bloodRequest, Request $request): View
    {
        $user = $request->user();

        $bloodRequest->load([
            'patient.user',
            'donor.user',
            'donor.bloodGroup',
            'donor.user',
            'bloodGroup',
            'donationSession',
            'donationSession.messages',
        ]);

        if ($user->isDonor()) {
            abort_unless($bloodRequest->donor->user_id === $user->id, 403);

            return view('donor.requests.show', ['request' => $bloodRequest]);
        }

        if ($user->isPatient()) {
            abort_unless($bloodRequest->patient->user_id === $user->id, 403);

            return view('patient.requests.show', ['request' => $bloodRequest]);
        }

        abort(403);
    }

    /**
     * Donor: accept a request — starts the session (Rules 1-3).
     *
     * Uses a DB transaction + eligibility re-check to prevent race
     * conditions where two processes try to accept the same request.
     */
    public function accept(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        $donor = $request->user()->donor()->firstOrFail();

        abort_unless($bloodRequest->donor_id === $donor->id, 403, 'This request is not assigned to you.');
        abort_unless($bloodRequest->status === 'Pending', 422, 'This request is no longer pending.');

        // Re-verify eligibility server-side against race conditions.
        $eligibility = $this->eligibilityService->checkEligibility($donor);
        if (! $eligibility['eligible']) {
            return back()->withErrors([
                'eligibility' => $eligibility['reason'],
            ]);
        }

        $session = $this->donationService->acceptRequest($bloodRequest, $donor);

        $this->auditLog('Request Accepted', $bloodRequest, $donor->user_id, [
            'session_id' => $session->id,
        ]);

        return redirect()->route('chat.show', $session)->with('success', 'Request accepted. Chat is now open.');
    }

    /** Donor: reject a request. */
    public function reject(BloodRequest $bloodRequest, Request $request): RedirectResponse
    {
        $donor = $request->user()->donor()->firstOrFail();

        abort_unless($bloodRequest->donor_id === $donor->id, 403);
        abort_unless($bloodRequest->status === 'Pending', 422, 'This request is no longer pending.');

        $this->donationService->rejectRequest($bloodRequest);

        $this->auditLog('Request Rejected', $bloodRequest, $donor->user_id);

        return back()->with('success', 'Request rejected.');
    }

    private function auditLog(string $action, $target, int $userId, array $metadata = []): void
    {
        app(AuditLogService::class)->log(
            $action,
            null,
            $target,
            $userId,
            $metadata
        );
    }

    /** Admin: list all blood requests. */
    public function adminIndex(Request $request): View
    {
        $query = BloodRequest::query()
            ->with(['patient.user', 'donor.user', 'bloodGroup']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($emergency = $request->query('emergency_level')) {
            $query->where('emergency_level', $emergency);
        }

        $requests = $query->latest()->paginate(25)->withQueryString();

        return view('admin.blood-requests', compact('requests'));
    }

    /** Admin: inspect a single blood request. */
    public function adminShow(BloodRequest $bloodRequest): View
    {
        $bloodRequest->load([
            'patient.user',
            'donor.user',
            'bloodGroup',
            'donationSession.messages',
        ]);

        return view('admin.blood-request-detail', compact('bloodRequest'));
    }
}
