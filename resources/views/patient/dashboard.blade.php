@extends('layouts.app')
@section('title', 'Patient Dashboard')

@section('content')
@php
    $requests = $patient->bloodRequests();
    $counts = [
        'My Requests' => (clone $requests)->count(),
        'Pending' => (clone $requests)->where('status', 'Pending')->count(),
        'Accepted' => (clone $requests)->where('status', 'Accepted')->count(),
        'Completed' => (clone $requests)->where('status', 'Completed')->count(),
    ];
    $activeSession = $patient->donationSessions()->where('status', 'Active')->with('donor.user')->first();
@endphp

<h4 class="mb-4">Welcome, {{ $patient->user->name }}</h4>

<div class="row g-3 mb-4">
    @foreach ($counts as $label => $value)
        <div class="col-md-3 col-6">
            <div class="stat-card h-100">
                <div class="stat-value">{{ $value }}</div>
                <div class="stat-label">{{ $label }}</div>
            </div>
        </div>
    @endforeach
</div>

@if ($activeSession)
    <div class="card border-0 shadow-sm mb-4 border-info">
        <div class="card-body">
            <h6 class="mb-2"><i class="bi bi-chat-dots"></i> Active Chat</h6>
            <p class="mb-2">Donor: <strong>{{ $activeSession->donor->user->name }}</strong></p>
            <a href="{{ route('chat.show', $activeSession) }}" class="btn btn-primary btn-sm">Open Chat</a>
        </div>
    </div>
@endif

@if ($activeSession)
@else
    <div class="alert alert-info border-0 mb-4">
        <i class="bi bi-info-circle me-2"></i> No active donation session. Search for donors to get started.
    </div>
@endif

<div class="d-flex flex-wrap gap-2">
    <a href="{{ route('patient.search') }}" class="btn btn-primary btn-sm">Search Donors</a>
    <a href="{{ route('patient.requests.index') }}" class="btn btn-outline-secondary btn-sm">Request History</a>
    <a href="{{ route('leaderboard') }}" class="btn btn-outline-secondary btn-sm">Leaderboard</a>
</div>
@endsection
