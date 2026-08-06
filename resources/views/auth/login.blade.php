@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-droplet-fill text-danger" style="font-size:2.5rem;"></i>
                    <h4 class="mt-2">Welcome back to Blood Link</h4>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>
                </form>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
                    <a href="{{ route('register') }}" class="small">Create an account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
