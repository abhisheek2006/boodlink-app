<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\DonationSession;
use App\Models\Donor;
use App\Support\DateExpr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function bloodGroupDistribution(): JsonResponse
    {
        $data = DB::table('donors')
            ->join('blood_groups', 'donors.blood_group_id', '=', 'blood_groups.id')
            ->selectRaw('blood_groups.name as label, COUNT(*) as value')
            ->groupBy('blood_groups.name')
            ->get();

        return response()->json($data);
    }

    public function monthlyDonations(): JsonResponse
    {
        $month = DateExpr::month('ended_at');

        $data = DonationSession::where('status', 'Completed')
            ->whereNotNull('ended_at')
            ->selectRaw("{$month} as label, COUNT(*) as value")
            ->groupByRaw($month)
            ->orderBy('label')
            ->get();

        return response()->json($data);
    }

    public function monthlyRequests(): JsonResponse
    {
        $month = DateExpr::month('created_at');

        $data = BloodRequest::selectRaw("{$month} as label, COUNT(*) as value")
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return response()->json($data);
    }

    public function availabilityBreakdown(): JsonResponse
    {
        $data = Donor::selectRaw('availability as label, COUNT(*) as value')
            ->groupBy('availability')
            ->get();

        return response()->json($data);
    }

    public function topCities(): JsonResponse
    {
        $data = Donor::selectRaw('city as label, COUNT(*) as value')
            ->groupBy('city')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}
