@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@php
    use App\Models\{Donor, Patient, BloodRequest, DonationSession};

    $cards = [
        [
            'label' => 'Total Donors',
            'value' => Donor::count(),
            'icon' => 'bi-people-fill',
            'color' => 'red',
            'trend' => '+5 this month'
        ],
        [
            'label' => 'Total Patients',
            'value' => Patient::count(),
            'icon' => 'bi-person-heart',
            'color' => 'blue',
            'trend' => '+3 this month'
        ],
        [
            'label' => 'Total Requests',
            'value' => BloodRequest::count(),
            'icon' => 'bi-droplet-fill',
            'color' => 'orange',
            'trend' => '+2 this week'
        ],
        [
            'label' => 'Available Donors',
            'value' => Donor::where('availability', 'Available')->count(),
            'icon' => 'bi-heart-pulse-fill',
            'color' => 'green',
            'trend' => '+6 this month'
        ],
        [
            'label' => 'Busy Donors',
            'value' => Donor::where('availability', 'Busy')->count(),
            'icon' => 'bi-hourglass-split',
            'color' => 'purple',
            'trend' => 'Currently busy'
        ],
        [
            'label' => 'Waiting Donors',
            'value' => Donor::where('availability', 'Waiting')->count(),
            'icon' => 'bi-clock-fill',
            'color' => 'orange',
            'trend' => 'Waiting'
        ],
        [
            'label' => 'Active Sessions',
            'value' => DonationSession::where('status', 'Active')->count(),
            'icon' => 'bi-activity',
            'color' => 'green',
            'trend' => 'Currently active'
        ],
        [
            'label' => 'Completed Donations',
            'value' => DonationSession::where('status', 'Completed')->count(),
            'icon' => 'bi-check-circle-fill',
            'color' => 'purple',
            'trend' => 'All completed'
        ],
    ];
@endphp

