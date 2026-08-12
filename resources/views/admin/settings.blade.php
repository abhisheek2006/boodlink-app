@extends('layouts.app')
@section('title', 'System Settings')

@section('content')
<h4 class="mb-4"><i class="bi bi-gear me-2 text-secondary"></i> System Settings</h4>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Session Timeout (minutes)</label>
            <input type="number" name="session_timeout_minutes" value="{{ old('session_timeout_minutes', $settings['session_timeout_minutes']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Minimum Donation Age</label>
            <input type="number" name="minimum_age_donate" value="{{ old('minimum_age_donate', $settings['minimum_age_donate']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Maximum Donation Age</label>
            <input type="number" name="maximum_age_donate" value="{{ old('maximum_age_donate', $settings['maximum_age_donate']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Minimum Weight (kg)</label>
            <input type="number" step="0.5" name="minimum_weight" value="{{ old('minimum_weight', $settings['minimum_weight']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Deferral Days (Male)</label>
            <input type="number" name="deferral_male_days" value="{{ old('deferral_male_days', $settings['deferral_male_days']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Deferral Days (Female)</label>
            <input type="number" name="deferral_female_days" value="{{ old('deferral_female_days', $settings['deferral_female_days']) }}" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Deferral Days (Other)</label>
            <input type="number" name="deferral_other_days" value="{{ old('deferral_other_days', $settings['deferral_other_days']) }}" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Shareable Session Statuses</label>
            @php
                $allStatuses = ['Pending', 'Active', 'Completed', 'Expired', 'Cancelled'];
            @endphp
            <select name="shareable_session_statuses[]" class="form-select" multiple style="min-height: 120px;">
                @foreach ($allStatuses as $s)
                    <option value="{{ $s }}" @selected(in_array($s, $settings['shareable_session_statuses']))>{{ $s }}</option>
                @endforeach
            </select>
            <div class="form-text">Ctrl+Click to select multiple.</div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save Settings</button>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<hr class="my-4">

<div class="d-flex align-items-center justify-content-between">
    <h5 class="mb-0">Cache Management</h5>
        <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm">Clear All Caches</button>
        </form>
</div>
@endsection
