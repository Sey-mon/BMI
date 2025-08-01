<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'barangay' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'sex' => ['required', 'in:male,female'],
            'total_household_members' => ['required', 'integer', 'min:1'],
            'household_adults' => ['required', 'integer', 'min:1'],
            'household_children' => ['required', 'integer', 'min:0'],
            'is_twin' => ['boolean'],
            'is_4ps_beneficiary' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'barangay' => $request->barangay,
            'role' => 'parents', // Set default role
            'status' => 'email_pending', // Set default status
            'is_active' => true, // Set as active
            'email_verification_attempts' => 0, // Initialize attempts
        ]);

        event(new Registered($user));

        // Send email verification
        $user->sendEmailVerificationNotification();

        // Don't auto-login the user - they need to verify email first
        return redirect()->route('verification.notice')
            ->with('status', 'Registration successful! Please check your email to verify your account.');
    }
}
