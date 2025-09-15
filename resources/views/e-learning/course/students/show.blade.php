@extends('layouts/student-modern')
@section('title')
    {{ $course->title ? $course->title : 'Course Details' }}
@endsection
@php
    use Illuminate\Support\Str;
@endphp

{{-- page style @S --}}
@section('style')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        200: '#bfdbfe',
                        300: '#93c5fd',
                        400: '#60a5fa',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8',
                        800: '#1e40af',
                        900: '#1e3a8a',
                        950: '#172554',
                    },
                    dark: {
                        50: '#f8fafc',
                        100: '#f1f5f9',
                        200: '#e2e8f0',
                        300: '#cbd5e1',
                        400: '#94a3b8',
                        500: '#64748b',
                        600: '#475569',
                        700: '#334155',
                        800: '#1e293b',
                        900: '#0f172a',
                        950: '#020617',
                    }
                }
            }
        }
    }
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    .font-inter { font-family: 'Inter', sans-serif; }
    
    /* Play/Pause icon control */
    .video_list_play .actv-show {
        display: none;
    }
    
    .video_list_play.active .actv-hide {
        display: none;
    }
    
    .video_list_play.active .actv-show {
        display: inline;
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .dark .glass-effect {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .glow-card {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
        transition: all 0.3s ease;
    }
    
    .glow-card:hover {
        box-shadow: 0 0 30px rgba(59, 130, 246, 0.25);
        transform: translateY(-2px);
    }

    /* Custom accordion styles */
    .accordion-button:not(.collapsed) {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border-radius: 0.75rem;
    }

    /* Video player styles */
    .video-container {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection
{{-- page style @E --}}

@section('seo')
    <meta name="keywords" content="{{ $course->categories . ', ' . $course->meta_keyword }}" />
    <meta name="description" content="{{ $course->meta_description }}" itemprop="description">
@endsection

@section('content')
    @php
        $i = 0;
    @endphp
    
    <!-- Debug information - remove in production -->
    @if(config('app.debug'))
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-4 text-sm hidden">
            <strong class="font-semibold text-blue-800 dark:text-blue-200">Debug Info:</strong> 
            <span class="text-blue-700 dark:text-blue-300">
                Completed Lessons: {{ count($userCompletedLessons ?? []) }} | 
                Lesson IDs: {{ implode(',', array_keys($userCompletedLessons ?? [])) }}
            </span>
        </div>
    @endif
    
    <div class="max-w-full mx-auto p-3">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <!-- Main Content Area - 2/3 width on large screens -->
            <div class="lg:col-span-8 px-3">
                <!-- Video Player Section -->
                @if ($isUserEnrolled)
                    <div class="glass-effect rounded-2xl mb-6 glow-card">
                        <div class="video-container rounded-xl overflow-hidden bg-gray-900" id="videoPlayerContainer" style="display: block;">
                                @if ($firstLesson)
                                    @php
                                        $videoLink = $firstLesson->video_link;
                                        $isYoutube = !empty($videoLink) && (strpos($videoLink, 'youtube.com') !== false || strpos($videoLink, 'youtu.be') !== false);
                                        $isVimeo = !empty($videoLink) && strpos($videoLink, 'vimeo.com') !== false;
                                        $embedUrl = '';
                                        
                                        if ($isYoutube) {
                                            $embedUrl = getYouTubeEmbedUrl($videoLink);
                                        } elseif ($isVimeo) {
                                            $embedUrl = getVimeoEmbedUrl($videoLink);
                                        }
                                    @endphp
                                    
                                    @if ($isYoutube && !empty($embedUrl))
                                        <div class="youtube-player w-full aspect-video" id="firstLesson"
                                            data-video-url="{{ $embedUrl }}"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="youtube">
                                            <iframe width="100%" height="100%" src="{{ $embedUrl }}" frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen class="rounded-lg"></iframe>
                                        </div>
                                    @elseif ($isVimeo && !empty($embedUrl))
                                        <div class="vimeo-player w-full aspect-video" id="firstLesson"
                                            data-vimeo-url="{{ $embedUrl }}"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="vimeo">
                                            <iframe width="100%" height="100%" src="{{ $embedUrl }}" frameborder="0" 
                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>
                                        </div>
                                    @elseif (!empty($videoLink))
                                        <div class="generic-video-player w-full aspect-video" id="firstLesson"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="generic">
                                            <video width="100%" height="100%" controls class="rounded-lg">
                                                <source src="{{ $videoLink }}" type="video/mp4">
                                                আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                                            </video>
                                        </div>
                                    @else
                                        <div class="no-video-placeholder w-full aspect-video bg-gray-100 dark:bg-gray-800 flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                                            <div class="text-center">
                                                <i class="fas fa-play-circle text-4xl text-gray-400 mb-3"></i>
                                                <p class="text-gray-500 dark:text-gray-400">প্রথম লেসনে কোনো ভিডিও নেই</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="no-lesson-placeholder w-full aspect-video bg-gray-100 dark:bg-gray-800 flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                                        <div class="text-center">
                                            <i class="fas fa-book-open text-4xl text-gray-400 mb-3"></i>
                                            <p class="text-gray-500 dark:text-gray-400">এই কোর্সে কোনো লেসন পাওয়া যায়নি</p>
                                        </div>
                                    </div>
                                @endif
                        </div>

                        {{-- Dynamic Video Players --}}
                        <div class="youtube-player w-full aspect-video hidden">
                            <iframe width="100%" height="100%" src="" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen class="rounded-lg"></iframe>
                        </div>
                        
                        <div class="vimeo-player w-full aspect-video hidden">
                            <iframe width="100%" height="100%" src="" frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>
                        </div>
                        
                        <div class="generic-video-player w-full aspect-video hidden">
                            <video width="100%" height="100%" controls class="rounded-lg">
                                <source src="" type="video/mp4">
                                আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                            </video>
                        </div>

                        {{-- Audio Player --}}
                        <div class="audio-iframe-box hidden bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <img src="{{ asset('assets/images/audio.png') }}" alt="Audio" class="w-24 h-24 rounded-lg shadow-lg">
                            </div>
                            <div class="audio-controls">
                                <audio id="audioPlayer" controls class="w-full rounded-lg bg-black/20">
                                    <source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Course Header -->
                <div class="glass-effect rounded-2xl p-6 mb-6 glow-card">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->title }}</h1>
                            <p class="text-gray-600 dark:text-gray-300 flex items-center">
                                <i class="fas fa-user-tie mr-2 text-primary-500"></i>
                                {{ $course->user->name }}
                            </p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            <!-- Like Button -->
                            <button class="p-3 rounded-lg transition-all duration-300 {{ $liked === 'active' ? 'text-red-400 active' : 'text-gray-400' }}" 
                                    id="likeBttn">
                                <i class="fas fa-heart text-lg"></i>
                            </button>
                            
                            {{-- Mark as Complete Button --}}
                            @if($isUserEnrolled)
                                <button class="px-4 py-2 text-gray-600 rounded-lg font-medium transition-all duration-300 btn-secondary text-sm text-green-500" id="markCompleteBtn" 
                                    data-course="{{ $course->id }}"
                                    data-module=""
                                    data-lesson=""
                                    data-duration="0"
                                    disabled>
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Completed
                                </button>
                            @else
                                <button class="px-4  transition-all duration-300 text-gray-600 py-2 rounded-lg font-medium bg-gray-600 text-gray-300 cursor-not-allowed text-sm" disabled>
                                    <i class="fas fa-lock mr-1"></i>
                                    Not Enrolled
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Text Content Area (Hidden by default) -->
                <div class="glass-effect rounded-2xl p-6 mb-6 hidden" id="textHideShow">
                    <div class="prose dark:prose-invert max-w-none">
                        <div id="dataTextContainer" class="text-gray-700 dark:text-gray-300"></div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mb-6 hidden" id="textHideShowSeparator"></div>

                <!-- Live Lesson Content Area (Hidden by default) -->
                <div class="glass-effect rounded-2xl p-6 mb-6 hidden" id="liveLessonContent">
                    <div class="text-center">
                        <!-- Live Lesson Status Icon -->
                        <div class="mb-4" id="liveLessonStatus">
                            <i class="fas fa-video text-4xl text-primary-500 mb-3"></i>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" id="liveLessonTitle">Live Lesson</h3>
                        </div>
                        
                        <!-- Live Lesson Info -->
                        <div class="mb-6" id="liveLessonInfo">
                            <p class="text-gray-600 dark:text-gray-400 mb-2" id="liveLessonTime">Starting time will appear here</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500" id="liveLessonDuration">Duration: 60 minutes</p>
                        </div>
                        
                        <!-- Countdown or Action Area -->
                        <div class="mb-4" id="liveLessonAction">
                            <!-- Countdown will be shown here for upcoming lessons -->
                            <div id="countdownDisplay" class="hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg p-4 mb-4">
                                    <div class="flex items-center justify-center space-x-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold" id="countdownDays">00</div>
                                            <div class="text-xs">Days</div>
                                        </div>
                                        <div class="text-xl">:</div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold" id="countdownHours">00</div>
                                            <div class="text-xs">Hours</div>
                                        </div>
                                        <div class="text-xl">:</div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold" id="countdownMinutes">00</div>
                                            <div class="text-xs">Minutes</div>
                                        </div>
                                        <div class="text-xl">:</div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold" id="countdownSeconds">00</div>
                                            <div class="text-xs">Seconds</div>
                                        </div>
                                    </div>
                                    <p class="text-center mt-2 text-sm">Live class starts in</p>
                                </div>
                                
                                <!-- Zoom Download Info -->
                                <div id="zoomDownloadInfo" class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-download text-blue-600 mr-2"></i>
                                        <h4 class="text-blue-800 dark:text-blue-200 font-semibold">Zoom অ্যাপ ডাউনলোড করুন</h4>
                                    </div>
                                    <p class="text-blue-700 dark:text-blue-300 text-sm mb-3">
                                        লাইভ ক্লাসে অংশগ্রহণের জন্য আপনার ডিভাইসে Zoom অ্যাপ ইনস্টল করুন:
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="https://zoom.us/download" target="_blank" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition-colors">
                                            <i class="fas fa-desktop mr-1"></i>
                                            Desktop
                                        </a>
                                        <a href="https://apps.apple.com/app/zoom/id546505307" target="_blank" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition-colors">
                                            <i class="fab fa-apple mr-1"></i>
                                            iOS
                                        </a>
                                        <a href="https://play.google.com/store/apps/details?id=us.zoom.videomeetings" target="_blank" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition-colors">
                                            <i class="fab fa-google-play mr-1"></i>
                                            Android
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Zoom Meeting Details (shown when live) -->
                            <div id="zoomMeetingDetails" class="hidden mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-video text-red-600 mr-2"></i>
                                    <h4 class="text-red-800 dark:text-red-200 font-semibold">Zoom Meeting Details</h4>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-800 rounded border">
                                        <span class="text-gray-600 dark:text-gray-400">Meeting ID:</span>
                                        <span id="zoomMeetingId" class="font-mono text-gray-900 dark:text-white font-semibold">--</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-800 rounded border">
                                        <span class="text-gray-600 dark:text-gray-400">Password:</span>
                                        <span id="zoomPassword" class="font-mono text-gray-900 dark:text-white font-semibold">--</span>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-800 rounded border">
                                        <span class="text-gray-600 dark:text-gray-400">Join URL:</span>
                                        <a id="zoomJoinUrl" href="#" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-xs break-all">--</a>
                                    </div>
                                </div>
                                <p class="text-red-700 dark:text-red-300 text-xs mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    You can copy these details to join manually if the button doesn't work
                                </p>
                            </div>
                            
                            <!-- Join Button for live lessons -->
                            <button id="joinLiveBtn" class="hidden bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 animate-pulse">
                                <i class="fas fa-video mr-2"></i>
                                Join Live Class
                            </button>
                            
                            <!-- Expired message -->
                            <div id="expiredMessage" class="hidden bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-6 py-3 rounded-lg">
                                <i class="fas fa-history mr-2"></i>
                                This live class has ended
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- About Course Section -->
                <div class="glass-effect rounded-2xl p-6 mb-6">
                    <h3 id="aboutCourse" class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                        About Course
                    </h3>
                    <div class="prose dark:prose-invert max-w-none" id="lessonShortDesc">
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! $course->description !!}
                        </div>
                    </div>
                </div>

                    {{-- 
                    <div class="download-files-box">
                        <h4>Download Files </h4>

                        <div class="files">
                            <a href="#">
                                PDF<img src="{{ asset('assets/images/icons/download.svg') }}" alt="clock" title="" class="img-fluid">
                            </a>
                            
                            <a href="#">Certificate Download <img src="{{ asset('assets/images/icons/download.svg') }}" alt="clock" title="120MB" class="img-fluid"></a>
                        </div>
                    </div> 
                    --}}
                <!-- Related Courses Section -->
                @if (count($relatedCourses) > 0)
                    <div class="glass-effect rounded-2xl p-6 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-graduation-cap mr-2 text-primary-500"></i>
                            Related Courses
                        </h3>
                        
                        <!-- Related Courses Grid - Max 2 items side by side -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($relatedCourses->take(2) as $relatedCourse)
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                                    <!-- Course Thumbnail -->
                                    <div class="aspect-video w-full">
                                        @if ($relatedCourse->thumbnail)
                                            <img src="{{ asset($relatedCourse->thumbnail) }}" alt="Course Thumbnail" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('assets/images/courses/thumbnail.png') }}" alt="Course Thumbnail" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    
                                    <!-- Course Info -->
                                    <div class="p-4">
                                        <!-- Course Title -->
                                        @if (isset($userEnrolledCourses[$relatedCourse->id]))
                                            <a href="{{ url('student/courses/my-courses/details/' . $relatedCourse->slug) }}"
                                               class="font-semibold text-lg text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 line-clamp-2">
                                                {{ $relatedCourse->title }}
                                            </a>
                                        @else
                                            <a href="{{ url('student/courses/overview/' . $relatedCourse->slug) }}"
                                               class="font-semibold text-lg text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 line-clamp-2">
                                                {{ $relatedCourse->title }}
                                            </a>
                                        @endif

                                        <!-- Instructor Name -->
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 mb-3">{{ $relatedCourse->user->name }}</p>

                                        <!-- Rating and Reviews -->
                                        @php
                                            $review_sum = 0;
                                            $review_avg = 0;
                                            $total = 0;
                                            foreach ($relatedCourse->reviews as $review) {
                                                $total++;
                                                $review_sum += $review->star;
                                            }
                                            if ($total) {
                                                $review_avg = $review_sum / $total;
                                            }
                                        @endphp
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-1">{{ number_format($review_avg, 1) }}</span>
                                                <div class="flex items-center mr-2">
                                                    @for ($i = 0; $i < floor($review_avg); $i++)
                                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $total }})</span>
                                            </div>

                                            <!-- Price -->
                                            <div class="flex items-center">
                                                @if ($relatedCourse->offer_price)
                                                    <span class="font-bold text-lg text-primary-600 dark:text-primary-400">৳ {{ $relatedCourse->offer_price }}</span>
                                                    <span class="text-sm text-gray-500 line-through ml-2">৳ {{ $relatedCourse->price }}</span>
                                                @elseif(!$relatedCourse->offer_price && !$relatedCourse->price)
                                                    <span class="font-bold text-lg text-green-600 dark:text-green-400">Free</span>
                                                @else
                                                    <span class="font-bold text-lg text-primary-600 dark:text-primary-400">৳ {{ $relatedCourse->price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($course->allow_review)
                    <!-- Reviews Section -->
                    <div class="glass-effect rounded-2xl p-6 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-star mr-2 text-yellow-500"></i>
                            {{ count($course_reviews) }} Reviews
                        </h3>

                        <!-- Review Form -->
                        <div class="flex items-start space-x-4 mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            @if ($course->user->avatar)
                                @if ($course->user->user_role == 'student')
                                    <img src="{{ asset($course->user->avatar) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                                @endif
                            @else
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {!! strtoupper($course->user->name[0]) !!}
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <form action="{{ route('student.courses.review', $course->slug) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <input autocomplete="off" type="text" name="comment" id="review"
                                            placeholder="Write a review" 
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div id="full-stars" class="flex items-center space-x-1">
                                            <div class="rating-group flex space-x-1">
                                                <label aria-label="1 star" class="rating__label cursor-pointer" for="rating-1">
                                                    <i class="rating__icon rating__icon--star fa fa-star text-gray-300 hover:text-yellow-400"></i>
                                                </label>
                                                <input class="rating__input hidden" name="star" id="rating-1" value="1" type="radio">
                                                <label aria-label="2 stars" class="rating__label cursor-pointer" for="rating-2">
                                                    <i class="rating__icon rating__icon--star fa fa-star text-gray-300 hover:text-yellow-400"></i>
                                                </label>
                                                <input class="rating__input hidden" name="star" id="rating-2" value="2" type="radio">
                                                <label aria-label="3 stars" class="rating__label cursor-pointer" for="rating-3">
                                                    <i class="rating__icon rating__icon--star fa fa-star text-gray-300 hover:text-yellow-400"></i>
                                                </label>
                                                <input class="rating__input hidden" name="star" id="rating-3" value="3" type="radio" checked>
                                                <label aria-label="4 stars" class="rating__label cursor-pointer" for="rating-4">
                                                    <i class="rating__icon rating__icon--star fa fa-star text-gray-300 hover:text-yellow-400"></i>
                                                </label>
                                                <input class="rating__input hidden" name="star" id="rating-4" value="4" type="radio">
                                                <label aria-label="5 stars" class="rating__label cursor-pointer" for="rating-5">
                                                    <i class="rating__icon rating__icon--star fa fa-star text-gray-300 hover:text-yellow-400"></i>
                                                </label>
                                                <input class="rating__input hidden" name="star" id="rating-5" value="5" type="radio">
                                            </div>
                                        </div>
                                        <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors duration-200">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        @if (count($course_reviews) > 0)
                            <div class="space-y-4">
                                @foreach ($course_reviews as $course_review)
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                        @if ($course_review->user && $course_review->user->avatar)
                                            <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {!! strtoupper($course_review->user->name[0]) !!}
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <h5 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $course_review->user->name }}</h5>
                                            <div class="flex items-center mb-2">
                                                @for ($i = 0; $i < $course_review->star; $i++)
                                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                @endfor
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-300">{{ $course_review->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400">No reviews yet. Be the first to review!</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <!-- Sidebar - 1/3 width on large screens -->
            <div class="lg:col-span-4">
                <!-- Course Modules -->
                <div class="glass-effect rounded-2xl p-4 glow-card sticky top-4">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-list-ul mr-2 text-primary-500"></i>
                            Modules
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $totalModules }} Module • {{ $totalLessons }} Lessons
                        </p>
                        
                        <!-- Real-time Lesson Search -->
                        <div class="mt-4 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input 
                                type="text" 
                                id="lessonSearchInput" 
                                placeholder="Search lessons..." 
                                class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                autocomplete="off"
                                oninput="searchLessons(this.value)"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button 
                                    type="button" 
                                    id="clearSearchBtn" 
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200 hidden"
                                    onclick="clearLessonSearch()"
                                >
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Search Results Counter -->
                        <div id="searchResultsInfo" class="mt-2 text-xs text-gray-500 dark:text-gray-400 hidden">
                            <span id="searchResultsCount"></span>
                        </div>
                    </div>
                    <div class="space-y-2" id="accordionExample">
                        @foreach ($course->modules as $module)
                            @if (count($module->lessons->where('status', 'published')) > 0)
                                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                                    <!-- Module Header -->
                                    <div class="p-3" id="heading_{{ $module->id }}">
                                        <button class="w-full text-left flex items-center justify-between hover:bg-gray-100 dark:hover:bg-gray-700/50 rounded-lg p-2 transition-colors duration-200" 
                                                type="button" 
                                                onclick="toggleAccordion({{ $module->id }})"
                                                aria-expanded="{{ $currentLesson && $currentLesson->module_id == $module->id ? 'true' : 'false' }}"
                                                aria-controls="collapse_{{ $module->id }}">
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle mr-3 text-lg {{ $module->isComplete() ? 'text-primary-500' : 'text-gray-400' }}" id="moduleCompletion_{{ $module->id }}"></i>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $module->title }}
                                                        @if($module->checkNumber())
                                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200 {{ $currentLesson && $currentLesson->module_id == $module->id ? 'rotate-180' : '' }}" id="chevron_{{ $module->id }}"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Module Content -->
                                    <div id="collapse_{{ $module->id }}"
                                        class="accordion-content {{ $currentLesson && $currentLesson->module_id == $module->id ? '' : 'hidden' }}"
                                        aria-labelledby="heading_{{ $module->id }}">
                                        <div class="px-3 pb-3">
                                            <div class="space-y-2" id="module_{{ $module->id }}">
                                                @foreach ($module->lessons as $lesson)
                                                    @if ($lesson->status == 'published')
                                                        @if (!$isUserEnrolled)
                                                            <div class="lesson-item flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-200" 
                                                                 data-lesson-title="{{ $lesson->title }}"
                                                                 data-lesson-slug="{{ $lesson->slug ?? '' }}"
                                                                 data-search-text="{{ strtolower($lesson->title . ' ' . ($lesson->slug ?? '')) }}">
                                                                <a href="{{ url('student/checkout/' . $course->slug) }}"
                                                                    class="video_list_play flex items-center w-full text-gray-600 dark:text-gray-400">
                                                                    <i class="fas fa-lock mr-3 text-gray-400"></i>
                                                                    <span class="flex-1">{{ $lesson->title }}</span>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="lesson-item lesson-clickable flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-200 cursor-pointer {{ $currentLesson && $currentLesson->id == $lesson->id ? 'bg-primary-50 dark:bg-primary-900/20 border-l-4 border-primary-500' : '' }}"
                                                                    data-video-id="{{ $lesson->id }}"
                                                                    data-lesson-id="{{ $lesson->id }}"
                                                                    data-course-id="{{ $course->id }}"
                                                                    data-modules-id="{{ $module->id }}"
                                                                    data-video-url="{{ $lesson->video_link ?? '' }}"
                                                                    data-audio-url="{{ $lesson->audio }}"
                                                                    data-lesson-type="{{ $lesson->type }}"
                                                                    data-lesson-duration="{{ $lesson->duration ?? 0 }}"
                                                                    data-instructor-id="{{ $course->user_id }}"
                                                                    data-lesson-title="{{ $lesson->title }}"
                                                                    data-lesson-slug="{{ $lesson->slug ?? '' }}"
                                                                    data-search-text="{{ strtolower($lesson->title . ' ' . ($lesson->slug ?? '')) }}"
                                                                    @if($lesson->type == 'live')
                                                                        data-live-start-time="{{ $lesson->live_start_time ? $lesson->live_start_time->toISOString() : '' }}"
                                                                        data-live-duration="{{ $lesson->live_duration_minutes ?? 60 }}"
                                                                        data-zoom-url="{{ $lesson->zoom_join_url ?? '' }}"
                                                                        data-zoom-meeting-id="{{ $lesson->zoom_meeting_id ?? '' }}"
                                                                        data-zoom-password="{{ $lesson->zoom_password ?? '' }}"
                                                                    @endif>

                                                                <!-- Completion Status -->
                                                                <span class="mr-3 cursor-pointer" id="completionIcon_{{ $lesson->id }}">
                                                                    @if (isset($userCompletedLessons[$lesson->id]))
                                                                        <i class="fas fa-check-circle text-green-500" 
                                                                           title="✅ Completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                    @else
                                                                        <i class="fas fa-check-circle text-gray-500 hover:text-green-400 is_complete_lesson cursor-pointer"
                                                                            data-course="{{ $course->id }}"
                                                                            data-module="{{ $module->id }}"
                                                                            data-lesson="{{ $lesson->id }}"
                                                                            data-duration="{{ $lesson->duration ?? 0 }}"
                                                                            data-user="{{ Auth::user()->id }}"
                                                                            title="⭕ Not completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                    @endif
                                                                </span>

                                                                <!-- Lesson Type Icon -->
                                                                <span class="mr-3">
                                                                    @if ($lesson->type == 'text')
                                                                        <i class="fa-regular fa-file-lines actv-hide text-gray-600 dark:text-gray-400"></i>
                                                                        <i class="fas fa-pause actv-show text-primary-500 hidden"></i>
                                                                    @elseif($lesson->type == 'audio')
                                                                        <i class="fa-solid fa-headphones actv-hide text-purple-600"></i>
                                                                        <i class="fas fa-pause actv-show text-primary-500 hidden"></i>
                                                                    @elseif($lesson->type == 'video')
                                                                        <i class="fas fa-play actv-hide text-red-500"></i>
                                                                        <i class="fas fa-pause actv-show text-primary-500 hidden"></i>
                                                                    @elseif($lesson->type == 'live')
                                                                        @if($lesson->isLive())
                                                                            <i class="fas fa-video text-red-500 animate-pulse" title="Live Now"></i>
                                                                        @elseif($lesson->isUpcoming())
                                                                            <i class="fas fa-clock text-blue-500" title="Scheduled"></i>
                                                                        @elseif($lesson->isExpired())
                                                                            <i class="fas fa-history text-gray-500" title="Expired"></i>
                                                                        @else
                                                                            <i class="fas fa-video text-gray-500"></i>
                                                                        @endif
                                                                    @endif
                                                                </span>

                                                                <!-- Lesson Title and Duration -->
                                                                <span class="flex-1 font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">{{ $lesson->title }}</span>
                                                                
                                                                <!-- Duration -->
                                                                @if($lesson->duration)
                                                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                                        @php
                                                                            $minutes = floor($lesson->duration / 60);
                                                                            $seconds = $lesson->duration % 60;
                                                                        @endphp
                                                                        @if($minutes > 0)
                                                                            {{ $minutes }}{{ $seconds > 0 ? ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT) : '' }} min
                                                                        @else
                                                                            {{ $seconds }}s
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

