@extends('layouts.app')

@section('title', 'Register as Donor')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm mt-3 mb-5">

            <div class="card-body p-4 p-md-5">

                {{-- Header --}}
                <div class="text-center mb-4">

                    <div
                        class="rounded-circle bg-danger bg-opacity-10
                               d-inline-flex align-items-center justify-content-center
                               mb-3"
                        style="width:64px;height:64px;"
                    >
                        <i class="bi bi-heart-pulse-fill text-danger fs-2"></i>
                    </div>

                    <h4 class="mb-1">
                        Become a Donor
                    </h4>

                    <p class="text-muted small mb-0">
                        Join a community that saves lives with every donation
                    </p>

                </div>


                {{-- Donor Registration Form --}}
                <form
                    method="POST"
                    action="{{ route('register.donor') }}"
                    enctype="multipart/form-data"
                >

                    @csrf

                    {{-- Role is fixed as Donor --}}
                    <input type="hidden" name="role" value="Donor">


                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control"
                                placeholder="John Doe"
                                required
                            >

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="you@example.com"
                                required
                            >

                        </div>


                        {{-- Password --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="password-field">

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
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

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <div class="password-field">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
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

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input
                                name="phone"
                                value="{{ old('phone') }}"
                                class="form-control"
                                placeholder="+1 555 0000"
                                required
                            >

                        </div>


                        {{-- Gender --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Gender
                            </label>

                            <select
                                name="gender"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select gender
                                </option>

                                <option
                                    value="Male"
                                    @selected(old('gender') === 'Male')
                                >
                                    Male
                                </option>

                                <option
                                    value="Female"
                                    @selected(old('gender') === 'Female')
                                >
                                    Female
                                </option>

                                <option
                                    value="Other"
                                    @selected(old('gender') === 'Other')
                                >
                                    Other
                                </option>

                            </select>

                        </div>


                        {{-- Date of Birth --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                name="dob"
                                value="{{ old('dob') }}"
                                class="form-control"
                                required
                            >

                        </div>


                        {{-- Profile Photo --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Profile Photo
                            </label>

                            <input
                                type="file"
                                name="profile_photo"
                                class="form-control"
                                accept="image/*"
                            >

                        </div>


                        {{-- Address --}}
                        <div class="col-12">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                placeholder="Street, neighborhood"
                                required
                            >{{ old('address') }}</textarea>

                        </div>


                        {{-- City --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                City
                            </label>

                            <input
                                name="city"
                                value="{{ old('city') }}"
                                class="form-control"
                                placeholder="City"
                                required
                            >

                        </div>


                        {{-- State --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                State / Province
                            </label>

                            <input
                                name="state"
                                value="{{ old('state') }}"
                                class="form-control"
                                placeholder="State"
                                required
                            >

                        </div>


                        {{-- PIN --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                PIN / ZIP Code
                            </label>

                            <input
                                name="pincode"
                                value="{{ old('pincode') }}"
                                class="form-control"
                                placeholder="PIN / ZIP"
                                required
                            >

                        </div>


                        {{-- Donor Information --}}
                        <div class="col-12">

                            <hr class="my-3">

                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-droplet-fill text-danger me-2"></i>
                                Donor Information
                            </h6>

                        </div>


                        {{-- Blood Group --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Blood Group <span class="text-danger">*</span>
                            </label>

                            <select
                                name="blood_group_id"
                                class="form-select"
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

                            <label class="form-label">
                                Weight (kg, min 45) <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                step="0.1"
                                name="weight"
                                value="{{ old('weight') }}"
                                class="form-control"
                                min="45"
                                placeholder="Minimum 45 kg"
                                required
                            >

                        </div>


                        {{-- Medical History --}}
                        <div class="col-12">

                            <label class="form-label">
                                Medical History
                                <span class="text-muted">
                                    (optional)
                                </span>
                            </label>

                            <textarea
                                name="medical_history"
                                class="form-control"
                                placeholder="e.g. No known conditions, medications..."
                            >{{ old('medical_history') }}</textarea>

                        </div>


                        {{-- Last Donation --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Last Donation Date
                                <span class="text-muted">
                                    (optional)
                                </span>
                            </label>

                            <input
                                type="date"
                                name="last_donation_date"
                                value="{{ old('last_donation_date') }}"
                                class="form-control"
                            >

                        </div>

                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="btn btn-primary w-100 mt-4 py-2"
                    >
                        <i class="bi bi-heart-pulse me-2"></i>
                        Create Donor Account
                    </button>

                </form>


                {{-- Login --}}
                <p class="text-center mt-4 small mb-0">

                    Already have an account?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>
</div>

@endsection