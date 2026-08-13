@extends('layouts.app')

@section('title', 'User Management')

@section('content')

<style>
    /* =========================================================
       BLOOD LINK - USER MANAGEMENT
       ========================================================= */

    .users-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }

    /* ---------------------------------------------------------
       TOP HEADER
       --------------------------------------------------------- */

    .users-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .users-heading {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .users-heading-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffe8ed;
        color: #e51e3f;
        font-size: 25px;
        flex-shrink: 0;
    }

    .users-heading h1 {
        margin: 0;
        color: #111827;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .users-heading p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    /* ---------------------------------------------------------
       SUMMARY CARDS
       --------------------------------------------------------- */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .summary-card {
        border-radius: 16px;
        padding: 15px 17px;
        display: flex;
        align-items: center;
        gap: 13px;
        min-height: 85px;
        border: 1px solid transparent;
    }

    .summary-card.red {
        background: #fff0f2;
        border-color: #ffe0e5;
    }

    .summary-card.blue {
        background: #edf6ff;
        border-color: #dcecff;
    }

    .summary-card.green {
        background: #edf9f2;
        border-color: #d9f2e3;
    }

    .summary-card.purple {
        background: #f3efff;
        border-color: #e8dfff;
    }

    .summary-icon {
        width: 45px;
        height: 45px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .red .summary-icon {
        background: #ffe0e6;
        color: #e51e3f;
    }

    .blue .summary-icon {
        background: #dcecff;
        color: #2877e8;
    }

    .green .summary-icon {
        background: #d9f3e4;
        color: #16a66a;
    }

    .purple .summary-icon {
        background: #e6ddff;
        color: #7451d7;
    }

    .summary-number {
        font-size: 24px;
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    .summary-label {
        margin-top: 5px;
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    /* ---------------------------------------------------------
       FILTER CARD
       --------------------------------------------------------- */

    .filter-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        padding: 20px;
        margin-bottom: 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1.15fr auto;
        gap: 13px;
        align-items: end;
    }

    .filter-group label {
        display: block;
        margin-bottom: 7px;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
    }

    .filter-control {
        width: 100%;
        height: 43px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 11px;
        padding: 0 13px;
        color: #334155;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .filter-control.search-input {
        padding-left: 38px;
    }

    .filter-control:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, .08);
    }

    .filter-button {
        height: 43px;
        min-width: 105px;
        border: 0;
        border-radius: 11px;
        background: #e51e3f;
        color: white;
        font-size: 13px;
        font-weight: 700;
        padding: 0 18px;
        box-shadow: 0 5px 12px rgba(229, 30, 63, .17);
        transition: .2s ease;
    }

    .filter-button:hover {
        background: #c91836;
        transform: translateY(-1px);
    }

    /* ---------------------------------------------------------
       USERS TABLE
       --------------------------------------------------------- */

    .users-table-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
        position: relative;
    }

    .table-scroll {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        margin: 0;
    }

    .users-table thead {
        background: #f8fafc;
    }

    .users-table th {
        padding: 15px 16px;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .3px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf0f4;
    }

    .users-table td {
        padding: 12px 16px;
        color: #172033;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        white-space: nowrap;
    }

    .users-table tbody tr {
        transition: background .18s ease;
    }

    .users-table tbody tr:hover {
        background: #fff8f9;
    }

    .users-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* ---------------------------------------------------------
       USER CELL
       --------------------------------------------------------- */

    .user-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .user-avatar {
        width: 37px;
        height: 37px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #e4edff;
    }

    .default-avatar {
        width: 37px;
        height: 37px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e8f0ff;
        color: #2775e8;
        font-size: 19px;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 650;
        color: #172033;
        font-size: 13px;
    }

    .user-email {
        color: #475569;
        font-size: 13px;
    }

    /* ---------------------------------------------------------
       BADGES
       --------------------------------------------------------- */

    .role-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1;
    }

    .role-admin {
        background: #e9ddff;
        color: #7145c7;
    }

    .role-donor {
        background: #ffe1e6;
        color: #e11d48;
    }

    .role-patient {
        background: #ffdfe5;
        color: #e34a68;
    }

    .role-default {
        background: #eef2f7;
        color: #64748b;
    }

    .status-active {
        background: #d9f7e6;
        color: #159b60;
    }

    .status-inactive {
        background: #eef2f7;
        color: #64748b;
    }

    .status-suspended {
        background: #fff0d5;
        color: #b77913;
    }

    .status-banned {
        background: #ffe0e4;
        color: #dc263f;
    }

    .blood-group {
        font-weight: 700;
        color: #172033;
    }

    .empty-value {
        color: #94a3b8;
    }

    /* ---------------------------------------------------------
       VIEW BUTTON
       --------------------------------------------------------- */

    .view-button {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 9px;
        background: #f4f6f9;
        color: #334155;
        text-decoration: none;
        transition: .2s ease;
    }

    .view-button:hover {
        background: #ffe8ed;
        color: #e11d48;
        transform: translateY(-1px);
    }

    /* ---------------------------------------------------------
       FOOTER / CUSTOM PAGINATION
       --------------------------------------------------------- */

    .users-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        border-top: 1px solid #edf0f4;
        gap: 15px;
    }

    .users-count {
        color: #64748b;
        font-size: 12px;
    }

    .users-pagination {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination-arrow {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: transparent;
        color: #1e293b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .pagination-arrow:hover {
        background: #ffe8ed;
        color: #e51e3f;
    }

    .pagination-arrow.disabled {
        color: #cbd5e1;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-number {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: transparent;
        color: #1e293b;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .pagination-number:hover {
        background: #ffe8ed;
        color: #e51e3f;
    }

    .pagination-number.active {
        background: #e51e3f;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(229, 30, 63, .22);
    }

    /* Table loading overlay */

    .table-loading-overlay {
        position: absolute;
        inset: 0;
        background: #ffffff;
        border-radius: 17px;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 5;
    }

    .table-loading-overlay.visible {
        display: flex;
    }

    /* ---------------------------------------------------------
       RESPONSIVE
       --------------------------------------------------------- */

    @media (max-width: 1200px) {

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .filter-group:first-child {
            grid-column: span 2;
        }

        .filter-button {
            width: 100%;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {

        .users-page {
            padding: 16px;
        }

        .users-top {
            display: block;
        }

        .users-heading h1 {
            font-size: 23px;
        }

        .summary-grid {
            grid-template-columns: 1fr 1fr;
            margin-top: 18px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-group:first-child {
            grid-column: auto;
        }

        .users-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .users-heading-icon {
            width: 48px;
            height: 48px;
            font-size: 21px;
        }

        .users-pagination {
            width: 100%;
            justify-content: center;
        }

        .custom-pagination {
            gap: 3px;
        }

        .pagination-arrow,
        .pagination-number {
            width: 32px;
            height: 32px;
        }
    }
</style>


<div class="users-page">

    {{-- =====================================================
         HEADER + SUMMARY CARDS
         ===================================================== --}}

    <div class="users-top">

        <div class="users-heading">

            <div class="users-heading-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>
                <h1>User Management</h1>

                <p>
                    Manage users, roles and access permissions
                </p>
            </div>

        </div>


        {{-- Summary Cards --}}

        <div class="summary-grid">

            <div class="summary-card red">

                <div class="summary-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>
                    <div class="summary-number">
                        {{ $totalUsers }}
                    </div>

                    <div class="summary-label">
                        Total Users
                    </div>
                </div>

            </div>


            <div class="summary-card blue">

                <div class="summary-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <div>
                    <div class="summary-number">
                        {{ $activeDonors }}
                    </div>

                    <div class="summary-label">
                        Active Donors
                    </div>
                </div>

            </div>


            <div class="summary-card green">

                <div class="summary-icon">
                    <i class="bi bi-droplet-fill"></i>
                </div>

                <div>
                    <div class="summary-number">
                        {{ $totalPatients }}
                    </div>

                    <div class="summary-label">
                        Patients
                    </div>
                </div>

            </div>


            <div class="summary-card purple">

                <div class="summary-icon">
                    <i class="bi bi-person-check-fill"></i>
                </div>

                <div>
                    <div class="summary-number">
                        {{ $totalLogins }}
                    </div>

                    <div class="summary-label">
                        Total Logins
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTERS
         ===================================================== --}}

    <div class="filter-card">

        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="filter-form"
        >

            {{-- Search --}}

            <div class="filter-group">

                <label>
                    Search
                </label>

                <div class="input-wrapper">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="filter-control search-input"
                        placeholder="Name, email or phone"
                    >

                </div>

            </div>


            {{-- Role --}}

            <div class="filter-group">

                <label>
                    Role
                </label>

                <select
                    name="role"
                    class="filter-control"
                >

                    <option value="">
                        All Roles
                    </option>

                    @foreach(['Admin', 'Donor', 'Patient'] as $role)

                        <option
                            value="{{ $role }}"
                            @selected(request('role') === $role)
                        >
                            {{ $role }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Status --}}

            <div class="filter-group">

                <label>
                    Status
                </label>

                <select
                    name="status"
                    class="filter-control"
                >

                    <option value="">
                        All Statuses
                    </option>

                    @foreach(['Active', 'Inactive', 'Suspended', 'Banned'] as $status)

                        <option
                            value="{{ $status }}"
                            @selected(request('status') === $status)
                        >
                            {{ $status }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- City --}}

            <div class="filter-group">

                <label>
                    City
                </label>

                <input
                    type="text"
                    name="city"
                    value="{{ request('city') }}"
                    class="filter-control"
                    placeholder="City"
                >

            </div>


            {{-- Filter Button --}}

            <div class="filter-group">

                <label
                    style="visibility:hidden;"
                >
                    Filter
                </label>

                <button
                    type="submit"
                    class="filter-button"
                >
                    <i class="bi bi-funnel-fill me-1"></i>
                    Filter
                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         USERS TABLE (AJAX refresh target)
         ===================================================== --}}

    <div class="users-table-wrapper" id="users-table-wrapper">

        <div class="table-loading-overlay" id="table-loading">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        @include('admin.users._table', ['users' => $users])

    </div>

