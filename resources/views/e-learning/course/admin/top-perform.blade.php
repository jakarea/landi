@extends('layouts.latest.admin')
@section('title')
Top Perform Courses
@endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

@section('content')
<main class="top-perform-courses-lists-pages">
    <div class="container-fluid">
        <div class="row align-items-end">
            <div class="col-lg-9 col-12 col-sm-8 col-md-8">
                <div class="user-title-box mb-0">
                    <h1>Top Performing Courses</h1>
                </div>
            </div> 
            <div class="col-lg-3 col-12 col-sm-4 col-md-4">
                <form action="" method="GET" id="myForm">
                    <input type="hidden" name="status" id="inputField">
                    <div class="filter-dropdown-box">
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                id="dropdownBttn">
                                All
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item filterItem" href="#">All</a></li>
                                <li><a class="dropdown-item filterItem" href="#" data-value="last_7_days">Last 7
                                        days</a></li>
                                <li><a class="dropdown-item filterItem" href="#" data-value="last_30_days">Last 30
                                        days</a></li>
                                <li><a class="dropdown-item filterItem" href="#" data-value="last_1_year">Last 1
                                        year</a></li>
                            </ul>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </form>
            </div>
            <div class="col-12 my-4">
                <div class="brdr-bottom-1"></div>
            </div>
        </div>
        <div class="row">
            @foreach ($TopPerformingCourses as $course)
            @php
            $review_sum = 0;
            $review_avg = 0;
            $total = 0;
            foreach ($course->reviews as $review) {
            $total++;
            $review_sum += $review->star;
            }
            if ($total) {
            $review_avg = $review_sum / $total;
            }
            @endphp

            {{-- course single box start --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mb-4">
                <div class="course-single-item">
                    <div>
                        <div class="course-thumb-box">
                            <div class="header-action">
                                <div class="dropdown">
                                    <button class="btn btn-ellipse" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ url('admin/courses/' . $course->slug) }}">View</a></li>
                                        <li>
                                            <form method="post" class="d-inline" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item btn text-danger">Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbanil"
                                class="img-fluid">
                        </div>
                        <div class="course-txt-box">
                            <a href="{{ url('admin/courses/overview/'.$course->slug) }}">{{ substr($course->title, 0, 27)
                                }}</a>
                            <p>{{ $course->user->subdomain }}</p>
                            <ul>
                                <li><span>{{ $review_avg }}</span></li>
                                @for ($i = 0; $i < $review_avg; $i++) <li><i class="fas fa-star"></i></li>
                                    @endfor
                                    <li><span>({{ $total }})</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="course-txt-box d-flex justify-content-between align-items-center">
                        <div>
                            @if ($course->offer_price)
                            <h5>৳{{ $course->offer_price }} <span>৳{{ $course->price }}</span></h5>
                            @else
                            <h5> {{ $course->price > 0 ? '৳ ' . $course->price : 'Free' }} </h5>
                            @endif
                        </div>
                        <div>
                            <span class="sold-item">
                                @if($course->sale_count == 0)
                                    No Sold Yet
                                @elseif($course->sale_count == 1)
                                    Sold 1 Time
                                @else
                                    Sold {{ $course->sale_count }} Times
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- course single box end --}}
            @endforeach

        </div>
        <div class="row">
            <div class="col-12">
                {{-- pagginate --}}
                <div class="paggination-wrap">
                    {{ $TopPerformingCourses->links('pagination::bootstrap-5') }}
                </div>
                {{-- pagginate --}}
            </div>
        </div>
    </div>
</main>
@endsection


{{-- page script @S --}}
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
            let inputField = document.getElementById("inputField");
            let dropbtn = document.getElementById("dropdownBttn");
            let form = document.getElementById("myForm");
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let status = urlParams.get('status');
            let dropdownItems = document.querySelectorAll(".filterItem");

            if (status == "last_7_days") {
                dropbtn.innerText = 'Last 7 Days';
            }
            if (status == "last_30_days") {
                dropbtn.innerText = 'Last 30 Days';
            }
            if (status == "last_1_year") {
                dropbtn.innerText = 'Last 1 Year';
            }

            inputField.value = status;

            dropdownItems.forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    inputField.value = this.getAttribute("data-value");
                    dropbtn.innerText = item.innerText;
                    form.submit();
                });
            });
        });
</script>
@endsection
{{-- page script @E --}}
