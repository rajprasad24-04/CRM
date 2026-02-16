<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
        // Validate the incoming request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class,  // Ensure email is unique in the User model
                'regex:/^[a-zA-Z0-9._%+-]+@wealixir\.com$/',  // Only allow @wealixir.com emails
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],  // Password confirmation and default rules
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Encrypt the password
        ]);

        // Trigger the Registered event
        event(new Registered($user));

        // Log in the user
        Auth::login($user);

        // Redirect to the home page
        return redirect(RouteServiceProvider::HOME);
    }
}
