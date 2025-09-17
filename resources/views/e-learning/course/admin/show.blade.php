@extends('layouts.latest.admin')
@section('title')
Course Details
@endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

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
                    <div class="video-iframe-vox">
                        @if (getFirstLesson($course->id))
                        <div class="video-iframe-vox">
                            <div class="vimeo-player w-100" id="firstLesson"
                                data-vimeo-url="{{ getFirstLesson($course->id)->video_link }}"
                                data-first-lesson-id="{{ getFirstLesson($course->id)->id }}"
                                data-first-course-id="{{ getFirstLesson($course->id)->course_id }}"
                                data-first-modules-id="{{ getFirstLesson($course->id)->module_id }}"
                                data-vimeo-width="1000" data-vimeo-height="360"></div>
                        </div>
                        @else
                        <div class="video-iframe-vox">
                            <div class="vimeo-player w-100" data-vimeo-url="https://vimeo.com/305108069"
                                data-vimeo-width="1000" data-vimeo-height="360"></div>
                        </div>
                        @endif
                    </div>
                    {{-- video player --}}

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

                    {{-- course title --}}
                    <div class="media course-title">
                        <div class="media-body">
                            <h1>{{ $course->title }}</h1>
                            <p class="text-capitalize">{{ $course->user->name }} . {{ $course->user->user_role }}</p>
                        </div>
                        {{-- <a href="#">
                            <img src="{{ asset('assets/images/icons/favorit.svg') }}" alt="clock" title="12:00"
                                class="img-fluid">
                        </a> --}}
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

                    {{-- course review --}}
                    @if ($course->allow_review)
                    <div class="course-review-wrap">
                        <h3>{{ count($course_reviews) }} Reviews</h3>
                        @if (count($course_reviews) > 0)
                        @foreach ($course_reviews as $course_review)
                        <div class="media">
                            @if ($course_review->user && $course_review->user->avatar)
                            <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar" class="img-fluid">
                            @else
                            <span class="user-name-avatar me-3">{!! strtoupper($course_review->user->name[0]) !!}</span>
                            @endif

                            <div class="media-body">
                                <h5>{{ $course_review->user->name }}</h5>
                                <ul>
                                    @for ($i = 0; $i < $course_review->star; $i++)
                                        <li><i class="fas fa-star"></i></li>
                                        @endfor
                                </ul>
                                <p>{{ $course_review->comment }}</p>
                                {{-- <small>{{ $course_review->created_at->diffForHumans() }}</small> --}}

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
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                {{-- course outline --}}
                <div class="course-outline-wrap  course-modules-lessons-redesign">
                    <div class="header">
                        <h3>Modules</h3>
                        <h6>{{ $totalModules }} Modules . {{ $totalLessons }} Lessons</h6>
                    </div>
                    <div class="accordion" id="accordionExample">
                        @foreach ($course->modules->where('status','published') as $module)
                        @if (count($module->lessons) > 0 || $module->status == 'published')
                        <div class="accordion-item">
                            <div class="accordion-header" id="heading_{{ $module->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{ $module->id }}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <div class="d-flex">
                                        <p class="module-title"><i class="fas fa-check-circle"></i> {{ $module->title }}
                                        </p>
                                    </div>
                                </button>
                            </div>
                            <div id="collapse_{{ $module->id }}" class="accordion-collapse collapse
                                {{ $currentLesson && $currentLesson->module_id == $module->id ? 'show' : '' }}"
                                aria-labelledby="heading_{{ $module->id }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <ul class="lesson-wrap">
                                        @foreach ($module->lessons as $lesson)
                                        @if ($lesson->status == 'published' && now()->diffInMinutes($lesson->updated_at)
                                        > 10)
                                        <li>
                                            <div class="d-flex align-items-center">
                                                @can('instructor')
                                                <a
                                                    href="{{ url('instructor/courses/create/'.$course->id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}">
                                                    <i class="fa-regular fa-pen-to-square me-2"
                                                        style="color: #A6B1C4"></i>
                                                </a>
                                                @endcan

                                                <a href="{{ $lesson->video_link }}"
                                                    class="video_list_play d-inline-block {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}"
                                                    data-video-id="{{ $lesson->id }}" data-lesson-id="{{ $lesson->id }}"
                                                    data-course-id="{{ $course->id }}"
                                                    data-modules-id="{{ $module->id }}"
                                                    data-audio-url="{{ $lesson->audio }}"
                                                    data-lesson-type="{{ $lesson->type }}"
                                                    style="font-size: 0.8rem!important">

                                                    @if ($lesson->type == 'text')
                                                    <i class="fa-regular fa-file-lines actv-hide"
                                                        style="color: #2F3A4C"></i>
                                                    <img src="{{ asset('assets/images/icons/pause.svg') }}"
                                                        alt="i" class="img-fluid actv-show" style="width: 1rem;">
                                                    @elseif($lesson->type == 'audio')
                                                    <i class="fa-solid fa-headphones actv-hide"
                                                        style="color: #2F3A4C"></i>
                                                    <img src="{{ asset('assets/images/icons/pause.svg') }}"
                                                        alt="i" class="img-fluid actv-show" style="width: 1rem;">
                                                    @elseif($lesson->type == 'video')
                                                    <img src="{{ asset('assets/images/icons/play-icon.svg') }}"
                                                        alt="i" class="img-fluid actv-hide" style="width: 0.8rem;">
                                                    <img src="{{ asset('assets/images/icons/pause.svg') }}"
                                                        alt="i" class="img-fluid actv-show" style="width: 1rem;">
                                                    @endif

                                                    {{ $lesson->title }}
                                                </a>
                                            </div>
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
                        <div class="col-md-6 col-12 col-lg-12 col-xl-12 mt-15">
                            {{-- item --}}
                            <div class="course-single-item">
                                <div class="course-thumb-box">
                                    @if ($relatedCourse->thumbnail)
                                    <img src="{{ asset($relatedCourse->thumbnail) }}" alt="Course Thumbnail"
                                        class="img-fluid">
                                    @else
                                    <img src="{{ asset('assets/images/courses/thumbnail.png') }}"
                                        alt="Course Thumbnail" class="img-fluid">
                                    @endif
                                </div>
                                <div class="course-txt-box">
                                    <a href="{{ url('admin/courses/'.$relatedCourse->slug.'/show') }}">{{
                                        $relatedCourse->title }}</a>
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
                                        @for ($i = 0; $i < $review_avg; $i++) <li><i class="fas fa-star"></i></li>
                                            @endfor
                                            <li><span>({{ $total }})</span></li>
                                    </ul>
                                    @if ($relatedCourse->offer_price)
                                    <h5>৳{{ $relatedCourse->offer_price }} <span>৳ {{ $relatedCourse->price }}</span>
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
{{-- course details page @E --}}
@endsection

