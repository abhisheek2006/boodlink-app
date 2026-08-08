@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                        <i class="bi bi-key-fill text-danger fs-3"></i>
                    </div>
                    <h5 class="mb-1">Choose a new password</h5>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $email }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2 mt-3">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
