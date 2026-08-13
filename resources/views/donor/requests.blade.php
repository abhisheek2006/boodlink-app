@extends('layouts.app')
@section('title', 'Blood Requests')

@section('content')

<div class="mb-4">
    <h1 class="fw-bold mb-1" style="font-size: 2rem; color: #17233c;">
        Incoming Blood Requests
    </h1>
    <div style="width: 58px; height: 3px; background: #ef2b2d; border-radius: 5px;"></div>
</div>

<div class="row g-4">
    @forelse ($requests as $request)

        <div class="col-12 col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm h-100"
                 style="
                    border-radius: 18px;
                    background: #ffffff;
                    overflow: hidden;
                 ">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        {{-- Patient Information --}}
                        <div class="d-flex align-items-center gap-3">

                            <div class="d-flex align-items-center justify-content-center"
                                 style="
                                    width: 72px;
                                    height: 72px;
                                    border-radius: 50%;
                                    background: #fff0f1;
                                    flex-shrink: 0;
                                 ">
                                <i class="bi bi-person"
                                   style="
                                      font-size: 2.2rem;
                                      color: #ef2b2d;
                                   "></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1" style="color: #17233c;">
                                    {{ $request->patient->user->name }}
                                </h5>

                                <div class="text-muted" style="font-size: 1rem;">
                                    Blood Group:
                                    <strong style="color: #17233c;">
                                        {{ $request->bloodGroup->name }}
                                    </strong>

                                    <span class="mx-1">•</span>

                                    Units:
                                    <strong style="color: #17233c;">
                                        {{ $request->units_required }}
                                    </strong>
                                </div>
                            </div>

                        </div>

                        {{-- Emergency Level --}}
                        <span class="badge rounded-3 px-3 py-2"
                              style="
                                background:
                                    {{ $request->emergency_level === 'Critical'
                                        ? '#ef2b2d'
                                        : ($request->emergency_level === 'High'
                                            ? '#f59e0b'
                                            : '#2874e8') }};
                                color: #fff;
                                font-size: 0.95rem;
                                font-weight: 600;
                              ">
                            {{ $request->emergency_level }}
                        </span>

                    </div>

                    {{-- Request Reason --}}
                    <div class="mt-3 mb-4">
                        <p class="mb-0 text-muted" style="font-size: 1rem;">
                            {{ $request->reason }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex gap-3">

                        <form method="POST"
                              action="{{ route('donor.requests.accept', $request) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn px-4 py-2 fw-semibold"
                                    style="
                                        background: #ffffff;
                                        color: #10b981;
                                        border: 1.5px solid #10b981;
                                        border-radius: 10px;
                                    ">
                                <i class="bi bi-check-circle me-1"></i>
                                Accept
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('donor.requests.reject', $request) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn px-4 py-2 fw-semibold"
                                    style="
                                        background: #ffffff;
                                        color: #ef2b2d;
                                        border: 1.5px solid #ef2b2d;
                                        border-radius: 10px;
                                    ">
                                <i class="bi bi-x-lg me-1"></i>
                                Reject
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    @empty

        <div class="col-12">
            <div class="card border-0 shadow-sm text-center p-5"
                 style="border-radius: 18px;">
                <div class="mb-3">
                    <i class="bi bi-envelope-open"
                       style="font-size: 3rem; color: #94a3b8;"></i>
                </div>

                <h5 class="fw-bold" style="color: #17233c;">
                    No Pending Requests
                </h5>

                <p class="text-muted mb-0">
                    There are no blood donation requests available right now.
                </p>
            </div>
        </div>

    @endforelse
</div>

{{-- Pagination --}}
@if ($requests->hasPages())
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
@endif

@endsection