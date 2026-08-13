@extends('layouts.app')

@section('title', 'Chat Monitoring')

@section('content')

<style>
    /* =========================================================
       BLOOD LINK - CHAT MONITORING
       ========================================================= */

    .chat-monitor-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }

    /* =========================================================
       PAGE HEADER
       ========================================================= */

    .chat-monitor-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .chat-monitor-header-icon {
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

    .chat-monitor-header h1 {
        margin: 0;

        color: #111827;

        font-size: 29px;
        font-weight: 800;

        letter-spacing: -.5px;
    }

    .chat-monitor-header p {
        margin: 4px 0 0;

        color: #64748b;

        font-size: 13px;
    }


    /* =========================================================
       FILTER CARD
       ========================================================= */

    .chat-filter-card {
        background: #fff;

        border: 1px solid #edf0f4;

        border-radius: 17px;

        padding: 20px 24px;

        margin-bottom: 20px;

        box-shadow:
            0 5px 20px rgba(15, 23, 42, .035);
    }

    .chat-filter-form {
        display: grid;

        grid-template-columns: minmax(280px, 1fr)
                             minmax(190px, 250px)
                             132px;

        gap: 14px;

        align-items: center;
    }

    .chat-search-wrapper {
        position: relative;
    }

    .chat-search-wrapper i {
        position: absolute;

        right: 15px;
        top: 50%;

        transform: translateY(-50%);

        color: #64748b;

        font-size: 15px;

        pointer-events: none;
    }

    .chat-search,
    .chat-status {
        width: 100%;
        height: 45px;

        border: 1px solid #e1e7ef;

        border-radius: 11px;

        background: #fff;

        color: #334155;

        padding: 0 14px;

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }

    .chat-search {
        padding-right: 42px;
    }

    .chat-search::placeholder {
        color: #94a3b8;
    }

    .chat-search:focus,
    .chat-status:focus {
        border-color: #ef536b;

        box-shadow:
            0 0 0 3px rgba(229, 30, 63, .07);
    }

    .chat-filter-button {
        height: 45px;
        width: 100%;

        border: 1px solid #e51e3f;

        border-radius: 11px;

        background: #fff;

        color: #e51e3f;

        font-size: 13px;
        font-weight: 700;

        transition: .2s ease;
    }

    .chat-filter-button:hover {
        background: #e51e3f;

        color: #fff;

        box-shadow:
            0 6px 14px rgba(229, 30, 63, .18);
    }


    /* =========================================================
       TABLE CARD
       ========================================================= */

    .chat-table-card {
        background: #fff;

        border: 1px solid #edf0f4;

        border-radius: 17px;

        overflow: hidden;

        box-shadow:
            0 5px 20px rgba(15, 23, 42, .04);
    }

    .chat-table-wrapper {
        overflow-x: auto;
    }

    .chat-table {
        width: 100%;

        min-width: 950px;

        border-collapse: collapse;

        margin: 0;
    }

    .chat-table thead {
        background: #fff;
    }

    .chat-table th {
        padding: 17px 20px;

        border-bottom: 1px solid #edf0f4;

        color: #64748b;

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .35px;

        white-space: nowrap;

        text-align: left;
    }

    .chat-table td {
        padding: 16px 20px;

        border-bottom: 1px solid #f0f3f6;

        color: #172033;

        font-size: 13px;

        white-space: nowrap;

        vertical-align: middle;
    }

    .chat-table tbody tr {
        transition: background .18s ease;
    }

    .chat-table tbody tr:hover {
        background: #fff8f9;
    }

    .chat-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* =========================================================
       USER CELL
       ========================================================= */

    .chat-user {
        display: flex;

        align-items: center;

        gap: 11px;
    }

    .chat-user-avatar {
        width: 39px;
        height: 39px;

        border-radius: 50%;

        display: flex;

        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        font-size: 14px;
    }

    .chat-user-avatar.donor {
        background: #ffe6eb;

        color: #e51e3f;
    }

    .chat-user-avatar.patient {
        background: #eee7ff;

        color: #6941c6;
    }

    .chat-user-avatar.empty {
        background: #eef2f6;

        color: #94a3b8;
    }

    .chat-user-name {
        color: #172033;

        font-size: 13px;

        font-weight: 700;
    }


    /* =========================================================
       STATUS
       ========================================================= */

    .chat-status-badge {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 7px 12px;

        border-radius: 20px;

        font-size: 10px;

        font-weight: 800;

        line-height: 1;
    }

    .chat-status-badge::before {
        content: "";

        width: 7px;
        height: 7px;

        border-radius: 50%;

        display: inline-block;
    }

    .chat-status-badge.active {
        background: #e4f1ff;
        color: #1976e8;
    }

    .chat-status-badge.active::before {
        background: #1976e8;
    }

    .chat-status-badge.completed {
        background: #dcf7e9;
        color: #11a267;
    }

    .chat-status-badge.completed::before {
        background: #11a267;
    }

    .chat-status-badge.cancelled {
        background: #ffe5e9;
        color: #e32a43;
    }

    .chat-status-badge.cancelled::before {
        background: #e32a43;
    }

    .chat-status-badge.expired {
        background: #fff0d5;
        color: #c27a08;
    }

    .chat-status-badge.expired::before {
        background: #c27a08;
    }

    .chat-status-badge.pending {
        background: #fff0d5;
        color: #c27a08;
    }

    .chat-status-badge.pending::before {
        background: #c27a08;
    }

    .chat-status-badge.default {
        background: #eef2f6;
        color: #64748b;
    }

    .chat-status-badge.default::before {
        background: #94a3b8;
    }


    /* =========================================================
       DATE
       ========================================================= */

    .chat-date {
        color: #172033;

        font-size: 12px;

        font-weight: 500;
    }

    .chat-date.empty {
        color: #94a3b8;
    }


    /* =========================================================
       VIEW BUTTON
       ========================================================= */

    .chat-view-button {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 7px;

        min-width: 72px;

        height: 38px;

        padding: 0 13px;

        border: 1px solid #ffb5c0;

        border-radius: 10px;

        background: #fff;

        color: #e51e3f;

        text-decoration: none;

        font-size: 11px;

        font-weight: 700;

        transition: .2s ease;
    }

    .chat-view-button:hover {
        background: #e51e3f;

        border-color: #e51e3f;

        color: #fff;

        box-shadow:
            0 5px 12px rgba(229, 30, 63, .18);
    }


    /* =========================================================
       TABLE FOOTER
       ========================================================= */

    .chat-table-footer {
        display: flex;

        align-items: center;
        justify-content: space-between;

        padding: 17px 22px;

        border-top: 1px solid #edf0f4;
    }

    .chat-results {
        color: #64748b;

        font-size: 12px;
    }


    /* =========================================================
       PAGINATION
       ========================================================= */

    .chat-pagination .pagination {
        display: flex;

        align-items: center;

        gap: 7px;

        margin: 0;
    }

    .chat-pagination .page-item {
        list-style: none;
    }

    .chat-pagination .page-link {
        width: 39px;
        height: 39px;

        padding: 0 !important;

        border: 1px solid #e7ecf2 !important;

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

    .chat-pagination .page-link:hover {
        background: #ffe8ed;

        border-color: #ffb5c0 !important;

        color: #e51e3f;
    }

    .chat-pagination .page-item.active .page-link {
        background: #e51e3f;

        border-color: #e51e3f !important;

        color: #fff;

        box-shadow:
            0 5px 12px rgba(229, 30, 63, .2);
    }

    .chat-pagination .page-item.disabled .page-link {
        color: #cbd5e1;

        background: #fff;

        pointer-events: none;
    }


    /* =========================================================
       EMPTY STATE
       ========================================================= */

    .chat-empty-state {
        padding: 55px 20px !important;

        text-align: center;

        color: #94a3b8;
    }

    .chat-empty-icon {
        width: 65px;
        height: 65px;

        margin: 0 auto 12px;

        border-radius: 50%;

        background: #fff0f3;

        color: #e51e3f;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 25px;
    }

    .chat-empty-title {
        color: #475569;

        font-size: 14px;

        font-weight: 800;
    }

    .chat-empty-text {
        margin-top: 4px;

        font-size: 11px;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        .chat-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .chat-filter-button {
            grid-column: span 2;
        }

    }

    @media (max-width: 768px) {

        .chat-monitor-page {
            padding: 16px;
        }

        .chat-monitor-header h1 {
            font-size: 24px;
        }

        .chat-filter-form {
            grid-template-columns: 1fr;
        }

        .chat-filter-button {
            grid-column: auto;
        }

        .chat-table-footer {
            flex-direction: column;

            align-items: flex-start;

            gap: 14px;
        }

        .chat-pagination {
            width: 100%;

            display: flex;

            justify-content: center;
        }

    }
</style>


<div class="chat-monitor-page">

    {{-- =====================================================
         HEADER
         ===================================================== --}}

    <div class="chat-monitor-header">

        <div class="chat-monitor-header-icon">
            <i class="bi bi-chat-square-text"></i>
        </div>

        <div>

            <h1>
                Chat Monitoring
            </h1>

            <p>
                Monitor donor and patient conversations
            </p>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
         ===================================================== --}}

    <div class="chat-filter-card">

        <form
            method="GET"
            action="{{ route('admin.chats.index') }}"
            class="chat-filter-form"
        >

            {{-- Search --}}

            <div class="chat-search-wrapper">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="chat-search"
                    placeholder="Search donor or patient name..."
                >

                <i class="bi bi-search"></i>

            </div>


            {{-- Status --}}

            <div>

                <select
                    name="status"
                    class="chat-status"
                >

                    <option value="">
                        All Statuses
                    </option>

                    @foreach (
                        ['Pending', 'Active', 'Completed', 'Expired', 'Cancelled']
                        as $status
                    )

                        <option
                            value="{{ $status }}"
                            @selected(request('status') === $status)
                        >
                            {{ $status }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Filter --}}

            <button
                type="submit"
                class="chat-filter-button"
            >

                <i class="bi bi-funnel me-1"></i>

                Filter

            </button>

        </form>

    </div>


    {{-- =====================================================
         TABLE
         ===================================================== --}}

    <div class="chat-table-card">

        <div class="chat-table-wrapper">

            <table class="chat-table">

                <thead>

                    <tr>

                        <th>
                            Donor
                        </th>

                        <th>
                            Patient
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

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($sessions as $session)

                        @php

                            $donorName =
                                $session->donor?->user?->name ?? '—';

                            $patientName =
                                $session->patient?->user?->name ?? '—';


                            $statusClass = match($session->status) {

                                'Active' =>
                                    'active',

                                'Completed' =>
                                    'completed',

                                'Cancelled' =>
                                    'cancelled',

                                'Expired' =>
                                    'expired',

                                'Pending' =>
                                    'pending',

                                default =>
                                    'default'

                            };

                        @endphp


                        <tr>

                            {{-- Donor --}}

                            <td>

                                @if($donorName !== '—')

                                    <div class="chat-user">

                                        <div class="chat-user-avatar donor">

                                            <i class="bi bi-person"></i>

                                        </div>

                                        <span class="chat-user-name">
                                            {{ $donorName }}
                                        </span>

                                    </div>

                                @else

                                    <div class="chat-user">

                                        <div class="chat-user-avatar empty">

                                            <i class="bi bi-dash"></i>

                                        </div>

                                        <span class="chat-user-name">
                                            —
                                        </span>

                                    </div>

                                @endif

                            </td>


                            {{-- Patient --}}

                            <td>

                                @if($patientName !== '—')

                                    <div class="chat-user">

                                        <div class="chat-user-avatar patient">

                                            <i class="bi bi-person"></i>

                                        </div>

                                        <span class="chat-user-name">
                                            {{ $patientName }}
                                        </span>

                                    </div>

                                @else

                                    <div class="chat-user">

                                        <div class="chat-user-avatar empty">

                                            <i class="bi bi-dash"></i>

                                        </div>

                                        <span class="chat-user-name">
                                            —
                                        </span>

                                    </div>

                                @endif

                            </td>


                            {{-- Status --}}

                            <td>

                                <span
                                    class="chat-status-badge {{ $statusClass }}"
                                >
                                    {{ $session->status }}
                                </span>

                            </td>


                            {{-- Started --}}

                            <td>

                                @if($session->started_at)

                                    <span class="chat-date">
                                        {{ $session->started_at->format('d M Y, h:i A') }}
                                    </span>

                                @else

                                    <span class="chat-date empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Ended --}}

                            <td>

                                @if($session->ended_at)

                                    <span class="chat-date">
                                        {{ $session->ended_at->format('d M Y, h:i A') }}
                                    </span>

                                @else

                                    <span class="chat-date empty">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}

                            <td class="text-end">

                                <a
                                    href="{{ route('admin.chats.show', $session) }}"
                                    class="chat-view-button"
                                >

                                    <i class="bi bi-eye"></i>

                                    View

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="chat-empty-state"
                            >

                                <div class="chat-empty-icon">

                                    <i class="bi bi-chat-heart"></i>

                                </div>

                                <div class="chat-empty-title">
                                    No conversations found
                                </div>

                                <div class="chat-empty-text">
                                    There are no donor-patient conversations matching your filters.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER + PAGINATION
             ================================================= --}}

        <div class="chat-table-footer">

            <div class="chat-results">

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

                    conversations

                @else

                    Showing 0 conversations

                @endif

            </div>


            <div class="chat-pagination">

                {{ $sessions->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>

@endsection