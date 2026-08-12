@extends('layouts.app')
@section('title', 'Request Details')

@section('content')
<h4 class="mb-4">Blood Request from {{ $request->patient->user->name ?? '—' }}</h4>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $request->patient->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $request->patient->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $request->patient->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>City:</strong> {{ $request->patient->city ?? '—' }}</p>
            </div>
        </div>
    </div>
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

<div class="mt-3 d-flex justify-content-between">
    <a href="{{ route('donor.requests.index') }}" class="btn btn-outline-secondary">Back to Requests</a>

    @if ($request->status === 'Pending' && $request->donationSession === null)
        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('donor.requests.accept', $request) }}">
                @csrf @method('PATCH')
                <button class="btn btn-success">Accept Request</button>
            </form>
            <form method="POST" action="{{ route('donor.requests.reject', $request) }}" onsubmit="return confirm('Reject this request?');">
                @csrf @method('PATCH')
                <button class="btn btn-outline-danger">Reject Request</button>
            </form>
        </div>
    @elseif ($request->status === 'Accepted' && $request->donationSession)
        <a href="{{ route('chat.show', $request->donationSession) }}" class="btn btn-primary">Open Chat</a>
    @endif
</div>
@endsection
