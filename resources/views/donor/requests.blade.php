@extends('layouts.app')
@section('title', 'Blood Requests')

@section('content')
<h4 class="mb-4">Incoming Blood Requests</h4>

<div class="row g-3">
    @forelse ($requests as $request)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="fw-semibold">{{ $request->patient->user->name }}</div>
                        <div class="small text-muted">Blood Group: {{ $request->bloodGroup->name }} &middot; Units: {{ $request->units_required }}</div>
                    </div>
                    <span class="badge bg-{{ $request->emergency_level === 'Critical' ? 'danger' : ($request->emergency_level === 'High' ? 'warning text-dark' : 'secondary') }}">
                        {{ $request->emergency_level }}
                    </span>
                </div>
                <p class="small mt-2 mb-2">{{ $request->reason }}</p>
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('donor.requests.accept', $request) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success btn-sm">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('donor.requests.reject', $request) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-outline-danger btn-sm">Reject</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-info">No pending requests right now.</div></div>
    @endforelse
</div>

<div class="mt-4">{{ $requests->links() }}</div>
@endsection
