@extends('layouts.app')
@section('title', 'My Requests')

@section('content')

<style>
    .requests-page {
        max-width: 1150px;
        margin: 0 auto;
    }

    .requests-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .requests-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .requests-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .requests-title h4 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .requests-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .request-count {
        padding: 7px 12px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .requests-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        overflow: hidden;
    }

    .requests-table {
        margin: 0;
    }

    .requests-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 14px 18px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .requests-table tbody td {
        padding: 15px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }

    .requests-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .requests-table tbody tr {
        transition: background .15s ease;
    }

    .requests-table tbody tr:hover {
        background: #fafafa;
    }

    .date-cell {
        color: #64748b !important;
        font-size: 12px !important;
        white-space: nowrap;
    }

    .donor-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 150px;
    }

    .donor-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .donor-name {
        font-weight: 600;
        color: #172033;
    }

    .donor-label {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        margin-top: 1px;
    }

    .blood-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        padding: 6px 9px;
        border-radius: 7px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 11px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-completed {
        background: #f0fdf4;
        color: #15803d;
    }

    .status-accepted {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-pending {
        background: #fffbeb;
        color: #b45309;
    }

    .status-rejected,
    .status-cancelled {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-cell {
        text-align: right;
        white-space: nowrap;
    }

    .btn-cancel-request {
        border: 1px solid #fecaca;
        color: #dc2626;
        background: #fff;
        border-radius: 7px;
        font-size: 11px;
        padding: 6px 10px;
    }

    .btn-cancel-request:hover {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fca5a5;
    }

    .btn-chat {
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
        border-radius: 7px;
        font-size: 11px;
        padding: 7px 11px;
        font-weight: 600;
    }

    .btn-chat:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    .no-action {
        color: #cbd5e1;
    }

    .empty-state {
        padding: 55px 20px !important;
        text-align: center;
    }

    .empty-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: #f8fafc;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 21px;
    }

    .empty-state strong {
        display: block;
        color: #475569;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .empty-state span {
        color: #94a3b8;
        font-size: 11px;
    }

    .pagination-wrapper {
        padding: 15px 18px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
    }

    @media (max-width: 768px) {

        .requests-header {
            align-items: flex-start;
        }

        .request-count {
            display: none;
        }

        .requests-card {
            border-radius: 12px;
        }

        .requests-table thead th,
        .requests-table tbody td {
            padding: 12px;
        }

        .action-cell {
            min-width: 90px;
        }
    }
</style>


<div class="requests-page">

    <!-- Header -->
    <div class="requests-header">

        <div class="requests-title">

            <div class="requests-icon">
                <i class="bi bi-card-list"></i>
            </div>

            <div>
                <h4>My Blood Requests</h4>
                <p>Track and manage your blood donation requests</p>
            </div>

        </div>

        <div class="request-count">
            {{ $requests->total() }} Request{{ $requests->total() == 1 ? '' : 's' }}
        </div>

    </div>


    <!-- Requests Table -->
    <div class="requests-card">

        <div class="table-responsive">

            <table class="table requests-table align-middle">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($requests as $request)

                        <tr>

                            <!-- Date -->
                            <td class="date-cell">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $request->created_at->toFormattedDateString() }}
                            </td>


                            <!-- Donor -->
                            <td>

                                <div class="donor-cell">

                                    <div class="donor-avatar">
                                        <i class="bi bi-person-heart"></i>
                                    </div>

                                    <div>
                                        <div class="donor-name">
                                            {{ $request->donor?->user->name ?? 'No donor assigned' }}
                                        </div>

                                        <span class="donor-label">
                                            {{ $request->donor ? 'Blood Donor' : 'Awaiting donor' }}
                                        </span>
                                    </div>

                                </div>

                            </td>


                            <!-- Blood Group -->
                            <td>

                                <span class="blood-badge">
                                    <i class="bi bi-droplet-fill me-1"></i>
                                    {{ $request->bloodGroup->name }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td>

                                @php

                                    $statusClass = match($request->status) {
                                        'Completed' => 'status-completed',
                                        'Accepted' => 'status-accepted',
                                        'Rejected' => 'status-rejected',
                                        'Cancelled' => 'status-cancelled',
                                        default => 'status-pending',
                                    };

                                    $statusIcon = match($request->status) {
                                        'Completed' => 'bi-check-circle-fill',
                                        'Accepted' => 'bi-check2-circle',
                                        'Rejected' => 'bi-x-circle',
                                        'Cancelled' => 'bi-slash-circle',
                                        default => 'bi-hourglass-split',
                                    };

                                @endphp

                                <span class="status-badge {{ $statusClass }}">
                                    <i class="bi {{ $statusIcon }}"></i>
                                    {{ $request->status }}
                                </span>

                            </td>


                            <!-- Actions -->
                            <td class="action-cell">

                                @if ($request->status === 'Pending')

                                    <form
                                        method="POST"
                                        action="{{ route('patient.requests.cancel', $request) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Cancel this blood request?');"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-cancel-request"
                                        >
                                            <i class="bi bi-x-lg me-1"></i>
                                            Cancel
                                        </button>

                                    </form>

                                @elseif ($request->status === 'Accepted' && $request->donationSession)

                                    <a
                                        href="{{ route('chat.show', $request->donationSession) }}"
                                        class="btn btn-chat"
                                    >
                                        <i class="bi bi-chat-dots me-1"></i>
                                        Open Chat
                                    </a>

                                @else

                                    <span class="no-action">—</span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty-state">

                                <div class="empty-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <strong>No blood requests yet</strong>

                                <span>
                                    Your submitted blood requests will appear here.
                                </span>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if ($requests->hasPages())

            <div class="pagination-wrapper">
                {{ $requests->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

@endsection