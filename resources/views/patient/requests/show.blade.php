@extends('layouts.app')
@section('title', 'Request Details')

@section('content')

<style>
    .request-page {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* Header */
    .request-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .request-heading {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .request-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .request-heading h4 {
        margin: 0;
        color: #172033;
        font-weight: 700;
    }

    .request-heading p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .request-number {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 7px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-family: monospace;
        white-space: nowrap;
    }

    /* Main Cards */
    .info-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 17px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #ffffff;
    }

    .info-card-header-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .info-card-header h6 {
        margin: 0;
        color: #172033;
        font-weight: 700;
        font-size: 14px;
    }

    .info-card-body {
        padding: 20px;
    }

    /* Information rows */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:first-child {
        padding-top: 0;
    }

    .info-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 500;
        min-width: 130px;
    }

    .info-value {
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        text-align: right;
    }

    /* Blood Group */
    .blood-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        padding: 5px 9px;
        border-radius: 7px;
        background: #fef2f2;
        color: #dc2626;
        font-size: 12px;
        font-weight: 800;
    }

    /* Emergency */
    .emergency-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    /* Status */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Notes */
    .notes-card {
        margin-top: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .notes-body {
        padding: 20px;
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
        background: #fafbfc;
    }

    /* Donation Session */
    .session-card {
        margin-top: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .session-body {
        padding: 20px;
    }

    .session-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        border-radius: 10px;
        padding: 13px 15px;
        margin-bottom: 15px;
    }

    .session-status-label {
        color: #64748b;
        font-size: 12px;
    }

    .session-status-value {
        font-weight: 700;
        color: #334155;
        font-size: 13px;
    }

    /* Actions */
    .request-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #e5e7eb;
    }

    .request-actions .btn {
        border-radius: 9px;
        font-weight: 600;
        font-size: 13px;
        padding: 9px 15px;
    }

    .btn-blood-primary {
        background: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
    }

    .btn-blood-primary:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #ffffff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .request-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .request-number {
            align-self: flex-start;
        }

        .info-row {
            flex-direction: column;
            gap: 5px;
        }

        .info-value {
            text-align: left;
        }

        .request-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .request-actions .btn,
        .request-actions form {
            width: 100%;
        }

        .request-actions form .btn {
            width: 100%;
        }
    }
</style>


<div class="request-page">

    <!-- Page Header -->
    <div class="request-header">

        <div class="request-heading">

            <div class="request-icon">
                <i class="bi bi-droplet-half"></i>
            </div>

            <div>
                <h4>Blood Request Details</h4>
                <p>View information about your blood request</p>
            </div>

        </div>

        <div class="request-number">
            Request #{{ $request->id }}
        </div>

    </div>


    <!-- Main Information -->
    <div class="row g-3">

        <!-- Request Details -->
        <div class="col-lg-6">

            <div class="info-card">

                <div class="info-card-header">

                    <div class="info-card-header-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>

                    <h6>Request Information</h6>

                </div>


                <div class="info-card-body">

                    <div class="info-row">

                        <span class="info-label">
                            Blood Group
                        </span>

                        <span class="info-value">
                            <span class="blood-group">
                                {{ $request->bloodGroup->name ?? '—' }}
                            </span>
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Units Required
                        </span>

                        <span class="info-value">
                            {{ $request->units_required }} unit(s)
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Emergency Level
                        </span>

                        <span class="info-value">

                            <span class="emergency-badge
                                {{ match($request->emergency_level) {
                                    'Critical' => 'bg-danger text-white',
                                    'High' => 'bg-warning text-dark',
                                    'Medium' => 'bg-info text-dark',
                                    default => 'bg-secondary text-white'
                                } }}">

                                <i class="bi bi-exclamation-circle"></i>

                                {{ $request->emergency_level }}

                            </span>

                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Reason
                        </span>

                        <span class="info-value">
                            {{ $request->reason }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Hospital
                        </span>

                        <span class="info-value">
                            {{ $request->hospital_name ?? 'Not specified' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Required Date
                        </span>

                        <span class="info-value">
                            {{ $request->required_date?->format('M d, Y') ?? 'Not specified' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Status
                        </span>

                        <span class="info-value">

                            <span class="status-badge bg-light text-dark">

                                <span class="status-dot"></span>

                                {{ $request->status }}

                            </span>

                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Created
                        </span>

                        <span class="info-value">
                            {{ $request->created_at->format('M d, Y H:i') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- Donor Information -->
        <div class="col-lg-6">

            <div class="info-card">

                <div class="info-card-header">

                    <div class="info-card-header-icon">
                        <i class="bi bi-person-heart"></i>
                    </div>

                    <h6>Donor Information</h6>

                </div>


                <div class="info-card-body">

                    <div class="info-row">

                        <span class="info-label">
                            Name
                        </span>

                        <span class="info-value">
                            {{ $request->donor->user->name ?? '—' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Email
                        </span>

                        <span class="info-value">
                            {{ $request->donor->user->email ?? '—' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Phone
                        </span>

                        <span class="info-value">
                            {{ $request->donor->user->phone ?? '—' }}
                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Blood Group
                        </span>

                        <span class="info-value">

                            <span class="blood-group">
                                {{ $request->donor->bloodGroup->name ?? '—' }}
                            </span>

                        </span>

                    </div>


                    <div class="info-row">

                        <span class="info-label">
                            Total Donations
                        </span>

                        <span class="info-value">
                            {{ $request->donor->total_donations ?? 0 }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Additional Notes -->
    @if ($request->additional_notes)

        <div class="notes-card">

            <div class="info-card-header">

                <div class="info-card-header-icon">
                    <i class="bi bi-sticky"></i>
                </div>

                <h6>Additional Notes</h6>

            </div>

            <div class="notes-body">
                {{ $request->additional_notes }}
            </div>

        </div>

    @endif


    <!-- Donation Session -->
    @if ($request->donationSession)

        <div class="session-card">

            <div class="info-card-header">

                <div class="info-card-header-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>

                <h6>Donation Session</h6>

            </div>


            <div class="session-body">

                <div class="session-status">

                    <span class="session-status-label">
                        Session Status
                    </span>

                    <span class="session-status-value">
                        {{ $request->donationSession->status }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Started
                    </span>

                    <span class="info-value">
                        {{ $request->donationSession->started_at?->format('M d, Y H:i') ?? '—' }}
                    </span>

                </div>


                @if ($request->donationSession->status === 'Accepted')

                    <div class="mt-3">

                        <a
                            href="{{ route('chat.show', $request->donationSession) }}"
                            class="btn btn-blood-primary btn-sm"
                        >
                            <i class="bi bi-chat-dots me-1"></i>
                            Open Chat
                        </a>

                    </div>

                @endif

            </div>

        </div>

    @endif


    <!-- Bottom Actions -->
    <div class="request-actions">

        <a
            href="{{ route('patient.requests.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to My Requests
        </a>


        @if (in_array($request->status, ['Pending', 'Accepted']))

            <form
                method="POST"
                action="{{ route('patient.requests.cancel', $request) }}"
                onsubmit="return confirm('Cancel this blood request?');"
            >

                @csrf
                @method('PATCH')

                <button class="btn btn-outline-danger">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel Request
                </button>

            </form>

        @endif

    </div>

</div>

@endsection