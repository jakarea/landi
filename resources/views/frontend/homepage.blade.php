@extends('partials/guest/guest')
@section('title')
Guest Home - Page
@endsection

{{-- page style @S --}}
@section('style')
<style>
    .bundle-course-head h2 {
        color: {
                {
                modulesetting('primary_color')
            }
        }

        ;
    }

    .course-item-box .course-actions .bttns a:first-child {
        color: {
                {
                modulesetting('primary_color')
            }
        }

        ;

        border-color: {
                {
                modulesetting('primary_color')
            }
        }
    }

    .course-item-box .course-actions .review h5 i {
        color: {
                {
                modulesetting('primary_color')
            }
        }

        ;
    }

    .browse-all a {
        color: {
                {
                modulesetting('secondary_color')
            }
        }

        ;
    }

    .navbar .d-flex a:first-child,
    .navbar .navbar-nav .nav-item .nav-link {
        color: {
                {
                modulesetting('menu_color')
            }
        }

         !important;
    }

    .navbar .d-flex a:last-child {
        color: {
                {
                modulesetting('secondary_color')
            }
        }

         !important;
    }

    .navbar .d-flex a:last-child:hover {
        color: {
                {
                modulesetting('menu_color')
            }
        }

         !important;
    }

    /* css end */
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- hero section @s --}}
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6  ">
                <div class="hero-txt-wrap">
                    {{ modulesetting('banner_title') }}
                    <h1> {{ modulesetting('banner_title') ?? 'Deep drive into captivating lessons and hands-on
                        exercises.' }}
                    </h1>
                    <p> {{ modulesetting('banner_text') ?? 'Are you ready to embark on an exciting journey of discovery
                        and lifelong learning? Look no further! KnowledgeQuest is here to empower you with the knowledge
                        and skills you need to excel in today\'s ever-evolving world.' }}
                    </p>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-img-box">
                    <img src="{{ asset('assets/images/login-3-image.png') }}" alt="home-page-hero"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
{{-- hero section @e --}}

{{-- course filter box @s --}}
<div class="course-filter-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="" method="GET">
                    <div class="course-filter-box">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input autocomplete="off" type="text" placeholder="Search with title" name="title"
                                id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="categories">Category</label>
                            @php
                            $categoriesg = isset($_GET['categories']) ? $_GET['categories'] : '';
                            @endphp
                            <select name="categories" id="categories" class="form-control">
                                <option selected value="">Select Below</option>
                                @foreach ($instructors->courses as $course)
                                @php
                                $cats = explode(',', $course->categories);
                                $cats = array_filter($cats, 'strlen');

                                @endphp
                                @foreach ($cats as $categ)
                                <option value="{{ $categ }}" {{ $categoriesg==!empty($categ) ? 'selected' : '' }}>{{
                                    $categ }}
                                </option>
                                @endforeach
                                @endforeach
                            </select>
                            <i class="fas fa-angle-down"></i>
                        </div>

                        <div class="form-group me-0">
                            <label for="price">Price</label>
                            <input type="number" placeholder="Enter your budget" name="price" id="price"
                                class="form-control" min="1">
                        </div>
                        <div class="filter-bttn">
                            <button type="reset" class="btn btn-reset">Clear</button>
                            <button type="submit" class="btn btn-submit"
                                style="background: {{ modulesetting('secondary_color') }}">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- course filter box @e --}}

