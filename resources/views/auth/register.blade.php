@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mt-3 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                        <i class="bi bi-heart-pulse-fill text-danger fs-2"></i>
                    </div>
                    <h4 class="mb-1">Create your Blood Link account</h4>
                    <p class="text-muted small mb-0">
                        @if (($role ?? null) === 'Patient')
                            Register to start searching for matching blood donors
                        @else
                            Join a community that saves lives with every donation
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    @php
                        $fixedRole = $role ?? null;
                    @endphp

                    @if ($fixedRole)
                        <input type="hidden" name="role" value="{{ $fixedRole }}">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <i class="bi {{ $fixedRole === 'Donor' ? 'bi-heart-pulse' : 'bi-person-heart' }} fs-4 me-2" style="color: var(--bl-secondary);"></i>
                            <span class="small text-muted mb-0">
                                Registering as a <span class="fw-semibold text-danger">{{ $fixedRole }}</span>
                                @if ($fixedRole === 'Donor')
                                    — <a href="{{ route('register.patient') }}" class="text-decoration-underline">register as a Patient instead</a>
                                @else
                                    — <a href="{{ route('register.donor') }}" class="text-decoration-underline">register as a Donor instead</a>
                                @endif
                            </span>
                        </div>
                    @else
                        <label class="form-label fw-semibold mb-1">I want to register as</label>
                        <div class="btn-group w-100 mb-4" role="group">
                            <input type="radio" class="btn-check" name="role" id="roleDonor" value="Donor" autocomplete="off" {{ old('role', 'Donor') == 'Donor' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="roleDonor"><i class="bi bi-heart-pulse"></i> Donor</label>

                            <input type="radio" class="btn-check" name="role" id="rolePatient" value="Patient" autocomplete="off" {{ old('role') == 'Patient' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="rolePatient"><i class="bi bi-person-heart"></i> Patient</label>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input name="name" value="{{ old('name') }}" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="you@example.com" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <div class="password-field">
                                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required>
                                <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <div class="password-field">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                                <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+1 555 0000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" placeholder="Street, neighborhood" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input name="city" value="{{ old('city') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State / Province</label>
                            <input name="state" value="{{ old('state') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PIN / ZIP Code</label>
                            <input name="pincode" value="{{ old('pincode') }}" class="form-control" required>
                        </div>
                    </div>

                    <div id="donorFields" class="row g-3 mt-1 @if ($fixedRole === 'Patient') d-none @endif">
                        <hr class="my-3">
                        <div class="col-md-6">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group_id" class="form-select" @if (!$fixedRole || $fixedRole === 'Donor') required @endif>
                                @foreach ($bloodGroups as $bg)
                                    <option value="{{ $bg->id }}" @selected(old('blood_group_id') == $bg->id)>{{ $bg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Weight (kg, min 45)</label>
                            <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" class="form-control" min="45" @if (!$fixedRole || $fixedRole === 'Donor') required @endif>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Medical History (optional)</label>
                            <textarea name="medical_history" class="form-control" placeholder="e.g. No known conditions, medications...">{{ old('medical_history') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Donation Date (optional)</label>
                            <input type="date" name="last_donation_date" value="{{ old('last_donation_date') }}" class="form-control">
                        </div>
                    </div>

                    <div id="patientFields" class="row g-3 mt-1 @if ($fixedRole === 'Donor') d-none @endif">
                        <hr class="my-3">
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact</label>
                            <input name="emergency_contact" value="{{ old('emergency_contact') }}" class="form-control" placeholder="Name & phone" @if (!$fixedRole || $fixedRole === 'Patient') required @endif>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Required Blood Group (optional)</label>
                            <select name="required_blood_group_id" class="form-select">
                                <option value="">-- none --</option>
                                @foreach ($bloodGroups as $bg)
                                    <option value="{{ $bg->id }}" @selected(old('required_blood_group_id') == $bg->id)>{{ $bg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-4 py-2">Create Account</button>
                </form>
                <p class="text-center mt-4 small mb-0">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const donorRadio  = document.getElementById('roleDonor');
    const patientRadio = document.getElementById('rolePatient');
    const donorFields  = document.getElementById('donorFields');
    const patientFields = document.getElementById('patientFields');
    const fixedRole = @json($fixedRole ?? null);

    function toggleFields() {
        if (fixedRole) {
            donorFields.classList.toggle('d-none', fixedRole !== 'Donor');
            patientFields.classList.toggle('d-none', fixedRole !== 'Patient');
            return;
        }
        const isDonor = donorRadio.checked;
        donorFields.classList.toggle('d-none', !isDonor);
        patientFields.classList.toggle('d-none', isDonor);
    }
    if (donorRadio) {
        donorRadio.addEventListener('change', toggleFields);
        patientRadio.addEventListener('change', toggleFields);
    }
    toggleFields();
</script>
@endpush
@endsection
