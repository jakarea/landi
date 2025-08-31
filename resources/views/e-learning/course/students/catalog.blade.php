@extends('layouts/latest/students')
@section('title')
    Home Page
@endsection
@php
    use Illuminate\Support\Str;
@endphp
@section('seo')
    <meta name="description"
        content="Explore a diverse course list on LearnCosy. Boost your skills with engaging lessons in technology, business, arts, and more. Begin your educational journey today and unlock your full potential. Discover now!"
        itemprop="description">
@endsection
{{-- page style @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <main class="student-courses-lists-pages">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="" method="GET" id="myForm">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8 col-xl-9">
                                <div class="user-search-box-wrap">
                                    <div class="form-group">
                                        <i class="fas fa-search"></i>
                                        <input autocomplete="off" type="text" placeholder="Search Course" class="form-control"
                                            name="title" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                                    </div>
                                    <input type="hidden" name="status" id="inputField">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 col-xl-3">
                                <div class="filter-dropdown-box">
                                    <div class="dropdown">
                                        <button class="btn" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false" id="dropdownBttn">
                                            All
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item filterItem" href="#">All</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="best_rated">Best Rated</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="most_purchased">Most Purchased</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="newest">Newest</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="oldest">Oldest</a></li>
                                        </ul>
                                    </div>
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @if (count($courses))
                    @foreach ($courses as $course)
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

                            $desc = $course->short_description;
                            $max_length = 205;
                            if (strlen($desc) > $max_length) {
                                $short_description = substr($desc, 0, $max_length);
                                $last_space = strrpos($short_description, ' ');
                                $short_description = substr($short_description, 0, $last_space) . ' ...';
                            } else {
                                $short_description = $desc;
                            }
                        @endphp
                        {{-- course single box start --}}
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xxl-3 mb-4 hover-item">
                            <div class="course-single-item">
                                <div>
                                    <div class="course-thumb-box">
                                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->slug }}"
                                            class="img-fluid">
                                    </div>
                                    <div class="course-txt-box">
                                        <a href="{{ url('student/courses/' . $course->slug . '/learn') }}">
                                            {{ Str::limit($course->title, 45) }}</a>

                                        <p>{{ Str::limit($course->short_description, $limit = 46, $end = '...') }}</p>
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
                                    <h5><i class="fas fa-check-circle text-success"></i> Enrolled</h5>
                                </div>
                                <div class="course-ol-box">
                                    <h5>{{ Str::limit($course->title, 50) }}</h5>
                                    <span>Last Update: {{ date('M d Y ', strtotime($course->updated_at)) }}</span>
                                    <h6>{{ Str::limit($course->short_description, $limit = 120, $end = '...') }}</h6>
                                    @php
                                        $objective = explode('[objective]', $course->objective);
                                        $limitedItems = array_slice($objective, 0, 4);
                                    @endphp
                                    <ul>
                                        @foreach ($limitedItems as $object)
                                            <li><i class="fas fa-check"></i>{{ Str::limit($object, 34) }}</li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ url('student/courses/' . $course->slug . '/learn') }}" class="btn btn-primary">Continue Learning</a>
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
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </div>
                    {{-- pagginate --}}
                </div>
            </div>
        </div>
    </main>
@endsection
{{-- page content @E --}}


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
                dropbtn.innerText = 'Best Rated';
            }
            if (status == "most_purchased") {
                dropbtn.innerText = 'Most Purchased';
            }
            if (status == "newest") {
                dropbtn.innerText = 'Newest';
            }
            if (status == "oldest") {
                dropbtn.innerText = 'Oldest';
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
