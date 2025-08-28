@extends('layouts/latest/students')
@section('title', 'Course Overview ')

@php
    use Illuminate\Support\Str;
@endphp

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

@section('seo')
<meta name="keywords" content="{{ $course->categories . ', ' . $course->meta_keyword }}" />
<meta name="description" content="{{ $course->meta_description }}" itemprop="description">
@endsection

@section('content')
<main class="course-overview-page">
    <div class="overview-banner-box">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="banner-title">
                        <h1>{{ $course->title }}</h1>
                        <p>{{ $course->sub_title }}</p>

                        @if ($course->user)
                        <div class="media">
                            @if ($course->user && $course->user->avatar)
                            <img src="{{ asset($course->user->avatar) }}" alt="Place" class="img-fluid">
                            @else
                            <span class="user-name-avatar me-3">{!! strtoupper($course->user->name[0]) !!}</span>
                            @endif

                            <div class="media-body">
                                <h5>{{ $course->user->name }}</h5>
                                <h6 class="text-capitalize">{{ $course->user->user_role }}</h6>
                            </div>
                        </div>
                        @endif

                        {{-- course lesson duration calculation --}}
                        @php
                        $totalDurationMinutes = 0;
                        @endphp
                        @foreach ($course->modules->where('status', 'published') as $module)
                        @foreach ($module->lessons->where('status', 'published') as $lesson)
                        @php
                        $totalDurationMinutes += $lesson->duration;
                        @endphp
                        @endforeach
                        @endforeach

                        @php
                        $hours = floor($totalDurationMinutes / 3600);
                        $minutes = floor(($totalDurationMinutes % 3600) / 60);
                        @endphp
                        {{-- course lesson duration calculation --}}

                        <h4>
                            @if ($hours > 0)
                            {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                            @endif

                            {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }} to Complete . {{ $course->modules->where('status',
                            'published')->count(); }} Moduls in
                            Course

                            @if ($course->allow_review)
                            . {{ count($course_reviews) }} {{ count($course_reviews) > 1 ? 'Reviews' : 'Review' }}
                                @endif
                            </h4>

                        @if (isEnrolled($course->id))
                        <a href="{{ url('student/courses/' . $course->slug) }}" class="common-bttn"
                            style="border-radius: 6.25rem; margin-top: 2rem"><img
                                src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a"
                                class="img-fluid me-1"> Start Course</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-12 order-2 order-lg-1">
                <div class="what-you-learn-box">
                    <h3>What You'll Learn</h3>
                    @php
                    $objectives = explode('[objective]', $course->objective);
                    @endphp
                    <ul>
                        @foreach ($objectives as $object)
                        @if (trim($object) !== '')
                        <li><i class="fas fa-check"></i> {{ $object }} </li>
                        @else
                        <li>No Objective Found!</li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                <div class="common-header">
                    <h3 class="mb-0">Course Content</h3>
                </div>
                {{-- course outline --}}
                <div class="course-outline-wrap course-content">
                    <div class="accordion" id="accordionExample">
                        @foreach ($course->modules as $module)
                        @if ($module->status == 'published')
                        <div class="accordion-item">
                            <div class="accordion-header" id="heading_{{ $module->id }}">
                                <button class="accordion-button pb-0" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_{{ $module->id }}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <div class="d-flex">
                                        <p>{{ $module->title }}</p>
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </button>
                                {{-- lessons total minutes --}}
                                @php
                                $totalDuration = 0;

                                foreach ($module->lessons->where('status', 'published') as $lesson) {
                                if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                                $totalDuration += $lesson->duration;
                                }
                                }

                                $hours = floor($totalDuration / 3600);
                                $minutes = floor(($totalDuration % 3600) / 60);
                                @endphp

                                <p class="common-para mb-4">
                                    @if ($hours > 0)
                                    {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                    @endif
                                    {{ $minutes }} Min .
                                    {{ $module->lessons->where('status','published')->count() }} Lessons</p>
                                {{-- lessons total minutes --}}
                            </div>
                            <div id="collapse_{{ $module->id }}" class="accordion-collapse collapse "
                                aria-labelledby="heading_{{ $module->id }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    <ul class="lesson-wrap">
                                        @foreach ($module->lessons as $lesson)
                                        @if ($lesson->status == 'published')
                                        @php
                                        $totalDuration2 = 0;

                                        if (isset($lesson->duration) && is_numeric($lesson->duration) && $lesson->status
                                        == 'published') {
                                        $totalDuration2 += $lesson->duration;
                                        }

                                        $hours2 = floor($totalDuration2 / 3600);
                                        $minutes2 = floor(($totalDuration2 % 3600) / 60);
                                        @endphp

                                        <li>
                                            <a href="javascript:void(0)"
                                                class="video_list_play d-flex">
                                                <div>
                                                    <img src="{{ asset('assets/images/icons/lok.svg') }}" alt="a"
                                                        class="img-fluid me-2">
                                                    {{ $lesson->title }}
                                                </div>
                                                <p class="common-para">
                                                    @if ($lesson->type != 'text')
                                                    @if ($hours2 > 0)
                                                    {{ $hours2 }} {{ $hours2 > 1 ? 'Hours' : 'Hour' }}
                                                    @endif
                                                    {{ $minutes2 < 1 ? 1 : $minutes2 }} Min
                                                    @else
                                                    <i class="fa-regular fa-file-lines"></i>
                                                    @endif
                                                </p>
                                            </a>
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
                @if ($course->allow_review)
                <div class="common-header">
                    <h3 class="mb-0">Student Review's</h3>
                    <span>Total {{ count($course_reviews) }} Reviews</span>
                </div>
                <div class="row">
                    @if (count($course_reviews) > 0)
                    @foreach ($course_reviews as $course_review)
                    <div class="col-lg-6">
                        <div class="course-rev-box">
                            <div class="media">
                                @if ($course_review->user)
                                @if ($course_review->user->avatar)
                                <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar" class="img-fluid">
                                @else
                                <span class="user-name-avatar me-3">{!! strtoupper($course->user->name[0]) !!}</span>
                                @endif
                                @endif
                                <div class="media-body">
                                    <h5>{{ $course_review->user->name }}</h5>
                                    <h6>{{ \Carbon\Carbon::parse($course_review->created_at)->format('D, M d Y') }}</h6>
                                </div>
                            </div>
                            <p>{{ $course_review->comment }}</p>
                            <ul>
                                @for ($i = 0; $i < $course_review->star; $i++)
                                    <li><i class="fas fa-star"></i></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center">
                        <p>No Review Found!</p>
                    </div>
                    @endif
                </div>
                @endif
                @if (count($related_course) > 0)
                <div class="common-header">
                    <h3 class="mb-0">Similar Course</h3>
                </div>
                <div class="row">
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
                    {{-- course single box start --}}
                    <div class="col-lg-5 col-sm-6 mb-4">
                        <div class="course-single-item">
                            <div>
                                <div class="course-thumb-box">
                                    <img src="{{ asset($r_course->thumbnail) }}" alt="{{ $r_course->slug }}"
                                        class="img-fluid">
                                </div>
                                <div class="course-txt-box">
                                    @if (isEnrolled($r_course->id))
                                    <a href="{{ url('student/courses/my-courses/details/' . $r_course->slug) }}">
                                        {{ Str::limit($r_course->title, 45) }}</a>
                                    @else
                                    <a href="{{ url('student/courses/overview/' . $r_course->slug) }}">
                                        {{ Str::limit($r_course->title, 50) }}</a>
                                    @endif

                                    <p>{{ Str::limit($r_course->short_description, $limit = 46, $end = '...') }}
                                    </p>
                                    <ul>
                                        <li><span>{{ $review_avg }}</span></li>
                                        @for ($i = 0; $i < $review_avg; $i++) <li><i class="fas fa-star"></i></li>
                                            @endfor
                                            <li><span>({{ $total }})</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-txt-box">
                                @if ($r_course->offer_price)
                                <h5>৳ {{ $r_course->offer_price }} <span>৳ {{ $r_course->price }}</span>
                                </h5>
                                @elseif(!$r_course->offer_price && !$r_course->price)
                                <h5>Free</h5>
                                @else
                                <h5>৳ {{ $r_course->price }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- course single box end --}}
                    @endforeach
                </div>
                @endif
            </div>
            <div class="col-lg-4 col-12 order-1 order-lg-2 col-md-6">
                <div class="course-overview-right-part">
                    <div class="course-main-thumb">
                        @if ($course->thumbnail)
                        <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbnail" class="img-fluid">
                        @else
                        <iframe style="border-radius: 1rem" width="300" height="220"
                            src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                        @endif
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if ($course->offer_price)
                                <h2>৳ {{ $course->offer_price }}</h2>
                                @elseif(!$course->offer_price && $course->price)
                                <h2>৳ {{ $course->price }}</h2>
                                @else
                                <h2>Free</h2>
                                @endif
                            </div>
                            <button type="button" class="btn btn-preview" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Preview</button>
                        </div>

                        @if (!isEnrolled($course->id))
                            @php
                                $existingEnrollment = \App\Models\CourseEnrollment::where('course_id', $course->id)
                                    ->where('user_id', auth()->id())
                                    ->first();
                            @endphp
                            
                            @if(!$existingEnrollment)
                                <a href="{{ route('courses.enroll', $course->id) }}" class="btn enrol-bttn">
                                    <i class="fas fa-graduation-cap"></i> Enroll Now
                                </a>
                            @elseif($existingEnrollment->status === 'pending')
                                <button class="btn btn-warning" disabled>
                                    <i class="fas fa-clock"></i> Enrollment Pending Approval
                                </button>
                            @elseif($existingEnrollment->status === 'rejected')
                                <button class="btn btn-danger" disabled>
                                    <i class="fas fa-times"></i> Enrollment Rejected
                                </button>
                                @if($existingEnrollment->rejection_reason)
                                    <small class="text-danger d-block mt-1">Reason: {{ $existingEnrollment->rejection_reason }}</small>
                                @endif
                            @endif

                            <form
                                action="{{ route('cart.add', ['course' => $course->id, 'subdomain' => config('app.subdomain')]) }}"
                                method="POST">
                                @csrf
                                @if ($cartCourses->pluck('course_id')->contains($course->id))
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn add-cart-bttn bg-secondary text-white border-0"
                                        disabled>
                                        Already in cart</button>
                                    <button type="button" class="btn btn-heart {{ $liked }}" id="likeBttn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                                @else
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn add-cart-bttn">Add to Cart</button>
                                    <button type="button" class="btn btn-heart {{ $liked }}" id="likeBttn">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                                @endif
                            </form>
                            @endif
                    </div>
                    <div class="course-desc-txt">
                        <h4>Course Description</h4>
                        <p>{{ $course->short_description }}</p>
                    </div>
                    <div class="course-details-txt">
                        <h4>Course Details</h4>

                        <p><img src="{{ asset('assets/images/icons/users.svg') }}" alt="users" class="img-fluid">
                            {{ $courseEnrolledNumber }} Enrolled</p>
                        <p><img src="{{ asset('assets/images/icons/alerm.svg') }}" alt="users" class="img-fluid">
                            @if ($hours > 0)
                            {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                            @endif

                            {{ $minutes }}  {{ $hours > 1 ? 'Minute' : 'Minutes' }} to Completed</p>

                            <p><img src="{{ asset('assets/images/icons/carriculam.svg') }}" alt="users"
                                class="img-fluid">{{ $course->modules->where('status', 'published')->sum(function($module) { return $module->lessons->where('status', 'published')->count(); }) }} Lessons in {{ $course->modules->where('status', 'published')->count(); }} Modules</p>

                        {{-- <p><img src="{{ asset('assets/images/icons/carriculam.svg') }}" alt="users"
                                class="img-fluid"> {{ $course->curriculum ? $course->curriculum : 0 }} Curriculum</p> --}}
                        @if ($course->language)
                        <p><img src="{{ asset('assets/images/icons/english.svg') }}" alt="users"
                                class="img-fluid">
                            {{ $course->language }}</p>
                        @endif
                        @if ($course->platform)
                        <p><img src="{{ asset('assets/images/icons/platform.svg') }}" alt="platform"
                                class="img-fluid">
                            {{ $course->platform }}</p>
                        @endif
                        <p><img src="{{ asset('assets/images/icons/loop.svg') }}" alt="users" class="img-fluid">
                            Full Lifetime Access</p>
                        @if ($course->hascertificate)
                        <p><img src="{{ asset('assets/images/icons/trophy.svg') }}" alt="users"
                                class="img-fluid">
                            Certificate of Completion</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- overview tab modal start --}}
