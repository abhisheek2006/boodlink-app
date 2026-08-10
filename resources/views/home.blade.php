@extends('layouts.app')
@section('title', 'Home')

@section('content')
@php
    $topDonors = \App\Models\Donor::with(['user', 'bloodGroup'])->orderByDesc('total_donations')->limit(5)->get();
    $stats = [
        'donors' => \App\Models\Donor::count(),
        'available' => \App\Models\Donor::where('availability', 'Available')->count(),
        'requests' => \App\Models\BloodRequest::count(),
        'completed' => \App\Models\DonationSession::where('status', 'Completed')->count(),
    ];
@endphp

<style>
    .hero-section {
        background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        border: 1px solid var(--bl-line);
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0; right: 0;
        width: 320px; height: 320px;
        background: radial-gradient(circle at top right, rgba(220,38,38,.08), transparent 60%);
        z-index: 0;
    }
    .hero-content { position: relative; z-index: 1; }
    @keyframes draw-hero-pulse { to { stroke-dashoffset: 0; } }
    @media (prefers-reduced-motion: reduce) {
        .hero-pulse path { animation: none !important; stroke-dashoffset: 0 !important; }
    }
</style>

<div class="hero-section rounded-4 p-4 p-md-5 mb-5">
    <div class="row align-items-center g-4 hero-content">
        <div class="col-lg-7">
            <span class="hero-badge mb-3 d-inline-block">Smart Blood Bank</span>
            <h1 class="display-headline fw-bold mb-4" style="font-size: clamp(2.2rem, 5vw, 3.2rem); line-height: 1.05;">
                A steady pulse between<br>those who give and those who wait.
            </h1>
            <p class="fs-5 mb-4" style="color: var(--bl-slate); max-width: 46ch;">
                Blood Link matches patients with eligible, willing donors nearby —
                privately, quickly, and without a single detail shared until the donor chooses.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Become a Donor</a>
                <a href="{{ auth()->check() ? route('patient.search') : route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Find a Donor</a>
            </div>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-end">
            <svg class="hero-pulse w-100" viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M0 90 H90 L110 30 L145 140 L175 60 L195 90 H400"
                      fill="none" stroke="var(--bl-primary)" stroke-width="3.5"
                      stroke-linecap="round" stroke-linejoin="round"
                      style="stroke-dasharray: 620; stroke-dashoffset: 620; animation: draw-hero-pulse 1.8s ease-out .2s forwards;" />
            </svg>
        </div>
    </div>
</div>

<!-- Stats row -->
<div class="row g-3 mb-5">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--bl-primary);">{{ $stats['donors'] }}</div>
            <div class="stat-label">Registered Donors</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--bl-success);">{{ $stats['available'] }}</div>
            <div class="stat-label">Available Now</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['requests'] }}</div>
            <div class="stat-label">Blood Requests</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="stat-value" style="color: var(--bl-info);">{{ $stats['completed'] }}</div>
            <div class="stat-label">Successful Donations</div>
        </div>
    </div>
</div>

<!-- Info cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card p-4 h-100 border-0 shadow-sm">
            <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-droplet-half fs-3" style="color: var(--bl-primary);"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-2">Why donate blood?</h5>
                    <p class="mb-0" style="color: var(--bl-slate);">One donation can support up to three people. Blood can't be manufactured — it only comes from someone who chooses to give it.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 h-100 border-0 shadow-sm">
            <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="rounded-circle bg-secondary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-shield-lock fs-3" style="color: var(--bl-secondary);"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-2">Your privacy comes first</h5>
                    <p class="mb-0" style="color: var(--bl-slate);">Your phone, email, and address stay hidden until you personally choose to share them with the person you're helping.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.pulse-divider')

<!-- Top Donors -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-transparent">
        <h5 class="mb-0"><i class="bi bi-trophy me-2" style="color: var(--bl-gold);"></i> Top Donors</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach ($topDonors as $donor)
                @php
                    $badges = ['Bronze Donor' => 'badge-bronze', 'Silver Donor' => 'badge-silver', 'Gold Donor' => 'badge-gold', 'Platinum Donor' => 'badge-platinum'];
                    $badgeClass = $badges[$donor->current_badge ?? 'No Badge'] ?? 'bg-secondary';
                @endphp
                <div class="col-md-2 col-4 text-center">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                         style="width:72px;height:72px; background: rgba(var(--bl-ink-rgb), .05);">
                        @if ($donor->user->profile_photo)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($donor->user->profile_photo) }}" alt="{{ $donor->user->name }}" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
                        @else
                            <i class="bi bi-person-fill fs-2" style="color: var(--bl-slate);"></i>
                        @endif
                    </div>
                    <div class="fw-semibold small">{{ $donor->user->name }}</div>
                    <span class="badge bg-danger mb-1">{{ $donor->bloodGroup->name }}</span>
                    @if ($donor->current_badge)
                        <span class="badge {{ $badgeClass }} mb-1">{{ $donor->current_badge }}</span>
                    @endif
                    <div class="small" style="color: var(--bl-slate);">{{ $donor->total_donations }} donations</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
