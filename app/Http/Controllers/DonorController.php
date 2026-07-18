<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorController extends Controller
{
    /** Search page for patients (Rule: busy/waiting donors never appear). */
    public function search(Request $request): View
    {
        $query = Donor::query()
            ->with(['user', 'bloodGroup'])
            ->whereHas('user', fn ($q) => $q->where('status', 'Active'))
            ->where('availability', 'Available')
            ->doesntHave('activeSession');

        if ($bloodGroupId = $request->query('blood_group_id')) {
            $query->where('blood_group_id', $bloodGroupId);
        }

        if ($city = $request->query('city')) {
            $query->where('city', 'like', "%{$city}%");
        }

        if ($state = $request->query('state')) {
            $query->where('state', 'like', "%{$state}%");
        }

        // Belt-and-suspenders: exclude anyone still inside cooldown even if
        // a scheduled job hasn't flipped their status back yet.
        $query->where(function ($q) {
            $q->whereNull('next_eligible_date')
                ->orWhereDate('next_eligible_date', '<=', now()->toDateString());
        });

        $donors = $query->paginate(12)->withQueryString();
        $bloodGroups = BloodGroup::where('status', 'Active')->orderBy('name')->get();

        return view('patient.search', compact('donors', 'bloodGroups'));
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
