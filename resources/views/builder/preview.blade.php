<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $landingPage->title }}</title>
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
    <!-- Preview Header -->
    <div class="bg-yellow-100 border-b border-yellow-200 px-6 py-3">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <div class="text-yellow-800">
                    <strong>Preview Mode</strong> - This is how your landing page will look when published
                </div>
                <button onclick="window.close()" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    Close Preview
                </button>
            </div>
        </div>
    </div>

    <!-- Landing Page Content -->
    <div class="landing-content">
        {!! $htmlContent !!}
    </div>
</body>
</html>