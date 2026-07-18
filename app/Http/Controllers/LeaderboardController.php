<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $donors = Donor::with(['user', 'bloodGroup'])
            ->where('total_donations', '>', 0)
            ->orderByDesc('total_donations')
            ->paginate(25);

        return view('leaderboard.index', compact('donors'));
    }
}
