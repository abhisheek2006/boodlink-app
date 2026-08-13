@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<style>
    /* ================================
       BLOOD LINK - PROFILE PAGE
    ================================= */

    .profile-page {
        padding: 8px 0 30px;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: minmax(0, 2.1fr) minmax(300px, .9fr);
        gap: 22px;
        align-items: start;
    }

    /* Main cards */
    .profile-card,
    .side-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(20, 32, 56, 0.06);
        overflow: hidden;
    }

    /* Header */
    .profile-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px 26px;
        border-bottom: 1px solid #edf0f5;
    }

    .profile-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0f1;
        color: #ef233c;
        font-size: 24px;
        flex-shrink: 0;
    }

    .profile-card-header h4 {
        margin: 0;
        color: #111827;
        font-size: 24px;
        font-weight: 700;
    }

    .profile-card-header p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    /* Form */
    .profile-card-body {
        padding: 26px;
    }

    .profile-form .form-label {
        color: #172033;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .profile-form .form-control,
    .profile-form .form-select {
        min-height: 48px;
        border-radius: 11px;
        border: 1px solid #dfe5ed;
        background: #fff;
        color: #273449;
        padding: 10px 14px;
        font-size: 14px;
        box-shadow: none;
        transition: all .2s ease;
    }

    .profile-form textarea.form-control {
        min-height: 88px;
        resize: vertical;
    }

    .profile-form .form-control:focus,
    .profile-form .form-select:focus {
        border-color: #ef233c;
        box-shadow: 0 0 0 3px rgba(239, 35, 60, .08);
    }

    .profile-form input[type="file"] {
        padding-top: 9px;
    }

    /* Input icons */
    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper .form-control {
        padding-right: 44px;
    }

    .input-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }

    /* Save button */
    .save-profile-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ef233c;
        border: none;
        color: #fff;
        padding: 12px 22px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 5px 12px rgba(239, 35, 60, .18);
        transition: all .2s ease;
    }

    .save-profile-btn:hover {
        background: #d91e36;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Section divider */
    .profile-section-divider {
        margin: 28px 0 22px;
        border: 0;
        border-top: 1px solid #edf0f5;
    }

    .profile-section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #172033;
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .profile-section-title::before {
        content: "";
        width: 4px;
        height: 21px;
        background: #ef233c;
        border-radius: 10px;
    }

    /* Side cards */
    .photo-card {
        text-align: center;
        padding: 28px 22px;
    }

    .photo-preview {
        width: 118px;
        height: 118px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border: 5px solid #eef2f7;
        overflow: hidden;
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-preview i {
        font-size: 76px;
        color: #2563eb;
    }

    .photo-card p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .remove-photo-btn {
        margin-top: 14px;
        border-radius: 9px;
    }

    /* Password card */
    .password-card-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 21px 23px 14px;
    }

    .password-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #fff0f1;
        color: #ef233c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .password-card-header h5 {
        margin: 0;
        color: #172033;
        font-size: 17px;
        font-weight: 700;
    }

    .password-card-header p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .password-card-body {
        padding: 8px 23px 23px;
    }

    .password-field {
        position: relative;
    }

    .password-field .form-control {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #94a3b8;
        padding: 4px;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle:hover {
        color: #ef233c;
    }

    .update-password-btn {
        width: 100%;
        min-height: 45px;
        border-radius: 10px;
        background: #fff;
        color: #ef233c;
        border: 1px solid #ef233c;
        font-weight: 600;
        transition: all .2s ease;
    }

    .update-password-btn:hover {
        background: #ef233c;
        color: #fff;
    }

    /* Select multiple */
    .status-select {
        min-height: 130px !important;
        padding: 5px !important;
    }

    .status-select option {
        padding: 8px 10px;
    }

    .form-help {
        color: #64748b;
        font-size: 12px;
        margin-top: 7px;
    }

    /* Mobile */
    @media (max-width: 991px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 575px) {
        .profile-card-header,
        .profile-card-body {
            padding: 20px;
        }

        .profile-card-header h4 {
            font-size: 21px;
        }
    }
</style>

<div class="profile-page">

    <div class="profile-grid">

        {{-- =========================================
             LEFT: EDIT PROFILE
        ========================================== --}}
        <div class="profile-card">

            <div class="profile-card-header">
                <div class="profile-title-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>
                    <h4>Edit Profile</h4>
                    <p>Update your personal information</p>
                </div>
            </div>

            <div class="profile-card-body">

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                    enctype="multipart/form-data"
                    class="profile-form"
                >
                    @csrf
                    @method('PUT')

                    {{-- ================= BASIC DETAILS ================= --}}
                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>

                            <input
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control"
                                required
                            >
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>

                            <div class="input-icon-wrapper">
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="form-control"
                                    required
                                >

                                <span class="input-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>

                            <input
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                class="form-control"
                                required
                            >
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>

                            <select name="gender" class="form-select" required>
                                @foreach (['Male', 'Female', 'Other'] as $g)
                                    <option
                                        value="{{ $g }}"
                                        @selected(old('gender', $user->gender) === $g)
                                    >
                                        {{ $g }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Date of Birth --}}
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>

                            <div class="input-icon-wrapper">
                                <input
                                    type="date"
                                    name="dob"
                                    value="{{ old('dob', optional($user->dob)->toDateString()) }}"
                                    class="form-control"
                                    required
                                >

                                <span class="input-icon">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                            </div>
                        </div>

                        {{-- Profile Photo --}}
                        <div class="col-md-6">
                            <label class="form-label">Profile Photo</label>

                            <input
                                type="file"
                                name="profile_photo"
                                class="form-control"
                                accept="image/*"
                            >
                        </div>

                        {{-- Address --}}
                        <div class="col-12">
                            <label class="form-label">Address</label>

                            <textarea
                                name="address"
                                class="form-control"
                                required
                            >{{ old('address', $user->donor->address ?? $user->patient->address ?? '') }}</textarea>
                        </div>

                        {{-- City --}}
                        <div class="col-md-4">
                            <label class="form-label">City</label>

                            <input
                                name="city"
                                value="{{ old('city', $user->donor->city ?? $user->patient->city ?? '') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        {{-- State --}}
                        <div class="col-md-4">
                            <label class="form-label">State</label>

                            <input
                                name="state"
                                value="{{ old('state', $user->donor->state ?? $user->patient->state ?? '') }}"
                                class="form-control"
                                required
                            >
                        </div>

                        {{-- PIN --}}
                        <div class="col-md-4">
                            <label class="form-label">PIN Code</label>

                            <input
                                name="pincode"
                                value="{{ old('pincode', $user->donor->pincode ?? $user->patient->pincode ?? '') }}"
                                class="form-control"
                                required
                            >
                        </div>

                    </div>


                    {{-- ================= DONOR DETAILS ================= --}}
                    @if ($user->isDonor())

                        <hr class="profile-section-divider">

                        <div class="profile-section-title">
                            Donor Details
                        </div>

                        <div class="row g-3">

                            {{-- Blood Group --}}
                            <div class="col-md-6">
                                <label class="form-label">Blood Group</label>

                                <select
                                    name="blood_group_id"
                                    class="form-select"
                                    required
                                >
                                    @foreach (
                                        \App\Models\BloodGroup::where('status', 'Active')
                                        ->orWhere('id', $user->donor->blood_group_id)
                                        ->orderBy('name')
                                        ->get()
                                        as $bg
                                    )
                                        <option
                                            value="{{ $bg->id }}"
                                            @selected(old('blood_group_id', $user->donor->blood_group_id) == $bg->id)
                                        >
                                            {{ $bg->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Weight --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    Weight (kg, min 45)
                                </label>

                                <input
                                    type="number"
                                    step="0.1"
                                    name="weight"
                                    value="{{ old('weight', $user->donor->weight) }}"
                                    class="form-control"
                                    required
                                >
                            </div>

                            {{-- Medical History --}}
                            <div class="col-12">
                                <label class="form-label">
                                    Medical History
                                </label>

                                <textarea
                                    name="medical_history"
                                    class="form-control"
                                >{{ old('medical_history', $user->donor->medical_history) }}</textarea>
                            </div>

                        </div>

                    @endif


                    {{-- ================= PATIENT DETAILS ================= --}}
                    @if ($user->isPatient())

                        <hr class="profile-section-divider">

                        <div class="profile-section-title">
                            Patient Details
                        </div>

                        <div class="row g-3">

                            {{-- Emergency Contact --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    Emergency Contact
                                </label>

                                <input
                                    name="emergency_contact"
                                    value="{{ old('emergency_contact', $user->patient->emergency_contact) }}"
                                    class="form-control"
                                    required
                                >
                            </div>

                            {{-- Required Blood Group --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    Required Blood Group (optional)
                                </label>

                                <select
                                    name="required_blood_group_id"
                                    class="form-select"
                                >
                                    <option value="">-- none --</option>

                                    @foreach (
                                        \App\Models\BloodGroup::where('status', 'Active')
                                        ->orderBy('name')
                                        ->get()
                                        as $bg
                                    )
                                        <option
                                            value="{{ $bg->id }}"
                                            @selected(
                                                old(
                                                    'required_blood_group_id',
                                                    $user->patient->required_blood_group_id
                                                ) == $bg->id
                                            )
                                        >
                                            {{ $bg->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    @endif


                    {{-- Save --}}
                    <div class="mt-4">
                        <button type="submit" class="save-profile-btn">
                            <i class="bi bi-save"></i>
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>


        {{-- =========================================
             RIGHT SIDEBAR
        ========================================== --}}
        <div>

            {{-- ================= PROFILE PHOTO ================= --}}
            <div class="side-card photo-card mb-4">

                <div class="photo-preview">

                    @if ($user->profile_photo)

                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo) }}"
                            alt="Profile Photo"
                        >

                    @else

                        <i class="bi bi-person-circle"></i>

                    @endif

                </div>

                @if ($user->profile_photo)

                    <p>Profile photo uploaded.</p>

                    <form
                        action="{{ route('profile.photo.remove') }}"
                        method="POST"
                        onsubmit="return confirm('Remove your profile photo?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-sm btn-outline-danger remove-photo-btn"
                        >
                            <i class="bi bi-trash me-1"></i>
                            Remove Photo
                        </button>
                    </form>

                @else

                    <p>No profile photo uploaded.</p>

                @endif

            </div>


            {{-- ================= CHANGE PASSWORD ================= --}}
            <div class="side-card">

                <div class="password-card-header">

                    <div class="password-icon">
                        <i class="bi bi-lock"></i>
                    </div>

                    <div>
                        <h5>Change Password</h5>
                        <p>Keep your account secure</p>
                    </div>

                </div>


                <div class="password-card-body">

                    <form
                        method="POST"
                        action="{{ route('profile.password') }}"
                    >
                        @csrf
                        @method('PUT')


                        {{-- Current Password --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Current Password
                            </label>

                            <div class="password-field">

                                <input
                                    type="password"
                                    name="current_password"
                                    class="form-control"
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


                        {{-- New Password --}}
                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <div class="password-field">

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
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
                        <div class="mb-3">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <div class="password-field">

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
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


                        <button
                            type="submit"
                            class="update-password-btn"
                        >
                            <i class="bi bi-lock me-2"></i>
                            Update Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


@push('scripts')
<script>
    document.querySelectorAll('.password-toggle').forEach(function(button) {

        button.addEventListener('click', function() {

            const input = this.parentElement.querySelector('input');
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
</script>
@endpush

@endsection