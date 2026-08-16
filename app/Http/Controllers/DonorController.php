<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Donor;
use App\Services\BloodCompatibilityService;
use App\Services\DonorEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Rule;
use Illuminate\View\View;

class DonorController extends Controller
{
    public function __construct(
        protected BloodCompatibilityService $compatibilityService,
        protected DonorEligibilityService $eligibilityService,
    ) {}

    /**
     * Search page for patients.
     *
     * Uses the central eligibility service (via isSearchable) and the
     * blood compatibility service to find donors whose blood type is
     * compatible with the patient's required blood group.
     */
    public function search(Request $request): View
    {
        $bloodGroupId = $request->query('blood_group_id');
        $recipientGroupName = null;

        if ($bloodGroupId) {
            $recipientGroup = BloodGroup::findOrFail($bloodGroupId);
            $recipientGroupName = $recipientGroup->name;
        }

        $query = Donor::query()
            ->with(['user', 'bloodGroup'])
            ->whereHas('user', fn ($q) => $q->where('status', 'Active'))
            ->whereHas('user', fn ($q) => $q->whereNotNull('dob')
                ->whereDate('dob', '<=', now()->subYears($this->eligibilityService->minimumAge())->toDateString())
                ->whereDate('dob', '>', now()->subYears($this->eligibilityService->maximumAge() + 1)->toDateString()))
            ->doesntHave('activeSession')
            ->where(function ($q) {
                $q->whereNull('next_eligible_date')
                    ->orWhereDate('next_eligible_date', '<=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('eligible_again_at')
                    ->orWhereDate('eligible_again_at', '<=', now()->toDateString());
            })
            ->where('medical_review_required', false);

        // Filter by compatible blood groups (not just exact match).
        if ($recipientGroupName) {
            $compatibleNames = $this->compatibilityService->compatibleDonors($recipientGroupName);

            if (empty($compatibleNames)) {
                $donors = collect();
            } else {
                $query->whereHas('bloodGroup', function ($q) use ($compatibleNames) {
                    $q->whereIn('name', $compatibleNames)
                        ->where('status', 'Active');
                });
            }
        }

        if ($city = $request->query('city')) {
            $query->where('city', 'like', "%{$city}%");
        }

        if ($state = $request->query('state')) {
            $query->where('state', 'like', "%{$state}%");
        }

        // Secondary availability filter — the eligibility service is the
        // authoritative check, but we pre-filter here for performance.
        $query->where('availability', '!=', 'Busy')
            ->where('availability', '!=', 'Deferred');

        if (isset($donors)) {
            // Empty collection from incompatible blood group
        } else {
            $donors = $query->paginate(12)->withQueryString();
        }

        $bloodGroups = BloodGroup::where('status', 'Active')->orderBy('name')->get();

        // Apply the eligibility check as a final filter on paginator results.
        if ($donors instanceof LengthAwarePaginator) {
            $filtered = $donors->getCollection()
                ->filter(fn ($d) => $this->eligibilityService->canReceiveBloodRequest($d));

            $donors = $donors->setCollection($filtered);
        }

        return view('patient.search', compact('donors', 'bloodGroups'));
    }

    /**
     * Donor: toggle own availability status (Available, Busy, Away etc.)
     * Stored in the donor profile so the search query filters it in real time.
     */
    public function updateAvailability(Request $request): RedirectResponse
    {
        $donor = $request->user()->donor()->firstOrFail();

        $request->validate([
            'availability' => ['required', Rule::in(['Available', 'Unavailable', 'Busy', 'Away'])],
        ]);

        $donor->update([
            'availability' => $request->input('availability'),
            'available_at' => now(),
        ]);

        return back()->with('success', 'Availability updated.');
    }

    public function history(Request $request): View
    {
        $donor = $request->user()->donor()->firstOrFail();

        $sessions = $donor->donationSessions()
            ->with('patient.user')
            ->latest('started_at')
            ->paginate(15);

        return view('donor.history', compact('sessions', 'donor'));
    }
}
