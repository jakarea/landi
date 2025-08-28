@extends('layouts.latest.auth')
@section('title')
Register | Join AI Bootcamp
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="auth-card">
            <h1 class="auth-title">Join the Bootcamp</h1>
            <p class="auth-subtitle">Future-Proof Your Career. Master AI for Ads.</p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" 
                           id="name"
                           placeholder="Enter your full name"
                           class="form-control @error('name') is-invalid @enderror" 
                           name="name"
                           value="{{ old('name') }}"
                           autocomplete="name" 
                           autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" 
                           id="email"
                           placeholder="Enter your email"
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email"
                           value="{{ old('email') }}"
                           autocomplete="email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Company (Optional)</label>
                    <input type="text" 
                           id="company_name"
                           placeholder="Your company name"
                           class="form-control" 
                           name="company_name"
                           value="{{ old('company_name') }}">
                </div>

                <div class="form-group">
                    <label for="user_role">I want to join as</label>
                    <select id="user_role" 
                            name="user_role" 
                            class="form-control @error('user_role') is-invalid @enderror">
                        <option value="">Select your role</option>
                        <option value="student" {{ old('user_role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="instructor" {{ old('user_role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                    </select>
                    @error('user_role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-field-wrapper">
                        <input id="password" 
                               placeholder="Create a password" 
                               type="password"
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password"
                               autocomplete="new-password">
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password', 'password-eye')" id="password-eye"></i>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="password-field-wrapper">
                        <input id="password_confirmation" 
                               placeholder="Confirm your password" 
                               type="password"
                               class="form-control" 
                               name="password_confirmation"
                               autocomplete="new-password">
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation', 'confirm-eye')" id="confirm-eye"></i>
                    </div>
                </div>
                
                <div class="form-check mb-4">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="terms" 
                           id="terms"
                           {{ old('terms') ? 'checked' : '' }}>
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#" class="auth-links">Terms of Service</a> and <a href="#" class="auth-links">Privacy Policy</a>
                    </label>
                    @error('terms')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <button class="btn btn-submit" type="submit">
                    Join Now
                </button>
                
                <div class="auth-links">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                </div>
                
                <div class="social-login">
                    <a href="{{ url('login/google') }}">Continue with Google</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
function togglePassword(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(iconId);
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>
@endsection