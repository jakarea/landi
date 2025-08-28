@extends('layouts.latest.students')
@section('title')
    {{ $course->title ? $course->title : 'Course Details' }}
@endsection

{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />

    <style>
        #firstLesson .vp-sidedock {
            display: none !important;
        }
        
        /* Play/Pause Icon Control */
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
    <main class="course-show-page-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                    <div class="course-left">
                        {{-- video player --}}
                        @if (isEnrolled($course->id))
                            {{-- video player --}}
                            <div class="video-iframe-vox" id="videoPlayerContainer" style="display: block;">
                                @if (getFirstLesson($course->id))
                                    @php
                                        $firstLesson = getFirstLesson($course->id);
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
                                @if(isEnrolled($course->id))
                                    @if($currentLesson && isLessonCompleted($currentLesson->id))
                                        <button class="btn btn-secondary btn-sm" id="markCompleteBtn" 
                                            data-course="{{ $course->id }}"
                                            data-module="{{ $currentLesson->module_id }}"
                                            data-lesson="{{ $currentLesson->id }}"
                                            data-duration="{{ $currentLesson->duration ?? 0 }}"
                                            disabled>
                                            <i class="fas fa-check-circle me-1"></i>
                                            Completed
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-sm" id="markCompleteBtn" 
                                            data-course="{{ $course->id }}"
                                            data-module="{{ $currentLesson ? $currentLesson->module_id : '' }}"
                                            data-lesson="{{ $currentLesson ? $currentLesson->id : '' }}"
                                            data-duration="{{ $currentLesson ? ($currentLesson->duration ?? 0) : 0 }}"
                                            {{ !$currentLesson ? 'disabled' : '' }}>
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ $currentLesson ? 'Mark as Complete' : 'Select a Lesson' }}
                                        </button>
                                    @endif
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

                    <div class="content-txt-box mb-3" id="textHideShow">
                        <div class="course-desc-txt">
                            <div id="dataTextContainer" class="my-3"></div>
                        </div>
                    </div>

                    <hr>
                    <div class="content-txt-box">
                        <h3 id="aboutCourse">About Course</h3>
                        <div class="course-desc-txt" id="lessonShortDesc">
                            {!! $course->description !!}
                        </div>
                    </div>

                    {{-- <div class="download-files-box">
                        <h4>Download Files </h4>

                        @if (!empty($group_files))
                            <div class="files">
                                @foreach ($group_files as $fileExtension)
                                    <a
                                        href="{{ route('file.download', ['course_id' => $course->id, 'extension' => $fileExtension, 'subdomain' => config('app.subdomain')]) }}">
                                        {{ strtoupper($fileExtension) }}<img
                                            src="{{ asset('assets/images/icons/download.svg') }}" alt="clock"
                                            title="" class="img-fluid">
                                    </a>
                                @endforeach
                                @php
                                    $progress = StudentActitviesProgress(auth()->user()->id, $course->id);
                                @endphp

                                @if ($progress > 90)
                                    <a
                                        href="{{ route('students.download.courses-certificate', ['slug' => $course->slug, 'subdomain' => config('app.subdomain')]) }}">Certificate
                                        Download <img src="{{ asset('assets/images/icons/download.svg') }}"
                                            alt="clock" title="120MB" class="img-fluid"></a>
                                @endif
                            </div>
                        @endif
                    </div> --}}
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
                                        action="{{ route('students.review.courses', ['slug' => $course->slug, 'subdomain' => config('app.subdomain')]) }}"
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
                                                        
                                                        @if ($lesson->status == 'published' )

                                                            <li>
                                                                @if (!isEnrolled($course->id))
                                                                    <a href="{{ route('students.checkout', ['slug' => $course->slug, 'subdomain' => config('app.subdomain')]) }}"
                                                                        class="video_list_play d-inline-block">
                                                                        <i class="fas fa-lock"></i>
                                                                        {{ $lesson->title }}
                                                                    </a>
                                                                @else
                                                                    <a href="{{ $lesson->video_link }}"
                                                                        class="video_list_play d-inline-block
                                                                {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}"
                                                                        data-video-id="{{ $lesson->id }}"
                                                                        data-lesson-id="{{ $lesson->id }}"
                                                                        data-course-id="{{ $course->id }}"
                                                                        data-modules-id="{{ $module->id }}"
                                                                        data-audio-url="{{ $lesson->audio }}"
                                                                        data-lesson-type="{{ $lesson->type }}">

                                                                        <span class="mt-2 ms-1" style="cursor:pointer;">
                                                                            @if (isLessonCompleted($lesson->id))
                                                                                <i
                                                                                    class="fas fa-check-circle text-primary"></i>
                                                                            @else
                                                                                <i class="fas fa-check-circle is_complete_lesson"
                                                                                    data-course="{{ $course->id }}"
                                                                                    data-module="{{ $module->id }}"
                                                                                    data-lesson="{{ $lesson->id }}"
                                                                                    data-duration="{{ $lesson->duration }}"
                                                                                    data-user="{{ Auth::user()->id }}"></i>
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
                                                @if (isEnrolled($relatedCourse->id))
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
                                                    <h5>€ {{ $relatedCourse->offer_price }} <span>€
                                                            {{ $relatedCourse->price }}</span>
                                                    </h5>
                                                @elseif(!$relatedCourse->offer_price && !$relatedCourse->price)
                                                    <h5>Free</h5>
                                                @else
                                                    <h5>€ {{ $relatedCourse->price }}</h5>
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
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script>
        $(document).ready(function() {
            
            // Disable right-click on video containers for protection
            $('.video-iframe-vox').on('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });
            
            // Disable F12, Ctrl+Shift+I, Ctrl+U, Ctrl+S on video containers
            $('.video-iframe-vox').on('keydown', function(e) {
                // F12 or Ctrl+Shift+I or Ctrl+U or Ctrl+S
                if (e.keyCode == 123 || (e.ctrlKey && e.shiftKey && e.keyCode == 73) || 
                    (e.ctrlKey && e.keyCode == 85) || (e.ctrlKey && e.keyCode == 83)) {
                    e.preventDefault();
                    return false;
                }
            });

            // Initialize players based on video type
            var vimeoPlayer = null;
            var youtubePlayer = null;
            var currentPlayerType = 'none';

            // Initialize Vimeo player if exists
            if (document.querySelector('.vimeo-player')) {
                var vimeoOptions = {
                    id: '{{ $defaultVideoId }}',
                    autoplay: true,
                    width: 500,
                };
                try {
                    vimeoPlayer = new Vimeo.Player(document.querySelector('.vimeo-player'), vimeoOptions);
                    currentPlayerType = 'vimeo';
                } catch(e) {
                    console.log('Vimeo player initialization failed:', e);
                }
            }

            // Video loading function with YouTube/Vimeo support and download protection
            function loadVideo(videoUrl, lessonId) {
                const videoContainer = document.getElementById('videoPlayerContainer');
                if (!videoContainer || !videoUrl) return;

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
                if (videoUrl.includes('vimeo.com')) {
                    platform = 'vimeo';
                    const videoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                    if (videoId) {
                        // Vimeo embed with download protection parameters
                        embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1&portrait=0&title=0&byline=0&controls=1&dnt=1&pip=0`;
                    }
                }

                if (embedUrl) {
                    // Create iframe with download protection attributes
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
                } else {
                    videoContainer.innerHTML = `
                        <div style="width: 100%; height: 480px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Invalid video URL</p>
                                <small class="text-muted">Only YouTube and Vimeo videos are supported</small>
                            </div>
                        </div>
                    `;
                }
            }



            // play all url
            let playUrl;
            playUrl = "{{ $playUrl }}";

            // initial audio
            var audioPlayer = document.getElementById('audioPlayer');
            var audioSource = audioPlayer.querySelector('source');

            if (audioPlayer) audioPlayer.pause();

            // Show/hide appropriate content based on lesson type
            $('#textHideShow').hide();
            document.querySelector('.audio-iframe-box').classList.add('d-none');

            let crntLesson = "{{ $currentLesson ? $currentLesson->type : '' }}";
            let crntLessonShort = "{{ $currentLesson ? $currentLesson->short_description : '' }}";
            
            
            if (crntLesson == 'video') {
                $('#aboutCourse').html('Lesson Content');

                $('#lessonShortDesc').html(crntLessonShort);

                    if (playUrl !== null) {
                    if (audioPlayer) audioPlayer.pause();
                    loadVideo(playUrl, "{{ $currentLesson ? $currentLesson->id : '' }}");
                }
            }else if(crntLesson == 'audio'){
                $('#aboutCourse').html('Lesson Content');

                $('#lessonShortDesc').html(crntLessonShort);

                if (playUrl !== null) {
                    $('.audio-iframe-box').show();
                    $('#textHideShow').hide();
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    document.querySelector('.audio-iframe-box').classList.remove('d-none');

                    audioSource.src = baseUrl + '/' + playUrl;
                    audioPlayer.load();
                    audioPlayer.play();
                }
            }else if(crntLesson == 'text'){
                $('#aboutCourse').html('Lesson Content');
                $('#lessonShortDesc').html(crntLessonShort);

                if (playUrl !== null) {
                    if (audioPlayer) audioPlayer.pause();

                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                    $('.audio-iframe-box').hide();
                    $('#textHideShow').show();
                    $('#dataTextContainer').html(playUrl);
                    document.querySelector('.audio-iframe-box').classList.add('d-none');

                }
            }

            // Auto-advance to next lesson when video ends (handled by iframe events if needed)

            // play next lesson after end audio
            audioPlayer.onended = function() {
                $('a.video_list_play.active .is_complete_lesson').click();
                $('a.video_list_play.active').parent().next().find('a.video_list_play').click();
            };

            $('a.video_list_play').click(function(e) {
                e.preventDefault();

                // Reset all lesson icons - show play icons, hide pause icons
                $('a.video_list_play').removeClass('active');
                $('a.video_list_play .actv-hide').show(); // Show play icons
                $('a.video_list_play .actv-show').hide(); // Hide pause icons
                
                // Set current lesson as active and show pause icon
                $(this).addClass('active');
                $(this).find('.actv-hide').hide(); // Hide play icon
                $(this).find('.actv-show').show(); // Show pause icon

                console.log('Lesson clicked - icon switching should work');

                let type = this.getAttribute('data-lesson-type');

                if (type == 'video') {
                    document.querySelector('#videoPlayerContainer').style.display = 'block';
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    $('#textHideShow').hide();
                    if (audioPlayer) audioPlayer.pause();

                    @if (isEnrolled($course->id))
                        const videoUrl = this.getAttribute('href');
                        if (videoUrl) {
                            loadVideo(videoUrl, $(this).data('lesson-id'));
                        }
                    @else
                        alert('Please enroll the course');
                    @endif

                } else if (type == 'audio') {
                    if (audioPlayer) audioPlayer.pause();
                    document.querySelector('.audio-iframe-box').classList.remove('d-none');
                    $('#textHideShow').hide();
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
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    document.querySelector('#videoPlayerContainer').style.display = 'none';
                }

                // Update mark as complete button for current lesson
                updateMarkAsCompleteButton($(this));

                // send request per lesson click
                var data = {
                    courseId: $(this).data('course-id'),
                    lessonId: $(this).data('lesson-id'),
                    moduleId: $(this).data('modules-id')
                };
                $.ajax({
                    url: '{{ route('students.log.courses') }}',
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        let currentLessons = response.currentPlayingLesson;

                        if (currentLessons) {
                            if (currentLessons.short_description) {
                                $('#lessonShortDesc').html(currentLessons.short_description);
                            }else{
                                $('#lessonShortDesc').html('No content!');
                            }

                            if (currentLessons.type == 'text') {
                                $('#dataTextContainer').html(currentLessons.text);
                            }else{
                                $('#dataTextContainer').html('No content');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors, if any
                    }
                });

            });

            // Mark as complete button handler
            $(document).on('click', '#markCompleteBtn', function(e) {
                e.preventDefault();
                
                @if (isEnrolled($course->id))
                    var lessonId = $(this).data('lesson');
                    var courseId = $(this).data('course');
                    var moduleId = $(this).data('module');
                    var duration = $(this).data('duration') || 0;
                    
                    var data = {
                        courseId: courseId,
                        lessonId: lessonId,
                        moduleId: moduleId,
                        duration: duration
                    };

                    var $element = $(this);

                    $.ajax({
                        url: '{{ route('students.complete.lesson') }}',
                        method: 'GET',
                        data: data,
                        beforeSend: function() {
                            // Change button to loading state
                            $element.html('<i class="spinner-border spinner-border-sm me-1"></i>Marking...');
                            $element.prop('disabled', true);
                        },
                        success: function(response) {
                            // Change button to completed state
                            $element.html('<i class="fas fa-check-circle me-1"></i>Completed');
                            $element.removeClass('btn-success').addClass('btn-secondary');
                            $element.prop('disabled', true);
                            
                            // Update the lesson completion icon in the sidebar
                            var $lessonIcon = $('a[data-lesson-id="' + lessonId + '"] span .fas.fa-check-circle');
                            $lessonIcon.addClass('text-primary');
                            $lessonIcon.removeClass('is_complete_lesson');
                            
                        },
                        error: function(xhr, status, error) {
                            // Reset button on error
                            $element.html('<i class="fas fa-check-circle me-1"></i>Mark as Complete');
                            $element.removeClass('btn-secondary').addClass('btn-success');
                            $element.prop('disabled', false);
                            
                            // Show error message
                            alert('Error marking lesson as complete: ' + error);
                        }
                    });
                @else
                    alert('Please enroll in the course');
                @endif
            });

            // is_complete_lesson on click check course is purchased or not and then check lesson video is completed or not after send to ajax
            $('.is_complete_lesson').click(function(e) {
                e.preventDefault();

                @if (isEnrolled($course->id))
                    var lessonId = $(this).data('lesson');
                    var courseId = $(this).data('course');
                    var moduleId = $(this).data('module');
                    var duration = $(this).data('duration');
                    var data = {
                        courseId: courseId,
                        lessonId: lessonId,
                        moduleId: moduleId,
                        duration: duration
                    };

                    var $element = $(this);

                    $.ajax({
                        url: '{{ route('students.complete.lesson') }}',
                        method: 'GET',
                        data: data,
                        beforeSend: function() {
                            // Change class to spinner
                            $element.removeClass('fas fa-check-circle').addClass(
                                'spinner-border spinner-border-sm');
                        },
                        success: function(response) {
                            // console.log('response', response);
                            // Change icon to success checkmark
                            $element.removeClass('spinner-border spinner-border-sm').addClass(
                                'fas fa-check-circle text-primary');
                        },
                        error: function(xhr, status, error) {
                            // Handle errors, if any
                        }
                    });
                @else
                    alert('Please enroll in the course');
                @endif
            });


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
