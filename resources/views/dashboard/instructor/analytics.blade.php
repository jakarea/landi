@extends('layouts.latest.instructor')
@section('title', 'Instructor Analytics')
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<main class="dashboard-page-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="yearly-analitics">
                    <h1>{{$analytics_title}}</h1>

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
            <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Students</h5>
                            <h4> {{ $currentMonthEnrolledStudentsCount }} </h4>
                        </div>
                    </div>
                    <p> <b style="color: {{ $formatedPercentageChangeOfStudentEnroll >= 0 ? 'green' : 'red' }}">{{
                            number_format($formatedPercentageChangeOfStudentEnroll, 0) }}</b>
                        % VS last {{$compear}}</p>
                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Courses</h5>
                            <h4> {{ count($courses) }} </h4>
                        </div>
                    </div>
                    <p> <b style="color: {{ $formatedPercentageOfCourse >= 0 ? 'green' : 'red' }}">{{
                            number_format($formatedPercentageOfCourse, 0) }}</b>
                        % VS last {{$compear}}</p>
                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    <div class="media">
                        <div class="media-body">
                            <h5>Earnings</h5>
                            {{-- <h4>৳{{ count($earningByDates) }}</h4> --}}
                            <h4>৳{{ $totalAmounts }}</h4>
                        </div>
                    </div>
                    <p> <b style="color: {{ $formattedPercentageChangeOfEarning >= 0 ? 'green' : 'red' }}">{{
                            number_format($formattedPercentageChangeOfEarning, 0) }}</b>
                        % VS last {{$compear}}</p>
                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>

            </div>
            <div class="col-12 col-sm-6 col-xl-4 col-xxl-3">
                <div class="total-client-box">
                    @php
                    
                    $totalCombinedCourses = $activeCourses + $draftCourses;

                    if ($totalCombinedCourses > 0) {
                        $percentageActiveCourses = ($activeCourses / $totalCombinedCourses) * 100;
                    } else {
                        $percentageActiveCourses = 0;
                    }
                    @endphp

                    <div class="media">
                        <div class="media-body">
                            <h5>Sell Rating</h5>
                            <h4>{{ ceil($percentageActiveCourses) }}%</h4>
                        </div>
                    </div>
                    <p>All time stats</p>
                    <img src="{{ asset('assets/images/chart.svg') }}" alt="Chart" class="img-fluid light-ele">
                    <img src="{{ asset('assets/images/chart-d.svg') }}" alt="Chart" class="img-fluid dark-ele">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-15">
                <div class="chart-box-wrap">
                    <div class="statics-head d-flex align-items-center">
                        <h5>Earnings</h5>
                        <p class="common-para ms-3"> <b
                                style="color: {{ $formattedPercentageChangeOfEarning >= 0 ? 'green' : 'red' }}">{{
                                number_format($formattedPercentageChangeOfEarning, 0) }}</b>
                            % VS last {{$compear}}</p>
                    </div>
                    <div id="earningChart"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mt-15">
                <div class="chart-box-wrap">
                    <div class="statics-head">
                        <h5>Monthly Earning</h5>
                    </div>
                    <div id="monthlyEarningGraph"></div>
                </div>
            </div>
            <div class="col-lg-4 mt-15">
                <div class="chart-box-wrap">
                    <div class="statics-head">
                        <h5>Course Progress</h5>
                    </div>
                    <div class="course-progress-box">
                        <div class="txt">
                            <h5>{{ count($courses) }}</h5>
                            <p>Total Courses</p>
                        </div>
                        <canvas id="courseProgress"></canvas>
                        <div id="legend" class="legend center-legend"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mt-15">
                <div class="chart-box-wrap">
                    <div class="statics-head custom-flex">
                        <h5>Students</h5>
                        <div class="header-flex">
                            <div>
                                <span style="background-color: #00AB55;"></span> Active Students
                            </div>
                            <div>
                                <span style="background-color: #FFAB00;"></span> Inactive
                            </div>
                        </div>
                    </div>
                    <div id="studentsGraph"></div>
                </div>
            </div>
            <div class="col-lg-4 mt-15">
                <div class="top-performing-course">
                    <div class="d-flex">
                        <h5>Message</h5>
                        @if (count($messages) > 5)
                        <a href="{{ url('course/messages') }}">View All</a>
                        @endif
                    </div>
                    <div class="messages-items-wrap">
                        @if (count($messages) > 0)
                        @foreach ($messages->slice(0, 5) as $message)
                        <div class="messages-item">
                            <div class="media">
                                <div class="avatar">

                                    @if ($message->groupUserName && $message->groupUserName->avatar)
                                        <img src="{{ asset($message->groupUserName->avatar) }}" alt="{!! strtoupper($message->groupUserName->name[0]) !!}" class="img-fluid">
                                    @else 
                                        <span class="user-name-avatar me-2">{!! strtoupper(optional($message->groupUserName)->name[0]) !!}</span>
                                    @endif  


                                    @if(Cache::has('user-is-online-' . $message->groupUserName->id))
                                        <i class="fas fa-circle"></i>
                                    @else
                                        <i class="fa-regular fa-circle"></i>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h5>{{ $message->user ? $message->user->name : 'User not found!' }}
                                        <span>{{ $message->created_at->diffForHumans() }}</span>
                                    </h5>
                                    <p>{{ $message->message }}</p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- statudents status start --}}
