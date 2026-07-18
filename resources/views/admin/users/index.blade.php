@extends('layouts.app')
@section('title', 'User Management')

@section('content')
<h4 class="mb-4"><i class="bi bi-people"></i> User Management</h4>

<form class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, email or phone">
    </div>
    <div class="col-md-2">
        <select name="role" class="form-select">
            <option value="">All Roles</option>
            @foreach (['Admin', 'Donor', 'Patient'] as $role)
                <option value="{{ $role }}" @selected(request('role') === $role)>{{ $role }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach (['Active', 'Inactive', 'Suspended', 'Banned'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
</form>

<div class="card p-3">
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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->donor->bloodGroup->name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ match($user->status) { 'Active' => 'success', 'Inactive' => 'secondary', 'Suspended' => 'warning', 'Banned' => 'danger', default => 'secondary' } }}">
                            {{ $user->status }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
