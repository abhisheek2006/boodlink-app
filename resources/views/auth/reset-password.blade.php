@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-5">

        <div class="card border-0 shadow-sm mt-4 mb-5 overflow-hidden">

            {{-- Header --}}
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">

                    <div
                        class="rounded-circle bg-danger bg-opacity-10
                               d-inline-flex align-items-center justify-content-center
                               mb-3"
                        style="width:72px;height:72px;"
                    >
                        <i class="bi bi-shield-lock-fill text-danger fs-2"></i>
                    </div>

                    <h4 class="fw-bold mb-2">
                        Reset Your Password
                    </h4>

                    <p class="text-muted small mb-0">
                        Create a new secure password for your Blood Link account.
                    </p>

                </div>


                {{-- Form --}}
                <form method="POST" action="{{ route('password.update') }}">

                    @csrf

                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token }}"
                    >


                    {{-- Email --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Email Address
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-envelope text-danger"></i>
                            </span>

                            <input
                                type="email"
                                name="email"
                                value="{{ $email }}"
                                class="form-control"
                                placeholder="you@example.com"
                                required
                                readonly
                            >

                        </div>

                    </div>


                    {{-- New Password --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            New Password
                        </label>

                        <div class="password-field">

                            <input
                                type="password"
                                name="password"
                                id="newPassword"
                                class="form-control"
                                placeholder="Enter your new password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                aria-label="Toggle password visibility"
                            >
                                <i class="bi bi-eye-slash"></i>
                            </button>

                        </div>

                        <div class="form-text">
                            Use at least 8 characters.
                        </div>

                    </div>


                    {{-- Confirm Password --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Confirm New Password
                        </label>

                        <div class="password-field">

                            <input
                                type="password"
                                name="password_confirmation"
                                id="confirmPassword"
                                class="form-control"
                                placeholder="Repeat your new password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                aria-label="Toggle password visibility"
                            >
                                <i class="bi bi-eye-slash"></i>
                            </button>

                        </div>

                    </div>


                    {{-- Password Requirements --}}
                    <div class="alert alert-light border mb-4">

                        <div class="small fw-semibold mb-2">
                            <i class="bi bi-shield-check text-danger me-1"></i>
                            Password Security
                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-check-circle me-1"></i>
                            Minimum 8 characters
                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-check-circle me-1"></i>
                            Avoid using easily guessed passwords
                        </div>

                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="btn btn-primary w-100 py-2 fw-semibold"
                    >
                        <i class="bi bi-key-fill me-2"></i>
                        Reset Password
                    </button>

                </form>


                {{-- Back to Login --}}
                <div class="text-center mt-4">

                    <a
                        href="{{ route('login') }}"
                        class="small text-decoration-none"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Login
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection