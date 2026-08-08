@extends('layouts.app')
@section('title', 'User Management')

@section('content')
<h4 class="mb-4"><i class="bi bi-people me-2 text-secondary"></i> User Management</h4>

<form class="row g-2 mb-3 align-items-end">
    <div class="col-md-3">
        <label class="form-label small">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, email or phone">
    </div>
    <div class="col-md-2">
        <label class="form-label small">Role</label>
        <select name="role" class="form-select">
            <option value="">All Roles</option>
            @foreach (['Admin', 'Donor', 'Patient'] as $role)
                <option value="{{ $role }}" @selected(request('role') === $role)>{{ $role }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label small">Status</label>
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach (['Active', 'Inactive', 'Suspended', 'Banned'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label small">City</label>
        <input name="city" value="{{ request('city') }}" class="form-control" placeholder="City">
    </div>
    <div class="col-md-1">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th><th>Email</th><th>Role</th><th>Blood Group</th>
                        <th>Status</th><th>Registered</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($user->profile_photo)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo) }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                                    @else
                                        <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                    @endif
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php($badge = match($user->role) { 'Admin'=>'bg-secondary','Donor'=>'bg-danger','Patient'=>'bg-secondary',default=>'bg-secondary' })
                                <span class="badge {{ $badge }}">{{ $user->role }}</span>
                            </td>
                            <td>{{ $user->donor->bloodGroup->name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ match($user->status) { 'Active' => 'bg-success', 'Inactive' => 'bg-secondary', 'Suspended' => 'bg-warning text-dark', 'Banned' => 'bg-danger', default => 'bg-secondary' } }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
