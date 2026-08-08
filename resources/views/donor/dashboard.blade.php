@extends('layouts.app')
@section('title', 'Donor Dashboard')

@section('content')
@php $activeSession = $donor->activeSession()->with('patient.user')->first(); @endphp

<h4 class="mb-4">Welcome, {{ $donor->user->name }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card h-100">
            <div class="stat-value" style="color: var(--bl-primary);">{{ $donor->bloodGroup->name }}</div>
            <div class="stat-label">Blood Group</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card h-100">
            <div class="stat-value" style="font-size: 1.4rem;">
                <span class="badge {{ $donor->availability === 'Available' ? 'bg-success' : ($donor->availability === 'Busy' ? 'bg-danger' : 'bg-warning text-dark') }}">
                    {{ $donor->availability }}
                </span>
            </div>
            <div class="stat-label">Status</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card h-100">
            <div class="stat-value">{{ $donor->total_donations }}</div>
            <div class="stat-label">Total Donations</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card h-100">
            <div class="stat-value" style="font-size: 1.1rem;">{{ $donor->current_badge ?? 'No Badge' }} &middot; #{{ $donor->current_rank ?? '-' }}</div>
            <div class="stat-label">Badge / Rank</div>
        </div>
    </div>
</div>

@if ($donor->availability === 'Waiting')
    <div class="alert alert-warning border-0 mb-4">
        Last Donation: {{ optional($donor->last_donation_date)->toFormattedDateString() }} —
        Next Eligible: {{ optional($donor->next_eligible_date)->toFormattedDateString() }}
        ({{ $donor->remainingCooldownDays() }} day(s) remaining)
    </div>
@endif

@if ($activeSession)
    <div class="card border-0 shadow-sm mb-4 border-danger">
        <div class="card-body">
            <h6 class="mb-2"><i class="bi bi-chat-dots"></i> Active Donation Session</h6>
            <p class="mb-2">Patient: <strong>{{ $activeSession->patient->user->name }}</strong> &middot; expires {{ $activeSession->expires_at->diffForHumans() }}</p>
            <a href="{{ route('chat.show', $activeSession) }}" class="btn btn-primary btn-sm">Open Chat</a>
        </div>
    </div>
@endif

<div class="d-flex flex-wrap gap-2">
    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
    <a href="{{ route('donor.requests.index') }}" class="btn btn-outline-secondary btn-sm">View Requests</a>
    <a href="{{ route('donor.history') }}" class="btn btn-outline-secondary btn-sm">Donation History</a>
    <a href="{{ route('leaderboard') }}" class="btn btn-outline-secondary btn-sm">Leaderboard</a>
</div>
@endsection
