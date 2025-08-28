@extends('layouts.latest.auth')
@section('title','Verify Email')

@section('content') 
<section class="auth-part-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 px-md-0"> 
                <div class="auth-form-wrap justify-content-start">
                    <div class="back-bttn  justify-content-end">
                        {{-- <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            Do it Later
                        </a> --}}
                    </div>
                    {{-- verify step start --}}
                    <div class="verify-step-wrap">
                        <div class="step-item active">
                            <h6>1</h6>
                            <p>Step 1</p>
                        </div>
                        <div class="step-item ">
                            <h6>2</h6>
                            <p>Step 2</p>
                        </div>
                        <div class="step-item">
                            <h6>3</h6>
                            <p>Step 3</p>
                        </div>
                        <div class="step-item">
                            <h6>4</h6>
                            <p>Step 4</p>
                        </div>
                        <div class="step-item">
                            <h6>5</h6>
                            <p>Step 5</p>
                        </div>
                        <div class="step-item">
                            <h6>6</h6>
                            <p>Step 6</p>
                        </div>
                    </div>
                    {{-- verify step end --}}
                    <a href="{{url('/')}}" class="mt-4">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="img-fluid">
                    </a>
                    <h1>Verify your mail address</h1>
                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif

                    <form class="ms-0" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="form-submit only-submit">
                            <button class="btn btn-submit mx-auto" type="submit">Resend Verification Link!</button>
                        </div>
                    </form>

                    <div class="optional-txt">
                        <p>Prefer to verify later? 
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout Now</a>
                        </p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                </div> 
            </div>
        </div>
    </div>
</section> 
@endsection