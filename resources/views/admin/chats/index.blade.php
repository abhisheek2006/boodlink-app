@extends('layouts.app')
@section('title', 'Chat Monitoring')

@section('content')
<h4 class="mb-4">Chat Monitoring</h4>

<form class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search donor or patient name">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach (['Pending', 'Active', 'Completed', 'Expired', 'Cancelled'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-primary w-100">Filter</button>
    </div>
</form>

<div class="card p-3">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>Donor</th>
                <th>Patient</th>
                <th>Status</th>
                <th>Started</th>
                <th>Ended</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sessions as $session)
                <tr>
                    <td>{{ $session->donor?->user?->name ?? '—' }}</td>
                    <td>{{ $session->patient?->user?->name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ match($session->status) { 'Active' => 'info', 'Completed' => 'success', 'Cancelled' => 'secondary', 'Expired' => 'warning', default => 'secondary' } }}">
                            {{ $session->status }}
                        </span>
                    </td>
                    <td>{{ $session->started_at->format('d M Y, h:i A') }}</td>
                    <td>{{ optional($session->ended_at)->format('d M Y, h:i A') ?? '—' }}</td>
                    <td><a href="{{ route('admin.chats.show', $session) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No conversations found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $sessions->links() }}</div>
@endsection
