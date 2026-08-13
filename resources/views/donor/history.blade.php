@extends('layouts.app')
@section('title', 'Donation History')

@section('content')

{{-- Page Header --}}
<div class="mb-4">
    <h1 class="fw-bold mb-1" style="font-size: 2rem; color: #17233c;">
        Donation History
    </h1>

    <div style="
        width: 58px;
        height: 3px;
        background: #ef2b2d;
        border-radius: 5px;
    "></div>

    <p class="text-muted mt-2 mb-0">
        Track your blood donation activity and achievements.
    </p>
</div>


{{-- Statistics Cards --}}
<div class="row g-3 mb-4">

    {{-- Total Donations --}}
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 18px;">

            <div class="card-body p-4 text-center">

                <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="
                        width: 58px;
                        height: 58px;
                        border-radius: 50%;
                        background: #fff0f1;
                     ">
                    <i class="bi bi-droplet"
                       style="
                            font-size: 1.7rem;
                            color: #ef2b2d;
                       "></i>
                </div>

                <div class="fw-bold"
                     style="
                        font-size: 1.8rem;
                        color: #17233c;
                     ">
                    {{ $donor->total_donations }}
                </div>

                <div class="text-muted small mt-1">
                    Total Donations
                </div>

            </div>
        </div>
    </div>


    {{-- Badge --}}
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 18px;">

            <div class="card-body p-4 text-center">

                <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="
                        width: 58px;
                        height: 58px;
                        border-radius: 50%;
                        background: #fff7e8;
                     ">
                    <i class="bi bi-award"
                       style="
                            font-size: 1.7rem;
                            color: #f59e0b;
                       "></i>
                </div>

                <div class="fw-bold"
                     style="
                        font-size: 1.15rem;
                        color: #17233c;
                     ">
                    {{ $donor->current_badge ?? 'No Badge' }}
                </div>

                <div class="text-muted small mt-1">
                    Current Badge
                </div>

            </div>
        </div>
    </div>


    {{-- Rank --}}
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 18px;">

            <div class="card-body p-4 text-center">

                <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="
                        width: 58px;
                        height: 58px;
                        border-radius: 50%;
                        background: #eef5ff;
                     ">
                    <i class="bi bi-trophy"
                       style="
                            font-size: 1.7rem;
                            color: #2874e8;
                       "></i>
                </div>

                <div class="fw-bold"
                     style="
                        font-size: 1.8rem;
                        color: #17233c;
                     ">
                    #{{ $donor->current_rank ?? '-' }}
                </div>

                <div class="text-muted small mt-1">
                    Current Rank
                </div>

            </div>
        </div>
    </div>


    {{-- Availability --}}
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 18px;">

            <div class="card-body p-4 text-center">

                <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="
                        width: 58px;
                        height: 58px;
                        border-radius: 50%;
                        background: #eafaf2;
                     ">
                    <i class="bi bi-heart-pulse"
                       style="
                            font-size: 1.7rem;
                            color: #10b981;
                       "></i>
                </div>

                <div class="fw-bold"
                     style="
                        font-size: 1.1rem;
                        color: #17233c;
                     ">
                    {{ $donor->availability }}
                </div>

                <div class="text-muted small mt-1">
                    Availability
                </div>

            </div>
        </div>
    </div>

</div>


