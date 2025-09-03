@extends('layouts.latest.students')
@section('title')
    {{ $course->title ? $course->title : 'Course Details' }}
@endsection
@php
    use Illuminate\Support\Str;
@endphp
{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
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
        
        /* Ensure proper sidebar positioning */
        .course-outline-wrap {
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }
        
        .course-modules-lessons-redesign {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
@endsection
{{-- style section @E --}}
@section('seo')
    <meta name="keywords" content="{{ $course->categories . ', ' . $course->meta_keyword }}" />
    <meta name="description" content="{{ $course->meta_description }}" itemprop="description">
@endsection

@section('content')
    @php
        $i = 0;
    @endphp
    
    {{-- Debug information removed for security --}}
    <main class="course-show-page-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-8 col-12">
                    <div class="course-left">
                        {{-- video player --}}
                        @if ($isUserEnrolled)
                            {{-- video player --}}
                            <div class="video-iframe-vox" id="videoPlayerContainer" style="display: block;">
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
                                        <div class="youtube-player w-100" id="firstLesson"
                                            data-video-url="{{ $embedUrl }}"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="youtube">
                                            <iframe width="100%" height="480" src="{{ $embedUrl }}" frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen></iframe>
                                        </div>
                                    @elseif ($isVimeo && !empty($embedUrl))
                                        <div class="vimeo-player w-100" id="firstLesson"
                                            data-vimeo-url="{{ $embedUrl }}"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="vimeo">
                                            <iframe width="100%" height="480" src="{{ $embedUrl }}" frameborder="0" 
                                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    @elseif (!empty($videoLink))
                                        <div class="generic-video-player w-100" id="firstLesson"
                                            data-first-lesson-id="{{ $firstLesson->id }}"
                                            data-first-course-id="{{ $firstLesson->course_id }}"
                                            data-first-modules-id="{{ $firstLesson->module_id }}"
                                            data-video-type="generic">
                                            <video width="100%" height="480" controls>
                                                <source src="{{ $videoLink }}" type="video/mp4">
                                                আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                                            </video>
                                        </div>
                                    @else
                                        <div class="no-video-placeholder" style="width: 100%; height: 480px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                            <div class="text-center">
                                                <i class="fas fa-play-circle fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">প্রথম লেসনে কোনো ভিডিও নেই</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="no-lesson-placeholder" style="width: 100%; height: 480px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                        <div class="text-center">
                                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">এই কোর্সে কোনো লেসন পাওয়া যায়নি</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Dynamic Video Players --}}
                            <div class="youtube-player w-100" style="display: none;">
                                <iframe width="100%" height="480" src="" frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                            </div>
                            
                            <div class="vimeo-player w-100" style="display: none;">
                                <iframe width="100%" height="480" src="" frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            
                            <div class="generic-video-player w-100" style="display: none;">
                                <video width="100%" height="480" controls>
                                    <source src="" type="video/mp4">
                                    আপনার ব্রাউজার এই ভিডিও ফরম্যাট সাপোর্ট করে না।
                                </video>
                            </div>

                            {{-- audio player --}}
                            <div class="audio-iframe-box d-none">
                                <a href="#">
                                    <img src="{{ asset('assets/images/audio.png') }}" alt="Audio"
                                        class="img-fluid big-thumb">
                                </a>
                                <div class="player-bottom">
                                    <audio id="audioPlayer" controls>
                                        <source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                            {{-- audio player --}}
                        @endif


                        {{-- course title --}}
                        <div class="media course-title">
                            <div class="media-body">
                                <h1>{{ $course->title }}</h1>
                                <p>{{ $course->user->name }} </p>
                            </div>
                            {{-- liked course button here --}}
                            <div class="liked-course-button d-flex align-items-center gap-2">
                                <button class="btn like-btn {{ $liked }}" id="likeBttn">
                                    <i class="fas fa-heart"></i>
                                </button>
                                
                                {{-- Mark as Complete Button --}}
                                @if($isUserEnrolled)
                                    <button class="btn btn-success btn-sm" id="markCompleteBtn" 
                                        data-course="{{ $course->id }}"
                                        data-module=""
                                        data-lesson=""
                                        data-duration="0"
                                        disabled>
                                        <i class="fas fa-check-circle me-1"></i>
                                        Completed
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-lock me-1"></i>
                                        Not Enrolled
                                    </button>
                                @endif
                            </div>
                            {{-- liked course button here --}}
                        </div>
                    </div>
                    {{-- course title --}}

                    <div class="content-txt-box mb-3" id="textHideShow" style="display: none;">
                        <div class="course-desc-txt">
                            <div id="dataTextContainer" class="my-3"></div>
                        </div>
                    </div>

                    <hr id="textHideShowSeparator" style="display: none;">
                    <div class="content-txt-box">
                        <h3 id="aboutCourse">About Course</h3>
                        <div class="course-desc-txt" id="lessonShortDesc">
                            {{ $course->description }}
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
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
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
                                                                    <div class="lesson-item lesson-clickable d-flex align-items-center p-2 rounded cursor-pointer {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active bg-primary text-white' : 'hover:bg-light' }}"
                                                                        data-video-id="{{ $lesson->id }}"
                                                                        data-lesson-id="{{ $lesson->id }}"
                                                                        data-course-id="{{ $course->id }}"
                                                                        data-modules-id="{{ $module->id }}"
                                                                        data-video-url="{{ $lesson->video_link ?? '' }}"
                                                                        data-audio-url="{{ $lesson->audio }}"
                                                                        data-lesson-type="{{ $lesson->type }}"
                                                                        data-lesson-duration="{{ $lesson->duration ?? 0 }}"
                                                                        data-instructor-id="{{ $course->user_id }}"
                                                                        style="cursor: pointer;"
                                                                        onclick="return false;">

                                                                        <span class="me-2" style="cursor:pointer;" onclick="event.stopPropagation();">
                                                                            @if (isset($userCompletedLessons[$lesson->id]))
                                                                                <i class="fas fa-check-circle text-success" 
                                                                                   title="Completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                            @else
                                                                                <i class="fas fa-check-circle is_complete_lesson text-muted"
                                                                                    data-course="{{ $course->id }}"
                                                                                    data-module="{{ $module->id }}"
                                                                                    data-lesson="{{ $lesson->id }}"
                                                                                    data-duration="{{ $lesson->duration ?? 0 }}"
                                                                                    data-user="{{ Auth::user()->id }}"
                                                                                    title="Not completed - Lesson ID: {{ $lesson->id }}"></i>
                                                                            @endif
                                                                        </span>

                                                                        <span class="lesson-icon me-2">
                                                                            @if ($lesson->type == 'text')
                                                                                <i class="fa-regular fa-file-lines actv-hide" style="color:#2F3A4C"></i>
                                                                                <i class="fas fa-pause actv-show" style="color:#2F3A4C; display: none;"></i>
                                                                            @elseif($lesson->type == 'audio')
                                                                                <i class="fa-solid fa-headphones actv-hide" style="color:#2F3A4C"></i>
                                                                                <i class="fas fa-pause actv-show" style="color:#2F3A4C; display: none;"></i>
                                                                            @elseif($lesson->type == 'video')
                                                                                <i class="fas fa-play actv-hide" style="color:#2F3A4C"></i>
                                                                                <i class="fas fa-pause actv-show" style="color:#2F3A4C; display: none;"></i>
                                                                            @endif
                                                                        </span>

                                                                        <span class="lesson-title flex-fill">{{ $lesson->title }}</span>
                                                                    </div>
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
    
    /* Lesson item styling */
    .lesson-item {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .lesson-item:hover {
        background-color: #f8f9fa !important;
        border-color: #dee2e6;
    }
    
    .lesson-item.active {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff;
    }
    
    .lesson-item.active * {
        color: white !important;
    }
    
    .lesson-item .lesson-icon i {
        width: 16px;
        text-align: center;
    }
</style>
@endsection

{{-- script section @S --}}
@section('script')
    <script>
        $(document).ready(function() {
            console.log('Student view script loaded');
            console.log('Lesson items found:', $('.lesson-item.lesson-clickable').length);
            
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

            // Lesson click handler - Updated to handle div.lesson-item clicks
            $(document).on('click', '.lesson-item.lesson-clickable', function(e) {
                // Don't prevent default for completion checkbox clicks
                if ($(e.target).hasClass('is_complete_lesson')) {
                    return; // Let the completion handler handle this
                }
                
                console.log('🎯 Lesson clicked - target:', e.target);
                console.log('🎯 This element:', this);
                console.log('🎯 Lesson div data:', $(this).data());
                
                // Completely stop any navigation
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                
                // Reset all lesson items - remove active state and show play icons
                $('.lesson-item.lesson-clickable').removeClass('active bg-primary text-white').addClass('hover:bg-light');
                $('.lesson-item .actv-hide').show(); // Show play icons
                $('.lesson-item .actv-show').hide(); // Hide pause icons
                
                // Set current lesson as active and show pause icon
                $(this).addClass('active bg-primary text-white').removeClass('hover:bg-light');
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
                    const videoUrl = this.getAttribute('data-video-url');
                    
                    // Detect media type (YouTube, Vimeo, or regular video)
                    let mediaType = 'video';
                    if (videoUrl) {
                        if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                            mediaType = 'youtube';
                        } else if (videoUrl.includes('vimeo.com')) {
                            mediaType = 'vimeo';
                        }
                    }
                    
                    console.log('Playing video lesson - Type:', mediaType, 'URL:', videoUrl);
                    
                    // Show video player, hide other media
                    document.querySelector('#videoPlayerContainer').style.display = 'block';
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    $('#textHideShow').hide();
                    $('#textHideShowSeparator').hide();
                    if (audioPlayer) audioPlayer.pause();

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
                
                // Ensure no navigation happens
                return false;
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
