<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>'শিখুন' | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Admin Template For Filter Developers" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ '' }}">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="theme-color" content="#fafafa">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- all css start -->
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/header.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/admin-dark.css') }}" rel="stylesheet" type="text/css" />

    {{-- Light box image popup --}}
    {{-- <link href="{{ asset('magnify-popup/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- Emoji --}}
    {{-- <link href="{{ asset('emoji/emojionearea.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    {{-- Toaster notification css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> --}}

    @yield('style')
    <link href="{{ asset('assets/admin-css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- all css end -->

    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .user-name-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: var(--transparent-grey-24, rgba(145, 158, 171, 0.24));
            color: var(--neutral-color-neutral-60, #66768E);
            font-size: 0.875rem;
            font-style: normal;
            font-weight: 600;
            line-height: 1.375rem;
        }

        .header-area .navbar-nav .nav-item .submenu-box li a:hover,
        .header-area .navbar-nav .nav-item .submenu-box li a.active{
            background: var(--neutral-color-neutral-20, #F1F4F9);
        }
        
        .header-area .navbar-nav .nav-item .nav-link.active {
            color: #000000;
            font-weight: 500;
        }

    </style>

    @yield('seo')
</head>

<body class="bg-body {{ session('darkModePreference') == 'dark-mode' ? 'dark-mode' : '' }}">

    {{-- Main Root Wrapper @S --}}

    {{-- header start --}}
    @if (Auth::user() && Auth::user()->user_role == 'instructor')
        @include('partials/latest/instructor/header')
    @elseif(Auth::user() && Auth::user()->user_role == 'admin')
        @include('partials/latest/dashboard/header')
    @else
        @include('partials/latest/students/header')
    @endif
    {{-- header end --}}

    @yield('content')
    {{-- Main Root Wrapper @E --}}

    {{-- dark mode button start --}}
    <input type="checkbox" id="darkModeBttn" class="d-none">

    <div class="dark-mode-bttn">
        <label for="darkModeBttn" class="active">
            <i class="fa-solid fa-sun"></i>
        </label>
        <label for="darkModeBttn">
            <i class="fa-solid fa-moon"></i>
        </label>
    </div>
    {{-- dark mode button end --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    {{-- Emoji area --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"
        integrity="sha512-hkvXFLlESjeYENO4CNi69z3A1puvONQV5Uh+G4TUDayZxSLyic5Kba9hhuiNLbHqdnKNMk2PxXKm0v7KDnWkYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Lightbox --}}
    {{-- <script src="{{ asset('magnify-popup/js/lightbox.min.js') }}"></script> --}}
    {{-- Toaster js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    {{-- dark mode js --}}
    <script>
        const htmlBody = document.querySelector("body");
        const modeBttn = document.getElementById("darkModeBttn");

        function modeCall(mode){
            let currentURLs = window.location.href;
            const baseUrls = currentURLs.split('/').slice(0, 3).join('/');

            // Update the dark mode preference using session
            fetch(`${baseUrls}/preference/mode/setting`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ preferenceMode: mode }),
            });
        }


        function toggleMode() {
            htmlBody.classList.toggle('dark-mode');
            const mode = htmlBody.classList.contains('dark-mode') ? 'dark-mode' : '';

            modeCall(mode);

            localStorage.setItem('dark-mode', mode);

            if (htmlBody.classList.contains('dark-mode')) {
                
                darkFunction();
            }else{
                
                lightFunction();
            }
        }
        const storedMode = localStorage.getItem('dark-mode');
        if (storedMode === 'dark-mode') {
            htmlBody.classList.add('dark-mode');
        }
        
        // Define dark mode functions
        function darkFunction() {
            // Dark mode specific functionality
            console.log('Dark mode activated');
        }
        
        function lightFunction() {
            // Light mode specific functionality  
            console.log('Light mode activated');
        }
        
        modeBttn.addEventListener('change', toggleMode);
    </script>

    <script>
        if (document.querySelector("body").classList.contains('dark-mode')) {
            
            darkFunction();
        } else {
            
            lightFunction();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/uuid@8.3.0/dist/umd/uuidv4.min.js"></script>
    <script>
        var userIdentifier = uuidv4();
            var domainParts = window.location.hostname.split('.');
            var topLevelDomain = domainParts.slice(-2).join('.');
            var cookieDomain = '.' + topLevelDomain;
            document.cookie = "userIdentifier=" + userIdentifier + "; path=/; domain=" + cookieDomain + "; secure; samesite=Strict";
    </script>

    @yield('script')
</body>

</html>
