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

                    <div class="content-txt-box mb-3" id="textHideShow" style="display: none;">
                        <div class="course-desc-txt">
                            <div id="dataTextContainer" class="my-3"></div>
                        </div>
                    </div>

                    <hr id="textHideShowSeparator" style="display: none;">
                    <div class="content-txt-box">
                        <h3 id="aboutCourse">About Course</h3>
                        <div class="course-desc-txt" id="lessonShortDesc">
                            {!! $course->description !!}
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
                    @if ($course->allow_review)
                        {{-- course review --}}
                        <div class="course-review-wrap">
                            <h3>{{ count($course_reviews) }} Reviews</h3>

                            <div class="media course-review-input-box">
                                @if ($course->user->avatar)
                                    @if ($course->user->user_role == 'student')
                                        <img src="{{ asset($course->user->avatar) }}" alt="Place" class="img-fluid">
                                    @endif
                                @else
                                    <span class="avtar">{!! strtoupper($course->user->name[0]) !!}</span>
                                @endif
                                <div class="media-body">
                                    <form
                                        action="{{ route('student.courses.review', $course->slug) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input autocomplete="off" type="text" name="comment" id="review"
                                                placeholder="Write a review">
                                        </div>
                                        <div class="form-rev">
                                            <div id="full-stars">
                                                <div class="rating-group">
                                                    <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input class="rating__input" name="star" id="rating-1"
                                                        value="1" type="radio">
                                                    <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input class="rating__input" name="star" id="rating-2"
                                                        value="2" type="radio">
                                                    <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input class="rating__input" name="star" id="rating-3"
                                                        value="3" type="radio" checked>
                                                    <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input class="rating__input" name="star" id="rating-4"
                                                        value="4" type="radio">
                                                    <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                    <input class="rating__input" name="star" id="rating-5"
                                                        value="5" type="radio">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn common-bttn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            @if (count($course_reviews) > 0)
                                @foreach ($course_reviews as $course_review)
                                    <div class="media">
                                        @if ($course_review->user && $course_review->user->avatar)
                                            <img src="{{ asset($course_review->user->avatar) }}" alt="Place"
                                                class="img-fluid">
                                        @else
                                            <span class="user-name-avatar me-1">{!! strtoupper($course_review->user->name[0]) !!}</span>
                                        @endif

                                        <div class="media-body">
                                            <h5>{{ $course_review->user->name }}</h5>
                                            <ul>
                                                @for ($i = 0; $i < $course_review->star; $i++)
                                                    <li><i class="fas fa-star"></i></li>
                                                @endfor
                                            </ul>
                                            <p>{{ $course_review->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="media">
                                    <div class="media-body">
                                        <p>No Review Found!</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- course review --}}
                    @endif
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                    {{-- course outline --}}
                    <div class="course-outline-wrap course-modules-lessons-redesign">
                        <div class="header">
                            <h3>Modules</h3>
                            <h6>
                                {{ $totalModules }} Module . {{ $totalLessons }} Lessons
                            </h6>
                        </div>
                        <div class="accordion" id="accordionExample">
                            @foreach ($course->modules as $module)
                                @if ($module->status == 'published' && count($module->lessons) > 0)
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="heading_{{ $module->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_{{ $module->id }}" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <div class="media align-items-center">

                                                    <i class="fas fa-check-circle me-2 {{ $module->isComplete() ? 'text-primary' : '' }}"></i>
                                                    <div class="media-body">
                                                        <p class="module-title">{{ $module->title }}
                                                            {{ $module->checkNumber() ? $loop->iteration : '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                        <div id="collapse_{{ $module->id }}"
                                            class="accordion-collapse collapse
                                            {{ $currentLesson && $currentLesson->module_id == $module->id ? 'show' : '' }}"
                                            aria-labelledby="heading_{{ $module->id }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <ul class="lesson-wrap">
                                                    @foreach ($module->lessons as $lesson)
                                                        @if ($lesson->status == 'published')
                                                            <li>
                                                                @if (!$isUserEnrolled)
                                                                    <a href="{{ url('student/checkout/' . $course->slug) }}"
                                                                        class="video_list_play d-inline-block">
                                                                        <i class="fas fa-lock"></i>
                                                                        {{ $lesson->title }}
                                                                    </a>
                                                                @else
                                                                    <a href="{{ $lesson->video_link }}"
                                                                        class="video_list_play d-inline-block {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}"
                                                                        data-video-id="{{ $lesson->id }}"
                                                                        data-lesson-id="{{ $lesson->id }}"
                                                                        data-course-id="{{ $course->id }}"
                                                                        data-modules-id="{{ $module->id }}"
                                                                        data-video-url="{{ $lesson->video_link ?? '' }}"
                                                                        data-audio-url="{{ $lesson->audio }}"
                                                                        data-lesson-type="{{ $lesson->type }}"
                                                                        data-lesson-duration="{{ $lesson->duration ?? 0 }}"
                                                                        data-instructor-id="{{ $course->user_id }}">

                                                                        <span class="mt-2 ms-1" style="cursor:pointer;">
                                                                            @if (isset($userCompletedLessons[$lesson->id]))
                                                                                <i class="fas fa-check-circle text-primary" 
                                                                                   title="Completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                            @else
                                                                                <i class="fas fa-check-circle is_complete_lesson"
                                                                                    data-course="{{ $course->id }}"
                                                                                    data-module="{{ $module->id }}"
                                                                                    data-lesson="{{ $lesson->id }}"
                                                                                    data-duration="{{ $lesson->duration ?? 0 }}"
                                                                                    data-user="{{ Auth::user()->id }}"
                                                                                    title="Not completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                            @endif
                                                                        </span>

                                                                        @if ($lesson->type == 'text')
                                                                            <i class="fa-regular fa-file-lines actv-hide" style="color:#2F3A4C"></i>
                                                                            <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                        @elseif($lesson->type == 'audio')
                                                                            <i class="fa-solid fa-headphones actv-hide" style="color:#2F3A4C"></i>
                                                                            <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                        @elseif($lesson->type == 'video')
                                                                            <img src="{{ asset('assets/images/icons/play-icon.svg') }}" alt="i" class="img-fluid actv-hide" style="width:0.8rem;">
                                                                            <img src="{{ asset('assets/images/icons/pause.svg') }}" alt="i" class="img-fluid actv-show" style="width:1rem;">
                                                                        @endif
                                                                        {{ $lesson->title }}
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
                    {{-- course outline --}}

                    {{-- related course --}}
                    <div class="related-course-box">
                        <h3>Related Courses</h3>
                        <div class="row">
                            @if (count($relatedCourses) > 0)
                                @foreach ($relatedCourses as $relatedCourse)
                                    <div class="col-md-6 col-12 col-lg-12 col-xl-12 mt-15 px-0">
                                        {{-- item --}}
                                        <div class="course-single-item">
                                            <div class="course-thumb-box">
                                                @if ($relatedCourse->thumbnail)
                                                <img src="{{ asset($relatedCourse->thumbnail) }}" alt="Course Thumbnail" class="img-fluid">
                                                @else
                                                    <img src="{{ asset('assets/images/courses/thumbnail.png') }}" alt="Course Thumbnail" class="img-fluid">
                                                @endif
                                            </div>
                                            <div class="course-txt-box">
                                                @if (isset($userEnrolledCourses[$relatedCourse->id]))
                                                    <a
                                                        href="{{ url('student/courses/my-courses/details/' . $relatedCourse->slug) }}">
                                                        {{ Str::limit($relatedCourse->title, 45) }}</a>
                                                @else
                                                    <a
                                                        href="{{ url('student/courses/overview/' . $relatedCourse->slug) }}">
                                                        {{ Str::limit($relatedCourse->title, 50) }}</a>
                                                @endif

                                                <p>{{ $relatedCourse->user->name }}</p>

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
                                                <ul>
                                                    <li><span>{{ $review_avg }}</span></li>
                                                    @for ($i = 0; $i < $review_avg; $i++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                                    <li><span>({{ $total }})</span></li>
                                                </ul>
                                                @if ($relatedCourse->offer_price)
                                                    <h5>৳ {{ $relatedCourse->offer_price }} <span>৳
                                                            {{ $relatedCourse->price }}</span>
                                                    </h5>
                                                @elseif(!$relatedCourse->offer_price && !$relatedCourse->price)
                                                    <h5>Free</h5>
                                                @else
                                                    <h5>৳ {{ $relatedCourse->price }}</h5>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- item --}}
                                    </div>
                                @endforeach
                            @else
                                @include('partials/no-data')
                            @endif
                        </div>
                    </div>
                    {{-- related course --}}

                </div>
            </div>
        </div>
    </main>
    <!-- course details page @E -->


@endsection

{{-- Additional CSS for video players --}}
@section('styles')
<style>
    .video-container {
        display: block !important;
    }
    
    .youtube-player, .vimeo-player, .generic-video-player {
        display: none;
    }
    
    .youtube-player.active, .vimeo-player.active, .generic-video-player.active {
        display: block !important;
    }
    
    /* Video protection styles */
    .youtube-player iframe, .vimeo-player iframe {
        pointer-events: none;
        position: relative;
    }
    
    .video-iframe-vox {
        position: relative;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    
    .video-iframe-vox::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        pointer-events: none;
    }
    
    /* Disable right click on video area */
    .video-iframe-vox iframe {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    
    /* Mark as complete button styling */
    #markCompleteBtn {
        white-space: nowrap;
        min-width: 140px;
    }
    
    .liked-course-button {
        flex-wrap: wrap;
    }
</style>
@endsection

{{-- script section @S --}}
@section('script')
    <script>
        $(document).ready(function() {
            console.log('Student view script loaded');
            
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
                console.log('🎬 Initializing with last lesson from course_logs:', {
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
                console.log('🎯 Lesson clicked - icon switching should work');
                
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

                console.log('Lesson data:', {
                    type: type,
                    lessonId: lessonId,
                    courseId: courseId,
                    moduleId: moduleId,
                    lessonDuration: lessonDuration,
                    instructorId: instructorId
                });

                if (type == 'video') {
                    console.log('Playing video lesson');
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
                    console.log('Playing audio lesson');
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
                    console.log('Showing text lesson');
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
                
                console.log('Sending AJAX request to course_logs table:', data);
                
                // ONLY Log course progress (similar to instructor) - DO NOT mark as complete
                $.ajax({
                    url: '{{ route('student.log.courses') }}',
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        console.log('✅ course_logs table insertion SUCCESS:', response);
                        console.log('Data logged in course_logs:', {
                            course_id: courseId,
                            lesson_id: lessonId,
                            module_id: moduleId,
                            user_id: '{{ Auth::user()->id }}'
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('❌ course_logs AJAX ERROR:', error);
                        console.log('Response Status:', xhr.status);
                        console.log('Response Text:', xhr.responseText);
                        console.log('Error Details:', {status: status, error: error});
                    }
                });
            });

            // Video loading function with YouTube/Vimeo support
            function loadVideo(videoUrl, lessonId) {
                console.log('Loading video:', videoUrl);
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
                    console.log('Video loaded successfully');
                } else {
                    console.log('Invalid video URL');
                }
            }

            // Function to update the Mark as Complete button based on selected lesson
            function updateMarkAsCompleteButton(lessonId, moduleId, instructorId, duration) {
                console.log('🔄 Updating Mark as Complete button for lesson:', lessonId);
                
                var $button = $('#markCompleteBtn');
                
                // Check if lesson is already completed by checking the PHP-generated completed lessons array
                var completedLessons = @json(array_keys($userCompletedLessons ?? []));
                var isCompleted = completedLessons.includes(parseInt(lessonId));
                
                console.log('Lesson completion status from server:', {
                    lessonId: lessonId,
                    completedLessons: completedLessons,
                    isCompleted: isCompleted
                });
                
                if (isCompleted) {
                    // Lesson is already completed - show Completed and disable
                    $button.removeClass('btn-success').addClass('btn-secondary');
                    $button.html('<i class="fas fa-check-circle me-1"></i>Completed');
                    $button.prop('disabled', true);
                    console.log('✅ Button set to Completed state');
                } else {
                    // Lesson not completed yet
                    $button.removeClass('btn-secondary').addClass('btn-success');
                    $button.html('<i class="fas fa-check-circle me-1"></i>Mark as Complete');
                    $button.prop('disabled', false);
                    
                    // Update button data attributes
                    $button.data('lesson', lessonId);
                    $button.data('module', moduleId);
                    $button.data('duration', duration);
                    $button.attr('data-lesson', lessonId);
                    $button.attr('data-module', moduleId);
                    $button.attr('data-duration', duration);
                    
                    console.log('🎯 Button set to Mark as Complete state for lesson:', lessonId);
                }
            }

            // Handle main "Mark as Complete" button click (beside heart icon)
            $(document).on('click', '#markCompleteBtn', function(e) {
                e.preventDefault();
                
                console.log('🎯 Mark Complete button clicked!');
                
                // Check if lesson is already completed - if so, don't proceed
                if ($(this).hasClass('btn-secondary') && $(this).text().includes('Completed')) {
                    console.log('🚫 Button is in Completed state - no AJAX call');
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
                
                console.log('🎯 MAIN Mark as Complete button clicked');
                console.log('Inserting into course_activities table:', data);

                $.ajax({
                    url: '{{ route('student.complete.lesson') }}',
                    method: 'GET',
                    data: data,
                    beforeSend: function() {
                        $element.html('<i class="spinner-border spinner-border-sm me-1"></i>Marking...');
                        $element.prop('disabled', true);
                        console.log('⏳ Processing main completion...');
                    },
                    success: function(response) {
                        console.log('✅ MAIN completion SUCCESS:', response);
                        console.log('Data inserted into course_activities:', {
                            course_id: courseId,
                            instructor_id: {{ $course->user_id }},
                            module_id: moduleId,
                            lesson_id: lessonId,
                            user_id: '{{ Auth::user()->id }}',
                            is_completed: true,
                            duration: duration
                        });
                        
                        // Change button to completed state
                        $element.html('<i class="fas fa-check-circle me-1"></i>Completed');
                        $element.removeClass('btn-success').addClass('btn-secondary');
                        $element.prop('disabled', true);
                        
                        // Update the lesson completion icon in the sidebar
                        var $lessonIcon = $('a[data-lesson-id="' + lessonId + '"] .is_complete_lesson');
                        if ($lessonIcon.length) {
                            $lessonIcon.addClass('text-primary');
                            $lessonIcon.removeClass('is_complete_lesson');
                        }
                        
                        // Update the module icon if all lessons in module are completed
                        updateModuleCompletionIcon(moduleId);
                        
                        console.log('✅ Main completion button updated');
                    },
                    error: function(xhr, status, error) {
                        console.log('❌ MAIN completion ERROR:', error);
                        console.log('Response Status:', xhr.status);
                        console.log('Response Text:', xhr.responseText);
                        console.log('Error Details:', {status: status, error: error});
                        
                        // Reset button on error
                        $element.html('<i class="fas fa-check-circle me-1"></i>Mark as Complete');
                        $element.removeClass('btn-secondary').addClass('btn-success');
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
                
                console.log('📝 MANUAL lesson completion clicked');
                console.log('Inserting into course_activities table:', data);

                $.ajax({
                    url: '{{ route('student.complete.lesson') }}',
                    method: 'GET',
                    data: data,
                    beforeSend: function() {
                        // Change class to spinner
                        $element.removeClass('fas fa-check-circle').addClass('spinner-border spinner-border-sm');
                        console.log('⏳ Processing manual completion...');
                    },
                    success: function(response) {
                        console.log('✅ MANUAL completion SUCCESS:', response);
                        console.log('Data inserted into course_activities:', {
                            course_id: courseId,
                            instructor_id: {{ $course->user_id }},
                            module_id: moduleId,
                            lesson_id: lessonId,
                            user_id: userId,
                            is_completed: true,
                            duration: duration
                        });
                        
                        // Change icon to success checkmark
                        $element.removeClass('spinner-border spinner-border-sm').addClass('fas fa-check-circle text-primary');
                        $element.removeClass('is_complete_lesson'); // Remove click handler
                        
                        // Update the module icon if all lessons in module are completed
                        updateModuleCompletionIcon(moduleId);
                        
                        console.log('✅ Manual completion icon updated');
                    },
                    error: function(xhr, status, error) {
                        console.log('❌ MANUAL completion ERROR:', error);
                        console.log('Response Status:', xhr.status);
                        console.log('Response Text:', xhr.responseText);
                        console.log('Error Details:', {status: status, error: error});
                        // Reset on error
                        $element.removeClass('spinner-border spinner-border-sm').addClass('fas fa-check-circle');
                    }
                });
            });

            // Function to update module completion icon when all lessons are completed
            function updateModuleCompletionIcon(moduleId) {
                console.log('🔍 Checking module completion for module:', moduleId);
                
                var $moduleHeader = $('#heading_' + moduleId + ' .fas.fa-check-circle');
                var $allLessonsInModule = $('a[data-modules-id="' + moduleId + '"] .fas.fa-check-circle');
                var totalLessons = $allLessonsInModule.length;
                var completedLessons = $allLessonsInModule.filter('.text-primary').length;
                
                console.log('Module completion check:', {
                    moduleId: moduleId,
                    totalLessons: totalLessons,
                    completedLessons: completedLessons
                });
                
                if (totalLessons > 0 && completedLessons === totalLessons) {
                    // All lessons completed - make module icon primary color
                    $moduleHeader.addClass('text-primary');
                    console.log('✅ Module ' + moduleId + ' marked as completed');
                } else {
                    // Not all lessons completed - remove primary color
                    $moduleHeader.removeClass('text-primary');
                    console.log('⏳ Module ' + moduleId + ' still in progress');
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
    </script>
     {{-- linke bttn --}}
     <script>
        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');
        const likeBttn = document.getElementById('likeBttn');

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
    </script>
@endsection
{{-- script section @E --}}
