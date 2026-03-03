<head>
    <link rel="stylesheet" href="{{ asset('css/socialbook.css') }}">
</head>

@extends('layouts.app')

@section('content')
<div id="auth-page">
    <!-- Left Section -->
    <div class="auth-left">
        <h1>SocialBook</h1>
        <p>
            Join SocialBook today and connect with friends, share your moments, 
            and be part of a growing community. It’s quick and easy!
        </p>
    </div>

    <!-- Right Section -->
    <div class="auth-right">
        <div class="auth-box">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="row-fields">
                    <input type="text" name="first_name" placeholder="First name" required>
                    <input type="text" name="last_name" placeholder="Last name" required>
                </div>
                @error('first_name') <p class="error">{{ $message }}</p> @enderror
                @error('last_name') <p class="error">{{ $message }}</p> @enderror

                <!-- Mobile or Email -->
                <input type="text" name="email_or_phone" placeholder="Mobile number or email" required>
                @error('email_or_phone') <p class="error">{{ $message }}</p> @enderror

                <!-- Password -->
                <input type="password" name="password" placeholder="New password" required>
                @error('password') <p class="error">{{ $message }}</p> @enderror


                <!-- Date of Birth -->
                <label class="form-label">Date of birth</label>
                <div class="row-fields">
                    <select name="day" required>
                        <option value="">Day</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="month" required>
                        <option value="">Month</option>
                        @foreach (['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $index => $month)
                            <option value="{{ $index+1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    <select name="year" required>
                        <option value="">Year</option>
                        @for ($i = date('Y'); $i >= 1905; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                @error('day') <p class="error">{{ $message }}</p> @enderror
                @error('month') <p class="error">{{ $message }}</p> @enderror
                @error('year') <p class="error">{{ $message }}</p> @enderror

                <!-- Gender -->
                <label class="form-label">Gender</label>
                <div class="row-fields gender-group">
                    <label><input type="radio" name="gender" value="Female" required> Female</label>
                    <label><input type="radio" name="gender" value="Male"> Male</label>
                    <label><input type="radio" name="gender" value="Custom"> Custom</label>
                </div>
                @error('gender') <p class="error">{{ $message }}</p> @enderror

                <!-- Register Button -->
                <button type="submit" class="register-btn">Sign Up</button>
            </form>

            <div class="auth-footer">
                <p>Secure login powered by SocialBook © {{ date('Y') }}</p>
                <p class="bottom-text">
                    Already have an account? <a href="{{ route('login') }}">Log In</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Minimal Inline Validation -->
<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    let valid = true;
    const inputs = this.querySelectorAll('input[required], select[required]');
    
    // Clear old errors
    this.querySelectorAll('.error').forEach(el => el.remove());

    // Check required fields
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valid = false;
            input.insertAdjacentHTML('afterend', `<p class="error">Please fill out this field.</p>`);
        }
    });

    // Password rule: 8+ chars & special char
    let password = this.querySelector('input[name="password"]').value;
    if (password.length < 8 || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        valid = false;
        this.querySelector('input[name="password"]').insertAdjacentHTML(
            'afterend',
            `<p class="error">Password must be at least 8 characters and include a special character.</p>`
        );
    }

    if (!valid) e.preventDefault();
});
</script>

@endsection
