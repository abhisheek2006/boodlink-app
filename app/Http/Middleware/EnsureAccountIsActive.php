<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applied to all authenticated routes. Immediately forces logout for
 * banned users, and for suspended users whose suspension is still active.
 */
class EnsureAccountIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ($user->isBanned() || $user->isSuspended())) {
            $reason = $user->isBanned()
                ? ('Your account has been banned. ' . ($user->ban_reason ?? ''))
                : ('Your account is suspended. ' . ($user->suspension_reason ?? ''));

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', trim($reason));
        }

        return $next($request);
    }
}
