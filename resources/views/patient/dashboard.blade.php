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

    $activeSession = $patient->donationSessions()
        ->where('status', 'Active')
        ->with('donor.user')
        ->first();
@endphp

<style>
    .patient-dashboard {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 26px;
        gap: 20px;
    }

    .welcome-section {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .welcome-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .welcome-section h4 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .welcome-section p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .dashboard-date {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #fff;
        color: #64748b;
        font-size: 12px;
    }

    /* Statistics */
    .stat-card-new {
        position: relative;
        height: 100%;
        padding: 20px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        transition: .2s ease;
    }

    .stat-card-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(15, 23, 42, .07);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .stat-number {
        font-size: 28px;
        line-height: 1;
        font-weight: 800;
        color: #172033;
    }

    .stat-label-new {
        margin-top: 7px;
        color: #64748b;
        font-size: 12px;
        font-weight: 500;
    }

    .stat-red .stat-icon {
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-yellow .stat-icon {
        background: #fffbeb;
        color: #d97706;
    }

    .stat-blue .stat-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-green .stat-icon {
        background: #f0fdf4;
        color: #16a34a;
    }

    /* Active Session */
    .active-session {
        margin-top: 22px;
        border: 1px solid #bfdbfe;
        background: linear-gradient(135deg, #eff6ff, #ffffff);
        border-radius: 15px;
        overflow: hidden;
    }

    .active-session-body {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .session-left {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .session-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .session-title {
        font-weight: 700;
        color: #172033;
        font-size: 14px;
    }

    .session-info {
        margin-top: 3px;
        color: #64748b;
        font-size: 12px;
    }

    .session-info strong {
        color: #334155;
    }

    .btn-dashboard-primary {
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
        border-radius: 9px;
        padding: 9px 15px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-dashboard-primary:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    /* Empty Session */
    .empty-session {
        margin-top: 22px;
        padding: 17px 20px;
        border-radius: 13px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #64748b;
        font-size: 13px;
    }

    .empty-session i {
        color: #2563eb;
        font-size: 17px;
    }

    /* Quick Actions */
    .quick-section {
        margin-top: 25px;
    }

    .section-title {
        margin-bottom: 12px;
        color: #172033;
        font-size: 14px;
        font-weight: 700;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        color: #334155;
        text-decoration: none;
        transition: .2s ease;
    }

    .quick-action:hover {
        color: #dc2626;
        border-color: #fecaca;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, .06);
    }

    .quick-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-text {
        flex: 1;
    }

    .quick-text strong {
        display: block;
        font-size: 13px;
    }

    .quick-text span {
        display: block;
        margin-top: 2px;
        color: #94a3b8;
        font-size: 11px;
    }

    .quick-arrow {
        color: #94a3b8;
    }

    @media (max-width: 768px) {

        .dashboard-header {
            align-items: flex-start;
        }

        .dashboard-date {
            display: none;
        }

        .active-session-body {
            align-items: flex-start;
            flex-direction: column;
        }

        .active-session-body .btn {
            width: 100%;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="patient-dashboard">

    <!-- Dashboard Header -->
    <div class="dashboard-header">

        <div class="welcome-section">

            <div class="welcome-icon">
                <i class="bi bi-person-heart"></i>
            </div>

            <div>
                <h4>Welcome, {{ $patient->user->name }}</h4>
                <p>Manage your blood requests and find donors</p>
            </div>

        </div>

        <div class="dashboard-date">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->format('M d, Y') }}
        </div>

    </div>


    <!-- Statistics -->
    <div class="row g-3">

        <div class="col-md-3 col-6">
            <div class="stat-card-new stat-red">

                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-card-list"></i>
                    </div>
                </div>

                <div class="stat-number">
                    {{ $counts['My Requests'] }}
                </div>

                <div class="stat-label-new">
                    My Requests
                </div>

            </div>
        </div>


        <div class="col-md-3 col-6">
            <div class="stat-card-new stat-yellow">

                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>

                <div class="stat-number">
                    {{ $counts['Pending'] }}
                </div>

                <div class="stat-label-new">
                    Pending Requests
                </div>

            </div>
        </div>


        <div class="col-md-3 col-6">
            <div class="stat-card-new stat-blue">

                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>

                <div class="stat-number">
                    {{ $counts['Accepted'] }}
                </div>

                <div class="stat-label-new">
                    Accepted Requests
                </div>

            </div>
        </div>


        <div class="col-md-3 col-6">
            <div class="stat-card-new stat-green">

                <div class="stat-top">
                    <div class="stat-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                </div>

                <div class="stat-number">
                    {{ $counts['Completed'] }}
                </div>

                <div class="stat-label-new">
                    Completed Requests
                </div>

            </div>
        </div>

    </div>


    <!-- Active Chat -->
    @if ($activeSession)

        <div class="active-session">

            <div class="active-session-body">

                <div class="session-left">

                    <div class="session-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>

                    <div>

                        <div class="session-title">
                            Active Donation Session
                        </div>

                        <div class="session-info">
                            You are connected with
                            <strong>{{ $activeSession->donor->user->name }}</strong>
                        </div>

                    </div>

                </div>


                <a
                    href="{{ route('chat.show', $activeSession) }}"
                    class="btn btn-dashboard-primary"
                >
                    <i class="bi bi-chat-text me-1"></i>
                    Open Chat
                </a>

            </div>

        </div>

    @else

        <div class="empty-session">

            <i class="bi bi-info-circle"></i>

            <span>
                No active donation session.
                Search for available donors to get started.
            </span>

        </div>

    @endif


    <!-- Quick Actions -->
    <div class="quick-section">

        <div class="section-title">
            Quick Actions
        </div>

        <div class="quick-actions">

            <a href="{{ route('patient.search') }}" class="quick-action">

                <div class="quick-icon">
                    <i class="bi bi-search"></i>
                </div>

                <div class="quick-text">
                    <strong>Search Donors</strong>
                    <span>Find compatible blood donors</span>
                </div>

                <i class="bi bi-chevron-right quick-arrow"></i>

            </a>


            <a href="{{ route('patient.requests.index') }}" class="quick-action">

                <div class="quick-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div class="quick-text">
                    <strong>Request History</strong>
                    <span>View your previous requests</span>
                </div>

                <i class="bi bi-chevron-right quick-arrow"></i>

            </a>


            <a href="{{ route('leaderboard') }}" class="quick-action">

                <div class="quick-icon">
                    <i class="bi bi-trophy"></i>
                </div>

                <div class="quick-text">
                    <strong>Leaderboard</strong>
                    <span>View top blood donors</span>
                </div>

                <i class="bi bi-chevron-right quick-arrow"></i>

            </a>

        </div>

    </div>

</div>

@endsection