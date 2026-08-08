@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                        <i class="bi bi-droplet-fill text-danger fs-2"></i>
                    </div>
                    <h4 class="mb-1">Welcome back to Blood Link</h4>
                    <p class="text-muted small mb-0">Sign in to continue your life-saving journey</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@example.com" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <button class="btn btn-primary w-100 py-2">Login</button>
                </form>

                <div class="d-flex justify-content-between mt-4 small">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                    <a href="{{ route('register') }}">Create an account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
