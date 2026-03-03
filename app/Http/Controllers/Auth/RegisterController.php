<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Redirect path after registration
     */
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // your register blade
    }

    /**
     * Handle registration
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email_or_phone' => 'required|string|max:255',
            'password'       => ['required','string','min:8','regex:/[!@#$%^&*(),.?":{}|<>]/'],
            'day'            => 'required|integer|min:1|max:31',
            'month'          => 'required|integer|min:1|max:12',
            'year'           => 'required|integer|min:1905|max:' . date('Y'),
            'gender'         => 'required|string',
        ]);

        $input = $request->email_or_phone;

        // Determine if input is email or mobile
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $email  = $input;
            $mobile = null;

            // Check email uniqueness
            if (User::where('email', $email)->exists()) {
                return back()->withErrors(['email_or_phone' => 'Email already taken'])->withInput();
            }
        } else {
            $email  = null;
            $mobile = $input;

            // Check mobile uniqueness
            if (User::where('mobile', $mobile)->exists()) {
                return back()->withErrors(['email_or_phone' => 'Mobile number already taken'])->withInput();
            }
        }

        // Build DOB
        $dob = sprintf('%04d-%02d-%02d', $request->year, $request->month, $request->day);

        // Create user with default profile picture left as null
        // The User model will handle showing the default male image
        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $email,
            'mobile'     => $mobile,
            'password'   => Hash::make($request->password),
            'dob'        => $dob,
            'gender'     => $request->gender,
            // profile_picture remains null - User model will show default-male.png
        ]);

        // Redirect to login with success message
        return redirect()->route('login.form')->with('success', '✅ Account created successfully. Please log in.');
    }
}