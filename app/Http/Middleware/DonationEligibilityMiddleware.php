<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures a donor has completed their cooldown period and is marked
 * Available before a new donation session can begin (Business Rules 4-6).
 */
class DonationEligibilityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $donor = $request->user()?->donor;

        if (! $donor) {
            abort(403, 'No donor profile found for this account.');
        }

        if ($donor->availability === 'Waiting') {
            $remaining = $donor->remainingCooldownDays();

            return back()->with(
                'error',
                "You are still in your donation cooldown period. Next eligible in {$remaining} day(s)."
            );
        }

        if ($donor->availability !== 'Available') {
            return back()->with('error', 'You are not currently available to accept new requests.');
        }

        return $next($request);
    }
}