{{-- No additional styles needed - all handled by Tailwind --}}
@section('styles')
<style>
    /* Bootstrap collapse compatibility */
    .collapse:not(.show) {
        display: none;
    }
    
    .collapse.show {
        display: block;
    }
    
    /* Video protection styles */
    .video-container iframe {
        pointer-events: auto;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    
    /* Custom button styles for better compatibility */
    .btn-secondary {
        @apply bg-gray-600 text-gray-300;
    }
    
    .btn-success {
        @apply bg-green-600 text-white hover:bg-green-700;
    }
    
    /* Line clamp for course titles */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Enhanced search highlighting styles */
    mark {
        background-color: #fef08a !important;
        color: #854d0e !important;
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 600;
        animation: highlight-pulse 0.6s ease-out;
    }
    
    .dark-mode mark {
        background-color: #a16207 !important;
        color: #fef3c7 !important;
    }
    
    @keyframes highlight-pulse {
        0% { 
            background-color: #fbbf24;
            transform: scale(1.05);
        }
        100% { 
            background-color: #fef08a;
            transform: scale(1);
        }
    }
    
    /* Search input enhancements */
    #lessonSearchInput:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }
    
    .dark-mode #lessonSearchInput:focus {
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        border-color: #60a5fa;
    }
    
    /* Rating system styles */
    .rating__input:checked ~ .rating__label .rating__icon--star,
    .rating__label:hover .rating__icon--star,
    .rating__label:hover ~ .rating__label .rating__icon--star,
    .rating-group :hover ~ .rating__icon--star {
        color: #f59e0b !important;
    }

