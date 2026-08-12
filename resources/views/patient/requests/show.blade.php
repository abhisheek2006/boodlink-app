@extends('layouts.app')
@section('title', 'Request Details')

@section('content')
<h4 class="mb-4">Blood Request #{{ $request->id }}</h4>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Request Details</div>
            <div class="card-body">
                <p class="mb-1"><strong>Blood Group:</strong> {{ $request->bloodGroup->name ?? '—' }}</p>
                <p class="mb-1"><strong>Units Required:</strong> {{ $request->units_required }}</p>
                <p class="mb-1"><strong>Emergency Level:</strong>
                    <span class="badge {{ match($request->emergency_level) { 'Critical' => 'bg-danger', 'High' => 'bg-warning text-dark', 'Medium' => 'bg-info', default => 'bg-secondary' } }}">
                        {{ $request->emergency_level }}
                    </span>
                </p>
                <p class="mb-1"><strong>Reason:</strong> {{ $request->reason }}</p>
                <p class="mb-1"><strong>Hospital:</strong> {{ $request->hospital_name ?? 'Not specified' }}</p>
                <p class="mb-1"><strong>Required Date:</strong> {{ $request->required_date?->format('M d, Y') ?? 'Not specified' }}</p>
                <p class="mb-1"><strong>Status:</strong> {{ $request->status }}</p>
                <p class="mb-0"><strong>Created:</strong> {{ $request->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Donor Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $request->donor->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $request->donor->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $request->donor->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>Blood Group:</strong> {{ $request->donor->bloodGroup->name ?? '—' }}</p>
                <p class="mb-1"><strong>Total Donations:</strong> {{ $request->donor->total_donations ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

@if ($request->additional_notes)
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header">Additional Notes</div>
        <div class="card-body">{{ $request->additional_notes }}</div>
    </div>
@endif

@if ($request->donationSession)
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header">Donation Session</div>
        <div class="card-body">
            <p class="mb-1"><strong>Status:</strong> {{ $request->donationSession->status }}</p>
            <p class="mb-1"><strong>Started:</strong> {{ $request->donationSession->started_at?->format('M d, Y H:i') ?? '—' }}</p>
            @if ($request->donationSession->status === 'Accepted')
                <a href="{{ route('chat.show', $request->donationSession) }}" class="btn btn-primary btn-sm">Open Chat</a>
            @endif
        </div>
    </div>
@endif

<div class="mt-3 d-flex justify-content-between">
    <a href="{{ route('patient.requests.index') }}" class="btn btn-outline-secondary">Back to My Requests</a>

    @if (in_array($request->status, ['Pending', 'Accepted']))
        <form method="POST" action="{{ route('patient.requests.cancel', $request) }}" onsubmit="return confirm('Cancel this blood request?');">
            @csrf @method('PATCH')
            <button class="btn btn-outline-danger">Cancel Request</button>
        </form>
    @endif
</div>
@endsection
