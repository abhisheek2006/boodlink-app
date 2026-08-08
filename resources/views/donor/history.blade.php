@extends('layouts.app')
@section('title', 'Donation History')

@section('content')
<h4 class="mb-4">Donation History</h4>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
    <div class="row text-center">
        <div class="col-md-3 col-6">
            <div class="text-muted small">Total Donations</div>
            <div class="fs-4 fw-bold">{{ $donor->total_donations }}</div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-muted small">Badge</div>
            <div class="fs-5 fw-bold">{{ $donor->current_badge ?? 'No Badge' }}</div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-muted small">Rank</div>
            <div class="fs-5 fw-bold">#{{ $donor->current_rank ?? '-' }}</div>
        </div>
        <div class="col-md-3 col-6">
            <div class="text-muted small">Availability</div>
            <div class="fs-6 fw-bold">{{ $donor->availability }}</div>
        </div>
    </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <table class="table table-hover align-middle mb-0" id="historyTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Blood Group</th>
                <th>Session Duration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sessions as $session)
                <tr>
                    <td>{{ optional($session->ended_at ?? $session->started_at)->toFormattedDateString() }}</td>
                    <td>{{ $session->patient->user->name }}</td>
                    <td>{{ $session->donor->bloodGroup->name ?? '-' }}</td>
                    <td>
                        @if ($session->session_duration)
                            {{ gmdate('i:s', $session->session_duration) }} min
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ match($session->status) { 'Completed' => 'success', 'Active' => 'info', 'Expired' => 'warning', default => 'secondary' } }}">
                            {{ $session->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No donation sessions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $sessions->links() }}</div>
@endsection
