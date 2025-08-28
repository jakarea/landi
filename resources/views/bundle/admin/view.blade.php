@extends('layouts.latest.admin')
@section('title')
View Bundle
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
            <div class="col-lg-9">
                <div class="select-bundle-title mt-0">
                    <h1>This bundle comprises the following courses</h1>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="select-bundle-title mt-0 text-end">
                    <a href="{{url('admin/bundle/courses')}}" class="btn d-inline">Total {{ $selectedCourses }} Courses</a>
                </div>
            </div>
        </div>
        @if ($selectedCourses >= 1)
        <div class="row">
            <div class="col-12">
                <div class="selected-bundle-courses-wrap">
                    <div class="row">
                        @foreach ($bundleSelected as $course)
                        {{-- course single box start --}}
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mb-3">
                            <div class="course-single-item">
                                <div class="course-thumb-box">
                                    <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbanil" class="img-fluid">

                                </div>
                                <div class="course-txt-box">
                                    <a href="{{url('admin/courses/overview/'.$course->slug)}}">{{
                                        Str::limit($course->title, $limit = 45, $end = '..') }}</a>
                                    <p>{{ Str::limit($course->short_description, $limit = 30, $end = '...') }}
                                    </p>
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
                                   <div class="d-flex align-items-center justify-content-between">
                                    @if ($course->offer_price)
                                    <h5>৳ {{ $course->offer_price }} <span>৳ {{ $course->price }}</span></h5>
                                    @elseif(!$course->offer_price && !$course->price)
                                    <h5>Free</h5>

                                    @else
                                    <h5>৳ {{ $course->price }}</h5>
                                    @endif

                                   </div>
                                </div>
                            </div>
                        </div>
                        {{-- course single box end --}}
                        @endforeach
                    </div>
                </div>
                <div class="bundle-create-form-wrap">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="basic-info-txt">
                                <h5>Bundle Course Information</h5>
                                @php
                                    $instructor = \App\Models\User::find($updatingCourse->instructor_id);
                                @endphp
                                <p>Instructor: {{ $instructor->name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="bundle-create-inputs">
                                <div class="form-group">
                                    <label for="title">Bundle Title</label>
                                    <input autocomplete="off" type="text" class="form-control border-0 p-0"
                                        value="{{ $updatingCourse->title }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="sub_title">Bundle Subtitle</label>
                                    <input autocomplete="off" type="text" class="form-control border-0 p-0"
                                        value="{{ $updatingCourse->sub_title }}" disabled>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="regular_price">Regular Price</label>
                                            <span class="input-group-text border-0" id="regular_price">৳</span>
                                            <input autocomplete="off" type="text" class="form-control border-0 p-0"
                                                value="{{ $updatingCourse->regular_price }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="sales_price">Sales Price</label>
                                            <span class="input-group-text border-0" id="sales_price">৳</span>
                                            <input autocomplete="off" type="text" class="form-control border-0 p-0"
                                                value="{{ $updatingCourse->sales_price }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Bundle Description</label>
                                    <textarea class="form-control border-0 p-0"
                                        disabled>{!! $updatingCourse->description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail</label>
                                    @if ($updatingCourse->thumbnail)
                                    <label for="" class="logo-upload-box">
                                        <img src="{{ asset($updatingCourse->thumbnail) }}" alt="Uploaded"
                                            class="img-fluid rounded">
                                    </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                @include('partials/no-data')
            </div>
        </div>
        @endif
    </div>
</main>
@endsection
