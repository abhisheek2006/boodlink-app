<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\BloodGroup;
use App\Models\Donor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register', [
            'bloodGroups' => BloodGroup::where('status', 'Active')->orderBy('name')->get(),
        ]);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = DB::transaction(function () use ($data, $request) {
            $photoPath = $request->hasFile('profile_photo')
                ? $request->file('profile_photo')->store('profiles', 'public')
                : null;

            $user = User::create([
                'role' => $data['role'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'profile_photo' => $photoPath,
                'status' => 'Active',
            ]);

            if ($data['role'] === 'Donor') {
                Donor::create([
                    'user_id' => $user->id,
                    'blood_group_id' => $data['blood_group_id'],
                    'weight' => $data['weight'],
                    'medical_history' => $data['medical_history'] ?? null,
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'pincode' => $data['pincode'],
                    'last_donation_date' => $data['last_donation_date'] ?? null,
                    'availability' => 'Available',
                ]);
            } else {
                Patient::create([
                    'user_id' => $user->id,
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'pincode' => $data['pincode'],
                    'emergency_contact' => $data['emergency_contact'],
                    'required_blood_group_id' => $data['required_blood_group_id'] ?? null,
                ]);
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($user->dashboardRoute())
            ->with('success', 'Welcome to Blood Link! Your account has been created.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        if ($user->isBanned()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account has been banned. ' . ($user->ban_reason ?? ''),
            ]);
        }

        if ($user->isSuspended()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account is suspended until ' . optional($user->suspended_until)->toFormattedDateString() . '.',
            ]);
        }

        if (! $user->isActiveAccount()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact support.',
            ]);
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(route($user->dashboardRoute()));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(string $token, Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])
                    ->setRememberToken(Str::random(60))
                    ->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
