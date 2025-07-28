<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LakasApp: Smart Nutrition for Kids</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="auth-container register-container">
        <div class="auth-header">
            <h1>Register for LakasApp</h1>
            <p>Create your account and provide patient information</p>
        </div>

        <div class="role-info">
            ℹ️ New accounts are created as regular users by default. Admin access is managed separately.
        </div>

        <div style="text-align:center;margin-bottom:1.5rem;">
            <span id="register-progress" style="font-weight:600;font-size:1.1rem;"></span>
        </div>
        <a href="{{ route('login') }}" style="position:fixed;top:24px;right:32px;z-index:10;color:#2196f3;font-weight:600;text-decoration:none;">&larr; Back to Login</a>

        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf
            <div class="register-step"> <!-- Step 1: Account Information & Basic Info -->
                <div class="form-section">
                    <h3>Account Information</h3>
                    <div class="form-row">
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
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                            />
                            <small style="color:#888;">A verification link will be sent to your email.</small>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
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
                                pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                            />
                            <small style="color:#888;">Minimum 8 characters, at least one letter and one number.</small>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
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
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="municipality">Municipality</label>
                            <input 
                                id="municipality" 
                                class="form-input" 
                                type="text" 
                                name="municipality" 
                                value="San Pedro" 
                                required
                                readonly
                            />
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay</label>
                            <select id="barangay" class="form-input" name="barangay" required>
                                <option value="">Select barangay</option>
                                <option value="Bagong Silang">Bagong Silang</option>
                                <option value="Calendola">Calendola</option>
                                <option value="Chrysanthemum">Chrysanthemum</option>
                                <option value="Cuyab">Cuyab</option>
                                <option value="Estrella">Estrella</option>
                                <option value="Fatima">Fatima</option>
                                <option value="GSIS">GSIS</option>
                                <option value="Landayan">Landayan</option>
                                <option value="Langgam">Langgam</option>
                                <option value="Laram">Laram</option>
                                <option value="Magsaysay">Magsaysay</option>
                                <option value="Maharlika">Maharlika</option>
                                <option value="Narra">Narra</option>
                                <option value="Nueva">Nueva</option>
                                <option value="Pacita 1">Pacita 1</option>
                                <option value="Pacita 2">Pacita 2</option>
                                <option value="Poblacion">Poblacion</option>
                                <option value="Riverside">Riverside</option>
                                <option value="Rosario">Rosario</option>
                                <option value="Sampaguita">Sampaguita</option>
                                <option value="San Antonio">San Antonio</option>
                                <option value="San Lorenzo Ruiz">San Lorenzo Ruiz</option>
                                <option value="San Roque">San Roque</option>
                                <option value="San Vicente">San Vicente</option>
                                <option value="Santo Niño">Santo Niño</option>
                                <option value="United Bayanihan">United Bayanihan</option>
                                <option value="United Better Living">United Better Living</option>
                            </select>
                            @error('barangay')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input 
                                id="date_of_birth" 
                                class="form-input" 
                                type="date" 
                                name="date_of_birth" 
                                value="{{ old('date_of_birth') }}" 
                                required
                            />
                            @error('date_of_birth')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Sex</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="radio" id="sex_male" name="sex" value="male" {{ old('sex') == 'male' ? 'checked' : '' }} required>
                                    <label for="sex_male">Male</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="radio" id="sex_female" name="sex" value="female" {{ old('sex') == 'female' ? 'checked' : '' }} required>
                                    <label for="sex_female">Female</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="radio" id="sex_other" name="sex" value="other" {{ old('sex') == 'other' ? 'checked' : '' }} required>
                                    <label for="sex_other">Other</label>
                                    <input type="text" name="sex_other_text" class="form-input" style="width:120px;display:inline-block;margin-left:8px;" placeholder="Specify" value="{{ old('sex_other_text') }}">
                                </div>
                            </div>
                            @error('sex')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="auth-btn register-next" type="button">Next</button>
            </div>
            <div class="register-step" style="display:none;"> <!-- Step 2: Household Information -->
                <div class="form-section">
                    <h3>Household Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="total_household_members">Total Household Members</label>
                            <input 
                                id="total_household_members" 
                                class="form-input" 
                                type="number" 
                                name="total_household_members" 
                                value="{{ old('total_household_members') }}" 
                                required
                                min="1"
                                placeholder="Total members in household"
                            />
                            @error('total_household_members')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="household_adults">Number of Adults</label>
                            <input 
                                id="household_adults" 
                                class="form-input" 
                                type="number" 
                                name="household_adults" 
                                value="{{ old('household_adults') }}" 
                                required
                                min="0"
                                placeholder="Number of adults"
                            />
                            @error('household_adults')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="household_children">Number of Children</label>
                            <input 
                                id="household_children" 
                                class="form-input" 
                                type="number" 
                                name="household_children" 
                                value="{{ old('household_children') }}" 
                                required
                                min="0"
                                placeholder="Number of children"
                            />
                            @error('household_children')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Special Conditions</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="is_twin" name="is_twin" value="1" {{ old('is_twin') ? 'checked' : '' }}>
                                    <label for="is_twin">Twin</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="is_4ps_beneficiary" name="is_4ps_beneficiary" value="1" {{ old('is_4ps_beneficiary') ? 'checked' : '' }}>
                                    <label for="is_4ps_beneficiary">4P's Beneficiary</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="auth-btn register-prev" type="button">Back</button>
                <button type="submit" class="auth-btn register-btn">Create Account</button>
            </div>
        </form>

        <div class="auth-links">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">Sign in here</a>
            
        </div>
    </div>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
