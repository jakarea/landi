@extends('layouts.latest.admin')
@section('title')
Bundle Course Update Select
@endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

@section('content')
{{-- get seleted course from session --}}
@php 
 $adminBundleSelected = [];
 if (session()->has('adminBundleSelected')) {
    $adminBundleSelected = session('adminBundleSelected');
 }
@endphp

{{-- get seleted course from session --}}
<main class="courses-lists-pages">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <form action="" method="GET" id="myForm">
                    <div class="user-search-box-wrap bundle-select-grid d-grid" style="grid-auto-columns: 60% 40%;">
                        <div class="form-group me-lg-3">
                            <i class="fas fa-search"></i>
                            <input autocomplete="off" type="text" placeholder="Search Course" class="form-control" name="title"
                                value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                        </div>
                        <div class="filter-dropdown-box">
                            <input type="hidden" name="status" id="inputField">
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    id="dropdownBttn">
                                    All
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item filterItem" href="#">All</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="best_rated">Best
                                            Rated</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="most_purchased">Most
                                            Purchased</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="newest">Newest</a>
                                    </li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="oldest">Oldest</a>
                                    </li>
                                </ul>
                            </div>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="select-bundle-title mb-2">
                    <h1>Select courses to update this bundle</h1>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="select-bundle-title mb-2 text-end"> 
                        <a href="{{ url('admin/bundle/courses/'.$bundleCourse->slug.'/edit-final') }}" class="btn d-inline">
                            <span class="counter">{{ count($adminBundleSelected) }}</span>
                            <img src="{{ asset('assets/images/icons/cart.svg') }}" alt="Course Thumbanil"
                                class="img-fluid"><b class="counter2" style="font-weight: 400">{{ count($adminBundleSelected) }} </b> Courses Selected
                        </a> 
                </div>
            </div>
        </div>
        <div class="row">
            @if (count($courses) > 0)
            @foreach ($courses as $course)
            {{-- course single box start --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mt-15">
                <div class="course-single-item">
                    <div class="course-thumb-box">
                        <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbanil" class="img-fluid">
                    </div>
                    <div class="course-txt-box">
                        <a href="{{ url('admin/bundle/courses/' . $course->slug) }}">{{ Str::limit($course->title,
                            $limit = 45, $end = '..') }}</a>
                        <p>{{ Str::limit($course->short_description, $limit = 30, $end = '...') }}</p>

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

                        <ul>
                            <li><span>{{ $review_avg }}</span></li>
                            @for ($i = 0; $i < $review_avg; $i++) <li><i class="fas fa-star"></i></li>
                                @endfor
                                <li><span>({{ $total }})</span></li>
                        </ul>

                        @if ($course->offer_price)
                        <h5>৳ {{ $course->offer_price }} <span>৳ {{ $course->price }}</span></h5>
                        @elseif(!$course->offer_price && !$course->price)
                        <h5>Free</h5>

                        @else
                        <h5>৳ {{ $course->price }}</h5>
                        @endif

                        <div class="bundle-create-bttn">
                            @if ($adminBundleSelected->pluck('id')->contains($course->id))
                            <button type="button" class="btn border-0" disabled style="background: #ccc!important; color: #101010"><i class="fas fa-check"></i> Added</button>
                            @else 
                            <button type="button" class="btn select-bundle" data-course-id="{{ $course->id }}" ><i
                                class="fas fa-plus"></i> Add to bundle</button>
                            @endif
                        </div>
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

{{-- page script @S --}}
@section('script')
{{-- filter course js --}}
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

{{-- select bundle ajax request with featch --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/'); 
        const selectedBundle = document.querySelectorAll('.select-bundle');
 
        selectedBundle.forEach(item => {
            item.addEventListener('click', function() {

                item.disabled = true;
                item.innerHTML = '<i class="fa-solid fa-spinner fa-spin-pulse"></i> Please Wait..';

                let courseId = item.getAttribute('data-course-id');  
                 
                    if (courseId) {
                        fetch(`${baseUrl}/admin/bundle/courses/${courseId}/select-update`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'DONE') {
                                    item.disabled = true;
                                    item.innerHTML = '<i class="fas fa-check"></i> Added';

                                    const countDisplay = document.querySelector('.counter');
                                    const countDisplay2 = document.querySelector('.counter2');
                                    const currentCount2 = parseInt(countDisplay2.textContent);
                                    const currentCount = parseInt(countDisplay.textContent);
                                    countDisplay2.textContent = currentCount2 + 1;
                                    countDisplay.textContent = currentCount + 1;

                                } else {
                                    item.disabled = false;
                                    item.innerHTML = '<i class="fas fa-plus"></i> Add to Bundle';
                                }
                            })
                            .catch(error => {
                                    item.disabled = false;
                                    item.innerHTML = '<i class="fas fa-plus"></i> Add to Bundle';
                            });
                    }
                });
            });
        });
         
</script>

@endsection
{{-- page script @E --}}