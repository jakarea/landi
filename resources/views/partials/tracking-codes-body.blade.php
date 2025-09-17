{{-- Marketing Tracking Codes (Body) --}}
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
    {{-- Google Tag Manager (Body) --}}
    @if($instructor->google_tag_manager_id)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $instructor->google_tag_manager_id }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
@endif