</div>

@endsection

@push('scripts')
<script>
    (function () {
        const wrapper = document.getElementById('users-table-wrapper');
        if (!wrapper) return;

        const tableCard = wrapper.querySelector('.users-table-card');
        const loading  = document.getElementById('table-loading');

        function showLoading() {
            if (loading) loading.classList.add('visible');
        }

        function hideLoading() {
            if (loading) loading.classList.remove('visible');
        }

        function getFragment(html) {
            const parser = new DOMParser();
            const doc    = parser.parseFromString(html, 'text/html');
            return doc.querySelector('.users-table-card');
        }

        function loadTable(url) {
            showLoading();
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to load results.');
                    return response.text();
                })
                .then(html => {
                    const fragment = getFragment(html);
                    if (fragment) {
                        tableCard.innerHTML = fragment.innerHTML;
                    } else {
                        tableCard.innerHTML = html;
                    }
                    window.history.pushState({ url }, '', url);
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    hideLoading();
                });
        }

        /* --- Pagination via event delegation --- */

        wrapper.addEventListener('click', function (e) {
            const link = e.target.closest('.pagination-number, .pagination-arrow');
            if (!link) return;

            e.preventDefault();

            if (link.classList.contains('disabled')) return;

            const url = link.getAttribute('href');
            if (!url) return;

            loadTable(url);
        });

        /* --- Filter form via AJAX --- */

        const filterForm = document.querySelector('.filter-form');
        if (filterForm) {
            filterForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const data = new FormData(filterForm);
                const params = new URLSearchParams();

                for (const [key, value] of data.entries()) {
                    if (value !== '') params.append(key, value);
                }

                const url = filterForm.action + (params.toString() ? '?' + params.toString() : '');

                loadTable(url);
            });
        }
    })();
</script>
@endpush
