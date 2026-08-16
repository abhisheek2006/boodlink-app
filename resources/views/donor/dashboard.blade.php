@extends('layouts.app')

@section('title', 'Donor Dashboard')

@section('content')

@php
    $activeSession = $donor->activeSession()->with('patient.user')->first();

    $availabilityClass = match($donor->availability) {
        'Available' => 'available',
        'Busy' => 'busy',
        default => 'waiting',
    };
@endphp

<style>
    /* ================================
       DONOR DASHBOARD
    ================================= */

    .donor-dashboard {
        padding: 8px 4px 40px;
    }

    .donor-welcome {
        margin-bottom: 28px;
    }

    .donor-welcome h1 {
        margin: 0;
        color: #111827;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .donor-welcome p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 16px;
    }

    /* ================================
       STAT CARDS
    ================================= */

    .donor-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .donor-stat-card {
        position: relative;
        min-height: 235px;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 18px;
        padding: 30px 20px 25px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-shadow: 0 5px 18px rgba(15, 23, 42, 0.045);
        transition: all .2s ease;
    }

    .donor-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
    }

    .donor-stat-icon {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        margin-bottom: 20px;
    }

    .icon-blood {
        background: #fff0f1;
        color: #ef233c;
    }

    .icon-status {
        background: #eafaf2;
        color: #13b87a;
    }

    .icon-donation {
        background: #eef5ff;
        color: #4285f4;
    }

    .icon-badge {
        background: #fff7e8;
        color: #f5a623;
    }

    .donor-stat-value {
        color: #111827;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .blood-value {
        color: #ef233c;
    }

    .donor-stat-label {
        color: #718096;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 500;
    }

    /* Availability badge */

    .donor-availability {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 17px;
        font-weight: 700;
    }

    .donor-availability::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .donor-availability.available {
        background: #16c784;
        color: white;
    }

    .donor-availability.busy {
        background: #fee2e2;
        color: #dc2626;
    }

    .donor-availability.waiting {
        background: #fff3cd;
        color: #9a6700;
    }

    .badge-value {
        font-size: 18px;
        white-space: nowrap;
    }

    /* ================================
       WAITING ALERT
    ================================= */

    .donor-alert {
        border: 1px solid #f8d98b;
        background: #fffaf0;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        color: #7a5a00;
    }

    .donor-alert strong {
        color: #624900;
    }

    /* ================================
       ACTIVE SESSION
    ================================= */

    .active-donation-card {
        background: #ffffff;
        border: 1px solid #ffd6da;
        border-left: 4px solid #ef233c;
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 28px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .045);
    }

    .active-donation-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .active-donation-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0f1;
        color: #ef233c;
        font-size: 21px;
    }

    .active-donation-header h5 {
        margin: 0;
        font-weight: 700;
        color: #111827;
    }

    .active-donation-card p {
        color: #64748b;
        margin: 8px 0 16px 56px;
    }

    .active-donation-card .btn {
        margin-left: 56px;
    }

    /* ================================
       QUICK ACTIONS
    ================================= */

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .quick-action {
        min-height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #ffffff;
        color: #111827;
        border: 1px solid #e6eaf0;
        border-radius: 14px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .035);
        transition: all .2s ease;
    }

    .quick-action i {
        color: #ef233c;
        font-size: 19px;
    }

    .quick-action:hover {
        color: #ef233c;
        border-color: #f4b5bb;
        background: #fffafb;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 35, 60, .08);
    }

    /* ================================
       MOBILE
    ================================= */

    @media (max-width: 1100px) {
        .donor-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .quick-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .donor-dashboard {
            padding: 5px 0 30px;
        }

        .donor-welcome h1 {
            font-size: 25px;
        }

        .donor-welcome p {
            font-size: 14px;
        }

        .donor-stats {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .donor-stat-card {
            min-height: 190px;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .active-donation-card p,
        .active-donation-card .btn {
            margin-left: 0;
        }
    }
</style>

<div class="donor-dashboard">

    {{-- ================================
         WELCOME SECTION
    ================================= --}}
    <div class="donor-welcome">
        <h1>Welcome, {{ $donor->user->name }}</h1>
        <p>
            Age: {{ $donor->age() ?? 'N/A' }} years
            <span class="mx-2">•</span>
            <span class="{{ $donor->isAgeEligible() ? 'text-success' : 'text-danger' }}">
                {{ $donor->isAgeEligible() ? 'Age-eligible to donate (18-65)' : 'Not age-eligible to donate' }}
            </span>
        </p>
    </div>


    {{-- ================================
         STATISTICS
    ================================= --}}
    <div class="donor-stats">

        {{-- Blood Group --}}
        <div class="donor-stat-card">

            <div class="donor-stat-icon icon-blood">
                <i class="bi bi-droplet"></i>
            </div>

            <div class="donor-stat-value blood-value">
                {{ $donor->bloodGroup->name }}
            </div>

            <div class="donor-stat-label">
                Blood Group
            </div>

        </div>


        {{-- Availability --}}
        <div class="donor-stat-card">

            <div class="donor-stat-icon icon-status">
                <i class="bi bi-shield-check"></i>
            </div>

            <div class="donor-stat-value">

                <span class="donor-availability {{ $availabilityClass }}">
                    {{ $donor->availability }}
                </span>

            </div>

            <div class="donor-stat-label">
                Status
            </div>

        </div>


        {{-- Total Donations --}}
        <div class="donor-stat-card">

            <div class="donor-stat-icon icon-donation">
                <i class="bi bi-heart"></i>
            </div>

            <div class="donor-stat-value">
                {{ $donor->total_donations }}
            </div>

            <div class="donor-stat-label">
                Total Donations
            </div>

        </div>


        {{-- Badge / Rank --}}
        <div class="donor-stat-card">

            <div class="donor-stat-icon icon-badge">
                <i class="bi bi-award"></i>
            </div>

            <div class="donor-stat-value badge-value">
                {{ $donor->current_badge ?? 'No Badge' }}
                <span>·</span>
                #{{ $donor->current_rank ?? '-' }}
            </div>

            <div class="donor-stat-label">
                Badge / Rank
            </div>

        </div>

    </div>


    {{-- ================================
         WAITING / COOLDOWN ALERT
    ================================= --}}
    @if ($donor->availability === 'Waiting')

        <div class="donor-alert">

            <i class="bi bi-info-circle me-2"></i>

            <strong>Donation cooldown:</strong>

            Last Donation:
            {{ optional($donor->last_donation_date)->toFormattedDateString() }}

            <span class="mx-2">—</span>

            Next Eligible:
            {{ optional($donor->next_eligible_date)->toFormattedDateString() }}

            <span class="mx-2">•</span>

            {{ $donor->remainingCooldownDays() }} day(s) remaining

        </div>

    @endif


    {{-- ================================
         ACTIVE DONATION SESSION
    ================================= --}}
    @if ($activeSession)

        <div class="active-donation-card">

            <div class="active-donation-header">

                <div class="active-donation-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>

                <h5>
                    Active Donation Session
                </h5>

            </div>

            <p>
                Patient:
                <strong>
                    {{ $activeSession->patient->user->name }}
                </strong>

                <span class="mx-2">•</span>

                Expires
                {{ $activeSession->expires_at->diffForHumans() }}
            </p>

            <a href="{{ route('chat.show', $activeSession) }}"
               class="btn btn-danger px-4">

                <i class="bi bi-chat-left-text me-1"></i>
                Open Chat

            </a>

        </div>

    @endif


    {{-- ================================
         QUICK ACTIONS
    ================================= --}}
    <div class="quick-actions">

        <a href="{{ route('profile.edit') }}"
           class="quick-action">

            <i class="bi bi-person"></i>
            <span>Edit Profile</span>

        </a>


        <a href="{{ route('donor.requests.index') }}"
           class="quick-action">

            <i class="bi bi-list-ul"></i>
            <span>View Requests</span>

        </a>


        <a href="{{ route('donor.history') }}"
           class="quick-action">

            <i class="bi bi-clock-history"></i>
            <span>Donation History</span>

        </a>


        <a href="{{ route('leaderboard') }}"
           class="quick-action">

            <i class="bi bi-trophy"></i>
            <span>Leaderboard</span>

        </a>

    </div>

</div>

@endsection