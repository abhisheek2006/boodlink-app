@extends('layouts.app')
@section('title', 'Request Details')

@section('content')

{{-- Page Header --}}
<div class="mb-4">

    <div class="d-flex align-items-center gap-3 mb-2">

        <div class="d-flex align-items-center justify-content-center"
             style="
                width: 58px;
                height: 58px;
                border-radius: 50%;
                background: #fff0f1;
             ">
            <i class="bi bi-droplet-fill"
               style="
                    font-size: 1.6rem;
                    color: #ef2b2d;
               "></i>
        </div>

        <div>
            <h1 class="fw-bold mb-1"
                style="
                    font-size: 2rem;
                    color: #17233c;
                ">
                Request Details
            </h1>

            <p class="text-muted mb-0">
                Blood request from
                <strong>{{ $request->patient->user->name ?? '—' }}</strong>
            </p>
        </div>

    </div>

    <div style="
        width: 58px;
        height: 3px;
        background: #ef2b2d;
        border-radius: 5px;
        margin-left: 1px;
    "></div>

</div>


{{-- Request Summary --}}
<div class="card border-0 shadow-sm mb-4"
     style="
        border-radius: 18px;
        overflow: hidden;
     ">

    <div class="card-body p-4">

        <div class="row g-4 align-items-center">

            {{-- Blood Group --}}
            <div class="col-md-3 col-6">

                <div class="d-flex align-items-center gap-3">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 52px;
                            height: 52px;
                            border-radius: 50%;
                            background: #fff0f1;
                         ">
                        <i class="bi bi-droplet-fill"
                           style="
                                color: #ef2b2d;
                                font-size: 1.4rem;
                           "></i>
                    </div>

                    <div>
                        <div class="text-muted small">
                            Blood Group
                        </div>

                        <div class="fw-bold fs-5"
                             style="color:#ef2b2d;">
                            {{ $request->bloodGroup->name ?? '—' }}
                        </div>
                    </div>

                </div>

            </div>


            {{-- Units --}}
            <div class="col-md-3 col-6">

                <div class="d-flex align-items-center gap-3">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 52px;
                            height: 52px;
                            border-radius: 50%;
                            background: #eef5ff;
                         ">
                        <i class="bi bi-layers"
                           style="
                                color: #2874e8;
                                font-size: 1.4rem;
                           "></i>
                    </div>

                    <div>
                        <div class="text-muted small">
                            Units Required
                        </div>

                        <div class="fw-bold fs-5"
                             style="color:#17233c;">
                            {{ $request->units_required }}
                        </div>
                    </div>

                </div>

            </div>


            {{-- Emergency --}}
            <div class="col-md-3 col-6">

                @php
                    $emergencyStyle = match($request->emergency_level) {
                        'Critical' => [
                            'bg' => '#fff0f1',
                            'color' => '#ef2b2d',
                            'icon' => 'bi-exclamation-triangle-fill'
                        ],
                        'High' => [
                            'bg' => '#fff7e8',
                            'color' => '#f59e0b',
                            'icon' => 'bi-exclamation-circle-fill'
                        ],
                        'Medium' => [
                            'bg' => '#eef5ff',
                            'color' => '#2874e8',
                            'icon' => 'bi-info-circle-fill'
                        ],
                        default => [
                            'bg' => '#f1f3f5',
                            'color' => '#64748b',
                            'icon' => 'bi-circle-fill'
                        ],
                    };
                @endphp

                <div class="d-flex align-items-center gap-3">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 52px;
                            height: 52px;
                            border-radius: 50%;
                            background: {{ $emergencyStyle['bg'] }};
                         ">
                        <i class="bi {{ $emergencyStyle['icon'] }}"
                           style="
                                color: {{ $emergencyStyle['color'] }};
                                font-size: 1.3rem;
                           "></i>
                    </div>

                    <div>
                        <div class="text-muted small">
                            Emergency
                        </div>

                        <span class="badge px-3 py-2"
                              style="
                                background: {{ $emergencyStyle['bg'] }};
                                color: {{ $emergencyStyle['color'] }};
                                border-radius: 8px;
                                font-weight: 600;
                              ">
                            {{ $request->emergency_level }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Status --}}
            <div class="col-md-3 col-6">

                @php
                    $statusStyle = match($request->status) {
                        'Accepted' => [
                            'bg' => '#eafaf2',
                            'color' => '#10b981',
                            'icon' => 'bi-check-circle-fill'
                        ],
                        'Pending' => [
                            'bg' => '#fff7e8',
                            'color' => '#f59e0b',
                            'icon' => 'bi-clock-fill'
                        ],
                        'Completed' => [
                            'bg' => '#eafaf2',
                            'color' => '#10b981',
                            'icon' => 'bi-check-circle-fill'
                        ],
                        'Rejected', 'Cancelled' => [
                            'bg' => '#fff0f1',
                            'color' => '#ef2b2d',
                            'icon' => 'bi-x-circle-fill'
                        ],
                        default => [
                            'bg' => '#f1f3f5',
                            'color' => '#64748b',
                            'icon' => 'bi-circle-fill'
                        ],
                    };
                @endphp

                <div class="d-flex align-items-center gap-3">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 52px;
                            height: 52px;
                            border-radius: 50%;
                            background: {{ $statusStyle['bg'] }};
                         ">
                        <i class="bi {{ $statusStyle['icon'] }}"
                           style="
                                color: {{ $statusStyle['color'] }};
                                font-size: 1.3rem;
                           "></i>
                    </div>

                    <div>
                        <div class="text-muted small">
                            Status
                        </div>

                        <span class="badge px-3 py-2"
                              style="
                                background: {{ $statusStyle['bg'] }};
                                color: {{ $statusStyle['color'] }};
                                border-radius: 8px;
                                font-weight: 600;
                              ">
                            {{ $request->status }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>


{{-- Information Cards --}}
<div class="row g-4">

    {{-- Patient Information --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100"
             style="
                border-radius: 18px;
                overflow: hidden;
             ">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 48px;
                            height: 48px;
                            border-radius: 50%;
                            background: #fff0f1;
                         ">
                        <i class="bi bi-person"
                           style="
                                color: #ef2b2d;
                                font-size: 1.4rem;
                           "></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0"
                            style="color:#17233c;">
                            Patient Information
                        </h5>

                        <small class="text-muted">
                            Details about the patient
                        </small>
                    </div>

                </div>


                {{-- Name --}}
                <div class="mb-3">

                    <div class="text-muted small mb-1">
                        Full Name
                    </div>

                    <div class="fw-semibold"
                         style="color:#17233c;">
                        {{ $request->patient->user->name ?? '—' }}
                    </div>

                </div>


                {{-- Email --}}
                <div class="mb-3">

                    <div class="text-muted small mb-1">
                        Email Address
                    </div>

                    <div class="fw-semibold"
                         style="color:#17233c;">
                        {{ $request->patient->user->email ?? '—' }}
                    </div>

                </div>


                {{-- Phone --}}
                <div class="mb-3">

                    <div class="text-muted small mb-1">
                        Phone Number
                    </div>

                    <div class="fw-semibold"
                         style="color:#17233c;">
                        {{ $request->patient->user->phone ?? '—' }}
                    </div>

                </div>


                {{-- City --}}
                <div>

                    <div class="text-muted small mb-1">
                        City
                    </div>

                    <div class="fw-semibold"
                         style="color:#17233c;">
                        {{ $request->patient->city ?? '—' }}
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Request Information --}}
    <div class="col-lg-6">

        <div class="card border-0 shadow-sm h-100"
             style="
                border-radius: 18px;
                overflow: hidden;
             ">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="d-flex align-items-center justify-content-center"
                         style="
                            width: 48px;
                            height: 48px;
                            border-radius: 50%;
                            background: #eef5ff;
                         ">
                        <i class="bi bi-file-medical"
                           style="
                                color: #2874e8;
                                font-size: 1.4rem;
                           "></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0"
                            style="color:#17233c;">
                            Request Information
                        </h5>

                        <small class="text-muted">
                            Details about the blood request
                        </small>
                    </div>

                </div>


                {{-- Blood Group --}}
                <div class="d-flex justify-content-between py-2 border-bottom">

                    <span class="text-muted">
                        Blood Group
                    </span>

                    <strong style="color:#ef2b2d;">
                        {{ $request->bloodGroup->name ?? '—' }}
                    </strong>

                </div>


                {{-- Units --}}
                <div class="d-flex justify-content-between py-2 border-bottom">

                    <span class="text-muted">
                        Units Required
                    </span>

                    <strong>
                        {{ $request->units_required }}
                    </strong>

                </div>


                {{-- Reason --}}
                <div class="d-flex justify-content-between py-2 border-bottom">

                    <span class="text-muted">
                        Reason
                    </span>

                    <strong>
                        {{ $request->reason ?: '—' }}
                    </strong>

                </div>


                {{-- Hospital --}}
                <div class="d-flex justify-content-between py-2 border-bottom">

                    <span class="text-muted">
                        Hospital
                    </span>

                    <strong class="text-end ms-3">
                        {{ $request->hospital_name ?? 'Not specified' }}
                    </strong>

                </div>


                {{-- Required Date --}}
                <div class="d-flex justify-content-between py-2">

                    <span class="text-muted">
                        Required Date
                    </span>

                    <strong>
                        {{ $request->required_date?->format('M d, Y') ?? 'Not specified' }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Additional Notes --}}
