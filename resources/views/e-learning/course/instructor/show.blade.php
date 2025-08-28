@extends('layouts.latest.instructor')
@section('title')
    Course Details
@endsection

{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
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

        /* Module and Lesson Management Styles */
        .add-lesson-item {
            border-top: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .add-lesson-btn {
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .add-lesson-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .add-module-section {
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .add-module-section:hover {
            border-color: #0d6efd;
            background: linear-gradient(135deg, #e7f1ff 0%, #cce7ff 100%);
        }

        .add-module-btn {
            font-weight: 600;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
            transition: all 0.3s ease;
        }

        .add-module-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* Lesson list improvements */
        .lesson-wrap li {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #f1f3f4;
            transition: background-color 0.2s ease;
        }

        .lesson-wrap li:hover {
            background-color: #f8f9fa;
        }

        .lesson-wrap li:last-child {
            border-bottom: none;
        }

        /* Module header improvements */
        .accordion-button {
            font-weight: 600;
            font-size: 0.95rem;
            padding: 1rem 1.25rem;
        }

        .module-title {
            margin: 0;
            font-size: 1rem;
            color: #2c3e50;
        }

    </style>
@endsection
{{-- style section @E --}}

@section('content')
    @php
        $i = 0;
    @endphp
    <main class="course-show-page-wrap">
    <div class="container-fluid">
        <div class="row">

            {{-- Left Side --}}
            <div class="col-xl-8 col-lg-7 col-md-12 col-12">
                <div class="course-left">

                    {{-- video player --}}
                    <div class="video-iframe-vox">
                        @if (getFirstLesson($course->id))
                            <div class="video-player w-100" id="mainVideoPlayer"
                                data-video-url="{{ getFirstLesson($course->id)->video_link }}"
                                data-lesson-id="{{ getFirstLesson($course->id)->id }}"
                                data-course-id="{{ getFirstLesson($course->id)->course_id }}"
                                data-module-id="{{ getFirstLesson($course->id)->module_id }}">
                                <div class="ratio ratio-16x9">
                                    <div id="videoContainer" class="d-flex align-items-center justify-content-center bg-dark">
                                        <div class="text-white text-center">
                                            <i class="fas fa-play-circle fa-4x mb-3"></i>
                                            <p>Click a lesson to start watching</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="video-player w-100">
                                <div class="ratio ratio-16x9">
                                    <div class="d-flex align-items-center justify-content-center bg-dark text-white">
                                        <div class="text-center">
                                            <i class="fas fa-video fa-4x mb-3"></i>
                                            <p>No lessons available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- video player --}}

                    {{-- audio player --}}
                    <div class="audio-iframe-box d-none">
                        <a href="#">
                            <img src="{{ asset('assets/images/audio.png') }}" alt="Audio" class="img-fluid big-thumb">
                        </a>
                        <div class="player-bottom">
                            <audio id="audioPlayer" controls>
                                <source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                    {{-- audio player --}}

                    {{-- course title --}}
                    <div class="media course-title mt-3">
                        <div class="media-body">
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $course->user->name }} . {{ $course->user->user_role }}</p>
                        </div>
                    </div>
                    {{-- course title --}}

                    <div class="content-txt-box mb-3" id="hideShow">
                        <div class="course-desc-txt">
                            <div id="dataTextContainer" class="my-3"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="content-txt-box">
                        <h3>About Course</h3>
                        <div class="course-desc-txt">
                            {!! $course->description !!}
                        </div>
                    </div>

                    @if (!empty($group_files))
                        <div class="download-files-box">
                            <h4>Download Files</h4>
                            <div class="files">
                                @foreach ($group_files as $fileExtension)
                                    <a href="{{ route('instructor.file.download', [$course->id, $fileExtension, 'subdomain' => config('app.subdomain')]) }}">
                                        {{ strtoupper($fileExtension) }}
                                        <img src="{{ asset('assets/images/icons/download.svg') }}" alt="download" class="img-fluid">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- course review --}}
                    @if ($course->allow_review)
                        <div class="course-review-wrap mt-4">
                            <h3>{{ count($course_reviews) }} Reviews</h3>

                            @if (count($course_reviews) > 0)
                                @foreach ($course_reviews as $course_review)
                                    <div class="media mb-3">
                                        @if ($course_review->user->avatar)
                                            <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar" class="img-fluid">
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
                                <p>No Review Found!</p>
                            @endif
                        </div>
                    @endif
                    {{-- course review --}}

                </div>
            </div>
            {{-- End Left Side --}}

            {{-- Right Side --}}
            <div class="col-xl-4 col-lg-5 col-md-12 col-12">

                {{-- course outline --}}
                <div class="course-outline-wrap course-modules-lessons-redesign">
                    <div class="header">
                        <h3>Modules</h3>
                        <h6>{{ $totalModules }} Modules . {{ $totalLessons }} Lessons</h6>
                    </div>
                    <div class="accordion" id="accordionExample">
                        @foreach ($course->modules as $module)
                            @if (count($module->lessons) > 0)
                                <div class="accordion-item">
                                    <div class="accordion-header" id="heading_{{ $module->id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $module->id }}"
                                            aria-expanded="true" aria-controls="collapse_{{ $module->id }}">
                                            <p class="module-title">
                                                {{ $module->title }}
                                                {{ $module->checkNumber() ? $loop->iteration : '' }}
                                            </p>
                                        </button>
                                    </div>
                                    <div id="collapse_{{ $module->id }}"
                                        class="accordion-collapse collapse {{ $currentLesson && $currentLesson->module_id == $module->id ? 'show' : '' }}"
                                        aria-labelledby="heading_{{ $module->id }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body p-0">
                                            <ul class="lesson-wrap">
                                                @foreach ($module->lessons as $lesson)
                                                    @php
                                                        $isPublic = isset($lesson->is_public) && $lesson->is_public;
                                                        $publishAt = isset($lesson->publish_at) ? \Carbon\Carbon::parse($lesson->publish_at) : null;
                                                        $isFuture = $publishAt && $publishAt->isFuture();
                                                    @endphp
                                                    <li>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center flex-grow-1">
                                                                @can('instructor')
                                                                    <a href="{{ url('instructor/courses/create/' . $course->id . '/video/' . $lesson->module_id . '/content/' . $lesson->id) }}" title="Edit Lesson">
                                                                        <i class="fa-regular fa-pen-to-square me-2" style="color:#A6B1C4"></i>
                                                                    </a>
                                                                @endcan

                                                                <a href="javascript:void(0)"
                                                                    class="video_list_play d-inline-block lesson-playable flex-grow-1 {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}"
                                                                    data-video-id="{{ $lesson->id }}"
                                                                    data-lesson-id="{{ $lesson->id }}"
                                                                    data-course-id="{{ $course->id }}"
                                                                    data-modules-id="{{ $module->id }}"
                                                                    data-video-url="{{ $lesson->video_link ?? '' }}"
                                                                    data-audio-url="{{ $lesson->audio }}"
                                                                    data-lesson-type="{{ $lesson->type }}"
                                                                    data-lesson-title="{{ $lesson->title }}"
                                                                    style="font-size:0.8rem!important">

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
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                
                                                @can('instructor')
                                                <!-- Add Lesson Button -->
                                                <li class="add-lesson-item">
                                                    <div class="text-center py-2">
                                                        <a href="{{ url('instructor/courses/create/' . $course->id . '/content') }}#module-{{ $module->id }}" 
                                                           class="btn btn-outline-primary btn-sm add-lesson-btn">
                                                            <i class="fas fa-plus me-1"></i>
                                                            Add Lesson to this Module
                                                        </a>
                                                    </div>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @can('instructor')
                        <div class="text-center add-module-section mt-3 mb-2">
                            <a href="{{ url('instructor/courses/create/' . $course->id . '/content') }}" 
                               class="btn btn-primary add-module-btn">
                                <i class="fas fa-plus-circle me-2"></i>
                                Add New Module
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                {{-- course outline --}}

                {{-- related course --}}
                <div class="related-course-box mt-4">
                    <h3>Related Courses</h3>
                    <div class="row">
                        @if ($relatedCourses && count($relatedCourses) > 0)
                            @foreach ($relatedCourses as $relatedCourse)
                                <div class="col-md-6 col-12 col-lg-12 col-xl-12 mb-3">
                                    <div class="course-single-item">
                                        <div class="course-thumb-box">
                                            <img src="{{ $relatedCourse->thumbnail ? asset($relatedCourse->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                                                 alt="Course Thumbnail" class="img-fluid">
                                        </div>
                                        <div class="course-txt-box">
                                            <a href="{{ url('instructor/courses', $relatedCourse->id) }}">
                                                {{ $relatedCourse->title }}
                                            </a>
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
                                                <h5>৳ {{ $relatedCourse->offer_price }} <span>৳ {{ $relatedCourse->price }}</span></h5>
                                            @elseif(!$relatedCourse->offer_price && !$relatedCourse->price)
                                                <h5>Free</h5>
                                            @else
                                                <h5>৳ {{ $relatedCourse->price }}</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @include('partials/no-data')
                        @endif
                    </div>
                </div>
                {{-- related course --}}

            </div>
            {{-- End Right Side --}}

        </div>
    </div>
