<?php

use App\Models\DonationSession;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
| Two private channels drive the real-time features:
|   - user.{userId}          → that user's own notification bell/sound
|   - donation-session.{id}  → the chat for that session (both participants,
|                              plus admins in read-only monitoring mode)
*/

Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    return (int) $user->id === $userId;
});

Broadcast::channel('donation-session.{sessionId}', function (User $user, int $sessionId) {
    $session = DonationSession::with(['donor', 'patient'])->find($sessionId);

    if (! $session) {
        return false;
    }

    if ($user->isAdmin()) {
        return true; // read-only monitoring, enforced in the UI/controller, not here
    }

    return $session->donor->user_id === $user->id || $session->patient->user_id === $user->id;
});
