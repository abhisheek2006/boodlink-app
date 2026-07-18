@extends('layouts.app')
@section('title', 'Donor Dashboard')

@section('content')
@php $activeSession = $donor->activeSession()->with('patient.user')->first(); @endphp

<h4 class="mb-4">Welcome, {{ $donor->user->name }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card p-3">
            <div class="text-muted small">Blood Group</div>
            <div class="fs-4 fw-bold">{{ $donor->bloodGroup->name }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3">
            <div class="text-muted small">Status</div>
            <div class="fs-5 fw-bold">
                <span class="badge {{ $donor->availability === 'Available' ? 'bg-success' : ($donor->availability === 'Busy' ? 'bg-danger' : 'bg-warning text-dark') }}">
                    {{ $donor->availability }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3">
            <div class="text-muted small">Total Donations</div>
            <div class="fs-4 fw-bold">{{ $donor->total_donations }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3">
            <div class="text-muted small">Badge / Rank</div>
            <div class="fs-6 fw-bold">{{ $donor->current_badge ?? 'No Badge' }} &middot; #{{ $donor->current_rank ?? '-' }}</div>
        </div>
    </div>
</div>

@if ($donor->availability === 'Waiting')
    <div class="alert alert-warning">
        Last Donation: {{ optional($donor->last_donation_date)->toFormattedDateString() }} —
        Next Eligible: {{ optional($donor->next_eligible_date)->toFormattedDateString() }}
        ({{ $donor->remainingCooldownDays() }} day(s) remaining)
    </div>
@endif

@if ($activeSession)
    <div class="card p-3 mb-4 border-danger">
        <h6><i class="bi bi-chat-dots"></i> Active Donation Session</h6>
        <p class="mb-2">Patient: <strong>{{ $activeSession->patient->user->name }}</strong> &middot; expires {{ $activeSession->expires_at->diffForHumans() }}</p>
        <a href="{{ route('chat.show', $activeSession) }}" class="btn btn-primary btn-sm">Open Chat</a>
    </div>
@endif

<div class="d-flex flex-wrap gap-2">
    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
    <a href="{{ route('donor.requests.index') }}" class="btn btn-outline-secondary btn-sm">View Requests</a>
    <a href="{{ route('donor.history') }}" class="btn btn-outline-secondary btn-sm">Donation History</a>
    <a href="{{ route('leaderboard') }}" class="btn btn-outline-secondary btn-sm">Leaderboard</a>
</div>
@endsection
