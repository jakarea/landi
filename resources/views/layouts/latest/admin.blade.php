<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>LearnCosy | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Admin Template For Filter Developers" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="">
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
    {{-- jquery ui css --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    @yield('style')
    <link href="{{ asset('assets/admin-css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <!-- all css end -->

    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    @yield('seo')
</head>

<body class="{{ session('darkModePreference') == 'dark-mode' ? 'dark-mode' : '' }}">

    {{-- ========= Main Root Wrapper @S ========= --}}
    <div class="main-page-wrapper">
        {{-- header start --}}
        @include('partials/latest/dashboard/header')

        {{-- header end --}}
        @yield('content')
    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    {{-- jquery ui --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


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
        modeBttn.addEventListener('change', toggleMode);
    </script>

    <script>
        if (document.querySelector("body").classList.contains('dark-mode')) {
            
            darkFunction();
        } else {
            
            lightFunction();
        }
    </script>



    @yield('script')
</body>

</html>
