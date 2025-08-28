@php
if ( Auth::user()->user_role == 'instructor') {
$layoutName = "layouts.latest.instructor";
}elseif(Auth::user()->user_role == 'student'){
$layoutName = "layouts.latest.students";
}else{
$layoutName = "layouts.latest.admin";
}
@endphp

@extends($layoutName)
@section('title') Student Notifications @endsection

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
                    @if (count($todays) == 0 && count($yestardays) == 0 && count($sevenDays) == 0 && count($thirtyDays)
                    == 0 && count($lastOneYears) == 0 )
                   <p class="text-center">There aren't any notifications in your inbox</p>
                    @else
                    <div class="show-notification-item">

                        @if ( count( $todays) > 0)
                            <div class="single" data-value="1">
                                {{-- day --}}
                                <h5>Today</h5>
                                {{-- day --}}

                                {{-- notify item start --}}
                                @foreach($todays as $today)
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
                                            @php
                                            $course = App\Models\Course::find($today->course_id);
                                            @endphp
                                            <h5>
                                                @if ($course)
                                                @if (isEnrolled($course->id))
                                                    <a href="{{ url('student/courses/my-courses/details/' . $course->slug) }}">
                                                        {{$today['title']}}</a>
                                                @else
                                                    <a href="{{ url('student/courses/overview/' . $course->slug) }}">
                                                        {{$today['title']}}</a>
                                                @endif
                                                @else
                                                {{$today['title']}}
                                                @endif
                                            </h5>
                                            <p>{{$today['type']}} - <span>{{ $today->created_at->diffForHumans() }}</span></p>
                                        </div>
                                    </div>
                                    <div class="delete-item">
                                        <form action="{{ route('notification.destroy',$today['id']) }}" method="POST">
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
                        @endif

                        @if ( count( $yestardays) > 0)
                            <div class="single" data-value="2">
                                {{-- day --}}
                                <h5 class="mt-5">Yesterday</h5>

                                {{-- day --}}

                                {{-- notify item start --}}
                                @foreach($yestardays as $yestarday)
                                <div class="notify-item-box">
                                    <div class="media">
                                        <div class="icon">
                                            @if ($yestarday['thumbnail'])
                                            <img src="{{asset($yestarday['thumbnail'])}}" alt="Thumbnail" class="img-fluid">
                                            @else
                                            <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                                class="img-fluid">
                                            @endif
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="media-body">
                                            @php
                                            $course = App\Models\Course::find($yestarday->course_id);
                                            @endphp
                                            <h5>
                                                @if ($course)
                                                @if (isEnrolled($course->id))
                                                    <a href="{{ url('student/courses/my-courses/details/' . $course->slug) }}">
                                                        {{$yestarday['title']}}</a>
                                                @else
                                                    <a href="{{ url('student/courses/overview/' . $course->slug) }}">
                                                        {{$yestarday['title']}}</a>
                                                @endif
                                                @else
                                                {{$yestarday['title']}}
                                                @endif
                                            </h5>
                                            <p>{{$yestarday['type']}} - <span>{{ $yestarday->created_at->diffForHumans() }}</span></p>
                                        </div>
                                    </div>

                                    <div class="delete-item">
                                        <form action="{{ route('notification.destroy',$yestarday['id']) }}" method="POST">
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
                        @endif

                        @if ( count( $sevenDays) > 0)
                            <div class="single" data-value="7">
                                {{-- day --}}
                                <h5 class="mt-5">Last 7 Days</h5>
                                {{-- day --}}

                                {{-- notify item start --}}
                                @foreach($sevenDays as $sevenDay)
                                <div class="notify-item-box">
                                    <div class="media">
                                        <div class="icon">
                                            @if ($sevenDay['thumbnail'])
                                            <img src="{{asset($sevenDay['thumbnail'])}}" alt="Thumbnail" class="img-fluid">
                                            @else
                                            <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                                class="img-fluid">
                                            @endif
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="media-body">
                                            @php
                                            $course = App\Models\Course::find($sevenDay->course_id);
                                            @endphp
                                            <h5>
                                                @if ($course)
                                                @if (isEnrolled($course->id))
                                                    <a href="{{ url('student/courses/my-courses/details/' . $course->slug) }}">
                                                        {{$sevenDay['title']}}</a>
                                                @else
                                                    <a href="{{ url('student/courses/overview/' . $course->slug) }}">
                                                        {{$sevenDay['title']}}</a>
                                                @endif
                                                @else
                                                {{$sevenDay['title']}}
                                                @endif
                                            </h5>
                                            <p>{{$sevenDay['type']}} - <span>{{ $sevenDay->created_at->diffForHumans() }}</span></p>
                                        </div>
                                    </div>

                                    <div class="delete-item">
                                        <form action="{{ route('notification.destroy',$sevenDay['id']) }}" method="POST">
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
                        @endif

                        @if ( count( $thirtyDays) > 0)
                            <div class="single" data-value="30">
                                {{-- day --}}
                                <h5 class="mt-5">Last 30 Days</h5>

                                {{-- notify item start --}}
                                @foreach($thirtyDays as $thirtyDay)
                                <div class="notify-item-box">
                                    <div class="media">
                                        <div class="icon">
                                            @if ($thirtyDay['thumbnail'])
                                            <img src="{{asset($thirtyDay['thumbnail'])}}" alt="Thumbnail" class="img-fluid">
                                            @else
                                            <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                                class="img-fluid">
                                            @endif
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="media-body">
                                            @php
                                            $course = App\Models\Course::find($thirtyDay->course_id);
                                            @endphp
                                            <h5>
                                                @if ($course)
                                                @if (isEnrolled($course->id))
                                                    <a href="{{ url('student/courses/my-courses/details/' . $course->slug) }}">
                                                        {{$thirtyDay['title']}}</a>
                                                @else
                                                    <a href="{{ url('student/courses/overview/' . $course->slug) }}">
                                                        {{$thirtyDay['title']}}</a>
                                                @endif
                                                @else
                                                {{$thirtyDay['title']}}
                                                @endif
                                            </h5>
                                            <p>{{$thirtyDay['type']}} - <span>{{ $thirtyDay->created_at->diffForHumans() }}</span></p>
                                        </div>
                                    </div>

                                    <div class="delete-item">
                                        <form action="{{ route('notification.destroy',$thirtyDay['id']) }}" method="POST">
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
                        @endif

                        @if ( count( $lastOneYears) > 0)
                            <div class="single" data-value="365">
                                {{-- day --}}
                                <h5 class="mt-5">Last 1 year</h5>
                                {{-- day --}}

                                {{-- notify item start --}}
                                @foreach($lastOneYears as $lastOneYear)
                                <div class="notify-item-box">
                                    <div class="media">
                                        <div class="icon">
                                            @if ($lastOneYear['thumbnail'])
                                            <img src="{{asset($lastOneYear['thumbnail'])}}" alt="Thumbnail"
                                                class="img-fluid">
                                            @else
                                            <img src="{{asset('assets/images/icons/gallery.svg')}}" alt="icon"
                                                class="img-fluid">
                                            @endif
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div class="media-body">
                                            @php
                                            $course = App\Models\Course::find($lastOneYear->course_id);
                                            @endphp
                                            <h5>
                                                @if ($course)
                                                @if (isEnrolled($course->id))
                                                    <a href="{{ url('student/courses/my-courses/details/' . $course->slug) }}">
                                                        {{$lastOneYear['title']}}</a>
                                                @else
                                                    <a href="{{ url('student/courses/overview/' . $course->slug) }}">
                                                        {{$lastOneYear['title']}}</a>
                                                @endif
                                                @else
                                                {{$lastOneYear['title']}}
                                                @endif
                                            </h5>
                                            <p>{{$lastOneYear['type']}} - <span>{{ $lastOneYear->created_at->diffForHumans() }}</span></p>
                                        </div>
                                    </div>

                                    <div class="delete-item">
                                        <form action="{{ route('notification.destroy',$lastOneYear['id']) }}" method="POST">
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
                        @endif

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
