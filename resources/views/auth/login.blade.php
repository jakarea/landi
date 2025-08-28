@extends('layouts.latest.auth')
@section('title')
Login | Access Your AI Bootcamp
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="auth-card">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Access your AI for Advertising training dashboard</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" 
                           id="email"
                           placeholder="Enter your email"
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email"
                           value="{{ old('email') }}"
                           autocomplete="email" 
                           autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password-field">Password</label>
                    <div class="password-field-wrapper">
                        <input id="password-field" 
                               placeholder="Enter your password" 
                               type="password"
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password"
                               autocomplete="current-password">
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()" id="eye-icon"></i>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="remember" 
                               id="remember" 
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot Password?
                    </a>
                    @endif
                </div>
                
                <button class="btn btn-submit" type="submit">
                    Access Dashboard
                </button>
                
                <div class="auth-links">
                    <p>Don't have an account? <a href="{{ route('register') }}">Join the Bootcamp</a></p>
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
function togglePassword() {
    const passwordField = document.getElementById("password-field");
    const eyeIcon = document.getElementById("eye-icon");
    
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