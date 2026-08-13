@extends('layouts.app')

@section('title', 'System Settings')

@section('content')

<style>
    .settings-page {
        padding: 10px 4px 30px;
    }

    /* Page Header */
    .settings-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 28px;
    }

    .settings-header-icon {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #fff0f2;
        color: #ed1b2f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        flex-shrink: 0;
    }

    .settings-header h1 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        color: #111827;
    }

    .settings-header p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 15px;
    }

    /* Main Card */
    .settings-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.06);
        padding: 26px 25px 25px;
        margin-bottom: 26px;
    }

    .settings-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 19px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 27px;
    }

    .settings-section-title::before {
        content: "";
        width: 4px;
        height: 23px;
        border-radius: 5px;
        background: #ed1b2f;
    }

    /* Form */
    .settings-field {
        margin-bottom: 20px;
    }

    .settings-field label {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: #263449;
        margin-bottom: 8px;
    }

    .settings-field .form-control,
    .settings-field .form-select {
        min-height: 45px;
        border: 1px solid #dfe5ec;
        border-radius: 11px;
        background: #ffffff;
        color: #334155;
        font-size: 15px;
        padding: 10px 14px;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    .settings-field .form-control:focus,
    .settings-field .form-select:focus {
        border-color: #ed1b2f;
        box-shadow: 0 0 0 3px rgba(237, 27, 47, 0.08);
    }

    /* Multiple Select */
    .status-select {
        width: 100%;
        min-height: 158px !important;
        padding: 5px !important;
        border-radius: 10px !important;
    }

    .status-select option {
        padding: 7px 12px;
        font-size: 15px;
    }

    .status-select option:checked {
        background: #f3f4f6;
        color: #172033;
    }

    .status-help {
        color: #64748b;
        font-size: 13px;
        margin-top: 6px;
    }

    /* Buttons */
    .settings-actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .btn-save-settings {
        background: #ed1b2f;
        border: 1px solid #ed1b2f;
        color: #ffffff;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(237, 27, 47, 0.18);
        transition: 0.2s ease;
    }

    .btn-save-settings:hover {
        background: #d91529;
        border-color: #d91529;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-reset-settings {
        background: #ffffff;
        border: 1px solid #dfe5ec;
        color: #263449;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-reset-settings:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #111827;
    }

    /* Cache Management */
    .cache-card {
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, 0.06);
        padding: 24px 25px;
    }

    .cache-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .cache-title-wrapper {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .cache-title-wrapper::before {
        content: "";
        width: 4px;
        min-width: 4px;
        height: 23px;
        border-radius: 5px;
        background: #ed1b2f;
        margin-top: 1px;
    }

    .cache-title {
        font-size: 19px;
        font-weight: 700;
        color: #172033;
        margin: 0;
    }

    .cache-description {
        color: #64748b;
        font-size: 14px;
        margin: 7px 0 0;
    }

    .btn-clear-cache {
        background: #ffffff;
        border: 1px solid #ffb6be;
        color: #ed1b2f;
        border-radius: 10px;
        padding: 9px 15px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .btn-clear-cache:hover {
        background: #fff1f2;
        border-color: #ed1b2f;
        color: #d91529;
    }

    /* Validation */
    .settings-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .settings-header h1 {
            font-size: 25px;
        }

        .settings-card,
        .cache-card {
            padding: 22px 20px;
        }
    }

    @media (max-width: 768px) {
        .settings-header {
            gap: 12px;
        }

        .settings-header-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }

        .settings-header h1 {
            font-size: 22px;
        }

        .settings-header p {
            font-size: 13px;
        }

        .cache-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-clear-cache {
            width: 100%;
        }

        .settings-actions {
            flex-wrap: wrap;
        }
    }
</style>