{{-- script section @S --}}
@section('script')
<script src="https://player.vimeo.com/api/player.js"></script>
<script>
    $(document).ready(function() {
        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');

            var firstLessonId = $('#firstLesson').data('first-lesson-id');
            var firstCourseId = $('#firstLesson').data('first-course-id');
            var firstModuleId = $('#firstLesson').data('first-modules-id');
            var data = {
                courseId: firstCourseId,
                lessonId: firstLessonId,
                moduleId: firstModuleId
            };
            $.ajax({
                url: '{{ route('admin.log.courses') }}',
                method: 'GET',
                data: data,
                success: function(response) {
                },
                error: function(xhr, status, error) {
                    // Handle errors, if any
                }
            });


            var options = {
                id: {{ $currentLessonVideo ?? 305108069 }},
                autoplay: true,
                // loop: true,
                width: 500,
            };
            var player = new Vimeo.Player(document.querySelector('.vimeo-player'), options);
            player.on('ended', function() {
                // $('.is_complete_lesson').click();
                $('a.video_list_play.active').parent().next().find('a.video_list_play').click();
            });


            $('a.video_list_play').click(function(e) {
                e.preventDefault();

                $('a.video_list_play').removeClass('active');
                $(this).addClass('active');

                let type = this.getAttribute('data-lesson-type');

                if(type == 'video'){
                    document.querySelector('#hideShow').classList.add('d-none');
                    document.querySelector('.video-iframe-vox').classList.remove('d-none');
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    // document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download Files';
                    document.getElementById('dataTextContainer').innerHTML = '';
                    audioPlayer.pause();

                    var videoId = $(this).data('video-id');
                    var videoUrl = $(this).attr('href');
                    videoUrl = videoUrl.replace('/videos/', '');
                    player.loadVideo(videoUrl);

                }else if(type == 'audio'){
                    document.querySelector('#hideShow').classList.add('d-none');
                    player.pause();
                    document.querySelector('.audio-iframe-box').classList.remove('d-none');
                    document.querySelector('.video-iframe-vox').classList.add('d-none');
                    var laravelURL = baseUrl +'/'+ this.getAttribute('data-audio-url');
                    let audioPlayer = document.getElementById('audioPlayer');
                    let audioSource = audioPlayer.querySelector('source');
                    audioSource.src = laravelURL;
                    audioPlayer.load();
                    audioPlayer.play();
                    // document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download Files';
                    document.getElementById('dataTextContainer').innerHTML = '';

                }else if(type == 'text'){
                    player.pause();
                    audioPlayer.pause();
                    document.querySelector('#hideShow').classList.remove('d-none');
                    document.querySelector('.audio-iframe-box').classList.add('d-none');
                    document.querySelector('.video-iframe-vox').classList.add('d-none');
                    // document.querySelector('.download-files-box').querySelector('h4').innerText = 'Download all course materials';

                    let lessonId =  this.getAttribute('data-lesson-id')

                    fetch(`${baseUrl}/student/lessons/${lessonId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                         document.getElementById('dataTextContainer').innerHTML = data.text;

                    })
                    .catch(error => {
                        // console.error(error);
                    });

                }

            });

        });
</script>
@endsection
{{-- script section @E --}}
