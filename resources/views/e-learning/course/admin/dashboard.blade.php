@extends('layouts.latest.admin')
@section('title','Admin Dashboard')
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/ins-dashboard.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="dashboard-page-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="yearly-analitics">
                    <h1>{{ $analytics_title }}</h1>
                    {{-- yearly filter box --}}
                    <div class="dropdown">
                        <button type="button" class="btn btn-filter" data-bs-toggle="dropdown" aria-expanded="false"
                            id="filterDropdownButton">
                            <img src="{{ asset('assets/images/icons/filter.svg') }}" alt="a" class="img-fluid">
                            Filters
                        </button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-option" href="#" data-duration="one_month">One
                                    Month</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-duration="three_months">Three
                                    Months</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-duration="six_months">Six
                                    Months</a></li>
                            <li><a class="dropdown-item filter-option" href="#" data-duration="one_year">One
                                    Year</a></li>
                        </ul>
                    </div>
                    {{-- yearly filter box --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Students</h5>
                            <h4> {{ $studentsCount }}</h4>
                        </div>
                    </div>
                    <p> <b style="color: {{ $percentageChangeOfStudent >= 0 ? 'green' : 'red' }}">{{
                            $percentageChangeOfStudent >= 0 ? '+' . $percentageChangeOfStudent :
                            $percentageChangeOfStudent }}%</b>
                        VS last {{$compear}}</p>

                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Instructors</h5>
                            <h4> {{ $instructorsCount }}</h4>
                        </div>
                    </div>
                    <p><b style="color: {{ $percentageChangeOfInstructor >= 0 ? 'green' : 'red' }}">{{
                            $percentageChangeOfInstructor >= 0 ? '+' . $percentageChangeOfInstructor :
                            $percentageChangeOfInstructor }}%</b> VS last {{$compear}}</p>

                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Courses</h5>
                            <h4> {{ $courseCount }}</h4>
                        </div>
                    </div>
                    <p><b style="color: {{ $percentageChangeOfCourse >= 0 ? 'green' : 'red' }}">{{
                            $percentageChangeOfCourse >= 0 ? '+' . number_format($percentageChangeOfCourse,0) :
                            number_format($percentageChangeOfCourse,0) }}%</b> VS last {{$compear}}</p>

                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Earnings</h5>
                            <h4>৳{{ $totalEarnings }}</h4>
                        </div>
                    </div>
                    <p> <b style="color: {{ $earningParcentage >= 0 ? 'green' : 'red' }}">{{ $earningParcentage >= 0 ?
                            '+' . $earningParcentage : $earningParcentage }}%</b>
                        VS last {{$compear}}</p>

                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mt-15">
                <div class="earnings-chart-wrap">
                    <div class="row align-items-start">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center">
                                <h5>Revenue</h5>
                                <p class="common-para ms-3"> <b
                                        style="color: {{ $earningParcentage >= 0 ? 'green' : 'red' }}">{{
                                        $earningParcentage >= 0 ?
                                        '+' . $earningParcentage : $earningParcentage }}%</b>
                                    VS last {{$compear}}</p>
                            </div>
                        </div>
                    </div>
                    <div id="totalRevenueChart"></div>
                </div>
            </div>
            <div class="col-xl-4 mt-15">
                <div class="top-performing-course">
                    <div class="d-flex">
                        <h5>Top Performing Courses</h5>
                        @if (count($TopPerformingCourses) > 5)
                        <a href="{{ url('admin/top-perform/courses') }}">View All</a>
                        @endif
                    </div>
                    <div class="course-lists ms-0 mt-2">
                        @if (count($TopPerformingCourses))
                        @php
                        $sale_count = $TopPerformingCourses[0]->sale_count;
                        $sn = 1;
                        @endphp
                        @foreach ($TopPerformingCourses->slice(0, 5) as $course)
                        @php
                        if ($course->sale_count < $sale_count && $sn < 3) { $sale_count=$course->sale_count;
                            $sn++;
                            }
                            @endphp
                            <div class="media">
                                <img src="{{ asset($course->thumbnail) }}" alt="Avatar" class="img-fluid">
                                <div class="media-body">
                                    <h5>
                                        <a href="{{ url('admin/courses/overview', $course->slug) }}">
                                        {{ substr($course->title ? $course->title : 'Untitled Course', 0, 20) . '...' }}</a>
                                    </h5>
                                    <p> {{ $course->categories }} </p>
                                </div>
                                <img src="{{ asset('assets/images/tofy-' . $sn . '.svg') }}" alt="Avatar"
                                    class="img-fluid me-0">
                            </div>
                            @endforeach
                            @else
                            @include('partials/no-data')
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mt-15">
                <form action="" method="GET" id="myForm">
                    <input type="hidden" name="status" id="inputField">
                </form>
                <div class="course-status-wrap">
                    <div class="d-flex py-0 pe-0">
                        <h4>Course Status</h4>
                        <div class="d-flex">
                            @if (count($courses) > 5)
                            <a href="{{ url('admin/courses') }}" class="me-0">View All</a>
                            @endif

                            <div class="dropdown course-status-filter">
                                <button type="button" class="btn" id="dropdownBttn" data-bs-toggle="dropdown"
                                    aria-expanded="false">All <i class="fas fa-angle-down"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item filterItem" href="javascript:void(0)">All</a></li>
                                    <li><a class="dropdown-item filterItem" href="javascript:void(0)"
                                            data-value="one">This Month</a></li>
                                    <li><a class="dropdown-item filterItem" href="javascript:void(0)"
                                            data-value="three">Three Months</a></li>
                                    <li><a class="dropdown-item filterItem" href="javascript:void(0)"
                                            data-value="six">Six Months</a></li>
                                    <li><a class="dropdown-item filterItem" href="javascript:void(0)"
                                            data-value="year">One Year</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if (count($courses) > 0)
                    <table>
                        <tr>
                            <th>Course Name</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>Earning</th>
                            <th class="text-end">Sell</th>
                        </tr>
                        @foreach ($courses->slice(0,6) as $course)
                        <tr>
                            <td>
                                <div class="media me-4 me-lg-0">
                                    <div class="avatar">
                                        <img src="{{ asset($course->thumbnail) }}" alt="c-status" class="img-fluid">
                                    </div>
                                    <div class="media-body">
                                        <h5><a href="{{ url('admin/courses/overview/'.$course->slug) }}"
                                                class="p-0 bg-transparent">{{ substr($course->title ? $course->title : 'Untitled Course', 0, 35) }}</a></h5>
                                        <p> {{ $course->categories }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>{{ ($course->offer_price ? ($price = $course->offer_price) : ($price =
                                    $course->price)) ? '৳' . $price : 'Free' }}
                                </p>
                            </td>
                            <td>
                                <p><i class="fas fa-star me-2" style="color: #F8AA00;"></i> {{
                                    number_format($course->avg_rating, 1) }}</p>
                            </td>
                            <td>
                                <p>৳{{ $course->sum_amount ? $course->sum_amount : 0 }}</p>
                            </td>
                            <td class="text-end">
                                <p>{{ $course->sale_count }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    @include('partials/no-data')
                    @endif
                </div>
            </div>
            <div class="col-xl-4 mt-15">
                <div class="top-performing-course">
                    <div class="d-flex">
                        <h5>Message</h5>
                        @if (count($lastMessages) > 6)
                        <a href="#">View All</a>
                        @endif
                    </div>
                    <div class="messages-items-wrap">
                        @if (count($lastMessages) > 0)
                        @foreach ($lastMessages->slice(0, 7) as $message)
                        <div class="messages-item">
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset($message->user->avatar) }}" alt="Avatar" class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <h5>{{ $message->user->name }}
                                        <span>{{ $message->created_at->diffForHumans() }}</span>
                                    </h5>
                                    <p>{{ substr($message->message, 0, 34) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        @include('partials/no-data')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
        const modess = document.querySelector("body").classList.contains('dark-mode') ? 'dark-mode' : '';
        modeCall(modess);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- course status filter --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let inputField = document.getElementById("inputField");
        let dropbtn = document.getElementById("dropdownBttn");
        let form = document.getElementById("myForm");
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let status = urlParams.get('status');
        let dropdownItems = document.querySelectorAll(".filterItem");

        if (status == "one") {
            dropbtn.innerHTML = 'This Month' + '<i class="fas fa-angle-down"></i>';
        }
        if (status == "three") {
            dropbtn.innerHTML = 'Three Month' + '<i class="fas fa-angle-down"></i>';
        }
        if (status == "six") {
            dropbtn.innerHTML = 'Six Month' + '<i class="fas fa-angle-down"></i>';
        }
        if (status == "year") {
            dropbtn.innerHTML = 'One Year' + '<i class="fas fa-angle-down"></i>';
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

{{-- time spend chart start --}}
<script>
    jQuery(document).ready(function() {
            var timeSpentData = @json($earningByMonth);
            var options = {
                series: [{
                    name: "Revenue",
                    data: timeSpentData,
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
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                }
            };
            var chart = new ApexCharts(document.querySelector("#totalRevenueChart"), options);
            chart.render();
        });
</script>

<script>
    $(document).ready(function() {
            $(".filter-option").click(function(e) {
                e.preventDefault();
                var duration = $(this).data("duration");

                var currentUrl = window.location.href;
                var updatedUrl = updateQueryStringParameter(currentUrl, 'duration', duration);
                history.pushState({
                    path: updatedUrl
                }, '', updatedUrl);

                window.location.reload();
            });

            function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
        });
</script>
@endsection