<div class="settings-page">

    {{-- =========================
        PAGE HEADER
    ========================== --}}
    <div class="settings-header">

        <div class="settings-header-icon">
            <i class="bi bi-gear"></i>
        </div>

        <div>
            <h1>System Settings</h1>
            <p>Manage system preferences and donation rules</p>
        </div>

    </div>


    {{-- =========================
        SETTINGS FORM
    ========================== --}}
    <div class="settings-card">

        <div class="settings-section-title">
            Donation &amp; Session Settings
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- Session Timeout --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="session_timeout_minutes">
                            Session Timeout (minutes)
                        </label>

                        <input
                            type="number"
                            id="session_timeout_minutes"
                            name="session_timeout_minutes"
                            value="{{ old('session_timeout_minutes', $settings['session_timeout_minutes']) }}"
                            class="form-control"
                            min="1"
                        >

                        @error('session_timeout_minutes')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Minimum Donation Age --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="minimum_age_donate">
                            Minimum Donation Age
                        </label>

                        <input
                            type="number"
                            id="minimum_age_donate"
                            name="minimum_age_donate"
                            value="{{ old('minimum_age_donate', $settings['minimum_age_donate']) }}"
                            class="form-control"
                            min="1"
                        >

                        @error('minimum_age_donate')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Maximum Donation Age --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="maximum_age_donate">
                            Maximum Donation Age
                        </label>

                        <input
                            type="number"
                            id="maximum_age_donate"
                            name="maximum_age_donate"
                            value="{{ old('maximum_age_donate', $settings['maximum_age_donate']) }}"
                            class="form-control"
                            min="1"
                        >

                        @error('maximum_age_donate')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Minimum Weight --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="minimum_weight">
                            Minimum Weight (kg)
                        </label>

                        <input
                            type="number"
                            step="0.5"
                            id="minimum_weight"
                            name="minimum_weight"
                            value="{{ old('minimum_weight', $settings['minimum_weight']) }}"
                            class="form-control"
                            min="1"
                        >

                        @error('minimum_weight')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Male Deferral --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="deferral_male_days">
                            Deferral Days (Male)
                        </label>

                        <input
                            type="number"
                            id="deferral_male_days"
                            name="deferral_male_days"
                            value="{{ old('deferral_male_days', $settings['deferral_male_days']) }}"
                            class="form-control"
                            min="0"
                        >

                        @error('deferral_male_days')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Female Deferral --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="deferral_female_days">
                            Deferral Days (Female)
                        </label>

                        <input
                            type="number"
                            id="deferral_female_days"
                            name="deferral_female_days"
                            value="{{ old('deferral_female_days', $settings['deferral_female_days']) }}"
                            class="form-control"
                            min="0"
                        >

                        @error('deferral_female_days')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Other Deferral --}}
                <div class="col-lg-4 col-md-6">
                    <div class="settings-field">

                        <label for="deferral_other_days">
                            Deferral Days (Other)
                        </label>

                        <input
                            type="number"
                            id="deferral_other_days"
                            name="deferral_other_days"
                            value="{{ old('deferral_other_days', $settings['deferral_other_days']) }}"
                            class="form-control"
                            min="0"
                        >

                        @error('deferral_other_days')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                {{-- Shareable Statuses --}}
                <div class="col-12">

                    <div class="settings-field mb-1">

                        <label for="shareable_session_statuses">
                            Shareable Session Statuses
                        </label>

                        @php
                            $allStatuses = [
                                'Pending',
                                'Active',
                                'Completed',
                                'Expired',
                                'Cancelled'
                            ];

                            $selectedStatuses = old(
                                'shareable_session_statuses',
                                $settings['shareable_session_statuses'] ?? []
                            );
                        @endphp

                        <select
                            name="shareable_session_statuses[]"
                            id="shareable_session_statuses"
                            class="form-select status-select"
                            multiple
                        >

                            @foreach ($allStatuses as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected(in_array($status, $selectedStatuses))
                                >
                                    {{ $status }}
                                </option>

                            @endforeach

                        </select>

                        <div class="status-help">
                            Ctrl+Click to select multiple.
                        </div>

                        @error('shareable_session_statuses')
                            <div class="settings-error">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="settings-actions">

                <button type="submit" class="btn btn-save-settings">
                    <i class="bi bi-save me-1"></i>
                    Save Settings
                </button>

                <a
                    href="{{ route('admin.settings.index') }}"
                    class="btn btn-reset-settings"
                >
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- =========================
        CACHE MANAGEMENT
    ========================== --}}
    <div class="cache-card">

        <div class="cache-header">

            <div class="cache-title-wrapper">

                <div>
                    <h5 class="cache-title">
                        Cache Management
                    </h5>

                    <p class="cache-description">
                        Clearing cache will remove all cached data and improve system performance.
                    </p>
                </div>

            </div>


            <form
                action="{{ route('admin.settings.clear-cache') }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to clear all caches?');"
            >
                @csrf

                <button type="submit" class="btn btn-clear-cache">
                    <i class="bi bi-trash3 me-1"></i>
                    Clear All Caches
                </button>

            </form>

        </div>

    </div>

</div>

@endsection