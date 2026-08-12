@extends('layouts.app')
@section('title', 'Blood Request #{{ $bloodRequest->id }}')

@section('content')
<h4 class="mb-4">Blood Request #{{ $bloodRequest->id }}</h4>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $bloodRequest->patient->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $bloodRequest->patient->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $bloodRequest->patient->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>City:</strong> {{ $bloodRequest->patient->city ?? '—' }}</p>
                <p class="mb-1"><strong>Blood Group Needed:</strong> {{ $bloodRequest->bloodGroup->name ?? '—' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Donor Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $bloodRequest->donor->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $bloodRequest->donor->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $bloodRequest->donor->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>City:</strong> {{ $bloodRequest->donor->city ?? '—' }}</p>
                <p class="mb-1"><strong>Blood Group:</strong> {{ $bloodRequest->donor->bloodGroup->name ?? '—' }}</p>
                <p class="mb-1"><strong>Total Donations:</strong> {{ $bloodRequest->donor->total_donations ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header">Request Details</div>
    <div class="card-body">
        <p class="mb-1"><strong>Units Required:</strong> {{ $bloodRequest->units_required }}</p>
        <p class="mb-1"><strong>Emergency Level:</strong> {{ $bloodRequest->emergency_level }}</p>
        <p class="mb-1"><strong>Reason:</strong> {{ $bloodRequest->reason }}</p>
        <p class="mb-1"><strong>Hospital:</strong> {{ $bloodRequest->hospital_name ?? 'Not specified' }}</p>
        <p class="mb-1"><strong>Required Date:</strong> {{ $bloodRequest->required_date?->format('M d, Y') ?? 'Not specified' }}</p>
        <p class="mb-1"><strong>Additional Notes:</strong> {{ $bloodRequest->additional_notes ?? 'None' }}</p>
        <p class="mb-1"><strong>Status:</strong> {{ $bloodRequest->status }}</p>
        <p class="mb-0"><strong>Created:</strong> {{ $bloodRequest->created_at->format('M d, Y H:i') }}</p>
    </div>
</div>

@if ($bloodRequest->donationSession)
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header">Donation Session</div>
        <div class="card-body">
            <p class="mb-1"><strong>Status:</strong> {{ $bloodRequest->donationSession->status }}</p>
            <p class="mb-1"><strong>Started:</strong> {{ $bloodRequest->donationSession->started_at?->format('M d, Y H:i') ?? '—' }}</p>
            <p class="mb-1"><strong>Ended:</strong> {{ $bloodRequest->donationSession->ended_at?->format('M d, Y H:i') ?? '—' }}</p>
            <p class="mb-1"><strong>Duration:</strong> {{ $bloodRequest->donationSession->session_duration ? $bloodRequest->donationSession->session_duration . 's' : '—' }}</p>
            <p class="mb-0"><strong>Contact Shared:</strong> {{ $bloodRequest->donationSession->contact_shared ? 'Yes' : 'No' }}</p>
        </div>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.blood-requests.index') }}" class="btn btn-outline-secondary">Back to Requests</a>
</div>
@endsection
