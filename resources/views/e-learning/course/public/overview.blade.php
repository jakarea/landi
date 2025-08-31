@extends('layouts/latest/students')
@section('title', $title)


{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}
@php
    use Illuminate\Support\Str;
@endphp
@section('seo')
    <meta name="keywords" content="{{ $course->categories . ', ' . $course->meta_keyword }}" />
    <meta name="description" content="{{ $course->meta_description }}" itemprop="description">
@endsection

@section('content')
    <main class="course-overview-page">
        <div class="overview-banner-box"
            style="background-image: url({{ asset('assets/images/courseds/' . $course->banner) }});">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="banner-title">
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $course->sub_title }}</p>

                            @if ($course->user)
                                <div class="media">
                                    @if ($course->user->avatar)
                                        <img src="{{ asset($course->user->avatar) }}" alt="Place" class="img-fluid">
                                    @else
                                        <span class="user-name-avatar me-1">{!! strtoupper($course->user->name[0]) !!}</span>
                                    @endif
                                    <div class="media-body">
                                        <h5>{{ $course->user->name }}</h5>
                                        <h6 class="text-capitalize">{{ $course->user->user_role }}</h6>
                                    </div>
                                </div>
                            @endif

                            {{-- Use controller-calculated data with comprehensive fallbacks --}}
                            @php
                                // Use controller data if available, otherwise calculate here
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
                                        // Include all modules - don't filter by status for now
                                        $modulesCount++;
                                        
                                        foreach ($module->lessons as $lesson) {
                                            // Include all lessons
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
                                        // Assume average 5 minutes per lesson
                                        $estimatedMinutes = $lessonsCount * 5;
                                        $hours = floor($estimatedMinutes / 60);
                                        $minutes = $estimatedMinutes % 60;
                                    }
                                } else {
                                    // Use controller data but ensure fallbacks for counts
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

                            <h4>@if ($hours > 0)
                                    {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                @endif

                            {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }} to Complete . {{ $modulesCount }} Module{{ $modulesCount != 1 ? 's' : '' }} {{$lessonsCount }} lessons in Course.

                                @if ($course->allow_review)
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= 4 ? '#ffc107' : '#e0e0e0' }}"></i>
                                    @endfor
                                <span class="rating-text"> ({{ count($course_reviews) }})</span>
                      
                                @endif
                            </h4>

                            @auth
                                @if(auth()->user()->user_role === 'student')
                                    @if(isEnrolled($course->id))
                                        <a href="{{ url('student/courses/' . $course->slug) }}" class="common-bttn"
                                            style="border-radius: 6.25rem; margin-top: 2rem"><img
                                                src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a"
                                                class="img-fluid me-1">Start Course</a>
                                    @else
                                        @php
                                            $existingEnrollment = \App\Models\CourseEnrollment::where('course_id', $course->id)
                                                ->where('user_id', auth()->id())
                                                ->first();
                                        @endphp
                                        
                                        @if(!$existingEnrollment)
                                            <a href="{{ route('courses.enroll', $course->slug) }}" class="common-bttn"
                                                style="border-radius: 6.25rem; margin-top: 2rem"><img
                                                    src="{{ asset('assets/images/icons/graduation-cap.svg') }}" alt="a"
                                                    class="img-fluid me-1">Enroll Now</a>
                                        @elseif($existingEnrollment->status === 'pending')
                                            <button class="common-bttn" disabled
                                                style="border-radius: 6.25rem; margin-top: 2rem; background-color: #ffc107; border-color: #ffc107;"><img
                                                    src="{{ asset('assets/images/icons/clock.svg') }}" alt="a"
                                                    class="img-fluid me-1">Enrollment Pending</button>
                                        @elseif($existingEnrollment->status === 'rejected')
                                            <button class="common-bttn" disabled
                                                style="border-radius: 6.25rem; margin-top: 2rem; background-color: #dc3545; border-color: #dc3545;"><img
                                                    src="{{ asset('assets/images/icons/times.svg') }}" alt="a"
                                                    class="img-fluid me-1">Enrollment Rejected</button>
                                            @if($existingEnrollment->rejection_reason)
                                                <small class="text-danger d-block mt-2">Reason: {{ $existingEnrollment->rejection_reason }}</small>
                                            @endif
                                        @endif
                                    @endif
                                @elseif(auth()->user()->user_role === 'instructor')
                                    <a href="{{ url('instructor/courses/' . $course->id) }}" class="common-bttn"
                                        style="border-radius: 6.25rem; margin-top: 2rem"><img
                                            src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a"
                                            class="img-fluid me-1">Manage Course</a>
                                @else
                                    <a href="{{ route('login') }}" class="common-bttn"
                                        style="border-radius: 6.25rem; margin-top: 2rem"><img
                                            src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a"
                                            class="img-fluid me-1">Login to Access</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="common-bttn"
                                    style="border-radius: 6.25rem; margin-top: 2rem"><img
                                        src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a"
                                        class="img-fluid me-1">Login to Access</a>
                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-12 order-2 order-lg-1">
                    <div class="white-block">
                        <p class="mb-2 fw-semibold">{{ strtoupper($course->user->name) }}</p>
                        <p>{!! $course->user->description !!}</p>
                        
                    </div>

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
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="heading_{{ $module->id }}">
                                            <button class="accordion-button pb-0" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse_{{ $module->id }}" aria-expanded="false"
                                                aria-controls="collapse_{{ $module->id }}">
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-0 fw-semibold" style="font-size: 0.95rem;">{{ $module->title }}
                                                            {{ $module->checkNumber() ? ' - Module ' . $loop->iteration : '' }}
                                                        </p>
                                                        <i class="fas fa-angle-down"></i>
                                                    </div>
                                                    {{-- lessons total minutes --}}
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

                                                    <p class="common-para mb-0 mt-2 text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        @if ($hours3 > 0)
                                                            {{ $hours3 }} {{ $hours3 > 1 ? 'Hours' : 'Hour' }}
                                                        @endif
                                                        {{ $minutes3 }} Min • 
                                                        <i class="fas fa-list me-1"></i>
                                                        {{ $lessonCount }} {{ $lessonCount > 1 ? 'Lessons' : 'Lesson' }}
                                                    </p>
                                                    {{-- lessons total minutes --}}
                                                </div>
                                            </button>
                                        </div>
                                        <div id="collapse_{{ $module->id }}" class="accordion-collapse collapse "
                                            aria-labelledby="heading_{{ $module->id }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body p-0">
                                                <ul class="lesson-wrap">
                                                    @foreach ($module->lessons as $lesson)
                                                        @php
                                                            // Calculate lesson duration
                                                            $totalDuration2 = 0;
                                                            if (isset($lesson->duration) && is_numeric($lesson->duration)) {
                                                                $totalDuration2 += $lesson->duration;
                                                            }
                                                            $hours2 = floor($totalDuration2 / 3600);
                                                            $minutes2 = floor(($totalDuration2 % 3600) / 60);
                                                            
                                                            // Check lesson access
                                                            $isPublic = isset($lesson->is_public) && $lesson->is_public;
                                                            $publishAt = isset($lesson->publish_at) ? \Carbon\Carbon::parse($lesson->publish_at) : null;
                                                            $isFuture = $publishAt && $publishAt->isFuture();
                                                            $canAccess = $isPublic || auth()->check();
                                                        @endphp

                                                        <li>
                                                            <div class="media d-flex py-2 {{ $isPublic ? 'public-lesson-item' : 'locked-lesson-item' }}" 
                                                                 @if($isPublic && $lesson->type == 'video') 
                                                                    data-lesson-id="{{ $lesson->id }}" 
                                                                    data-lesson-title="{{ $lesson->title }}"
                                                                    data-video-type="{{ $lesson->video_type }}"
                                                                    data-video-link="{{ $lesson->video_link }}"
                                                                    style="cursor: pointer;"
                                                                 @endif>
                                                                <img src="{{ asset('assets/images/icons/icon-play.svg') }}"
                                                                    alt="video-thumb" class="img-fluid icon">
                                                                <div class="media-body">
                                                                    <p class="mt-0 mb-1">{{ $lesson->title }}
                                                                        @if ($isPublic)
                                                                            <small class="badge bg-success ms-2">Free</small>
                                                                        @endif
                                                                        @if ($isFuture)
                                                                            <small class="badge bg-info ms-2">Scheduled</small>
                                                                        @endif
                                                                    </p>
                                                                    @if ($isFuture)
                                                                        <small class="text-muted d-block">Available {{ $publishAt->format('M d, Y') }}</small>
                                                                    @elseif ($lesson->type != 'text' && ($hours2 > 0 || $minutes2 > 0))
                                                                        <small class="text-muted d-block">
                                                                            @if ($hours2 > 0)
                                                                                {{ $hours2 }} {{ $hours2 > 1 ? 'Hours' : 'Hour' }}
                                                                            @endif
                                                                            {{ $minutes2 < 1 ? 1 : $minutes2 }} Min
                                                                        </small>
                                                                    @endif
                                                                </div>
                                                                @if (!$isPublic)
                                                                    <img src="{{ asset('assets/images/icons/lok.svg') }}"
                                                                        alt="video-thumb" class="img-fluid icon">
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <img src="{{ asset($course_review->user->avatar) }}" alt="Avatar"
                                                        class="img-fluid">
                                                @else
                                                    <span class="user-name-avatar me-3">{!! strtoupper($course->user->name[0]) !!}</span>
                                                @endif
                                            @endif

                                            <div class="media-body">
                                                <h5>{{ $course_review->user->name }}</h5>
                                                <h6>{{ \Carbon\Carbon::parse($course_review->created_at)->format('D, M d Y') }}
                                                </h6>
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
                                                <img src="{{ $r_course->thumbnail ? asset($r_course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="{{ $r_course->slug }}"
                                                    class="img-fluid">
                                            </div>
                                            <div class="course-txt-box">
                                                <a href="{{ url('courses/' . $r_course->slug) }}">
                                                    {{ Str::limit($r_course->title, 45) }}</a>

                                                <p>{{ Str::limit($r_course->short_description, $limit = 46, $end = '...') }}
                                                </p>
                                                <ul>
                                                    <li><span>{{ $review_avg }}</span></li>
                                                    @for ($i = 0; $i < $review_avg; $i++)
                                                        <li><i class="fas fa-star"></i></li>
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
                            @if ($promo_video_link != '')
                                <iframe style="border-radius: 1rem" width="300" height="220"
                                    src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                            @else
                                <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="" class="img-fluid">
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
                                    data-bs-target="#coursePreviewModal">Preview</button>
                            </div>

                            <button type="button" class="btn enrol-bttn btn-share" data-bs-toggle="modal"
                                data-bs-target="#exampleModal2"><img
                                    src="{{ asset('assets/images/icons/share.svg') }}" alt="a"
                                    class="img-fluid me-2" style="width: 1.5rem"> Share this course</button>

                        </div>
                        <div class="course-desc-txt">
                            <h4>Course Description</h4>
                            <p>{!! $course->short_description !!}</p>
                        </div>
                        <div class="course-details-txt">
                            <h4>Course Summary</h4>
                            
                            {{-- Course Statistics --}}
                            <div class="course-stats mb-3">
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-users me-2" style="color: #007bff; width: 20px;"></i>
                                    <span><strong>{{ $courseEnrolledNumber }}</strong> Students Enrolled</span>
                                </div>
                                
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #28a745; width: 20px;"></i>
                                    <span><strong>
                                        @if ($hours > 0)
                                            {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                        @endif
                                        @if ($minutes > 0)
                                            {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }}
                                        @else
                                            {{ $lessonsCount > 0 ? ($lessonsCount * 5) . ' Minutes (estimated)' : '0 Minutes' }}
                                        @endif
                                    </strong> Total Duration</span>
                                </div>

                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-list-ul me-2" style="color: #17a2b8; width: 20px;"></i>
                                    <span><strong>{{ $lessonsCount }} Lesson{{ $lessonsCount != 1 ? 's' : '' }}</strong> in <strong>{{ $modulesCount }} Module{{ $modulesCount != 1 ? 's' : '' }}</strong></span>
                                </div>

                                @if ($course->language)
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-language me-2" style="color: #6c757d; width: 20px;"></i>
                                    <span>Language: <strong>{{ $course->language }}</strong></span>
                                </div>
                                @endif

                                @if ($course->platform)
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-desktop me-2" style="color: #fd7e14; width: 20px;"></i>
                                    <span>Platform: <strong>{{ $course->platform }}</strong></span>
                                </div>
                                @endif

                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-infinity me-2" style="color: #6f42c1; width: 20px;"></i>
                                    <span><strong>Full Lifetime Access</strong></span>
                                </div>

                                @if ($course->hascertificate)
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-certificate me-2" style="color: #ffc107; width: 20px;"></i>
                                    <span><strong>Certificate of Completion</strong></span>
                                </div>
                                @endif

                                {{-- Course Level --}}
                                @if ($course->level)
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-layer-group me-2" style="color: #e83e8c; width: 20px;"></i>
                                    <span>Level: <strong>{{ ucfirst($course->level) }}</strong></span>
                                </div>
                                @endif

                                {{-- Last Updated --}}
                                @if ($course->updated_at)
                                <div class="stat-item d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt me-2" style="color: #20c997; width: 20px;"></i>
                                    <span>Updated: <strong>{{ \Carbon\Carbon::parse($course->updated_at)->format('M Y') }}</strong></span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- overview tab modal start --}}
    <div class="overview-modal-box">
        <div class="modal fade" id="coursePreviewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="overview-box-wrap">
                            {{-- header --}}
                            <div class="media">
                                <div class="media-body">
                                    <h5>Course Preview</h5>
                                    <h6>{{ $course->title }}</h6>
                                </div>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn">
                                    <i class="fas fa-close"></i>
                                </button>
                            </div>
                            {{-- header --}}

                            {{-- intro video --}}
                            <div class="intro-video-box">
                                @if ($promo_video_link != '')
                                    <iframe class="youtubePlayer" style="border-radius: 1rem" width="100%"
                                        height="320"
                                        src="https://www.youtube-nocookie.com/embed/{{ $promo_video_link }}"></iframe>
                                @else
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" alt="Thumbnail"
                                        class="img-fluid d-block w-100">
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
                                            <div class="media d-flex py-2 {{ $lesson->is_public ? 'public-lesson-item' : 'locked-lesson-item' }}" 
                                                 @if($lesson->is_public) 
                                                    data-lesson-id="{{ $lesson->id }}" 
                                                    data-lesson-title="{{ $lesson->title }}"
                                                    data-video-type="{{ $lesson->video_type }}"
                                                    data-video-link="{{ $lesson->video_link }}"
                                                    style="cursor: pointer;"
                                                 @endif>
                                                <img src="{{ asset('assets/images/icons/icon-play.svg') }}"
                                                    alt="video-thumb" class="img-fluid icon">
                                                <div class="media-body">
                                                    <p class="mt-0">{{ $lesson->title }}
                                                        @if ($lesson->is_public)
                                                            <small class="badge bg-success ms-2">Free</small>
                                                        @endif
                                </p>
                                                </div>
                                                @if (!$lesson->is_public)
                                                    <img src="{{ asset('assets/images/icons/lok.svg') }}"
                                                        alt="video-thumb" class="img-fluid icon">
                                                @endif
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

    {{-- Public Lesson Video Player Modal --}}
    <div class="modal fade" id="publicLessonModal" tabindex="-1" aria-labelledby="publicLessonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="publicLessonModalLabel">Lesson Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="publicLessonVideoContainer">
                        {{-- Video content will be inserted here by JavaScript --}}
                    </div>
                    <div class="mt-3">
                        <p><strong>Note:</strong> This is a free preview lesson. <a href="#" class="btn btn-primary btn-sm ms-2">Enroll Now</a> to access all course content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Public Lesson Video Player Modal End --}}

    {{-- share course modal --}}
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="share-on-social-wrap mt-0">
                    <h4>Share</h4>
                    <h6>As a post</h6>
                    <div class="d-flex">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('courses/overview-courses', $course->slug) }}"
                            target="_blank">
                            <img src="{{ asset('assets/images/icons/fb.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>Facebook</span>
                        </a>
                        <a href="#">
                            <img src="{{ asset('assets/images/icons/tg.svg') }}" alt="TG"
                                class="img-fluid">
                            <span>Telegram</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ url('courses/overview-courses', $course->slug) }}"
                            target="_blank">
                            <img src="{{ asset('assets/images/icons/linkedin-ic.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>LinkedIn</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url('courses/overview-courses', $course->slug) }}&text={{ $course->title }}"
                            target="_blank"> <img src="{{ asset('assets/images/icons/twt.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>Twitter</span>
                        </a>
                    </div>
                    <h6>As a message</h6>
                    <div class="d-flex">
                        <a
                            href="https://www.messenger.com/share.php?text={{ url('courses/overview-courses', $course->slug) }}">
                            <img src="{{ asset('assets/images/icons/messenger.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>Messenger</span>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ url('courses/overview-courses', $course->slug) }}">
                            <img src="{{ asset('assets/images/icons/wapp.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>Whatsapp</span>
                        </a>
                        <a href="https://telegram.me/share/url?url={{ url('courses/overview-courses', $course->slug) }}">
                            <img src="{{ asset('assets/images/icons/teleg.svg') }}" alt="FB"
                                class="img-fluid">
                            <span>Telegram</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <h6>Or copy link</h6>
                        <span id="notify" style="color: green; font-size: 14px;"></span>
                    </div>
                    <div class="copy-link">
                        <input autocomplete="off" type="text" placeholder="Link"
                            value="{{ url('courses/overview-courses', $course->slug) }}" class="form-control"
                            id="linkToCopy">
                        <a href="#" id="copyButton" class="ms-1 px-0">Copy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- share course modal --}}