<<<<<<< HEAD

=======
>>>>>>> 8d9465a (course review error page fixed)
    /* Show selected stars (all stars before and including checked input) */
.rating__input:checked ~ .rating__label .rating__icon--star {
    color: #f59e0b !important; /* yellow-400 */
}

/* Show hover effect - highlight current and previous stars */
.rating__label:hover .rating__icon--star,
.rating__label:hover ~ .rating__label .rating__icon--star {
    color: #f59e0b !important;
}
<<<<<<< HEAD

=======
>>>>>>> 8d9465a (course review error page fixed)
</style>
@endsection

{{-- script section @S --}}
@section('script')
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Make accordion toggle function global so onclick can access it
        window.toggleAccordion = function(moduleId) {
            const content = document.getElementById('collapse_' + moduleId);
            const chevron = document.getElementById('chevron_' + moduleId);
            const button = content.previousElementSibling.querySelector('button');
            
            // Toggle visibility
            content.classList.toggle('hidden');
            
            // Toggle chevron rotation
            chevron.classList.toggle('rotate-180');
            
            // Update aria-expanded
            const isExpanded = !content.classList.contains('hidden');
            button.setAttribute('aria-expanded', isExpanded);
        }

        // Basic check - Is jQuery loaded?

        $(document).ready(function() {
            
            // jQuery is now loaded and working
            
            let currentURL = window.location.href;
            const baseUrl = currentURL.split('/').slice(0, 3).join('/');

            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Video/Audio players
            let audioPlayer = document.getElementById('audioPlayer');

            // Initialize with last lesson from course_logs
            @if($currentLesson)

                // Set the current lesson as active in sidebar using the new structure
                $('[data-lesson-id="{{ $currentLesson->id }}"]').addClass('bg-primary-50 dark:bg-primary-900/20 border-l-4 border-primary-500');
                $('[data-lesson-id="{{ $currentLesson->id }}"] .actv-hide').hide();
                $('[data-lesson-id="{{ $currentLesson->id }}"] .actv-show').show();

                @if($currentModule)
                    // Open the accordion for current module
                    $('#collapse_{{ $currentModule->id }}').removeClass('hidden');
                    $('#chevron_{{ $currentModule->id }}').addClass('rotate-180');
                @endif

                // Initialize the Mark as Complete button for current lesson
                updateMarkAsCompleteButton({{ $currentLesson->id }}, {{ $currentLesson->module_id }}, {{ $course->user_id }}, {{ $currentLesson->duration ?? 0 }});

                // Load the current lesson content
                @if($currentLesson->type == 'video' && $currentLesson->video_link)
                    document.querySelector('#videoPlayerContainer').style.display = 'block';
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    loadVideo('{{ $currentLesson->video_link }}', {{ $currentLesson->id }});
                @elseif($currentLesson->type == 'audio' && $currentLesson->audio)
                    document.querySelector('.audio-iframe-box').classList.remove('hidden');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    var audioSource = audioPlayer.querySelector('source');
                    audioSource.src = baseUrl + '/{{ $currentLesson->audio }}';
                    audioPlayer.load();
                    // Show Mark as Complete button for audio lessons
                    $('#markCompleteBtn').show();
                @elseif($currentLesson->type == 'text')
                    $('#textHideShow').show();
                    $('#textHideShowSeparator').show();
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    // Show Mark as Complete button for text lessons
                    $('#markCompleteBtn').show();
                @elseif($currentLesson->type == 'live')
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    
                    // Show live lesson content with current lesson data
                    showLiveLessonContent(
                        {{ $currentLesson->id }},
                        '{{ $currentLesson->live_start_time ? $currentLesson->live_start_time->toISOString() : '' }}',
                        {{ $currentLesson->live_duration_minutes ?? 60 }},
                        '{{ $currentLesson->zoom_join_url ?? '' }}',
                        '{{ $currentLesson->zoom_meeting_id ?? '' }}',
                        '{{ $currentLesson->zoom_password ?? '' }}'
                    );
                @endif
            @endif

            // Lesson functionality is now working

            // Main lesson click handler
            $(document).on('click', '.lesson-item.lesson-clickable', function(e) {
                // Don't prevent default for completion checkbox clicks
                if ($(e.target).hasClass('is_complete_lesson')) {
                    return; // Let the completion handler handle this
                }
                
                e.preventDefault();
                e.stopPropagation();
                
                // Get lesson data
                let type = this.getAttribute('data-lesson-type');
                let lessonId = this.getAttribute('data-lesson-id');
                let courseId = this.getAttribute('data-course-id');
                let moduleId = this.getAttribute('data-modules-id');
                let lessonDuration = this.getAttribute('data-lesson-duration') || 0;
                let instructorId = this.getAttribute('data-instructor-id');
                let videoUrl = this.getAttribute('data-video-url');
                let audioUrl = this.getAttribute('data-audio-url');


                // Log course progress - track last played lesson
                logCourseProgress(courseId, lessonId, moduleId);

                // Reset all lesson items - remove active state
                $('.lesson-item.lesson-clickable').removeClass('bg-primary-50 dark:bg-primary-900/20 border-l-4 border-primary-500');
                $('.lesson-item .actv-hide').show();
                $('.lesson-item .actv-show').hide();
                
                // Set current lesson as active
                $(this).addClass('bg-primary-50 dark:bg-primary-900/20 border-l-4 border-primary-500');
                $(this).find('.actv-hide').hide();
                $(this).find('.actv-show').show();

                // Handle different lesson types
                if (type == 'video' && videoUrl) {
                    
                    // Show video player, hide other media
                    document.querySelector('#videoPlayerContainer').style.display = 'block';
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    if (audioPlayer) audioPlayer.pause();

                    loadVideo(videoUrl, lessonId);

                } else if (type == 'audio' && audioUrl) {
                    if (audioPlayer) audioPlayer.pause();
                    document.querySelector('.audio-iframe-box').classList.remove('hidden');
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    document.querySelector('#videoPlayerContainer').style.display = 'none';

                    var fullAudioURL = baseUrl + '/' + audioUrl;
                    if (audioPlayer) {
                        let audioSource = audioPlayer.querySelector('source');
                        audioSource.src = fullAudioURL;
                        audioPlayer.load();
                        audioPlayer.play();
                    }
                    
                    // Show Mark as Complete button for audio lessons
                    $('#markCompleteBtn').show();

                } else if (type == 'text') {
                    if (audioPlayer) audioPlayer.pause();
                    
                    $('#textHideShow').show();
                    $('#textHideShowSeparator').show();
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    
                    // Show Mark as Complete button for text lessons
                    $('#markCompleteBtn').show();
                    
                } else if (type == 'live') {
                    if (audioPlayer) audioPlayer.pause();
                    
                    // Hide other media players
                    document.querySelector('.audio-iframe-box').classList.add('hidden');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    
                    // Get live lesson data attributes
                    let startTime = this.getAttribute('data-live-start-time');
                    let duration = this.getAttribute('data-live-duration');
                    let zoomUrl = this.getAttribute('data-zoom-url');
                    let zoomMeetingId = this.getAttribute('data-zoom-meeting-id');
                    let zoomPassword = this.getAttribute('data-zoom-password');
                    
                    // Show live lesson content area
                    showLiveLessonContent(lessonId, startTime, duration, zoomUrl, zoomMeetingId, zoomPassword);
                }

                // Update Mark as Complete button
                updateMarkAsCompleteButton(lessonId, moduleId, instructorId, lessonDuration);

                // Log course progress
                var data = {
                    courseId: courseId,
                    lessonId: lessonId,
                    moduleId: moduleId
                };
                
                $.ajax({
                    url: '{{ route('student.log.courses') }}',
                    method: 'GET',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        // Course progress logged successfully
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 302 || xhr.status === 401) {
                            // Authentication issue - redirect to login
                            window.location.href = '/login';
                        }
                    }
                });
            });

            // Video loading function with YouTube/Vimeo support
            function loadVideo(videoUrl, lessonId) {
                const videoContainer = document.getElementById('videoPlayerContainer');
                if (!videoContainer || !videoUrl) return;

                let embedUrl = '';

                // YouTube detection
                if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    let videoId = '';
                    
                    if (videoUrl.includes('youtu.be/')) {
                        videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                    } else if (videoUrl.includes('watch?v=')) {
                        videoId = videoUrl.split('watch?v=')[1].split('&')[0];
                    }
                    
                    if (videoId) {
                        embedUrl = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&fs=0&disablekb=1`;
                    }
                }
                
                // Vimeo detection
                if (videoUrl.includes('vimeo.com')) {
                    const videoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                    if (videoId) {
                        embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1&portrait=0&title=0&byline=0&controls=1&dnt=1&pip=0`;
                    }
                }

                if (embedUrl) {
                    videoContainer.innerHTML = `
                        <iframe 
                            src="${embedUrl}" 
                            width="100%" 
                            height="480" 
                            frameborder="0" 
                            allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen
                            style="pointer-events: auto;"
                            oncontextmenu="return false;"
                            controlslist="nodownload nofullscreen noremoteplayback"
                            disablepictureinpicture>
                        </iframe>
                    `;
                    
                    // Show Mark as Complete button for regular video lessons
                    $('#markCompleteBtn').show();
                } else {
                }
            }

            // Function to show live lesson content with countdown, redirect, etc.
            function showLiveLessonContent(lessonId, startTime, duration, zoomUrl, zoomMeetingId, zoomPassword) {
                
                // Hide Mark as Complete button for live sessions
                $('#markCompleteBtn').hide();
                
                // Show the live lesson content area
                $('#liveLessonContent').show();
                
                // Hide all action elements first
                $('#countdownDisplay').addClass('hidden');
                $('#joinLiveBtn').addClass('hidden');
                $('#expiredMessage').addClass('hidden');
                $('#zoomDownloadInfo').addClass('hidden');
                $('#zoomMeetingDetails').addClass('hidden');
                
                if (!startTime) {
                    // No start time set - show as unavailable
                    $('#liveLessonTitle').text('Live Lesson - Not Scheduled');
                    $('#liveLessonTime').text('This live lesson has not been scheduled yet');
                    $('#liveLessonDuration').text('Duration: ' + duration + ' minutes');
                    return;
                }
                
                const now = new Date();
                const startDateTime = new Date(startTime);
                const endDateTime = new Date(startDateTime.getTime() + duration * 60000);
                
                // Format start time for display
                const formatOptions = { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                };
                $('#liveLessonTime').text('Starts: ' + startDateTime.toLocaleDateString('en-US', formatOptions));
                $('#liveLessonDuration').text('Duration: ' + duration + ' minutes');
                
                // Determine lesson status and show appropriate content
                if (now >= startDateTime && now <= endDateTime) {
                    // Lesson is currently live
                    showLiveLessonLive(lessonId, zoomUrl, zoomMeetingId, zoomPassword);
                } else if (now < startDateTime) {
                    // Lesson is upcoming - show countdown
                    showLiveLessonCountdown(lessonId, startDateTime, zoomUrl, zoomMeetingId, zoomPassword);
                } else {
                    // Lesson has expired
                    showLiveLessonExpired(lessonId);
                }
            }
            
            // Function to show live lesson when it's currently live
            function showLiveLessonLive(lessonId, zoomUrl, zoomMeetingId, zoomPassword) {
                $('#liveLessonTitle').text('Live Lesson - Now Live!');
                $('#liveLessonStatus i').removeClass().addClass('fas fa-video text-4xl text-red-500 mb-3 animate-pulse');
                $('#liveLessonTime').text('🔴 Live session is currently running');
                
                // Show Zoom meeting details
                if (zoomMeetingId || zoomUrl) {
                    $('#zoomMeetingDetails').removeClass('hidden');
                    $('#zoomMeetingId').text(zoomMeetingId || 'Not provided');
                    $('#zoomPassword').text(zoomPassword || 'No password required');
                    if (zoomUrl) {
                        $('#zoomJoinUrl').attr('href', zoomUrl).text(zoomUrl);
                    } else {
                        $('#zoomJoinUrl').attr('href', '#').text('Not provided');
                    }
                }
                
                if (zoomUrl) {
                    $('#joinLiveBtn').removeClass('hidden').off('click').on('click', function() {
                        // Mark lesson as completed when joining
                        markLessonCompleted(lessonId);
                        // Open Zoom URL
                        window.open(zoomUrl, '_blank');
                        
                        // Update button text after joining
                        $(this).html('<i class="fas fa-check mr-2"></i>Joined - Lesson Completed').prop('disabled', true);
                        
                        // Update the mark as complete button to show completed state
                        setTimeout(function() {
                            const $button = $('#markCompleteBtn');
                            $button.removeClass('btn-success').addClass('btn-secondary');
                            $button.html('<i class="fas fa-check-circle me-1 text-green-500"></i><span class="text-green-500">Completed</span>');
                            $button.prop('disabled', true);
                        }, 1000);
                    });
                } else {
                    $('#joinLiveBtn').text('No Zoom URL Available').removeClass('hidden').prop('disabled', true);
                }
            }
            
            // Function to show countdown for upcoming live lesson
            function showLiveLessonCountdown(lessonId, startDateTime, zoomUrl, zoomMeetingId, zoomPassword) {
                $('#liveLessonTitle').text('Live Lesson - Coming Soon');
                $('#liveLessonStatus i').removeClass().addClass('fas fa-clock text-4xl text-blue-500 mb-3');
                $('#countdownDisplay').removeClass('hidden');
                $('#zoomDownloadInfo').removeClass('hidden');
                
                // Start countdown timer
                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = startDateTime.getTime() - now;
                    
                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        // Lesson has started - refresh the live lesson content
                        showLiveLessonContent(lessonId, startDateTime.toISOString(), 
                            parseInt($('#liveLessonDuration').text().match(/\d+/)[0]), zoomUrl, zoomMeetingId, zoomPassword);
                        return;
                    }
                    
                    // Calculate time units
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    // Update countdown display
                    $('#countdownDays').text(days.toString().padStart(2, '0'));
                    $('#countdownHours').text(hours.toString().padStart(2, '0'));
                    $('#countdownMinutes').text(minutes.toString().padStart(2, '0'));
                    $('#countdownSeconds').text(seconds.toString().padStart(2, '0'));
                }, 1000);
            }
            
            // Function to show expired live lesson
            function showLiveLessonExpired(lessonId) {
                $('#liveLessonTitle').text('Live Lesson - Ended');
                $('#liveLessonStatus i').removeClass().addClass('fas fa-history text-4xl text-gray-500 mb-3');
                $('#expiredMessage').removeClass('hidden');
                
                // Automatically mark expired live lesson as completed
                markLessonCompleted(lessonId);
                
                // Update the mark as complete button to show completed state
                setTimeout(function() {
                    const $button = $('#markCompleteBtn');
                    $button.removeClass('btn-success').addClass('btn-secondary');
                    $button.html('<i class="fas fa-check-circle me-1 text-green-500"></i><span class="text-green-500">Completed</span>');
                    $button.prop('disabled', true);
                }, 500);
            }
            
            // Function to mark lesson as completed (for live lessons)
            function markLessonCompleted(lessonId) {
                const data = {
                    courseId: {{ $course->id }},
                    moduleId: $('.lesson-item[data-lesson-id="' + lessonId + '"]').attr('data-modules-id'),
                    lessonId: lessonId,
                    duration: 0, // Always 0 for live sessions - duration not calculated
                    instructorId: {{ $course->user_id }},
                    userId: {{ Auth::user()->id }},
                    is_completed: true
                };
                
                $.ajax({
                    url: '{{ route('student.complete.lesson') }}',
                    method: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        // Update completion icon in sidebar
                        $('#completionIcon_' + lessonId + ' i').removeClass('text-gray-500 hover:text-green-400')
                            .addClass('text-green-500').removeClass('is_complete_lesson');
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }

            // Function to update the Mark as Complete button based on selected lesson
            function updateMarkAsCompleteButton(lessonId, moduleId, instructorId, duration) {
                
                var $button = $('#markCompleteBtn');
                
                // Check if lesson is already completed by checking the PHP-generated completed lessons array
                var completedLessons = @json(array_keys($userCompletedLessons ?? []));
                var isCompleted = completedLessons.includes(parseInt(lessonId));
                
                //     lessonId: lessonId,
                //     completedLessons: completedLessons,
                //     isCompleted: isCompleted
                // });
                
                if (isCompleted) {
                    // Lesson is already completed - show Completed and disable
                    $button.removeClass('btn-success').addClass('btn-secondary');
                    $button.html('<i class="fas fa-check-circle me-1 text-green-500"></i><span class="text-green-500">Completed</span>');
                    $button.prop('disabled', true);
                } else {
                    // Lesson not completed yet
                    $button.removeClass('btn-secondary').addClass('btn-success');
                    $button.html('<i class="fas fa-check-circle me-1 text-gray-600"></i><span class="text-gray-600">Mark as Complete</span>');
                    $button.prop('disabled', false);
                    
                    // Update button data attributes
                    $button.data('lesson', lessonId);
                    $button.data('module', moduleId);
                    $button.data('duration', duration);
                    $button.attr('data-lesson', lessonId);
                    $button.attr('data-module', moduleId);
                    $button.attr('data-duration', duration);
                    
                }
            }

            // Handle manual lesson completion clicks
            // $(document).on('click', '.is_complete_lesson', function(e) {
            //     e.preventDefault();
            //     e.stopPropagation(); // Prevent lesson click event
                
            //     var lessonId = $(this).data('lesson');
            //     var courseId = $(this).data('course');
            //     var moduleId = $(this).data('module');
            //     var duration = $(this).data('duration') || 0;
            //     var userId = $(this).data('user');
                
            //     var data = {
            //         courseId: courseId,
            //         lessonId: lessonId,
            //         moduleId: moduleId,
            //         instructorId: {{ $course->user_id }},
            //         duration: duration,
            //         is_completed: true
            //     };

            //     var $element = $(this);
                

            //     $.ajax({
            //         url: '{{ route('student.complete.lesson') }}',
            //         method: 'POST',
            //         data: data,
            //         beforeSend: function() {
            //             // Change class to spinner
            //             $element.removeClass('fas fa-check-circle').addClass('spinner-border spinner-border-sm');
            //         },
            //         success: function(response) {
            //             //     course_id: courseId,
            //             //     instructor_id: {{ $course->user_id }},
            //             //     module_id: moduleId,
            //             //     lesson_id: lessonId,
            //             //     user_id: userId,
            //             //     is_completed: true,
            //             //     duration: duration
            //             // });
                        
            //             // Change icon to success checkmark
            //             $element.removeClass('spinner-border spinner-border-sm text-gray-500 hover:text-green-400 is_complete_lesson').addClass('fas fa-check-circle text-green-500');
            //             $element.attr('title', '✅ Completed - Lesson ID: ' + lessonId);
                        
            //             // Update the module icon if all lessons in module are completed
            //             // updateModuleCompletionIcon(moduleId);
                        
            //         },
            //         error: function(xhr, status, error) {
            //             // Reset on error
            //             $element.removeClass('spinner-border spinner-border-sm').addClass('fas fa-check-circle');
            //         }
            //     });
            // });

            // Function to update module completion icon when all lessons are completed
            function updateModuleCompletionIcon(moduleId) {
                
                var $moduleHeader = $('#moduleCompletion_' + moduleId);
                var $allLessonsInModule = $('[data-modules-id="' + moduleId + '"] .is_complete_lesson');
                var totalLessons = $allLessonsInModule.length;
                var completedLessons = $allLessonsInModule.filter('.text-green-500').length;
                
                console.log('Module completion check:', {
                    moduleId: moduleId,
                    totalLessons: totalLessons,
                    completedLessons: completedLessons,
                    moduleHeaderElement: $moduleHeader[0]
                });
                
                if (totalLessons > 0 && completedLessons === totalLessons) {
                    // All lessons completed - make module icon primary color
                    $moduleHeader.removeClass('text-gray-400').addClass('text-primary-500');
                } else {
                    // Not all lessons completed - keep gray color
                    $moduleHeader.removeClass('text-primary-500').addClass('text-gray-400');
                }
            }

            // Initialize module completion status on page load
            @foreach($course->modules as $module)
                @if(count($module->lessons->where('status', 'published')) > 0)
                    updateModuleCompletionIcon({{ $module->id }});
                @endif
            @endforeach
            
            // Like button handler (moved inside document ready)
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
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                        })
                        .then(response => {
                            if (response.status === 302 || response.status === 401) {
                                window.location.href = '/login';
                                return;
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data) return; // Prevent errors if redirected
                            
                            if (data.message === 'liked') {
                                likeBttn.classList.add('active');
                                likeBttn.classList.remove('text-gray-400');
                                likeBttn.classList.add('text-red-600');
                            } else {
                                likeBttn.classList.remove('active');
                                likeBttn.classList.remove('text-red-600');
                                likeBttn.classList.add('text-gray-400');
                            }
                        })
                        .catch(error => {
                            likeBttn.classList.remove('active');
                        });
                });
            }
            
            // Mark as Complete functionality - moved inside document ready
            // Try multiple selectors to catch the button
            $(document).on('click', '#markCompleteBtn, .markCompleteBtn, button[data-lesson]', function(e) {
                    
                    e.preventDefault();
                    
                    // Debug: Check authentication status
                    console.log('- Auth User ID: {{ Auth::check() ? Auth::user()->id : "NOT AUTHENTICATED" }}');
                    console.log('- CSRF Token:', $('meta[name="csrf-token"]').attr('content'));
                    console.log('- Current URL:', window.location.href);
                    console.log('- Base URL:', baseUrl);
                    console.log('- Complete URL:', baseUrl + '/student/courses/complete-lesson');
                    console.log('- Laravel Route URL:', '{{ route("student.complete.lesson") }}');
                    
                    // Test simple auth endpoint first
                    console.log('🧪 Testing simple auth endpoint...');
                    $.ajax({
                        url: '{{ route("student.test.auth") }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            console.log('✅ Auth test SUCCESS:', response);
                        },
                        error: function(xhr, status, error) {
                            console.log('❌ Auth test FAILED:', {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText
                            });
                        }
                    });
                    
                    console.log('🎯 STEP 9: Extracting data attributes...');
                    var lessonId = $(this).data('lesson');
                    var courseId = $(this).data('course');
                    var moduleId = $(this).data('module');
                    var duration = $(this).data('duration') || 0;
                    
                    console.log('🎯 STEP 10: Data attributes extracted:');
                    console.log('- lessonId:', lessonId);
                    console.log('- courseId:', courseId);
                    console.log('- moduleId:', moduleId);
                    console.log('- duration:', duration);
                    
                    var data = {
                        courseId: courseId,
                        lessonId: lessonId,
                        moduleId: moduleId,
                        instructorId: {{ $course->user_id }},
                        duration: duration,
                        userId: {{ Auth::check() ? Auth::user()->id : 'null' }},
                        is_completed: true
                    };

                    console.log('🎯 STEP 11: Final data object:', data);
                    var $element = $(this);
                    console.log('🎯 STEP 12: Button element stored as $element');
                    
                    // Try fetch instead of jQuery AJAX
                    console.log('🎯 STEP 13: Starting fetch request...');
                    
                    // Update button state to loading
                    console.log('🎯 STEP 14: Updating button to loading state...');
                    $element.html('<i class="spinner-border spinner-border-sm me-1"></i>Marking...');
                    $element.prop('disabled', true);
                    console.log('🎯 STEP 15: Button updated successfully');
                    
                    // Try with form data instead of JSON
                    console.log('🎯 STEP 16: Creating FormData...');
                    const formData = new FormData();
                    Object.keys(data).forEach(key => {
                        console.log(`🎯 STEP 17: Adding to FormData - ${key}:`, data[key]);
                        formData.append(key, data[key]);
                    });
                    console.log('🎯 STEP 18: FormData created, entries:');
                    for (let [key, value] of formData.entries()) {
                        console.log(`  - ${key}: ${value}`);
                    }
                    
                    console.log('🎯 STEP 19: About to call fetch with URL:', '{{ route("student.complete.lesson") }}');
                    console.log('🎯 STEP 20: Fetch headers will be:');
                    console.log('  - X-CSRF-TOKEN:', $('meta[name="csrf-token"]').attr('content'));
                    console.log('  - X-Requested-With: XMLHttpRequest');
                    
                    fetch('{{ route("student.complete.lesson") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                            // Don't set Content-Type, let browser set it for FormData
                        },
                        body: formData,
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('🎯 STEP 21: Fetch .then() block reached!');
                        console.log('📡 Fetch response:', response);
                        console.log('- Status:', response.status);
                        console.log('- Status Text:', response.statusText);
                        console.log('- Redirected:', response.redirected);
                        console.log('- URL:', response.url);
                        console.log('- Headers:', [...response.headers.entries()]);
                        
                        if (response.status === 302) {
                            console.log('🚫 Got 302 redirect');
                            throw new Error('Session expired - 302 redirect');
                        }
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        // Check if response is actually JSON
                        const contentType = response.headers.get('content-type');
                        console.log('- Content-Type:', contentType);
                        
                        if (!contentType || !contentType.includes('application/json')) {
                            console.log('⚠️ Response is not JSON, likely redirected to HTML page');
                            // Get the text to see what page we're getting
                            return response.text().then(text => {
                                console.log('📄 Response text (first 500 chars):', text.substring(0, 500));
                                throw new Error('Expected JSON response but got HTML page');
                            });
                        }
                        
                        return response.json();
                    })
                    .then(data => {
                        console.log('🎯 STEP 22: Second .then() block reached - JSON parsed successfully!');
                        console.log('✅ Fetch SUCCESS:', data);
                        $element.html('<i class="fas fa-check-circle me-1 text-green-500"></i><span class="text-green-500">Completed</span>');
                        $element.removeClass('btn-success').addClass('btn-secondary');
                        $element.prop('disabled', true);
                    })
                    .catch(error => {
                        console.log('🎯 STEP 23: .catch() block reached - An error occurred!');
                        console.log('❌ Fetch ERROR:', error);
                        
                        // Reset button on error
                        $element.html('<i class="fas fa-check-circle me-1"></i>Mark as Complete');
                        $element.removeClass('btn-secondary').addClass('btn-success');
                        $element.prop('disabled', false);
                        
                        if (error.message.includes('302') || error.message.includes('Session expired')) {
                            alert('আপনার সেশন শেষ হয়ে গেছে। অনুগ্রহ করে পুনরায় লগইন করুন।');
                            window.location.href = '/login';
                        }
                    });
                    
                    console.log('🎯 STEP 24: Fetch request initiated, waiting for response...');
                    return; // Skip the old jQuery AJAX code
            });
            
        });
    
        var iframe = document.getElementById('firstLesson');
        if (iframe) {
            iframe.onload = function() {
            // Wait for the Vimeo player to be ready
            var playerDoc = iframe.contentDocument || iframe.contentWindow.document;

            // Add custom CSS to hide the .vp-sidedock element
            var customCSS = `
            .vp-sidedock {
                display: none !important;
            }
        `;

            // Create a style element and append it to the player's document
            var style = playerDoc.createElement('style');
            style.type = 'text/css';
            style.appendChild(playerDoc.createTextNode(customCSS));
            playerDoc.head.appendChild(style);
        };
        }

        // END OF SCRIPT
            
        // Simple and Effective Lesson Search Filter
        window.searchLessons = function(searchTerm) {
            const search = searchTerm.trim().toLowerCase();
            const clearBtn = document.getElementById('clearSearchBtn');
            const searchInfo = document.getElementById('searchResultsInfo');
            const searchCount = document.getElementById('searchResultsCount');
            
            // Show/hide clear button
            if (search.length > 0) {
                clearBtn.classList.remove('hidden');
                searchInfo.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
                searchInfo.classList.add('hidden');
            }
            
            let visibleLessons = 0;
            let visibleModules = 0;
            
            // Get all modules and lessons
            const modules = document.querySelectorAll('#accordionExample > div');
            
            modules.forEach(moduleDiv => {
                let moduleHasVisibleLessons = false;
                const lessons = moduleDiv.querySelectorAll('.lesson-item');
                
                lessons.forEach(lesson => {
                    let isVisible = false;
                    
                    if (search === '') {
                        // Show all lessons when search is empty
                        isVisible = true;
                    } else {
                        // Get lesson data
                        const lessonTitle = (lesson.getAttribute('data-lesson-title') || '').toLowerCase();
                        const lessonSlug = (lesson.getAttribute('data-lesson-slug') || '').toLowerCase();
                        
                        // Check if search term matches title OR slug
                        isVisible = lessonTitle.includes(search) || lessonSlug.includes(search);
                    }
                    
                    if (isVisible) {
                        lesson.style.display = 'flex';
                        moduleHasVisibleLessons = true;
                        visibleLessons++;
                        
                        // Highlight matching text
                        if (search !== '') {
                            highlightMatchingText(lesson, search);
                        } else {
                            removeHighlights(lesson);
                        }
                    } else {
                        lesson.style.display = 'none';
                        removeHighlights(lesson);
                    }
                });
                
                // Show/hide entire module based on whether it has visible lessons
                if (search === '' || moduleHasVisibleLessons) {
                    moduleDiv.style.display = 'block';
                    if (moduleHasVisibleLessons) visibleModules++;
                    
                    // Auto-expand modules with matching lessons when searching
                    if (search !== '' && moduleHasVisibleLessons) {
                        const moduleId = moduleDiv.querySelector('[id^="heading_"]')?.id.replace('heading_', '');
                        if (moduleId) {
                            const content = document.getElementById('collapse_' + moduleId);
                            const chevron = document.getElementById('chevron_' + moduleId);
                            
                            if (content && content.classList.contains('hidden')) {
                                content.classList.remove('hidden');
                                if (chevron) chevron.classList.add('rotate-180');
                            }
                        }
                    }
                } else {
                    moduleDiv.style.display = 'none';
                }
            });
            
            // Update search results counter
            if (search !== '') {
                if (visibleLessons === 0) {
                    searchCount.textContent = 'No lessons found';
                    searchCount.className = 'text-red-500 dark:text-red-400';
                } else if (visibleLessons === 1) {
                    searchCount.textContent = '1 lesson found';
                    searchCount.className = 'text-green-600 dark:text-green-400';
                } else {
                    searchCount.textContent = `${visibleLessons} lessons found in ${visibleModules} modules`;
                    searchCount.className = 'text-green-600 dark:text-green-400';
                }
            }
        }
        
        // Function to highlight matching text in lesson titles
        function highlightMatchingText(lesson, searchTerm) {
            if (!searchTerm || searchTerm.length < 1) return;
            
            const titleElement = lesson.querySelector('.font-medium');
            if (!titleElement) return;
            
            const originalText = titleElement.getAttribute('data-original-text') || titleElement.textContent;
            if (!titleElement.hasAttribute('data-original-text')) {
                titleElement.setAttribute('data-original-text', originalText);
            }
            
            // Escape special regex characters
            const escapedSearchTerm = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp(`(${escapedSearchTerm})`, 'gi');
            const highlightedText = originalText.replace(regex, '<mark class="bg-yellow-200 dark:bg-yellow-700 px-1 rounded">$1</mark>');
            
            titleElement.innerHTML = highlightedText;
        }
        
        // Function to remove highlights
        function removeHighlights(lesson) {
            const titleElement = lesson.querySelector('.font-medium');
            if (!titleElement) return;
            
            const originalText = titleElement.getAttribute('data-original-text');
            if (originalText) {
                titleElement.textContent = originalText;
            }
        }
        
        // Enhanced Clear search function
        window.clearLessonSearch = function() {
            const searchInput = document.getElementById('lessonSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            const searchInfo = document.getElementById('searchResultsInfo');
            
            searchInput.value = '';
            clearBtn.classList.add('hidden');
            searchInfo.classList.add('hidden');
            
            // Reset all lessons and modules visibility
            const modules = document.querySelectorAll('#accordionExample > div');
            const lessons = document.querySelectorAll('.lesson-item');
            
            modules.forEach(module => module.style.display = 'block');
            lessons.forEach(lesson => {
                lesson.style.display = 'flex';
                // Remove any highlights
                removeHighlights(lesson);
            });
            
            // Focus back to search input for better UX
            searchInput.focus();
        }
        
        // Course Progress Logging Function
        function logCourseProgress(courseId, lessonId, moduleId) {
            if (!courseId || !lessonId) {
                return;
            }

            $.ajax({
                url: '{{ route("student.log.courses") }}',
                type: 'POST',
                data: {
                    courseId: courseId,
                    lessonId: lessonId,
                    moduleId: moduleId,
                    _token: '{{ csrf_token() }}'
                }
            });
        }

        // Add keyboard shortcut for search (Ctrl/Cmd + K)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('lessonSearchInput').focus();
            }
        });
    </script>
@endsection
{{-- script section @E --}}