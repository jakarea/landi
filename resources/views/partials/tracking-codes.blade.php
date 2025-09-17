{{-- Marketing Tracking Codes --}}
@php
    // Get the first instructor's tracking codes for the site
    $instructor = \App\Models\User::where('user_role', 'instructor')
        ->where(function($query) {
            $query->whereNotNull('facebook_pixel_id')
                  ->orWhereNotNull('google_analytics_id')
                  ->orWhereNotNull('google_tag_manager_id');
        })
        ->first();
@endphp

@if($instructor)
    {{-- Google Tag Manager (Head) --}}
    @if($instructor->google_tag_manager_id)
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $instructor->google_tag_manager_id }}');</script>
    <!-- End Google Tag Manager -->
    @endif

    {{-- Google Analytics 4 --}}
    @if($instructor->google_analytics_id)
    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $instructor->google_analytics_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $instructor->google_analytics_id }}');
    </script>
    <!-- End Google Analytics 4 -->
    @endif

    {{-- Facebook Pixel --}}
    @if($instructor->facebook_pixel_id)
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $instructor->facebook_pixel_id }}');
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id={{ $instructor->facebook_pixel_id }}&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    @endif
@endif