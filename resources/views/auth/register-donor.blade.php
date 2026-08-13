@extends('layouts.app')
@section('title', 'Register as Donor')

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

    .field-help {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 5px;
    }

    .donor-info {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 13px 15px;
        margin-top: 22px;
        background: #fff7e8;
        border: 1px solid #fde7b0;
        border-radius: 11px;
        color: #92400e;
        font-size: 12px;
        line-height: 1.5;
    }

    .donor-info i {
        color: #f59e0b;
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
                <i class="bi bi-heart-pulse-fill"></i>
            </div>

            <h1 class="register-title">
                Become a Donor
            </h1>

            <p class="register-subtitle">
                Join a community that saves lives with every donation.
            </p>

        </div>


        <div class="register-body">

            <form method="POST"
                  action="{{ route('register.donor') }}"
                  enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="role" value="Donor">


                {{-- Personal Information --}}
                <div class="section-title">
                    <i class="bi bi-person"></i>
                    Personal Information
                </div>

                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Full Name <span class="required-mark">*</span>
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
                            Email Address <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="register-input"
                                placeholder="you@example.com"
                                required
                            >

                        </div>

                    </div>


                    {{-- Password --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Password <span class="required-mark">*</span>
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
                            Confirm Password <span class="required-mark">*</span>
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
                            Phone Number <span class="required-mark">*</span>
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
                            Gender <span class="required-mark">*</span>
                        </label>

                        <select
                            name="gender"
                            class="register-select"
                            required
                        >
                            <option value="">Select gender</option>
                            <option value="Male" @selected(old('gender') === 'Male')>
                                Male
                            </option>
                            <option value="Female" @selected(old('gender') === 'Female')>
                                Female
                            </option>
                            <option value="Other" @selected(old('gender') === 'Other')>
                                Other
                            </option>
                        </select>

                    </div>


                    {{-- DOB --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Date of Birth <span class="required-mark">*</span>
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
                            Address <span class="required-mark">*</span>
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
                            City <span class="required-mark">*</span>
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
                            State / Province <span class="required-mark">*</span>
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
                            PIN / ZIP Code <span class="required-mark">*</span>
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


                {{-- Donor Information --}}
                <div class="section-title mt-4">

                    <i class="bi bi-droplet-fill"></i>

                    Donor Information

                </div>


                <div class="row g-3">

                    {{-- Blood Group --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Blood Group <span class="required-mark">*</span>
                        </label>

                        <select
                            name="blood_group_id"
                            class="register-select"
                            required
                        >

                            <option value="">
                                Select blood group
                            </option>

                            @foreach ($bloodGroups as $bg)

                                <option
                                    value="{{ $bg->id }}"
                                    @selected(old('blood_group_id') == $bg->id)
                                >
                                    {{ $bg->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Weight --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Weight (kg) <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-speedometer2"></i>

                            <input
                                type="number"
                                step="0.1"
                                name="weight"
                                value="{{ old('weight') }}"
                                class="register-input"
                                min="45"
                                placeholder="Minimum 45 kg"
                                required
                            >

                        </div>

                        <div class="field-help">
                            Minimum required weight: 45 kg
                        </div>

                    </div>


                    {{-- Medical History --}}
                    <div class="col-12">

                        <label class="register-label">
                            Medical History
                            <span class="text-muted fw-normal">(optional)</span>
                        </label>

                        <textarea
                            name="medical_history"
                            class="register-textarea"
                            placeholder="e.g. No known conditions, medications..."
                        >{{ old('medical_history') }}</textarea>

                    </div>


                    {{-- Last Donation --}}
                    <div class="col-md-6">

                        <label class="register-label">
                            Last Donation Date
                            <span class="text-muted fw-normal">(optional)</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="bi bi-calendar-heart"></i>

                            <input
                                type="date"
                                name="last_donation_date"
                                value="{{ old('last_donation_date') }}"
                                class="register-input"
                            >

                        </div>

                    </div>

                </div>


                {{-- Information Note --}}
                <div class="donor-info">

                    <i class="bi bi-info-circle-fill"></i>

                    <div>
                        <strong>Before registering as a donor</strong><br>

                        Please make sure that the information you provide is
                        accurate. Your blood group and donor information will
                        be used to help match you with patients who need blood.
                    </div>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="register-button"
                >

                    <i class="bi bi-heart-pulse me-2"></i>

                    Create Donor Account

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