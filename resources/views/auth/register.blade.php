<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BMI Authentication</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container register-container">
        <div class="auth-header">
            <h1>Join BMI</h1>
            <p>Create your account to get started</p>
        </div>

        <div class="role-info">
            ℹ️ New accounts are created as regular users by default. Admin access is managed separately.
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input 
                    id="name" 
                    class="form-input" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="Enter your full name"
                />
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    id="email" 
                    class="form-input" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autocomplete="username"
                    placeholder="Enter your email"
                />
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    id="password" 
                    class="form-input"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Choose a strong password"
                />
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    id="password_confirmation" 
                    class="form-input"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                />
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="auth-btn register-btn">
                Create Account
            </button>
        </form>

        <div class="auth-links">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">Sign in here</a>
            
            <div style="margin-top: 15px;">
                <a href="{{ url('/home') }}">← Back to Home</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
