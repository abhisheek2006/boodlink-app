@extends('layouts.app')
@section('title', 'Search Donors')

@section('content')
<h4 class="mb-4">Search Donors</h4>

<form class="row g-2 mb-4" method="GET">
    <div class="col-md-3">
        <select name="blood_group_id" class="form-select">
            <option value="">All Blood Groups</option>
            @foreach ($bloodGroups as $bg)
                <option value="{{ $bg->id }}" @selected(request('blood_group_id') == $bg->id)>{{ $bg->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input name="city" value="{{ request('city') }}" class="form-control" placeholder="City">
    </div>
    <div class="col-md-3">
        <input name="state" value="{{ request('state') }}" class="form-control" placeholder="State">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary w-100">Search</button>
    </div>
</form>

<div class="row g-3">
    @forelse ($donors as $donor)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                        <i class="bi bi-person-fill fs-4 text-secondary"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $donor->user->name }}</div>
                        <span class="badge bg-danger">{{ $donor->bloodGroup->name }}</span>
                        @if ($donor->current_badge)
                            <span class="badge bg-secondary">{{ $donor->current_badge }}</span>
                        @endif
                    </div>
                </div>
                <div class="small text-muted mb-2">{{ $donor->city }}, {{ $donor->state }} &middot; {{ $donor->total_donations }} donations</div>
                <a href="{{ route('patient.requests.create', $donor) }}" class="btn btn-primary btn-sm mt-auto">Request Blood</a>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No eligible donors match your search right now. Try widening your filters.</div>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $donors->links() }}</div>
@endsection
