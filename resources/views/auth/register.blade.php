@extends('layouts.latest.auth')
@section('title')
নিবন্ধন | এআই বুটক্যাম্পে যোগ দিন
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="auth-card">
            <h1 class="auth-title">বুটক্যাম্পে যোগ দিন</h1>
            <p class="auth-subtitle">ভবিষ্যতের জন্য প্রস্তুত হন। বিজ্ঞাপনের জন্য এআই শিখুন।</p>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">পূর্ণ নাম</label>
                    <input type="text" 
                           id="name"
                           placeholder="আপনার পূর্ণ নাম লিখুন"
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
                    <label for="email">ইমেইল ঠিকানা</label>
                    <input type="email" 
                           id="email"
                           placeholder="আপনার ইমেইল লিখুন"
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
                    <label for="password">পাসওয়ার্ড</label>
                    <div class="password-field-wrapper">
                        <input id="password" 
                               placeholder="একটি পাসওয়ার্ড তৈরি করুন" 
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
                    <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <div class="password-field-wrapper">
                        <input id="password_confirmation" 
                               placeholder="আপনার পাসওয়ার্ড পুনরায় লিখুন" 
                               type="password"
                               class="form-control" 
                               name="password_confirmation"
                               autocomplete="new-password">
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation', 'confirm-eye')" id="confirm-eye"></i>
                    </div>
                </div>
                
                <button class="btn btn-submit" type="submit">
                    এখনই যোগ দিন
                </button>
                
                <div class="auth-links">
                    <p>ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">লগইন করুন</a></p>
                </div>
                
                <div class="social-login">
                    <a href="{{ url('login/google') }}">গুগল দিয়ে চালিয়ে যান</a>
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