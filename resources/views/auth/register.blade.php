@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card mt-4 mb-5">
            <div class="card-body p-4">
                <h4 class="mb-4 text-center">Create your Blood Link account</h4>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <label class="form-label">I want to register as</label>
                    <div class="btn-group w-100 mb-3" role="group">
                        <input type="radio" class="btn-check" name="role" id="roleDonor" value="Donor" autocomplete="off" {{ old('role', 'Donor') == 'Donor' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="roleDonor"><i class="bi bi-heart-pulse"></i> Donor</label>

                        <input type="radio" class="btn-check" name="role" id="rolePatient" value="Patient" autocomplete="off" {{ old('role') == 'Patient' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="rolePatient"><i class="bi bi-person-heart"></i> Patient</label>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input name="phone" value="{{ old('phone') }}" class="form-control" required>
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
                            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input name="city" value="{{ old('city') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input name="state" value="{{ old('state') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PIN Code</label>
                            <input name="pincode" value="{{ old('pincode') }}" class="form-control" required>
                        </div>
                    </div>

                    <div id="donorFields" class="row g-3 mt-1">
                        <hr class="mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group_id" class="form-select">
                                @foreach ($bloodGroups as $bg)
                                    <option value="{{ $bg->id }}">{{ $bg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Weight (kg, min 45)</label>
                            <input type="number" step="0.1" name="weight" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Medical History (optional)</label>
                            <textarea name="medical_history" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Donation Date (optional)</label>
                            <input type="date" name="last_donation_date" class="form-control">
                        </div>
                    </div>

                    <div id="patientFields" class="row g-3 mt-1 d-none">
                        <hr class="mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact</label>
                            <input name="emergency_contact" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Required Blood Group (optional)</label>
                            <select name="required_blood_group_id" class="form-select">
                                <option value="">-- none --</option>
                                @foreach ($bloodGroups as $bg)
                                    <option value="{{ $bg->id }}">{{ $bg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-4">Create Account</button>
                </form>
                <p class="text-center mt-3 small">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const donorRadio = document.getElementById('roleDonor');
    const patientRadio = document.getElementById('rolePatient');
    const donorFields = document.getElementById('donorFields');
    const patientFields = document.getElementById('patientFields');

    function toggleFields() {
        const isDonor = donorRadio.checked;
        donorFields.classList.toggle('d-none', !isDonor);
        patientFields.classList.toggle('d-none', isDonor);
    }
    donorRadio.addEventListener('change', toggleFields);
    patientRadio.addEventListener('change', toggleFields);
    toggleFields();
</script>
@endpush
@endsection
