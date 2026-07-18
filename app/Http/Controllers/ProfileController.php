<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['donor.bloodGroup', 'patient.requiredBloodGroup']);

        return view('profile.edit', ['user' => $user]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'profile_photo' => $data['profile_photo'] ?? $user->profile_photo,
        ]);

        if ($user->isDonor()) {
            $user->donor->update([
                'blood_group_id' => $data['blood_group_id'],
                'weight' => $data['weight'],
                'medical_history' => $data['medical_history'] ?? null,
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
            ]);
        }

        if ($user->isPatient()) {
            $user->patient->update([
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'emergency_contact' => $data['emergency_contact'],
                'required_blood_group_id' => $data['required_blood_group_id'] ?? null,
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function removePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Profile photo removed.');
    }
}
