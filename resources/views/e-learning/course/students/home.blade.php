@extends('layouts/latest/student')
@section('title') হোম পেজ @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/css/course.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/student.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="students-home-page-wrap">
    <div class="email-camping-head">
        <h1>সকল কোর্স</h1>
    </div>
    {{-- page tab head area @S --}}
    <div class="student-head-bttn">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">বিশেষ কোর্স</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false">জনপ্রিয় কোর্স</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                    type="button" role="tab" aria-controls="pills-contact" aria-selected="false">প্রস্তাবিত কোর্স</button>
            </li>
        </ul>
    </div>
    {{-- page tab head area @E --}}

    {{-- course search area @S --}}
    <form action="" method="GET">
        <div class="student-search-wrap">
            <div class="student-search-box">
                <img src="{{ asset('assets/images/search-icon.svg') }}" alt="Search icon" class="img-fluid">
                <input autocomplete="off" type="text" name="title" class="form-control" placeholder="কোর্স খুঁজুন"
                    value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
            </div>
            <div class="student-bttn-box">
                <button class="btn btn-search" type="submit">খুঁজুন</button>
            </div>
        </div>
    </form>
    {{-- course search area @E --}}

    {{-- course listing @S --}}
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0">
            {{-- featured course @S --}}
            <div class="row">
                <!-- item @S -->
                @foreach($courses as $course)
                @php
                $desc = $course->short_description;
                $max_length = 105;
                if (strlen($desc) > $max_length) {
                $short_description = substr($desc, 0, $max_length);
                $last_space = strrpos($short_description, ' ');
                $short_description = substr($short_description, 0, $last_space) . " ...";
                } else {
                $short_description = $desc;
                }
                @endphp
                <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="course-box-wrap">
                        <div class="course-content-box">
                            <div class="course-thumbnail">
                                <img src="{{asset('assets/images/courses/'. $course->thumbnail)}}"
                                    alt="{{ $course->slug}}" class="img-fluid">
                            </div>
                            <div class="course-txt-box">
                                <h3> <a href="{{url('student/courses/'.$course->slug )}}">{{ $course->title }} </a>
                                </h3>
                                <ul>
                                    <li><a href="#" class="text-dark">পাঠ: {{ $course->number_of_lesson}}</a></li>
                                    <li><a href="#" class="text-dark">মডিউল: {{ $course->number_of_module}}</a></li>
                                </ul>
                                <ul>
                                    <li><a href="#" class="text-dark">সার্টিফিকেট: {{ $course->sample_certificates ==
                                            'yes' ? 'হ্যাঁ' : 'না'}}</a></li>
                                    <li><a href="#" class="text-dark">সময়কাল: {{ $course->duration }}</a></li>
                                </ul>
                                <p>{{ $short_description}}</p>
                            </div>
                        </div>
                        <div class="course-ftr">
                            <h5><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-play text-info"></i> প্রোমো ভিডিও দেখুন </a></h5>
                            <a href="javascript:void(0)" class="btn btn-exprec enroll__btn">এখনই ভর্তি হন</a>
                        </div>
                         {{-- promo video modal @S --}}
                         <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">প্রোমো ভিডিও</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="promo-video-box">
                                        <iframe width="100%" height="315" src="{{$course->promo_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- promo video modal @E --}}
                    </div>
                </div>
                @endforeach
                <!-- item @E -->
            </div>
            <div class="row">
                @if(count($courses) == 0)
                <div class="col-12">
                    <div class="no-result-found">
                        <h6>কোনো কোর্স পাওয়া যায়নি!</h6>
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-center mt-4">
                      @if ($courses->hasPages())
                        <div class="pagination-wrapper text-center">
                            {{ $courses->links('pagination::bootstrap-5') }}
                        </div>
                     @endif
                    </div>
                 </div>
                @endif
            </div>
            {{-- featured course @E --}}
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            {{-- popular course @S --}}
            <div class="row">
                <!-- item @S -->
                @foreach($courses as $course)
                @php
                $desc = $course->short_description;
                $max_length = 105;
                if (strlen($desc) > $max_length) {
                $short_description = substr($desc, 0, $max_length);
                $last_space = strrpos($short_description, ' ');
                $short_description = substr($short_description, 0, $last_space) . " ...";
                } else {
                $short_description = $desc;
                }
                @endphp
                <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="course-box-wrap">
                        <div class="course-content-box">
                            <div class="course-thumbnail">
                                <img src="{{asset('assets/images/courses/'. $course->thumbnail)}}"
                                    alt="{{ $course->slug}}" class="img-fluid">
                            </div>
                            <div class="course-txt-box">
                                <h3> <a href="{{url('student/courses/'.$course->slug )}}">{{ $course->title }} </a>
                                </h3>
                                <ul>
                                    <li><a href="#" class="text-dark">পাঠ: {{ $course->number_of_lesson}}</a></li>
                                    <li><a href="#" class="text-dark">মডিউল: {{ $course->number_of_module}}</a></li>
                                </ul>
                                <ul>
                                    <li><a href="#" class="text-dark">সার্টিফিকেট: {{ $course->sample_certificates ==
                                            'yes' ? 'হ্যাঁ' : 'না'}}</a></li>
                                    <li><a href="#" class="text-dark">সময়কাল: {{ $course->duration }}</a></li>
                                </ul>
                                <p>{{ $short_description}}</p>
                            </div>
                        </div>
                        <div class="course-ftr">
                            <h5><a href="{{$course->promo_video}}"><i class="fas fa-play"></i> সংক্ষিপ্ত পর্যালোচনা </a></h5>
                            <a href="javascript:void(0)" class="btn btn-exprec enroll__btn">এখনই ভর্তি হন</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- item @E -->
            </div>
            <div class="row">
                @if(count($courses) == 0)
                <div class="col-12">
                    <div class="no-result-found">
                        <h6>কোনো কোর্স পাওয়া যায়নি!</h6>
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-center mt-4">
                        @if ($courses->hasPages())
                            <div class="pagination-wrapper text-center">
                                {{ $courses->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            {{-- popular course @E --}}
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
            {{-- recomended course @S --}}
            <div class="row">
                <!-- item @S -->
                @foreach($courses as $course)
                @php
                $desc = $course->short_description;
                $max_length = 105;
                if (strlen($desc) > $max_length) {
                $short_description = substr($desc, 0, $max_length);
                $last_space = strrpos($short_description, ' ');
                $short_description = substr($short_description, 0, $last_space) . " ...";
                } else {
                $short_description = $desc;
                }
                @endphp
                <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="course-box-wrap">
                        <div class="course-content-box">
                            <div class="course-thumbnail">
                                <img src="{{asset('assets/images/courses/'. $course->thumbnail)}}"
                                    alt="{{ $course->slug}}" class="img-fluid">
                            </div>
                            <div class="course-txt-box">
                                <h3> <a href="{{url('student/courses/'.$course->slug )}}">{{ $course->title }} </a>
                                </h3>
                                <ul>
                                    <li><a href="#" class="text-dark">পাঠ: {{ $course->number_of_lesson}}</a></li>
                                    <li><a href="#" class="text-dark">মডিউল: {{ $course->number_of_module}}</a></li>
                                </ul>
                                <ul>
                                    <li><a href="#" class="text-dark">সার্টিফিকেট: {{ $course->sample_certificates ==
                                            'yes' ? 'হ্যাঁ' : 'না'}}</a></li>
                                    <li><a href="#" class="text-dark">সময়কাল: {{ $course->duration }}</a></li>
                                </ul>
                                <p>{{ $short_description}}</p>
                            </div>
                        </div>
                        <div class="course-ftr">
                            <h5><a href="{{$course->promo_video}}"><i class="fas fa-play"></i> সংক্ষিপ্ত পর্যালোচনা </a></h5>
                            <a href="javascript:void(0)" class="btn btn-exprec enroll__btn">এখনই ভর্তি হন</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- item @E -->
            </div>
            <div class="row">
                @if(count($courses) == 0)
                <div class="col-12">
                    <div class="no-result-found">
                        <h6>কোনো কোর্স পাওয়া যায়নি!</h6>
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-center mt-4">
                      @if ($courses->hasPages())
                        <div class="pagination-wrapper text-center">
                            {{ $courses->links('pagination::bootstrap-5') }}
                        </div>
                     @endif
                    </div>
                 </div>
                @endif
            </div>
            {{-- recomended course @E --}}
        </div>
    </div>
    {{-- course listing @E --}}
</main>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')

@endsection
{{-- page script @E --}}
