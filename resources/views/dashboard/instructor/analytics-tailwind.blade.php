@extends('layouts.instructor-tailwind')
@section('title', 'ইনস্ট্রাক্টর অ্যানালিটিক্স')
@section('header-title', $analytics_title)
@section('header-subtitle', 'আপনার কোর্স ও আয়ের পরিসংখ্যান')

@section('style')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-white font-semibold text-xl mb-1">{{ $analytics_title }}</h2>
                <p class="text-secondary-200">আপনার কোর্স ও আয়ের বিস্তারিত পরিসংখ্যান</p>
            </div>
            
            <!-- Filter Dropdown -->
            <div class="relative">
                @php
                    $currentDuration = request('duration');
                    $durationTexts = [
                        'one_month' => 'এক মাস',
                        'three_months' => 'তিন মাস',
                        'six_months' => 'ছয় মাস',
                        'one_year' => 'এক বছর'
                    ];
                    $currentText = $currentDuration && isset($durationTexts[$currentDuration]) ? $durationTexts[$currentDuration] : 'ফিল্টার';
                @endphp
                <button id="filterBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-primary rounded-lg text-secondary-100 anim hover:bg-orange hover:text-primary">
                    <i class="fas fa-filter"></i>
                    <span>{{ $currentText }}</span>
                    <i class="fas fa-chevron-down text-sm"></i>
                </button>
                
                <div id="filterDropdown" class="absolute right-0 mt-2 w-48 bg-card rounded-lg shadow-1 border border-[#fff]/20 hidden z-10">
                    <div class="py-2">
                        <a href="?duration=one_month" class="flex items-center gap-2 px-4 py-2 text-secondary-100 hover:bg-primary hover:text-white anim {{ $currentDuration == 'one_month' ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-calendar-day text-xs"></i>
                            এক মাস
                            @if($currentDuration == 'one_month')
                                <i class="fas fa-check text-xs ml-auto"></i>
                            @endif
                        </a>
                        <a href="?duration=three_months" class="flex items-center gap-2 px-4 py-2 text-secondary-100 hover:bg-primary hover:text-white anim {{ $currentDuration == 'three_months' ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-calendar-week text-xs"></i>
                            তিন মাস
                            @if($currentDuration == 'three_months')
                                <i class="fas fa-check text-xs ml-auto"></i>
                            @endif
                        </a>
                        <a href="?duration=six_months" class="flex items-center gap-2 px-4 py-2 text-secondary-100 hover:bg-primary hover:text-white anim {{ $currentDuration == 'six_months' ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-calendar-alt text-xs"></i>
                            ছয় মাস
                            @if($currentDuration == 'six_months')
                                <i class="fas fa-check text-xs ml-auto"></i>
                            @endif
                        </a>
                        <a href="?duration=one_year" class="flex items-center gap-2 px-4 py-2 text-secondary-100 hover:bg-primary hover:text-white anim {{ $currentDuration == 'one_year' ? 'bg-primary text-white' : '' }}">
                            <i class="fas fa-calendar text-xs"></i>
                            এক বছর
                            @if($currentDuration == 'one_year')
                                <i class="fas fa-check text-xs ml-auto"></i>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Students Card -->
        <div class="bg-card rounded-xl p-6 shadow-2 smooth-bounce">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-blue/20 flex items-center justify-center">
                            <i class="fas fa-users text-blue text-sm"></i>
                        </div>
                        <h3 class="text-secondary-200 font-medium text-sm">শিক্ষার্থী</h3>
                    </div>
                    <p class="text-white font-bold text-2xl mb-2">{{ $currentMonthEnrolledStudentsCount }}</p>
                    <div class="flex items-center gap-1">
                        <span class="text-xs px-2 py-1 rounded-full {{ $formatedPercentageChangeOfStudentEnroll >= 0 ? 'bg-lime/20 text-lime' : 'bg-orange/20 text-orange' }}">
                            <i class="fas fa-arrow-{{ $formatedPercentageChangeOfStudentEnroll >= 0 ? 'up' : 'down' }} mr-1"></i>
                            {{ number_format(abs($formatedPercentageChangeOfStudentEnroll), 0) }}%
                        </span>
                        <span class="text-secondary-200 text-xs">গত {{ $compear }} থেকে</span>
                    </div>
                </div>
                <div class="text-blue opacity-20">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Courses Card -->
        <div class="bg-card rounded-xl p-6 shadow-2 smooth-bounce">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-orange/20 flex items-center justify-center">
                            <i class="fas fa-book text-orange text-sm"></i>
                        </div>
                        <h3 class="text-secondary-200 font-medium text-sm">কোর্স</h3>
                    </div>
                    <p class="text-white font-bold text-2xl mb-2">{{ count($courses) }}</p>
                    <div class="flex items-center gap-1">
                        <span class="text-xs px-2 py-1 rounded-full {{ $formatedPercentageOfCourse >= 0 ? 'bg-lime/20 text-lime' : 'bg-orange/20 text-orange' }}">
                            <i class="fas fa-arrow-{{ $formatedPercentageOfCourse >= 0 ? 'up' : 'down' }} mr-1"></i>
                            {{ number_format(abs($formatedPercentageOfCourse), 0) }}%
                        </span>
                        <span class="text-secondary-200 text-xs">গত {{ $compear }} থেকে</span>
                    </div>
                </div>
                <div class="text-orange opacity-20">
                    <i class="fas fa-book text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Earnings Card -->
        <div class="bg-card rounded-xl p-6 shadow-2 smooth-bounce">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-lime/20 flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-lime text-sm"></i>
                        </div>
                        <h3 class="text-secondary-200 font-medium text-sm">আয়</h3>
                    </div>
                    <p class="text-white font-bold text-2xl mb-2">৳{{ number_format($totalAmounts) }}</p>
                    <div class="flex items-center gap-1">
                        <span class="text-xs px-2 py-1 rounded-full {{ $formattedPercentageChangeOfEarning >= 0 ? 'bg-lime/20 text-lime' : 'bg-orange/20 text-orange' }}">
                            <i class="fas fa-arrow-{{ $formattedPercentageChangeOfEarning >= 0 ? 'up' : 'down' }} mr-1"></i>
                            {{ number_format(abs($formattedPercentageChangeOfEarning), 0) }}%
                        </span>
                        <span class="text-secondary-200 text-xs">গত {{ $compear }} থেকে</span>
                    </div>
                </div>
                <div class="text-lime opacity-20">
                    <i class="fas fa-dollar-sign text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Sell Rating Card -->
        <div class="bg-card rounded-xl p-6 shadow-2 smooth-bounce">
            @php
                $totalCombinedCourses = $activeCourses + $draftCourses;
                if ($totalCombinedCourses > 0) {
                    $percentageActiveCourses = ($activeCourses / $totalCombinedCourses) * 100;
                } else {
                    $percentageActiveCourses = 0;
                }
            @endphp
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-full bg-blue/20 flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue text-sm"></i>
                        </div>
                        <h3 class="text-secondary-200 font-medium text-sm">বিক্রয় রেটিং</h3>
                    </div>
                    <p class="text-white font-bold text-2xl mb-2">{{ ceil($percentageActiveCourses) }}%</p>
                    <p class="text-secondary-200 text-xs">সব সময়ের পরিসংখ্যান</p>
                </div>
                <div class="text-blue opacity-20">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Earnings Chart -->
        <div class="bg-card rounded-xl p-6 shadow-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-white font-semibold text-lg">আয়ের গ্রাফ</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs px-2 py-1 rounded-full {{ $formattedPercentageChangeOfEarning >= 0 ? 'bg-lime/20 text-lime' : 'bg-orange/20 text-orange' }}">
                            <i class="fas fa-arrow-{{ $formattedPercentageChangeOfEarning >= 0 ? 'up' : 'down' }} mr-1"></i>
                            {{ number_format(abs($formattedPercentageChangeOfEarning), 0) }}%
                        </span>
                        <span class="text-secondary-200 text-xs">গত {{ $compear }} থেকে</span>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-blue/20 flex items-center justify-center">
                    <i class="fas fa-chart-area text-blue text-sm"></i>
                </div>
            </div>
            <div id="earningChart"></div>
        </div>

        <!-- Course Progress Chart -->
        <div class="bg-card rounded-xl p-6 shadow-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-white font-semibold text-lg">কোর্সের অগ্রগতি</h3>
                    <p class="text-secondary-200 text-sm">{{ count($courses) }} টি মোট কোর্স</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-orange/20 flex items-center justify-center">
                    <i class="fas fa-chart-pie text-orange text-sm"></i>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <div class="relative w-48 h-48 mb-4">
                    <canvas id="courseProgress"></canvas>
                </div>
                <div id="legend" class="space-y-2"></div>
            </div>
        </div>
    </div>

    <!-- Monthly Earnings and Students Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Earnings -->
        <div class="lg:col-span-2 bg-card rounded-xl p-6 shadow-2">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-full bg-blue/20 flex items-center justify-center">
                    <i class="fas fa-chart-bar text-blue text-sm"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">মাসিক আয়</h3>
            </div>
            <div id="monthlyEarningGraph"></div>
        </div>

        <!-- Students Status -->
        <div class="bg-card rounded-xl p-6 shadow-2">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-full bg-lime/20 flex items-center justify-center">
                    <i class="fas fa-users text-lime text-sm"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">শিক্ষার্থীর অবস্থা</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-lime"></div>
                        <span class="text-secondary-200 text-sm">সক্রিয় শিক্ষার্থী</span>
                    </div>
                    <span class="text-white font-semibold">{{ $activeCourses }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-orange"></div>
                        <span class="text-secondary-200 text-sm">নিষ্ক্রিয় শিক্ষার্থী</span>
                    </div>
                    <span class="text-white font-semibold">{{ $draftCourses }}</span>
                </div>
            </div>
            <div id="studentsGraph" class="mt-6 h-48"></div>
        </div>
    </div>

    <!-- Messages Section -->
    @if(count($messages) > 0)
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue/20 flex items-center justify-center">
                    <i class="fas fa-envelope text-blue text-sm"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">সাম্প্রতিক বার্তা</h3>
            </div>
            @if (count($messages) > 5)
                <a href="{{ url('course/messages') }}" class="text-blue hover:text-lime anim text-sm font-medium">
                    সব দেখুন <i class="fas fa-arrow-right ml-1"></i>
                </a>
            @endif
        </div>
        
        <div class="space-y-4">
            @foreach ($messages->slice(0, 5) as $message)
            <div class="flex items-start gap-4 p-4 rounded-lg bg-body border border-[#fff]/10 anim hover:border-blue/30">
                <div class="relative">
                    @if ($message->groupUserName && $message->groupUserName->avatar)
                        <img src="{{ asset($message->groupUserName->avatar) }}" alt="{{ $message->groupUserName->name }}" class="w-10 h-10 rounded-full object-cover">
                    @else 
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue to-lime flex items-center justify-center">
                            <span class="text-primary font-semibold text-sm">{{ substr(optional($message->groupUserName)->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    @if(Cache::has('user-is-online-' . $message->groupUserName->id))
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-lime rounded-full border-2 border-primary"></div>
                    @else
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-secondary-200 rounded-full border-2 border-primary"></div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="text-white font-medium text-sm">{{ $message->user ? $message->user->name : 'ব্যবহারকারী পাওয়া যায়নি!' }}</h5>
                        <span class="text-secondary-200 text-xs">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-secondary-200 text-sm leading-relaxed">{{ $message->message }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>
    // Filter dropdown functionality
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');

    filterBtn.addEventListener('click', function() {
        filterDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!filterBtn.contains(event.target) && !filterDropdown.contains(event.target)) {
            filterDropdown.classList.add('hidden');
        }
    });

    // Students status chart
    const studentsData = @json($activeInActiveStudents);
    
    var studentsOptions = {
        series: [
            {
                name: 'সক্রিয় শিক্ষার্থী',
                data: studentsData.active_students || []
            },
            {
                name: 'নিষ্ক্রিয় শিক্ষার্থী',
                data: studentsData.inactive_students || []
            }
        ],
        chart: {
            height: 200,
            type: 'area',
            toolbar: { show: false },
            background: 'transparent'
        },
        theme: {
            mode: 'dark'
        },
        dataLabels: { enabled: false },
        grid: {
            show: true,
            borderColor: 'rgba(90, 234, 244, 0.2)',
            strokeDashArray: 0,
            xaxis: { lines: { show: false } }
        },
        colors: ['#CBFB90', '#FFBB32'],
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: ['জানু', 'ফেব', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্ট', 'অক্ট', 'নভে', 'ডিসে'],
            labels: { style: { colors: '#ABABAB' } }
        },
        yaxis: {
            labels: { style: { colors: '#ABABAB' } }
        },
        tooltip: {
            theme: 'dark',
            style: { fontSize: '12px' }
        },
        legend: { show: false }
    };

    var studentsChart = new ApexCharts(document.querySelector("#studentsGraph"), studentsOptions);
    studentsChart.render();

    // Earnings Chart
    let earningData = @json($earningByDates);
    const currentMonthData = {};
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth() + 1;

    for (const date in earningData) {
        const dateObj = new Date(date);
        const year = dateObj.getFullYear();
        const month = dateObj.getMonth() + 1;

        if (year === currentYear && month === currentMonth) {
            currentMonthData[date] = earningData[date];
        }
    }

    const chartData = Object.keys(currentMonthData).map((date) => {
        return {
            x: new Date(date).getTime(),
            y: currentMonthData[date]
        };
    });

    var earningOptions = {
        series: [{ data: chartData }],
        chart: {
            id: 'area-datetime',
            type: 'area',
            height: 250,
            toolbar: { show: false },
            background: 'transparent'
        },
        theme: { mode: 'dark' },
        dataLabels: { enabled: false },
        markers: { size: 0 },
        xaxis: {
            type: 'datetime',
            tickAmount: 6,
            labels: { style: { colors: '#ABABAB' } }
        },
        yaxis: {
            labels: { style: { colors: '#ABABAB' } }
        },
        colors: ['#5AEAF4'],
        tooltip: {
            theme: 'dark',
            x: { format: 'dd MMM yyyy' }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 100]
            }
        },
        grid: {
            show: true,
            borderColor: 'rgba(90, 234, 244, 0.2)'
        }
    };

    var earningChart = new ApexCharts(document.querySelector("#earningChart"), earningOptions);
    earningChart.render();

    // Monthly Earning Chart
    const earningsByMonths = @json($earningByMonth);
    
    var monthlyOptions = {
        series: [{
            name: 'মাসিক আয়',
            data: earningsByMonths
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            background: 'transparent'
        },
        theme: { mode: 'dark' },
        colors: ['#5AEAF4'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '60%',
                borderRadius: 4,
                endingShape: 'rounded'
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: {
            categories: ['জানু', 'ফেব', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্ট', 'অক্ট', 'নভে', 'ডিসে'],
            labels: { style: { colors: '#ABABAB' } }
        },
        yaxis: {
            labels: { style: { colors: '#ABABAB' } }
        },
        fill: { opacity: 1 },
        grid: {
            show: true,
            borderColor: 'rgba(90, 234, 244, 0.2)',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(val) {
                    return "৳ " + val.toLocaleString();
                }
            }
        }
    };

    var monthlyChart = new ApexCharts(document.querySelector("#monthlyEarningGraph"), monthlyOptions);
    monthlyChart.render();

    // Course Progress Doughnut Chart
    var coursesData = [{{ $activeCourses }}, {{ $draftCourses }}];
    var backgroundColor = ['#CBFB90', '#5AEAF4'];
    var ctx = document.getElementById('courseProgress').getContext('2d');
    
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['সম্পূর্ণ', 'চলমান'],
            datasets: [{
                label: 'কোর্সের অগ্রগতি',
                data: coursesData,
                backgroundColor: backgroundColor,
                borderColor: '#091D3D',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F2342',
                    titleColor: '#FFFFFF',
                    bodyColor: '#ABABAB',
                    borderColor: '#5AEAF4',
                    borderWidth: 1
                }
            },
            cutout: '70%'
        }
    });

    // Generate custom legend
    var total = coursesData.reduce((a, b) => a + b, 0);
    var percentages = coursesData.map((value) => {
        return total === 0 ? "0%" : ((value / total) * 100).toFixed(0) + "%";
    });

    var legendHtml = "";
    for (var i = 0; i < myDoughnutChart.data.labels.length; i++) {
        legendHtml +=
            '<div class="flex items-center justify-between py-2 px-3 rounded-lg bg-body/50">' +
            '<div class="flex items-center gap-2">' +
            '<div class="w-3 h-3 rounded-full" style="background-color:' +
            myDoughnutChart.data.datasets[0].backgroundColor[i] + '"></div>' +
            '<span class="text-secondary-200 text-sm">' + myDoughnutChart.data.labels[i] + '</span>' +
            '</div>' +
            '<span class="text-white font-semibold text-sm">' + percentages[i] + '</span>' +
            '</div>';
    }
    document.getElementById("legend").innerHTML = legendHtml;
</script>
@endsection