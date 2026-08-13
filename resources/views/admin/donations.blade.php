@extends('layouts.app')

@section('title', 'Donations')

@section('content')

<style>
    /* =========================================================
       DONATION SESSIONS PAGE
       ========================================================= */

    .donations-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }


    /* =========================================================
       HEADER
       ========================================================= */

    .donations-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }

    .donations-header-icon {
        width: 58px;
        height: 58px;

        border-radius: 50%;

        background: #ffe8ed;
        color: #e51e3f;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 26px;

        flex-shrink: 0;
    }

    .donations-header h1 {
        margin: 0;

        color: #111827;

        font-size: 29px;
        font-weight: 800;

        letter-spacing: -.5px;
    }

    .donations-header p {
        margin: 4px 0 0;

        color: #64748b;

        font-size: 13px;
    }


    /* =========================================================
       FILTER CARD
       ========================================================= */

    .donations-filter-card {
        background: #fff;

        border: 1px solid #edf0f4;

        border-radius: 17px;

        padding: 20px;

        margin-bottom: 20px;

        box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    }

    .donations-filter-form {
        display: grid;

        grid-template-columns: 1fr 1fr 130px;

        gap: 13px;

        align-items: end;
    }

    .donations-filter-label {
        display: block;

        color: #172033;

        font-size: 12px;
        font-weight: 700;

        margin-bottom: 7px;
    }

    .donations-select,
    .donations-date {
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

    .donations-select:focus,
    .donations-date:focus {
        border-color: #ef536b;

        box-shadow:
            0 0 0 3px rgba(225, 29, 72, .07);
    }

    .donations-filter-button {
        width: 100%;
        height: 45px;

        border: 0;

        border-radius: 11px;

        background: #e51e3f;

        color: #fff;

        font-size: 13px;
        font-weight: 700;

        box-shadow:
            0 6px 14px rgba(229, 30, 63, .18);

        transition: .2s ease;
    }

    .donations-filter-button:hover {
        background: #c91836;

        transform: translateY(-1px);
    }


    /* =========================================================
       TABLE CARD
       ========================================================= */

    .donations-table-card {
        background: #fff;

        border: 1px solid #edf0f4;

        border-radius: 17px;

        overflow: hidden;

        box-shadow:
            0 5px 20px rgba(15, 23, 42, .04);
    }

    .donations-table-wrapper {
        overflow-x: auto;
    }

    .donations-table {
        width: 100%;

        min-width: 1000px;

        border-collapse: collapse;

        margin: 0;
    }

    .donations-table thead {
        background: #fff;
    }

    .donations-table th {
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

    .donations-table td {
        padding: 14px 20px;

        border-bottom: 1px solid #f1f5f9;

        color: #172033;

        font-size: 13px;

        white-space: nowrap;

        vertical-align: middle;
    }

    .donations-table tbody tr {
        transition: background .18s ease;
    }

    .donations-table tbody tr:hover {
        background: #fff8f9;
    }

    .donations-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* =========================================================
       PERSON CELL
       ========================================================= */

    .donation-person {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .donation-avatar {
        width: 38px;
        height: 38px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 15px;
    }

    .donation-avatar.red {
        background: #ffe7eb;
        color: #e51e3f;
    }

    .donation-avatar.blue {
        background: #e5efff;
        color: #2877e8;
    }

    .donation-avatar.green {
        background: #ddf7e9;
        color: #12a568;
    }

    .donation-avatar.empty {
        background: #eef2f7;
        color: #94a3b8;
    }

    .donation-person-name {
        color: #172033;

        font-size: 13px;
        font-weight: 700;
    }


    /* =========================================================
       BLOOD GROUP
       ========================================================= */

    .donation-blood-group {
        font-size: 13px;

        color: #172033;

        font-weight: 800;
    }


    /* =========================================================
       STATUS BADGES
       ========================================================= */

    .donation-status {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 6px 11px;

        border-radius: 20px;

        font-size: 10px;

        font-weight: 800;

        line-height: 1;
    }

    .donation-status.pending {
        background: #fff0d2;
        color: #c27b05;
    }

    .donation-status.active {
        background: #e3efff;
        color: #2877e8;
    }

    .donation-status.completed {
        background: #dcf7e8;
        color: #11945b;
    }

    .donation-status.expired {
        background: #fff0d2;
        color: #c27b05;
    }

    .donation-status.cancelled {
        background: #ffe4e8;
        color: #dc2941;
    }

    .donation-status.default {
        background: #eef2f7;
        color: #64748b;
    }


    /* =========================================================
       DATES / DURATION
       ========================================================= */

    .donation-date {
        color: #172033;

        font-size: 12px;
    }

    .donation-duration {
        color: #172033;

        font-size: 12px;

        font-weight: 700;
    }

    .donation-empty {
        color: #94a3b8;
    }


    /* =========================================================
       VIEW BUTTON
       ========================================================= */

    .donation-view-button {
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

        box-shadow:
            0 3px 8px rgba(15, 23, 42, .04);

        transition: all .2s ease;
    }

    .donation-view-button:hover {
        background: #ffe8ed;

        border-color: #ffb6c3;

        color: #e51e3f;

        transform: translateY(-1px);
    }


    /* =========================================================
       FOOTER
       ========================================================= */

    .donations-footer {
        display: flex;

        align-items: center;
        justify-content: space-between;

        padding: 16px 20px;

        border-top: 1px solid #edf0f4;
    }

    .donations-count {
        color: #64748b;

        font-size: 12px;
    }

    .donations-count strong {
        color: #475569;
    }


    /* =========================================================
       PAGINATION
       ========================================================= */

    .donations-pagination .pagination {
        display: flex;

        align-items: center;

        gap: 6px;

        margin: 0;

        padding: 0;
    }

    .donations-pagination .page-item {
        list-style: none;
    }

    .donations-pagination .page-link {
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

    .donations-pagination .page-link:hover {
        background: #ffe8ed;

        border-color: #ffb6c3 !important;

        color: #e51e3f;
    }

    .donations-pagination .page-item.active .page-link {
        background: #e51e3f;

        border-color: #e51e3f !important;

        color: #fff;

        box-shadow:
            0 4px 10px rgba(229, 30, 63, .2);
    }

    .donations-pagination .page-item.disabled .page-link {
        color: #cbd5e1;

        background: #fff;

        pointer-events: none;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        .donations-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .donations-filter-button {
            grid-column: span 2;
        }

    }

    @media (max-width: 768px) {

        .donations-page {
            padding: 16px;
        }

        .donations-header h1 {
            font-size: 24px;
        }

        .donations-filter-form {
            grid-template-columns: 1fr;
        }

        .donations-filter-button {
            grid-column: auto;
        }

        .donations-footer {
            flex-direction: column;

            align-items: flex-start;

            gap: 14px;
        }

        .donations-pagination {
            width: 100%;

            display: flex;

            justify-content: center;
        }

    }
</style>


<div class="donations-page">

    {{-- =====================================================
         PAGE HEADER
         ===================================================== --}}

    <div class="donations-header">

        <div class="donations-header-icon">
            <i class="bi bi-heart-pulse"></i>
        </div>

        <div>

            <h1>
                Donation Sessions
            </h1>

            <p>
                Track and manage donation sessions
            </p>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
         ===================================================== --}}

    <div class="donations-filter-card">

        <form
            method="GET"
            action="{{ route('admin.donations.index') }}"
            class="donations-filter-form"
        >

            {{-- Status --}}

            <div>

                <label class="donations-filter-label">
                    Status
                </label>

                <select
                    name="status"
                    class="donations-select"
                >

                    <option value="">
                        All Statuses
                    </option>

                    @foreach (
                        ['Pending', 'Active', 'Completed', 'Expired', 'Cancelled']
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


            {{-- Date --}}

            <div>

                <label class="donations-filter-label">
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="donations-date"
                >

            </div>


            {{-- Filter Button --}}

            <div>

                <label
                    class="donations-filter-label"
                    style="visibility:hidden;"
                >
                    Filter
                </label>

                <button
                    type="submit"
                    class="donations-filter-button"
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

    <div class="donations-table-card">

        <div class="donations-table-wrapper">

            <table class="donations-table">

                <thead>

                    <tr>

                        <th>
                            Donor
                        </th>

                        <th>
                            Patient
                        </th>

                        <th>
                            Blood Group
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Started
                        </th>

                        <th>
                            Ended
                        </th>

                        <th>
                            Duration
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($sessions as $s)

                        @php

                            $donorName =
                                $s->donor->user->name ?? '—';

                            $patientName =
                                $s->patient->user->name ?? '—';


                            $statusClass = match($s->status) {

                                'Pending' =>
                                    'pending',

                                'Active' =>
                                    'active',

                                'Completed' =>
                                    'completed',

                                'Expired' =>
                                    'expired',

                                'Cancelled' =>
                                    'cancelled',

                                default =>
                                    'default'

                            };


                            /*
                             * Give each donor row a subtle
                             * avatar color like the reference.
                             */

                            $avatarClass = match($s->status) {

                                'Cancelled' =>
                                    'red',

                                'Active' =>
                                    'blue',

                                'Completed' =>
                                    'green',

                                default =>
                                    'red'

                            };

                        @endphp


                        <tr>

                            {{-- Donor --}}

                            <td>

                                <div class="donation-person">

                                    <div
                                        class="donation-avatar
                                        {{ $donorName === '—'
                                            ? 'empty'
                                            : $avatarClass }}"
                                    >

                                        <i class="bi bi-person"></i>

                                    </div>

                                    <span class="donation-person-name">
                                        {{ $donorName }}
                                    </span>

                                </div>

                            </td>


                            {{-- Patient --}}

                            <td>

                                @if($patientName !== '—')

                                    <div class="donation-person">

                                        <div class="donation-avatar blue">

                                            <i class="bi bi-person"></i>

                                        </div>

                                        <span class="donation-person-name">
                                            {{ $patientName }}
                                        </span>

                                    </div>

                                @else

                                    <span class="donation-empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Blood Group --}}

                            <td>

                                <span class="donation-blood-group">
                                    {{ $s->bloodRequest->bloodGroup->name ?? '—' }}
                                </span>

                            </td>


                            {{-- Status --}}

                            <td>

                                <span
                                    class="donation-status {{ $statusClass }}"
                                >

                                    @if($s->status === 'Active')

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                    @elseif($s->status === 'Completed')

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                    @elseif($s->status === 'Cancelled')

                                        <i class="bi bi-x-circle-fill me-1"></i>

                                    @elseif($s->status === 'Pending')

                                        <i class="bi bi-clock-fill me-1"></i>

                                    @elseif($s->status === 'Expired')

                                        <i class="bi bi-clock-history me-1"></i>

                                    @endif

                                    {{ $s->status }}

                                </span>

                            </td>


                            {{-- Started --}}

                            <td>

                                @if($s->started_at)

                                    <span class="donation-date">
                                        {{ $s->started_at->format('M d, Y') }}
                                    </span>

                                @else

                                    <span class="donation-empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Ended --}}

                            <td>

                                @if($s->ended_at)

                                    <span class="donation-date">
                                        {{ $s->ended_at->format('M d, Y') }}
                                    </span>

                                @else

                                    <span class="donation-empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Duration --}}

                            <td>

                                @if($s->session_duration)

                                    <span class="donation-duration">
                                        {{ $s->session_duration }}s
                                    </span>

                                @else

                                    <span class="donation-empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}

                            <td class="text-end">

                                <a
                                    href="{{ route('admin.donations.show', $s) }}"
                                    class="donation-view-button"
                                    title="View Donation Session"
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
                                    class="bi bi-heart-pulse fs-1 text-muted d-block mb-2"
                                ></i>

                                <span class="text-muted">
                                    No donation sessions found.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             TABLE FOOTER
             ================================================= --}}

        <div class="donations-footer">

            <div class="donations-count">

                @if($sessions->total() > 0)

                    Showing

                    <strong>
                        {{ $sessions->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $sessions->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $sessions->total() }}
                    </strong>

                    sessions

                @else

                    Showing 0 sessions

                @endif

            </div>


            <div class="donations-pagination">

                {{ $sessions->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection