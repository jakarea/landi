@extends('layouts.latest.auth')
@section('title')
নতুন পাসওয়ার্ড সেট করুন | আপনার পাসওয়ার্ড রিসেট করুন
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="auth-card">
            <h1 class="auth-title">নতুন পাসওয়ার্ড সেট করুন</h1>
            <p class="auth-subtitle">আপনার অ্যাকাউন্টের জন্য একটি নতুন পাসওয়ার্ড তৈরি করুন</p>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">ইমেইল ঠিকানা</label>
                    <input id="email" 
                           type="email" 
                           placeholder="আপনার ইমেইল লিখুন"
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">নতুন পাসওয়ার্ড</label>
                    <div class="password-field-wrapper">
                        <input id="password" 
                               placeholder="একটি শক্তিশালী পাসওয়ার্ড তৈরি করুন" 
                               type="password"
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password"
                               required
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
                    <label for="password-confirm">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <div class="password-field-wrapper">
                        <input id="password-confirm" 
                               placeholder="আপনার পাসওয়ার্ড পুনরায় লিখুন" 
                               type="password"
                               class="form-control" 
                               name="password_confirmation"
                               required
                               autocomplete="new-password">
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password-confirm', 'confirm-eye')" id="confirm-eye"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-submit">
                    পাসওয়ার্ড রিসেট করুন
                </button>

                <div class="auth-links">
                    <p>পাসওয়ার্ড মনে পড়েছে? <a href="{{ route('login') }}">লগইন করুন</a></p>
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
