@extends('layouts.app')
@section('title', 'Leaderboard')

@section('content')

{{-- Page Header --}}
<div class="mb-4">

    <div class="d-flex align-items-center gap-3 mb-2">

        <div class="d-flex align-items-center justify-content-center"
             style="
                width: 58px;
                height: 58px;
                border-radius: 50%;
                background: #fff7e8;
             ">

            <i class="bi bi-trophy-fill"
               style="
                    color: #f59e0b;
                    font-size: 1.6rem;
               "></i>

        </div>

        <div>
            <h1 class="fw-bold mb-1"
                style="
                    font-size: 2rem;
                    color: #17233c;
                ">
                Donor Leaderboard
            </h1>

            <p class="text-muted mb-0">
                Recognizing our lifesavers and top blood donors.
            </p>
        </div>

    </div>

    <div style="
        width: 58px;
        height: 3px;
        background: #ef2b2d;
        border-radius: 5px;
    "></div>

</div>


{{-- Top Donors --}}
@php
    $topDonors = $donors->take(3);
@endphp

@if ($topDonors->count() > 0)

<div class="row g-3 mb-4">

    @foreach ($topDonors as $index => $topDonor)

        @php
            $rank = $topDonor->current_rank ?? ($index + 1);

            $rankStyle = match($index) {
                0 => [
                    'bg' => '#fff7e8',
                    'color' => '#f59e0b',
                    'icon' => 'bi-trophy-fill'
                ],
                1 => [
                    'bg' => '#f1f3f5',
                    'color' => '#64748b',
                    'icon' => 'bi-award-fill'
                ],
                default => [
                    'bg' => '#fff0e1',
                    'color' => '#b87333',
                    'icon' => 'bi-award-fill'
                ],
            };
        @endphp

        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100"
                 style="
                    border-radius: 18px;
                    overflow: hidden;
                 ">

                <div class="card-body p-4 text-center">

                    {{-- Rank Icon --}}
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="
                            width: 64px;
                            height: 64px;
                            border-radius: 50%;
                            background: {{ $rankStyle['bg'] }};
                         ">

                        <i class="bi {{ $rankStyle['icon'] }}"
                           style="
                                font-size: 1.7rem;
                                color: {{ $rankStyle['color'] }};
                           "></i>

                    </div>


                    {{-- Rank --}}
                    <div class="small text-muted mb-1">
                        Rank
                    </div>

                    <div class="fw-bold mb-3"
                         style="
                            font-size: 1.4rem;
                            color: {{ $rankStyle['color'] }};
                         ">
                        #{{ $rank }}
                    </div>


                    {{-- Name --}}
                    <h5 class="fw-bold mb-2"
                        style="color:#17233c;">

                        {{ $topDonor->user->name }}

                    </h5>


                    {{-- Blood Group --}}
                    <span class="badge px-3 py-2"
                          style="
                            background:#fff0f1;
                            color:#ef2b2d;
                            border-radius:8px;
                          ">

                        <i class="bi bi-droplet-fill me-1"></i>

                        {{ $topDonor->bloodGroup->name ?? '-' }}

                    </span>


                    {{-- Donations --}}
                    <div class="mt-3">

                        <div class="fw-bold"
                             style="
                                font-size:1.5rem;
                                color:#17233c;
                             ">
                            {{ $topDonor->total_donations }}
                        </div>

                        <div class="text-muted small">
                            Total Donations
                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

@endif


