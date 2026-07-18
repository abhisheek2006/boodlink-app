<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures a donor cannot open a second concurrent donation session
 * (Business Rule 1 / Rule 3).
 */
class SessionActiveMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $donor = $request->user()?->donor;

        if (! $donor) {
            abort(403, 'No donor profile found for this account.');
        }

        if ($donor->activeSession()->exists()) {
            return back()->with(
                'error',
                'You already have an active donation session. Please complete or end it before accepting a new request.'
            );
        }

        return $next($request);
    }
}
