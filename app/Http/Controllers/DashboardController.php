<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /** Generic entry point; sends the user to their role-specific dashboard. */
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route($request->user()->dashboardRoute());
    }

    public function admin(Request $request): View
    {
        return view('admin.dashboard');
    }

    public function donor(Request $request): View
    {
        $donor = $request->user()->donor()->with('bloodGroup')->firstOrFail();

        return view('donor.dashboard', ['donor' => $donor]);
    }

    public function patient(Request $request): View
    {
        $patient = $request->user()->patient()->with('requiredBloodGroup')->firstOrFail();

        return view('patient.dashboard', ['patient' => $patient]);
    }
}
