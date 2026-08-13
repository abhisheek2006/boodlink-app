@extends('layouts.app')

@section('title', 'Blood Requests')

@section('content')

<style>
    /* =========================================================
       BLOOD REQUESTS PAGE
       ========================================================= */

    .requests-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }

    /* =========================================================
       HEADER
       ========================================================= */

    .requests-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }

    .requests-header-icon {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #ffe8ed;
        color: #e51e3f;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 25px;
        flex-shrink: 0;
    }

    .requests-header h1 {
        margin: 0;
        color: #111827;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .requests-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }


    /* =========================================================
       FILTER CARD
       ========================================================= */

    .requests-filter-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 17px;

        padding: 20px;

        margin-bottom: 20px;

        box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    }

    .requests-filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr 130px;
        gap: 13px;
        align-items: end;
    }

    .requests-filter-label {
        display: block;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .requests-select {
        width: 100%;
        height: 45px;

        padding: 0 14px;

        border: 1px solid #e2e8f0;
        border-radius: 11px;

        background: #fff;

        color: #334155;

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }

    .requests-select:focus {
        border-color: #ef536b;

        box-shadow:
            0 0 0 3px rgba(225, 29, 72, .07);
    }

    .requests-filter-button {
        height: 45px;
        width: 100%;

        border: 0;
        border-radius: 11px;

        background: #e51e3f;
        color: #fff;

        font-size: 13px;
        font-weight: 700;

        box-shadow: 0 6px 14px rgba(229, 30, 63, .18);

        transition: .2s ease;
    }

    .requests-filter-button:hover {
        background: #c91836;
        transform: translateY(-1px);
    }


    /* =========================================================
       TABLE CARD
       ========================================================= */

    .requests-table-card {
        background: #fff;

        border: 1px solid #edf0f4;
        border-radius: 17px;

        overflow: hidden;

        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .requests-table-wrapper {
        overflow-x: auto;
    }

    .requests-table {
        width: 100%;
        min-width: 950px;

        border-collapse: collapse;
        margin: 0;
    }

    .requests-table thead {
        background: #fff;
    }

    .requests-table th {
        padding: 16px 20px;

        border-bottom: 1px solid #edf0f4;

        color: #64748b;

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .35px;

        white-space: nowrap;
        text-align: left;
    }

    .requests-table td {
        padding: 14px 20px;

        border-bottom: 1px solid #f1f5f9;

        color: #172033;

        font-size: 13px;

        white-space: nowrap;
        vertical-align: middle;
    }

    .requests-table tbody tr {
        transition: .18s ease;
    }

    .requests-table tbody tr:hover {
        background: #fff8f9;
    }

    .requests-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* =========================================================
       PERSON CELL
       ========================================================= */

    .request-person {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .request-person-avatar {
        width: 38px;
        height: 38px;

        border-radius: 50%;

        background: #ffe7eb;
        color: #e51e3f;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 15px;

        flex-shrink: 0;
    }

    .request-person-avatar.empty {
        background: #eef2f7;
        color: #94a3b8;
    }

    .request-person-name {
        color: #172033;
        font-size: 13px;
        font-weight: 700;
    }


    /* =========================================================
       BLOOD GROUP
       ========================================================= */

    .request-blood-group {
        font-weight: 800;
        color: #172033;
    }


    /* =========================================================
       UNITS
       ========================================================= */

    .request-units {
        font-weight: 700;
        color: #172033;
    }


    /* =========================================================
       EMERGENCY BADGES
       ========================================================= */

    .request-badge {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 60px;

        padding: 6px 11px;

        border-radius: 20px;

        font-size: 10px;
        font-weight: 800;

        line-height: 1;
    }

    .emergency-low {
        background: #dbeafe;
        color: #2563eb;
    }

    .emergency-medium {
        background: #dbeafe;
        color: #2563eb;
    }

    .emergency-high {
        background: #fff0d2;
        color: #d97706;
    }

    .emergency-critical {
        background: #ffe1e5;
        color: #dc263f;
    }


    /* =========================================================
       STATUS BADGES
       ========================================================= */

    .status-pending {
        background: #fff0d2;
        color: #d97706;
    }

    .status-accepted {
        background: #dcf7e8;
        color: #11935a;
    }

    .status-completed {
        background: #dcf7e8;
        color: #11935a;
    }

    .status-cancelled {
        background: #ffe1e5;
        color: #dc263f;
    }

    .status-rejected {
        background: #ffe1e5;
        color: #dc263f;
    }

    .status-default {
        background: #eef2f7;
        color: #64748b;
    }


    /* =========================================================
       DATE
       ========================================================= */

    .request-date {
        color: #64748b;
        font-size: 12px;
    }


    /* =========================================================
       VIEW BUTTON
       ========================================================= */

    .request-view-button {
        width: 40px;
        height: 40px;

        border: 1px solid #e8edf3;

        border-radius: 50%;

        background: #fff;

        color: #334155;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        text-decoration: none;

        font-size: 14px;

        transition: all .2s ease;

        box-shadow: 0 3px 8px rgba(15, 23, 42, .04);
    }

    .request-view-button:hover {
        background: #ffe8ed;
        border-color: #ffb6c3;
        color: #e51e3f;

        transform: translateY(-1px);
    }


    /* =========================================================
       TABLE FOOTER
       ========================================================= */

    .requests-footer {
        display: flex;

        align-items: center;
        justify-content: space-between;

        padding: 16px 20px;

        border-top: 1px solid #edf0f4;
    }

    .requests-count {
        color: #64748b;
        font-size: 12px;
    }

    .requests-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .requests-pagination .page-item {
        list-style: none;
    }

    .requests-pagination .pagination {
        display: flex;
        gap: 6px;

        margin: 0;
        padding: 0;

        align-items: center;
    }

    .requests-pagination .page-link {
        width: 38px;
        height: 38px;

        padding: 0;

        border: 1px solid #e8edf3 !important;

        border-radius: 50% !important;

        background: #fff;

        color: #334155;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 12px;
        font-weight: 700;

        box-shadow: none;

        transition: .2s ease;
    }

    .requests-pagination .page-link:hover {
        background: #ffe8ed;

        border-color: #ffb6c3 !important;

        color: #e51e3f;
    }

    .requests-pagination .page-item.active .page-link {
        background: #e51e3f;

        border-color: #e51e3f !important;

        color: #fff;

        box-shadow:
            0 4px 10px rgba(229, 30, 63, .2);
    }

    .requests-pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #fff;

        pointer-events: none;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        .requests-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .requests-filter-button {
            grid-column: span 2;
        }

    }

    @media (max-width: 768px) {

        .requests-page {
            padding: 16px;
        }

        .requests-header h1 {
            font-size: 24px;
        }

        .requests-filter-form {
            grid-template-columns: 1fr;
        }

        .requests-filter-button {
            grid-column: auto;
        }

        .requests-footer {
            flex-direction: column;
            gap: 14px;
            align-items: flex-start;
        }

        .requests-pagination {
            width: 100%;
            justify-content: center;
        }

    }
</style>


<div class="requests-page">

    {{-- =====================================================
         HEADER
         ===================================================== --}}

    <div class="requests-header">

        <div class="requests-header-icon">
            <i class="bi bi-card-list"></i>
        </div>

        <div>

            <h1>
                Blood Requests
            </h1>

            <p>
                Manage and track blood requests
            </p>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
         ===================================================== --}}

    <div class="requests-filter-card">

        <form
            method="GET"
            action="{{ route('admin.blood-requests.index') }}"
            class="requests-filter-form"
        >

            {{-- Status --}}

            <div>

                <label class="requests-filter-label">
                    Status
                </label>

                <select
                    name="status"
                    class="requests-select"
                >

                    <option value="">
                        All Statuses
                    </option>

                    @foreach (
                        ['Pending', 'Accepted', 'Completed', 'Cancelled', 'Rejected']
                        as $s
                    )

                        <option
                            value="{{ $s }}"
                            @selected(request('status') === $s)
                        >
                            {{ $s }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Emergency Level --}}

            <div>

                <label class="requests-filter-label">
                    Emergency Level
                </label>

                <select
                    name="emergency_level"
                    class="requests-select"
                >

                    <option value="">
                        All Levels
                    </option>

                    @foreach (
                        ['Low', 'Medium', 'High', 'Critical']
                        as $s
                    )

                        <option
                            value="{{ $s }}"
                            @selected(request('emergency_level') === $s)
                        >
                            {{ $s }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Filter Button --}}

            <div>

                <label
                    class="requests-filter-label"
                    style="visibility:hidden;"
                >
                    Filter
                </label>

                <button
                    type="submit"
                    class="requests-filter-button"
                >
                    <i class="bi bi-funnel me-1"></i>
                    Filter
                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABLE
         ===================================================== --}}

    <div class="requests-table-card">

        <div class="requests-table-wrapper">

            <table class="requests-table">

                <thead>

                    <tr>

                        <th>
                            Patient
                        </th>

                        <th>
                            Donor
                        </th>

                        <th>
                            Blood Group
                        </th>

                        <th>
                            Units
                        </th>

                        <th>
                            Emergency
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($requests as $r)

                        @php

                            $patientName =
                                $r->patient->user->name ?? '—';

                            $donorName =
                                $r->donor->user->name ?? '—';

                            $emergencyClass = match(
                                $r->emergency_level
                            ) {

                                'Low' =>
                                    'emergency-low',

                                'Medium' =>
                                    'emergency-medium',

                                'High' =>
                                    'emergency-high',

                                'Critical' =>
                                    'emergency-critical',

                                default =>
                                    'emergency-low'

                            };


                            $statusClass = match(
                                $r->status
                            ) {

                                'Pending' =>
                                    'status-pending',

                                'Accepted' =>
                                    'status-accepted',

                                'Completed' =>
                                    'status-completed',

                                'Cancelled' =>
                                    'status-cancelled',

                                'Rejected' =>
                                    'status-rejected',

                                default =>
                                    'status-default'

                            };

                        @endphp


                        <tr>

                            {{-- Patient --}}

                            <td>

                                <div class="request-person">

                                    <div
                                        class="request-person-avatar
                                        {{ $patientName === '—' ? 'empty' : '' }}"
                                    >

                                        @if($patientName !== '—')

                                            <i class="bi bi-person"></i>

                                        @else

                                            <i class="bi bi-person"></i>

                                        @endif

                                    </div>

                                    <span class="request-person-name">
                                        {{ $patientName }}
                                    </span>

                                </div>

                            </td>


                            {{-- Donor --}}

                            <td>

                                <div class="request-person">

                                    <div
                                        class="request-person-avatar
                                        {{ $donorName === '—' ? 'empty' : '' }}"
                                    >

                                        <i class="bi bi-person"></i>

                                    </div>

                                    <span class="request-person-name">
                                        {{ $donorName }}
                                    </span>

                                </div>

                            </td>


                            {{-- Blood Group --}}

                            <td>

                                <span class="request-blood-group">
                                    {{ $r->bloodGroup->name ?? '—' }}
                                </span>

                            </td>


                            {{-- Units --}}

                            <td>

                                <span class="request-units">
                                    {{ $r->units_required }}
                                </span>

                            </td>


                            {{-- Emergency --}}

                            <td>

                                <span
                                    class="request-badge {{ $emergencyClass }}"
                                >

                                    @if($r->emergency_level === 'Critical')

                                        <i class="bi bi-exclamation-circle-fill me-1"></i>

                                    @elseif($r->emergency_level === 'High')

                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>

                                    @elseif($r->emergency_level === 'Medium')

                                        <i class="bi bi-dash-circle-fill me-1"></i>

                                    @else

                                        <i class="bi bi-arrow-down-circle-fill me-1"></i>

                                    @endif

                                    {{ $r->emergency_level }}

                                </span>

                            </td>


                            {{-- Status --}}

                            <td>

                                <span
                                    class="request-badge {{ $statusClass }}"
                                >

                                    @if($r->status === 'Pending')

                                        <i class="bi bi-clock-fill me-1"></i>

                                    @elseif($r->status === 'Accepted')

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                    @elseif($r->status === 'Completed')

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                    @elseif($r->status === 'Cancelled')

                                        <i class="bi bi-x-circle-fill me-1"></i>

                                    @elseif($r->status === 'Rejected')

                                        <i class="bi bi-x-circle-fill me-1"></i>

                                    @endif

                                    {{ $r->status }}

                                </span>

                            </td>


                            {{-- Created --}}

                            <td>

                                <span class="request-date">

                                    {{ $r->created_at->format('M d, Y') }}

                                </span>

                            </td>


                            {{-- Action --}}

                            <td class="text-end">

                                <a
                                    href="{{ route('admin.blood-requests.show', $r) }}"
                                    class="request-view-button"
                                    title="View Request"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-droplet-half fs-1 text-muted d-block mb-2"
                                ></i>

                                <span class="text-muted">
                                    No blood requests found.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER / PAGINATION
             ================================================= --}}

        <div class="requests-footer">

            <div class="requests-count">

                @if($requests->total() > 0)

                    Showing

                    <strong>
                        {{ $requests->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $requests->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $requests->total() }}
                    </strong>

                    requests

                @else

                    Showing 0 requests

                @endif

            </div>


            <div class="requests-pagination">

                {{ $requests->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection