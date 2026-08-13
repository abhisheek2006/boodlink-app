@extends('layouts.app')
@section('title', 'Home')

@section('content')

@php
    $topDonors = \App\Models\Donor::with(['user', 'bloodGroup'])
        ->orderByDesc('total_donations')
        ->limit(5)
        ->get();

    $stats = [
        'donors' => \App\Models\Donor::count(),
        'available' => \App\Models\Donor::where('availability', 'Available')->count(),
        'requests' => \App\Models\BloodRequest::count(),
        'completed' => \App\Models\DonationSession::where('status', 'Completed')->count(),
    ];
@endphp

<style>
    /* =========================
       HOME PAGE
    ========================= */

    .home-page {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* =========================
       HERO
    ========================= */

    .home-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        min-height: 430px;
        padding: 55px;
        background:
            radial-gradient(
                circle at 90% 15%,
                rgba(220, 38, 38, .10),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #ffffff 0%,
                #fffafa 55%,
                #f8fafc 100%
            );
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 35px rgba(15, 23, 42, .05);
    }

    .home-hero::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        right: -100px;
        bottom: -140px;
        border-radius: 50%;
        background: rgba(220, 38, 38, .035);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 30px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .hero-title {
        max-width: 690px;
        color: #172033;
        font-size: clamp(2.4rem, 5vw, 4.3rem);
        line-height: 1.02;
        font-weight: 800;
        letter-spacing: -0.045em;
        margin-bottom: 22px;
    }

    .hero-title span {
        color: #dc2626;
    }

    .hero-description {
        max-width: 580px;
        color: #64748b;
        font-size: 16px;
        line-height: 1.75;
        margin-bottom: 28px;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .hero-primary-btn {
        border-radius: 10px;
        padding: 11px 20px;
        font-size: 13px;
        font-weight: 700;
        background: #dc2626;
        border-color: #dc2626;
    }

    .hero-primary-btn:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    .hero-secondary-btn {
        border-radius: 10px;
        padding: 11px 20px;
        font-size: 13px;
        font-weight: 600;
        background: #fff;
    }

    /* Hero graphic */

    .hero-visual {
        position: relative;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .heart-orbit {
        position: relative;
        width: 245px;
        height: 245px;
        border: 1px solid #fecaca;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .heart-orbit::before,
    .heart-orbit::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        border: 1px solid #fee2e2;
    }

    .heart-orbit::before {
        width: 190px;
        height: 190px;
    }

    .heart-orbit::after {
        width: 285px;
        height: 285px;
        opacity: .6;
    }

    .hero-heart {
        width: 125px;
        height: 125px;
        border-radius: 35px;
        background: linear-gradient(145deg, #dc2626, #ef4444);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        box-shadow:
            0 20px 45px rgba(220, 38, 38, .25);
        transform: rotate(-5deg);
        z-index: 2;
    }

    .floating-card {
        position: absolute;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 13px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        z-index: 4;
    }

    .floating-card small {
        display: block;
        color: #94a3b8;
        font-size: 9px;
        margin-bottom: 2px;
    }

    .floating-card strong {
        font-size: 12px;
        color: #334155;
    }

    .floating-card.available {
        top: 18px;
        right: 5px;
    }

    .floating-card.lives {
        bottom: 20px;
        left: 0;
    }

    .pulse-line {
        position: absolute;
        bottom: 18px;
        left: 0;
        width: 100%;
        opacity: .35;
    }

    /* =========================
       STATS
    ========================= */

    .stats-section {
        margin-top: 25px;
        margin-bottom: 45px;
    }

    .stat-box {
        height: 100%;
        padding: 22px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        transition: .2s ease;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, .06);
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-bottom: 14px;
        background: #f8fafc;
        color: #dc2626;
        font-size: 17px;
    }

    .stat-number {
        color: #172033;
        font-size: 26px;
        line-height: 1;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .stat-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    /* =========================
       SECTION HEADINGS
    ========================= */

    .section-heading {
        margin-bottom: 18px;
    }

    .section-heading h5 {
        color: #172033;
        font-size: 18px;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .section-heading p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    /* =========================
       FEATURES
    ========================= */

    .feature-card {
        height: 100%;
        padding: 24px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        transition: .2s ease;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 22px;
    }

    .feature-icon.red {
        color: #dc2626;
        background: #fef2f2;
    }

    .feature-icon.blue {
        color: #2563eb;
        background: #eff6ff;
    }

    .feature-icon.green {
        color: #16a34a;
        background: #f0fdf4;
    }

    .feature-card h6 {
        color: #172033;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .feature-card p {
        color: #64748b;
        font-size: 12px;
        line-height: 1.7;
        margin: 0;
    }

    /* =========================
       TOP DONORS
    ========================= */

    .donor-section {
        margin-top: 45px;
    }

    .donor-container {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
    }

    .donor-header {
        padding: 20px 22px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .donor-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .trophy-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fffbeb;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .donor-header h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 750;
        color: #172033;
    }

    .donor-header span {
        color: #94a3b8;
        font-size: 11px;
    }

    .donor-body {
        padding: 25px 20px;
    }

    .donor-profile {
        text-align: center;
        padding: 10px;
        border-radius: 13px;
        transition: .2s ease;
    }

    .donor-profile:hover {
        background: #f8fafc;
    }

    .donor-avatar {
        width: 72px;
        height: 72px;
        margin: 0 auto 10px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fef2f2;
        color: #dc2626;
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px #fecaca;
        overflow: hidden;
    }

    .donor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .donor-name {
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .blood-badge {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 5px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 9px;
        font-weight: 700;
    }

    .donation-count {
        color: #94a3b8;
        font-size: 10px;
        margin-top: 5px;
    }

    /* =========================
       CTA
    ========================= */

    .bottom-cta {
        margin-top: 45px;
        margin-bottom: 20px;
        padding: 30px;
        border-radius: 18px;
        background: linear-gradient(135deg, #172033, #293548);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .bottom-cta::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -80px;
        top: -100px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }

    .bottom-cta h5 {
        font-weight: 750;
        margin-bottom: 7px;
    }

    .bottom-cta p {
        color: #cbd5e1;
        font-size: 12px;
        margin: 0;
    }

    .bottom-cta .btn {
        position: relative;
        z-index: 2;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        padding: 9px 16px;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 991px) {

        .home-hero {
            padding: 38px 28px;
        }

        .hero-visual {
            display: none;
        }
    }

    @media (max-width: 576px) {

        .home-hero {
            padding: 30px 20px;
            border-radius: 18px;
        }

        .hero-title {
            font-size: 2.25rem;
        }

        .hero-description {
            font-size: 14px;
        }

        .stat-box {
            padding: 17px;
        }

        .donor-body {
            padding: 18px 10px;
        }

        .bottom-cta {
            padding: 24px 20px;
        }
    }
</style>


<div class="home-page">

    <!-- ==========================================
         HERO
    =========================================== -->

    <section class="home-hero">

        <div class="row align-items-center g-4">

            <div class="col-lg-7">

                <div class="hero-content">

                    <div class="hero-tag">
                        <i class="bi bi-heart-pulse-fill"></i>
                        Smart Blood Bank
                    </div>

                    <h1 class="hero-title">
                        Every drop can
                        <span>save a life.</span>
                    </h1>

                    <p class="hero-description">
                        Blood Link connects patients with eligible donors nearby.
                        Find the right blood group quickly, communicate securely,
                        and make every donation count.
                    </p>

                    <div class="hero-actions">

                        <a
                            href="{{ route('register.donor') }}"
                            class="btn btn-primary hero-primary-btn"
                        >
                            <i class="bi bi-heart-pulse me-1"></i>
                            Become a Donor
                        </a>

                        <a
                            href="{{ auth()->check() ? route('patient.search') : route('register.patient') }}"
                            class="btn btn-outline-secondary hero-secondary-btn"
                        >
                            <i class="bi bi-search me-1"></i>
                            Find a Donor
                        </a>

                    </div>

                </div>

            </div>


            <!-- Hero Visual -->

            <div class="col-lg-5">

                <div class="hero-visual">

                    <div class="heart-orbit">

                        <div class="hero-heart">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>

                    </div>

                    <div class="floating-card available">

                        <small>Available donors</small>

                        <strong>
                            <i class="bi bi-circle-fill text-success"
                               style="font-size:7px;"></i>
                            {{ $stats['available'] }} available now
                        </strong>

                    </div>

                    <div class="floating-card lives">

                        <small>Successful donations</small>

                        <strong>
                            <i class="bi bi-heart-fill text-danger"></i>
                            {{ $stats['completed'] }} lives supported
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ==========================================
         STATS
    =========================================== -->

    <section class="stats-section">

        <div class="row g-3">

            <div class="col-lg-3 col-6">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div class="stat-number">
                        {{ $stats['donors'] }}
                    </div>

                    <div class="stat-label">
                        Registered Donors
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-6">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="stat-number">
                        {{ $stats['available'] }}
                    </div>

                    <div class="stat-label">
                        Available Now
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-6">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-file-medical-fill"></i>
                    </div>

                    <div class="stat-number">
                        {{ $stats['requests'] }}
                    </div>

                    <div class="stat-label">
                        Blood Requests
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-6">

                <div class="stat-box">

                    <div class="stat-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <div class="stat-number">
                        {{ $stats['completed'] }}
                    </div>

                    <div class="stat-label">
                        Successful Donations
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ==========================================
         FEATURES
    =========================================== -->

    <div class="section-heading">

        <h5>
            Built around people who need help
        </h5>

        <p>
            Simple tools that make blood donation safer and easier.
        </p>

    </div>


    <div class="row g-3 mb-4">

        <!-- Feature 1 -->

        <div class="col-lg-4">

            <div class="feature-card">

                <div class="feature-icon red">
                    <i class="bi bi-droplet-half"></i>
                </div>

                <h6>
                    Every donation matters
                </h6>

                <p>
                    One blood donation can help multiple patients.
                    Blood Link makes it easier for willing donors
                    to connect with people who need them.
                </p>

            </div>

        </div>


        <!-- Feature 2 -->

        <div class="col-lg-4">

            <div class="feature-card">

                <div class="feature-icon blue">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <h6>
                    Privacy by design
                </h6>

                <p>
                    Personal contact information stays private until
                    a donor chooses to share their details with the
                    person they're helping.
                </p>

            </div>

        </div>


        <!-- Feature 3 -->

        <div class="col-lg-4">

            <div class="feature-card">

                <div class="feature-icon green">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>

                <h6>
                    Fast connections
                </h6>

                <p>
                    Search by blood group and location to discover
                    eligible donors and send a blood request without
                    unnecessary delays.
                </p>

            </div>

        </div>

    </div>


    <!-- ==========================================
         TOP DONORS
    =========================================== -->

    <section class="donor-section">

        <div class="donor-container">

            <div class="donor-header">

                <div class="donor-header-title">

                    <div class="trophy-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>

                    <div>

                        <h5>
                            Top Donors
                        </h5>

                        <span>
                            Our community's most active lifesavers
                        </span>

                    </div>

                </div>

                <i class="bi bi-arrow-up-right text-muted"></i>

            </div>


            <div class="donor-body">

                <div class="row g-2 justify-content-center">

                    @forelse ($topDonors as $donor)

                        @php

                            $badges = [
                                'Bronze Donor' => 'badge-bronze',
                                'Silver Donor' => 'badge-silver',
                                'Gold Donor' => 'badge-gold',
                                'Platinum Donor' => 'badge-platinum'
                            ];

                            $badgeClass =
                                $badges[$donor->current_badge ?? 'No Badge']
                                ?? 'bg-secondary';

                        @endphp


                        <div class="col-lg col-md-4 col-6">

                            <div class="donor-profile">

                                <div class="donor-avatar">

                                    @if ($donor->user->profile_photo)

                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::url($donor->user->profile_photo) }}"
                                            alt="{{ $donor->user->name }}"
                                        >

                                    @else

                                        <i class="bi bi-person-fill fs-3"></i>

                                    @endif

                                </div>


                                <div class="donor-name">
                                    {{ $donor->user->name }}
                                </div>


                                <span class="blood-badge">
                                    {{ $donor->bloodGroup->name }}
                                </span>


                                @if ($donor->current_badge)

                                    <div class="mt-1">

                                        <span class="badge {{ $badgeClass }}"
                                              style="font-size:8px;">
                                            {{ $donor->current_badge }}
                                        </span>

                                    </div>

                                @endif


                                <div class="donation-count">

                                    {{ $donor->total_donations }}
                                    {{ $donor->total_donations == 1 ? 'donation' : 'donations' }}

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12 text-center py-4">

                            <div class="text-muted small">
                                No donor data available yet.
                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </section>


    <!-- ==========================================
         BOTTOM CTA
    =========================================== -->

    <section class="bottom-cta">

        <div class="row align-items-center g-3">

            <div class="col-md-8">

                <h5>
                    Be someone's reason to hope.
                </h5>

                <p>
                    Join Blood Link and help connect blood donors
                    with patients when they need it most.
                </p>

            </div>

            <div class="col-md-4 text-md-end">

                <a
                    href="{{ route('register.donor') }}"
                    class="btn btn-danger"
                >
                    Become a Donor
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>

            </div>

        </div>

    </section>

</div>

@endsection