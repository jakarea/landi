@extends('layouts.latest.students')
@section('title') কোর্স কার্যক্রম @endsection
@php 
    use Illuminate\Support\Str;
@endphp
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/subscription.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<style>
.activity-dashboard {
    margin-bottom: 2rem;
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    text-align: center;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transition: all 0.6s ease;
}

.stats-card:hover::before {
    top: -70%;
    right: -70%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.25);
}

.stats-card.completed {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.stats-card.in-progress {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-card.not-started {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #333;
}

.stats-card.time-spent {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #333;
}

.stats-number {
    font-size: 3rem;
    font-weight: bold;
    margin: 0;
    animation: countUp 1s ease-out;
}

.stats-label {
    font-size: 1rem;
    opacity: 0.9;
    margin-top: 0.5rem;
}

.chart-container {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
    position: relative;
    height: 350px;
    display: flex;
    flex-direction: column;
}

.chart-container canvas {
    max-height: 280px;
    width: 100% !important;
    height: auto !important;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
    text-align: center;
}

.progress-bars {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.progress-item {
    margin-bottom: 1.5rem;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.progress-bar-custom {
    height: 8px;
    background: #f0f0f0;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 1.5s ease-out;
    width: 0;
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    text-align: center;
    margin-bottom: 2rem;
}

.dashboard-title {
    font-size: 2rem;
    margin: 0;
    font-weight: 600;
}

.dashboard-subtitle {
    opacity: 0.9;
    margin-top: 0.5rem;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.course-activity-table {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    overflow-x: auto;
}

.course-activity-table table {
    width: 100%;
    border-collapse: collapse;
}

.course-activity-table th {
    background: #f8f9fa;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
}

.course-activity-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.course-thumbnail {
    width: 60px;
    height: 40px;
    object-fit: cover;
    border-radius: 8px;
}

.play-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.play-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-progress {
    background: #cce5ff;
    color: #004085;
}

.status-not-started {
    background: #f8d7da;
    color: #721c24;
}
</style>
@endsection
{{-- page style @E --}}

{{-- page content @S --}}
@section('content')
<main class="course-activity-list-page">
    <div class="container-fluid">
        {{-- Dashboard Header --}}
        <div class="row">
            <div class="col-12">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">কোর্স কার্যক্রম ড্যাশবোর্ড</h1>
                    <p class="dashboard-subtitle">আপনার শিক্ষা অগ্রগতির সম্পূর্ণ চিত্র</p>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row activity-dashboard">
            <div class="col-md-3 col-sm-6">
                <div class="stats-card completed">
                    <h2 class="stats-number" data-count="{{ $completedCourses }}">0</h2>
                    <p class="stats-label">সম্পূর্ণ কোর্স</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card in-progress">
                    <h2 class="stats-number" data-count="{{ $inProgressCourses }}">0</h2>
                    <p class="stats-label">চলমান কোর্স</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card not-started">
                    <h2 class="stats-number" data-count="{{ $totalLessonsCompleted }}">0</h2>
                    <p class="stats-label">সম্পূর্ণ পাঠ</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card time-spent">
                    <h2 class="stats-number">{{ $totalHours }}<span style="font-size: 1rem;">ঘ</span> {{ $totalMinutes }}<span style="font-size: 1rem;">মি</span></h2>
                    <p class="stats-label">মোট সময়</p>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-container">
                    <h3 class="chart-title">কোর্স সম্পূর্ণতার হার</h3>
                    <canvas id="completionChart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="progress-bars">
                    <h3 class="chart-title">কোর্সওয়ার অগ্রগতি</h3>
                    @foreach($courseCompletionData as $index => $course)
                    @if($index < 5) {{-- Show top 5 courses --}}
                    <div class="progress-item">
                        <div class="progress-header">
                            <span>{{ Str::limit($course['course_name'], 30) }}</span>
                            <span>{{ $course['progress'] }}%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" data-progress="{{ $course['progress'] }}"></div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Weekly Activity Chart --}}
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="chart-title">সাপ্তাহিক শিক্ষা কার্যক্রম (গত ৮ সপ্তাহ)</h3>
                    <canvas id="weeklyChart" width="400" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Course Activities Table --}}
        @if (count($courseActivities) > 0)
        <div class="row">
            <div class="col-12">
                <div class="course-activity-table">
                    <h3 class="chart-title" style="text-align: left; margin-bottom: 1.5rem;">কোর্স তালিকা</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>কোর্সের নাম</th>
                                <th>সময়কাল</th>
                                <th>অবস্থা</th>
                                <th>অগ্রগতি</th>
                                <th>কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseActivities as $course)
                            @php
                                $totalDurationMinutes = 0;
                                foreach($course->modules as $module) {
                                    foreach($module->lessons as $lesson) {
                                        $totalDurationMinutes += $lesson->duration;
                                    }
                                }
                                $totalProgressPercent = StudentActitviesProgress(auth()->user()->id, $course->id);
                            @endphp
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="course-thumbnail">
                                        <div>
                                            <strong>{{ Str::limit($course->title, 40) }}</strong>
                                            <br>
                                            <small style="color: #666;">{{ $course->categories }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($totalDurationMinutes / 60, 1) }} ঘন্টা</td>
                                <td>
                                    @if($totalProgressPercent >= 100)
                                        <span class="status-badge status-completed">সম্পূর্ণ</span>
                                    @elseif($totalProgressPercent > 0)
                                        <span class="status-badge status-progress">চলমান</span>
                                    @else
                                        <span class="status-badge status-not-started">শুরু হয়নি</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div class="progress-bar-custom" style="width: 60px;">
                                            <div class="progress-fill" data-progress="{{ $totalProgressPercent }}"></div>
                                        </div>
                                        <span style="font-size: 0.875rem; font-weight: 600;">{{ $totalProgressPercent }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('student/courses/'.$course->slug.'/learn') }}" class="play-button">
                                        <i class="fas fa-play"></i>
                                        শিখুন
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

        {{-- Pagination --}}
        <div class="row">
            <div class="col-12">
                <div class="paggination-wrap mt-4">
                    {{ $courseActivities->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
{{-- page content @E --}}

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counter numbers
    const counters = document.querySelectorAll('.stats-number[data-count]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 30);
    });

    // Animate progress bars
    setTimeout(() => {
        const progressFills = document.querySelectorAll('.progress-fill[data-progress]');
        progressFills.forEach(fill => {
            const progress = fill.getAttribute('data-progress');
            fill.style.width = progress + '%';
        });
    }, 500);

    // Completion Pie Chart
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    new Chart(completionCtx, {
        type: 'doughnut',
        data: {
            labels: ['সম্পূর্ণ', 'চলমান', 'শুরু হয়নি'],
            datasets: [{
                data: [{{ $completedCourses }}, {{ $inProgressCourses }}, {{ $notStartedCourses }}],
                backgroundColor: [
                    '#38ef7d',
                    '#667eea',
                    '#fcb69f'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });

    // Weekly Activity Line Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyData = @json($weeklyActivityData);
    
    const weeks = weeklyData.map(item => `সপ্তাহ ${item.week}`);
    const lessonCounts = weeklyData.map(item => item.lessons_count);
    
    new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: weeks.length ? weeks : ['সপ্তাহ ১', 'সপ্তাহ ২', 'সপ্তাহ ৩', 'সপ্তাহ ৪'],
            datasets: [{
                label: 'সম্পূর্ণ পাঠ',
                data: lessonCounts.length ? lessonCounts : [0, 0, 0, 0],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 3,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endsection