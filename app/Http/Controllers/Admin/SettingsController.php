<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /** Display the settings page with current config values. */
    public function index(): View
    {
        $settings = [
            'session_timeout_minutes' => config('blood.session_timeout_minutes', 30),
            'minimum_age_donate' => config('blood.minimum_age_donate', 18),
            'maximum_age_donate' => config('blood.maximum_age_donate', 65),
            'minimum_weight' => config('blood.minimum_weight', 50),
            'deferral_male_days' => config('blood.donation_deferral.whole_blood.male_days', 90),
            'deferral_female_days' => config('blood.donation_deferral.whole_blood.female_days', 120),
            'deferral_other_days' => config('blood.donation_deferral.whole_blood.other_days', 90),
            'shareable_session_statuses' => config('blood.shareable_session_statuses', ['Active', 'Completed']),
        ];

        return view('admin.settings', ['settings' => $settings]);
    }

    /** Persist updated settings to the environment / config cache. */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'session_timeout_minutes' => ['required', 'integer', 'min:5', 'max:300'],
            'minimum_age_donate' => ['required', 'integer', 'min:16', 'max:80'],
            'maximum_age_donate' => ['required', 'integer', 'min:18', 'max:100'],
            'minimum_weight' => ['required', 'numeric', 'min:30', 'max:200'],
            'deferral_male_days' => ['required', 'integer', 'min:0', 'max:365'],
            'deferral_female_days' => ['required', 'integer', 'min:0', 'max:365'],
            'deferral_other_days' => ['required', 'integer', 'min:0', 'max:365'],
            'shareable_session_statuses' => ['required', 'array'],
            'shareable_session_statuses.*' => ['in:Pending,Active,Completed,Expired,Cancelled'],
        ]);

        // In production you'd persist these to a settings table or .env file.
        // Here we write to the config cache so changes take effect immediately
        // until the application is restarted.
        $config = [
            'donation_deferral' => [
                'whole_blood' => [
                    'male_days' => $data['deferral_male_days'],
                    'female_days' => $data['deferral_female_days'],
                    'other_days' => $data['deferral_other_days'],
                ],
            ],
        ];

        config([
            'blood.session_timeout_minutes' => $data['session_timeout_minutes'],
            'blood.minimum_age_donate' => $data['minimum_age_donate'],
            'blood.maximum_age_donate' => $data['maximum_age_donate'],
            'blood.minimum_weight' => $data['minimum_weight'],
            'blood.donation_deferral.whole_blood' => $config['donation_deferral']['whole_blood'],
            'blood.shareable_session_statuses' => $data['shareable_session_statuses'],
        ]);

        return back()->with('success', 'Settings updated successfully.');
    }

    /** Clear all caches (config, route, view, compiled) for the admin. */
    public function clearCache(Request $request): RedirectResponse
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return back()->with('success', 'All caches have been cleared.');
    }
}
