@extends('layouts.app')
@section('title', $user->name)

@section('content')
<a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <div class="text-muted">{{ $user->role }} &middot; {{ $user->email }}</div>
                </div>
                <span class="badge bg-{{ match($user->status) { 'Active' => 'success', 'Inactive' => 'secondary', 'Suspended' => 'warning', 'Banned' => 'danger', default => 'secondary' } }} fs-6">
                    {{ $user->status }}
                </span>
            </div>

            <div class="row g-3">
                <div class="col-md-6"><div class="text-muted small">Phone</div><div>{{ $user->phone }}</div></div>
                <div class="col-md-6"><div class="text-muted small">Gender</div><div>{{ $user->gender }}</div></div>
                <div class="col-md-6"><div class="text-muted small">Date of Birth</div><div>{{ optional($user->dob)->toFormattedDateString() }}</div></div>
                <div class="col-md-6"><div class="text-muted small">Last Login</div><div>{{ optional($user->last_login_at)->diffForHumans() ?? '—' }}</div></div>

                @if ($user->donor)
                    <div class="col-md-6"><div class="text-muted small">Blood Group</div><div>{{ $user->donor->bloodGroup->name ?? '—' }}</div></div>
                    <div class="col-md-6"><div class="text-muted small">Total Donations</div><div>{{ $user->donor->total_donations }} &middot; {{ $user->donor->current_badge ?? 'No Badge' }}</div></div>
                    <div class="col-md-6"><div class="text-muted small">Availability</div><div>{{ $user->donor->availability }}</div></div>
                    <div class="col-md-6"><div class="text-muted small">Next Eligible</div><div>{{ optional($user->donor->next_eligible_date)->toFormattedDateString() ?? '—' }}</div></div>
                @endif

                @if ($user->patient)
                    <div class="col-md-6"><div class="text-muted small">Emergency Contact</div><div>{{ $user->patient->emergency_contact }}</div></div>
                    <div class="col-md-6"><div class="text-muted small">Required Blood Group</div><div>{{ $user->patient->requiredBloodGroup->name ?? '—' }}</div></div>
                @endif
            </div>
        </div>

        <div class="card p-4">
            <h6 class="mb-3">Moderation History</h6>
            <table class="table table-sm mb-0">
                <thead><tr><th>Action</th><th>By</th><th>Reason</th><th>Date</th></tr></thead>
                <tbody>
                    @forelse ($user->moderationLogs as $log)
                        <tr>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->admin->name ?? '—' }}</td>
                            <td>{{ $log->reason ?? '—' }}</td>
                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">No moderation actions recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="mb-3">Admin Actions</h6>
            <div class="d-grid gap-2">
                @if ($user->status !== 'Active')
                    <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-success w-100">Activate</button>
                    </form>
                @endif

                @if ($user->status === 'Active')
                    <form action="{{ route('admin.users.deactivate', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-secondary w-100">Deactivate</button>
                    </form>
                @endif

                @if ($user->status === 'Suspended')
                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-warning w-100">Remove Suspension</button>
                    </form>
                @else
                    <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#suspendModal">Suspend</button>
                @endif

                @if ($user->status === 'Banned')
                    <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger w-100">Unban</button>
                    </form>
                @else
                    <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#banModal">Ban</button>
                @endif

                <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" onsubmit="return confirm('Reset this user\'s password?');">
                    @csrf
                    <button class="btn btn-outline-primary w-100">Reset Password</button>
                </form>

                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Permanently delete this user?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-dark w-100">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="suspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header"><h5 class="modal-title">Suspend {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">Duration (days, optional — leave blank for indefinite)</label>
                    <input type="number" name="duration_days" min="1" class="form-control mb-2">
                    <label class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
                <div class="modal-footer"><button class="btn btn-warning">Suspend</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="banModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header"><h5 class="modal-title">Ban {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
                <div class="modal-footer"><button class="btn btn-danger">Ban</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
