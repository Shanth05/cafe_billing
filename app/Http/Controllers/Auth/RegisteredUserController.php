<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // ✅ Returns the combined login/register Blade view
        return view('auth.login-register');
    }

    public function store(Request $request): RedirectResponse
    {
        // ✅ Validation for registration
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ✅ Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Assign role
        $user->assignRole('cashier');

        // ✅ Trigger Registered event (used for email verification, etc.)
        event(new Registered($user));

        // ✅ Redirect back to login tab with flash message
        return redirect()->route('auth.combined', ['tab' => 'login'])
                         ->with('status', 'Registration successful. Please login.');
    }
}