{{-- course wrap @s --}}
<div class="course-section-wrap" id="course_sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="course-list-wrap">
                    @foreach ($instructors->courses as $course)
                    {{-- course item @s --}}
                    @if($course->status == 'published')
                    <div class="course-item-box">
                        <div class="row">
                            <div class="col-lg-9 col-md-8">
                                <div class="media">
                                    <div class="course-thumbnail">

                                        @isset( $course->thumbnail )
                                        <img src="{{ asset( $course->thumbnail ) }}" alt="{{ $course->name }}"
                                            class="img-fluid">
                                        @else
                                        <span class="user-name-thumbnail">{!! strtoupper($course->name[0]) !!}</span>
                                        @endisset

                                    </div>
                                    <div class="media-body">
                                        <a class="text-decoration-none"
                                            href="{{ url('courses/overview-courses/' . $course->slug) }}">
                                            <h4>{{ $course->title }}</h4>
                                        </a>

                                        @php $courseCategories = explode(",",$course->categories) @endphp

                                        <div class="course-categories">
                                            @foreach ($courseCategories as $courseCategory)
                                            <span class="badge text-bg-info">{{ $courseCategory }}</span>
                                            @endforeach
                                        </div>

                                        <p>{{ Str::limit($course->short_description, $limit = 158, $end = '...') }}
                                        </p>

                                        <a href="{{ url('courses/overview-courses/' . $course->slug) }}">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="course-actions">
                                    <div class="review">
                                        <h5><i class="fas fa-star"></i></h5>
                                        <p>
                                            @if (count($course->reviews) > 1)
                                            {{ count($course->reviews) }} reviews
                                            @elseif(count($course->reviews) == 1)
                                            {{ count($course->reviews) }} review
                                            @elseif(count($course->reviews) <= 0) No review yet! @endif </p>
                                    </div>
                                    <div class="bttns">
                                        <a href="{{ url('courses/overview-courses/' . $course->slug) }}">More
                                            Details</a>
                                        <a href="#" class="d-none"></a>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- course item @e --}}
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="course-instructor me-md-2 me-lg-0 text-center">
                    <div class="thumbnail">
                        <img src="{{ asset($instructors->avatar) }}" alt="Avatar" class="img-fluid">
                    </div>
                    <div class="txt">
                        <h4>{{ $instructors->name }}</h4>
                        <h5>{{ $instructors->email }}</h5>
                        {{-- @if (Auth::check())
                        @can('student')
                        <a href="{{ route('students.dashboard', config('app.subdomain')) }}">Get more details!</a>
                        @else
                        <a href="{{ route('instructor.dashboard.index', config('app.subdomain')) }}">Get more
                            details!</a>
                        @endcan
                        @else
                        <a href="{{ route('login', ['subdomain' => config('app.subdomain')]) }}">Get more details!</a>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- course wrap @e --}}

{{-- bundle course @s --}}
<div class="bundle-course-wrap" id="b_course_sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="bundle-course-head">
                    <h2 class="text-dark">Bundle Courses</h2>
                    <p>At KnowledgeQuest, we believe that learning should be an immersive and engaging experience.
                        That's why our courses are crafted by industry experts and thought leaders, ensuring the highest
                        quality of content and up-to-date information. </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="browse-all">
                    {{-- @if (Auth::check())
                    @can('student')
                    <a href="{{ route('students.dashboard', config('app.subdomain')) }}">Browse all <i
                            class="fas fa-angle-right"></i></a>
                    @else
                    <a href="{{ route('instructor.dashboard.index' ,config('app.subdomain')) }}">Browse all <i
                            class="fas fa-angle-right"></i></a>
                    @endcan
                    @else
                    <a href="{{ route('login', ['subdomain' => config('app.subdomain')]) }}">Browse all <i
                            class="fas fa-angle-right"></i></a>
                    @endif --}}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($bundle_courses as $bundle_course)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="bundle-course-box" style="height: 100%">
                    <div class="thumbnail">
                        <img src="{{ asset($bundle_course->thumbnail) }}" alt="a" class="img-fluid">
                    </div>
                    <div class="txt">
                        <h4>{{ $bundle_course->title }}</h4>
                        <div class="categories">
                            <span class="text-secondary" style="font-size: .8rem">Subscription Status: {{
                                $bundle_course->sub_title }} </span>
                        </div>
                        <p>{{ $bundle_course->short_description }}</p>
                    </div>
                    <div class="bttns">
                        <h6>৳ {{ $bundle_course->sales_price ? $bundle_course->sales_price :
                            $bundle_course->regular_price }} /</h6>
                        <h6><span>included {{ count($bundle_course->courses) }} courses</span></h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
{{-- bundle course @e --}}

{{-- review section @s --}}
<section class="review-section" id="feedback_sec">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="bundle-course-head">
                    <h2 class="text-dark"> A Testimonial Showcase</h2>
                    <p>Explore a compilation of inspiring testimonials that highlight the impact our platform has had on
                        their lives and careers. Join our community and be a part of the success stories.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="browse-all">
                    {{-- <a href="{{ route('login', ['subdomain' => config('app.subdomain')])}}">Browse all <i
                            class="fas fa-angle-right"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($courses_review->slice(0,3) as $review)
            <div class="col-lg-6">
                <div class="feedback-slider">
                    <div class="student-feeback-box mb-3">
                        <div class="media">
                            <img src="{{ asset($review->user->avatar) }}" alt="a" class="img-fluid">
                            <div class="media-body">
                                <p>{{ $review->comment }}</p>

                                <h6>{{ $review->user->name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
{{-- review section @e --}}

{{-- footer @s --}}
@include('partials/guest/footer')
{{-- footer @e --}}
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')

@endsection
{{-- page script @E --}}