{{-- Full Leaderboard --}}
<div class="card border-0 shadow-sm"
     style="
        border-radius:18px;
        overflow:hidden;
     ">

    {{-- Card Header --}}
    <div class="card-body px-4 pt-4 pb-3">

        <div class="d-flex align-items-center justify-content-between">

            <div>

                <h5 class="fw-bold mb-1"
                    style="color:#17233c;">

                    <i class="bi bi-bar-chart-fill me-2"
                       style="color:#ef2b2d;"></i>

                    All Donors

                </h5>

                <p class="text-muted small mb-0">
                    Donor rankings based on completed donations.
                </p>

            </div>

        </div>

    </div>


    {{-- Table --}}
    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>

                <tr style="background:#fafbfc;">

                    <th class="px-4 py-3 text-muted small text-uppercase">
                        Rank
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Donor
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Blood Group
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Donations
                    </th>

                    <th class="py-3 text-muted small text-uppercase">
                        Badge
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($donors as $donor)

                    @php
                        $rank = $donor->current_rank ?? $loop->iteration;

                        $badgeClass = match($donor->current_badge) {
                            'Platinum Donor' => [
                                'bg' => '#f3f4f6',
                                'color' => '#475569',
                                'icon' => 'bi-gem'
                            ],
                            'Gold Donor' => [
                                'bg' => '#fff7e8',
                                'color' => '#d97706',
                                'icon' => 'bi-award-fill'
                            ],
                            'Silver Donor' => [
                                'bg' => '#f1f3f5',
                                'color' => '#64748b',
                                'icon' => 'bi-award'
                            ],
                            'Bronze Donor' => [
                                'bg' => '#fff0e1',
                                'color' => '#b87333',
                                'icon' => 'bi-award'
                            ],
                            default => [
                                'bg' => '#f1f3f5',
                                'color' => '#64748b',
                                'icon' => 'bi-dash-circle'
                            ],
                        };
                    @endphp


                    <tr style="border-top:1px solid #eef1f5;">

                        {{-- Rank --}}
                        <td class="px-4 py-4">

                            @if ($rank <= 3)

                                <div class="d-flex align-items-center justify-content-center"
                                     style="
                                        width:40px;
                                        height:40px;
                                        border-radius:50%;
                                        background: {{ $rank === 1 ? '#fff7e8' : ($rank === 2 ? '#f1f3f5' : '#fff0e1') }};
                                        color: {{ $rank === 1 ? '#f59e0b' : ($rank === 2 ? '#64748b' : '#b87333') }};
                                        font-weight:700;
                                     ">

                                    {{ $rank }}

                                </div>

                            @else

                                <span class="fw-bold"
                                      style="color:#17233c;">

                                    #{{ $rank }}

                                </span>

                            @endif

                        </td>


                        {{-- Donor --}}
                        <td class="py-4">

                            <div class="d-flex align-items-center gap-3">

                                <div class="d-flex align-items-center justify-content-center"
                                     style="
                                        width:42px;
                                        height:42px;
                                        border-radius:50%;
                                        background:#fff0f1;
                                     ">

                                    <i class="bi bi-person-fill"
                                       style="
                                            color:#ef2b2d;
                                            font-size:1.2rem;
                                       "></i>

                                </div>

                                <div>

                                    <div class="fw-semibold"
                                         style="color:#17233c;">

                                        {{ $donor->user->name }}

                                    </div>

                                    <div class="small text-muted">
                                        Blood Donor
                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- Blood Group --}}
                        <td class="py-4">

                            <span class="badge px-3 py-2"
                                  style="
                                    background:#fff0f1;
                                    color:#ef2b2d;
                                    border-radius:8px;
                                    font-weight:600;
                                  ">

                                <i class="bi bi-droplet-fill me-1"></i>

                                {{ $donor->bloodGroup->name ?? '-' }}

                            </span>

                        </td>


                        {{-- Donations --}}
                        <td class="py-4">

                            <div class="d-flex align-items-center gap-2">

                                <div class="d-flex align-items-center justify-content-center"
                                     style="
                                        width:38px;
                                        height:38px;
                                        border-radius:50%;
                                        background:#eef5ff;
                                     ">

                                    <i class="bi bi-heart-pulse"
                                       style="color:#2874e8;"></i>

                                </div>

                                <div>

                                    <div class="fw-bold"
                                         style="color:#17233c;">

                                        {{ $donor->total_donations }}

                                    </div>

                                    <div class="small text-muted">
                                        Donations
                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- Badge --}}
                        <td class="py-4">

                            <span class="badge px-3 py-2"
                                  style="
                                    background:{{ $badgeClass['bg'] }};
                                    color:{{ $badgeClass['color'] }};
                                    border-radius:8px;
                                    font-weight:600;
                                  ">

                                <i class="bi {{ $badgeClass['icon'] }} me-1"></i>

                                {{ $donor->current_badge ?? 'No Badge' }}

                            </span>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-5">

                            <div class="mb-3">

                                <i class="bi bi-trophy"
                                   style="
                                        font-size:3rem;
                                        color:#cbd5e1;
                                   "></i>

                            </div>

                            <h6 class="fw-bold"
                                style="color:#17233c;">

                                No Donors Yet

                            </h6>

                            <p class="text-muted mb-0">

                                Completed donations will appear on the leaderboard.

                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- Custom Pagination --}}
@if ($donors->hasPages())

    <div class="users-footer mt-4">

        <div class="users-count">
            Showing
            <strong>{{ $donors->firstItem() }}</strong>
            -
            <strong>{{ $donors->lastItem() }}</strong>
            of
            <strong>{{ $donors->total() }}</strong>
            donors
        </div>

        <div class="users-pagination">

            <div class="custom-pagination">

                {{-- Previous --}}
                @if ($donors->onFirstPage())

                    <span class="pagination-arrow disabled">
                        <i class="bi bi-chevron-left"></i>
                    </span>

                @else

                    <a href="{{ $donors->previousPageUrl() }}"
                       class="pagination-arrow">
                        <i class="bi bi-chevron-left"></i>
                    </a>

                @endif


                {{-- Page Numbers --}}
                @php
                    $current = $donors->currentPage();
                    $last = $donors->lastPage();

                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                @endphp

                @if ($start > 1)

                    <a href="{{ $donors->url(1) }}"
                       class="pagination-number">
                        1
                    </a>

                    @if ($start > 2)
                        <span class="pagination-number"
                              style="pointer-events:none;">
                            ...
                        </span>
                    @endif

                @endif


                @for ($page = $start; $page <= $end; $page++)

                    @if ($page == $current)

                        <span class="pagination-number active">
                            {{ $page }}
                        </span>

                    @else

                        <a href="{{ $donors->url($page) }}"
                           class="pagination-number">
                            {{ $page }}
                        </a>

                    @endif

                @endfor


                @if ($end < $last)

                    @if ($end < $last - 1)
                        <span class="pagination-number"
                              style="pointer-events:none;">
                            ...
                        </span>
                    @endif

                    <a href="{{ $donors->url($last) }}"
                       class="pagination-number">
                        {{ $last }}
                    </a>

                @endif


                {{-- Next --}}
                @if ($donors->hasMorePages())

                    <a href="{{ $donors->nextPageUrl() }}"
                       class="pagination-arrow">
                        <i class="bi bi-chevron-right"></i>
                    </a>

                @else

                    <span class="pagination-arrow disabled">
                        <i class="bi bi-chevron-right"></i>
                    </span>

                @endif

            </div>

        </div>

    </div>

@endif

@endsection