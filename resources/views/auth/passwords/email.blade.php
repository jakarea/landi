@extends('layouts.latest.auth')
@section('title')
পাসওয়ার্ড রিসেট | আপনার পাসওয়ার্ড পুনরুদ্ধার করুন
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-5">
        <div class="auth-card">
            <h1 class="auth-title">পাসওয়ার্ড ভুলে গেছেন?</h1>
            <p class="auth-subtitle">চিন্তা করবেন না! আপনার ইমেইল দিন এবং আমরা আপনাকে পাসওয়ার্ড রিসেট লিঙ্ক পাঠাব।</p>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">ইমেইল ঠিকানা</label>
                    <input id="email" 
                           type="email" 
                           placeholder="আপনার ইমেইল লিখুন"
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit">
                    পাসওয়ার্ড রিসেট লিঙ্ক পাঠান
                </button>

                <div class="auth-links">
                    <p>পাসওয়ার্ড মনে পড়েছে? <a href="{{ route('login') }}">লগইন করুন</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
