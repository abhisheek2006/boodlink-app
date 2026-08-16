@extends('layouts.app')
@section('title', 'Request Blood')

@section('content')

<style>
    .request-page {
        max-width: 900px;
        margin: 0 auto;
    }

    .request-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .request-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .request-header h4 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .request-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .request-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .donor-banner {
        padding: 18px 22px;
        background: linear-gradient(135deg, #fff5f5, #ffffff);
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .donor-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .donor-name {
        font-size: 14px;
        font-weight: 700;
        color: #172033;
    }

    .donor-info {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    .form-content {
        padding: 25px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #172033;
        padding-bottom: 11px;
        margin-bottom: 18px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-title i {
        color: #dc2626;
    }

    .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border: 1px solid #dbe1e8;
        border-radius: 9px;
        padding: 10px 12px;
        font-size: 13px;
        color: #334155;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .08);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        min-height: 95px;
        resize: vertical;
    }

    .blood-group-display {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 9px;
        color: #dc2626;
        font-size: 14px;
        font-weight: 700;
    }

    .blood-group-display i {
        font-size: 17px;
    }

    /* Emergency buttons */
    .emergency-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }

    .emergency-item {
        position: relative;
    }

    .emergency-item input {
        position: absolute;
        opacity: 0;
    }

    .emergency-item label {
        display: block;
        text-align: center;
        padding: 11px 5px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        color: #64748b;
        background: #fff;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .emergency-item label:hover {
        border-color: #cbd5e1;
    }

    .emergency-low input:checked + label {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #475569;
    }

    .emergency-medium input:checked + label {
        background: #eff6ff;
        border-color: #60a5fa;
        color: #2563eb;
    }

    .emergency-high input:checked + label {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #b45309;
    }

    .emergency-critical input:checked + label {
        background: #fef2f2;
        border-color: #ef4444;
        color: #dc2626;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 23px;
        padding-top: 18px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-submit {
        background: #dc2626;
        border: 1px solid #dc2626;
        color: #fff;
        border-radius: 9px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-submit:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    .btn-cancel {
        border-radius: 9px;
        padding: 10px 18px;
        font-size: 13px;
    }

    .optional {
        font-weight: 400;
        color: #94a3b8;
    }

    .required {
        color: #dc2626;
    }

    @media (max-width: 600px) {
        .form-content {
            padding: 18px;
        }

        .emergency-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .form-footer .btn {
            width: 100%;
        }
    }
</style>


<div class="request-page">

    <!-- Header -->
    <div class="request-header">

        <div class="request-icon">
            <i class="bi bi-droplet-fill"></i>
        </div>

        <div>
            <h4>Request Blood</h4>
            <p>
                Submit a blood request from
                <strong>{{ $donor->user->name }}</strong>
            </p>
        </div>

    </div>


    <!-- Main Card -->
    <div class="request-card">

        <!-- Donor Banner -->
        <div class="donor-banner">

            <div class="donor-avatar">
                <i class="bi bi-person-heart"></i>
            </div>

            <div>
                <div class="donor-name">
                    {{ $donor->user->name }}
                </div>

                <div class="donor-info">
                    Blood donor · {{ $donor->age() }} years old · Compatible blood group
                </div>
            </div>

        </div>


        <div class="form-content">

            <form method="POST" action="{{ route('patient.requests.store', $donor) }}">
                @csrf


                <!-- Blood Requirement -->
                <div class="section-title">
                    <i class="bi bi-droplet"></i>
                    Blood Requirement
                </div>

                <div class="row g-3">

                    <!-- Blood Group -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Blood Group Needed
                            <span class="required">*</span>
                        </label>

                        <div class="blood-group-display">
                            <i class="bi bi-droplet-fill"></i>

                            {{ $donor->bloodGroup->name }}

                        </div>

                        <input
                            type="hidden"
                            name="blood_group_id"
                            value="{{ $donor->blood_group_id }}"
                        >

                    </div>


                    <!-- Units -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Units Required
                            <span class="required">*</span>
                        </label>

                        <input
                            type="number"
                            name="units_required"
                            min="1"
                            max="4"
                            class="form-control"
                            placeholder="Enter required units"
                            required
                        >

                    </div>


                    <!-- Emergency -->
                    <div class="col-12">

                        <label class="form-label">
                            Emergency Level
                            <span class="required">*</span>
                        </label>

                        <div class="emergency-grid">

                            <div class="emergency-item emergency-low">
                                <input
                                    type="radio"
                                    name="emergency_level"
                                    value="Low"
                                    id="levelLow"
                                    required
                                >
                                <label for="levelLow">
                                    <i class="bi bi-circle me-1"></i>
                                    Low
                                </label>
                            </div>

                            <div class="emergency-item emergency-medium">
                                <input
                                    type="radio"
                                    name="emergency_level"
                                    value="Medium"
                                    id="levelMedium"
                                >
                                <label for="levelMedium">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Medium
                                </label>
                            </div>

                            <div class="emergency-item emergency-high">
                                <input
                                    type="radio"
                                    name="emergency_level"
                                    value="High"
                                    id="levelHigh"
                                >
                                <label for="levelHigh">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    High
                                </label>
                            </div>

                            <div class="emergency-item emergency-critical">
                                <input
                                    type="radio"
                                    name="emergency_level"
                                    value="Critical"
                                    id="levelCritical"
                                >
                                <label for="levelCritical">
                                    <i class="bi bi-exclamation-octagon me-1"></i>
                                    Critical
                                </label>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- Medical Information -->
                <div class="section-title mt-4">
                    <i class="bi bi-hospital"></i>
                    Medical Information
                </div>

                <div class="row g-3">

                    <!-- Hospital -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Hospital Name
                            <span class="optional">(optional)</span>
                        </label>

                        <input
                            name="hospital_name"
                            class="form-control"
                            placeholder="Enter hospital name"
                        >

                    </div>


                    <!-- Required Date -->
                    <div class="col-md-6">

                        <label class="form-label">
                            Required Date
                            <span class="optional">(optional)</span>
                        </label>

                        <input
                            type="date"
                            name="required_date"
                            class="form-control"
                        >

                    </div>


                    <!-- Medical Reason -->
                    <div class="col-12">

                        <label class="form-label">
                            Medical Reason
                            <span class="required">*</span>
                        </label>

                        <textarea
                            name="reason"
                            class="form-control"
                            placeholder="Explain why blood is required..."
                            required
                        ></textarea>

                    </div>


                    <!-- Additional Notes -->
                    <div class="col-12">

                        <label class="form-label">
                            Additional Notes
                            <span class="optional">(optional)</span>
                        </label>

                        <textarea
                            name="additional_notes"
                            class="form-control"
                            placeholder="Add any additional information..."
                        ></textarea>

                    </div>

                </div>


                <!-- Footer -->
                <div class="form-footer">

                    <a
                        href="{{ url()->previous() }}"
                        class="btn btn-outline-secondary btn-cancel"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-submit"
                    >
                        <i class="bi bi-send me-1"></i>
                        Submit Request
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection