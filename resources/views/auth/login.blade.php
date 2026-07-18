@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-crimson-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="bi bi-droplet-fill text-crimson" style="font-size:2.2rem;"></i>
                    </div>
                    <h4 class="mt-3 fw-bold">Welcome back</h4>
                    <p class="text-secondary small">Sign in to access your Blood Link account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-envelope text-secondary"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="form-control border-start-0" 
                                   required autofocus>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock text-secondary"></i>
                            </span>
                            <input type="password" name="password" id="passwordField" 
                                   class="form-control border-start-0 border-end-0" 
                                   required>
                            <button type="button" id="togglePassword" 
                                    class="btn btn-outline-secondary border-start-0 bg-transparent" 
                                    tabindex="-1"
                                    style="border-left: none !important;">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>

                    <button class="btn btn-primary w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <div class="d-flex justify-content-between mt-4 pt-2 border-top">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                        <i class="bi bi-key me-1"></i>Forgot Password?
                    </a>
                    <a href="{{ route('register') }}" class="text-decoration-none small">
                        <i class="bi bi-person-plus me-1"></i>Create an account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('passwordField');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            // Check current state
            const isPasswordVisible = passwordField.getAttribute('type') === 'text';
            
            if (isPasswordVisible) {
                // Hide password - show asterisks
                passwordField.setAttribute('type', 'password');
                toggleIcon.className = 'bi bi-eye-slash';
                togglePassword.setAttribute('aria-label', 'Show password');
                // Change input text to asterisks for visual consistency
                passwordField.style.fontFamily = 'inherit';
            } else {
                // Show password - reveal text
                passwordField.setAttribute('type', 'text');
                toggleIcon.className = 'bi bi-eye';
                togglePassword.setAttribute('aria-label', 'Hide password');
            }
        });

        // Keyboard shortcut: Ctrl+Shift+P to toggle
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.shiftKey && (e.key === 'p' || e.key === 'P')) {
                e.preventDefault();
                togglePassword.click();
            }
        });

        // Add visual feedback for asterisk display
        const style = document.createElement('style');
        style.textContent = `
            /* Style password input to show asterisks with larger font */
            input[type="password"] {
                font-family: 'Courier New', monospace !important;
                letter-spacing: 2px;
                font-size: 1.1rem;
            }
            
            input[type="text"] {
                font-family: 'Inter', sans-serif !important;
                letter-spacing: normal;
                font-size: 0.9rem;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

@push('styles')
<style>
    /* Smooth transitions for the toggle button */
    #togglePassword {
        transition: all 0.2s ease;
        border-top-right-radius: 0.625rem;
        border-bottom-right-radius: 0.625rem;
        cursor: pointer;
        z-index: 5;
    }
    
    #togglePassword:hover {
        background: rgba(0,0,0,0.04) !important;
    }
    
    #togglePassword:focus {
        box-shadow: none;
        outline: none;
    }
    
    #togglePassword:active {
        transform: scale(0.95);
    }
    
    .input-group-text {
        border-top-left-radius: 0.625rem;
        border-bottom-left-radius: 0.625rem;
        background: transparent !important;
    }
    
    .input-group .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
    }
    
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(196, 30, 58, 0.15);
        border-radius: 0.625rem;
    }
    
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control,
    .input-group:focus-within #togglePassword {
        border-color: var(--bl-crimson, #C41E3A);
    }
    
    /* Style for the circular icon background */
    .bg-crimson-light {
        background: rgba(196, 30, 58, 0.10);
    }
    
    .text-crimson {
        color: var(--bl-crimson, #C41E3A);
    }

    /* Remove placeholder styling */
    .form-control::placeholder {
        color: transparent;
    }

    /* Ensure consistent input styling */
    .form-control {
        background: transparent;
    }

    /* Card hover effect */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.10) !important;
    }

    /* Button hover enhancement */
    .btn-primary {
        transition: all 0.25s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(196, 30, 58, 0.35);
    }

    /* Checkbox styling */
    .form-check-input:checked {
        background-color: var(--bl-crimson, #C41E3A);
        border-color: var(--bl-crimson, #C41E3A);
    }

    .form-check-input:focus {
        border-color: var(--bl-crimson, #C41E3A);
        box-shadow: 0 0 0 0.2rem rgba(196, 30, 58, 0.15);
    }

    /* Password field styling for asterisks */
    input[type="password"] {
        font-family: 'Courier New', 'IBM Plex Mono', monospace !important;
        letter-spacing: 3px;
        font-size: 1.15rem;
        font-weight: 600;
    }
    
    /* When password is visible (text mode) */
    input[type="text"] {
        font-family: 'Inter', sans-serif !important;
        letter-spacing: normal;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Smooth transition between password/text modes */
    #passwordField {
        transition: all 0.2s ease;
    }
</style>
@endpush
@endsection