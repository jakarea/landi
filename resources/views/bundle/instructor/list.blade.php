@extends('layouts.latest.instructor')
@section('title')
    Bundle Course List
@endsection

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
                <div class="col-12">
                    <form action="" method="GET" id="myForm">
                        <div class="row">
                            <div class="col-xl-7 col-md-8">
                                <div class="user-search-box-wrap">
                                    <div class="form-group">
                                        <i class="fas fa-search"></i>
                                        <input autocomplete="off" type="text" placeholder="Search Course" class="form-control"
                                            name="title" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                                    </div>
                                    <input type="hidden" name="status" id="inputField">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <div class="filter-dropdown-box">
                                    <div class="dropdown">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false" id="dropdownBttn">
                                            All Bundle
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item filterItem" href="#">All Bundle</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="best_rated">Best Rated Bundle</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="most_purchased">Most Purchased Bundle</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="newest">Newest Bundle</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="oldest">Oldest Bundle</a></li>
                                        </ul>
                                    </div>
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="col-xl-2 ps-0 col-md-5">
                                <div class="user-add-box text-xl-end mb-lg-3 mb-xl-0">
                                    <a href="{{ url('instructor/bundle/courses/select') }}"><i
                                            class="fas fa-plus me-2"></i> Add New Course</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @if (count($bundleCourses) > 0)
                    @foreach ($bundleCourses as $course)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mb-4">
                            <div class="course-single-item">
                                <div class="course-thumb-box">
                                    <div class="header-action">
                                        <div class="dropdown">
                                            <button class="btn btn-ellipse" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{route('course.bundle.view', ['slug' => $course->slug, config('app.subdomain') ])}}">View</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route ('select.again.bundle.course', ['slug' => $course->slug, config('app.subdomain') ])}}">Edit</a>
                                                </li>
                                                <li>
                                                    <form method="POST" class="d-inline" action="{{ route('delete.bundle.course', ['bundle_id' => $course->id, 'subdomain' => config('app.subdomain') ]) }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item btn text-danger">Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbanil" class="img-fluid">
                                </div>
                                <div class="course-txt-box">
                                    <a href="{{route('course.bundle.view', ['slug' => $course->slug, config('app.subdomain') ])}}">{{ Str::limit($course->title, $limit = 45, $end = '..') }}</a>
                                    <p>{{ Str::limit($course->sub_title, $limit = 30, $end = '...') }}</p>

                                    @php
                                    $courseIds = explode(',', $course->selected_course);
                                    $bundleSelected = App\Models\Course::whereIn('id', $courseIds)
                                        ->where('user_id', Auth::user()->id)
                                        ->with('reviews')
                                        ->get();

                                    $review_sum = 0;
                                    $total = 0;
                                    @endphp

                                    @foreach ($bundleSelected as $selectedCourse)
                                        @foreach ($selectedCourse->reviews as $review)
                                            @php
                                            $total++;
                                            $review_sum += $review->star;
                                            @endphp
                                        @endforeach
                                    @endforeach

                                    @php
                                    $review_avg = ($total > 0) ? $review_sum / $total : 0;
                                    @endphp

                                    <ul>
                                        <li><span>{{ number_format($review_avg, 2) }}</span></li>
                                        @for ($i = 0; $i < $review_avg; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor
                                        <li><span>({{ $total }})</span></li>
                                    </ul>

                                    @if ($course->sales_price)
                                        <h5>৳ {{ $course->sales_price }} <span>৳ {{ $course->regular_price }}</span></h5>
                                    @else
                                        <h5>{{ $course->regular_price > 0 ? '৳ ' . $course->regular_price : 'Free' }}</h5>
                                    @endif
                                </div>

                            </div>
                        </div>
                        {{-- course single box end --}}
                    @endforeach
                @else
                    <div class="col-12">
                        @include('partials/no-data')
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    {{-- pagginate --}}
                    <div class="paggination-wrap">
                        {{ $bundleCourses->links('pagination::bootstrap-5') }}
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
            let title = urlParams.get('title');
            let status = urlParams.get('status');
            let dropdownItems = document.querySelectorAll(".filterItem");

            if (status == "best_rated") {
                dropbtn.innerText = 'Best Rated Bundle';
            }
            if (status == "most_purchased") {
                dropbtn.innerText = 'Most Purchased Bundle';
            }
            if (status == "newest") {
                dropbtn.innerText = 'Newest Bundle';
            }
            if (status == "oldest") {
                dropbtn.innerText = 'Oldest Bundle';
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