@endsection

{{-- js --}}
@section('script')
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

    {{-- Public Lesson Video Player Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle public lesson clicks
            const publicLessonItems = document.querySelectorAll('.public-lesson-item');
            const publicLessonModal = new bootstrap.Modal(document.getElementById('publicLessonModal'));
            const videoContainer = document.getElementById('publicLessonVideoContainer');
            const modalTitle = document.getElementById('publicLessonModalLabel');
            
            publicLessonItems.forEach(item => {
                item.addEventListener('click', function() {
                    const lessonTitle = this.getAttribute('data-lesson-title');
                    const videoType = this.getAttribute('data-video-type');
                    const videoLink = this.getAttribute('data-video-link');
                    
                    // Set modal title
                    modalTitle.textContent = lessonTitle;
                    
                    // Clear previous video content
                    videoContainer.innerHTML = '';
                    
                    // Create video player based on type
                    if (videoType === 'youtube' || videoLink.includes('youtube.com') || videoLink.includes('youtu.be')) {
                        // Handle YouTube videos
                        let youtubeId = '';
                        if (videoLink.includes('watch?v=')) {
                            youtubeId = videoLink.split('watch?v=')[1].split('&')[0];
                        } else if (videoLink.includes('youtu.be/')) {
                            youtubeId = videoLink.split('youtu.be/')[1].split('?')[0];
                        } else if (videoLink.includes('/embed/')) {
                            youtubeId = videoLink.split('/embed/')[1].split('?')[0];
                        }
                        
                        if (youtubeId) {
                            videoContainer.innerHTML = `
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/${youtubeId}?autoplay=1" 
                                            title="${lessonTitle}" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            `;
                        } else {
                            videoContainer.innerHTML = '<p class="text-danger">Invalid YouTube video URL</p>';
                        }
                    } else if (videoType === 'vimeo' || videoLink.includes('vimeo.com')) {
                        // Handle Vimeo videos  
                        let vimeoId = '';
                        if (videoLink.includes('vimeo.com/')) {
                            vimeoId = videoLink.split('vimeo.com/')[1].split('/')[0];
                        }
                        
                        if (vimeoId) {
                            videoContainer.innerHTML = `
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://player.vimeo.com/video/${vimeoId}?autoplay=1" 
                                            title="${lessonTitle}" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            `;
                        } else {
                            videoContainer.innerHTML = '<p class="text-danger">Invalid Vimeo video URL</p>';
                        }
                    } else {
                        // Handle direct video files
                        if (videoLink && videoLink !== '') {
                            videoContainer.innerHTML = `
                                <video controls class="w-100" style="border-radius: 0.375rem;">
                                    <source src="${videoLink}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            `;
                        } else {
                            videoContainer.innerHTML = '<p class="text-warning">Video not available</p>';
                        }
                    }
                    
                    // Show the modal
                    publicLessonModal.show();
                });
            });
            
            // Clean up video when modal is closed
            document.getElementById('publicLessonModal').addEventListener('hidden.bs.modal', function() {
                videoContainer.innerHTML = '';
            });
        });
    </script>

    {{-- Video Popup Script --}}
    <script>
        $(document).ready(function() {
            // Video popup functionality
            $('.lesson-playable').click(function(e) {
                e.preventDefault();
                
                const videoUrl = $(this).data('video-url');
                const lessonType = $(this).data('lesson-type');
                const lessonTitle = $(this).find('.flex-grow-1').text().trim();
                
                if (!videoUrl || (lessonType !== 'video' && lessonType !== 'audio')) {
                    return;
                }
                
                // Detect video platform and create embed URL with download protection
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
                    // Create and show popup modal with video protection
                    const modalHtml = `
                        <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">${lessonTitle}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="ratio ratio-16x9">
                                            <iframe 
                                                src="${embedUrl}" 
                                                frameborder="0"
                                                allowfullscreen 
                                                allow="autoplay"
                                                oncontextmenu="return false;"
                                                controlslist="nodownload nofullscreen noremoteplayback"
                                                disablepictureinpicture
                                                style="pointer-events: auto; user-select: none;">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove existing modal if any
                    $('#videoModal').remove();
                    
                    // Add modal to body and show
                    $('body').append(modalHtml);
                    $('#videoModal').modal('show');
                    
                    // Add video protection after modal is shown
                    $('#videoModal').on('shown.bs.modal', function() {
                        addVideoProtectionToModal();
                    });
                    
                    // Clean up when modal is closed
                    $('#videoModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });
                } else {
                    // Show error for unsupported video formats
                    const modalHtml = `
                        <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Invalid Video</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                        <h4>Invalid video URL</h4>
                                        <p class="text-muted">Only YouTube and Vimeo videos are supported.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove existing modal if any
                    $('#videoModal').remove();
                    
                    // Add modal to body and show
                    $('body').append(modalHtml);
                    $('#videoModal').modal('show');
                    
                    // Clean up when modal is closed
                    $('#videoModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });
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
{{-- js --}}
