@extends('layouts.app')
@section('title', 'Audit Log')

@section('content')

<style>
    .audit-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    .audit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .audit-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .audit-title-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .audit-title h4 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .audit-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    /* Filter */
    .audit-filter {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .audit-filter .form-label {
        color: #475569;
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .audit-filter .form-control,
    .audit-filter .form-select {
        min-height: 42px;
        border-radius: 9px;
        border-color: #dbe1e8;
        font-size: 14px;
    }

    .audit-filter .form-control:focus,
    .audit-filter .form-select:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, .08);
    }

    .audit-filter-btn {
        min-height: 42px;
        border: 0;
        border-radius: 9px;
        background: #dc2626;
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
    }

    .audit-filter-btn:hover {
        background: #b91c1c;
        color: #ffffff;
    }

    /* Table */
    .audit-table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .audit-table-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .audit-table-header h6 {
        margin: 0;
        font-weight: 700;
        color: #172033;
    }

    .audit-table-header span {
        font-size: 12px;
        color: #64748b;
    }

    .audit-table {
        margin: 0;
    }

    .audit-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .audit-table tbody td {
        padding: 15px 16px;
        color: #334155;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .audit-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .audit-table tbody tr:hover {
        background: #fffafa;
    }

    /* Time */
    .audit-time {
        white-space: nowrap;
    }

    .audit-time-main {
        font-weight: 600;
        color: #334155;
    }

    .audit-time-sub {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-top: 2px;
    }

    /* Action */
    .audit-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 50px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 11px;
        font-weight: 700;
    }

    /* Admin */
    .admin-info {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .admin-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .admin-name {
        font-weight: 600;
        color: #334155;
    }

    /* Model */
    .model-name {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 4px 8px;
        font-family: monospace;
        font-size: 11px;
        color: #475569;
    }

    /* ID */
    .model-id {
        font-family: monospace;
        font-size: 12px;
        color: #64748b;
    }

    /* Metadata */
    .metadata-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        max-width: 360px;
    }

    .metadata-item {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 6px;
        padding: 4px 7px;
        font-size: 10px;
    }

    .metadata-key {
        font-weight: 700;
        color: #334155;
    }

    /* Empty */
    .audit-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .audit-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #f8fafc;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .audit-empty strong {
        display: block;
        color: #475569;
        margin-bottom: 4px;
    }

    .audit-empty span {
        color: #94a3b8;
        font-size: 13px;
    }

    /* Pagination */
    .audit-pagination {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .audit-header {
            align-items: flex-start;
        }

        .audit-table-header {
            padding: 15px;
        }

        .audit-table thead th,
        .audit-table tbody td {
            padding: 12px;
        }
    }
</style>


<div class="audit-page">

    <!-- Header -->
    <div class="audit-header">

        <div class="audit-title">
            <div class="audit-title-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <div>
                <h4>Audit Log</h4>
                <p>Track administrative actions and system activity</p>
            </div>
        </div>

    </div>


    <!-- Filters -->
    <form class="audit-filter">

        <div class="row g-3 align-items-end">

            <div class="col-md-4 col-lg-3">

                <label class="form-label">
                    Action
                </label>

                <select name="action" class="form-select">

                    <option value="">All Actions</option>

                    @foreach ($actions as $a)
                        <option
                            value="{{ $a }}"
                            @selected(request('action') === $a)
                        >
                            {{ ucfirst($a) }}
                        </option>
                    @endforeach

                </select>

            </div>


            <div class="col-md-4 col-lg-3">

                <label class="form-label">
                    Model
                </label>

                <input
                    type="text"
                    name="model"
                    value="{{ request('model') }}"
                    class="form-control"
                    placeholder="e.g. BloodRequest"
                >

            </div>


            <div class="col-md-4 col-lg-3">

                <label class="form-label">
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="form-control"
                >

            </div>


            <div class="col-md-3 col-lg-2">

                <button class="btn audit-filter-btn w-100">
                    <i class="bi bi-funnel me-1"></i>
                    Filter
                </button>

            </div>

        </div>

    </form>


    <!-- Table -->
    <div class="audit-table-card">

        <div class="audit-table-header">

            <div>
                <h6>
                    <i class="bi bi-clock-history me-2"></i>
                    Activity History
                </h6>
            </div>

            <span>
                Administrative activity
            </span>

        </div>


        <div class="table-responsive">

            <table class="table audit-table align-middle">

                <thead>

                    <tr>

                        <th>Time</th>

                        <th>Action</th>

                        <th>Admin</th>

                        <th>Model</th>

                        <th>ID</th>

                        <th>Metadata</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($logs as $log)

                        <tr>

                            <!-- Time -->
                            <td>

                                <div class="audit-time">

                                    <span class="audit-time-main">
                                        {{ $log->created_at->format('M d, H:i') }}
                                    </span>

                                    <span class="audit-time-sub">
                                        {{ $log->created_at->format('Y') }}
                                    </span>

                                </div>

                            </td>


                            <!-- Action -->
                            <td>

                                <span class="audit-action">

                                    <i class="bi bi-lightning-charge-fill"></i>

                                    {{ $log->action }}

                                </span>

                            </td>


                            <!-- Admin -->
                            <td>

                                <div class="admin-info">

                                    <div class="admin-avatar">
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <span class="admin-name">
                                        {{ $log->admin?->name ?? 'System' }}
                                    </span>

                                </div>

                            </td>


                            <!-- Model -->
                            <td>

                                <span class="model-name">
                                    {{ class_basename($log->model_type) ?? '—' }}
                                </span>

                            </td>


                            <!-- ID -->
                            <td>

                                <span class="model-id">
                                    #{{ $log->model_id ?? '—' }}
                                </span>

                            </td>


                            <!-- Metadata -->
                            <td>

                                @if ($log->metadata)

                                    <div class="metadata-list">

                                        @foreach ($log->metadata as $k => $v)

                                            <span class="metadata-item">

                                                <span class="metadata-key">
                                                    {{ $k }}:
                                                </span>

                                                {{ $v }}

                                            </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span class="text-muted small">
                                        —
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="audit-empty">

                                <div class="audit-empty-icon">
                                    <i class="bi bi-shield-x"></i>
                                </div>

                                <strong>
                                    No audit logs found
                                </strong>

                                <span>
                                    There are no activities matching your current filters.
                                </span>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- Pagination -->
    @if ($logs->hasPages())

        <div class="audit-pagination">
            {{ $logs->withQueryString()->links() }}
        </div>

    @endif

</div>

@endsection