@extends('layouts.app')

@section('title', 'Blood Groups')

@section('content')

<style>
    /* =========================================================
       BLOOD LINK - BLOOD GROUP MANAGEMENT
       ========================================================= */

    .blood-groups-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }

    /* =========================================================
       PAGE HEADER
       ========================================================= */

    .blood-groups-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 20px;
    }

    .blood-groups-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .blood-groups-title-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #ffe8ed;
        color: #e51e3f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .blood-groups-title h1 {
        margin: 0;
        font-size: 29px;
        font-weight: 800;
        color: #111827;
        letter-spacing: -.5px;
    }

    .blood-groups-title p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .add-blood-button {
        height: 43px;
        padding: 0 18px;
        border: 0;
        border-radius: 11px;
        background: #e51e3f;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 6px 15px rgba(229, 30, 63, .18);
        transition: all .2s ease;
    }

    .add-blood-button:hover {
        background: #c91836;
        color: #fff;
        transform: translateY(-1px);
    }

    /* =========================================================
       STATISTICS
       ========================================================= */

    .blood-stats {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .blood-stat-card {
        min-height: 96px;
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 16px;
        padding: 14px 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
        transition: all .2s ease;
    }

    .blood-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 25px rgba(15, 23, 42, .07);
    }

    .blood-stat-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .stat-red .blood-stat-icon {
        background: #ffe3e8;
        color: #e51e3f;
    }

    .stat-green .blood-stat-icon {
        background: #def7e8;
        color: #14a568;
    }

    .stat-blue .blood-stat-icon {
        background: #e0edff;
        color: #2775e8;
    }

    .stat-orange .blood-stat-icon {
        background: #fff0d9;
        color: #e59a18;
    }

    .stat-purple .blood-stat-icon {
        background: #eee6ff;
        color: #7650d9;
    }

    .stat-pink .blood-stat-icon {
        background: #ffe6ed;
        color: #e84567;
    }

    .blood-stat-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 4px;
        white-space: nowrap;
    }

    .blood-stat-value {
        color: #111827;
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
    }

    /* =========================================================
       FILTER CARD
       ========================================================= */

    .blood-filter-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        padding: 20px;
        margin-bottom: 18px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
    }

    .blood-filter-form {
        display: grid;
        grid-template-columns: 1.7fr 1fr 160px;
        gap: 13px;
        align-items: end;
    }

    .filter-label {
        display: block;
        margin-bottom: 7px;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
    }

    .blood-input-wrapper {
        position: relative;
    }

    .blood-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        z-index: 2;
    }

    .blood-filter-control {
        width: 100%;
        height: 43px;
        border: 1px solid #e2e8f0;
        background: #fff;
        border-radius: 11px;
        color: #334155;
        padding: 0 13px;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .blood-filter-control.search-control {
        padding-left: 39px;
    }

    .blood-filter-control:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, .07);
    }

    .blood-filter-button {
        height: 43px;
        width: 100%;
        border: 1px solid #e51e3f;
        border-radius: 11px;
        background: #fff;
        color: #e51e3f;
        font-size: 13px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .blood-filter-button:hover {
        background: #e51e3f;
        color: #fff;
    }

    /* =========================================================
       TABLE CARD
       ========================================================= */

    .blood-table-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .blood-table-scroll {
        overflow-x: auto;
    }

    .blood-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        margin: 0;
    }

    .blood-table thead {
        background: #f8fafc;
    }

    .blood-table th {
        padding: 15px 16px;
        border-bottom: 1px solid #edf0f4;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .3px;
        white-space: nowrap;
        text-align: left;
    }

    .blood-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #172033;
        font-size: 13px;
        white-space: nowrap;
        vertical-align: middle;
    }

    .blood-table tbody tr {
        transition: background .18s ease;
    }

    .blood-table tbody tr:hover {
        background: #fff8f9;
    }

    .blood-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .blood-group-name {
        font-size: 14px;
        font-weight: 800;
        color: #111827;
    }

    .blood-description {
        color: #334155;
    }

    .blood-number {
        font-weight: 600;
        color: #334155;
    }

    .blood-stock {
        font-weight: 700;
        color: #172033;
    }

    /* =========================================================
       STATUS
       ========================================================= */

    .blood-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1;
    }

    .blood-status-active {
        background: #dff7e9;
        color: #12a564;
    }

    .blood-status-inactive {
        background: #eef2f7;
        color: #64748b;
    }

    /* =========================================================
       ACTION BUTTONS
       ========================================================= */

    .blood-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .blood-action {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all .2s ease;
    }

    .blood-action-edit {
        border: 1px solid #ffb7c4;
        color: #e51e3f;
    }

    .blood-action-edit:hover {
        background: #ffe8ed;
        color: #c91836;
    }

    .blood-action-pause {
        border: 1px solid #f5cf69;
        color: #e8a600;
    }

    .blood-action-pause:hover {
        background: #fff6dc;
    }

    .blood-action-play {
        border: 1px solid #9bdab9;
        color: #159b60;
    }

    .blood-action-play:hover {
        background: #eaf9f0;
    }

    .blood-action-delete {
        border: 1px solid #ffb7c4;
        color: #e51e3f;
    }

    .blood-action-delete:hover {
        background: #ffe8ed;
    }

    /* =========================================================
       TABLE FOOTER
       ========================================================= */

    .blood-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        border-top: 1px solid #edf0f4;
        gap: 15px;
    }

    .blood-count {
        color: #64748b;
        font-size: 12px;
    }

    .blood-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .blood-page-button {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: 0;
        background: transparent;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .blood-page-button:hover {
        background: #ffe8ed;
        color: #e51e3f;
    }

    .blood-page-button.active {
        background: #e51e3f;
        color: #fff;
        box-shadow: 0 4px 10px rgba(229, 30, 63, .2);
    }

    .blood-page-button.disabled {
        color: #cbd5e1;
        pointer-events: none;
    }

    /* =========================================================
       MODAL
       ========================================================= */

    .blood-modal .modal-content {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .18);
    }

    .blood-modal .modal-header {
        padding: 20px 22px;
        border-bottom: 1px solid #f1f5f9;
    }

    .blood-modal .modal-title {
        font-size: 18px;
        font-weight: 800;
        color: #172033;
    }

    .blood-modal .modal-body {
        padding: 22px;
    }

    .blood-modal .modal-footer {
        padding: 16px 22px;
        border-top: 1px solid #f1f5f9;
    }

    .blood-modal .form-label {
        color: #334155;
        font-size: 12px;
        font-weight: 700;
    }

    .blood-modal .form-control,
    .blood-modal .form-select {
        min-height: 43px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
    }

    .blood-modal .form-control:focus,
    .blood-modal .form-select:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, .07);
    }

    .modal-save-button {
        border: 0;
        border-radius: 10px;
        background: #e51e3f;
        color: #fff;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
    }

    .modal-save-button:hover {
        background: #c91836;
        color: #fff;
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1400px) {

        .blood-stats {
            grid-template-columns: repeat(3, 1fr);
        }

    }

    @media (max-width: 1000px) {

        .blood-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .blood-filter-button {
            grid-column: span 2;
        }

    }

    @media (max-width: 768px) {

        .blood-groups-page {
            padding: 16px;
        }

        .blood-groups-header {
            align-items: flex-start;
        }

        .blood-groups-title h1 {
            font-size: 23px;
        }

        .blood-groups-title-icon {
            width: 48px;
            height: 48px;
            font-size: 21px;
        }

        .blood-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .blood-filter-form {
            grid-template-columns: 1fr;
        }

        .blood-filter-button {
            grid-column: auto;
        }

        .blood-table-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .blood-pagination {
            width: 100%;
            justify-content: center;
        }

    }

    @media (max-width: 480px) {

        .blood-groups-header {
            flex-direction: column;
        }

        .add-blood-button {
            width: 100%;
        }

        .blood-stats {
            grid-template-columns: 1fr;
        }

    }
</style>


<div class="blood-groups-page">

    {{-- =====================================================
         PAGE HEADER
         ===================================================== --}}

    <div class="blood-groups-header">

        <div class="blood-groups-title">

            <div class="blood-groups-title-icon">
                <i class="bi bi-droplet-fill"></i>
            </div>

            <div>

                <h1>
                    Blood Group Management
                </h1>

                <p>
                    Manage blood groups and their availability
                </p>

            </div>

        </div>


        <button
            type="button"
            class="add-blood-button"
            data-bs-toggle="modal"
            data-bs-target="#addModal"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Blood Group
        </button>

    </div>


    {{-- =====================================================
         STATISTICS
         ===================================================== --}}

    <div class="blood-stats">

        {{-- Total --}}

        <div class="blood-stat-card stat-red">

            <div class="blood-stat-icon">
                <i class="bi bi-droplet-fill"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Total
                </div>

                <div class="blood-stat-value">
                    {{ $stats['total'] }}
                </div>

            </div>

        </div>


        {{-- Active --}}

        <div class="blood-stat-card stat-green">

            <div class="blood-stat-icon">
                <i class="bi bi-activity"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Active
                </div>

                <div class="blood-stat-value">
                    {{ $stats['active'] }}
                </div>

            </div>

        </div>


        {{-- Inactive --}}

        <div class="blood-stat-card stat-blue">

            <div class="blood-stat-icon">
                <i class="bi bi-pause-fill"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Inactive
                </div>

                <div class="blood-stat-value">
                    {{ $stats['inactive'] }}
                </div>

            </div>

        </div>


        {{-- Most Requested --}}

        <div class="blood-stat-card stat-orange">

            <div class="blood-stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Most Requested
                </div>

                <div class="blood-stat-value">
                    {{ $stats['most_requested']->name ?? '-' }}
                </div>

            </div>

        </div>


        {{-- Highest Stock --}}

        <div class="blood-stat-card stat-purple">

            <div class="blood-stat-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Highest Stock
                </div>

                <div class="blood-stat-value">
                    {{ $stats['highest_stock']->name ?? '-' }}
                </div>

            </div>

        </div>


        {{-- Lowest Stock --}}

        <div class="blood-stat-card stat-pink">

            <div class="blood-stat-icon">
                <i class="bi bi-graph-down-arrow"></i>
            </div>

            <div>

                <div class="blood-stat-label">
                    Lowest Stock
                </div>

                <div class="blood-stat-value">
                    {{ $stats['lowest_stock']->name ?? '-' }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SEARCH / FILTER
         ===================================================== --}}

    <div class="blood-filter-card">

        <form
            method="GET"
            action="{{ route('admin.blood-groups.index') }}"
            class="blood-filter-form"
        >

            {{-- Search --}}

            <div>

                <label class="filter-label">
                    Search
                </label>

                <div class="blood-input-wrapper">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="blood-filter-control search-control"
                        placeholder="Search name or description..."
                    >

                </div>

            </div>


            {{-- Status --}}

            <div>

                <label class="filter-label">
                    Status
                </label>

                <select
                    name="status"
                    class="blood-filter-control"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="Active"
                        @selected(request('status') === 'Active')
                    >
                        Active
                    </option>

                    <option
                        value="Inactive"
                        @selected(request('status') === 'Inactive')
                    >
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Filter --}}

            <div>

                <label
                    class="filter-label"
                    style="visibility:hidden;"
                >
                    Filter
                </label>

                <button
                    type="submit"
                    class="blood-filter-button"
                >
                    <i class="bi bi-funnel me-1"></i>
                    Filter
                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         BLOOD GROUP TABLE
         ===================================================== --}}

    <div class="blood-table-card">

        <div class="blood-table-scroll">

            <table class="blood-table">

                <thead>

                    <tr>

                        <th>
                            Blood Group
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Donors
                        </th>

                        <th>
                            Patients
                        </th>

                        <th>
                            Stock Units
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($bloodGroups as $bg)

                        <tr>

                            {{-- Blood Group --}}

                            <td>

                                <span class="blood-group-name">
                                    {{ $bg->name }}
                                </span>

                            </td>


                            {{-- Description --}}

                            <td>

                                <span class="blood-description">
                                    {{ $bg->description ?? '—' }}
                                </span>

                            </td>


                            {{-- Status --}}

                            <td>

                                @if($bg->status === 'Active')

                                    <span class="blood-status blood-status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="blood-status blood-status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Donors --}}

                            <td>

                                <span class="blood-number">
                                    {{ $bg->donors_count }}
                                </span>

                            </td>


                            {{-- Patients --}}

                            <td>

                                <span class="blood-number">
                                    {{ $bg->patients_count }}
                                </span>

                            </td>


                            {{-- Stock --}}

                            <td>

                                <span class="blood-stock">
                                    {{ $bg->bloodStock->units ?? 0 }}
                                </span>

                            </td>


                            {{-- Actions --}}

                            <td>

                                <div class="blood-actions">

                                    {{-- Edit --}}

                                    <button
                                        type="button"
                                        class="blood-action blood-action-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $bg->id }}"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>


                                    {{-- Activate / Deactivate --}}

                                    @if($bg->status === 'Active')

                                        <form
                                            action="{{ route('admin.blood-groups.deactivate', $bg) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="blood-action blood-action-pause"
                                                title="Deactivate"
                                            >
                                                <i class="bi bi-pause-fill"></i>
                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route('admin.blood-groups.activate', $bg) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="blood-action blood-action-play"
                                                title="Activate"
                                            >
                                                <i class="bi bi-play-fill"></i>
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Delete --}}

                                    <form
                                        action="{{ route('admin.blood-groups.destroy', $bg) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete this blood group?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="blood-action blood-action-delete"
                                            title="Delete"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-droplet fs-1 text-muted d-block mb-2"
                                ></i>

                                <span class="text-muted">
                                    No blood groups found.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             TABLE FOOTER / PAGINATION
             ================================================= --}}

        @if($bloodGroups->total() > 0)

            <div class="blood-table-footer">

                <div class="blood-count">

                    Showing
                    <strong>{{ $bloodGroups->firstItem() }}</strong>
                    to
                    <strong>{{ $bloodGroups->lastItem() }}</strong>
                    of
                    <strong>{{ $bloodGroups->total() }}</strong>
                    blood groups

                </div>


                <div class="blood-pagination">

                    {{-- Previous --}}

                    @if($bloodGroups->onFirstPage())

                        <span class="blood-page-button disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $bloodGroups->previousPageUrl() }}"
                            class="blood-page-button"
                            aria-label="Previous page"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>

                    @endif


                    {{-- Pages --}}

                    @foreach(
                        $bloodGroups->getUrlRange(
                            max(1, $bloodGroups->currentPage() - 2),
                            min($bloodGroups->lastPage(), $bloodGroups->currentPage() + 2)
                        )
                        as $page => $url
                    )

                        @if($page == $bloodGroups->currentPage())

                            <span class="blood-page-button active">
                                {{ $page }}
                            </span>

                        @else

                            <a
                                href="{{ $url }}"
                                class="blood-page-button"
                            >
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    {{-- Next --}}

                    @if($bloodGroups->hasMorePages())

                        <a
                            href="{{ $bloodGroups->nextPageUrl() }}"
                            class="blood-page-button"
                            aria-label="Next page"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    @else

                        <span class="blood-page-button disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     ADD BLOOD GROUP MODAL
     ========================================================= --}}

