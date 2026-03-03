<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string',
            'password'       => 'required|string',
        ]);

        // Find user by email or mobile
        $user = User::where('email', $request->email_or_phone)
                    ->orWhere('mobile', $request->email_or_phone)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', '✅ Login successful!');
        }

        // Wrong credentials
        return back()
            ->withErrors([
                'email_or_phone' => '⚠️ Username or password is incorrect',
            ])
            ->withInput()
            ->with('login_error', true);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form')->with('success', 'Logged out successfully.');
    }
}