{{-- Donation History Table --}}
<div class="card border-0 shadow-sm"
     style="
        border-radius: 18px;
        overflow: hidden;
     ">

    {{-- Card Header --}}
    <div class="card-body px-4 pt-4 pb-3">

        <div class="d-flex align-items-center justify-content-between">

            <div>
                <h5 class="fw-bold mb-1" style="color: #17233c;">
                    <i class="bi bi-clock-history me-2"
                       style="color: #ef2b2d;"></i>
                    Donation Records
                </h5>

                <p class="text-muted small mb-0">
                    Your previous blood donation sessions.
                </p>
            </div>

        </div>

    </div>


    {{-- Table --}}
    <div class="table-responsive">

        <table class="table align-middle mb-0"
               id="historyTable">

            <thead>
                <tr style="background: #fafbfc;">

                    <th class="px-4 py-3 text-muted small text-uppercase">
                        Date
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Patient
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Blood Group
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Duration
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Status
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse ($sessions as $session)

                    <tr style="border-top: 1px solid #eef1f5;">

                        {{-- Date --}}
                        <td class="px-4 py-4">
                            <div class="d-flex align-items-center gap-2">

                                <div class="d-flex align-items-center justify-content-center"
                                     style="
                                        width: 38px;
                                        height: 38px;
                                        border-radius: 50%;
                                        background: #fff0f1;
                                     ">
                                    <i class="bi bi-calendar3"
                                       style="color: #ef2b2d;"></i>
                                </div>

                                <span class="fw-semibold"
                                      style="color: #17233c;">
                                    {{ optional($session->ended_at ?? $session->started_at)->toFormattedDateString() }}
                                </span>

                            </div>
                        </td>


                        {{-- Patient --}}
                        <td class="py-4">

                            <div class="d-flex align-items-center gap-2">

                                <div class="d-flex align-items-center justify-content-center"
                                     style="
                                        width: 38px;
                                        height: 38px;
                                        border-radius: 50%;
                                        background: #eef5ff;
                                     ">
                                    <i class="bi bi-person"
                                       style="color: #2874e8;"></i>
                                </div>

                                <span class="fw-semibold"
                                      style="color: #17233c;">
                                    {{ $session->patient->user->name }}
                                </span>

                            </div>

                        </td>


                        {{-- Blood Group --}}
                        <td class="py-4">

                            <span class="fw-bold"
                                  style="color: #ef2b2d;">
                                <i class="bi bi-droplet-fill me-1"></i>
                                {{ $session->donor->bloodGroup->name ?? '-' }}
                            </span>

                        </td>


                        {{-- Duration --}}
                        <td class="py-4">

                            @if ($session->session_duration)

                                <span class="text-muted">
                                    <i class="bi bi-stopwatch me-1"></i>
                                    {{ gmdate('i:s', $session->session_duration) }} min
                                </span>

                            @else

                                <span class="text-muted">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- Status --}}
                        <td class="py-4">

                            @php
                                $statusStyle = match($session->status) {
                                    'Completed' => [
                                        'bg' => '#eafaf2',
                                        'color' => '#10b981',
                                        'icon' => 'bi-check-circle'
                                    ],
                                    'Active' => [
                                        'bg' => '#eef5ff',
                                        'color' => '#2874e8',
                                        'icon' => 'bi-clock'
                                    ],
                                    'Expired' => [
                                        'bg' => '#fff7e8',
                                        'color' => '#f59e0b',
                                        'icon' => 'bi-exclamation-circle'
                                    ],
                                    default => [
                                        'bg' => '#f1f3f5',
                                        'color' => '#64748b',
                                        'icon' => 'bi-dash-circle'
                                    ],
                                };
                            @endphp

                            <span class="badge px-3 py-2"
                                  style="
                                    background: {{ $statusStyle['bg'] }};
                                    color: {{ $statusStyle['color'] }};
                                    border-radius: 8px;
                                    font-weight: 600;
                                  ">

                                <i class="bi {{ $statusStyle['icon'] }} me-1"></i>

                                {{ $session->status }}

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-5">

                            <div class="mb-3">
                                <i class="bi bi-droplet"
                                   style="
                                        font-size: 3rem;
                                        color: #cbd5e1;
                                   "></i>
                            </div>

                            <h6 class="fw-bold" style="color: #17233c;">
                                No Donation History
                            </h6>

                            <p class="text-muted mb-0">
                                Your completed donation sessions will appear here.
                            </p>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- Pagination --}}
@if ($sessions->hasPages())
    <div class="mt-4">
        {{ $sessions->links() }}
    </div>
@endif

@endsection