</main>

    <!-- course details page @E -->
@endsection


{{-- script section @S --}}
@section('script')
    <script>
        document.querySelector('#hideShow').classList.add('d-none');

        $(document).ready(function() {
            let currentURL = window.location.href;
            const baseUrl = currentURL.split('/').slice(0, 3).join('/');

            // Auto-play first lesson if available
            @if (getFirstLesson($course->id))
                var firstLessonId = {{ getFirstLesson($course->id)->id }};
                var firstCourseId = {{ getFirstLesson($course->id)->course_id }};
                var firstModuleId = {{ getFirstLesson($course->id)->module_id }};
                var data = {
                    courseId: firstCourseId,
                    lessonId: firstLessonId,
                    moduleId: firstModuleId
                };
                
                // Log course progress
                $.ajax({
                    url: '{{ route('instructor.log.courses', config('app.subdomain')) }}',
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        // console.log('response', response)
                    },
                    error: function(xhr, status, error) {
                        // Handle errors, if any
                    }
                });

                // Auto-load first lesson video
                const firstVideoUrl = "{{ getFirstLesson($course->id)->video_link }}";
                if (firstVideoUrl) {
                    loadVideo(firstVideoUrl, {{ getFirstLesson($course->id)->id }});
                    
                    // Set the first lesson as active with pause icon
                    const firstLessonLink = $('a.video_list_play[data-lesson-id="{{ getFirstLesson($course->id)->id }}"]');
                    if (firstLessonLink.length) {
                        // Reset all icons first
                        $('a.video_list_play').removeClass('active');
                        $('a.video_list_play .actv-hide').show();
                        $('a.video_list_play .actv-show').hide();
                        
                        // Set first lesson as active
                        firstLessonLink.addClass('active');
                        firstLessonLink.find('.actv-hide').hide();
                        firstLessonLink.find('.actv-show').show();
                    }
                }
            @endif

            // Video/Audio players
            let audioPlayer = document.getElementById('audioPlayer');

            // Lesson click handler
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

                let type = this.getAttribute('data-lesson-type');
                let lessonId = this.getAttribute('data-lesson-id');
                let courseId = this.getAttribute('data-course-id');
                let moduleId = this.getAttribute('data-modules-id');

                // Log lesson access
                var logData = {
                    courseId: courseId,
                    lessonId: lessonId,
                    moduleId: moduleId
                };
                
                $.ajax({
                    url: '{{ route('instructor.log.courses', config('app.subdomain')) }}',
                    method: 'GET',
                    data: logData,
                    success: function(response) {
                        // console.log('Lesson logged', response)
                    }
                });

                if (type == 'video') {
                    document.querySelector('#hideShow').classList.add('d-none');
                    document.querySelector('.video-iframe-vox').classList.remove('d-none');
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    if (document.querySelector('.download-files-box')) {
                        document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download Files';
                    }
                    if (document.getElementById('dataTextContainer')) {
                        document.getElementById('dataTextContainer').innerHTML = '';
                    }
                    if (audioPlayer) audioPlayer.pause();

                    const videoUrl = this.getAttribute('data-video-url');
                    if (videoUrl) {
                        loadVideo(videoUrl, lessonId);
                    }

                } else if (type == 'audio') {
                    document.querySelector('#hideShow').classList.add('d-none');
                    document.querySelector('.audio-iframe-box').classList.remove('d-none');
                    document.querySelector('.video-iframe-vox').classList.add('d-none');
                    
                    var laravelURL = baseUrl + '/' + this.getAttribute('data-audio-url');
                    if (audioPlayer) {
                        let audioSource = audioPlayer.querySelector('source');
                        audioSource.src = laravelURL;
                        audioPlayer.load();
                        audioPlayer.play();
                    }
                    
                    if (document.querySelector('.download-files-box')) {
                        document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download Files';
                    }
                    if (document.getElementById('dataTextContainer')) {
                        document.getElementById('dataTextContainer').innerHTML = '';
                    }

                } else if (type == 'text') {
                    if (audioPlayer) audioPlayer.pause();
                    document.querySelector('#hideShow').classList.remove('d-none');
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    document.querySelector('.video-iframe-vox').classList.add('d-none');
                    
                    if (document.querySelector('.download-files-box')) {
                        document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download all course materials';
                    }

                    // Load text content
                    fetch(`${baseUrl}/student/lessons/${lessonId}`, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (document.getElementById('dataTextContainer')) {
                                document.getElementById('dataTextContainer').innerHTML = data.text;
                            }
                        })
                        .catch(error => {
                            console.error('Error loading text content:', error);
                        });
                }
            });

            // Video loading function with YouTube/Vimeo support and download protection
            function loadVideo(videoUrl, lessonId) {
                const videoContainer = document.getElementById('videoContainer');
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
                            height="100%" 
                            frameborder="0" 
                            allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen
                            style="pointer-events: auto;"
                            oncontextmenu="return false;"
                            controlslist="nodownload nofullscreen noremoteplayback"
                            disablepictureinpicture>
                        </iframe>
                    `;
                    
                    // Add additional protection after iframe loads
                    setTimeout(() => {
                        addVideoProtection();
                    }, 1000);
                } else {
                    videoContainer.innerHTML = `
                        <div class="d-flex align-items-center justify-content-center bg-dark text-white">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
                                <p>Invalid video URL</p>
                                <small class="text-muted">Only YouTube and Vimeo videos are supported</small>
                            </div>
                        </div>
                    `;
                }
            }

            // Additional video protection measures
            function addVideoProtection() {
                // Disable right-click on video container
                const videoContainer = document.getElementById('videoContainer');
                if (videoContainer) {
                    videoContainer.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                        return false;
                    });

                    // Disable drag
                    videoContainer.addEventListener('dragstart', function(e) {
                        e.preventDefault();
                        return false;
                    });

                    // Disable text selection
                    videoContainer.style.userSelect = 'none';
                    videoContainer.style.webkitUserSelect = 'none';
                    videoContainer.style.mozUserSelect = 'none';
                    videoContainer.style.msUserSelect = 'none';
                }

                // Disable common download keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // Disable Ctrl+S (Save)
                    if (e.ctrlKey && e.keyCode === 83) {
                        e.preventDefault();
                        return false;
                    }
                    
                    // Disable Ctrl+A (Select All)
                    if (e.ctrlKey && e.keyCode === 65) {
                        e.preventDefault();
                        return false;
                    }
                    
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
                });
            }
        });
    </script>
@endsection
{{-- script section @E --}}
