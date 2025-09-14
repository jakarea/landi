@extends('layouts.landing-static')
@section('title', $title)

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="min-h-screen bg-body">
    <!-- Course Hero Section -->
    <section class="w-full pt-12 pb-20 first-gradient relative overflow-hidden border-b border-[#fff]/20 xl:py-[120px]">
        <!-- Background Elements -->
        <div class="absolute inset-0 grid-background opacity-[13%] z-10"></div>
        <img src="{{ asset('/assets/landing/images/section-one-shadow.svg') }}" class="absolute inset-0 left-0 top-0 w-full h-full z-30" alt="shadow">
        
        @if($course->banner)
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('assets/images/courseds/' . $course->banner) }}" 
                     alt="{{ $course->title }}" 
                     class="w-full h-full object-cover opacity-30">
            </div>
        @endif

        <div class="container-x relative z-40">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 xl:gap-16">
                <!-- Course Content -->
                <div class="lg:col-span-2">
                    <!-- Course Title -->
                    <div class="mb-6">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 rounded-full bg-[#3C5D62] flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <span class="text-orange font-medium text-sm">{{ $course->categories ?? 'কোর্স' }}</span>
                        </div>
                        
                        <h1 class="font-bold text-3xl lg:text-4xl xl:text-5xl leading-[110%] text-white mb-4">
                            {{ $course->title }}
                        </h1>
                        
                        @if($course->sub_title)
                            <p class="text-secondary-200 text-lg lg:text-xl font-medium mb-6">
                                {{ $course->sub_title }}
                            </p>
                        @endif
                    </div>

                    <!-- Instructor Info -->
                    @if($course->user)
                        <div class="flex items-center gap-4 mb-6 p-4 bg-black/20 rounded-xl backdrop-blur-sm border border-[#fff]/10">
                            @if($course->user->avatar)
                                <img src="{{ asset($course->user->avatar) }}" 
                                     alt="{{ $course->user->name }}" 
                                     class="w-16 h-16 rounded-full border-2 border-orange">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-orange to-lime flex items-center justify-center text-xl font-bold text-primary">
                                    {{ strtoupper($course->user->name[0]) }}
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="text-white font-semibold text-lg">{{ $course->user->name }}</h3>
                                <p class="text-secondary-200 text-sm capitalize">{{ $course->user->user_role }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Course Stats -->
                    @php
                        // Use controller-calculated data with comprehensive fallbacks
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
                                $modulesCount++;
                                foreach ($module->lessons as $lesson) {
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
                                $estimatedMinutes = $lessonsCount * 5;
                                $hours = floor($estimatedMinutes / 60);
                                $minutes = $estimatedMinutes % 60;
                            }
                        } else {
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

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-black/20 rounded-xl p-4 text-center backdrop-blur-sm border border-[#fff]/10">
                            <div class="text-orange text-2xl font-bold">
                                @if($hours > 0) {{ $hours }}h @endif {{ $minutes }}m
                            </div>
                            <div class="text-secondary-200 text-sm">Duration</div>
                        </div>
                        
                        <div class="bg-black/20 rounded-xl p-4 text-center backdrop-blur-sm border border-[#fff]/10">
                            <div class="text-lime text-2xl font-bold">{{ $modulesCount }}</div>
                            <div class="text-secondary-200 text-sm">Modules</div>
                        </div>
                        
                        <div class="bg-black/20 rounded-xl p-4 text-center backdrop-blur-sm border border-[#fff]/10">
                            <div class="text-blue-400 text-2xl font-bold">{{ $lessonsCount }}</div>
                            <div class="text-secondary-200 text-sm">Lessons</div>
                        </div>

                        @if($course->allow_review)
                            <div class="bg-black/20 rounded-xl p-4 text-center backdrop-blur-sm border border-[#fff]/10">
                                <div class="flex items-center justify-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <div class="text-secondary-200 text-sm">({{ count($course_reviews) }}) Reviews</div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4">
                        @auth
                            @if(auth()->user()->user_role === 'student')
                                @if(isEnrolled($course->id))
                                    <a href="{{ url('courses/' . $course->slug) }}" 
                                       class="inline-flex items-center justify-center bg-gradient-to-r from-orange to-red-500 hover:from-red-500 hover:to-orange rounded-full px-6 py-3 font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Start Course
                                    </a>
                                @else
                                    @php
                                        $existingEnrollment = \App\Models\CourseEnrollment::where('course_id', $course->id)
                                            ->where('user_id', auth()->id())
                                            ->first();
                                    @endphp
                                    
                                    @if(!$existingEnrollment)
                                        <a href="{{ route('courses.enroll', $course->slug) }}" 
                                           class="inline-flex items-center justify-center bg-gradient-to-r from-lime to-green-500 hover:from-green-500 hover:to-lime rounded-full px-6 py-3 font-semibold text-primary transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                                            </svg>
                                            Enroll Now
                                        </a>
                                    @elseif($existingEnrollment->status === 'pending')
                                        <button disabled 
                                                class="inline-flex items-center justify-center bg-yellow-500 rounded-full px-6 py-3 font-semibold text-black opacity-80 cursor-not-allowed">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                                            </svg>
                                            Enrollment Pending
                                        </button>
                                    @elseif($existingEnrollment->status === 'rejected')
                                        <div class="text-center">
                                            <button disabled 
                                                    class="inline-flex items-center justify-center bg-red-500 rounded-full px-6 py-3 font-semibold text-white opacity-80 cursor-not-allowed mb-2">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                                                </svg>
                                                Enrollment Rejected
                                            </button>
                                            @if($existingEnrollment->rejection_reason)
                                                <p class="text-red-400 text-sm">Reason: {{ $existingEnrollment->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            @elseif(auth()->user()->user_role === 'instructor')
                                <a href="{{ url('instructor/courses/' . $course->id) }}" 
                                   class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-purple-600 hover:from-purple-600 hover:to-blue-500 rounded-full px-6 py-3 font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.22,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.22,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.68 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z"/>
                                    </svg>
                                    Manage Course
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center justify-center bg-gradient-to-r from-orange to-red-500 hover:from-red-500 hover:to-orange rounded-full px-6 py-3 font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10,17V14H3V10H10V7L15,12L10,17M10,2H19A2,2 0 0,1 21,4V20A2,2 0 0,1 19,22H10A2,2 0 0,1 8,20V18H10V20H19V4H10V6H8V4A2,2 0 0,1 10,2Z"/>
                                    </svg>
                                    Login to Access
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center justify-center bg-gradient-to-r from-orange to-red-500 hover:from-red-500 hover:to-orange rounded-full px-6 py-3 font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10,17V14H3V10H10V7L15,12L10,17M10,2H19A2,2 0 0,1 21,4V20A2,2 0 0,1 19,22H10A2,2 0 0,1 8,20V18H10V20H19V4H10V6H8V4A2,2 0 0,1 10,2Z"/>
                                </svg>
                                Login to Access
                            </a>
                        @endauth
                        
                        <button type="button" 
                                data-bs-toggle="modal" 
                                data-bs-target="#coursePreviewModal"
                                class="inline-flex items-center justify-center bg-transparent border-2 border-white/30 hover:border-white/60 rounded-full px-6 py-3 font-semibold text-white transition-all duration-300 hover:bg-white/10">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8,5.14V19.14L19,12.14L8,5.14Z"/>
                            </svg>
                            Preview
                        </button>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-black/40 backdrop-blur-sm rounded-xl p-6 border border-[#fff]/10 sticky top-8">
                        <!-- Course Thumbnail/Video -->
                        <div class="gradient-border mb-6">
                            <div class="gradient-border-content p-0 relative">
                                @if($promo_video_link != '')
                                    <iframe class="w-full aspect-video rounded-[calc(0.75rem-2px)]" 
                                            src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}">
                                    </iframe>
                                @else
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                                         alt="{{ $course->title }}" 
                                         class="w-full aspect-video object-cover rounded-[calc(0.75rem-2px)]">
                                @endif
                            </div>
                        </div>
                        
                        <!-- Pricing -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                @if($course->offer_price)
                                    <div class="text-3xl font-bold text-orange">৳{{ number_format($course->offer_price) }}</div>
                                    <div class="text-sm text-secondary-200 line-through">৳{{ number_format($course->price) }}</div>
                                @elseif(!$course->offer_price && $course->price)
                                    <div class="text-3xl font-bold text-orange">৳{{ number_format($course->price) }}</div>
                                @else
                                    <div class="text-3xl font-bold text-lime">Free</div>
                                @endif
                            </div>
                            
                            <button type="button" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#exampleModal2"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-white transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18,16.08C17.24,16.08 16.56,16.38 16.04,16.85L8.91,12.7C8.96,12.47 9,12.24 9,12C9,11.76 8.96,11.53 8.91,11.3L15.96,7.19C16.5,7.69 17.21,8 18,8A3,3 0 0,0 21,5A3,3 0 0,0 18,2A3,3 0 0,0 15,5C15,5.24 15.04,5.47 15.09,5.7L8.04,9.81C7.5,9.31 6.79,9 6,9A3,3 0 0,0 3,12A3,3 0 0,0 6,15C6.79,15 7.5,14.69 8.04,14.19L15.16,18.34C15.11,18.55 15.08,18.77 15.08,19C15.08,20.61 16.39,21.91 18,21.91C19.61,21.91 20.92,20.61 20.92,19A2.92,2.92 0 0,0 18,16.08Z"/>
                                </svg>
                                Share
                            </button>
                        </div>
                        
                        <!-- Course Description -->
                        @if($course->short_description)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-white mb-3">Course Description</h3>
                                <div class="text-secondary-200 text-sm leading-relaxed">
                                    {!! $course->short_description !!}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Course Details -->
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-white mb-4">Course Summary</h3>
                            
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-4h2v4h12v-4h2v4c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2zM18 8h-2V6H8v2H6V6c0-1.1.9-2 2-2h8c1.1 0 2 .9 2 2v2z"/>
                                    </svg>
                                </div>
                                <span class="text-white">{{ $courseEnrolledNumber ?? 0 }} Students Enrolled</span>
                            </div>
                            
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                                    </svg>
                                </div>
                                <span class="text-white">
                                    @if($hours > 0) {{ $hours }} Hour{{ $hours > 1 ? 's' : '' }} @endif
                                    {{ $minutes }} Minute{{ $minutes > 1 ? 's' : '' }} Total Duration
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3,5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5M7.5,15V9H9V15H7.5M11,15V9H12.5V15H11M14.5,15V9H16V15H14.5Z"/>
                                    </svg>
                                </div>
                                <span class="text-white">{{ $lessonsCount }} Lesson{{ $lessonsCount != 1 ? 's' : '' }} in {{ $modulesCount }} Module{{ $modulesCount != 1 ? 's' : '' }}</span>
                            </div>
                            
                            @if($course->language)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 rounded-full bg-yellow-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.9,17.39C17.64,16.59 16.89,16 16,16H15V13A1,1 0 0,0 14,12H8V10H10A1,1 0 0,0 11,9V7H13A2,2 0 0,0 15,5V4.59C17.93,5.77 20,8.64 20,12C20,14.08 19.2,15.97 17.9,17.39M11,19.93C7.05,19.44 4,16.08 4,12C4,11.38 4.08,10.78 4.21,10.21L9,15V16A2,2 0 0,0 11,18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white">Language: {{ $course->language }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-3 text-sm">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6Z"/>
                                    </svg>
                                </div>
                                <span class="text-white">Full Lifetime Access</span>
                            </div>
                            
                            @if($course->hascertificate)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 rounded-full bg-orange/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-orange" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,2L13.09,8.26L22,9L18.18,14.74L22.81,21L12,17.27L1.19,21L5.82,14.74L2,9L10.91,8.26L12,2Z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white">Certificate of Completion</span>
                                </div>
                            @endif
                            
                            @if($course->level)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 rounded-full bg-pink-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M5,4H19A2,2 0 0,1 21,6V18A2,2 0 0,1 19,20H5A2,2 0 0,1 3,18V6A2,2 0 0,1 5,4M5,8V12H11V8H5M13,8V12H19V8H13M5,14V18H11V14H5M13,14V18H19V14H13Z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white">Level: {{ ucfirst($course->level) }}</span>
                                </div>
                            @endif
                            
                            @if($course->updated_at)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 rounded-full bg-teal-500/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white">Updated: {{ \Carbon\Carbon::parse($course->updated_at)->format('M Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="w-full py-20 bg-gradient-to-b from-body to-black">
        <div class="container-x">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-12">
                    <!-- Instructor Section -->
                    @if($course->user)
                        <div class="bg-black/40 backdrop-blur-sm rounded-xl p-8 border border-[#fff]/10">
                            <div class="flex items-center gap-6 mb-6">
                                <div class="w-20 h-20 rounded-full bg-[#3C5D62] flex items-center justify-center">
                                    <svg class="w-8 h-8 text-orange" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                                    </svg>
                                </div>
                                <h2 class="font-bold text-2xl text-white">About the Instructor</h2>
                            </div>
                            
                            <p class="text-orange font-semibold text-lg mb-2">{{ strtoupper($course->user->name) }}</p>
                            <div class="text-secondary-200 leading-relaxed">
                                {!! $course->user->description !!}
                            </div>
                        </div>
                    @endif

                    <!-- What You'll Learn -->
                    <div class="bg-black/40 backdrop-blur-sm rounded-xl p-8 border border-[#fff]/10">
                        <div class="flex items-center gap-6 mb-6">
                            <div class="w-20 h-20 rounded-full bg-[#3C5D62] flex items-center justify-center">
                                <svg class="w-8 h-8 text-lime" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9M10,16V19.08L13.08,16H20V4H4V16H10Z"/>
                                </svg>
                            </div>
                            <h2 class="font-bold text-2xl text-white">What You'll Learn</h2>
                        </div>
                        
                        @php
                            $objectives = explode('[objective]', $course->objective);
                        @endphp
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($objectives as $object)
                                @if(trim($object) !== '')
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full bg-lime/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-lime" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                                            </svg>
                                        </div>
                                        <span class="text-secondary-200 text-sm leading-relaxed">{{ trim($object) }}</span>
                                    </div>
                                @else
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                            </svg>
                                        </div>
                                        <span class="text-red-400 text-sm">No Objective Found!</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="bg-black/40 backdrop-blur-sm rounded-xl p-8 border border-[#fff]/10">
                        <div class="flex items-center gap-6 mb-6">
                            <div class="w-20 h-20 rounded-full bg-[#3C5D62] flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,3H5C3.9,3 3,3.9 3,5V19C3,20.1 3.9,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.9 20.1,3 19,3M19,19H5V5H19V19M17,12H15V15H12V17H15C16.1,17 17,16.1 17,15V12M7,12V15C7,16.1 7.9,17 9,17H12V15H9V12H7M15,7H12V9H15V12H17V9C17,7.9 16.1,7 15,7M9,7C7.9,7 7,7.9 7,9V12H9V9H12V7H9Z"/>
                                </svg>
                            </div>
                            <h2 class="font-bold text-2xl text-white">Course Content</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($course->modules as $module)
                                <div class="bg-black/40 border border-[#fff]/10 rounded-lg overflow-hidden">
                                    <button type="button" 
                                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-all duration-200"
                                            onclick="toggleAccordion('module-{{ $module->id }}')">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-white text-base mb-2">
                                                {{ $module->title }}
                                                @if($module->checkNumber())
                                                    <span class="text-orange text-sm ml-2">- Module {{ $loop->iteration }}</span>
                                                @endif
                                            </h3>
                                            
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
                                            
                                            <div class="flex items-center gap-4 text-secondary-200 text-sm">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                                                    </svg>
                                                    <span>
                                                        @if($hours3 > 0) {{ $hours3 }}h @endif {{ $minutes3 }}m
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M3,5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5M7.5,15V9H9V15H7.5M11,15V9H12.5V15H11M14.5,15V9H16V15H14.5Z"/>
                                                    </svg>
                                                    <span>{{ $lessonCount }} Lesson{{ $lessonCount > 1 ? 's' : '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <svg class="w-5 h-5 text-white transform transition-transform duration-200 accordion-icon-{{ $module->id }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                                        </svg>
                                    </button>
                                    
                                    <div id="module-{{ $module->id }}" class="hidden accordion-content">
                                        <div class="px-6 pb-4">
                                            <div class="space-y-2">
                                                @foreach($module->lessons as $lesson)
                                                    @php
                                                        $totalDuration2 = 0;
                                                        if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                                                            $totalDuration2 += $lesson->duration;
                                                        }
                                                        $hours2 = floor($totalDuration2 / 3600);
                                                        $minutes2 = floor(($totalDuration2 % 3600) / 60);
                                                        
                                                        $isPublic = isset($lesson->is_public) && $lesson->is_public;
                                                        $publishAt = isset($lesson->publish_at) ? \Carbon\Carbon::parse($lesson->publish_at) : null;
                                                        $isFuture = $publishAt && $publishAt->isFuture();
                                                    @endphp
                                                    
                                                    <div class="flex items-center gap-3 py-3 px-4 rounded-lg bg-black/20 hover:bg-black/40 transition-all duration-200 {{ $isPublic ? 'cursor-pointer public-lesson-item' : '' }}"
                                                         @if($isPublic && $lesson->type == 'video') 
                                                            data-lesson-id="{{ $lesson->id }}" 
                                                            data-lesson-title="{{ $lesson->title }}"
                                                            data-video-type="{{ $lesson->video_type }}"
                                                            data-video-link="{{ $lesson->video_link }}"
                                                         @endif>
                                                        <div class="w-8 h-8 rounded-full bg-orange/20 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-4 h-4 text-orange" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8,5.14V19.14L19,12.14L8,5.14Z"/>
                                                            </svg>
                                                        </div>
                                                        
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <h4 class="text-white text-sm font-medium">{{ $lesson->title }}</h4>
                                                                @if($isPublic)
                                                                    <span class="bg-lime/20 text-lime text-xs px-2 py-1 rounded-full">Free</span>
                                                                @endif
                                                                @if($isFuture)
                                                                    <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full">Scheduled</span>
                                                                @endif
                                                            </div>
                                                            
                                                            @if($isFuture)
                                                                <p class="text-secondary-200 text-xs">Available {{ $publishAt->format('M d, Y') }}</p>
                                                            @elseif($lesson->type != 'text' && ($hours2 > 0 || $minutes2 > 0))
                                                                <p class="text-secondary-200 text-xs">
                                                                    @if($hours2 > 0) {{ $hours2 }}h @endif {{ $minutes2 < 1 ? 1 : $minutes2 }}m
                                                                </p>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(!$isPublic)
                                                            <div class="w-8 h-8 rounded-full bg-gray-500/20 flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Reviews Section -->
            @if (count($course_reviews) > 0)
                <div class="bg-card/50 backdrop-blur-sm rounded-xl p-6 lg:p-8 border border-[#fff]/10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange to-yellow-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Student Reviews</h2>
                        <span class="text-secondary-200">({{ count($course_reviews) }} Reviews)</span>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach ($course_reviews as $course_review)
                            <div class="bg-card rounded-[10px] p-6 shadow-2 anim hover:shadow-1">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex-shrink-0">
                                        @if ($course_review->user && $course_review->user->avatar)
                                            <img src="{{ asset($course_review->user->avatar) }}" alt="{{ $course_review->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue to-purple-600 flex items-center justify-center">
                                                <span class="text-white font-semibold text-lg">{{ $course_review->user ? strtoupper($course_review->user->name[0]) : 'U' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h5 class="text-white font-semibold">{{ $course_review->user ? $course_review->user->name : 'Unknown User' }}</h5>
                                        <p class="text-secondary-200 text-sm">{{ \Carbon\Carbon::parse($course_review->created_at)->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center gap-1">
                                        @for ($i = 0; $i < $course_review->star; $i++)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                            </svg>
                                        @endfor
                                        @for ($i = $course_review->star; $i < 5; $i++)
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                
                                <p class="text-secondary-100 leading-relaxed">{{ $course_review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Related Courses Section -->
            @if (count($related_course) > 0)
                <div class="bg-card/50 backdrop-blur-sm rounded-xl p-6 lg:p-8 border border-[#fff]/10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-lime to-green-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,3L1,9L5,11.18V17.18L12,21L19,17.18V11.18L23,9L12,3M5,13.18L8,11.45V15.18L12,17.45L16,15.18V11.45L19,13.18L12,16.45L5,13.18Z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Similar Courses</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($related_course as $r_course)
                            @php
                                $review_sum = 0;
                                $review_avg = 0;
                                $total = 0;
                                foreach ($r_course->reviews as $review) {
                                    $total++;
                                    $review_sum += $review->star;
                                }
                                if ($total > 0) {
                                    $review_avg = round($review_sum / $total, 1);
                                }
                            @endphp
                            
                            <div class="bg-card rounded-[10px] overflow-hidden shadow-2 group hover:shadow-1 anim">
                                <div class="relative overflow-hidden">
                                    <img src="{{ asset($r_course->thumbnail) }}" alt="{{ $r_course->title }}"
                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    
                                    @if ($r_course->price > 0)
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-orange px-3 py-1 rounded-full text-white text-sm font-semibold">
                                                ৳{{ $r_course->price }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-lime px-3 py-1 rounded-full text-primary text-sm font-semibold">
                                                Free
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="text-white font-semibold text-lg mb-2 line-clamp-2 group-hover:text-orange transition-colors">
                                        <a href="{{ url('courses/' . $r_course->slug) }}">{{ $r_course->title }}</a>
                                    </h3>
                                    
                                    <div class="flex items-center gap-4 text-sm text-secondary-200 mb-3">
                                        @if ($total > 0)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                                                </svg>
                                                <span>{{ $review_avg }}</span>
                                                <span>({{ $total }})</span>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M16,4H18V2H16V4M6,4H8V2H6V4M20,6H4A2,2 0 0,0 2,8V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8A2,2 0 0,0 20,6M20,18H4V10H20V18Z"/>
                                            </svg>
                                            <span>{{ $r_course->modules->count() }} Modules</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            @if ($r_course->user && $r_course->user->avatar)
                                                <img src="{{ asset($r_course->user->avatar) }}" alt="{{ $r_course->user->name }}"
                                                     class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue to-purple-600 flex items-center justify-center">
                                                    <span class="text-white text-sm font-semibold">{{ $r_course->user ? strtoupper($r_course->user->name[0]) : 'U' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-secondary-200 text-sm">{{ $r_course->user ? $r_course->user->name : 'Unknown' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-md w-full p-6 border border-[#fff]/10">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white">Share Course</h3>
            <button onclick="closeShareModal()" class="text-secondary-200 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="space-y-3">
            <div>
                <label class="block text-secondary-200 text-sm mb-2">Course URL</label>
                <div class="flex">
                    <input type="text" id="courseUrl" value="{{ url('courses/' . $course->slug) }}" 
                           class="flex-1 bg-[#091D3D] border border-[#fff]/20 rounded-l-lg px-4 py-2 text-white anim" readonly>
                    <button onclick="copyToClipboard()" 
                            class="bg-orange hover:bg-orange/80 px-4 py-2 rounded-r-lg text-white font-medium transition-colors">
                        Copy
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('courses/' . $course->slug)) }}" target="_blank"
                   class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-3 text-white font-medium transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('courses/' . $course->slug)) }}&text={{ urlencode($course->title) }}" target="_blank"
                   class="flex items-center justify-center gap-2 bg-sky-500 hover:bg-sky-600 rounded-lg px-4 py-3 text-white font-medium transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        // Share Modal Functions
        function openShareModal() {
            document.getElementById('shareModal').classList.remove('hidden');
            document.getElementById('shareModal').classList.add('flex');
        }

        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
            document.getElementById('shareModal').classList.remove('flex');
        }

        // Copy to clipboard function
        function copyToClipboard() {
            const urlInput = document.getElementById('courseUrl');
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            
            try {
                document.execCommand('copy');
                // Show success feedback
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-green-600');
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-600');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }

        // Accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            const accordionButtons = document.querySelectorAll('[data-accordion-target]');
            
            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-accordion-target');
                    const targetElement = document.querySelector(targetId);
                    const icon = this.querySelector('svg');
                    
                    if (targetElement.style.maxHeight) {
                        targetElement.style.maxHeight = null;
                        targetElement.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        targetElement.classList.remove('hidden');
                        targetElement.style.maxHeight = targetElement.scrollHeight + "px";
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Video modal and protection functionality
            $('.play-btn').on('click', function(e) {
                e.preventDefault();
                
                const videoUrl = $(this).data('video-url');
                const lessonTitle = $(this).data('title') || 'Course Preview';
                
                if (!videoUrl) {
                    return;
                }
                
                // Check if it's a valid YouTube or Vimeo URL
                const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
                const vimeoRegex = /(?:vimeo\.com\/)([0-9]+)/;
                
                let embedUrl = '';
                let videoId = '';
                
                const youtubeMatch = videoUrl.match(youtubeRegex);
                const vimeoMatch = videoUrl.match(vimeoRegex);
                
                if (youtubeMatch) {
                    videoId = youtubeMatch[1];
                    embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&modestbranding=1`;
                } else if (vimeoMatch) {
                    videoId = vimeoMatch[1];
                    embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1&title=0&byline=0&portrait=0`;
                }
                
                if (embedUrl) {
                    const modalHtml = `
                        <div class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4" id="videoModal">
                            <div class="relative w-full max-w-4xl bg-card rounded-xl overflow-hidden border border-[#fff]/10">
                                <div class="flex items-center justify-between p-4 border-b border-[#fff]/10">
                                    <h3 class="text-xl font-bold text-white">${lessonTitle}</h3>
                                    <button onclick="closeVideoModal()" class="text-secondary-200 hover:text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative aspect-video">
                                    <iframe src="${embedUrl}" 
                                            class="w-full h-full" 
                                            frameborder="0" 
                                            allow="autoplay; fullscreen; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('body').append(modalHtml);
                    addVideoProtectionToModal();
                } else {
                    // Show invalid video modal
                    const modalHtml = `
                        <div class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4" id="videoModal">
                            <div class="bg-card rounded-xl max-w-md w-full p-6 border border-[#fff]/10 text-center">
                                <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-white mb-2">Invalid Video URL</h4>
                                <p class="text-secondary-200 mb-4">Only YouTube and Vimeo videos are supported.</p>
                                <button onclick="closeVideoModal()" 
                                        class="bg-orange hover:bg-orange/80 px-6 py-2 rounded-lg text-white font-medium transition-colors">
                                    Close
                                </button>
                            </div>
                        </div>
                    `;
                    
                    $('body').append(modalHtml);
                }
            });

            // Close modal functions
            window.closeVideoModal = function() {
                $('#videoModal').remove();
            };

            // Close modal when clicking outside
            $(document).on('click', '#videoModal', function(e) {
                if (e.target === this) {
                    closeVideoModal();
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