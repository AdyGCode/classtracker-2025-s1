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
//            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'family_name' => 'required',
            'given_name' => 'required',
            'preferred_name' => 'nullable',
            'pronouns' => 'required',
        ]);

        $user = User::create([
//            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'family_name' => $request->family_name,
            'given_name' => $request->given_name,
            'preferred_name' => $request->preferred_name ?? $request->given_name,
            'pronouns' => $request->pronouns,
        ]);

        $user->assignRole('Student');

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');

//        return redirect(route('dashboard', absolute: false));
    }
}
