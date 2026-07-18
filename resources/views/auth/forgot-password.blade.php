@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-body p-4">
                <h5 class="mb-3">Forgot your password?</h5>
                <p class="text-muted small">Enter your email and we'll send you a reset link.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email address" required>
                    </div>
                    <button class="btn btn-primary w-100">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
