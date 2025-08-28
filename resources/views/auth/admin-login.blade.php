@extends('layouts.latest.auth')
@section('title')
Login Page
@endsection

@section('content') 

<section class="auth-part-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 px-0">
                <div class="auth-form-wrap">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <a href="#">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="img-fluid">
                    </a>  
                    <h1>Welcome back</h1>
                    <p>Welcome back! Please enter your details.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input autocomplete="off" type="email" placeholder="Enter Email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-field">{{ __('Password') }}</label>
                            <input id="password-field" placeholder="••••••••" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <i class="fa-regular fa-eye" onclick="changeType()" id="eye-click"></i>
                        </div>
                        <div class="d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                    old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember for 30 days
                                </label>
                            </div>
                            <div class="forgot">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                    @endif
                            </div>
                        </div>
                        <div class="form-submit">
                            <button class="btn btn-submit" type="submit">Login</button>
                        </div>
                        <div class="optional-txt">
                            <p>Dont't have an account? <a href="{{ url('/register') }}">Register</a></p>
                        </div>
                    </form>
                </div> 
            </div>
            <div class="col-lg-6 px-0">
                <div class="auth-side-img d-none d-lg-block">
                    <img src="{{ asset('assets/images/auth/auth.png') }}" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section> 

@endsection

@section('script')
<script>
    function changeType() {
      var field = document.getElementById("password-field");
      var clickk = document.getElementById("eye-click");

      if (field.type === "password") {
        field.type = "text";
        clickk.classList.add('fa-eye-slash');
        clickk.classList.remove('fa-eye');
      } else {
        field.type = "password";
        clickk.classList.remove('fa-eye-slash');
        clickk.classList.add('fa-eye');
      }

    }
</script>
@endsection
