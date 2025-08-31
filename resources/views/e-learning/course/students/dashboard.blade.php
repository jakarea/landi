@extends('layouts/latest/students')
@section('title')
শিক্ষার্থী ড্যাশবোর্ড
@endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/ins-dashboard.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="student-dashboard-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="yearly-analitics">
                    <h1>বার্ষিক বিশ্লেষণ</h1>

                    {{-- yearly filter box --}}
                    {{-- <div class="dropdown">
                        <button type="button" class="btn btn-filter" data-bs-toggle="dropdown"
                            aria-expanded="false"><img src="{{ asset('assets/images/icons/filter.svg') }}"
                                alt="a" class="img-fluid"> Filters</button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">One Month</a></li>
                            <li><a class="dropdown-item" href="#">Three Months</a></li>
                            <li><a class="dropdown-item" href="#">Six Months</a></li>
                            <li><a class="dropdown-item" href="#">One Year</a></li>
                        </ul>
                    </div> --}}
                    {{-- yearly filter box --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="status-card-box">
                    <p>চলমান কোর্স</p>
                    <div class="d-flex">
                        <h5>{{ $inProgressCount }}</h5>
                        @php
                            $progPercentage = 0;
                            $totalCoureses = count($enrolments);
                            if($totalCoureses> 0 && $inProgressCount > 0)
                                $progPercentage = ($inProgressCount / $totalCoureses) * 100;
                        @endphp
                        <span>
                            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" alt="Test" class="img-fluid">
                            {{number_format(abs($progPercentage), 2)}}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="status-card-box">
                    <p>সম্পন্ন কোর্স</p>
                    <div class="d-flex">
                        <h5>{{ $completedCount }}</h5>
                        @php
                            $cmpltPercentage = 0;
                            $totalCoureses = count($enrolments);
                            if($totalCoureses> 0 && $completedCount > 0)
                            $cmpltPercentage = ($completedCount / $totalCoureses) * 100;
                        @endphp
                        <span>
                            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" alt="Test" class="img-fluid">
                            {{ number_format(abs($cmpltPercentage), 2) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="status-card-box">
                    <p>মোট দেখার সময়</p>
                    <div class="d-flex">
                        <h5>{{ $totalHours }} ঘণ্টা <b style="font-size: 1.25rem; font-weight:600">{{ $totalMinutes }} মিনিট</b></h5>
                        <span>
                            @if ($percentageChange > 0)
                            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" alt="Up"
                                class="img-fluid">
                            @elseif ($percentageChange < 0) <img
                                src="{{ asset('assets/images/icons/arrow-down.svg') }}" alt="Down"
                                class="img-fluid">
                                @endif
                                {{ number_format(abs($percentageChange), 2) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="status-card-box">
                    <p>সার্টিফিকেট অর্জন</p>
                    <div class="d-flex">
                        <h5>{{ $completedCount}}</h5>
                        @php
                            $cmpltPercentage = 0;
                            $totalCoureses = count($enrolments);
                            if($totalCoureses> 0 && $completedCount > 0)
                            $cmpltPercentage = ($completedCount / $totalCoureses) * 100;
                        @endphp
                        <span>
                            <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" alt="Test" class="img-fluid">
                            {{ number_format(abs($cmpltPercentage), 2) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mt-15">
                <div class="earnings-chart-wrap pb-0">
                    <div class="row align-items-start">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center">
                                <h5>সময় ব্যয়</h5>
                                <h3 class="ms-4">{{ $totalHours }}<sub class="text-muted"
                                        style="font-size: 1rem"> ঘণ্টা</sub>
                                    {{ $totalMinutes }}<sub class="text-muted" style="font-size: 1rem"> মিনিট</sub></h3>
                            </div>
                        </div>
                    </div>
                    <div id="timeSpendingChart"></div>
                </div>
            </div>
            <div class="col-xl-4 mt-15">
                <div class="top-performing-course fixed-height">
                    <div class="d-flex justify-content-between w-100">
                        <h5>আমার প্রোফাইল</h5>
                        <a href="{{ url('student/profile/myprofile') }}">প্রোফাইল দেখুন</a>
                    </div>
                    <div class="profile-widget-wrapper">
                        <div class="profile-widget-inner">

                            @if (auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                                class="img-fluid" width="100">
                            @else
                            <span class="avatar-user" style="width: 5rem; height: 5rem; border-radius: 50%; background: #ccc; display: inline-flex; align-items: center; justify-content:center; padding-right:0; font-size: 2rem; font-weight: 700;">{!! strtoupper(auth()->user()->name[0]) !!}</span>
                            @endif
                            <div class="profile-widget-info mt-2">
                                <h6 class="text-small">{{ auth()->user()->name }}</h6>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <ul class="profile-widget-history">
                            <li>
                                <h6>{{ $completedCount + 1 }}</h6>
                                <p>র‍্যাঙ্ক</p>
                            </li>
                            <li>
                                <h6>{{ $total_hr }}ঘ:{{ $total_min }}মি</h6>
                                <p>গড় সময়</p>
                            </li>
                            <li>
                                <h6>{{ $enrolled }}</h6>
                                <p>নথিভুক্ত</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mt-15">
                <div class="my-courses-box">
                    <h3>পছন্দের কোর্সসমূহ</h3>
                    <div class="course-box-overflown liked-courses">
                        @if (count($likeCourses) > 0)
                        @foreach ($likeCourses as $likeCourse)


                        @php
                            $totalLessons = 0;
                            $course = $likeCourse->course;

                            if ($course && $course->modules) {
                                foreach ($course->modules as $module) {
                                    if ($module && $module->lessons) {
                                        $totalLessons += count($module->lessons);
                                    }
                                }
                            }
                        @endphp

                        <div class="media">
                            @if ($likeCourse->course && $likeCourse->course->thumbnail)
                            <img src="{{ asset($likeCourse->course->thumbnail) }}" alt="a" class="img-fluid me-3 thumab">
                            @else
                            <img src="{{ asset('assets/images/course-small.svg') }}" alt="a"
                                class="img-fluid me-3 thumab">
                            @endif
                            <div class="media-body">
                                <h5><a href="{{ url('student/courses/overview/' . $likeCourse->course->slug) }}">{{ optional($likeCourse->course)->title }}</a></h5>
                                <p class="user"><i class="fa-solid fa-user"></i> {{ optional($likeCourse->course->user)->name }}

                                    &nbsp; - &nbsp;{{ optional($likeCourse->course)->platform }}</p>
                                <p class="lessons">
                                    <img src="{{ asset('assets/images/icons/modules.svg') }}" alt="a" class="img-fluid">
                                     {{ count($likeCourse->course->modules) }} Modules &nbsp;&nbsp;
                                     <img src="{{ asset('assets/images/icons/modules.svg') }}" alt="a" class="img-fluid"> {{ $totalLessons }} Lessons
                                </p>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-filter" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i
                                    class="fa-solid fa-ellipsis-vertical"></i></button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('student.courses.unlike', $likeCourse->course->slug) }}" method="POST" class="d-block">
                                            @csrf
                                            <button type="submit" class="btn p-0 dropdown-item">অপছন্দ</button>
                                        </form>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('student/courses/'.$likeCourse->course->slug) }}">শুরু করুন</a></li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        @else
                            @include('partials/no-data')
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-15">
                <div class="chart-box-wrap">
                    <div class="statics-head">
                        <h5>কোর্সের পরিসংখ্যান</h5>
                    </div>
                    <div class="course-progress-box">
                        <div class="txt">
                            <h5>{{ count($enrolments) }}</h5>
                            <p>মোট কোর্স</p>
                        </div>
                        <canvas id="myCourseStatics"></canvas>
                        <div id="legend"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-15">
                <div class="course-status-wrap">
                    <div class="d-flex">
                        <h4>কোর্সের অবস্থা</h4>
                        @if (count($enrolments) > 3)
                        <div>
                            <a href="{{ url('student/dashboard/enrolled') }}" class="me-0">সব দেখুন</a>
                        </div>
                        @endif

                    </div>
                    @if (count($enrolments) > 0)
                    <table>
                        <tr>
                            <th width="40%">কোর্সের নাম</th>
                            <th>মূল্য</th>
                            <th width="22%">অগ্রগতি</th>
                            <th>শুরুর তারিখ</th>
                            <th class="text-end">কার্যক্রম</th>
                        </tr>
                        @foreach ($enrolments->slice(0, 4) as $enrolment)

                        @if ($enrolment->course)
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="avatar">
                                        <img src="{{ asset($enrolment->course->thumbnail) }}" alt="Thumb"
                                            class="img-fluid">
                                    </div>
                                    <div class="media-body">
                                        <h5><a class="bg-transparent" href="{{ url('student/courses/my-courses/details/' . $enrolment->course->slug) }}">{{$enrolment->course->title}}</a></h5>
                                        <p>{{ $enrolment->course->platform }} </p>
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
                                </div>
                            </td>
                            <td>
                                <p>৳ {{$enrolment->amount}}</p>
                            </td>
                            @php
                            $courseProgress = null;
                            $courseProgress = StudentActitviesProgress(auth()->user()->id, $enrolment->course->id);
                            @endphp
                            <td>
                                <p>{{ $courseProgress }}%</p>
                                <div class="progress" role="progressbar" aria-label="Basic example"
                                    aria-valuenow="{{ $courseProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: {{ $courseProgress }}%"></div>
                                </div>
                            </td>
                            <td>
                                <p>{{ $enrolment->created_at->format('d-F-Y') }}</p>
                            </td>
                            <td class="text-end">
                                @if($enrolment->status == 'approved')
                                    <a href="{{ url('student/courses/'.$enrolment->course->slug) }}" class="btn btn-primary btn-sm">শুরু করুন</a>
                                @elseif($enrolment->status == 'pending')
                                    <small class="text-warning">অনুমোদনের অপেক্ষায়</small>
                                @elseif($enrolment->status == 'payment_pending')
                                    <a href="{{ url('courses/'.$enrolment->course->slug.'/enroll') }}" class="btn btn-warning btn-sm">পেমেন্ট সম্পন্ন করুন</a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    @else
                        @include('partials/no-data')
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script>
        const modess = document.querySelector("body").classList.contains('dark-mode') ? 'dark-mode' : '';
        modeCall(modess);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- time spend chart start --}}
<script>
    jQuery(document).ready(function() {
            var timeSpentData = @json($timeSpentData);

            var options = {
                series: [{
                    name: "Time spend",
                    data: timeSpentData.map(item => item.time_spent),
                }],
                chart: {
                    height: 280,
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#294CFF'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: timeSpentData.map(item => item.month),
                }
            };
            var chart = new ApexCharts(document.querySelector("#timeSpendingChart"), options);
            chart.render();
        });
</script>
{{-- time spend chart end --}}

{{-- course statics chart start --}}
<script>
    let completedCount = @json($completedCount);
    let notStartedCount = @json($notStartedCount);
    let inProgressCount = @json($inProgressCount);

    var data = [completedCount, inProgressCount, notStartedCount];
    var total = data.reduce((a, b) => a + b, 0);
    var percentages = data.map((value) => ((value / total) * 100).toFixed(0) + "%");

    var ctx = document.getElementById('myCourseStatics').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'সম্পন্ন',
                'চলমান',
                'শুরু হয়নি',
            ],
            datasets: [{
                label: 'কোর্সের অগ্রগতি',
                data: data,
                backgroundColor: [
                    '#00AB55',
                    '#00B8D9',
                    '#FFAB00'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                display: false
                }
            },
            title: {
                display: true,
                text: 'Course Statistics'
            },
            legend: {
                display: false,
            },
            tooltips: {
                enabled: false
            },
            cutout: '88%',
            radius: 120,
        },
    });

    var legendHtml = "<ul>";
for (var i = 0; i < myDoughnutChart.data.labels.length; i++) {
    var percentage = percentages[i];
    if (percentage === "NaN%") {
        percentage = "0%";
    }
    legendHtml +=
        '<li>' + '<p> <span style="background-color:' +
        myDoughnutChart.data.datasets[0].backgroundColor[i] +
        '"></span> ' + myDoughnutChart.data.labels[i] + '</p>' + '<h6>' + percentage + '</h6>' +
        "</li>";
}
legendHtml += "</ul>";

document.getElementById("legend").innerHTML = legendHtml;


</script>
{{-- course statics chart end --}}
@endsection
{{-- page script @E --}}
