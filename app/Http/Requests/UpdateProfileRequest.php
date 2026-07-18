<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'gender' => ['required', Rule::in(['Male', 'Female', 'Other'])],
            'dob' => ['required', 'date', 'before:-18 years'],

            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:120'],
            'state' => ['required', 'string', 'max:120'],
            'pincode' => ['required', 'string', 'max:10'],

            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        if ($this->user()->isDonor()) {
            $rules += [
                'blood_group_id' => [
                    'required',
                    Rule::exists('blood_groups', 'id')->where('status', 'Active'),
                ],
                'weight' => ['required', 'numeric', 'min:45'],
                'medical_history' => ['nullable', 'string', 'max:2000'],
            ];
        }

        if ($this->user()->isPatient()) {
            $rules += [
                'emergency_contact' => ['required', 'string', 'regex:/^[0-9+\-\s]{7,20}$/'],
                'required_blood_group_id' => [
                    'nullable',
                    Rule::exists('blood_groups', 'id')->where('status', 'Active'),
                ],
            ];
        }

        return $rules;
    }
}
