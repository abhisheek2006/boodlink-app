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

<div class="hero-section rounded-4 p-4 p-md-5 mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <div class="text-uppercase small fw-semibold mb-2" style="color: var(--bl-primary); letter-spacing: .08em;">
                Smart Blood Bank
            </div>
            <h1 class="display-headline fw-semibold mb-3" style="font-size: clamp(2.1rem, 4vw, 3.1rem); line-height: 1.08;">
                A steady pulse between<br>those who give and those who wait.
            </h1>
            <p class="fs-5 mb-4" style="color: var(--bl-slate); max-width: 46ch;">
                Blood Link matches patients with eligible, willing donors nearby —
                privately, quickly, and without a single detail shared until the donor chooses to.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Become a Donor</a>
                <a href="{{ auth()->check() ? route('patient.search') : route('register') }}" class="btn btn-outline-dark btn-lg px-4">Find a Donor</a>
            </div>
        </div>
        <div class="col-lg-5">
            <svg class="hero-pulse w-100" viewBox="0 0 400 160" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M0 90 H90 L110 30 L145 140 L175 60 L195 90 H400"
                      fill="none" stroke="var(--bl-primary)" stroke-width="3.5"
                      stroke-linecap="round" stroke-linejoin="round"
                      style="stroke-dasharray: 620; stroke-dashoffset: 620; animation: draw-hero-pulse 1.8s ease-out .2s forwards;" />
            </svg>
        </div>
    </div>
</div>

<style>
    .hero-section { background: var(--bl-surface); border: 1px solid var(--bl-line); }
    @keyframes draw-hero-pulse { to { stroke-dashoffset: 0; } }
    @media (prefers-reduced-motion: reduce) {
        .hero-pulse path { animation: none !important; stroke-dashoffset: 0 !important; }
    }
</style>

<div class="row g-3 mb-5">
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <div class="font-mono fs-3 fw-semibold" style="color: var(--bl-primary);">{{ $stats['donors'] }}</div>
            <small style="color: var(--bl-slate);">Registered Donors</small>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <div class="font-mono fs-3 fw-semibold" style="color: var(--bl-pulse);">{{ $stats['available'] }}</div>
            <small style="color: var(--bl-slate);">Available Right Now</small>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <div class="font-mono fs-3 fw-semibold">{{ $stats['requests'] }}</div>
            <small style="color: var(--bl-slate);">Blood Requests</small>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card p-3 text-center">
            <div class="font-mono fs-3 fw-semibold" style="color: var(--bl-gold);">{{ $stats['completed'] }}</div>
            <small style="color: var(--bl-slate);">Successful Donations</small>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="mb-2"><i class="bi bi-droplet-half" style="color: var(--bl-primary);"></i> Why donate blood?</h5>
            <p class="mb-0" style="color: var(--bl-slate);">One donation can support up to three people. Blood can't be manufactured — it only comes from someone who chooses to give it.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <h5 class="mb-2"><i class="bi bi-shield-lock" style="color: var(--bl-primary);"></i> Your privacy comes first</h5>
            <p class="mb-0" style="color: var(--bl-slate);">Your phone, email, and address stay hidden until you personally choose to share them with the person you're helping.</p>
        </div>
    </div>
</div>

@include('partials.pulse-divider')

<div class="card p-4 mt-4">
    <h5 class="mb-3"><i class="bi bi-trophy" style="color: var(--bl-gold);"></i> Top Donors</h5>
    <div class="row g-3">
        @foreach ($topDonors as $donor)
            <div class="col-md-2 col-4 text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:64px;height:64px; background: rgba(var(--bl-ink-rgb), .05);">
                    <i class="bi bi-person-fill fs-3" style="color: var(--bl-slate);"></i>
                </div>
                <div class="fw-semibold small">{{ $donor->user->name }}</div>
                <span class="badge" style="background: var(--bl-primary);">{{ $donor->bloodGroup->name }}</span>
                <div class="small" style="color: var(--bl-slate);">{{ $donor->total_donations }} donations</div>
            </div>
        @endforeach
    </div>
</div>
@endsection
