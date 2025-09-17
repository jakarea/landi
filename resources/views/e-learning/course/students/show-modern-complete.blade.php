@extends('layouts/student-modern')
@section('title', $course->title ?? 'কোর্স শিক্ষা')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
    .video-player-container {
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        position: relative;
        overflow: hidden;
    }
    
    .lesson-item {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(148, 163, 184, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .lesson-item:hover {
        background: rgba(30, 41, 59, 0.8);
        border-color: rgba(99, 102, 241, 0.4);
        transform: translateX(4px);
    }
    
    .lesson-item.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        border-color: rgba(99, 102, 241, 0.6);
    }
    
    .lesson-item::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        transform: translateX(-100%) translateY(-100%);
        transition: transform 0.8s ease-in-out;
    }
    
    .lesson-item:hover::before {
        transform: translateX(200%) translateY(200%);
    }
    
    .module-header {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
    }
    
    .module-header:hover {
        border-color: rgba(99, 102, 241, 0.4);
    }
    
    .review-card {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }
    
    .review-card:hover {
        border-color: rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .rating-star {
        color: #fbbf24;
        transition: color 0.2s;
    }
    
    .rating-star:hover {
        color: #f59e0b;
    }
    
    .video_list_play .actv-show {
        display: none;
    }
    
    .video_list_play.active .actv-hide {
        display: none;
    }
    
    .video_list_play.active .actv-show {
        display: inline;
    }
    
    .accordion-collapse.show {
        display: block !important;
    }
    
    .accordion-collapse {
        display: none;
    }
</style>
@endpush

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
    <div class="bg-blue-900/50 border border-blue-600 text-blue-200 p-3 rounded-lg mb-4 text-sm">
        <strong>Debug Info:</strong> 
        Completed Lessons: {{ count($userCompletedLessons ?? []) }} | 
        Lesson IDs: {{ implode(',', array_keys($userCompletedLessons ?? [])) }}
    </div>
@endif

<div class="p-6 space-y-6">
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Main Content Area -->
        <div class="xl:col-span-3 space-y-6">
            
            <!-- Video Player Section -->
            @if ($isUserEnrolled)
                <div class="video-player-container rounded-2xl overflow-hidden" id="videoPlayerContainer">
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
                            <div class="youtube-player w-full" id="firstLesson"
                                data-video-url="{{ $embedUrl }}"
                                data-first-lesson-id="{{ $firstLesson->id }}"
                                data-first-course-id="{{ $firstLesson->course_id }}"
                                data-first-modules-id="{{ $firstLesson->module_id }}"
                                data-video-type="youtube">
                                <iframe class="w-full aspect-video" src="{{ $embedUrl }}" frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                            </div>
                        @elseif ($isVimeo && !empty($embedUrl))
                            <div class="vimeo-player w-full" id="firstLesson"
                                data-vimeo-url="{{ $embedUrl }}"
                                data-first-lesson-id="{{ $firstLesson->id }}"
                                data-first-course-id="{{ $firstLesson->course_id }}"
                                data-first-modules-id="{{ $firstLesson->module_id }}"
                                data-video-type="vimeo">
                                <iframe class="w-full aspect-video" src="{{ $embedUrl }}" frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @elseif (!empty($videoLink))
                            <div class="generic-video-player w-full" id="firstLesson"
                                data-first-lesson-id="{{ $firstLesson->id }}"
                                data-first-course-id="{{ $firstLesson->course_id }}"
                                data-first-modules-id="{{ $firstLesson->module_id }}"
                                data-video-type="generic">
                                <video class="w-full aspect-video" controls>
                                    <source src="{{ $videoLink }}" type="video/mp4">
                                    আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                                </video>
                            </div>
                        @else
                            <div class="w-full aspect-video bg-gray-800 flex items-center justify-center border-2 border-dashed border-gray-600">
                                <div class="text-center">
                                    <i class="fas fa-play-circle text-4xl text-gray-500 mb-3"></i>
                                    <p class="text-gray-400">প্রথম লেসনে কোনো ভিডিও নেই</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-full aspect-video bg-gray-800 flex items-center justify-center border-2 border-dashed border-gray-600">
                            <div class="text-center">
                                <i class="fas fa-book-open text-4xl text-gray-500 mb-3"></i>
                                <p class="text-gray-400">এই কোর্সে কোনো লেসন পাওয়া যায়নি</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Dynamic Video Players (Hidden) -->
                <div class="youtube-player w-full" style="display: none;">
                    <iframe class="w-full aspect-video" src="" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
                </div>
                
                <div class="vimeo-player w-full" style="display: none;">
                    <iframe class="w-full aspect-video" src="" frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </div>
                
                <div class="generic-video-player w-full" style="display: none;">
                    <video class="w-full aspect-video" controls>
                        <source src="" type="video/mp4">
                        আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                    </video>
                </div>

                <!-- Audio Player -->
                <div class="audio-iframe-box d-none glass-effect rounded-2xl p-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-headphones text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <audio id="audioPlayer" controls class="w-full">
                                <source src="" type="audio/mpeg">
                                আপনার ব্রাউজার এই অডিও ফরম্যাট সাপোর্ট করে না।
                            </audio>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Course Title and Actions -->
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-white mb-3">{{ $course->title }}</h1>
                        <div class="flex items-center space-x-4 text-gray-400">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span>{{ $course->user->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                <span>{{ $totalModules }} মডিউল</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-play-circle mr-2"></i>
                                <span>{{ $totalLessons }} লেসন</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <!-- Like Button -->
                        <button class="p-3 rounded-lg transition-all duration-300 {{ $liked === 'liked' ? 'bg-red-600 text-white' : 'bg-gray-700 text-gray-400 hover:text-red-400' }}" 
                                id="likeBttn">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
                        
                        <!-- Mark as Complete Button -->
                        @if($isUserEnrolled)
                            <button class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-300 ray-hover btn btn-success btn-sm" 
                                    id="markCompleteBtn" 
                                    data-course="{{ $course->id }}"
                                    data-module=""
                                    data-lesson=""
                                    data-duration="0"
                                    disabled>
                                <i class="fas fa-check-circle mr-2"></i>
                                সম্পন্ন
                            </button>
                        @else
                            <button class="px-4 py-3 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed" disabled>
                                <i class="fas fa-lock mr-2"></i>
                                ভর্তি হননি
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Lesson Content Area -->
            <div class="glass-effect rounded-2xl p-6" id="textHideShow" style="display: none;">
                <div id="dataTextContainer" class="prose prose-invert max-w-none"></div>
                <hr id="textHideShowSeparator" style="display: none;" class="border-gray-600 my-6">
            </div>

            <!-- Course Description -->
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center" id="aboutCourse">
                    <i class="fas fa-info-circle mr-3 text-purple-400"></i>
                    কোর্স সম্পর্কে
                </h2>
                <div class="text-gray-300 leading-relaxed" id="lessonShortDesc">
                    {!! $course->description !!}
                </div>
            </div>

            <!-- Course Reviews -->
            @if ($course->allow_review)
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-star mr-3 text-yellow-400"></i>
                        রিভিউ ({{ count($course_reviews) }})
                    </h2>

                    <!-- Review Form -->
                    <div class="review-card rounded-xl p-4 mb-6">
                        <div class="flex space-x-4">
                            @if (auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                                    <span class="text-white font-semibold">{{ strtoupper(auth()->user()->name[0]) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <form action="{{ route('student.courses.review', $course->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="text" name="comment" id="review" 
                                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-purple-500 focus:outline-none"
                                               placeholder="আপনার রিভিউ লিখুন...">
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-1" id="full-stars">
                                            <div class="rating-group">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <input type="radio" name="star" value="{{ $i }}" id="rating-{{ $i }}" class="rating__input hidden" {{ $i == 3 ? 'checked' : '' }}>
                                                    <label for="rating-{{ $i }}" class="rating__label cursor-pointer text-2xl text-gray-500 hover:text-yellow-400 rating-star">
                                                        <i class="fas fa-star rating__icon rating__icon--star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <button type="submit" 
                                                class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 btn common-bttn">
                                            রিভিউ জমা দিন
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @forelse ($course_reviews as $review)
                            <div class="review-card rounded-xl p-4">
                                <div class="flex space-x-4">
                                    @if ($review->user && $review->user->avatar)
                                        <img src="{{ asset($review->user->avatar) }}" alt="{{ $review->user->name }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold">{{ strtoupper($review->user->name[0]) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-white">{{ $review->user->name }}</h4>
                                            <div class="flex space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-sm {{ $i <= $review->star ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-300">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-comments text-3xl mb-3"></i>
                                <p>এখনো কোনো রিভিউ নেই।</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="xl:col-span-1 space-y-6">
            
            <!-- Course Modules -->
            <div class="glass-effect rounded-2xl overflow-hidden course-modules-lessons-redesign">
                <div class="module-header p-4 border-b border-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-2 text-purple-400"></i>
                        মডিউল তালিকা
                    </h3>
                    <p class="text-sm text-gray-400 mt-1">{{ $totalModules }} মডিউল • {{ $totalLessons }} লেসন</p>
                </div>
                
                <div class="accordion" id="accordionExample">
                    @foreach ($course->modules as $module)
                        @if ($module->status == 'published' && count($module->lessons) > 0)
                            <div class="accordion-item border-b border-gray-700 last:border-b-0">
                                <!-- Module Header -->
                                <div class="accordion-header" id="heading_{{ $module->id }}">
                                    <button class="accordion-button w-full p-4 text-left hover:bg-gray-700/30 transition-colors collapsed" 
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $module->id }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $module->id }}">
                                        <div class="flex items-center justify-between w-full">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-check-circle {{ $module->isComplete() ? 'text-primary' : 'text-gray-500' }}"></i>
                                                <span class="font-medium text-white module-title">{{ $module->title }}
                                                    {{ $module->checkNumber() ? $loop->iteration : '' }}
                                                </span>
                                            </div>
                                            <i class="fas fa-chevron-down text-gray-400 transform transition-transform"></i>
                                        </div>
                                    </button>
                                </div>
                                
                                <!-- Module Lessons -->
                                <div class="accordion-collapse collapse {{ $currentLesson && $currentLesson->module_id == $module->id ? 'show' : '' }}" 
                                     id="collapse_{{ $module->id }}"
                                     aria-labelledby="heading_{{ $module->id }}"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body p-0">
                                        <ul class="lesson-wrap space-y-0">
                                            @foreach ($module->lessons as $lesson)
                                                @if ($lesson->status == 'published')
                                                    <li class="lesson-item border-t border-gray-700 {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}">
                                                        @if (!$isUserEnrolled)
                                                            <a href="{{ url('student/checkout/' . $course->slug) }}" 
                                                               class="video_list_play flex items-center space-x-3 p-3 text-gray-400 hover:text-white transition-colors">
                                                                <i class="fas fa-lock text-sm"></i>
                                                                <span class="text-sm">{{ $lesson->title }}</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ $lesson->video_link }}" 
                                                               class="video_list_play flex items-center space-x-3 p-3 text-gray-300 hover:text-white transition-colors {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active text-white' : '' }} d-inline-block"
                                                               data-video-id="{{ $lesson->id }}"
                                                               data-lesson-id="{{ $lesson->id }}"
                                                               data-course-id="{{ $course->id }}"
                                                               data-modules-id="{{ $module->id }}"
                                                               data-video-url="{{ $lesson->video_link ?? '' }}"
                                                               data-audio-url="{{ $lesson->audio }}"
                                                               data-lesson-type="{{ $lesson->type }}"
                                                               data-lesson-duration="{{ $lesson->duration ?? 0 }}"
                                                               data-instructor-id="{{ $course->user_id }}">
                                                                
                                                                <!-- Completion Status -->
                                                                <span class="mt-2 ms-1" style="cursor:pointer;">
                                                                    @if (isset($userCompletedLessons[$lesson->id]))
                                                                        <i class="fas fa-check-circle text-primary text-sm"
                                                                           title="Completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                    @else
                                                                        <i class="fas fa-check-circle text-gray-500 text-sm is_complete_lesson cursor-pointer hover:text-green-400"
                                                                           data-course="{{ $course->id }}"
                                                                           data-module="{{ $module->id }}"
                                                                           data-lesson="{{ $lesson->id }}"
                                                                           data-duration="{{ $lesson->duration ?? 0 }}"
                                                                           data-user="{{ Auth::user()->id }}"
                                                                           title="Not completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                    @endif
                                                                </span>

                                                                <!-- Lesson Type Icon -->
                                                                <div class="flex-shrink-0">
                                                                    @if ($lesson->type == 'text')
                                                                        <i class="fa-regular fa-file-lines actv-hide text-sm text-blue-400" style="color:#2F3A4C"></i>
                                                                        <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                    @elseif($lesson->type == 'audio')
                                                                        <i class="fa-solid fa-headphones actv-hide text-sm text-green-400" style="color:#2F3A4C"></i>
                                                                        <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                    @elseif($lesson->type == 'video')
                                                                        <img src="{{ asset('assets/images/icons/play-icon.svg') }}" alt="i" class="img-fluid actv-hide" style="width:0.8rem;">
                                                                        <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                    @endif
                                                                </div>
                                                                
                                                                <!-- Lesson Title -->
                                                                <span class="flex-1 text-sm">{{ $lesson->title }}</span>
                                                                
                                                                <!-- Duration -->
                                                                @if($lesson->duration)
                                                                    <span class="text-xs text-gray-500">{{ $lesson->duration }}min</span>
                                                                @endif
                                                            </a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Related Courses -->
            @if(count($relatedCourses) > 0)
                <div class="glass-effect rounded-2xl p-4 related-course-box">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-graduation-cap mr-2 text-purple-400"></i>
                        সংশ্লিষ্ট কোর্স
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($relatedCourses->take(3) as $relatedCourse)
                            <div class="review-card rounded-lg p-3 course-single-item">
                                <div class="flex space-x-3">
                                    <div class="course-thumb-box">
                                        @if ($relatedCourse->thumbnail)
                                            <img src="{{ asset($relatedCourse->thumbnail) }}" alt="Course Thumbnail" 
                                                 class="w-16 h-12 rounded-lg object-cover img-fluid">
                                        @else
                                            <img src="{{ asset('assets/images/courses/thumbnail.png') }}" alt="Course Thumbnail" 
                                                 class="w-16 h-12 rounded-lg object-cover img-fluid">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 course-txt-box">
                                        @if (isset($userEnrolledCourses[$relatedCourse->id]))
                                            <a href="{{ url('student/courses/my-courses/details/' . $relatedCourse->slug) }}" 
                                               class="text-sm font-medium text-white hover:text-purple-400 transition-colors line-clamp-2">
                                                {{ Str::limit($relatedCourse->title, 45) }}
                                            </a>
                                        @else
                                            <a href="{{ url('student/courses/overview/' . $relatedCourse->slug) }}" 
                                               class="text-sm font-medium text-white hover:text-purple-400 transition-colors line-clamp-2">
                                                {{ Str::limit($relatedCourse->title, 50) }}
                                            </a>
                                        @endif
                                        <p class="text-xs text-gray-400 mt-1">{{ $relatedCourse->user->name }}</p>
                                        
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
                                        
                                        <ul class="flex items-center mt-1">
                                            <li><span class="text-xs text-yellow-400 mr-1">{{ number_format($review_avg, 1) }}</span></li>
                                            @for($i = 1; $i <= 5; $i++)
                                                <li><i class="fas fa-star text-xs {{ $i <= $review_avg ? 'text-yellow-400' : 'text-gray-600' }}"></i></li>
                                            @endfor
                                            <li><span class="text-xs text-gray-500 ml-1">({{ $total }})</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
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
                lessonId: {{ $currentLesson->id }},
                moduleId: {{ $currentLesson->module_id }},
                type: '{{ $currentLesson->type }}'
            });

            // Set the current lesson as active in sidebar
            $('a[data-lesson-id="{{ $currentLesson->id }}"]').addClass('active');
            $('a[data-lesson-id="{{ $currentLesson->id }}"] .actv-hide').hide();
            $('a[data-lesson-id="{{ $currentLesson->id }}"] .actv-show').show();

            @if($currentModule)
                // Open the accordion for current module
                $('#collapse_{{ $currentModule->id }}').addClass('show');
            @endif

            // Initialize the Mark as Complete button for current lesson
            updateMarkAsCompleteButton({{ $currentLesson->id }}, {{ $currentLesson->module_id }}, {{ $course->user_id }}, {{ $currentLesson->duration ?? 0 }});

            // Load the current lesson content
            @if($currentLesson->type == 'video' && $currentLesson->video_link)
                loadVideo('{{ $currentLesson->video_link }}', {{ $currentLesson->id }});
            @elseif($currentLesson->type == 'audio' && $currentLesson->audio)
                // Load audio
                document.querySelector('.audio-iframe-box').classList.remove('d-none');
                document.querySelector('#videoPlayerContainer').style.display = 'none';
                $('#textHideShow').hide();
                var audioSource = audioPlayer.querySelector('source');
                audioSource.src = baseUrl + '/{{ $currentLesson->audio }}';
                audioPlayer.load();
            @elseif($currentLesson->type == 'text')
                // Load text content
                $('#textHideShow').show();
                $('#textHideShowSeparator').show();
                document.querySelector('.audio-iframe-box').classList.add('d-none');
                document.querySelector('#videoPlayerContainer').style.display = 'none';
                // Load text content here if needed
            @endif
        @endif

        // Lesson click handler
        $('a.video_list_play').click(function(e) {
            e.preventDefault();
            
            // Remove alert for production

            // Reset all lesson icons - show play icons, hide pause icons
            $('a.video_list_play').removeClass('active');
            $('a.video_list_play .actv-hide').show(); // Show play icons
            $('a.video_list_play .actv-show').hide(); // Hide pause icons
            
            // Set current lesson as active and show pause icon
            $(this).addClass('active');
            $(this).find('.actv-hide').hide(); // Hide play icon
            $(this).find('.actv-show').show(); // Show pause icon

            let type = this.getAttribute('data-lesson-type');
            let lessonId = this.getAttribute('data-lesson-id');
            let courseId = this.getAttribute('data-course-id');
            let moduleId = this.getAttribute('data-modules-id');
            let lessonDuration = this.getAttribute('data-lesson-duration') || 0;
            let instructorId = this.getAttribute('data-instructor-id');

                type: type,
                lessonId: lessonId,
                courseId: courseId,
                moduleId: moduleId,
                lessonDuration: lessonDuration,
                instructorId: instructorId
            });

            if (type == 'video') {
                document.querySelector('#videoPlayerContainer').style.display = 'block';
                document.querySelector('.audio-iframe-box').classList.add('d-none');
                $('#textHideShow').hide();
                $('#textHideShowSeparator').hide();
                if (audioPlayer) audioPlayer.pause();

                const videoUrl = this.getAttribute('data-video-url');
                if (videoUrl) {
                    loadVideo(videoUrl, lessonId);
                }

            } else if (type == 'audio') {
                if (audioPlayer) audioPlayer.pause();
                document.querySelector('.audio-iframe-box').classList.remove('d-none');
                $('#textHideShow').hide();
                $('#textHideShowSeparator').hide();
                document.querySelector('#videoPlayerContainer').style.display = 'none';

                var laravelURL = baseUrl + '/' + this.getAttribute('data-audio-url');
                if (audioPlayer) {
                    let audioSource = audioPlayer.querySelector('source');
                    audioSource.src = laravelURL;
                    audioPlayer.load();
                    audioPlayer.play();
                }

            } else if (type == 'text') {
                if (audioPlayer) audioPlayer.pause();
                
                $('#textHideShow').show();
                $('#textHideShowSeparator').show();
                document.querySelector('.audio-iframe-box').classList.add('d-none');
                document.querySelector('#videoPlayerContainer').style.display = 'none';
            }

            // Update Mark as Complete button for the selected lesson
            updateMarkAsCompleteButton(lessonId, moduleId, instructorId, lessonDuration);

            // Send request per lesson click
            var data = {
                courseId: courseId,
                lessonId: lessonId,
                moduleId: moduleId
            };
            
            
            // ONLY Log course progress (similar to instructor) - DO NOT mark as complete
            $.ajax({
                url: '{{ route('student.log.courses') }}',
                method: 'GET',
                data: data,
                success: function(response) {
                        course_id: courseId,
                        lesson_id: lessonId,
                        module_id: moduleId,
                        user_id: '{{ Auth::user()->id }}'
                    });
                },
                error: function(xhr, status, error) {
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
                        class="w-full aspect-video" 
                        frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" 
                        allowfullscreen
                        style="pointer-events: auto;"
                        oncontextmenu="return false;"
                        controlslist="nodownload nofullscreen noremoteplayback"
                        disablepictureinpicture>
                    </iframe>
                `;
            } else {
            }
        }

        // Function to update the Mark as Complete button based on selected lesson
        function updateMarkAsCompleteButton(lessonId, moduleId, instructorId, duration) {
            
            var $button = $('#markCompleteBtn');
            
            // Check if lesson is already completed by checking the PHP-generated completed lessons array
            var completedLessons = @json(array_keys($userCompletedLessons ?? []));
            var isCompleted = completedLessons.includes(parseInt(lessonId));
            
                lessonId: lessonId,
                completedLessons: completedLessons,
                isCompleted: isCompleted
            });
            
            if (isCompleted) {
                // Lesson is already completed - show Completed and disable
                $button.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-gray-600');
                $button.html('<i class="fas fa-check-circle mr-2"></i>সম্পন্ন');
                $button.prop('disabled', true);
            } else {
                // Lesson not completed yet
                $button.removeClass('bg-gray-600').addClass('bg-green-600 hover:bg-green-700');
                $button.html('<i class="fas fa-check-circle mr-2"></i>সম্পন্ন করুন');
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

        // Handle main "Mark as Complete" button click (beside heart icon)
        $(document).on('click', '#markCompleteBtn', function(e) {
            e.preventDefault();
            
            
            // Check if lesson is already completed - if so, don't proceed
            if ($(this).hasClass('bg-gray-600') && $(this).text().includes('সম্পন্ন')) {
                return false;
            }
            
            var lessonId = $(this).data('lesson');
            var courseId = $(this).data('course');
            var moduleId = $(this).data('module');
            var duration = $(this).data('duration') || 0;
            
            var data = {
                courseId: courseId,
                lessonId: lessonId,
                moduleId: moduleId,
                instructorId: {{ $course->user_id }},
                duration: duration,
                is_completed: true
            };

            var $element = $(this);
            

            $.ajax({
                url: '{{ route('student.complete.lesson') }}',
                method: 'GET',
                data: data,
                beforeSend: function() {
                    $element.html('<i class="fas fa-spinner fa-spin mr-2"></i>প্রক্রিয়াকরণ...');
                    $element.prop('disabled', true);
                },
                success: function(response) {
                        course_id: courseId,
                        instructor_id: {{ $course->user_id }},
                        module_id: moduleId,
                        lesson_id: lessonId,
                        user_id: '{{ Auth::user()->id }}',
                        is_completed: true,
                        duration: duration
                    });
                    
                    // Change button to completed state
                    $element.html('<i class="fas fa-check-circle mr-2"></i>সম্পন্ন');
                    $element.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-gray-600');
                    $element.prop('disabled', true);
                    
                    // Update the lesson completion icon in the sidebar
                    var $lessonIcon = $('a[data-lesson-id="' + lessonId + '"] .is_complete_lesson');
                    if ($lessonIcon.length) {
                        $lessonIcon.addClass('text-primary');
                        $lessonIcon.removeClass('is_complete_lesson');
                    }
                    
                    // Update the module icon if all lessons in module are completed
                    updateModuleCompletionIcon(moduleId);
                    
                },
                error: function(xhr, status, error) {
                    
                    // Reset button on error
                    $element.html('<i class="fas fa-check-circle mr-2"></i>সম্পন্ন করুন');
                    $element.removeClass('bg-gray-600').addClass('bg-green-600 hover:bg-green-700');
                    $element.prop('disabled', false);
                }
            });
        });

        // Handle manual lesson completion clicks
        $(document).on('click', '.is_complete_lesson', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent lesson click event
            
            var lessonId = $(this).data('lesson');
            var courseId = $(this).data('course');
            var moduleId = $(this).data('module');
            var duration = $(this).data('duration') || 0;
            var userId = $(this).data('user');
            
            var data = {
                courseId: courseId,
                lessonId: lessonId,
                moduleId: moduleId,
                instructorId: {{ $course->user_id }},
                duration: duration,
                is_completed: true
            };

            var $element = $(this);
            

            $.ajax({
                url: '{{ route('student.complete.lesson') }}',
                method: 'GET',
                data: data,
                beforeSend: function() {
                    // Change class to spinner
                    $element.removeClass('fas fa-check-circle').addClass('fas fa-spinner fa-spin');
                },
                success: function(response) {
                        course_id: courseId,
                        instructor_id: {{ $course->user_id }},
                        module_id: moduleId,
                        lesson_id: lessonId,
                        user_id: userId,
                        is_completed: true,
                        duration: duration
                    });
                    
                    // Change icon to success checkmark
                    $element.removeClass('fas fa-spinner fa-spin').addClass('fas fa-check-circle text-primary');
                    $element.removeClass('is_complete_lesson'); // Remove click handler
                    
                    // Update the module icon if all lessons in module are completed
                    updateModuleCompletionIcon(moduleId);
                    
                },
                error: function(xhr, status, error) {
                    // Reset on error
                    $element.removeClass('fas fa-spinner fa-spin').addClass('fas fa-check-circle');
                }
            });
        });

        // Function to update module completion icon when all lessons are completed
        function updateModuleCompletionIcon(moduleId) {
            
            var $moduleHeader = $('#heading_' + moduleId + ' .fas.fa-check-circle');
            var $allLessonsInModule = $('a[data-modules-id="' + moduleId + '"] .fas.fa-check-circle');
            var totalLessons = $allLessonsInModule.length;
            var completedLessons = $allLessonsInModule.filter('.text-primary').length;
            
                moduleId: moduleId,
                totalLessons: totalLessons,
                completedLessons: completedLessons
            });
            
            if (totalLessons > 0 && completedLessons === totalLessons) {
                // All lessons completed - make module icon primary color
                $moduleHeader.addClass('text-primary');
            } else {
                // Not all lessons completed - remove primary color
                $moduleHeader.removeClass('text-primary');
            }
        }

        // Initialize module completion status on page load
        @foreach($course->modules as $module)
            @if($module->status == 'published' && count($module->lessons) > 0)
                updateModuleCompletionIcon({{ $module->id }});
            @endif
        @endforeach
    });
</script>

{{-- vimeo player ready --}}
<script>
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
</script>

{{-- like bttn --}}
<script>
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
                    // console.error(error);
                    likeBttn.classList.remove('active');
                });
        });
    }
</script>
@endpush
@endsection