<script>
    const data = @json($activeInActiveStudents);

        var options = {
            series: [
                {
                    name: '',
                    data: data.active_students
                },
                {
                    name: '',
                    data: data.inactive_students
                }
            ],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: true,
                borderColor: '#C2C6CE',
                strokeDashArray: 0,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            colors: ['#00AB55', '#FFAB00'],
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            legend: {
                show: false // Hide the legend
            },
            toolbar: {
                show: false // Hide the top toolbar
            }
        };

        var chart = new ApexCharts(document.querySelector("#studentsGraph"), options);
        chart.render();
</script>
{{-- statudents status end --}}

{{-- Total earnings start --}}
<script>

    let newdata = @json($earningByDates);

// Create an object to store data for the current month
const currentMonthData = {};

const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = currentDate.getMonth() + 1; // JavaScript months are zero-based

// Iterate through the data and filter it for the current month
for (const date in newdata) {
    const dateObj = new Date(date);
    const year = dateObj.getFullYear();
    const month = dateObj.getMonth() + 1;

    if (year === currentYear && month === currentMonth) {
        currentMonthData[date] = newdata[date];
    }
}

const chartData = Object.keys(currentMonthData).map((date) => {
    return {
        x: new Date(date).getTime(),
        y: currentMonthData[date]
    };
});

var options = {
    series: [{
        data: chartData
    }],
    chart: {
        id: 'area-datetime',
        type: 'area',
        height: 350,
        toolbar: {
            show: false
        },
        zoom: {
            autoScaleYaxis: true
        }
    },
    dataLabels: {
        enabled: false
    },
    markers: {
        size: 0,
        style: 'hollow',
    },
    xaxis: {
        type: 'datetime',
        tickAmount: 6,
    },
    colors: ['#294CFF'],
    tooltip: {
        x: {
            format: 'dd MMM yyyy'
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 100]
        }
    },
};

var chart = new ApexCharts(document.querySelector("#earningChart"), options);
chart.render();


</script>
{{-- Total earnings end --}}

{{-- monthly earning start --}}
<script>
    const earningsByMonths = @json($earningByMonth);

        var options = {
            series: [{
                name: 'Monthly Earnings',
                data: earningsByMonths
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                },
            },
            colors: ['#294CFF', '#E7EBFF'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    borderRadius: 2,
                    endingShape: 'rounded',

                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            fill: {
                opacity: 1
            },
            grid: {
                show: true,
                borderColor: '#C2C6CE',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#monthlyEarningGraph"), options);
        chart.render();
</script>
{{-- monthly earning end --}}

{{-- course progress chart start --}}
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

{{-- course progress chart start --}}
<script>
    var datas = [{{ $activeCourses }}, {{ $draftCourses }}];

        var backgroundColor = ['#FFAB00', '#294CFF'];
        var ctx = document.getElementById('courseProgress').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Complete', 'Inprogress'],
                datasets: [{
                    label: 'Course Progress',
                    data: datas,
                    backgroundColor: backgroundColor,
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
                    text: 'Chart Donut'
                },
                legend: {
                    display: false
                },
                cutout: '70%',
                radius: 120
            }
        });

        // Calculate percentages
        var total = datas.reduce((a, b) => a + b, 0);
        // var percentages = datas.map((value) => ((value / total) * 100).toFixed(0) + "%");
        var percentages = datas.map((value) => {
            if (value === 0 || total === 0) {
                return "0%";
            } else {
                return ((value / total) * 100).toFixed(0) + "%";
            }
        });

        console.log({ percentages, total })
        // Generate and display the custom legend
        var legendHtml = "<ul>";
        for (var i = 0; i < myDoughnutChart.data.labels.length; i++) {
            legendHtml +=
                '<li>' + '<p> <span style="background-color:' +
                myDoughnutChart.data.datasets[0].backgroundColor[i] +
                '"></span> ' + myDoughnutChart.data.labels[i] + '</p>' + '<h6>' + percentages[i] + '</h6>' +
                "</li>";
        }
        legendHtml += "</ul>";
        document.getElementById("legend").innerHTML = legendHtml;
</script>
{{-- course progress chart end --}}
@endsection
