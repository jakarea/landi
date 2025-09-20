<!doctype html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO -->
    <title>@yield('title', 'আব্দুর রউফ - AI Creative Training Platform')</title>
    <meta name="description" content="@yield('description', 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')">
    <meta name="keywords" content="@yield('keywords', 'AI, Creative, Training, Bangladesh, এআই, ক্রিয়েটিভ, ট্রেনিং')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'আব্দুর রউফ - AI Creative Training Platform')">
    <meta property="og:description" content="@yield('og_description', 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')">
    <meta property="og:image" content="@yield('og_image', asset('/images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        /* Missing CTA background class */
        .get-bg {
            background: linear-gradient(180deg, #011A1D 0%, #010E10 100%);
        }
    </style>
    @yield('styles')

    {{-- Marketing Tracking Codes --}}
    @include('partials.tracking-codes')
</head>

<body class="bg-[#0A0A0A]">
    {{-- Marketing Tracking Codes (Body) --}}
    @include('partials.tracking-codes-body')

    {{-- Main Content --}} 
        @yield('content') 

    {{-- Footer --}}
    @include('partials.guest.footer')

    <!-- Scripts -->
    @yield('scripts')
</body>

</html>