<style>
    /* =========================================
       BLOOD LINK ADMIN DASHBOARD
       ========================================= */

    .blood-dashboard {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }

    /* Header */
    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 20px;
    }

    .dashboard-title-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .dashboard-title-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff1f2;
        color: #e11d48;
        font-size: 22px;
    }

    .dashboard-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #172033;
        letter-spacing: -0.5px;
    }

    .dashboard-subtitle {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .dashboard-date {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 11px 16px;
        border-radius: 12px;
        color: #64748b;
        font-size: 13px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .03);
    }

    /* KPI Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 18px;
    }

    .stat-card-modern {
        position: relative;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 18px;
        padding: 20px;
        min-height: 170px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
        transition: all .25s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .stat-icon.red {
        background: #ffe4e9;
        color: #e11d48;
    }

    .stat-icon.blue {
        background: #e4efff;
        color: #3182ce;
    }

    .stat-icon.orange {
        background: #fff0dc;
        color: #f59e0b;
    }

    .stat-icon.green {
        background: #e5f7e8;
        color: #52b947;
    }

    .stat-icon.purple {
        background: #eee8ff;
        color: #7356d8;
    }

    .stat-value {
        margin-top: 15px;
        font-size: 30px;
        line-height: 1;
        font-weight: 800;
        color: #172033;
    }

    .stat-label {
        margin-top: 8px;
        font-size: 13px;
        color: #475569;
        font-weight: 600;
    }

    .stat-trend {
        margin-top: 13px;
        font-size: 11px;
        color: #64748b;
    }

    .stat-trend i {
        color: #22c55e;
        margin-right: 4px;
    }

    .stat-wave {
        position: absolute;
        left: 0;
        right: 0;
        bottom: -2px;
        height: 38px;
        opacity: .8;
    }

    .stat-wave svg {
        width: 100%;
        height: 100%;
    }

    .wave-red path {
        stroke: #fb7185;
        fill: none;
    }

    .wave-blue path {
        stroke: #60a5fa;
        fill: none;
    }

    .wave-orange path {
        stroke: #fb923c;
        fill: none;
    }

    .wave-green path {
        stroke: #65c84a;
        fill: none;
    }

    /* Chart cards */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 18px;
        margin-bottom: 18px;
    }

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .045);
        overflow: hidden;
    }

    .dashboard-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 19px 21px;
        border-bottom: 1px solid #f0f2f5;
    }

    .card-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 750;
        color: #172033;
        font-size: 16px;
    }

    .card-heading i {
        color: #e11d48;
        font-size: 18px;
    }

    .card-action {
        border: none;
        background: #fff1f2;
        color: #e11d48;
        border-radius: 10px;
        padding: 7px 13px;
        font-size: 11px;
        font-weight: 700;
    }

    .dashboard-card-body {
        padding: 20px;
    }

    .chart-container {
        height: 280px;
        position: relative;
    }

    /* Tables */
    .activity-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table th {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        padding: 0 10px 12px;
        white-space: nowrap;
    }

    .activity-table td {
        padding: 13px 10px;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
        color: #334155;
        white-space: nowrap;
    }

    .person-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        color: #1e293b;
    }

    .person-avatar {
        width: 29px;
        height: 29px;
        border-radius: 50%;
        background: #fff1f2;
        color: #e11d48;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .blood-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        padding: 4px 7px;
        border-radius: 8px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 10px;
        font-weight: 800;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .status-completed,
    .status-matched {
        background: #e8f7e8;
        color: #3c8c3c;
    }

    .status-pending {
        background: #fff0dc;
        color: #c67a12;
    }

    .status-urgent {
        background: #ffe4e9;
        color: #d9234f;
    }

    /* Donation promo */
    .donation-banner {
        margin-top: 18px;
        border-radius: 18px;
        padding: 24px;
        background: linear-gradient(135deg, #fff1f2, #ffffff);
        border: 1px solid #ffe4e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .donation-banner-content h4 {
        margin: 0 0 6px;
        font-size: 18px;
        font-weight: 800;
        color: #172033;
    }

    .donation-banner-content p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .donation-banner-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #e11d48;
        color: #ffffff !important;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 11px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 7px 18px rgba(225, 29, 72, .2);
    }

    .dashboard-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 22px;
        color: #94a3b8;
        font-size: 11px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .activity-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .blood-dashboard {
            padding: 16px;
        }

        .dashboard-header {
            align-items: flex-start;
        }

        .dashboard-title {
            font-size: 22px;
        }

        .dashboard-date {
            display: none;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-card-modern {
            padding: 15px;
            min-height: 145px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            font-size: 18px;
        }

        .stat-value {
            font-size: 24px;
        }

        .activity-table {
            min-width: 650px;
        }

        .dashboard-card-body {
            overflow-x: auto;
        }

        .donation-banner {
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-footer {
            flex-direction: column;
            gap: 7px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="blood-dashboard">

    {{-- ================= HEADER ================= --}}
    <div class="dashboard-header">

        <div class="dashboard-title-wrapper">

            <div class="dashboard-title-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div>
                <h1 class="dashboard-title">Admin Dashboard</h1>
                <p class="dashboard-subtitle">
                    Welcome back, {{ auth()->user()->name ?? 'Administrator' }}
                </p>
            </div>

        </div>

        <div class="dashboard-date">
            <i class="bi bi-calendar3 me-2"></i>
            {{ now()->format('d M Y') }}
        </div>

    </div>


    {{-- ================= MAIN STAT CARDS ================= --}}
    <div class="stats-grid">

        @foreach($cards as $card)

            <div class="stat-card-modern">

                <div class="stat-top">

                    <div class="stat-icon {{ $card['color'] }}">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $card['value'] }}
                </div>

                <div class="stat-label">
                    {{ $card['label'] }}
                </div>

                <div class="stat-trend">
                    <i class="bi bi-arrow-up-right"></i>
                    {{ $card['trend'] }}
                </div>

                <div class="stat-wave wave-{{ $card['color'] }}">
                    <svg viewBox="0 0 300 50" preserveAspectRatio="none">
                        <path
                            d="M0,38 C30,20 45,42 70,28 C100,12 120,39 150,25 C180,11 200,32 225,22 C250,12 270,25 300,8"
                            stroke-width="2.5"
                        />
                    </svg>
                </div>

            </div>

        @endforeach

    </div>


    {{-- ================= CHARTS ================= --}}
    <div class="dashboard-grid">

        {{-- Blood Groups --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-pie-chart-fill"></i>
                    Blood Group Distribution
                </div>

                <button class="card-action">
                    View Details
                </button>

            </div>

            <div class="dashboard-card-body">

                <div class="chart-container">
                    <canvas id="bloodGroupChart"></canvas>
                </div>

            </div>

        </div>


        {{-- Monthly Donations --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-droplet-fill"></i>
                    Monthly Donations
                </div>

                <a href="{{ route('admin.reports.preview', 'monthly-donations') }}" class="card-action">
                    View Report
                </a>

            </div>

            <div class="dashboard-card-body">

                <div class="chart-container">
                    <canvas id="monthlyDonationsChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    {{-- ================= SECONDARY CHARTS ================= --}}
    <div class="dashboard-grid">

        {{-- Donor Availability --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-person-check-fill"></i>
                    Donor Availability
                </div>

            </div>

            <div class="dashboard-card-body">

                <div class="chart-container">
                    <canvas id="availabilityChart"></canvas>
                </div>

            </div>

        </div>


        {{-- Top Cities --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-geo-alt-fill"></i>
                    Top Cities by Donor Count
                </div>

            </div>

            <div class="dashboard-card-body">

                <div class="chart-container">
                    <canvas id="topCitiesChart"></canvas>
                </div>

            </div>

        </div>

    </div>


    {{-- ================= RECENT ACTIVITY ================= --}}
    <div class="activity-grid">

        {{-- Blood Requests --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-clipboard2-pulse-fill"></i>
                    Recent Blood Requests
                </div>

                <button class="card-action">
                    View All
                </button>

            </div>

            <div class="dashboard-card-body">

                <table class="activity-table">

                    <thead>
                        <tr>
                            <th>REQUEST</th>
                            <th>BLOOD</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse(BloodRequest::latest()->take(4)->get() as $request)

                            <tr>

                                <td>
                                    <div class="person-cell">

                                        <div class="person-avatar">
                                            <i class="bi bi-person-fill"></i>
                                        </div>

                                        {{ optional($request->patient)->name ?? 'Patient' }}

                                    </div>
                                </td>

                                <td>
                                    <span class="blood-badge">
                                        {{ $request->blood_group ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    {{ optional($request->created_at)->format('d M Y') }}
                                </td>

                                <td>

                                    @php
                                        $status = strtolower($request->status ?? 'pending');
                                    @endphp

                                    <span class="status-badge
                                        {{ $status === 'urgent' ? 'status-urgent' : '' }}
                                        {{ $status === 'pending' ? 'status-pending' : '' }}
                                        {{ $status === 'matched' ? 'status-matched' : '' }}
                                        {{ $status === 'completed' ? 'status-completed' : '' }}
                                    ">
                                        {{ ucfirst($request->status ?? 'Pending') }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No blood requests found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Recent Donations --}}
        <div class="dashboard-card">

            <div class="dashboard-card-header">

                <div class="card-heading">
                    <i class="bi bi-droplet-fill"></i>
                    Recent Donations
                </div>

                <button class="card-action">
                    View All
                </button>

            </div>

            <div class="dashboard-card-body">

                <table class="activity-table">

                    <thead>
                        <tr>
                            <th>DONOR</th>
                            <th>BLOOD</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse(DonationSession::latest()->take(4)->get() as $session)

                            <tr>

                                <td>

                                    <div class="person-cell">

                                        <div class="person-avatar">
                                            <i class="bi bi-person-fill"></i>
                                        </div>

                                        {{ optional($session->donor)->name ?? 'Donor' }}

                                    </div>

                                </td>

                                <td>

                                    <span class="blood-badge">
                                        {{ optional($session->donor)->blood_group ?? ($session->blood_group ?? 'N/A') }}
                                    </span>

                                </td>

                                <td>
                                    {{ optional($session->created_at)->format('d M Y') }}
                                </td>

                                <td>

                                    @php
                                        $sessionStatus = strtolower($session->status ?? 'pending');
                                    @endphp

                                    <span class="status-badge
                                        {{ $sessionStatus === 'completed' ? 'status-completed' : '' }}
                                        {{ $sessionStatus === 'pending' ? 'status-pending' : '' }}
                                    ">
                                        {{ ucfirst($session->status ?? 'Pending') }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No donations found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ================= DONATION BANNER ================= --}}
    <div class="donation-banner">

        <div class="donation-banner-content">

            <h4>
                <i class="bi bi-heart-fill text-danger me-2"></i>
                Every Drop Counts
            </h4>

            <p>
                Your support helps connect donors with patients and saves more lives.
            </p>

        </div>

        <a href="#" class="donation-banner-button">
            <i class="bi bi-droplet-fill"></i>
            View Donations
        </a>

    </div>


    {{-- ================= FOOTER ================= --}}
    <div class="dashboard-footer">

        <span>
            © {{ date('Y') }} Blood Link. All rights reserved.
        </span>

        <span>
            Made with <i class="bi bi-heart-fill text-danger"></i>
            for a better tomorrow
        </span>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Chart Defaults
    |--------------------------------------------------------------------------
    */

    Chart.defaults.font.family =
        "'Inter', 'Segoe UI', Arial, sans-serif";

    Chart.defaults.color = '#64748b';


    /*
    |--------------------------------------------------------------------------
    | Blood Group Distribution
    |--------------------------------------------------------------------------
    */

    fetch(@json(route('admin.analytics.blood-groups')))
        .then(response => response.json())
        .then(rows => {

            new Chart(
                document.getElementById('bloodGroupChart'),
                {
                    type: 'doughnut',

                    data: {

                        labels: rows.map(row => row.label),

                        datasets: [{
                            data: rows.map(row => row.value),

                            backgroundColor: [
                                '#c92f3d',
                                '#f05b7b',
                                '#805ad5',
                                '#4299e1',
                                '#f59e0b',
                                '#65b74b'
                            ],

                            borderWidth: 4,
                            borderColor: '#ffffff',

                            hoverOffset: 7
                        }]
                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        cutout: '62%',

                        plugins: {

                            legend: {
                                position: 'right',

                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    boxWidth: 8,
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    }
                                }
                            },

                            tooltip: {
                                backgroundColor: '#172033',
                                padding: 12,
                                cornerRadius: 10
                            }

                        }
                    }
                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Monthly Donations
    |--------------------------------------------------------------------------
    */

    fetch(@json(route('admin.analytics.monthly-donations')))
        .then(response => response.json())
        .then(rows => {

            new Chart(
                document.getElementById('monthlyDonationsChart'),
                {
                    type: 'line',

                    data: {

                        labels: rows.map(row => row.label),

                        datasets: [{

                            label: 'Donations',

                            data: rows.map(row => row.value),

                            borderColor: '#e11d48',

                            backgroundColor: 'rgba(225,29,72,.10)',

                            borderWidth: 3,

                            fill: true,

                            tension: .4,

                            pointRadius: 4,

                            pointHoverRadius: 7,

                            pointBackgroundColor: '#e11d48',

                            pointBorderColor: '#ffffff',

                            pointBorderWidth: 2
                        }]
                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {

                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#172033',
                                padding: 12,
                                cornerRadius: 10
                            }

                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                }
                            },

                            y: {
                                beginAtZero: true,

                                grid: {
                                    color: '#f1f5f9'
                                },

                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                }
                            }

                        }
                    }
                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Donor Availability
    |--------------------------------------------------------------------------
    */

    fetch(@json(route('admin.analytics.availability')))
        .then(response => response.json())
        .then(rows => {

            new Chart(
                document.getElementById('availabilityChart'),
                {
                    type: 'pie',

                    data: {

                        labels: rows.map(row => row.label),

                        datasets: [{

                            data: rows.map(row => row.value),

                            backgroundColor: [
                                '#65b74b',
                                '#f59e0b',
                                '#805ad5',
                                '#e11d48'
                            ],

                            borderColor: '#ffffff',

                            borderWidth: 4
                        }]
                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                position: 'right',

                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    boxWidth: 8,
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    }
                                }
                            }

                        }
                    }
                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Top Cities
    |--------------------------------------------------------------------------
    */

    fetch(@json(route('admin.analytics.top-cities')))
        .then(response => response.json())
        .then(rows => {

            new Chart(
                document.getElementById('topCitiesChart'),
                {
                    type: 'bar',

                    data: {

                        labels: rows.map(row => row.label),

                        datasets: [{

                            label: 'Donors',

                            data: rows.map(row => row.value),

                            backgroundColor: '#e11d48',

                            borderRadius: 7,

                            borderSkipped: false
                        }]
                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: false
                            }

                        },

                        scales: {

                            x: {
                                grid: {
                                    display: false
                                },

                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 10
                                    }
                                }
                            },

                            y: {

                                beginAtZero: true,

                                grid: {
                                    color: '#f1f5f9'
                                },

                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 10
                                    }
                                }

                            }

                        }
                    }
                }
            );

        });

});

</script>

@endpush

@endsection