<div class="overview-modal-box">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="overview-box-wrap">
                        {{-- header --}}
                        <div class="media">
                            <div class="media-body">
                                <h5>Course Preview</h5>
                                <h4>{{ $course->title }}</h4>
                            </div>
                            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn">
                                <i class="fas fa-close"></i>
                            </button>
                        </div>
                        {{-- header --}}

                        {{-- intro video --}}
                        <div class="intro-video-box">
                            @if ($promo_video_link != '')
                            <iframe style="border-radius: 1rem" width="100%" height="320"
                                src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                            @else
                            <img src="{{ asset($course->thumbnail) }}" alt="Thumbnail" class="img-fluid d-block w-100">
                            @endif
                        </div>
                        {{-- intro video --}}

                        {{-- free sample video --}}
                        <div class="free-sample-video-list">
                            <h5 class="mb-4">Course Videos:</h5>

                            @foreach ($course->modules as $module)
                            @foreach ($module->lessons as $lesson)
                            @if ($lesson->type == 'video')
                            {{-- item --}}
                            <div class="media d-flex py-2">
                                <img src="{{ asset('assets/images/icons/icon-play.svg') }}" alt="video-thumb"
                                    class="img-fluid icon">
                                <div class="media-body">

                                    <p class="mt-0">{{ $lesson->title }}</p>
                                </div>
                                <img src="{{ asset('assets/images/icons/lok.svg') }}" alt="video-thumb"
                                    class="img-fluid icon">
                            </div>
                            {{-- item --}}
                            @endif
                            @endforeach
                            @endforeach

                        </div>
                        {{-- free sample video --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- overview tab modal end --}}

