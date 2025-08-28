@extends('layouts/latest/students')
@section('title')
    My Courses
@endsection

@php
    use Illuminate\Support\Str;
@endphp
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
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
                                <div class="user-search-box-wrap">
                                    <div class="form-group">
                                        <i class="fas fa-search"></i>
                                        <input autocomplete="off" type="text" placeholder="কোর্স অনুসন্ধান করুন" class="form-control"
                                            name="title" value="{{ request('title') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                                <select name="category" class="form-select">
                                    <option value="">সব ক্যাটেগরি</option>
                                    @if(isset($availableCategories))
                                        @foreach($availableCategories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                                <select name="instructor" class="form-select">
                                    <option value="">সব ইনস্ট্রাক্টর</option>
                                    @if(isset($availableInstructors))
                                        @foreach($availableInstructors as $instructorName)
                                            <option value="{{ $instructorName }}" {{ request('instructor') == $instructorName ? 'selected' : '' }}>
                                                {{ $instructorName }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 mb-3">
                                <select name="progress" class="form-select">
                                    <option value="">সব অগ্রগতি</option>
                                    <option value="not_started" {{ request('progress') == 'not_started' ? 'selected' : '' }}>শুরু হয়নি</option>
                                    <option value="in_progress" {{ request('progress') == 'in_progress' ? 'selected' : '' }}>চলমান</option>
                                    <option value="completed" {{ request('progress') == 'completed' ? 'selected' : '' }}>সমাপ্ত</option>
                                </select>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 mb-3">
                                <div class="filter-dropdown-box">
                                    <div class="dropdown">
                                        <button class="btn w-100" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false" id="dropdownBttn">
                                            সব
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item filterItem" href="#" data-value="">সব</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="best_rated">সর্বোচ্চ রেটেড</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="most_purchased">সর্বাধিক ক্রয়</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="newest">সর্বশেষ</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="recently_accessed">সাম্প্রতিক অ্যাক্সেস</a></li>
                                            <li><a class="dropdown-item filterItem" href="#"
                                                    data-value="oldest">পুরাতন</a></li>
                                        </ul>
                                    </div>
                                    <i class="fas fa-angle-down"></i>
                                    <input type="hidden" name="status" id="inputField" value="{{ request('status') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>ফিল্টার প্রয়োগ
                                </button>
                                <a href="{{ route('students.dashboard.enrolled') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-refresh me-2"></i>রিসেট
                                </a>
                            </div>
                            <div class="col-md-6 text-end mb-3">
                                <a href="{{ url('student/courses-activies/list') }}" class="btn btn-outline-info">
                                    <i class="fas fa-chart-line me-2"></i>কোর্স কার্যকলাপ
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @if (count($enrolments) > 0)
                    @foreach ($enrolments as $enrolment)
                        {{-- course single box start --}}
                        @if ($enrolment->course)
                        @php
                            $review_sum = 0;
                            $review_avg = 0;
                            $total = 0;
                            foreach ($enrolment->course->reviews as $review) {
                                $total++;
                                $review_sum += $review->star;
                            }
                            if ($total) {
                                $review_avg = $review_sum / $total;
                            }
                        @endphp
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mb-4">
                            <div class="course-single-item">
                                <div>
                                    <div class="course-thumb-box">
                                        <img src="{{ asset($enrolment->course->thumbnail) }}"
                                            alt="{{ $enrolment->course->slug }}" class="img-fluid">
                                    </div>
                                    <div class="course-txt-box">
                                        <a href="{{ url('student/courses/' . $enrolment->course->slug) }}">
                                            {{ Str::limit($enrolment->course->title, 45) }}</a>
                                        
                                        {{-- Status Badge --}}
                                        <div class="mb-2">
                                            @if($enrolment->status == 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i> অনুমোদনের অপেক্ষায়
                                                </span>
                                            @elseif($enrolment->status == 'approved')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> অনুমোদিত
                                                </span>
                                            @elseif($enrolment->status == 'payment_pending')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-credit-card me-1"></i> পেমেন্ট অপেক্ষায়
                                                </span>
                                            @endif
                                        </div>
                                        
                                        {!! Str::limit($enrolment->course->short_description, $limit = 260, $end = '...') !!}
                                        
                                        <ul>
                                            <li><span>{{ $review_avg }}</span></li>

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review_avg)
                                                    <li><i class="fas fa-star"></i></li>
                                                @else
                                                    <li><i class="fas fa-star not-rev"></i></li>
                                                @endif
                                            @endfor

                                            <li><span>({{ $total }})</span></li>
                                        </ul>


                                    </div>
                                </div>
                                <div class="course-txt-box pt-0">
                                    @if($enrolment->status == 'approved')
                                        {{-- Show progress for approved courses --}}
                                        <div class="course-progress-bar">
                                            <div class="progress" role="progressbar" aria-label="Basic example"
                                                aria-valuenow="{{ $enrolment->course->progress ?? 0 }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                                @if (($enrolment->course->progress ?? 0) == 100)
                                                    <div class="progress-bar course-gren-bg"
                                                        style="width: {{ $enrolment->course->progress ?? 0 }}%;">
                                                    </div>
                                                @else
                                                    <div class="progress-bar"
                                                        style="width: {{ $enrolment->course->progress ?? 0 }}%">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex">
                                                @if (($enrolment->course->progress ?? 0) == 100)
                                                    <h6 class="course-gren-colr">Completed</h6>
                                                    <h6 class="course-gren-colr">
                                                        {{ $enrolment->course->progress ?? 0 }}%</h6>
                                                @else
                                                    <h6>Incomplete</h6>
                                                    <h6>{{ $enrolment->course->progress ?? 0 }}%</h6>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($enrolment->status == 'pending')
                                        {{-- Show pending status for pending courses --}}
                                        <div class="course-progress-bar">
                                            <div class="text-center py-3">
                                                <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                                                <p class="text-warning mb-0"><strong>অনুমোদনের অপেক্ষায়</strong></p>
                                                <small class="text-muted">ইনস্ট্রাক্টর শীঘ্রই আপনার এনরোলমেন্ট অনুমোদন করবেন</small>
                                            </div>
                                        </div>
                                    @elseif($enrolment->status == 'payment_pending')
                                        {{-- Show payment pending status --}}
                                        <div class="course-progress-bar">
                                            <div class="text-center py-3">
                                                <i class="fas fa-credit-card text-danger fa-2x mb-2"></i>
                                                <p class="text-danger mb-0"><strong>পেমেন্ট অপেক্ষায়</strong></p>
                                                <small class="text-muted">কোর্স শুরু করতে পেমেন্ট সম্পন্ন করুন</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
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
                        {{ $enrolments->links('pagination::bootstrap-5') }}
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
