@extends('layouts.app')
@section('title', 'Register as Patient')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mt-3 mb-5">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-secondary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:64px;height:64px;">
                        <i class="bi bi-person-heart fs-2" style="color: var(--bl-secondary);"></i>
                    </div>
                    <h4 class="mb-1">Find a Donor</h4>
                    <p class="text-muted small mb-0">Register as a patient to search for compatible donors</p>
                </div>

                <form method="POST" action="{{ route('register.patient') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="role" value="Patient">

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

                        <!-- Patient-specific fields -->
                        <hr class="my-3">
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact *</label>
                            <input name="emergency_contact" value="{{ old('emergency_contact') }}" class="form-control" placeholder="Name & phone" required>
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

                    <button class="btn btn-secondary w-100 mt-4 py-2">Create Patient Account</button>
                </form>
                <p class="text-center mt-4 small mb-0">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection