@php
    $path = '';
    if (Auth::check()) {
        $user = auth()->user();
        if ($user->user_role == 'student') {
            $path = 'layouts.latest.students';
        }else {
            $path = 'layouts.latest.' . $user->user_role;
        }

    }
@endphp

@extends(!empty($path) ? $path : 'partials.guest.guest')

@section('style')
    <link href="{{ asset('assets/admin-css/style.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('title') 404 - Eror Page @endsection


{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <main class="user-profile-view-page">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="error-page-txt">
                        <img src="{{ asset('assets/images/404.png') }}" alt="error" class="img-fluid">
                        <h1>404 Not Found</h1>
                        <p>The page you are looking for doesn't exist or has been moved.</p>

                        <a href="{{ url('/')}}">Back to the homepage <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
{{-- page content @E --}}

{{-- script --}}
@section('script')

@endsection
{{-- script --}}
