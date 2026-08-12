@extends('layouts.app')
@section('title', 'Donations')

@section('content')
<h4 class="mb-4"><i class="bi bi-heart-pulse me-2 text-secondary"></i> Donation Sessions</h4>

<form class="row g-2 mb-3 align-items-end">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach (['Pending', 'Active', 'Completed', 'Expired', 'Cancelled'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
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
                        <th>Donor</th><th>Patient</th><th>Blood Group</th><th>Status</th><th>Started</th><th>Ended</th><th>Duration</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sessions as $s)
                        <tr>
                            <td>{{ $s->donor->user->name ?? '—' }}</td>
                            <td>{{ $s->patient->user->name ?? '—' }}</td>
                            <td>{{ $s->bloodRequest->bloodGroup->name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ match($s->status) { 'Active' => 'bg-info', 'Completed' => 'bg-success', 'Expired' => 'bg-warning text-dark', 'Cancelled' => 'bg-secondary', 'Pending' => 'bg-secondary', default => 'bg-secondary' } }}">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td>{{ $s->started_at?->format('M d, Y') ?? '—' }}</td>
                            <td>{{ $s->ended_at?->format('M d, Y') ?? '—' }}</td>
                            <td>{{ $s->session_duration ? $s->session_duration . 's' : '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.donations.show', $s) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No donation sessions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $sessions->links() }}</div>
@endsection
