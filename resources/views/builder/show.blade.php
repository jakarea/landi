<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>{{ $landingPage->seo_title ?? $landingPage->title }}</title>
    <meta name="description" content="{{ $landingPage->seo_meta_description }}">
    <meta name="keywords" content="{{ $landingPage->seo_keywords }}">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ $landingPage->seo_title ?? $landingPage->title }}">
    <meta property="og:description" content="{{ $landingPage->seo_meta_description }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($landingPage->og_image)
    <meta property="og:image" content="{{ $landingPage->og_image }}">
    @endif
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $landingPage->seo_title ?? $landingPage->title }}">
    <meta name="twitter:description" content="{{ $landingPage->seo_meta_description }}">
    @if($landingPage->og_image)
    <meta name="twitter:image" content="{{ $landingPage->og_image }}">
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .prose {
            max-width: none;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .prose h1 { font-size: 2.5rem; }
        .prose h2 { font-size: 2rem; }
        .prose h3 { font-size: 1.5rem; }
        .prose p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "{{ $landingPage->seo_title ?? $landingPage->title }}",
        "description": "{{ $landingPage->seo_meta_description }}",
        "url": "{{ request()->url() }}"
    }
    </script>

    <!-- Landing Page Content -->
    <main>
        {!! $landingPage->rendered_html !!}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel LMS') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>