<style>
/* Fix Course Preview Modal Font Sizes */
#exampleModal .modal-body {
    font-size: 14px !important;
    line-height: 1.5;
}

#exampleModal .modal-body h1,
#exampleModal .modal-body h2,
#exampleModal .modal-body h3,
#exampleModal .modal-body h4,
#exampleModal .modal-body h5,
#exampleModal .modal-body h6 {
    font-size: 14px !important;
    font-weight: 600;
    margin-bottom: 8px;
}

#exampleModal .modal-body p,
#exampleModal .modal-body div,
#exampleModal .modal-body span {
    font-size: 14px !important;
    line-height: 1.4;
}

#exampleModal .modal-body .overview-box-wrap * {
    font-size: 14px !important;
}

/* Ensure Enroll Button is Visible and Properly Styled */
.enrol-bttn {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    margin: 10px 0 !important;
    padding: 12px 24px !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    text-decoration: none !important;
    border-radius: 5px !important;
    transition: all 0.3s ease !important;
    z-index: 10 !important;
    position: relative !important;
}

/* Ensure the button container has proper spacing */
.price-section {
    margin-bottom: 20px !important;
}

/* Fix button positioning issues */
.btn.enrol-bttn,
.btn.btn-warning,
.btn.btn-danger {
    width: 100% !important;
    max-width: 300px !important;
    margin: 15px 0 !important;
    clear: both !important;
    display: block !important;
}

/* Ensure proper spacing for enrollment status messages */
.text-danger.d-block {
    margin-top: 8px !important;
    font-size: 12px !important;
    padding: 5px 0 !important;
}

/* Override any conflicting styles that might hide buttons */
.overview-banner-box .btn {
    position: static !important;
    transform: none !important;
}
</style>

@endsection

{{-- js --}}
@section('script')
<script>
    let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');
        const likeBttn = document.getElementById('likeBttn');

        likeBttn.addEventListener('click', (e) => {

            const course_id = {{ $course->id }};
            console.log({
                course_id
            });
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
</script>

<script>
    const copyButton = document.getElementById("copyButton");
        const linkToCopy = document.getElementById("linkToCopy");
        const notify = document.getElementById("notify");

        copyButton.addEventListener("click", (e) => {
            e.preventDefault();
            linkToCopy.select();
            document.execCommand("copy");
            notify.innerText = 'Copied!';

            setTimeout(() => {
                notify.innerText = '';
            }, 1000);

        });
</script>

@endsection
{{-- js --}}
