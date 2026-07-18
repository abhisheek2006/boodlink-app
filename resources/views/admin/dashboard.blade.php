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

<h4 class="mb-4">Admin Dashboard</h4>

<div class="row g-3 mb-4">
    @foreach ($cards as $label => $value)
        <div class="col-md-3 col-6">
            <div class="card p-3">
                <div class="text-muted small">{{ $label }}</div>
                <div class="fs-3 fw-bold">{{ $value }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Blood Group Distribution</h6>
            <canvas id="bloodGroupChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Monthly Donations</h6>
            <canvas id="monthlyDonationsChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Donor Availability</h6>
            <canvas id="availabilityChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h6>Top Cities by Donor Count</h6>
            <canvas id="topCitiesChart" height="220"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function loadChart(url, canvasId, type = 'bar') {
    const res = await fetch(url);
    const rows = await res.json();
    new Chart(document.getElementById(canvasId), {
        type,
        data: {
            labels: rows.map(r => r.label),
            datasets: [{ label: 'Total', data: rows.map(r => r.value), backgroundColor: '#D32F2F' }]
        },
        options: { plugins: { legend: { display: false } } }
    });
}

loadChart(@json(route('admin.analytics.blood-groups')), 'bloodGroupChart', 'doughnut');
loadChart(@json(route('admin.analytics.monthly-donations')), 'monthlyDonationsChart', 'line');
loadChart(@json(route('admin.analytics.availability')), 'availabilityChart', 'pie');
loadChart(@json(route('admin.analytics.top-cities')), 'topCitiesChart', 'bar');
</script>
@endpush
@endsection
