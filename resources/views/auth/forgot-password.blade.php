@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')

<style>
    .forgot-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 35px 20px;
        background: #f8fafc;
    }

    .forgot-card {
        width: 100%;
        max-width: 460px;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 22px;
        padding: 42px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .06);
    }

    .forgot-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffe8ed;
        color: #e51e3f;
        font-size: 30px;
    }

    .forgot-title {
        color: #111827;
        font-size: 25px;
        font-weight: 800;
        margin-bottom: 8px;
        text-align: center;
    }

    .forgot-description {
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
        text-align: center;
        margin-bottom: 28px;
    }

    .forgot-label {
        display: block;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
        text-align: left;
    }

    .forgot-input-wrapper {
        position: relative;
    }

    .forgot-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    .forgot-input {
        width: 100%;
        height: 46px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 0 14px 0 42px;
        color: #334155;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .forgot-input:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, .08);
    }

    .forgot-button {
        width: 100%;
        height: 46px;
        border: 0;
        border-radius: 11px;
        background: #e51e3f;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        margin-top: 20px;
        transition: all .2s ease;
        box-shadow: 0 5px 14px rgba(229, 30, 63, .18);
    }

    .forgot-button:hover {
        background: #c91836;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(229, 30, 63, .22);
    }

    .forgot-footer {
        margin-top: 24px;
        text-align: center;
        font-size: 12px;
        color: #64748b;
    }

    .forgot-footer a {
        color: #e51e3f;
        font-weight: 700;
        text-decoration: none;
    }

    .forgot-footer a:hover {
        text-decoration: underline;
    }

    .security-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #edf0f4;
        color: #94a3b8;
        font-size: 11px;
    }

    .security-note i {
        color: #16a66a;
    }

    @media (max-width: 576px) {

        .forgot-page {
            padding: 20px 15px;
        }

        .forgot-card {
            padding: 30px 22px;
            border-radius: 18px;
        }

        .forgot-title {
            font-size: 22px;
        }

        .forgot-icon {
            width: 64px;
            height: 64px;
            font-size: 26px;
        }
    }
</style>


<div class="forgot-page">

    <div class="forgot-card">

        {{-- Icon --}}
        <div class="forgot-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>


        {{-- Heading --}}
        <h1 class="forgot-title">
            Forgot your password?
        </h1>

        <p class="forgot-description">
            No worries. Enter the email address associated with your
            Blood Link account and we'll send you a secure password
            reset link.
        </p>


        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}">

            @csrf

            <div class="mb-2">

                <label class="forgot-label">
                    Email Address
                </label>

                <div class="forgot-input-wrapper">

                    <i class="bi bi-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="forgot-input"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >

                </div>

                @error('email')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Submit --}}
            <button type="submit" class="forgot-button">

                <i class="bi bi-send me-2"></i>
                Send Reset Link

            </button>

        </form>


        {{-- Back to Login --}}
        <div class="forgot-footer">

            Remember your password?

            <a href="{{ route('login') }}">
                Back to Login
            </a>

        </div>


        {{-- Security Note --}}
        <div class="security-note">

            <i class="bi bi-shield-check"></i>

            Your account information is kept secure.

        </div>

    </div>

</div>

@endsection