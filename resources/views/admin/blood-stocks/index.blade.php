@extends('layouts.app')

@section('title', 'Blood Inventory')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Inventory Statistics
    |--------------------------------------------------------------------------
    */

    $totalBloodGroups = $stocks->count();

    $totalUnits = $stocks->sum('units');

    $sufficientStock = $stocks->where('status', 'Sufficient')->count();

    $lowStock = $stocks->where('status', 'Low')->count();

    $outOfStock = $stocks->filter(function ($stock) {
        return $stock->units <= 0 || $stock->status === 'Critical';
    })->count();
@endphp


<style>
    /* =========================================================
       BLOOD LINK - BLOOD INVENTORY
       ========================================================= */

    .inventory-page {
        background: #f8fafc;
        min-height: calc(100vh - 70px);
        padding: 28px;
    }


    /* =========================================================
       PAGE HEADER
       ========================================================= */

    .inventory-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .inventory-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .inventory-title-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #ffe8ed;
        color: #e51e3f;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 25px;
        flex-shrink: 0;
    }

    .inventory-title h1 {
        margin: 0;
        color: #111827;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .inventory-title p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .add-stock-button {
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

    .add-stock-button:hover {
        background: #c91836;
        color: #fff;
        transform: translateY(-1px);
    }


    /* =========================================================
       STATISTICS CARDS
       ========================================================= */

    .inventory-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .inventory-stat {
        min-height: 98px;

        background: #fff;

        border: 1px solid #edf0f4;
        border-radius: 16px;

        padding: 15px;

        display: flex;
        align-items: center;
        gap: 13px;

        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);

        transition: all .2s ease;
    }

    .inventory-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(15, 23, 42, .07);
    }

    .inventory-stat-icon {
        width: 48px;
        height: 48px;

        border-radius: 14px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 21px;

        flex-shrink: 0;
    }

    .inventory-stat.red .inventory-stat-icon {
        background: #ffe4e9;
        color: #e51e3f;
    }

    .inventory-stat.blue .inventory-stat-icon {
        background: #e3efff;
        color: #2877e8;
    }

    .inventory-stat.green .inventory-stat-icon {
        background: #ddf7e9;
        color: #13a568;
    }

    .inventory-stat.orange .inventory-stat-icon {
        background: #fff0d8;
        color: #e79a17;
    }

    .inventory-stat.purple .inventory-stat-icon {
        background: #eee6ff;
        color: #7651d8;
    }

    .inventory-stat-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 5px;
        white-space: nowrap;
    }

    .inventory-stat-value {
        color: #111827;
        font-size: 23px;
        line-height: 1;
        font-weight: 800;
    }


    /* =========================================================
       FILTER / SEARCH CARD
       ========================================================= */

    .inventory-filter {
        background: #fff;

        border: 1px solid #edf0f4;
        border-radius: 17px;

        padding: 20px;

        margin-bottom: 18px;

        box-shadow: 0 5px 18px rgba(15, 23, 42, .035);
    }

    .inventory-filter-form {
        display: grid;
        grid-template-columns: 1.6fr 1fr 130px;
        gap: 13px;
        align-items: end;
    }

    .inventory-filter-label {
        display: block;

        color: #172033;

        font-size: 12px;
        font-weight: 700;

        margin-bottom: 7px;
    }

    .inventory-input-wrapper {
        position: relative;
    }

    .inventory-input-wrapper i {
        position: absolute;

        left: 14px;
        top: 50%;

        transform: translateY(-50%);

        color: #94a3b8;

        font-size: 14px;

        z-index: 2;
    }

    .inventory-input,
    .inventory-select {
        width: 100%;
        height: 43px;

        border: 1px solid #e2e8f0;
        border-radius: 11px;

        background: #fff;

        color: #334155;

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }

    .inventory-input {
        padding: 0 13px 0 39px;
    }

    .inventory-select {
        padding: 0 13px;
    }

    .inventory-input:focus,
    .inventory-select:focus {
        border-color: #f25a70;

        box-shadow:
            0 0 0 3px rgba(225, 29, 72, .07);
    }

    .inventory-filter-button {
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

    .inventory-filter-button:hover {
        background: #e51e3f;
        color: #fff;
    }


    /* =========================================================
       TABLE CARD
       ========================================================= */

    .inventory-table-card {
        background: #fff;

        border: 1px solid #edf0f4;
        border-radius: 17px;

        overflow: hidden;

        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .inventory-table-scroll {
        overflow-x: auto;
    }

    .inventory-table {
        width: 100%;
        min-width: 900px;

        border-collapse: collapse;

        margin: 0;
    }

    .inventory-table thead {
        background: #f8fafc;
    }

    .inventory-table th {
        padding: 15px 20px;

        border-bottom: 1px solid #edf0f4;

        color: #64748b;

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;

        letter-spacing: .3px;

        white-space: nowrap;

        text-align: left;
    }

    .inventory-table td {
        padding: 12px 20px;

        border-bottom: 1px solid #f1f5f9;

        color: #172033;

        font-size: 13px;

        white-space: nowrap;

        vertical-align: middle;
    }

    .inventory-table tbody tr {
        transition: background .18s ease;
    }

    .inventory-table tbody tr:hover {
        background: #fff8f9;
    }

    .inventory-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* =========================================================
       BLOOD GROUP CELL
       ========================================================= */

    .inventory-blood-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .inventory-blood-icon {
        width: 38px;
        height: 38px;

        border-radius: 50%;

        background: #ffe9ed;

        color: #e51e3f;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 15px;

        flex-shrink: 0;
    }

    .inventory-blood-name {
        font-size: 14px;
        font-weight: 800;
        color: #111827;
    }


    /* =========================================================
       UNITS
       ========================================================= */

    .inventory-units {
        font-size: 14px;
        font-weight: 650;
        color: #172033;
    }


    /* =========================================================
       STATUS BADGES
       ========================================================= */

    .inventory-status {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 6px 12px;

        border-radius: 20px;

        font-size: 10px;
        font-weight: 800;

        line-height: 1;
    }

    .inventory-status-sufficient {
        background: #dcf7e8;
        color: #12945b;
    }

    .inventory-status-low {
        background: #fff0d5;
        color: #b9780c;
    }

    .inventory-status-critical {
        background: #ffe1e5;
        color: #d9243f;
    }

    .inventory-status-default {
        background: #eef2f7;
        color: #64748b;
    }


    /* =========================================================
       LAST UPDATED
       ========================================================= */

    .inventory-updated {
        color: #475569;
        font-size: 12px;
    }


    /* =========================================================
       ACTIONS
       ========================================================= */

    .inventory-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .inventory-update-form {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .inventory-unit-input {
        width: 92px;
        height: 36px;

        border: 1px solid #e2e8f0;

        border-radius: 10px;

        background: #fff;

        padding: 0 10px;

        color: #334155;

        font-size: 12px;

        outline: none;
    }

    .inventory-unit-input:focus {
        border-color: #f25a70;

        box-shadow:
            0 0 0 3px rgba(225, 29, 72, .06);
    }

    .inventory-update-button {
        height: 36px;

        padding: 0 13px;

        border: 1px solid #ffb7c4;

        border-radius: 10px;

        background: #fff;

        color: #e51e3f;

        font-size: 12px;

        font-weight: 700;

        transition: .2s ease;
    }

    .inventory-update-button:hover {
        background: #ffe8ed;
        color: #c91836;
    }

    .inventory-delete-button {
        width: 36px;
        height: 36px;

        border: 1px solid #ffb7c4;

        border-radius: 10px;

        background: #fff;

        color: #e51e3f;

        display: inline-flex;

        align-items: center;
        justify-content: center;

        transition: .2s ease;
    }

    .inventory-delete-button:hover {
        background: #ffe8ed;
        color: #c91836;
    }


    /* =========================================================
       TABLE FOOTER
       ========================================================= */

    .inventory-footer {
        display: flex;

        align-items: center;
        justify-content: space-between;

        padding: 15px 20px;

        border-top: 1px solid #edf0f4;

        gap: 15px;
    }

    .inventory-count {
        color: #64748b;

        font-size: 12px;
    }

    .inventory-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .inventory-page-button {
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

    .inventory-page-button:hover {
        background: #ffe8ed;
        color: #e51e3f;
    }

    .inventory-page-button.active {
        background: #e51e3f;
        color: #fff;

        box-shadow:
            0 4px 10px rgba(229, 30, 63, .2);
    }

    .inventory-page-button.disabled {
        color: #cbd5e1;

        pointer-events: none;
    }


    /* =========================================================
       MODAL
       ========================================================= */

    .inventory-modal .modal-content {
        border: 0;

        border-radius: 18px;

        overflow: hidden;

        box-shadow:
            0 20px 50px rgba(15, 23, 42, .18);
    }

    .inventory-modal .modal-header {
        padding: 20px 22px;

        border-bottom: 1px solid #f1f5f9;
    }

    .inventory-modal .modal-title {
        color: #172033;

        font-size: 18px;
        font-weight: 800;
    }

    .inventory-modal .modal-body {
        padding: 22px;
    }

    .inventory-modal .modal-footer {
        padding: 16px 22px;

        border-top: 1px solid #f1f5f9;
    }

    .inventory-modal .form-label {
        color: #334155;

        font-size: 12px;
        font-weight: 700;
    }

    .inventory-modal .form-control,
    .inventory-modal .form-select {
        min-height: 43px;

        border: 1px solid #e2e8f0;

        border-radius: 10px;

        font-size: 13px;
    }

    .inventory-modal .form-control:focus,
    .inventory-modal .form-select:focus {
        border-color: #f25a70;

        box-shadow:
            0 0 0 3px rgba(225, 29, 72, .07);
    }

    .inventory-modal-add {
        border: 0;

        border-radius: 10px;

        background: #e51e3f;

        color: #fff;

        padding: 10px 18px;

        font-size: 13px;

        font-weight: 700;
    }

    .inventory-modal-add:hover {
        background: #c91836;
        color: #fff;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 1200px) {

        .inventory-stats {
            grid-template-columns: repeat(3, 1fr);
        }

    }

    @media (max-width: 900px) {

        .inventory-filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .inventory-filter-button {
            grid-column: span 2;
        }

    }

    @media (max-width: 768px) {

        .inventory-page {
            padding: 16px;
        }

        .inventory-header {
            align-items: flex-start;
        }

        .inventory-title h1 {
            font-size: 23px;
        }

        .inventory-title-icon {
            width: 48px;
            height: 48px;
            font-size: 21px;
        }

        .inventory-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .inventory-filter-form {
            grid-template-columns: 1fr;
        }

        .inventory-filter-button {
            grid-column: auto;
        }

        .inventory-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .inventory-pagination {
            width: 100%;
            justify-content: center;
        }

    }

    @media (max-width: 480px) {

        .inventory-header {
            flex-direction: column;
        }

        .add-stock-button {
            width: 100%;
        }

        .inventory-stats {
            grid-template-columns: 1fr;
        }

    }
</style>


<div class="inventory-page">

    {{-- =====================================================
         PAGE HEADER
         ===================================================== --}}

    <div class="inventory-header">

        <div class="inventory-title">

            <div class="inventory-title-icon">
                <i class="bi bi-boxes"></i>
            </div>

            <div>

                <h1>
                    Blood Inventory
                </h1>

                <p>
                    Manage blood stock and availability
                </p>

            </div>

        </div>


        <button
            type="button"
            class="add-stock-button"
            data-bs-toggle="modal"
            data-bs-target="#addStockModal"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Stock Entry
        </button>

    </div>


    {{-- =====================================================
         STATISTICS
         ===================================================== --}}

    <div class="inventory-stats">

        {{-- Total Blood Groups --}}

        <div class="inventory-stat red">

            <div class="inventory-stat-icon">
                <i class="bi bi-droplet-fill"></i>
            </div>

            <div>

                <div class="inventory-stat-label">
                    Total Blood Groups
                </div>

                <div class="inventory-stat-value">
                    {{ $totalBloodGroups }}
                </div>

            </div>

        </div>


        {{-- Total Units --}}

        <div class="inventory-stat blue">

            <div class="inventory-stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>

                <div class="inventory-stat-label">
                    Total Units
                </div>

                <div class="inventory-stat-value">
                    {{ $totalUnits }}
                </div>

            </div>

        </div>


        {{-- Sufficient --}}

        <div class="inventory-stat green">

            <div class="inventory-stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>

            <div>

                <div class="inventory-stat-label">
                    Sufficient Stock
                </div>

                <div class="inventory-stat-value">
                    {{ $sufficientStock }}
                </div>

            </div>

        </div>


        {{-- Low --}}

        <div class="inventory-stat orange">

            <div class="inventory-stat-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div>

                <div class="inventory-stat-label">
                    Low Stock
                </div>

                <div class="inventory-stat-value">
                    {{ $lowStock }}
                </div>

            </div>

        </div>


        {{-- Out of Stock --}}

        <div class="inventory-stat purple">

            <div class="inventory-stat-icon">
                <i class="bi bi-x-circle"></i>
            </div>

            <div>

                <div class="inventory-stat-label">
                    Out of Stock
                </div>

                <div class="inventory-stat-value">
                    {{ $outOfStock }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SEARCH / FILTER
         ===================================================== --}}

    <div class="inventory-filter">

        <form
            method="GET"
            action="{{ route('admin.blood-stocks.index') }}"
            class="inventory-filter-form"
        >

            <div>

                <label class="inventory-filter-label">
                    Search
                </label>

                <div class="inventory-input-wrapper">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="inventory-input"
                        placeholder="Search blood group..."
                    >

                </div>

            </div>


            <div>

                <label class="inventory-filter-label">
                    Status
                </label>

                <select
                    name="status"
                    class="inventory-select"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="Sufficient"
                        @selected(request('status') === 'Sufficient')
                    >
                        Sufficient
                    </option>

                    <option
                        value="Low"
                        @selected(request('status') === 'Low')
                    >
                        Low
                    </option>

                    <option
                        value="Critical"
                        @selected(request('status') === 'Critical')
                    >
                        Critical
                    </option>

                </select>

            </div>


            <div>

                <label
                    class="inventory-filter-label"
                    style="visibility:hidden;"
                >
                    Filter
                </label>

                <button
                    type="submit"
                    class="inventory-filter-button"
                >
                    <i class="bi bi-funnel me-1"></i>
                    Filter
                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         INVENTORY TABLE
         ===================================================== --}}

    <div class="inventory-table-card">

        <div class="inventory-table-scroll">

            <table class="inventory-table">

                <thead>

                    <tr>

                        <th>
                            Blood Group
                        </th>

                        <th>
                            Units Available
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Last Updated
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($stocks as $stock)

                        @php

                            $statusClass = match($stock->status) {

                                'Sufficient' =>
                                    'inventory-status-sufficient',

                                'Low' =>
                                    'inventory-status-low',

                                'Critical' =>
                                    'inventory-status-critical',

                                default =>
                                    'inventory-status-default'

                            };

                        @endphp


                        <tr>

                            {{-- Blood Group --}}

                            <td>

                                <div class="inventory-blood-cell">

                                    <div class="inventory-blood-icon">
                                        <i class="bi bi-droplet"></i>
                                    </div>

                                    <span class="inventory-blood-name">
                                        {{ $stock->bloodGroup->name }}
                                    </span>

                                </div>

                            </td>


                            {{-- Units --}}

                            <td>

                                <span class="inventory-units">
                                    {{ $stock->units }} Units
                                </span>

                            </td>


                            {{-- Status --}}

                            <td>

                                <span class="inventory-status {{ $statusClass }}">

                                    @if($stock->status === 'Sufficient')
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                    @elseif($stock->status === 'Low')
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    @elseif($stock->status === 'Critical')
                                        <i class="bi bi-x-circle-fill me-1"></i>
                                    @endif

                                    {{ $stock->status }}

                                </span>

                            </td>


                            {{-- Last Updated --}}

                            <td>

                                <span class="inventory-updated">

                                    @if($stock->updated_at)

                                        {{ $stock->updated_at->format('d M Y, h:i A') }}

                                    @else

                                        —

                                    @endif

                                </span>

                            </td>


                            {{-- Actions --}}

                            <td>

                                <div class="inventory-actions">

                                    <form
                                        action="{{ route('admin.blood-stocks.update', $stock) }}"
                                        method="POST"
                                        class="inventory-update-form"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="number"
                                            name="units"
                                            value="{{ $stock->units }}"
                                            min="0"
                                            class="inventory-unit-input"
                                            aria-label="Units"
                                        >

                                        <button
                                            type="submit"
                                            class="inventory-update-button"
                                        >
                                            <i class="bi bi-pencil me-1"></i>
                                            Update
                                        </button>

                                    </form>


                                    <form
                                        action="{{ route('admin.blood-stocks.destroy', $stock) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Remove this stock entry?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inventory-delete-button"
                                            title="Delete stock"
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
                                colspan="5"
                                class="text-center py-5"
                            >

                                <i
                                    class="bi bi-box-seam fs-1 text-muted d-block mb-2"
                                ></i>

                                <span class="text-muted">
                                    No stock entries yet.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER
             ================================================= --}}

        <div class="inventory-footer">

            <div class="inventory-count">

                Showing
                <strong>{{ $stocks->count() }}</strong>
                of
                <strong>{{ $stocks->count() }}</strong>
                inventory entries

            </div>


            <div class="inventory-pagination">

                <span class="inventory-page-button disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>

                <span class="inventory-page-button active">
                    1
                </span>

                <span class="inventory-page-button disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     ADD STOCK MODAL
     ========================================================= --}}

<div
    class="modal fade inventory-modal"
    id="addStockModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.blood-stocks.store') }}"
                method="POST"
            >

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-box-seam text-danger me-2"></i>

                        Add Stock Entry

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
                            Blood Group
                        </label>

                        <select
                            name="blood_group_id"
                            class="form-select"
                            required
                        >

                            @foreach(
                                \App\Models\BloodGroup::where(
                                    'status',
                                    'Active'
                                )->orderBy('name')->get()
                                as $bg
                            )

                                <option value="{{ $bg->id }}">
                                    {{ $bg->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="form-label">
                            Units
                        </label>

                        <input
                            type="number"
                            name="units"
                            min="0"
                            class="form-control"
                            required
                            placeholder="Enter available units"
                        >

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
                        class="inventory-modal-add"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Add Stock
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection