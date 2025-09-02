@extends('layouts/latest/instructor')
@section('title', $title)


{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .course-description-content {
            font-size: 1rem;
            line-height: 1.7;
            color: #555;
        }
        
        .course-description-content p {
            margin-bottom: 1rem;
        }
        
        .course-description-content h1,
        .course-description-content h2,
        .course-description-content h3,
        .course-description-content h4,
        .course-description-content h5,
        .course-description-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #333;
        }
        
        .course-description-content ul,
        .course-description-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        
        .course-description-content li {
            margin-bottom: 0.25rem;
        }
        
        .course-description-content strong,
        .course-description-content b {
            font-weight: 600;
            color: #333;
        }
        
        .course-description-content blockquote {
            border-left: 4px solid #F97316;
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: #666;
        }
        
        .course-description-content a {
            color: #F97316;
            text-decoration: none;
        }
        
        .course-description-content a:hover {
            color: #EA580C;
            text-decoration: underline;
        }
        
        .course-short-desc {
            max-width: 600px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        /* Override Bootstrap conflicts */
        .course-overview-main .container-x {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 1024px) {
            .course-overview-main .container-x {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        /* Ensure Tailwind utilities work */
        .course-overview-main * {
            box-sizing: border-box;
        }
        
        /* Override Bootstrap grid conflicts */
        .course-overview-main .grid {
            display: grid !important;
        }
        
        .course-overview-main .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }
        
        @media (min-width: 1024px) {
            .course-overview-main .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }
        
        /* Ensure flex utilities work */
        .course-overview-main .flex {
            display: flex !important;
        }
        
        .course-overview-main .items-center {
            align-items: center !important;
        }
        
        .course-overview-main .justify-between {
            justify-content: space-between !important;
        }
        
        /* Fix spacing utilities */
        .course-overview-main .space-y-3 > * + * {
            margin-top: 0.75rem !important;
        }
        
        .course-overview-main .space-y-4 > * + * {
            margin-top: 1rem !important;
        }
        
        /* Override Bootstrap text colors */
        .course-overview-main .text-orange {
            color: #F97316 !important;
        }
        
        .course-overview-main .bg-orange {
            background-color: #F97316 !important;
        }
        
        .course-overview-main .border-orange\/30 {
            border-color: rgba(249, 115, 22, 0.3) !important;
        }
        
        /* Ensure rounded corners work */
        .course-overview-main .rounded-2xl {
            border-radius: 1rem !important;
        }
        
        .course-overview-main .rounded-xl {
            border-radius: 0.75rem !important;
        }
        
        /* Fix shadows */
        .course-overview-main .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        }
        
        /* Hero section gradient */
        .course-overview-main .first-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
        }
        
        /* Grid background pattern */
        .course-overview-main .grid-background {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0);
            background-size: 20px 20px;
        }
        
        /* Make sure text colors work over gradient */
        .course-overview-main .text-white {
            color: #ffffff !important;
        }
        
        .course-overview-main .text-white\/90 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .course-overview-main .text-white\/80 {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>
@endsection
{{-- style section @E --}}

@section('seo')
    <meta name="keywords" content="{{ $course->categories . ', ' . $course->meta_keyword }}" />
    <meta name="description" content="{{ $course->meta_description }}" itemprop="description">
@endsection

@section('content')
    <main class="w-full course-overview-main">
        <section class="w-full pt-12 pb-20 first-gradient relative overflow-hidden border-b border-[#fff]/20 xl:py-[188px]" style="background-image: url({{ asset('assets/images/courseds/' . $course->banner) }});">
            <div class="absolute inset-0 grid-background opacity-[13%] z-10"></div>
            <div class="container-x">
                <div class="w-full grid grid-cols-1 lg:grid-cols-2 lg:gap-x-20 xl:gap-x-[105px] lg:items-center">
                    <div class="w-full">
                        <div class="text-center relative z-40 lg:text-start">
                            <h2 class="font-bold text-[28px] leading-[110%] text-[#fff] lg:text-[42px] xl:text-[52px] 2xl:text-[62px] mb-5">{{ $course->title }}</h2>
                            <p class="text-base text-[#fff]/90 leading-[150%] mb-8 lg:text-lg xl:text-xl course-short-desc">{{ $course->sub_title }}</p>

                            @if ($course->user)
                                <div class="w-full flex justify-center items-center gap-x-4 mb-8 lg:justify-start">
                                    @if ($course->user->avatar)
                                        <img src="{{ asset($course->user->avatar) }}" alt="Instructor" class="w-12 h-12 rounded-full object-cover lg:w-[50px] lg:h-[50px]">
                                    @else
                                        <span class="w-12 h-12 rounded-full bg-[#3C5D62] text-white flex items-center justify-center font-semibold text-lg lg:w-[50px] lg:h-[50px]">{!! strtoupper($course->user->name[0]) !!}</span>
                                    @endif
                                    <div class="text-center lg:text-start">
                                        <h5 class="text-white font-semibold text-base lg:text-lg">{{ $course->user->name }}</h5>
                                        <h6 class="text-white/80 capitalize text-sm font-medium">{{ $course->user->user_role }}</h6>
                                    </div>
                                </div>
                            @endif

                            {{-- Use controller-calculated data with comprehensive fallbacks --}}
                            @php
                                // Use controller data if available, otherwise calculate here
                                $hours = $totalHours ?? 0;
                                $minutes = $totalMinutes ?? 0;
                                $modulesCount = $totalModules ?? 0;
                                $lessonsCount = $totalLessons ?? 0;
                                
                                // Always recalculate if controller data is zero or missing
                                if ($hours == 0 && $minutes == 0 && $modulesCount == 0 && $lessonsCount == 0) {
                                    $totalDurationSeconds = 0;
                                    $modulesCount = 0;
                                    $lessonsCount = 0;
                                    
                                    foreach ($course->modules as $module) {
                                        // Include all modules - don't filter by status for now
                                        $modulesCount++;
                                        
                                        foreach ($module->lessons as $lesson) {
                                            // Include all lessons
                                            $lessonsCount++;
                                            
                                            if (isset($lesson->duration) && is_numeric($lesson->duration) && $lesson->duration > 0) {
                                                $totalDurationSeconds += $lesson->duration;
                                            }
                                        }
                                    }
                                    
                                    // Try treating duration as seconds first
                                    if ($totalDurationSeconds > 0) {
                                        $hours = floor($totalDurationSeconds / 3600);
                                        $minutes = floor(($totalDurationSeconds % 3600) / 60);
                                    }
                                    
                                    // If still zero but we found lessons, assume duration is in minutes
                                    if ($hours == 0 && $minutes == 0 && $totalDurationSeconds > 0) {
                                        $totalMinutesFromSeconds = $totalDurationSeconds;
                                        $hours = floor($totalMinutesFromSeconds / 60);
                                        $minutes = $totalMinutesFromSeconds % 60;
                                    }
                                    
                                    // Final fallback: assign some default values if we have lessons but no duration
                                    if ($hours == 0 && $minutes == 0 && $lessonsCount > 0) {
                                        // Assume average 5 minutes per lesson
                                        $estimatedMinutes = $lessonsCount * 5;
                                        $hours = floor($estimatedMinutes / 60);
                                        $minutes = $estimatedMinutes % 60;
                                    }
                                } else {
                                    // Use controller data but ensure fallbacks for counts
                                    if ($modulesCount == 0) {
                                        $modulesCount = $course->modules->count();
                                    }
                                    if ($lessonsCount == 0) {
                                        foreach ($course->modules as $module) {
                                            $lessonsCount += $module->lessons->count();
                                        }
                                    }
                                }
                                
                            @endphp

                            <div class="text-white/80 text-sm leading-[150%] mb-8 lg:text-base">
                                @if ($hours > 0)
                                    {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                @endif
                                {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }} to Complete • {{ $modulesCount }} Module{{ $modulesCount != 1 ? 's' : '' }} in Course
                                @if ($course->allow_review)
                                   • {{ count($course_reviews) }} {{ count($course_reviews) > 1 ? 'Reviews' : 'Review' }}
                                @endif
                            </div>

                           

                            <a href="{{ url('instructor/courses/' . $course->id) }}" class="inline-flex items-center gap-x-2.5 bg-orange text-white px-6 py-3 rounded-full font-semibold text-base hover:bg-orange/90 transition-all duration-300 lg:px-8 lg:py-4 lg:text-lg relative z-40">
                                <img src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="Play" class="w-5 h-5 lg:w-6 lg:h-6">
                                Go to Course
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
        
        <div class="container-x py-12 lg:py-20">
            <div class="w-full grid grid-cols-1 lg:grid-cols-2 lg:gap-x-20 xl:gap-x-[105px]">
                <div class="w-full order-2 lg:order-1">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 lg:p-8">
                        <h3 class="font-bold text-xl text-gray-900 mb-6 lg:text-2xl">What You'll Learn</h3>
                        @php
                            $objectives = explode('[objective]', $course->objective);
                        @endphp
                        <ul class="space-y-3">
                            @foreach ($objectives as $object)
                                @if (trim($object) !== '')
                                    <li class="flex items-start gap-3">
                                        <i class="fas fa-check text-orange mt-1 flex-shrink-0"></i>
                                        <span class="text-gray-700 text-sm leading-[150%] lg:text-base">{{ $object }}</span>
                                    </li>
                                @else
                                    <li class="text-gray-500 italic text-sm">No Objective Found!</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    
                    @if ($course->description)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 lg:p-8">
                        <h3 class="font-bold text-xl text-gray-900 mb-6 lg:text-2xl">Course Details</h3>
                        <div class="course-description-content prose prose-sm max-w-none lg:prose-base">
                            {!! $course->description !!} 
                        </div>
                    </div>
                    @endif
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 lg:p-8">
                        <h3 class="font-bold text-xl text-gray-900 mb-6 lg:text-2xl">Course Content</h3>
                        <div class="space-y-3">
                            @foreach ($course->modules as $module)
                                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-orange/30 transition-colors">
                                        <div class="bg-gray-50/50">
                                            <button class="w-full p-5 text-left focus:outline-none focus:ring-2 focus:ring-orange/20 focus:ring-inset lg:p-6" type="button" onclick="toggleModule({{ $module->id }})">
                                                <div class="flex justify-between items-center">
                                                    <h5 class="text-base font-semibold text-gray-900 lg:text-lg">{{ $module->title }}
                                                        {{ $module->checkNumber() ? ' - Module ' . $loop->iteration : '' }}
                                                    </h5>
                                                    <i class="fas fa-chevron-down text-orange transition-transform duration-200" id="icon_{{ $module->id }}"></i>
                                                </div>
                                                    {{-- lessons total minutes --}}
                                                    @php
                                                    $totalDuration3 = 0;

                                                        foreach ($module->lessons as $lesson) {
                                                            if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                                                                $totalDuration3 += $lesson->duration;
                                                            }
                                                        }

                                                        $hours3 = floor($totalDuration3 / 3600);
                                                        $minutes3 = floor(($totalDuration3 % 3600) / 60);
                                                        $lessonCount = $module->lessons->count();
                                                    @endphp

                                                    <p class="text-xs text-orange mt-2.5 flex items-center gap-4 lg:text-sm lg:mt-3">
                                                        <span class="flex items-center gap-1.5">
                                                            <i class="fas fa-clock text-orange"></i>
                                                            @if ($hours3 > 0)
                                                                {{ $hours3 }} {{ $hours3 > 1 ? 'Hours' : 'Hour' }}
                                                            @endif
                                                            {{ $minutes3 }} Min
                                                        </span>
                                                        <span class="flex items-center gap-1.5">
                                                            <i class="fas fa-list text-orange"></i>
                                                            {{ $lessonCount }} {{ $lessonCount > 1 ? 'Lessons' : 'Lesson' }}
                                                        </span>
                                                    </p>
                                                    {{-- lessons total minutes --}}
                                                </div>
                                            </button>
                                        </div>
                                        <div id="collapse_{{ $module->id }}" class="hidden transition-all duration-300">
                                            <div class="border-t border-gray-200/50">
                                                <ul class="divide-y divide-gray-100/50">
                                                    @foreach ($module->lessons as $lesson)
                                                        @php
                                                            // Calculate lesson duration
                                                            $totalDuration2 = 0;
                                                            if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                                                                $totalDuration2 += $lesson->duration;
                                                            }
                                                            $hours2 = floor($totalDuration2 / 3600);
                                                            $minutes2 = floor(($totalDuration2 % 3600) / 60);
                                                            
                                                            // Check lesson access
                                                            $isPublic = isset($lesson->is_public) && $lesson->is_public;
                                                            $publishAt = isset($lesson->publish_at) ? \Carbon\Carbon::parse($lesson->publish_at) : null;
                                                            $isFuture = $publishAt && $publishAt->isFuture();
                                                            $canAccess = $isPublic || auth()->check();
                                                        @endphp

                                                        <li>
                                                            <a href="javascript:void(0)" 
                                                               class="video_list_play flex items-center justify-between p-3.5 hover:bg-orange/5 transition-colors {{ ($lesson->type == 'video' || $lesson->type == 'audio') && ($isPublic || auth()->check()) && !$isFuture ? 'lesson-playable cursor-pointer' : 'cursor-default' }} lg:p-4"
                                                               data-lesson-id="{{ $lesson->id }}"
                                                               data-lesson-type="{{ $lesson->type }}"
                                                               data-video-url="{{ $lesson->video_link ?? '' }}">
                                                                <div class="flex items-center gap-2.5 flex-1 lg:gap-3">
                                                                    @if ($isFuture)
                                                                        <i class="fas fa-clock text-blue-500 text-sm"></i>
                                                                    @elseif ($isPublic)
                                                                        <i class="fas fa-play-circle text-orange text-sm"></i>
                                                                    @elseif (auth()->check())
                                                                        <i class="fas fa-play-circle text-orange text-sm"></i>
                                                                    @else
                                                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                                                    @endif
                                                                    
                                                                    <span class="text-gray-900 font-medium text-sm lg:text-base">{{ $lesson->title }}</span>
                                                                    
                                                                    @if ($isPublic)
                                                                        <span class="px-1.5 py-0.5 bg-orange/10 text-orange text-xs font-medium rounded-full">Public</span>
                                                                    @endif
                                                                </div>
                                                                <div class="text-right">
                                                                    @if ($isFuture)
                                                                        <small class="text-gray-500 text-xs lg:text-sm">Available {{ $publishAt->format('M d, Y') }}</small>
                                                                    @else
                                                                        <div class="text-orange text-xs lg:text-sm">
                                                                            @if ($lesson->type != 'text')
                                                                                @if ($hours2 > 0)
                                                                                    {{ $hours2 }} {{ $hours2 > 1 ? 'Hours' : 'Hour' }}
                                                                                @endif
                                                                                {{ $minutes2 < 1 ? 1 : $minutes2 }} Min
                                                                            @else
                                                                                <i class="fa-regular fa-file-lines text-orange"></i>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                    @if ($course->allow_review)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 lg:p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-xl text-gray-900 lg:text-2xl">Student Reviews</h3>
                            <span class="text-orange text-sm lg:text-base">Total {{ count($course_reviews) }} Reviews</span>
                        </div>
                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-6">
                        @if (count($course_reviews) > 0)
                            @foreach ($course_reviews as $course_review)
                                <div class="bg-gray-50/50 rounded-xl p-5 border border-gray-100/50 lg:p-6">
                                    <div class="flex items-start gap-3 mb-4 lg:gap-4">
                                        @if ($course_review->user)
                                            @if ($course_review->user->avatar)
                                                <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover lg:w-12 lg:h-12">
                                            @else
                                                <span class="w-10 h-10 rounded-full bg-orange/10 text-orange flex items-center justify-center font-semibold text-sm lg:w-12 lg:h-12">{!! strtoupper($course->user->name[0]) !!}</span>
                                            @endif
                                        @endif

                                        <div class="flex-1">
                                            <h5 class="font-semibold text-gray-900 text-sm lg:text-base">{{ $course_review->user->name }}</h5>
                                            <p class="text-xs text-orange lg:text-sm">{{ \Carbon\Carbon::parse($course_review->created_at)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-3 text-sm leading-[150%] lg:text-base lg:mb-4">{{ $course_review->comment }}</p>
                                    <div class="flex gap-0.5">
                                        @for ($i = 0; $i < $course_review->star; $i++)
                                            <i class="fas fa-star text-orange text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 lg:py-12">
                                <p class="text-gray-500 text-base lg:text-lg">No Review Found!</p>
                            </div>
                        @endif
                        </div>
                    </div>
                    @endif
                    @if (count($related_course) > 0)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 lg:p-8">
                            <h3 class="font-bold text-xl text-gray-900 mb-6 lg:text-2xl">Similar Courses</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:gap-6">
                            @foreach ($related_course as $r_course)
                                @php
                                    $review_sum = 0;
                                    $review_avg = 0;
                                    $total = 0;
                                    foreach ($r_course->reviews as $review) {
                                        $total++;
                                        $review_sum += $review->star;
                                    }
                                    if ($total) {
                                        $review_avg = $review_sum / $total;
                                    }
                                @endphp
                                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-sm hover:border-orange/30 transition-all duration-300">
                                    <div class="aspect-video overflow-hidden">
                                        <img src="{{ $r_course->thumbnail ? asset($r_course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="{{ $r_course->slug }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <div class="p-5 lg:p-6">
                                        <h4 class="text-base font-semibold text-gray-900 mb-3 leading-tight lg:text-lg">
                                            <a href="{{ url('instructor/courses/overview/' . $r_course->slug) }}" class="hover:text-orange transition-colors">
                                                {{ Str::limit($r_course->title, 45) }}
                                            </a>
                                        </h4>
                                        <p class="text-orange text-xs mb-4 leading-[150%] lg:text-sm">{{ Str::limit($r_course->short_description, $limit = 46, $end = '...') }}</p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-xs font-medium text-gray-700 lg:text-sm">{{ number_format($review_avg, 1) }}</span>
                                                <div class="flex gap-0.5">
                                                    @for ($i = 0; $i < floor($review_avg); $i++)
                                                        <i class="fas fa-star text-orange text-xs"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500 lg:text-sm">({{ $total }})</span>
                                            </div>
                                            
                                            <div class="text-right">
                                                @if ($r_course->offer_price)
                                                    <div class="text-base font-bold text-gray-900 lg:text-lg">৳ {{ $r_course->offer_price }}</div>
                                                    <div class="text-xs text-gray-500 line-through lg:text-sm">৳ {{ $r_course->price }}</div>
                                                @elseif(!$r_course->offer_price && !$r_course->price)
                                                    <div class="text-base font-bold text-orange lg:text-lg">Free</div>
                                                @else
                                                    <div class="text-base font-bold text-gray-900 lg:text-lg">৳ {{ $r_course->price }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="lg:col-span-4 order-1 lg:order-2">
                    <div class="sticky top-8">
                        <div class="bg-white rounded-2xl p-8 shadow-lg mb-8">
                            <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                                @if ($promo_video_link != '')
                                    <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                                @else
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="Course Thumbnail" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    @if ($course->offer_price)
                                        <h2 class="text-3xl font-bold text-gray-900">৳ {{ $course->offer_price }}</h2>
                                        @if ($course->price)
                                            <p class="text-lg text-gray-500 line-through">৳ {{ $course->price }}</p>
                                        @endif
                                    @elseif(!$course->offer_price && $course->price)
                                        <h2 class="text-3xl font-bold text-gray-900">৳ {{ $course->price }}</h2>
                                    @else
                                        <h2 class="text-3xl font-bold text-orange">Free</h2>
                                    @endif
                                </div>
                                <button type="button" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-medium hover:bg-blue-200 transition-colors" data-bs-toggle="modal" data-bs-target="#exampleModal">Preview</button>
                            </div>

                            <button type="button" class="w-full flex items-center justify-center gap-3 bg-blue-600 text-white py-4 rounded-xl font-semibold hover:bg-blue-700 transition-colors" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                <img src="{{ asset('assets/images/icons/share.svg') }}" alt="Share" class="w-6 h-6">
                                Share this course
                            </button>

                        </div>
                        </div>
                        
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <div class="prose prose-sm max-w-none mb-6">
                                {!! $course->short_description !!}
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-6">Course Summary</h4>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-users text-orange w-5"></i>
                                    <span class="text-gray-700"><strong>{{ $courseEnrolledNumber }}</strong> Students Enrolled</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-clock text-orange w-5"></i>
                                    <span class="text-gray-700"><strong>
                                        @if ($hours > 0)
                                            {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                        @endif
                                        @if ($minutes > 0)
                                            {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }}
                                        @else
                                            {{ $lessonsCount > 0 ? ($lessonsCount * 5) . ' Minutes (estimated)' : '0 Minutes' }}
                                        @endif
                                    </strong> Total Duration</span>
                                </div>
                                
                                {{-- Temporary debug info (remove in production) --}}
                                {{-- 
                                <div class="stat-item d-flex align-items-center mb-2" style="font-size: 10px; color: #999;">
                                    Debug: H:{{ $hours ?? 'null' }} M:{{ $minutes ?? 'null' }} 
                                    Modules:{{ $modulesCount ?? 'null' }} Lessons:{{ $lessonsCount ?? 'null' }}
                                    Controller: H:{{ $totalHours ?? 'null' }} M:{{ $totalMinutes ?? 'null' }}
                                </div>
                                --}}

                                <div class="flex items-center gap-3">
                                    <i class="fas fa-list-ul text-orange w-5"></i>
                                    <span class="text-gray-700"><strong>{{ $lessonsCount }} Lesson{{ $lessonsCount != 1 ? 's' : '' }}</strong> in <strong>{{ $modulesCount }} Module{{ $modulesCount != 1 ? 's' : '' }}</strong></span>
                                </div>

                                @if ($course->language)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-language text-orange w-5"></i>
                                    <span class="text-gray-700">Language: <strong>{{ $course->language }}</strong></span>
                                </div>
                                @endif

                                @if ($course->platform)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-desktop text-orange w-5"></i>
                                    <span class="text-gray-700">Platform: <strong>{{ $course->platform }}</strong></span>
                                </div>
                                @endif

                                <div class="flex items-center gap-3">
                                    <i class="fas fa-infinity text-orange w-5"></i>
                                    <span class="text-gray-700"><strong>Full Lifetime Access</strong></span>
                                </div>

                                @if ($course->hascertificate)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-certificate text-orange w-5"></i>
                                    <span class="text-gray-700"><strong>Certificate of Completion</strong></span>
                                </div>
                                @endif

                                @if ($course->level)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-layer-group text-orange w-5"></i>
                                    <span class="text-gray-700">Level: <strong>{{ ucfirst($course->level) }}</strong></span>
                                </div>
                                @endif

                                @if ($course->updated_at)
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-calendar-alt text-orange w-5"></i>
                                    <span class="text-gray-700">Updated: <strong>{{ \Carbon\Carbon::parse($course->updated_at)->format('M Y') }}</strong></span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- overview tab modal start --}}
    <div class="fixed inset-0 z-50 hidden" id="exampleModal">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('exampleModal')"></div>
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl mx-4">
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                    <div class="p-0">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900">Course Preview</h5>
                                    <h4 class="text-2xl font-bold text-gray-900 mt-1">{{ $course->title }}</h4>
                                </div>
                                <button type="button" onclick="closeModal('exampleModal')" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                    <i class="fas fa-times text-orange"></i>
                                </button>
                            </div>

                            <div class="aspect-video rounded-2xl overflow-hidden mb-6">
                                @if ($promo_video_link != '')
                                    <iframe class="youtubePlayer w-full h-full" src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                                @else
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="Thumbnail" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="space-y-4">
                                <h5 class="text-lg font-semibold text-gray-900">Course Videos:</h5>
                                <div class="max-h-64 overflow-y-auto space-y-3">
                                    @foreach ($course->modules as $module)
                                        @foreach ($module->lessons as $lesson)
                                            @if ($lesson->type == 'video')
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ asset('assets/images/icons/icon-play.svg') }}" alt="Play" class="w-5 h-5">
                                                        <p class="text-gray-900 font-medium">{{ $lesson->title }}</p>
                                                    </div>
                                                    <img src="{{ asset('assets/images/icons/lok.svg') }}" alt="Lock" class="w-5 h-5">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- overview tab modal end --}}

    {{-- share course modal --}}
    <div class="fixed inset-0 z-50 hidden" id="exampleModal2">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('exampleModal2')"></div>
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md mx-4">
            <div class="bg-white rounded-2xl p-8">
                <div class="text-center mb-8">
                    <h4 class="text-2xl font-bold text-gray-900 mb-2">Share</h4>
                    <button type="button" onclick="closeModal('exampleModal2')" class="absolute top-4 right-4 p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-times text-orange"></i>
                    </button>
                </div>
                
                <div class="mb-8">
                    <h6 class="text-sm font-semibold text-gray-700 mb-4">As a post</h6>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('courses/overview-courses', $course->slug) }}" target="_blank" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/fb.svg') }}" alt="Facebook" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">Facebook</span>
                        </a>
                        <a href="#" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/tg.svg') }}" alt="Telegram" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">Telegram</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ url('courses/overview-courses', $course->slug) }}" target="_blank" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/linkedin-ic.svg') }}" alt="LinkedIn" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">LinkedIn</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url('courses/overview-courses', $course->slug) }}&text={{ $course->title }}" target="_blank" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/twt.svg') }}" alt="Twitter" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">Twitter</span>
                        </a>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h6 class="text-sm font-semibold text-gray-700 mb-4">As a message</h6>
                    <div class="flex gap-4 justify-center">
                        <a href="https://www.messenger.com/share.php?text={{ url('courses/overview-courses', $course->slug) }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/messenger.svg') }}" alt="Messenger" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">Messenger</span>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ url('courses/overview-courses', $course->slug) }}" class="flex flex-col items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/wapp.svg') }}" alt="WhatsApp" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">WhatsApp</span>
                        </a>
                        <a href="https://telegram.me/share/url?url={{ url('courses/overview-courses', $course->slug) }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                            <img src="{{ asset('assets/images/icons/teleg.svg') }}" alt="Telegram" class="w-8 h-8 mb-2">
                            <span class="text-sm font-medium text-gray-900">Telegram</span>
                        </a>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h6 class="text-sm font-semibold text-gray-700">Or copy link</h6>
                        <span id="notify" class="text-orange text-sm font-medium"></span>
                    </div>
                    <div class="flex gap-2">
                        <input autocomplete="off" type="text" placeholder="Link" value="{{ url('courses/overview-courses', $course->slug) }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="linkToCopy" readonly>
                        <button type="button" id="copyButton" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">Copy</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    {{-- share course modal --}}

@endsection

{{-- js --}}
@section('script')
    <script>
        // Modal Functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        
        // Module Toggle Function
        function toggleModule(moduleId) {
            const collapse = document.getElementById(`collapse_${moduleId}`);
            const icon = document.getElementById(`icon_${moduleId}`);
            
            if (collapse.classList.contains('hidden')) {
                collapse.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                collapse.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
        
        // Modal event listeners
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const target = button.getAttribute('data-bs-target');
                if (target) {
                    const modalId = target.replace('#', '');
                    openModal(modalId);
                }
            });
        });
        
        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');
        const likeBttn = document.getElementById('likeBttn');

        if (likeBttn) {
            likeBttn.addEventListener('click', (e) => {
                const course_id = {{ $course->id }};
                const ins_id = {{ $course->user_id }};

                fetch(`${baseUrl}/student/course-like/${course_id}/${ins_id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'liked') {
                            likeBttn.classList.add('active');
                        } else {
                            likeBttn.classList.remove('active');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    </script>

    <script>
        const copyButton = document.getElementById("copyButton");
        const linkToCopy = document.getElementById("linkToCopy");
        const notify = document.getElementById("notify");

        if (copyButton && linkToCopy && notify) {
            copyButton.addEventListener("click", (e) => {
                e.preventDefault();
                linkToCopy.select();
                document.execCommand("copy");
                notify.innerText = 'Copied!';

                setTimeout(() => {
                    notify.innerText = '';
                }, 1000);
            });
        }
    </script>

    {{-- Video Popup Script --}}
    <script>
        $(document).ready(function() {
            // Video popup functionality
            $('.lesson-playable').click(function(e) {
                e.preventDefault();
                
                const videoUrl = $(this).data('video-url');
                const lessonType = $(this).data('lesson-type');
                const lessonTitle = $(this).find('.flex-grow-1').text().trim();
                
                if (!videoUrl || (lessonType !== 'video' && lessonType !== 'audio')) {
                    return;
                }
                
                // Detect video platform and create embed URL with download protection
                let embedUrl = '';
                let platform = '';
                
                // YouTube detection with download protection
                if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    platform = 'youtube';
                    let videoId = '';
                    
                    if (videoUrl.includes('youtu.be/')) {
                        videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                    } else if (videoUrl.includes('watch?v=')) {
                        videoId = videoUrl.split('watch?v=')[1].split('&')[0];
                    }
                    
                    if (videoId) {
                        // YouTube embed with download protection parameters
                        embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&fs=0&disablekb=1`;
                    }
                }
                // Vimeo detection with download protection
                else if (videoUrl.includes('vimeo.com')) {
                    platform = 'vimeo';
                    const videoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                    if (videoId) {
                        // Vimeo embed with download protection parameters
                        embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1&portrait=0&title=0&byline=0&controls=1&dnt=1&pip=0`;
                    }
                }
                
                if (embedUrl) {
                    // Create and show popup modal with video protection
                    const modalHtml = `
                        <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">${lessonTitle}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="ratio ratio-16x9">
                                            <iframe 
                                                src="${embedUrl}" 
                                                frameborder="0"
                                                allowfullscreen 
                                                allow="autoplay"
                                                oncontextmenu="return false;"
                                                controlslist="nodownload nofullscreen noremoteplayback"
                                                disablepictureinpicture
                                                style="pointer-events: auto; user-select: none;">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove existing modal if any
                    $('#videoModal').remove();
                    
                    // Add modal to body and show
                    $('body').append(modalHtml);
                    $('#videoModal').modal('show');
                    
                    // Add video protection after modal is shown
                    $('#videoModal').on('shown.bs.modal', function() {
                        addVideoProtectionToModal();
                    });
                    
                    // Clean up when modal is closed
                    $('#videoModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });
                } else {
                    // Show error for unsupported video formats
                    const modalHtml = `
                        <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Invalid Video</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                        <h4>Invalid video URL</h4>
                                        <p class="text-muted">Only YouTube and Vimeo videos are supported.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove existing modal if any
                    $('#videoModal').remove();
                    
                    // Add modal to body and show
                    $('body').append(modalHtml);
                    $('#videoModal').modal('show');
                    
                    // Clean up when modal is closed
                    $('#videoModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });
                }
            });

            // Video protection function for modal
            function addVideoProtectionToModal() {
                const videoModal = document.getElementById('videoModal');
                if (videoModal) {
                    // Disable right-click on modal
                    videoModal.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                        return false;
                    });

                    // Disable drag
                    videoModal.addEventListener('dragstart', function(e) {
                        e.preventDefault();
                        return false;
                    });

                    // Disable text selection
                    videoModal.style.userSelect = 'none';
                    videoModal.style.webkitUserSelect = 'none';
                    videoModal.style.mozUserSelect = 'none';
                    videoModal.style.msUserSelect = 'none';

                    // Find iframe and add additional protection
                    const iframe = videoModal.querySelector('iframe');
                    if (iframe) {
                        iframe.style.pointerEvents = 'auto';
                        iframe.style.userSelect = 'none';
                    }
                }

                // Disable keyboard shortcuts when modal is open
                const keydownHandler = function(e) {
                    // Disable F12 (Developer Tools)
                    if (e.keyCode === 123) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Disable Ctrl+Shift+I (Developer Tools)
                    if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Disable Ctrl+U (View Source)
                    if (e.ctrlKey && e.keyCode === 85) {
                        e.preventDefault();
                        return false;
                    }

                    // Disable Ctrl+S (Save)
                    if (e.ctrlKey && e.keyCode === 83) {
                        e.preventDefault();
                        return false;
                    }
                };

                document.addEventListener('keydown', keydownHandler);

                // Remove keydown handler when modal is closed
                $('#videoModal').on('hidden.bs.modal', function() {
                    document.removeEventListener('keydown', keydownHandler);
                });
            }
        });
    </script>

@endsection
{{-- js --}}
