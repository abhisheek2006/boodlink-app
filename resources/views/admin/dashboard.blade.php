@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
@php
    use App\Models\{Donor, Patient, BloodRequest, DonationSession};
    $cards = [
        'Total Donors' => Donor::count(),
        'Total Patients' => Patient::count(),
        'Total Blood Requests' => BloodRequest::count(),
        'Available Donors' => Donor::where('availability', 'Available')->count(),
        'Busy Donors' => Donor::where('availability', 'Busy')->count(),
        'Waiting Donors' => Donor::where('availability', 'Waiting')->count(),
        'Active Sessions' => DonationSession::where('status', 'Active')->count(),
        'Completed Donations' => DonationSession::where('status', 'Completed')->count(),
    ];
@endphp

<h4 class="mb-4"><i class="bi bi-speedometer2 me-2 text-secondary"></i> Admin Dashboard</h4>

<div class="row g-3 mb-4">
    @foreach ($cards as $label => $value)
        <div class="col-md-3 col-6">
            <div class="stat-card h-100">
                <div class="stat-value">{{ $value }}</div>
                <div class="stat-label">{{ $label }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent">Blood Group Distribution</div>
            <div class="card-body">
                <canvas id="bloodGroupChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent">Monthly Donations</div>
            <div class="card-body">
                <canvas id="monthlyDonationsChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent">Donor Availability</div>
            <div class="card-body">
                <canvas id="availabilityChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent">Top Cities by Donor Count</div>
            <div class="card-body">
                <canvas id="topCitiesChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function loadChart(url, canvasId, type = 'bar') {
    const res = await fetch(url);
    const rows = await res.json();
    const bgColors = type === 'doughnut' || type === 'pie'
        ? undefined
        : rows.map(() => '#' + Math.floor(Math.random()*16777215).toString(16));
    new Chart(document.getElementById(canvasId), {
        type,
        data: {
            labels: rows.map(r => r.label),
            datasets: [{ label: 'Total', data: rows.map(r => r.value), backgroundColor: bgColors ?? 'rgba(220,38,38,.7)', borderColor: 'rgba(220,38,38,1)' }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { ticks: { color: '#64748B' }, grid: { color: 'rgba(226,232,240,.4)' } }
        }
    });
}

loadChart(@json(route('admin.analytics.blood-groups')), 'bloodGroupChart', 'doughnut');
loadChart(@json(route('admin.analytics.monthly-donations')), 'monthlyDonationsChart', 'line');
loadChart(@json(route('admin.analytics.availability')), 'availabilityChart', 'pie');
loadChart(@json(route('admin.analytics.top-cities')), 'topCitiesChart', 'bar');
</script>
@endpush
@endsection