@if ($request->additional_notes)

    <div class="card border-0 shadow-sm mt-4"
         style="
            border-radius: 18px;
         ">

        <div class="card-body p-4">

            <div class="d-flex align-items-center gap-3 mb-3">

                <div class="d-flex align-items-center justify-content-center"
                     style="
                        width: 46px;
                        height: 46px;
                        border-radius: 50%;
                        background: #fff7e8;
                     ">
                    <i class="bi bi-chat-left-text"
                       style="
                            color: #f59e0b;
                            font-size: 1.3rem;
                       "></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-0"
                        style="color:#17233c;">
                        Additional Notes
                    </h5>

                    <small class="text-muted">
                        Information provided with the request
                    </small>
                </div>

            </div>

            <div class="p-3 rounded-3"
                 style="
                    background:#f8fafc;
                    color:#475569;
                 ">
                {{ $request->additional_notes }}
            </div>

        </div>

    </div>

@endif


{{-- Actions --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

    {{-- Back --}}
    <a href="{{ route('donor.requests.index') }}"
       class="btn px-4 py-2"
       style="
            border:1px solid #e2e8f0;
            background:#ffffff;
            color:#17233c;
            border-radius:10px;
       ">

        <i class="bi bi-arrow-left me-2"></i>
        Back to Requests

    </a>


    {{-- Request Actions --}}
    @if ($request->status === 'Pending' && $request->donationSession === null)

        <div class="d-flex flex-wrap gap-2">

            {{-- Accept --}}
            <form method="POST"
                  action="{{ route('donor.requests.accept', $request) }}">

                @csrf
                @method('PATCH')

                <button type="submit"
                        class="btn px-4 py-2"
                        style="
                            background:#10b981;
                            color:white;
                            border-radius:10px;
                            border:none;
                            font-weight:600;
                        ">

                    <i class="bi bi-check-circle me-2"></i>
                    Accept Request

                </button>

            </form>


            {{-- Reject --}}
            <form method="POST"
                  action="{{ route('donor.requests.reject', $request) }}"
                  onsubmit="return confirm('Reject this request?');">

                @csrf
                @method('PATCH')

                <button type="submit"
                        class="btn px-4 py-2"
                        style="
                            background:#ffffff;
                            color:#ef2b2d;
                            border:1px solid #ef2b2d;
                            border-radius:10px;
                            font-weight:600;
                        ">

                    <i class="bi bi-x-circle me-2"></i>
                    Reject Request

                </button>

            </form>

        </div>


    {{-- Accepted --}}
    @elseif ($request->status === 'Accepted' && $request->donationSession)

        <a href="{{ route('chat.show', $request->donationSession) }}"
           class="btn px-4 py-2"
           style="
                background:#ef2b2d;
                color:#ffffff;
                border:none;
                border-radius:10px;
                font-weight:600;
           ">

            <i class="bi bi-chat-dots me-2"></i>
            Open Chat

        </a>

    @endif

</div>

@endsection