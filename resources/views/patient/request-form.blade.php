@extends('layouts.app')
@section('title', 'Request Blood')

@section('content')
<h4 class="mb-4">Request Blood from {{ $donor->user->name }}</h4>

<div class="card border-0 shadow-sm" style="max-width:640px;">
    <form method="POST" action="{{ route('patient.requests.store', $donor) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Blood Group Needed</label>
            <select name="blood_group_id" class="form-select" required>
                <option value="{{ $donor->blood_group_id }}" selected>{{ $donor->bloodGroup->name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Units Required</label>
            <input type="number" name="units_required" min="1" max="4" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Emergency Level</label>
            <select name="emergency_level" class="form-select" required>
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
                <option>Critical</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hospital Name (optional)</label>
            <input name="hospital_name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Required Date (optional)</label>
            <input type="date" name="required_date" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Medical Reason</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Additional Notes (optional)</label>
            <textarea name="additional_notes" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Submit Request</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
    </form>
</div>
@endsection
