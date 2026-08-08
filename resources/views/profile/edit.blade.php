@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0">Edit Profile</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                @foreach (['Male', 'Female', 'Other'] as $g)
                                    <option value="{{ $g }}" @selected(old('gender', $user->gender) === $g)>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', optional($user->dob)->toDateString()) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" required>{{ old('address', $user->donor->address ?? $user->patient->address ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input name="city" value="{{ old('city', $user->donor->city ?? $user->patient->city ?? '') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input name="state" value="{{ old('state', $user->donor->state ?? $user->patient->state ?? '') }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PIN Code</label>
                            <input name="pincode" value="{{ old('pincode', $user->donor->pincode ?? $user->patient->pincode ?? '') }}" class="form-control" required>
                        </div>
                    </div>

                    @if ($user->isDonor())
                        <hr class="my-4">
                        <h6 class="mb-3">Donor Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group_id" class="form-select" required>
                                    @foreach (\App\Models\BloodGroup::where('status', 'Active')->orWhere('id', $user->donor->blood_group_id)->orderBy('name')->get() as $bg)
                                        <option value="{{ $bg->id }}" @selected(old('blood_group_id', $user->donor->blood_group_id) == $bg->id)>{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Weight (kg, min 45)</label>
                                <input type="number" step="0.1" name="weight" value="{{ old('weight', $user->donor->weight) }}" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Medical History</label>
                                <textarea name="medical_history" class="form-control">{{ old('medical_history', $user->donor->medical_history) }}</textarea>
                            </div>
                        </div>
                    @endif

                    @if ($user->isPatient())
                        <hr class="my-4">
                        <h6 class="mb-3">Patient Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input name="emergency_contact" value="{{ old('emergency_contact', $user->patient->emergency_contact) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Required Blood Group (optional)</label>
                                <select name="required_blood_group_id" class="form-select">
                                    <option value="">-- none --</option>
                                    @foreach (\App\Models\BloodGroup::where('status', 'Active')->orderBy('name')->get() as $bg)
                                        <option value="{{ $bg->id }}" @selected(old('required_blood_group_id', $user->patient->required_blood_group_id) == $bg->id)>{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <button class="btn btn-primary mt-4 px-4">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Profile photo -->
        <div class="card border-0 shadow-sm mb-4 text-center">
            <div class="card-body p-4">
                @if ($user->profile_photo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo) }}" class="rounded-circle mx-auto mb-3" width="110" height="110" style="object-fit: cover;">
                    <form action="{{ route('profile.photo.remove') }}" method="POST" onsubmit="return confirm('Remove your profile photo?');" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Remove Photo</button>
                    </form>
                @else
                    <i class="bi bi-person-circle text-secondary mb-3" style="font-size: 5rem;"></i>
                    <p class="text-muted small mb-0">No profile photo uploaded.</p>
                @endif
            </div>
        </div>

        <!-- Change Password -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">Change Password</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="password-field">
                            <input type="password" name="current_password" class="form-control" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="password-field">
                            <input type="password" name="password" class="form-control" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" class="form-control" required>
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-outline-primary w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
