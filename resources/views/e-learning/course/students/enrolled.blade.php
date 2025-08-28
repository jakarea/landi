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
                            <div class="course-single-item modern-course-card">
                                <div class="course-card-content">
                                    <div class="course-thumb-box">
                                        <img src="{{ asset($enrolment->course->thumbnail) }}"
                                            alt="{{ $enrolment->course->slug }}" class="img-fluid">
                                        
                                        {{-- Status Badge --}}
                                        <div class="status-badge-overlay">
                                            @if($enrolment->status == 'pending')
                                                <span class="modern-badge pending-badge">
                                                    <i class="fas fa-clock"></i> অনুমোদনের অপেক্ষায়
                                                </span>
                                            @elseif($enrolment->status == 'approved')
                                                <span class="modern-badge approved-badge">
                                                    <i class="fas fa-check-circle"></i> অনুমোদিত
                                                </span>
                                            @elseif($enrolment->status == 'payment_pending')
                                                <span class="modern-badge payment-badge">
                                                    <i class="fas fa-credit-card"></i> পেমেন্ট প্রয়োজন
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="course-txt-box">
                                        <div class="course-meta-info mb-2">
                                            <div class="rating-info">
                                                <div class="star-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review_avg)
                                                            <i class="fas fa-star filled"></i>
                                                        @else
                                                            <i class="fas fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="rating-score">{{ number_format($review_avg, 1) }}</span>
                                                <span class="review-count">({{ $total }})</span>
                                            </div>
                                        </div>
                                        
                                        <h3 class="course-title">
                                            <a href="{{ url('student/courses/' . $enrolment->course->slug) }}">
                                                {{ Str::limit($enrolment->course->title, 50) }}
                                            </a>
                                        </h3>
                                        
                                        <p class="course-description">
                                            {{ Str::limit(strip_tags($enrolment->course->short_description), 80, '...') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="modern-course-footer">
                                    @if($enrolment->status == 'approved')
                                        {{-- Show progress for approved courses --}}
                                        <div class="modern-progress-section">
                                            <div class="progress-header">
                                                <span class="progress-label">অগ্রগতি</span>
                                                <span class="progress-percentage">{{ $enrolment->course->progress ?? 0 }}%</span>
                                            </div>
                                            <div class="modern-progress-bar">
                                                <div class="progress-track">
                                                    <div class="progress-fill {{ ($enrolment->course->progress ?? 0) == 100 ? 'completed' : '' }}"
                                                        style="width: {{ $enrolment->course->progress ?? 0 }}%"></div>
                                                </div>
                                            </div>
                                            @if (($enrolment->course->progress ?? 0) == 100)
                                                <div class="completion-badge">
                                                    <i class="fas fa-check-circle"></i> সম্পন্ন
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($enrolment->status == 'pending')
                                        {{-- Show pending status for pending courses --}}
                                        <div class="modern-status-section pending">
                                            <div class="status-content">
                                                <i class="fas fa-hourglass-half"></i>
                                                <div class="status-text">
                                                    <strong>অনুমোদনের অপেক্ষায়</strong>
                                                    <small>ইনস্ট্রাক্টর শীঘ্রই অনুমোদন করবেন</small>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($enrolment->status == 'payment_pending')
                                        {{-- Show payment pending status --}}
                                        <div class="modern-status-section payment">
                                            <div class="status-content">
                                                <i class="fas fa-credit-card"></i>
                                                <div class="status-text">
                                                    <strong>পেমেন্ট প্রয়োজন</strong>
                                                    <small>কোর্স শুরু করতে পেমেন্ট সম্পন্ন করুন</small>
                                                </div>
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
