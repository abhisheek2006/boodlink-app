@extends('layouts.app')
@section('title', 'Register as Patient')

@section('content')

<style>
    .register-page {
        min-height: calc(100vh - 80px);
        padding: 35px 20px 50px;
        background: #f8fafc;
    }

    .register-card {
        max-width: 900px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #edf0f4;
        border-radius: 22px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .register-header {
        text-align: center;
        padding: 38px 40px 28px;
    }

    .register-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffe8ed;
        color: #e51e3f;
        font-size: 30px;
    }

    .register-title {
        color: #111827;
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .register-subtitle {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .register-body {
        padding: 10px 42px 40px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 22px 0 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf0f4;
        color: #172033;
        font-size: 14px;
        font-weight: 800;
    }

    .section-title i {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #fff0f1;
        color: #e51e3f;
    }

    .register-label {
        display: block;
        color: #172033;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .required-mark {
        color: #e51e3f;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
    }

    .register-input,
    .register-select,
    .register-textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #ffffff;
        color: #334155;
        font-size: 13px;
        outline: none;
        transition: all .2s ease;
    }

    .register-input,
    .register-select {
        height: 45px;
        padding: 0 14px;
    }

    .input-wrapper .register-input {
        padding-left: 40px;
        padding-right: 40px;
    }

    .register-textarea {
        min-height: 95px;
        padding: 12px 14px;
        resize: vertical;
    }

    .register-input:focus,
    .register-select:focus,
    .register-textarea:focus {
        border-color: #f25a70;
        box-shadow: 0 0 0 3px rgba(229, 30, 63, .08);
    }

    .password-toggle {
        position: absolute;
        right: 5px;
        top: 4px;
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
    }

    .password-toggle:hover {
        background: #fff0f1;
        color: #e51e3f;
    }

    .file-input {
        padding-top: 9px;
        cursor: pointer;
    }

    .patient-info {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 13px 15px;
        margin-top: 22px;
        background: #eef5ff;
        border: 1px solid #dbeafe;
        border-radius: 11px;
        color: #1e40af;
        font-size: 12px;
        line-height: 1.5;
    }

    .patient-info i {
        color: #2874e8;
        font-size: 17px;
    }

    .register-button {
        width: 100%;
        height: 48px;
        margin-top: 28px;
        border: 0;
        border-radius: 11px;
        background: #e51e3f;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 5px 14px rgba(229, 30, 63, .18);
        transition: all .2s ease;
    }

    .register-button:hover {
        background: #c91836;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(229, 30, 63, .22);
    }

    .login-link {
        text-align: center;
        margin-top: 22px;
        color: #64748b;
        font-size: 12px;
    }

    .login-link a {
        color: #e51e3f;
        font-weight: 700;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .security-note {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        margin-top: 18px;
        color: #94a3b8;
        font-size: 11px;
    }

    .security-note i {
        color: #16a66a;
    }

    @media (max-width: 768px) {
        .register-page {
            padding: 20px 12px 35px;
        }

        .register-header {
            padding: 30px 20px 20px;
        }

        .register-body {
            padding: 5px 20px 30px;
        }

        .register-title {
            font-size: 23px;
        }
    }

    @media (max-width: 576px) {
        .register-card {
            border-radius: 18px;
        }

        .register-icon {
            width: 64px;
            height: 64px;
            font-size: 26px;
        }
    }
</style>


<div class="register-page">

    <div class="register-card">

        {{-- Header --}}
        <div class="register-header">

            <div class="register-icon">
                <i class="bi bi-person-heart"></i>
            </div>

            <h1 class="register-title">
                Find a Donor
            </h1>

            <p class="register-subtitle">
                Register as a patient to find compatible blood donors.
            </p>

        </div>


        <div class="register-body">

            <form method="POST"
                  action="{{ route('register.patient') }}"
                  enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="role" value="Patient">


                {{-- Personal Information --}}
                <div class="section-title">

                    <i class="bi bi-person"></i>

                    Personal Information

                </div>


                <div class="row g-3">

                    {{-- Full Name --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Full Name
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-person"></i>

                            <input
                                name="name"
                                value="{{ old('name') }}"
                                class="register-input"
                                placeholder="John Doe"
                                required
                            >

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Email Address
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="register-input"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                            >

                        </div>

                    </div>


                    {{-- Password --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Password
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                name="password"
                                class="register-input password-input"
                                placeholder="Min. 8 characters"
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


                    {{-- Confirm Password --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Confirm Password
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-lock-fill"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="register-input password-input"
                                placeholder="Repeat password"
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


                    {{-- Phone --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Phone Number
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-telephone"></i>

                            <input
                                name="phone"
                                value="{{ old('phone') }}"
                                class="register-input"
                                placeholder="+1 555 0000"
                                required
                            >

                        </div>

                    </div>


                    {{-- Gender --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Gender
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            name="gender"
                            class="register-select"
                            required
                        >

                            <option value="">
                                Select gender
                            </option>

                            <option value="Male"
                                @selected(old('gender') === 'Male')}>
                                Male
                            </option>

                            <option value="Female"
                                @selected(old('gender') === 'Female')}>
                                Female
                            </option>

                            <option value="Other"
                                @selected(old('gender') === 'Other')}>
                                Other
                            </option>

                        </select>

                    </div>


                    {{-- DOB --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Date of Birth
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-calendar3"></i>

                            <input
                                type="date"
                                name="dob"
                                value="{{ old('dob') }}"
                                class="register-input"
                                required
                            >

                        </div>

                    </div>


                    {{-- Profile Photo --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Profile Photo
                        </label>

                        <input
                            type="file"
                            name="profile_photo"
                            class="form-control register-input file-input"
                            accept="image/*"
                        >

                    </div>


                    {{-- Address --}}
                    <div class="col-12">

                        <label class="register-label">
                            Address
                            <span class="required-mark">*</span>
                        </label>

                        <textarea
                            name="address"
                            class="register-textarea"
                            placeholder="Street, neighborhood"
                            required
                        >{{ old('address') }}</textarea>

                    </div>


                    {{-- City --}}
                    <div class="col-md-4">

                        <label class="register-label">
                            City
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            name="city"
                            value="{{ old('city') }}"
                            class="register-input"
                            placeholder="City"
                            required
                        >

                    </div>


                    {{-- State --}}
                    <div class="col-md-4">

                        <label class="register-label">
                            State / Province
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            name="state"
                            value="{{ old('state') }}"
                            class="register-input"
                            placeholder="State"
                            required
                        >

                    </div>


                    {{-- PIN --}}
                    <div class="col-md-4">

                        <label class="register-label">
                            PIN / ZIP Code
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            name="pincode"
                            value="{{ old('pincode') }}"
                            class="register-input"
                            placeholder="PIN / ZIP"
                            required
                        >

                    </div>

                </div>


                {{-- Patient Information --}}
                <div class="section-title mt-4">

                    <i class="bi bi-heart-pulse-fill"></i>

                    Patient Information

                </div>


                <div class="row g-3">

                    {{-- Emergency Contact --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Emergency Contact
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-telephone-forward"></i>

                            <input
                                name="emergency_contact"
                                value="{{ old('emergency_contact') }}"
                                class="register-input"
                                placeholder="Name & phone"
                                required
                            >

                        </div>

                    </div>


                    {{-- Required Blood Group --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Required Blood Group
                            <span class="text-muted fw-normal">
                                (optional)
                            </span>
                        </label>

                        <select
                            name="required_blood_group_id"
                            class="register-select"
                        >

                            <option value="">
                                -- None --
                            </option>

                            @foreach ($bloodGroups as $bg)

                                <option
                                    value="{{ $bg->id }}"
                                    @selected(old('required_blood_group_id') == $bg->id)
                                >
                                    {{ $bg->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Information Note --}}
                <div class="patient-info">

                    <i class="bi bi-info-circle-fill"></i>

                    <div>

                        <strong>Need blood?</strong><br>

                        Your information helps Blood Link connect you
                        with compatible donors when you need blood.
                        Please make sure your contact details are accurate.

                    </div>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="register-button"
                >

                    <i class="bi bi-person-heart me-2"></i>

                    Create Patient Account

                </button>

            </form>


            {{-- Login --}}
            <div class="login-link">

                Already have an account?

                <a href="{{ route('login') }}">
                    Login
                </a>

            </div>


            {{-- Security --}}
            <div class="security-note">

                <i class="bi bi-shield-check"></i>

                Your personal information is securely protected.

            </div>

        </div>

    </div>

</div>


{{-- Password Toggle --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.password-toggle').forEach(function (button) {

            button.addEventListener('click', function () {

                const wrapper = this.closest('.input-wrapper');
                const input = wrapper.querySelector('.password-input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {

                    input.type = 'text';

                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');

                } else {

                    input.type = 'password';

                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');

                }

            });

        });

    });
</script>
@endpush

@endsection