<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }

    // Create New User
    public function store(Request $request) {
        \Log::info('Request Input: ' . json_encode($request->all()));
        
        try {
            $formFields = $request->validate([
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|min:6',
                'avatar' => 'nullable|image|mimes:jpg,png,gif,jpeg|max:2048'
            ]);
            \Log::info('Validation successful.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        }
        \Log::info('step2');

        if( $request->hasFile('avatar') ) {
            $formFields['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }else{
            $formFields['avatar'] = 'default-avatar.png';
        }
        \Log::info('step3');

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        \Log::info('Form Fields: ' . json_encode($formFields));
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }

    // Logout User
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');

    }

    // Show Login Form
    public function login() {
        return view('users.login');
    }

    // Authenticate User
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
