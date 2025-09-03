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
                <div class="youtube-player w-full hidden">
                    <iframe class="w-full aspect-video" src="" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
                </div>
                
                <div class="vimeo-player w-full hidden">
                    <iframe class="w-full aspect-video" src="" frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </div>
                
                <div class="generic-video-player w-full hidden">
                    <video class="w-full aspect-video" controls>
                        <source src="" type="video/mp4">
                        আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                    </video>
                </div>

                <!-- Audio Player -->
                <div class="audio-iframe-box hidden glass-effect rounded-2xl p-6">
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
                            <button class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-300 ray-hover" 
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
            </div>

            <!-- Course Description -->
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
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
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="star" value="{{ $i }}" id="star{{ $i }}" class="hidden" {{ $i == 3 ? 'checked' : '' }}>
                                                <label for="star{{ $i }}" class="cursor-pointer text-2xl text-gray-500 hover:text-yellow-400 rating-star">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        
                                        <button type="submit" 
                                                class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300">
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
            <div class="glass-effect rounded-2xl overflow-hidden">
                <div class="module-header p-4 border-b border-gray-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-2 text-purple-400"></i>
                        মডিউল তালিকা
                    </h3>
                    <p class="text-sm text-gray-400 mt-1">{{ $totalModules }} মডিউল • {{ $totalLessons }} লেসন</p>
                </div>
                
                <div class="max-h-96 overflow-y-auto">
                    @foreach ($course->modules as $module)
                        @if ($module->status == 'published' && count($module->lessons) > 0)
                            <div class="border-b border-gray-700 last:border-b-0">
                                <!-- Module Header -->
                                <button class="w-full p-4 text-left hover:bg-gray-700/30 transition-colors" 
                                        onclick="toggleModule('module-{{ $module->id }}')">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-check-circle {{ $module->isComplete() ? 'text-green-400' : 'text-gray-500' }}"></i>
                                            <span class="font-medium text-white">{{ $module->title }}</span>
                                        </div>
                                        <i class="fas fa-chevron-down text-gray-400 transform transition-transform" 
                                           id="icon-module-{{ $module->id }}"></i>
                                    </div>
                                </button>
                                
                                <!-- Module Lessons -->
                                <div class="lessons-container {{ $currentLesson && $currentLesson->module_id == $module->id ? '' : 'hidden' }}" 
                                     id="module-{{ $module->id }}">
                                    @foreach ($module->lessons as $lesson)
                                        @if ($lesson->status == 'published')
                                            <div class="lesson-item border-t border-gray-700 {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}">
                                                @if (!$isUserEnrolled)
                                                    <a href="{{ url('student/checkout/' . $course->slug) }}" 
                                                       class="flex items-center space-x-3 p-3 text-gray-400 hover:text-white transition-colors">
                                                        <i class="fas fa-lock text-sm"></i>
                                                        <span class="text-sm">{{ $lesson->title }}</span>
                                                    </a>
                                                @else
                                                    <a href="{{ $lesson->video_link }}" 
                                                       class="video_list_play flex items-center space-x-3 p-3 text-gray-300 hover:text-white transition-colors {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active text-white' : '' }}"
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
                                                        @if (isset($userCompletedLessons[$lesson->id]))
                                                            <i class="fas fa-check-circle text-green-400 text-sm"></i>
                                                        @else
                                                            <i class="fas fa-check-circle text-gray-500 text-sm is_complete_lesson cursor-pointer hover:text-green-400"
                                                               data-course="{{ $course->id }}"
                                                               data-module="{{ $module->id }}"
                                                               data-lesson="{{ $lesson->id }}"
                                                               data-duration="{{ $lesson->duration ?? 0 }}"
                                                               data-user="{{ Auth::user()->id }}"></i>
                                                        @endif

                                                        <!-- Lesson Type Icon -->
                                                        <div class="flex-shrink-0">
                                                            @if ($lesson->type == 'text')
                                                                <i class="fa-regular fa-file-lines actv-hide text-sm text-blue-400"></i>
                                                                <i class="fas fa-pause actv-show text-sm text-purple-400"></i>
                                                            @elseif($lesson->type == 'audio')
                                                                <i class="fa-solid fa-headphones actv-hide text-sm text-green-400"></i>
                                                                <i class="fas fa-pause actv-show text-sm text-purple-400"></i>
                                                            @elseif($lesson->type == 'video')
                                                                <i class="fas fa-play actv-hide text-sm text-red-400"></i>
                                                                <i class="fas fa-pause actv-show text-sm text-purple-400"></i>
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
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Related Courses -->
            @if(count($relatedCourses) > 0)
                <div class="glass-effect rounded-2xl p-4">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-graduation-cap mr-2 text-purple-400"></i>
                        সংশ্লিষ্ট কোর্স
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($relatedCourses->take(3) as $relatedCourse)
                            <div class="review-card rounded-lg p-3">
                                <div class="flex space-x-3">
                                    <img src="{{ asset($relatedCourse->thumbnail ?? 'assets/images/courses/thumbnail.png') }}" 
                                         alt="{{ $relatedCourse->title }}" 
                                         class="w-16 h-12 rounded-lg object-cover">
                                    <div class="flex-1 min-w-0">
                                        @if (isset($userEnrolledCourses[$relatedCourse->id]))
                                            <a href="{{ url('student/courses/my-courses/details/' . $relatedCourse->slug) }}" 
                                               class="text-sm font-medium text-white hover:text-purple-400 transition-colors line-clamp-2">
                                                {{ $relatedCourse->title }}
                                            </a>
                                        @else
                                            <a href="{{ url('student/courses/overview/' . $relatedCourse->slug) }}" 
                                               class="text-sm font-medium text-white hover:text-purple-400 transition-colors line-clamp-2">
                                                {{ $relatedCourse->title }}
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
                                        
                                        <div class="flex items-center mt-1">
                                            <span class="text-xs text-yellow-400 mr-1">{{ number_format($review_avg, 1) }}</span>
                                            <div class="flex space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $review_avg ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500 ml-1">({{ $total }})</span>
                                        </div>
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
<script>
function toggleModule(moduleId) {
    const module = document.getElementById(moduleId);
    const icon = document.getElementById('icon-' + moduleId);
    
    if (module.classList.contains('hidden')) {
        module.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        module.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Initialize rating system
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.previousElementSibling.value;
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-yellow-400');
                    s.classList.remove('text-gray-500');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-500');
                }
            });
        });
    });
});
</script>
@endpush
@endsection