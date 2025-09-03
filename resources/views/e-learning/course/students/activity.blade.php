@extends('layouts/student-modern')
@section('title') কোর্স কার্যক্রম @endsection
@php 
    use Illuminate\Support\Str;
@endphp
{{-- page style @S --}}
@section('style')
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
<div class="p-6 max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
            <div class="text-center">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    কোর্স কার্যক্রম ড্যাশবোর্ড
                </h1>
                <p class="text-slate-600 dark:text-slate-400">আপনার শিক্ষা অগ্রগতির সম্পূর্ণ চিত্র</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Completed Courses -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card bg-gradient-to-br from-green-500/10 to-emerald-600/10 border-green-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="text-green-600 dark:text-green-400 text-sm font-medium">100%</div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1" data-count="{{ $completedCourses }}">0</h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm">সম্পূর্ণ কোর্স</p>
        </div>

        <!-- In Progress Courses -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card bg-gradient-to-br from-blue-500/10 to-purple-600/10 border-blue-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-play-circle text-white text-xl"></i>
                </div>
                <div class="text-blue-600 dark:text-blue-400 text-sm font-medium">চলমান</div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1" data-count="{{ $inProgressCourses }}">0</h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm">চলমান কোর্স</p>
        </div>

        <!-- Total Lessons -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card bg-gradient-to-br from-orange-500/10 to-red-600/10 border-orange-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-xl"></i>
                </div>
                <div class="text-orange-600 dark:text-orange-400 text-sm font-medium">পাঠ</div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-1" data-count="{{ $totalLessonsCompleted }}">0</h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm">সম্পূর্ণ পাঠ</p>
        </div>

        <!-- Time Spent -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card bg-gradient-to-br from-purple-500/10 to-pink-600/10 border-purple-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="text-purple-600 dark:text-purple-400 text-sm font-medium">সময়</div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-1">{{ $totalHours }}<span class="text-base text-slate-500">ঘ</span> {{ $totalMinutes }}<span class="text-base text-slate-500">মি</span></h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm">মোট সময়</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Completion Chart -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">কোর্স সম্পূর্ণতার হার</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-pie text-white text-sm"></i>
                </div>
            </div>
            <div class="relative h-64 flex items-center justify-center">
                <canvas id="completionChart" class="max-w-full max-h-full"></canvas>
            </div>
        </div>

        <!-- Course Progress Bars -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">কোর্সওয়ার অগ্রগতি</h3>
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-white text-sm"></i>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($courseCompletionData as $index => $course)
                @if($index < 5)
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ Str::limit($course['course_name'], 30) }}</span>
                        <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-1000 bg-gradient-to-r from-blue-500 to-purple-600" 
                             data-progress="{{ $course['progress'] }}" style="width: 0%"></div>
                    </div>
                </div>
                @endif
                @endforeach
                @if(count($courseCompletionData) == 0)
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400">কোন কোর্স ডেটা পাওয়া যায়নি</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Weekly Activity Chart -->
    <div class="glass-effect rounded-2xl p-6 ray-hover glow-card mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">সাপ্তাহিক শিক্ষা কার্যক্রম (গত ৮ সপ্তাহ)</h3>
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-sm"></i>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="weeklyChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Course Activities Table -->
    @if (count($courseActivities) > 0)
    <div class="glass-effect rounded-2xl p-6 ray-hover glow-card mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">কোর্স তালিকা</h3>
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-list text-white text-sm"></i>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">কোর্সের নাম</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">সময়কাল</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">অবস্থা</th>
                        <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">অগ্রগতি</th>
                        <th class="text-center py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
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
                    <tr class="hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" 
                                     class="w-12 h-8 object-cover rounded-lg">
                                <div>
                                    <div class="font-semibold text-slate-800 dark:text-white text-sm">{{ Str::limit($course->title, 40) }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $course->categories }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ number_format($totalDurationMinutes / 60, 1) }} ঘন্টা</span>
                        </td>
                        <td class="py-4 px-4">
                            @if($totalProgressPercent >= 100)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    <i class="fas fa-check-circle mr-1"></i> সম্পূর্ণ
                                </span>
                            @elseif($totalProgressPercent > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                    <i class="fas fa-play-circle mr-1"></i> চলমান
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">
                                    <i class="fas fa-pause-circle mr-1"></i> শুরু হয়নি
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1">
                                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-300" 
                                             data-progress="{{ $totalProgressPercent }}" style="width: 0%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-slate-800 dark:text-white min-w-[3rem]">{{ $totalProgressPercent }}%</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <a href="{{ url('student/courses/'.$course->slug.'/learn') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
                                <i class="fas fa-play mr-2"></i>শিখুন
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="glass-effect rounded-2xl p-12 ray-hover glow-card text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-graduation-cap text-white text-3xl"></i>
        </div>
        <h3 class="text-2xl font-semibold text-slate-600 dark:text-slate-400 mb-3">কোন কার্যক্রম পাওয়া যায়নি</h3>
        <p class="text-slate-500 dark:text-slate-500 mb-6 max-w-md mx-auto">আপনার প্রথম কোর্সে নথিভুক্ত হয়ে শেখার যাত্রা শুরু করুন</p>
        <a href="{{ url('/courses/') }}" 
           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
            <i class="fas fa-search mr-2"></i>কোর্স খুঁজুন
        </a>
    </div>
    @endif

    <!-- Pagination -->
    @if (count($courseActivities) > 0)
    <div class="flex justify-center">
        <div class="glass-effect rounded-2xl p-4 ray-hover glow-card">
            {{ $courseActivities->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection
{{-- page content @E --}}

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counter numbers
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        let current = 0;
        const increment = target / 60;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 25);
    });

    // Animate progress bars
    setTimeout(() => {
        const progressFills = document.querySelectorAll('[data-progress]');
        progressFills.forEach(fill => {
            const progress = fill.getAttribute('data-progress');
            fill.style.width = progress + '%';
        });
    }, 800);

    // Completion Pie Chart
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    new Chart(completionCtx, {
        type: 'doughnut',
        data: {
            labels: ['সম্পূর্ণ', 'চলমান', 'শুরু হয়নি'],
            datasets: [{
                data: [{{ $completedCourses }}, {{ $inProgressCourses }}, {{ $notStartedCourses }}],
                backgroundColor: [
                    'rgb(34 197 94)',   // Green
                    'rgb(59 130 246)',  // Blue
                    'rgb(245 158 11)'   // Orange
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            family: 'Inter'
                        },
                        color: document.documentElement.classList.contains('dark') ? '#e2e8f0' : '#475569'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8
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
            labels: weeks.length ? weeks : ['সপ্তাহ ১', 'সপ্তাহ ২', 'সপ্তাহ ৩', 'সপ্তাহ ৪', 'সপ্তাহ ৫', 'সপ্তাহ ৬'],
            datasets: [{
                label: 'সম্পূর্ণ পাঠ',
                data: lessonCounts.length ? lessonCounts : [2, 5, 3, 8, 6, 4],
                borderColor: 'rgb(59 130 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(59 130 246)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            family: 'Inter'
                        },
                        color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            family: 'Inter'
                        },
                        color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b'
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
    
    // Confirmation prompts for delete buttons
    const deleteButtons = document.querySelectorAll('button[type="submit"]');
    deleteButtons.forEach(button => {
        const buttonText = button.textContent.trim();
        if (buttonText.includes('অপছন্দ') || buttonText.includes('Delete') || buttonText.includes('delete') || buttonText.includes('মুছুন')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('আপনি কি নিশ্চিত যে এই কার্যক্রমটি সম্পাদন করতে চান?')) {
                    this.closest('form').submit();
                }
            });
        }
    });
});
</script>
@endsection