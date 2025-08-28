@php
    $path = '';
    if (Auth::check()) {
        $user = auth()->user();
        $path = $user->user_role == 'student' ? 'layouts.latest.students' : '';
    }
@endphp

@extends(!empty($path) ? $path : 'partials.guest.guest')

@section('style')
    <link href="{{ asset('assets/admin-css/style.css') }}" rel="stylesheet" type="text/css" />
@endsection




@section('title') 403 - Eror Page @endsection


{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <main class="user-profile-view-page">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="error-page-txt">
                        <img src="{{ asset('assets/images/404.png') }}" alt="error" class="img-fluid">
                        <h1>403 Forbidden</h1>
                        <p>Oops! It seems like you don't have the required permissions to access the requested page.</p>
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
