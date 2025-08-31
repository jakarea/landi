@extends('layouts/latest/students')
@section('title')
    My Course Details
@endsection
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
    <meta name="keywords" content="{{ ($course->categories ?? '') . ', ' . ($course->meta_keyword ?? '') }}" />
    <meta name="description" content="{{ $course->meta_description ?? '' }}" itemprop="description">
@endsection

@section('content')
    <main class="course-overview-page">
        <div class="overview-banner-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-8">
                        <div class="banner-title">
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $course->sub_title ?? '' }}</p>

                            @if ($course->user)
                                <div class="media">
                                    @if ($course->user && $course->user->avatar)
                                        <img src="{{ asset( $course->user->avatar) }}" alt="Place" class="img-fluid">
                                    @else
                                    <span class="user-name-avatar me-3">{!! strtoupper($course->user->name[0]) !!}</span>
                                    @endif
                                    <div class="media-body">
                                        <h5>{{ $course->user->name }}</h5>
                                        <h6>Instructor</h6>
                                    </div>
                                </div>
                            @endif

                            {{-- course lesson duration calculation --}}
                            @php
                                $totalDurationMinutes = 0;
                            @endphp
                            @if($course->modules)
                                @foreach ($course->modules as $module)
                                    @if($module->lessons)
                                        @foreach ($module->lessons as $lesson)
                                        @php
                                        $totalDurationMinutes += $lesson->duration ?? 0;
                                        @endphp
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif

                            @php
                                // Convert seconds to hours and minutes
                                $hours = floor($totalDurationMinutes / 3600);
                                $minutes = floor(($totalDurationMinutes % 3600) / 60);
                            @endphp
                            {{-- course lesson duration calculation --}}

                            <h4>@if ($hours > 0)
                                {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                            @endif

                            {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }} to Complete . {{ $course->modules ? $course->modules->count() : 0 }} Modules in
                                Course

                                @if ($course->allow_review)
                                   . {{ count($course_reviews) }} {{ count($course_reviews) > 1 ? 'Reviews' : 'Review' }}
                                @endif
                            </h4>

                            <a href="{{ url('student/courses/' . $course->slug.'/learn') }}" class="common-bttn"
                                style="border-radius: 6.25rem; margin-top: 2rem"><img src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a" class="img-fluid me-1"> Start Learning</a>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="overall-progress">
                            <h6>Overall Progress</h6>
                            <div class="circle-prog-big">
                                <div class="cards">
                                    <div class="percent">

                                        @php
                                        $totalLessons = 0;
                                        $completedLessons = 0;
                                    @endphp
                                    @if($course->modules)
                                        @foreach ($course->modules as $module)
                                            @php
                                                $totalLessons += $module->lessons ? count($module->lessons) : 0;
                                                $completedLessons += $module->lessons ? $module->lessons->where('completed', 1)->count() : 0;
                                            @endphp
                                        @endforeach
                                    @endif

                                        @php
                                        $totalPorgressPercent = StudentActitviesProgress(auth()->user()->id, $course->id);
                                        $showPercentage = null;

                                        if($totalPorgressPercent > 95 && $totalPorgressPercent < 100){
                                            $showPercentage = $totalPorgressPercent - 2;
                                        }
                                        @endphp
                                        @php
                                            $percentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                                        @endphp
                                        <svg>
                                            <circle cx="73" cy="73" r="65"></circle>
                                            <circle cx="73" cy="73" r="65"
                                                style="--percent: {{ $percentage }}">
                                            </circle>
                                        </svg>



                                        <div class="number">
                                            <h5>{{ $percentage }}<span>%</span>
                                            </h5>
                                            <p>{{ $completedLessons }}/{{ $totalLessons }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="course-description-box">
                        <h4>Course Description</h4>
                        {!! $course->description !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="course-details">
                        <h4>Course Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <p><img src="{{asset('assets/images/icons/users.svg')}}" alt="users"
                                    class="img-fluid"> {{ $courseEnrolledNumber }} Enrolled</p>

                                    <p><img src="{{ asset('assets/images/icons/alerm.svg') }}" alt="users"
                                        class="img-fluid">
                                        @if ($hours > 0)
                                        {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                        @endif

                                        {{ $minutes }} {{ $hours > 1 ? 'Minute' : 'Minutes' }} to Completed</p>

                                        <p><img src="{{ asset('assets/images/icons/carriculam.svg') }}" alt="users"
                                            class="img-fluid">{{ $course->modules ? $course->modules->sum(function($module) { return $module->lessons ? $module->lessons->count() : 0; }) : 0 }} Lessons in {{ $course->modules ? $course->modules->count() : 0 }} Modules</p>

                                {{-- <p><img src="{{asset('assets/images/icons/carriculam.svg')}}" alt="users"
                                            class="img-fluid"> {{ $course->curriculum ? $course->curriculum : 0 }} Curriculum</p> --}}

                                <p><img src="{{asset('assets/images/icons/trophy.svg')}}" alt="users" class="img-fluid">
                                                Certificate of Completion</p>

                            </div>
                            <div class="col-lg-6">
                                @if ($course->language)
                                <p><img src="{{asset('assets/images/icons/english.svg')}}" alt="users" class="img-fluid">
                                    {{ $course->language }}</p>
                                @endif
                                @if ($course->platform)
                                <p><img src="{{asset('assets/images/icons/platform.svg')}}" alt="platform" class="img-fluid">
                                    {{ $course->platform }}</p>
                                @endif
                                <p><img src="{{asset('assets/images/icons/loop.svg')}}" alt="users"
                                    class="img-fluid">  Full Lifetime Access</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="all-modules-box">
                        <h3>Modules ({{ $course->modules ? count($course->modules) : 0 }})</h3>
                    </div>
                </div>
                @if($course->modules)
                    @foreach ($course->modules as $module)
                    @php
                        $totalLessons = $module->lessons ? count($module->lessons) : 0;
                        $completedLessons = $module->lessons ? $module->lessons->where('completed', 1)->count() : 0;
                        $percentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="course-modules-boxx">
                            <div class="media">
                                <div class="media-body">
                                    <h5>{{ $module->title }}</h5>
                                    <p>{{ $module->lessons ? count($module->lessons) : 0 }} Lessons - {{ $completedLessons }} Completed</p>
                                </div>

                                <div class="circle-prog">
                                    <div class="cards">
                                        <div class="percent">
                                            <svg>
                                                <circle cx="27" cy="30" r="25"></circle>
                                                <circle cx="27" cy="30" r="25"
                                                    style="--percent: {{ $percentage }}"></circle>
                                            </svg>
                                            <div class="number">
                                                <h6>{{ $percentage }}<span>%</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <ul>
                                @if($module->lessons)
                                    @foreach ($module->lessons->slice(0, 3) as $lesson)
                                    <li>
                                        <span>{{ Str::limit($lesson->title, 30) }}</span>
                                        <div>
                                            @if ($lesson->completed == 1)
                                                <img src="{{ asset('assets/images/icons/chk.svg') }}" alt="icon"
                                                    class="img-fluid ms-2">
                                            @else
                                                @if ($lesson->type == 'text')
                                                    <i class="fa-regular fa-file-lines text-dark ms-2"></i>
                                                @elseif($lesson->type == 'audio')
                                                    <i class="fa-solid fa-headphones text-dark ms-2"></i>
                                                @elseif($lesson->type == 'video')
                                                <img src="{{ asset('assets/images/icons/play-icon.svg') }}" alt="icon"
                                                class="img-fluid ms-2 light-ele">
                                                <img src="{{ asset('assets/images/icons/play-icon-d.svg') }}" alt="icon"
                                                class="img-fluid ms-2 dark-ele">
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                @endif
                                <div class="collapse mb-3" id="collapseExample{{ $module->id }}">
                                    @if($module->lessons)
                                        @foreach ($module->lessons->slice(3, 10) as $lesson)
                                    <li>
                                        <span>{{ Str::limit($lesson->title, 30) }}</span>
                                        <div>
                                            @if ($lesson->completed == 1)
                                                <img src="{{ asset('assets/images/icons/chk.svg') }}" alt="icon"
                                                    class="img-fluid ms-2">
                                            @else
                                                @if ($lesson->type == 'text')
                                                    <i class="fa-regular fa-file-lines text-dark ms-2"></i>
                                                @elseif($lesson->type == 'audio')
                                                    <i class="fa-solid fa-headphones text-dark ms-2"></i>
                                                @elseif($lesson->type == 'video')
                                                <img src="{{ asset('assets/images/icons/play-icon.svg') }}" alt="icon"
                                                class="img-fluid ms-2 light-ele">
                                                <img src="{{ asset('assets/images/icons/play-icon-d.svg') }}" alt="icon"
                                                class="img-fluid ms-2 dark-ele">
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                        @endforeach
                                    @endif
                                </div>
                            </ul>

                            @if ($module->lessons && count($module->lessons) > 3)
                                <div class="text-center">
                                    <a data-bs-toggle="collapse" href="#collapseExample{{ $module->id }}" role="button" aria-expanded="false" aria-controls="collapseExample{{ $module->id }}">Show More <i class="fas fa-angle-down"></i></a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
                @endif

            </div>
        </div>
    </main>
@endsection

@section('script')

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.text-center a').forEach(function(element) {
        element.addEventListener('click', function() {
            var ariaExpandedValue = element.getAttribute('aria-expanded');
            element.innerHTML = (ariaExpandedValue === 'false') ? 'Show More <i class="fas fa-angle-down"></i>' : 'Show Less <i class="fas fa-angle-up"></i>';
        });
    });
});
</script>

@endsection
