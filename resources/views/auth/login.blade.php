@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/socialbook.css') }}">
    <style>
        .error-message { color: red; margin: 5px 0 10px; font-size: 14px; }
        .border-red { border: 1px solid red; }
        .success-message {
            background: #d1fae5; 
            color: #065f46; 
            padding: 10px; 
            border-radius: 6px; 
            margin-bottom: 15px; 
            text-align: center;
        }
    </style>
</head>

<div id="auth-page">
    <!-- Left Section -->
    <div class="auth-left">
        <h1>SocialBook</h1>
        <p>
            Connect with friends and the world around you on SocialBook.<br>
            Share updates, photos, and stay in touch with the people that matter.
        </p>
    </div>

    <!-- Right Section -->
    <div class="auth-right">
        <div class="auth-box">

            <!-- Success Messages (Registration & Logout) -->
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email or Mobile -->
                <input 
                    type="text" 
                    name="email_or_phone" 
                    placeholder="Email or Mobile" 
                    value="{{ old('email_or_phone') }}" 
                    class="@if($errors->has('email_or_phone') || session('login_error')) border-red @endif"
                    required
                >
                @error('email_or_phone')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <!-- Password -->
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password" 
                    class="@if($errors->has('email_or_phone') || session('login_error')) border-red @endif"
                    required
                >
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <button type="submit">Log In</button>

                <a href="#" class="link">Forgot Password?</a>
                <div class="divider"></div>
                <a href="{{ route('register.form') }}" class="create-btn">Create New Account</a>
            </form>

            <!-- Footer -->
            <div class="auth-footer">
                <p>Secure login powered by SocialBook © {{ date('Y') }}</p>
            </div>

        </div>
    </div>
</div>
@endsection
