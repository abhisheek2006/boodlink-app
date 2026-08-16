@extends('layouts.app')
@section('title', 'Login')

@section('content')

<style>
    .login-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 35px 20px;
        background: #f8fafc;
    }

    .login-card {
        width: 100%;
        max-width: 460px;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 22px;
        padding: 42px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .06);
    }

    .login-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffe8ed;
        color: #e51e3f;
        font-size: 30px;
    }

    .login-title {
        color: #111827;
        font-size: 25px;
        font-weight: 800;
        margin-bottom: 8px;
        text-align: center;
    }

    .login-description {
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
        text-align: center;
        margin-bottom: 28px;
    }

    .login-label {
        display: block;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .login-input-wrapper {
        position: relative;
    }

    .login-input-wrapper > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        z-index: 2;
    }

    .login-input {
        width: 100%;
        height: 46px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 0 42px;
        color: #334155;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .login-input:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(229, 30, 63, .08);
    }

    .password-toggle {
        position: absolute;
        right: 5px;
        top: 5px;
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s ease;
    }

    .password-toggle:hover {
        background: #fff0f1;
        color: #e51e3f;
    }

    .login-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
    }

    .remember-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .remember-wrapper input {
        width: 15px;
        height: 15px;
        accent-color: #e51e3f;
        cursor: pointer;
    }

    .remember-wrapper label {
        color: #64748b;
        font-size: 12px;
        cursor: pointer;
    }

    .forgot-link {
        color: #e51e3f;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .login-button {
        width: 100%;
        height: 46px;
        border: 0;
        border-radius: 11px;
        background: #e51e3f;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        margin-top: 22px;
        transition: all .2s ease;
        box-shadow: 0 5px 14px rgba(229, 30, 63, .18);
    }

    .login-button:hover {
        background: #c91836;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(229, 30, 63, .22);
    }

    .register-box {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #edf0f4;
        text-align: center;
        color: #64748b;
        font-size: 12px;
    }

    .register-box a {
        color: #e51e3f;
        font-weight: 700;
        text-decoration: none;
    }

    .register-box a:hover {
        text-decoration: underline;
    }

    .security-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        margin-top: 18px;
        color: #94a3b8;
        font-size: 11px;
    }

    .security-note i {
        color: #16a66a;
    }

    @media (max-width: 576px) {

        .login-page {
            padding: 20px 15px;
        }

        .login-card {
            padding: 30px 22px;
            border-radius: 18px;
        }

        .login-title {
            font-size: 22px;
        }

        .login-icon {
            width: 64px;
            height: 64px;
            font-size: 26px;
        }
    }
</style>


<div class="login-page">

    <div class="login-card">

        {{-- Logo / Icon --}}
        <div class="login-icon">
            <i class="bi bi-droplet-fill"></i>
        </div>


        {{-- Heading --}}
        <h1 class="login-title">
            Welcome back to Blood Link
        </h1>

        <p class="login-description">
            Sign in to continue your life-saving journey.
        </p>


        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">

            @csrf

            {{-- Email --}}
            <div class="mb-3">

                <label class="login-label">
                    Email Address
                </label>

                <div class="login-input-wrapper">

                    <i class="bi bi-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="login-input"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                        autofocus
                    >

                </div>

                @error('email')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Password --}}
            <div class="mb-2">

                <label class="login-label">
                    Password
                </label>

                <div class="login-input-wrapper">

                    <i class="bi bi-lock"></i>

                    <input
                        type="password"
                        name="password"
                        id="loginPassword"
                        class="login-input"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="passwordToggle"
                        aria-label="Toggle password visibility"
                    >
                        <i class="bi bi-eye-slash"></i>
                    </button>

                </div>

                @error('password')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Remember / Forgot --}}
            <div class="login-options">

                <div class="remember-wrapper">

                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <label for="remember">
                        Remember Me
                    </label>

                </div>

                <a
                    href="{{ route('password.request') }}"
                    class="forgot-link"
                >
                    Forgot Password?
                </a>

            </div>


            {{-- Login Button --}}
            <button
                type="submit"
                class="login-button"
            >
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Login
            </button>

        </form>


        {{-- Register --}}
        <div class="register-box">

            Don't have an account?

            <a href="{{ route('register.donor') }}">
                Create an account
            </a>

        </div>


        {{-- Security --}}
        <div class="security-note">

            <i class="bi bi-shield-check"></i>

            Your login information is securely protected.

        </div>

    </div>

</div>


{{-- Password Toggle --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const passwordInput = document.getElementById('loginPassword');
        const passwordToggle = document.getElementById('passwordToggle');

        if (!passwordInput || !passwordToggle) {
            return;
        }

        passwordToggle.addEventListener('click', function () {

            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

            } else {

                passwordInput.type = 'password';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

            }

        });

    });
</script>
@endpush

@endsection