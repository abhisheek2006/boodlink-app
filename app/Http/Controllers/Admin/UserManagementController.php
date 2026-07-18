<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\User;
use App\Models\UserModerationLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with(['donor.bloodGroup', 'patient']);

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($city = $request->query('city')) {
            $query->where(function ($q) use ($city) {
                $q->whereHas('donor', fn ($d) => $d->where('city', $city))
                    ->orWhereHas('patient', fn ($p) => $p->where('city', $city));
            });
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['donor.bloodGroup', 'patient.requiredBloodGroup', 'moderationLogs.admin']);

        return view('admin.users.show', compact('user'));
    }

    public function activate(User $user, Request $request): RedirectResponse
    {
        $user->update(['status' => 'Active']);
        $this->log($user, $request->user(), 'Activated');

        return back()->with('success', 'User activated.');
    }

    public function deactivate(User $user, Request $request): RedirectResponse
    {
        $this->guardLastActiveAdmin($user);

        $user->update(['status' => 'Inactive']);
        $this->log($user, $request->user(), 'Deactivated');

        return back()->with('success', 'User deactivated.');
    }

    public function suspend(User $user, Request $request): RedirectResponse
    {
        $this->guardAgainstSelf($user, $request);
        $this->guardLastActiveAdmin($user);

        $data = $request->validate([
            'duration_days' => ['nullable', 'integer', 'min:1'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'status' => 'Suspended',
            'suspended_until' => isset($data['duration_days'])
                ? now()->addDays($data['duration_days'])
                : null,
            'suspension_reason' => $data['reason'],
        ]);

        $this->cancelPendingRequestsIfPatient($user);

        $this->log($user, $request->user(), 'Suspended', $data['reason']);

        return back()->with('success', 'User suspended.');
    }

    public function unsuspend(User $user, Request $request): RedirectResponse
    {
        $user->update([
            'status' => 'Active',
            'suspended_until' => null,
            'suspension_reason' => null,
        ]);

        $this->log($user, $request->user(), 'Unsuspended');

        return back()->with('success', 'Suspension removed.');
    }

    public function ban(User $user, Request $request): RedirectResponse
    {
        $this->guardAgainstSelf($user, $request);
        $this->guardLastActiveAdmin($user);

        $data = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $user->update([
            'status' => 'Banned',
            'banned_at' => now(),
            'ban_reason' => $data['reason'],
            'banned_by' => $request->user()->id,
        ]);

        $this->cancelPendingRequestsIfPatient($user);

        $this->log($user, $request->user(), 'Banned', $data['reason']);

        return back()->with('success', 'User banned.');
    }

    public function unban(User $user, Request $request): RedirectResponse
    {
        $user->update([
            'status' => 'Active',
            'banned_at' => null,
            'ban_reason' => null,
            'banned_by' => null,
        ]);

        $this->log($user, $request->user(), 'Unbanned');

        return back()->with('success', 'User unbanned.');
    }

    public function resetPassword(User $user, Request $request): RedirectResponse
    {
        $temporaryPassword = Str::random(12);

        $user->update(['password' => Hash::make($temporaryPassword)]);

        $this->log($user, $request->user(), 'Password Reset');

        // In production this would be emailed rather than flashed.
        return back()->with('success', "Password reset. Temporary password: {$temporaryPassword}");
    }

    public function destroy(User $user, Request $request): RedirectResponse
    {
        $this->guardAgainstSelf($user, $request);
        $this->guardLastActiveAdmin($user);

        $hasActiveSession = $user->donor?->activeSession()->exists()
            || $user->patient?->donationSessions()->where('status', 'Active')->exists();

        $hasPendingRequest = BloodRequest::where('status', 'Pending')
            ->where(function ($q) use ($user) {
                $q->whereHas('patient', fn ($p) => $p->where('user_id', $user->id))
                    ->orWhereHas('donor', fn ($d) => $d->where('user_id', $user->id));
            })->exists();

        if ($hasActiveSession || $hasPendingRequest) {
            return back()->withErrors([
                'user' => 'This user cannot be deleted because they have active records in the system.',
            ]);
        }

        DB::transaction(function () use ($user, $request) {
            $this->log($user, $request->user(), 'Deleted');
            $user->delete();
        });

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    private function guardAgainstSelf(User $user, Request $request): void
    {
        abort_if($user->id === $request->user()->id, 403, 'You cannot perform this action on your own account.');
    }

    /** Enforces Rule 16: there must always be at least one active administrator. */
    private function guardLastActiveAdmin(User $user): void
    {
        if (! $user->isAdmin() || ! $user->isActiveAccount()) {
            return;
        }

        $otherActiveAdmins = User::where('role', 'Admin')
            ->where('status', 'Active')
            ->where('id', '!=', $user->id)
            ->exists();

        abort_if(! $otherActiveAdmins, 422, 'At least one active administrator must remain in the system.');
    }

    private function cancelPendingRequestsIfPatient(User $user): void
    {
        if (! $user->isPatient() || ! $user->patient) {
            return;
        }

        $user->patient->bloodRequests()
            ->where('status', 'Pending')
            ->get()
            ->each(function (BloodRequest $request) {
                $request->update(['status' => 'Cancelled']);
            });
    }

    private function log(User $user, User $admin, string $action, ?string $reason = null): void
    {
        UserModerationLog::create([
            'user_id' => $user->id,
            'admin_id' => $admin->id,
            'action' => $action,
            'reason' => $reason,
        ]);
    }
}