<div
    class="modal fade blood-modal"
    id="addModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.blood-groups.store') }}"
                method="POST"
            >

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-droplet-fill text-danger me-2"></i>
                        Add Blood Group
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Blood Group Name
                        </label>

                        <input
                            name="name"
                            maxlength="10"
                            class="form-control"
                            required
                            placeholder="e.g. A+"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Enter blood group description"
                        ></textarea>

                    </div>


                    <div>

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            <option value="Active">
                                Active
                            </option>

                            <option value="Inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="modal-save-button"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Create Blood Group
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     EDIT MODALS
     ========================================================= --}}

@foreach($bloodGroups as $bg)

    <div
        class="modal fade blood-modal"
        id="editModal{{ $bg->id }}"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <form
                    action="{{ route('admin.blood-groups.update', $bg) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')

                    <div class="modal-header">

                        <h5 class="modal-title">

                            <i class="bi bi-pencil-square text-danger me-2"></i>

                            Edit {{ $bg->name }}

                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>

                    </div>


                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Blood Group Name
                            </label>

                            <input
                                name="name"
                                value="{{ $bg->name }}"
                                maxlength="10"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                            >{{ $bg->description }}</textarea>

                        </div>


                        <div>

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                            >

                                <option
                                    value="Active"
                                    @selected($bg->status === 'Active')
                                >
                                    Active
                                </option>

                                <option
                                    value="Inactive"
                                    @selected($bg->status === 'Inactive')
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="modal-save-button"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endforeach

@endsection