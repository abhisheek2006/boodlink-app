@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                    <i class="bi bi-send-lock text-primary fs-3"></i>
                </div>
                <h5 class="mb-2">Forgot your password?</h5>
                <p class="text-muted small mb-4">Enter your email and we'll send you a reset link.</p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                    </div>
                    <button class="btn btn-primary w-100 py-2">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
