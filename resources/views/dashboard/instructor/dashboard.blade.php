@extends('layouts.latest.instructor')
@section('title', 'Instructor Dashboard')
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<main class="instructor-dashboard-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="welcome-back-box">
                    <h1>Welcome back, {{ auth::user()->name }}</h1>
                    <h6>Your progress this week is Awesome, let's keep it up.</h6>
                    <h5>Complete your profile</h5>

                    <div class="d_flex">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 75%"></div>
                        </div>
                        <span>75%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mt-15">
                <div class="my-courses-box">
                    <h3>My Courses</h3>
                    <div class="course-box-overflown liked-courses">
                        @if (count($courses) > 0)
                        @foreach ($courses->slice(0, 5) as $myCourses)
                        @php
                            $totalPublishedModules = 0;
                            $totalPublishedLessons = 0;
                        @endphp

                        @foreach ($myCourses->modules as $module)
                            @if ($module->status === 'published')
                                @php
                                    $totalPublishedModules++;
                                    $totalPublishedLessons += $module->lessons->where('status', 'published')->count();
                                @endphp
                            @endif
                        @endforeach 


                        <div class="media">
                            @if ($myCourses->thumbnail)
                            <img src="{{ asset($myCourses->thumbnail) }}" alt="Thumbnail" class="img-fluid me-3 thumab">
                            @else
                            <img src="{{ asset('assets/images/course-small.svg') }}" alt="a"
                                class="img-fluid me-3 thumab">
                            @endif
                            <div class="media-body">
                                <h5><a href="{{ url('instructor/courses/overview/'.$myCourses->slug) }}">{{ Str::limit($myCourses->title, $limit = 38, $end = '..') }}</a></h5>

                                <p class="user">{{ $myCourses->platform }}</p>
                                <p class="lessons">
                                    <img src="{{ asset('assets/images/icons/modules.svg') }}" alt="a"
                                        class="img-fluid">
                                    {{ $totalPublishedModules }} Modules &nbsp;&nbsp;
                                    <img src="{{ asset('assets/images/icons/modules.svg') }}" alt="a"
                                        class="img-fluid"> {{ $totalPublishedLessons }} Lessons
                                </p>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-filter" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></button>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('builder.editor', $myCourses->id) }}">Landing Page Builder</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('instructor/courses/overview/'.$myCourses->slug) }}">View</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('course.destroy', ['subdomain' => config('app.subdomain')
                                                , 'id' => $myCourses->id]) }}" method="POST" class="d-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0 dropdown-item">Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        @else
                        @include('partials/no-data')
                        @endif
                    </div>

                    @if (count($courses) > 5)
                    <div class="text-center mt-4">
                        <a href="{{ url('instructor/courses') }}" class="common-bttn">All Courses</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 mt-15">
                <div class="recent-payment-box recent-payment-grid-view">
                    <h3>Recent Payment</h3>
                    @if (count($payments) > 0)
                    @foreach ($payments->slice(0, 5) as $payment)
                    <div class="payment-box">
                        <h5>
                            @if ($payment->user && $payment->user->avatar)
                            <img src="{{ asset($payment->user->avatar) }}" alt="Avatar" class="img-fluid">
                            @else 
                                <span class="user-name-avatar me-2" style="width: 2.2rem; height: 2.2rem;">{!! strtoupper(optional($payment->user)->name[0]) !!}</span>
                            @endif
                            {{ optional($payment->user)->name }}
                        </h5>

                        <p>
                            @if ($payment->status == 'completed')
                            <span style="color: #2A920B;">{{ $payment->status }}</span>
                            @else
                            <span style="color: #ED5763; background: transparent;">{{ $payment->status }}</span>
                            @endif
                        </p>
                        <p>৳ {{ $payment->amount }}</p>

                        <a href="{{ url('instructor/payments', encrypt($payment->payment_id)) }}">View</a>
                    </div>
                    @endforeach
                    @if (count($payments) > 5)
                    <div class="text-center mt-3">
                        <a href="{{ url('instructor/payments') }}" class="common-bttn">View All Payment</a>
                    </div>
                    @endif
                    @else
                    @include('partials/no-data')
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mt-15">
                <div class="my-courses-box recent-update-box">
                    <h3>Recent Updates</h3>
                    @if (count($recentUpdates) > 0)
                    @foreach ($recentUpdates->slice(0,5) as $recentUpdate)

                    @php
                    $course = App\Models\Course::find($recentUpdate->course_id);
                    $user = App\Models\User::find($recentUpdate->user_id);
                    @endphp
                    @if ($course && $user)
                    <div class="media">

                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="icon" class="img-fluid me-3 user">
                        @else 
                            <span class="user-name-avatar me-3 big-avt" style="width: 3.75rem; height: 3.75rem;">{!! strtoupper($user->name[0]) !!}</span>
                        @endif

                        
                        <div class="media-body">

                            @if ($recentUpdate->message == 'enrolled')
                            <h5><span>{{ $user->name }}</span> - Enrolled to {{ Str::limit($course->title, $limit = 60, $end = '...')
                                }}</h5>
                            @elseif($recentUpdate->message == 'review')
                            <h5><span>{{ $user->name }}</span> - Post a review to {{ Str::limit($course->title, $limit = 60, $end =
                                '...') }}</h5>
                            @endif
                            <p>{{ Auth::user()->name }}</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> {{$recentUpdate->created_at->diffForHumans()}} </li>
                            </ul>
                        </div>

                        <form
                            action="{{ route('instructor.notify.destroy', ['id' => $recentUpdate->id, 'subdomain' => config('app.subdomain')]) }}"
                            class="d-inline" method="POST">
                            @csrf
                            <button type="submit" class="btn"><i class="fa-solid fa-trash-can"
                                    style="color: #ED5763"></i></button>
                        </form>

                    </div>
                    @endif

                    @endforeach
                    @else
                    @include('partials/no-data')
                    @endif
                </div>
            </div>
            <div class="col-lg-6 mt-15">
                <div class="my-courses-box recent-update-box">
                    <h3>System Updates</h3>

                    <div class="media">
                        <div class="media-body">
                            <h5>Complete your certificate for Ux design course </h5>
                            <p>Evelyn Gaylord</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> 1 min ago</li>
                            </ul>
                        </div>
                        <a href="#"><img src="{{ asset('assets/images/circle-q.svg') }}" alt="icon"
                                class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/cir-2.svg') }}" alt="icon"
                                class="img-fluid dark-ele"></a>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <h5>Complete your certificate for Ux design course </h5>
                            <p>Evelyn Gaylord</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> 1 min ago</li>
                            </ul>
                        </div>
                        <a href="#"><img src="{{ asset('assets/images/circle-q.svg') }}" alt="icon"
                                class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/cir-2.svg') }}" alt="icon"
                                class="img-fluid dark-ele"></a>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <h5>Complete your certificate for Ux design course </h5>
                            <p>Evelyn Gaylord</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> 1 min ago</li>
                            </ul>
                        </div>
                        <a href="#"><img src="{{ asset('assets/images/circle-q.svg') }}" alt="icon"
                                class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/cir-2.svg') }}" alt="icon"
                                class="img-fluid dark-ele"></a>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <h5>Complete your certificate for Ux design course </h5>
                            <p>Evelyn Gaylord</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> 1 min ago</li>
                            </ul>
                        </div>
                        <a href="#"><img src="{{ asset('assets/images/circle-q.svg') }}" alt="icon"
                                class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/cir-2.svg') }}" alt="icon"
                                class="img-fluid dark-ele"></a>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <h5>Complete your certificate for Ux design course </h5>
                            <p>Evelyn Gaylord</p>

                            <ul>
                                <li><img src="{{ asset('assets/images/clock.svg') }}" alt="icon"
                                        class="img-fluid"> 1 min ago</li>
                            </ul>
                        </div>
                        <a href="#">
                            <img src="{{ asset('assets/images/circle-q.svg') }}" alt="icon"
                                class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/cir-2.svg') }}" alt="icon"
                                class="img-fluid dark-ele">
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>  
        const modess = document.querySelector("body").classList.contains('dark-mode') ? 'dark-mode' : '';
        modeCall(modess); 
</script>  
@endsection