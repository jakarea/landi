<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title> 'Learncosy'  | @yield('title')</title>
    <meta name="description" content="Learncosy Template For Filter Developers">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Learncosy Template For Filter Developers" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="theme-color" content="#fafafa">

    <!-- App favicon -->
 
    <link rel="shortcut icon" href="{{ asset('favicon') }}">
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- all css start -->
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/homepage.css') }}" rel="stylesheet" type="text/css" />
    @yield('style')
    <!-- all css end -->

    {{-- Marketing Tracking Codes --}}
    @include('partials.tracking-codes')
</head>

<body>

    {{-- Marketing Tracking Codes (Body) --}}
    @include('partials.tracking-codes-body')

    {{-- landing page wrap @s --}}
    <section class="landing-page-wrapper">
        {{-- header @s --}}
        @include('partials/guest/header')
        {{-- header @E --}}

        @yield('content')
    </section>
    {{-- landing page wrap @e --}}

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('script')

    <script src="https://cdn.jsdelivr.net/npm/uuid@8.3.0/dist/umd/uuidv4.min.js"></script>
    <script>
        // Check if the userIdentifier cookie exists
        var existingUserIdentifier = getCookie('userIdentifier');

        // If it doesn't exist, generate and set the cookie
        if (!existingUserIdentifier) {
            var userIdentifier = uuidv4();
            document.cookie = "userIdentifier=" + userIdentifier + "; path=/";
        }

        // Function to get a cookie by name
        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }
    </script>

</body>
</html>
