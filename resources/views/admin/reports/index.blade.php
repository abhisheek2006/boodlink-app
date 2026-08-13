@extends('layouts.app')

@section('title', 'Reports')

@section('content')

<style>
    .reports-page {
        padding: 8px 4px 30px;
    }

    /* =========================
       PAGE HEADER
    ========================== */

    .reports-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 32px;
    }

    .reports-header-icon {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #fff0f2;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        flex-shrink: 0;
    }

    .reports-header h1 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .reports-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 15px;
    }


    /* =========================
       REPORT GRID
    ========================== */

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }


    /* =========================
       REPORT CARD
    ========================== */

    .report-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 17px;
        min-height: 190px;
        padding: 26px 24px 23px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.055);
        transition: all 0.2s ease;
    }

    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.09);
    }


    /* =========================
       REPORT TITLE
    ========================== */

    .report-title {
        display: flex;
        align-items: center;
        gap: 17px;
        margin-bottom: 25px;
    }

    .report-icon {
        width: 64px;
        height: 64px;
        min-width: 64px;
        border-radius: 50%;
        background: #fff0f2;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    .report-name {
        font-size: 17px;
        font-weight: 700;
        color: #172033;
        line-height: 1.35;
    }


    /* =========================
       REPORT ACTIONS
    ========================== */

    .report-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .preview-btn {
        flex: 1;
        min-height: 47px;
        border: 1px solid #dfe5ec;
        border-radius: 11px;
        background: #ffffff;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .preview-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #111827;
    }


    /* PDF */

    .pdf-btn {
        width: 50px;
        height: 47px;
        border: 1px solid #ff8994;
        border-radius: 11px;
        background: #ffffff;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 21px;
        transition: all 0.2s ease;
    }

    .pdf-btn:hover {
        background: #fff0f2;
        border-color: #ed1b2f;
        color: #d91529;
    }


    /* Excel */

    .excel-btn {
        width: 50px;
        height: 47px;
        border: 1px solid #45b889;
        border-radius: 11px;
        background: #ffffff;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 21px;
        transition: all 0.2s ease;
    }

    .excel-btn:hover {
        background: #effbf5;
        border-color: #198754;
        color: #157347;
    }


    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 1100px) {

        .reports-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 700px) {

        .reports-page {
            padding: 5px 0 25px;
        }

        .reports-header {
            gap: 12px;
            margin-bottom: 24px;
        }

        .reports-header-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }

        .reports-header h1 {
            font-size: 23px;
        }

        .reports-header p {
            font-size: 13px;
        }

        .reports-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .report-card {
            min-height: 175px;
        }

    }

    @media (max-width: 400px) {

        .report-actions {
            gap: 8px;
        }

        .pdf-btn,
        .excel-btn {
            width: 45px;
        }

    }
</style>


<div class="reports-page">

    {{-- =========================
         PAGE HEADER
    ========================== --}}

    <div class="reports-header">

        <div class="reports-header-icon">
            <i class="bi bi-file-earmark-bar-graph"></i>
        </div>

        <div>
            <h1>Reports</h1>

            <p>
                View, export and analyze blood bank data
            </p>
        </div>

    </div>


    {{-- =========================
         REPORT CARDS
    ========================== --}}

    <div class="reports-grid">

        @foreach ($reports as $key => $label)

            @php
                $icon = match ($key) {
                    'total_donors' => 'bi-people-fill',
                    'total_patients' => 'bi-person-fill',
                    'total_blood_requests' => 'bi-clipboard2-pulse',
                    'available_blood_stock' => 'bi-droplet-fill',
                    'donation_sessions' => 'bi-heart-pulse-fill',
                    'completed_donations' => 'bi-check-circle-fill',
                    'monthly_donation_report' => 'bi-calendar3',
                    'blood_group_distribution' => 'bi-pie-chart-fill',
                    'top_donors' => 'bi-trophy-fill',
                    default => 'bi-file-earmark-bar-graph'
                };
            @endphp


            <div class="report-card">

                {{-- Report Name --}}
                <div class="report-title">

                    <div class="report-icon">
                        <i class="bi {{ $icon }}"></i>
                    </div>

                    <div class="report-name">
                        {{ $label }}
                    </div>

                </div>


                {{-- Actions --}}
                <div class="report-actions">

                    {{-- Preview --}}
                    <a
                        href="{{ route('admin.reports.preview', $key) }}"
                        class="preview-btn"
                    >
                        Preview
                    </a>


                    {{-- PDF --}}
                    <a
                        href="{{ route('admin.reports.pdf', $key) }}"
                        class="pdf-btn"
                        title="Export PDF"
                        aria-label="Export PDF"
                    >
                        <i class="bi bi-filetype-pdf"></i>
                    </a>


                    {{-- Excel --}}
                    <a
                        href="{{ route('admin.reports.excel', $key) }}"
                        class="excel-btn"
                        title="Export Excel"
                        aria-label="Export Excel"
                    >
                        <i class="bi bi-filetype-xlsx"></i>
                    </a>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection