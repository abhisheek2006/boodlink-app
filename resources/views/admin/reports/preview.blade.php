@extends('layouts.app')

@section('title', $title)

@section('content')

<style>
    .report-preview-page {
        padding: 8px 4px 30px;
    }

    /* =========================
       TOP HEADER
    ========================== */

    .report-preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
    }

    .report-heading {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .report-heading-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #fff0f2;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        flex-shrink: 0;
    }

    .report-heading h1 {
        margin: 0;
        font-size: 27px;
        font-weight: 700;
        color: #111827;
    }

    .report-heading p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 14px;
    }


    /* =========================
       BACK BUTTON
    ========================== */

    .back-report-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1px solid #dfe5ec;
        color: #334155;
        border-radius: 10px;
        padding: 9px 15px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        transition: all .2s ease;
    }

    .back-report-btn:hover {
        background: #f8fafc;
        color: #111827;
        border-color: #cbd5e1;
    }


    /* =========================
       ACTION BUTTONS
    ========================== */

    .report-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .report-action-btn {
        min-height: 42px;
        padding: 8px 14px;
        border-radius: 10px;
        background: #ffffff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: all .2s ease;
    }

    .pdf-action {
        border: 1px solid #ff9aa4;
        color: #ed1b2f;
    }

    .pdf-action:hover {
        background: #fff0f2;
        color: #d91529;
        border-color: #ed1b2f;
    }

    .excel-action {
        border: 1px solid #52bd91;
        color: #198754;
    }

    .excel-action:hover {
        background: #effbf5;
        color: #157347;
        border-color: #198754;
    }

    .print-action {
        border: 1px solid #dfe5ec;
        color: #334155;
    }

    .print-action:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #111827;
    }


    /* =========================
       REPORT CARD
    ========================== */

    .report-data-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .report-card-top {
        padding: 22px 25px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .report-card-title {
        display: flex;
        align-items: center;
        gap: 11px;
        font-size: 17px;
        font-weight: 700;
        color: #172033;
    }

    .report-card-title i {
        color: #ed1b2f;
        font-size: 20px;
    }

    .record-count {
        color: #64748b;
        background: #f8fafc;
        border: 1px solid #e5eaf0;
        border-radius: 20px;
        padding: 5px 11px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }


    /* =========================
       TABLE
    ========================== */

    .report-table-wrapper {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .report-table thead th {
        background: #fafbfc;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .3px;
        padding: 16px 20px;
        border-bottom: 1px solid #e8edf2;
        white-space: nowrap;
    }

    .report-table tbody td {
        padding: 16px 20px;
        color: #1e293b;
        font-size: 14px;
        border-bottom: 1px solid #edf0f4;
        white-space: nowrap;
    }

    .report-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .report-table tbody tr {
        transition: background .15s ease;
    }

    .report-table tbody tr:hover {
        background: #fff8f9;
    }


    /* =========================
       EMPTY STATE
    ========================== */

    .empty-report {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-report-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #fff0f2;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    .empty-report h5 {
        color: #172033;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .empty-report p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }


    /* =========================
       PRINT
    ========================== */

    @media print {

        body {
            background: #ffffff !important;
        }

        .sidebar,
        .navbar,
        header,
        nav {
            display: none !important;
        }

        .report-preview-page {
            padding: 0;
        }

        .back-report-btn,
        .report-actions {
            display: none !important;
        }

        .report-data-card {
            border: 1px solid #ddd;
            box-shadow: none;
        }

        .report-table tbody tr:hover {
            background: transparent;
        }
    }


    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 900px) {

        .report-preview-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .report-actions {
            width: 100%;
        }

    }

    @media (max-width: 600px) {

        .report-heading {
            align-items: flex-start;
        }

        .report-heading-icon {
            width: 54px;
            height: 54px;
            font-size: 23px;
        }

        .report-heading h1 {
            font-size: 22px;
        }

        .report-heading p {
            font-size: 13px;
        }

        .report-card-top {
            padding: 18px;
        }

        .report-table thead th,
        .report-table tbody td {
            padding: 13px 15px;
        }

        .report-actions {
            gap: 7px;
        }

        .report-action-btn {
            flex: 1;
        }

    }
</style>


<div class="report-preview-page">

    {{-- =========================
         BACK
    ========================== --}}

    <a
        href="{{ route('admin.reports.index') }}"
        class="back-report-btn"
    >
        <i class="bi bi-arrow-left"></i>
        Back to Reports
    </a>


    {{-- =========================
         HEADER
    ========================== --}}

    <div class="report-preview-header">

        <div class="report-heading">

            <div class="report-heading-icon">
                <i class="bi bi-file-earmark-bar-graph"></i>
            </div>

            <div>
                <h1>{{ $title }}</h1>

                <p>
                    Preview and export report data
                </p>
            </div>

        </div>


        {{-- Actions --}}

        <div class="report-actions">

            <a
                href="{{ route('admin.reports.pdf', $report) }}"
                class="report-action-btn pdf-action"
            >
                <i class="bi bi-filetype-pdf"></i>
                PDF
            </a>

            <a
                href="{{ route('admin.reports.excel', $report) }}"
                class="report-action-btn excel-action"
            >
                <i class="bi bi-filetype-xlsx"></i>
                Excel
            </a>

            <button
                type="button"
                onclick="window.print()"
                class="report-action-btn print-action"
            >
                <i class="bi bi-printer"></i>
                Print
            </button>

        </div>

    </div>


    {{-- =========================
         REPORT DATA CARD
    ========================== --}}

    <div class="report-data-card">

        <div class="report-card-top">

            <div class="report-card-title">
                <i class="bi bi-table"></i>
                Report Data
            </div>

            <div class="record-count">
                {{ $rows->count() }}
                {{ $rows->count() === 1 ? 'record' : 'records' }}
            </div>

        </div>


        @if ($rows->isEmpty())

            {{-- Empty State --}}

            <div class="empty-report">

                <div class="empty-report-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>

                <h5>No Data Available</h5>

                <p>
                    No data is currently available for this report.
                </p>

            </div>

        @else

            {{-- =========================
                 DATA TABLE
            ========================== --}}

            <div class="report-table-wrapper">

                <table class="report-table">

                    <thead>

                        <tr>

                            @foreach (array_keys((array) $rows->first()) as $column)

                                <th>
                                    {{ \Illuminate\Support\Str::headline($column) }}
                                </th>

                            @endforeach

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($rows as $row)

                            <tr>

                                @foreach ((array) $row as $value)

                                    <td>
                                        {{ $value ?? '—' }}
                                    </td>

                                @endforeach

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection