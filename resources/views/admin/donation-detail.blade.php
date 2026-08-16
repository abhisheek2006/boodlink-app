@extends('layouts.app')
@section('title', 'Donation Session #{{ $session->id }}')

@section('content')
<h4 class="mb-4">Donation Session #{{ $session->id }}</h4>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Donor Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $session->donor->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $session->donor->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $session->donor->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>Blood Group:</strong> {{ $session->donor->bloodGroup->name ?? '—' }}</p>
                <p class="mb-1"><strong>Total Donations:</strong> {{ $session->donor->total_donations ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $session->patient->user->name ?? '—' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $session->patient->user->email ?? '—' }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $session->patient->user->phone ?? '—' }}</p>
                <p class="mb-1"><strong>Blood Group Needed:</strong> {{ $session->bloodRequest->bloodGroup->name ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header">Session Details</div>
    <div class="card-body">
        <p class="mb-1"><strong>Status:</strong> {{ $session->status }}</p>
        <p class="mb-1"><strong>Started:</strong> {{ $session->started_at?->format('M d, Y H:i') ?? '—' }}</p>
        <p class="mb-1"><strong>Expires:</strong> {{ $session->expires_at?->format('M d, Y H:i') ?? '—' }}</p>
        <p class="mb-1"><strong>Ended:</strong> {{ $session->ended_at?->format('M d, Y H:i') ?? '—' }}</p>
        <p class="mb-1"><strong>Duration:</strong> {{ $session->session_duration ? $session->session_duration . ' seconds' : '—' }}</p>
        <p class="mb-1"><strong>Contact Shared:</strong> {{ $session->contact_shared ? 'Yes' : 'No' }}</p>
    </div>
</div>

@if ($session->chatMessages && $session->chatMessages->isNotEmpty())
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header">Chat Messages</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr><th>Time</th><th>Sender</th><th>Message</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($session->chatMessages as $msg)
                            <tr>
                                <td>{{ $msg->created_at->format('M d, H:i') }}</td>
                                <td>{{ $msg->sender->name ?? '—' }}</td>
                                <td>{{ $msg->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<div class="mt-3">
    <a href="{{ route('admin.donations.index') }}" class="btn btn-outline-secondary">Back to Donations</a>
</div>
@endsection
