@extends('layouts.app')
@section('title', 'Search Donors')

@section('content')

<style>
    .donor-search-page {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .search-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .search-title {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .search-icon {
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

    .search-title h4 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .search-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    /* Search panel */
    .search-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 26px;
    }

    .filter-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .filter-heading i {
        color: #dc2626;
    }

    .filter-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .filter-control {
        height: 42px;
        border-radius: 9px;
        border: 1px solid #dbe2ea;
        font-size: 13px;
        box-shadow: none !important;
    }

    .filter-control:focus {
        border-color: #fca5a5;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .08) !important;
    }

    .search-btn {
        height: 42px;
        border-radius: 9px;
        background: #dc2626;
        border-color: #dc2626;
        font-size: 13px;
        font-weight: 600;
    }

    .search-btn:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    /* Results header */
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .results-title {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
    }

    .results-count {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 6px 10px;
        border-radius: 7px;
    }

    /* Donor card */
    .donor-card {
        height: 100%;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 19px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        display: flex;
        flex-direction: column;
    }

    .donor-card:hover {
        transform: translateY(-2px);
        border-color: #fecaca;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .07);
    }

    .donor-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .donor-avatar {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        border-radius: 13px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .donor-name {
        font-size: 14px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 6px;
    }

    .blood-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 4px 7px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
    }

    .donor-badge {
        display: inline-flex;
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 4px 7px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 3px;
    }

    .donor-info {
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        margin-bottom: 17px;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 11px;
        margin-bottom: 8px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-row i {
        width: 18px;
        color: #94a3b8;
        text-align: center;
    }

    .request-btn {
        margin-top: auto;
        width: 100%;
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .request-btn:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    /* Empty state */
    .empty-state {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 55px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 15px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        font-size: 22px;
    }

    .empty-state h6 {
        color: #334155;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    /* Pagination (styled identically to admin/users/index.blade.php) */
    .users-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 24px;
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

    @media (max-width: 576px) {
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

    /* Mobile */
    @media (max-width: 768px) {
        .search-header {
            align-items: flex-start;
        }

        .search-panel {
            padding: 16px;
        }

        .donor-card {
            padding: 16px;
        }
    }
</style>


<div class="donor-search-page">

    <!-- Header -->
    <div class="search-header">

        <div class="search-title">

            <div class="search-icon">
                <i class="bi bi-search"></i>
            </div>

            <div>
                <h4>Search Donors</h4>
                <p>Find eligible blood donors near you</p>
            </div>

        </div>

    </div>


    <!-- Search Filters -->
    <div class="search-panel">

        <div class="filter-heading">
            <i class="bi bi-sliders"></i>
            Find a compatible donor
        </div>

        <form method="GET">

            <div class="row g-3 align-items-end">

                <!-- Blood Group -->
                <div class="col-lg-3 col-md-6">

                    <label class="filter-label">
                        Blood Group
                    </label>

                    <select
                        name="blood_group_id"
                        class="form-select filter-control"
                    >
                        <option value="">All Blood Groups</option>

                        @foreach ($bloodGroups as $bg)

                            <option
                                value="{{ $bg->id }}"
                                @selected(request('blood_group_id') == $bg->id)
                            >
                                {{ $bg->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- City -->
                <div class="col-lg-3 col-md-6">

                    <label class="filter-label">
                        City
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-geo-alt text-muted"></i>
                        </span>

                        <input
                            name="city"
                            value="{{ request('city') }}"
                            class="form-control filter-control border-start-0"
                            placeholder="Enter city"
                        >

                    </div>

                </div>


                <!-- State -->
                <div class="col-lg-3 col-md-6">

                    <label class="filter-label">
                        State
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-map text-muted"></i>
                        </span>

                        <input
                            name="state"
                            value="{{ request('state') }}"
                            class="form-control filter-control border-start-0"
                            placeholder="Enter state"
                        >

                    </div>

                </div>


                <!-- Search -->
                <div class="col-lg-3 col-md-6">

                    <button class="btn btn-primary search-btn w-100">
                        <i class="bi bi-search me-2"></i>
                        Search Donors
                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- Results -->
    @if ($donors->total() > 0)

        <div class="results-header">

            <div class="results-title">
                Available Donors
            </div>

            <div class="results-count">
                {{ $donors->total() }}
                {{ $donors->total() == 1 ? 'Donor' : 'Donors' }}
            </div>

        </div>

    @endif


    <!-- Donor Cards -->
    <div class="row g-3">

        @forelse ($donors as $donor)

            <div class="col-xl-4 col-md-6">

                <div class="donor-card">

                    <!-- Donor Header -->
                    <div class="donor-top">

                        <div class="donor-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div>

                            <div class="donor-name">
                                {{ $donor->user->name }}
                            </div>

                            <span class="blood-badge">
                                <i class="bi bi-droplet-fill"></i>
                                {{ $donor->bloodGroup->name }}
                            </span>

                            @if ($donor->current_badge)

                                <span class="donor-badge">
                                    <i class="bi bi-award me-1"></i>
                                    {{ $donor->current_badge }}
                                </span>

                            @endif

                        </div>

                    </div>


                    <!-- Donor Information -->
                    <div class="donor-info">

                        <div class="info-row">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>
                                {{ $donor->city }}, {{ $donor->state }}
                            </span>
                        </div>

                        <div class="info-row">
                            <i class="bi bi-heart-pulse-fill"></i>
                            <span>
                                {{ $donor->total_donations }} donation{{ $donor->total_donations == 1 ? '' : 's' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <i class="bi bi-calendar2-check-fill"></i>
                            <span>
                                {{ $donor->age() }} years old
                            </span>
                        </div>

                        <div class="info-row">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>
                                Available donor
                            </span>
                        </div>

                    </div>


                    <!-- Request -->
                    <a
                        href="{{ route('patient.requests.create', $donor) }}"
                        class="btn request-btn"
                    >
                        <i class="bi bi-heart-pulse me-1"></i>
                        Request Blood
                    </a>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <h6>No eligible donors found</h6>

                    <p>
                        No donors match your current search.
                        Try widening your blood group, city, or state filters.
                    </p>

                </div>

            </div>

        @endforelse

    </div>


    <!-- Pagination (styled identically to admin/users/index.blade.php) -->
    @if ($donors->hasPages())

        <div class="users-pagination">

            <div class="custom-pagination">

                {{-- Previous --}}
                @if ($donors->onFirstPage())

                    <span class="pagination-arrow disabled">
                        <i class="bi bi-chevron-left"></i>
                    </span>

                @else

                    <a
                        href="{{ $donors->previousPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Previous page"
                    >
                        <i class="bi bi-chevron-left"></i>
                    </a>

                @endif


                {{-- Page Numbers --}}
                @foreach ($donors->getUrlRange(
                    max(1, $donors->currentPage() - 2),
                    min($donors->lastPage(), $donors->currentPage() + 2)
                ) as $page => $url)

                    @if ($page == $donors->currentPage())

                        <span class="pagination-number active">
                            {{ $page }}
                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="pagination-number"
                        >
                            {{ $page }}
                        </a>

                    @endif

                @endforeach


                {{-- Next --}}
                @if ($donors->hasMorePages())

                    <a
                        href="{{ $donors->nextPageUrl() }}"
                        class="pagination-arrow"
                        aria-label="Next page"
                    >
                        <i class="bi bi-chevron-right"></i>
                    </a>

                @else

                    <span class="pagination-arrow disabled">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                @endif

            </div>

        </div>

    @endif

</div>

@endsection