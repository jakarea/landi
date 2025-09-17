@extends('layouts.latest.instructor')
@section('title') Instructor Notifications @endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

@section('content')
<main class="courses-lists-pages">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-7 col-lg-8 col-xl-9">
                <div class="user-title-box">
                    <h1>Notification </h1>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-5 col-lg-4 col-xl-3">
                <div class="filter-dropdown-box">
                    <div class="dropdown">
                        <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            id="dropdownBttn">
                            Please select
                        </button>
                        <ul class="dropdown-menu" id="day-wise-notification">
                            <li><a class="dropdown-item filterItem" href="#" data-value="1">Today</a></li>
                            <li><a class="dropdown-item filterItem" href="#" data-value="7">Last 7 days</a></li>
                            <li><a class="dropdown-item filterItem" href="#" data-value="30">Last 30 days</a></li>
                            <li><a class="dropdown-item filterItem" href="#" data-value="365">Last 1 year</a></li>
                        </ul>
                    </div>
                    <i class="fas fa-angle-down"></i>
                </div>
                <input type="hidden" id="inputField">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <hr class="line">
                <div class="notification-box-wrapper">
                    @if (count($todays) == 0 && count($yestardays) == 0 && count($sevenDays) == 0 && count($thirtyDays) == 0 && count($lastOneYears) == 0 )
                    <p class="text-center">There aren't any notifications in your inbox</p>
                    @else
                    <div class="show-notification-item">

                        <div class="single" data-value="1">
                            {{-- day --}}
                            <h5>Today</h5>
                            {{-- day --}}

                            {{-- notify item start --}}
                            @foreach($todays as $today)
                            @php
                                $course = App\Models\Course::find($today->course_id);
                                $user = App\Models\User::find($today->user_id);
                            @endphp

                            <div class="notify-item-box">
                                <div class="media">
                                    <div class="icon">
                                        @if ($today['thumbnail'])
                                        <img src="{{asset($today['thumbnail'])}}" alt="Thumbnail" class="img-fluid">
                                        @else
                                        <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                            class="img-fluid">
                                        @endif
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="media-body">

                                        @if ($course && $user)
                                            @if ($today->message == 'enrolled')
                                            <h5>{{ $user->name }} - Enrolled to <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($today->message == 'review')
                                                <h5>{{ $user->name }} - Post a review to  <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($today->type == 'new_enrollment')
                                                <div class="alert alert-warning border-start border-warning border-4 bg-warning bg-opacity-10">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-4 me-3"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-warning fw-bold mb-2">
                                                                <i class="fas fa-credit-card me-2"></i>পেমেন্ট যাচাই প্রয়োজন
                                                            </h5>
                                                            <div class="text-dark">
                                                                <p class="mb-2 fw-semibold">নতুন শিক্ষার্থী: {{ $user->name }}</p>
                                                                <div class="text-muted small" style="white-space: pre-line;">{{ $today->message }}</div>
                                                            </div>
                                                            @if($today->status == 'unseen')
                                                                <div class="mt-3 d-flex gap-2">
                                                                    <a href="{{ route('instructor.enrollments') }}?status=pending" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-check-circle me-1"></i>পেমেন্ট যাচাই করুন
                                                                    </a>
                                                                    <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-secondary btn-sm">
                                                                        <i class="fas fa-eye me-1"></i>সকল এনরোলমেন্ট দেখুন
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h5>{{$today['message']}}</h5>
                                        @endif

                                        @if($today->type != 'new_enrollment')
                                        <p>{{ $today->message }} - <span>{{ $today->created_at->diffForHumans() }}</span></p>
                                        @else
                                        <p><span>{{ $today->created_at->diffForHumans() }}</span></p>
                                        @endif

                                    </div>
                                </div>
                                <div class="delete-item">
                                    <form action="{{ route('instructor.notify.destroy', $today->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn"><img
                                                src="{{asset('assets/images/icons/trash-bin.svg')}}" alt="Delete"
                                                class="img-fluid"></button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            {{-- notify item end --}}
                        </div>

                        <div class="single" data-value="2">
                            {{-- day --}}
                            <h5 class="mt-5">Yesterday</h5>

                            {{-- day --}}

                            {{-- notify item start --}}
                            @foreach($yestardays as $yestarday)

                            @php
                                $course = App\Models\Course::find($yestarday->course_id);
                                $user = App\Models\User::find($yestarday->user_id);
                            @endphp

                            <div class="notify-item-box">
                                <div class="media">
                                    <div class="icon">
                                        @if ($yestarday['thumbnail'])
                                        <img src="{{asset($yestarday['thumbnail'])}}"
                                            alt="Thumbnail" class="img-fluid">
                                        @else
                                        <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                            class="img-fluid">
                                        @endif
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="media-body">

                                        @if ($course && $user)
                                            @if ($yestarday->message == 'enrolled')
                                            <h5>{{ $user->name }} - Enrolled to <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($yestarday->message == 'review')
                                                <h5>{{ $user->name }} - Post a review to  <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($yestarday->type == 'new_enrollment')
                                                <div class="alert alert-warning border-start border-warning border-4 bg-warning bg-opacity-10">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-4 me-3"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-warning fw-bold mb-2">
                                                                <i class="fas fa-credit-card me-2"></i>পেমেন্ট যাচাই প্রয়োজন
                                                            </h5>
                                                            <div class="text-dark">
                                                                <p class="mb-2 fw-semibold">নতুন শিক্ষার্থী: {{ $user->name }}</p>
                                                                <div class="text-muted small" style="white-space: pre-line;">{{ $yestarday->message }}</div>
                                                            </div>
                                                            @if($yestarday->status == 'unseen')
                                                                <div class="mt-3 d-flex gap-2">
                                                                    <a href="{{ route('instructor.enrollments') }}?status=pending" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-check-circle me-1"></i>পেমেন্ট যাচাই করুন
                                                                    </a>
                                                                    <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-secondary btn-sm">
                                                                        <i class="fas fa-eye me-1"></i>সকল এনরোলমেন্ট দেখুন
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h5>{{$yestarday['message']}}</h5>
                                        @endif

                                        @if($yestarday->type != 'new_enrollment')
                                        <p>{{ $yestarday->message }} - <span>{{ $yestarday->created_at->diffForHumans() }}</span></p>
                                        @else
                                        <p><span>{{ $yestarday->created_at->diffForHumans() }}</span></p>
                                        @endif

                                    </div>
                                </div>

                                <div class="delete-item">
                                    <form action="{{ route('instructor.notify.destroy', $yestarday->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn"><img
                                                src="{{asset('assets/images/icons/trash-bin.svg')}}" alt="Delete"
                                                class="img-fluid"></button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            {{-- notify item end --}}
                        </div>

                        <div class="single" data-value="7">
                            {{-- day --}}
                            <h5 class="mt-5">Last 7 Days</h5>
                            {{-- day --}}

                            {{-- notify item start --}}
                            @foreach($sevenDays as $sevenDay)

                            @php
                                $course = App\Models\Course::find($sevenDay->course_id);
                                $user = App\Models\User::find($sevenDay->user_id);
                            @endphp

                            <div class="notify-item-box">
                                <div class="media">
                                    <div class="icon">
                                        @if ($sevenDay['thumbnail'])
                                        <img src="{{asset($sevenDay['thumbnail'])}}"
                                            alt="Thumbnail" class="img-fluid">
                                        @else
                                        <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                            class="img-fluid">
                                        @endif
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="media-body">

                                        @if ($course && $user)
                                            @if ($sevenDay->message == 'enrolled')
                                            <h5>{{ $user->name }} - Enrolled to <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($sevenDay->message == 'review')
                                                <h5>{{ $user->name }} - Post a review to  <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($sevenDay->type == 'new_enrollment')
                                                <div class="alert alert-warning border-start border-warning border-4 bg-warning bg-opacity-10">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-4 me-3"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-warning fw-bold mb-2">
                                                                <i class="fas fa-credit-card me-2"></i>পেমেন্ট যাচাই প্রয়োজন
                                                            </h5>
                                                            <div class="text-dark">
                                                                <p class="mb-2 fw-semibold">নতুন শিক্ষার্থী: {{ $user->name }}</p>
                                                                <div class="text-muted small" style="white-space: pre-line;">{{ $sevenDay->message }}</div>
                                                            </div>
                                                            @if($sevenDay->status == 'unseen')
                                                                <div class="mt-3 d-flex gap-2">
                                                                    <a href="{{ route('instructor.enrollments') }}?status=pending" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-check-circle me-1"></i>পেমেন্ট যাচাই করুন
                                                                    </a>
                                                                    <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-secondary btn-sm">
                                                                        <i class="fas fa-eye me-1"></i>সকল এনরোলমেন্ট দেখুন
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h5>{{$sevenDay['message']}}</h5>
                                        @endif

                                        @if($sevenDay->type != 'new_enrollment')
                                        <p>{{ $sevenDay->message }} - <span>{{ $sevenDay->created_at->diffForHumans() }}</span></p>
                                        @else
                                        <p><span>{{ $sevenDay->created_at->diffForHumans() }}</span></p>
                                        @endif

                                    </div>
                                </div>

                                <div class="delete-item">
                                    <form action="{{ route('instructor.notify.destroy', $sevenDay->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn"><img
                                                src="{{asset('assets/images/icons/trash-bin.svg')}}" alt="Delete"
                                                class="img-fluid"></button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            {{-- notify item end --}}
                        </div>

                        <div class="single" data-value="30">
                            {{-- day --}}
                            <h5 class="mt-5">Last 30 Days</h5>

                            {{-- notify item start --}}
                            @foreach($thirtyDays as $thirtyDay)

                            @php
                                $course = App\Models\Course::find($thirtyDay->course_id);
                                $user = App\Models\User::find($thirtyDay->user_id);
                            @endphp

                            <div class="notify-item-box">
                                <div class="media">
                                    <div class="icon">
                                        @if ($thirtyDay['thumbnail'])
                                        <img src="{{asset($thirtyDay['thumbnail'])}}"
                                            alt="Thumbnail" class="img-fluid">
                                        @else
                                        <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                            class="img-fluid">
                                        @endif
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="media-body">

                                        @if ($course && $user)
                                            @if ($thirtyDay->message == 'enrolled')
                                            <h5>{{ $user->name }} - Enrolled to <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($thirtyDay->message == 'review')
                                                <h5>{{ $user->name }} - Post a review to  <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($thirtyDay->type == 'new_enrollment')
                                                <div class="alert alert-warning border-start border-warning border-4 bg-warning bg-opacity-10">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-4 me-3"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-warning fw-bold mb-2">
                                                                <i class="fas fa-credit-card me-2"></i>পেমেন্ট যাচাই প্রয়োজন
                                                            </h5>
                                                            <div class="text-dark">
                                                                <p class="mb-2 fw-semibold">নতুন শিক্ষার্থী: {{ $user->name }}</p>
                                                                <div class="text-muted small" style="white-space: pre-line;">{{ $thirtyDay->message }}</div>
                                                            </div>
                                                            @if($thirtyDay->status == 'unseen')
                                                                <div class="mt-3 d-flex gap-2">
                                                                    <a href="{{ route('instructor.enrollments') }}?status=pending" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-check-circle me-1"></i>পেমেন্ট যাচাই করুন
                                                                    </a>
                                                                    <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-secondary btn-sm">
                                                                        <i class="fas fa-eye me-1"></i>সকল এনরোলমেন্ট দেখুন
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h5>{{$thirtyDay['message']}}</h5>
                                        @endif

                                        @if($thirtyDay->type != 'new_enrollment')
                                        <p>{{ $thirtyDay->message }} - <span>{{ $thirtyDay->created_at->diffForHumans() }}</span></p>
                                        @else
                                        <p><span>{{ $thirtyDay->created_at->diffForHumans() }}</span></p>
                                        @endif

                                    </div>
                                </div>

                                <div class="delete-item">
                                    <form action="{{ route('instructor.notify.destroy', $thirtyDay->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn"><img
                                                src="{{asset('assets/images/icons/trash-bin.svg')}}" alt="Delete"
                                                class="img-fluid"></button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            {{-- notify item end --}}
                        </div>

                        <div class="single" data-value="365">
                            {{-- day --}}

                            <h5 class="mt-5">Last 1 year</h5>
                            {{-- day --}}

                            {{-- notify item start --}}
                            @foreach($lastOneYears as $lastOneYear)

                            @php
                                $course = App\Models\Course::find($lastOneYear->course_id);
                                $user = App\Models\User::find($lastOneYear->user_id);
                            @endphp

                            <div class="notify-item-box">
                                <div class="media">
                                    <div class="icon">
                                        @if ($lastOneYear['thumbnail'])
                                        <img src="{{asset($lastOneYear['thumbnail'])}}"
                                            alt="Thumbnail" class="img-fluid">
                                        @else
                                        <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                            class="img-fluid">
                                        @endif
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="media-body">

                                        @if ($course && $user)
                                            @if ($lastOneYear->message == 'enrolled')
                                            <h5>{{ $user->name }} - Enrolled to <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($lastOneYear->message == 'review')
                                                <h5>{{ $user->name }} - Post a review to  <a href="{{ url('instructor/courses/overview/'.$course->slug) }}">{{ $course->title }}</a></h5>
                                            @elseif($lastOneYear->type == 'new_enrollment')
                                                <div class="alert alert-warning border-start border-warning border-4 bg-warning bg-opacity-10">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-4 me-3"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="text-warning fw-bold mb-2">
                                                                <i class="fas fa-credit-card me-2"></i>পেমেন্ট যাচাই প্রয়োজন
                                                            </h5>
                                                            <div class="text-dark">
                                                                <p class="mb-2 fw-semibold">নতুন শিক্ষার্থী: {{ $user->name }}</p>
                                                                <div class="text-muted small" style="white-space: pre-line;">{{ $lastOneYear->message }}</div>
                                                            </div>
                                                            @if($lastOneYear->status == 'unseen')
                                                                <div class="mt-3 d-flex gap-2">
                                                                    <a href="{{ route('instructor.enrollments') }}?status=pending" class="btn btn-warning btn-sm">
                                                                        <i class="fas fa-check-circle me-1"></i>পেমেন্ট যাচাই করুন
                                                                    </a>
                                                                    <a href="{{ route('instructor.enrollments') }}" class="btn btn-outline-secondary btn-sm">
                                                                        <i class="fas fa-eye me-1"></i>সকল এনরোলমেন্ট দেখুন
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <h5>{{$lastOneYear['message']}}</h5>
                                        @endif

                                        @if($lastOneYear->type != 'new_enrollment')
                                        <p>{{ $lastOneYear->message }} - <span>{{ $lastOneYear->created_at->diffForHumans() }}</span></p>
                                        @else
                                        <p><span>{{ $lastOneYear->created_at->diffForHumans() }}</span></p>
                                        @endif

                                    </div>
                                </div>

                                <div class="delete-item">
                                    <form action="{{ route('instructor.notify.destroy', $lastOneYear->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn"><img
                                                src="{{asset('assets/images/icons/trash-bin.svg')}}" alt="Delete"
                                                class="img-fluid"></button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            {{-- notify item end --}}
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{-- pagginate --}}
                <div class="paggination-wrap">
                    {{-- {{ $lastOneYears->links('pagination::bootstrap-5') }} --}}
                </div>
                {{-- pagginate --}}
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let inputField = document.getElementById("inputField");
        let dropbtn = document.getElementById("dropdownBttn");
        let dropdownItems = document.querySelectorAll(".filterItem");
        let itemWrapperItems = document.querySelectorAll(".show-notification-item .single");
        let status;

        itemWrapperItems.forEach(witem => {
            witem.style.display = 'none';
        });

        document.querySelector(".single[data-value='1']").style.display = 'block';
        document.querySelector(".single[data-value='2']").style.display = 'block';

        dropdownItems.forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                inputField.value = this.getAttribute("data-value");
                status = inputField.value;

                if(status == "1"){
                    dropbtn.innerText = 'Today';
                    document.querySelector(".single[data-value='1']").style.display = 'block';
                    document.querySelector(".single[data-value='2']").style.display = 'none';
                    document.querySelector(".single[data-value='7']").style.display = 'none';
                    document.querySelector(".single[data-value='30']").style.display = 'none';
                    document.querySelector(".single[data-value='365']").style.display = 'none';
                }
                if(status == "7"){
                    dropbtn.innerText = 'Last 7 days';
                    document.querySelector(".single[data-value='1']").style.display = 'block';
                    document.querySelector(".single[data-value='2']").style.display = 'block';
                    document.querySelector(".single[data-value='7']").style.display = 'block';
                    document.querySelector(".single[data-value='30']").style.display = 'none';
                    document.querySelector(".single[data-value='365']").style.display = 'none';
                }
                if(status == "30"){
                    dropbtn.innerText = 'Last 30 days';
                    document.querySelector(".single[data-value='1']").style.display = 'block';
                    document.querySelector(".single[data-value='2']").style.display = 'block';
                    document.querySelector(".single[data-value='7']").style.display = 'block';
                    document.querySelector(".single[data-value='30']").style.display = 'block';
                    document.querySelector(".single[data-value='365']").style.display = 'none';
                }
                if(status == "365"){
                    dropbtn.innerText = 'Last 1 year';
                    document.querySelector(".single[data-value='1']").style.display = 'block';
                    document.querySelector(".single[data-value='2']").style.display = 'block';
                    document.querySelector(".single[data-value='7']").style.display = 'block';
                    document.querySelector(".single[data-value='30']").style.display = 'block';
                    document.querySelector(".single[data-value='365']").style.display = 'block';
                }


            });
        });
    });
</script>
@endsection
