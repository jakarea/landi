@extends('layouts.latest.instructor')

@section('title', 'Course Performance Analytics')

@php
    use Illuminate\Support\Str;
@endphp

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.8/dist/countUp.min.js"></script>
<style>
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #f093fb;
    --success-color: #4facfe;
    --warning-color: #f6d55c;
    --danger-color: #ff6b6b;
    --info-color: #4ecdc4;
    --dark-color: #2c3e50;
    --light-color: #f8f9fa;
    --shadow-light: 0 2px 10px rgba(0,0,0,0.1);
    --shadow-medium: 0 5px 25px rgba(0,0,0,0.15);
    --shadow-heavy: 0 10px 40px rgba(0,0,0,0.2);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.analytics-page {
    padding: 1rem 0;
    min-height: 100vh;
}

/* Animated Background */
.analytics-page::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="g" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="20" cy="20" r="2" fill="url(%23g)"><animate attributeName="cy" values="20;80;20" dur="3s" repeatCount="indefinite"/></circle><circle cx="50" cy="50" r="1.5" fill="url(%23g)"><animate attributeName="cx" values="50;80;50" dur="4s" repeatCount="indefinite"/></circle><circle cx="80" cy="30" r="2.5" fill="url(%23g)"><animate attributeName="cy" values="30;70;30" dur="2.5s" repeatCount="indefinite"/></circle></svg>') repeat;
    animation: float 10s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Header Section */
.page-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-medium);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 1;
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
    animation: fadeIn 0.8s ease-out 0.2s both;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-bottom: 0;
    animation: fadeIn 0.8s ease-out 0.4s both;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Overall Stats Cards */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 1rem;
    box-shadow: var(--shadow-light);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition);
    position: relative;
    z-index: 1;
    overflow: hidden;
    animation: scaleIn 0.6s ease-out;
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.stat-card:hover::before {
    left: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-heavy);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: var(--shadow-light);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    counter-reset: number;
}

.stat-label {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}

/* Course Performance Grid */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.course-performance-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 1rem;
    box-shadow: var(--shadow-light);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition);
    position: relative;
    z-index: 1;
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.course-performance-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.course-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.course-thumbnail {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    object-fit: cover;
    margin-right: 0.75rem;
    box-shadow: var(--shadow-light);
    animation: fadeIn 0.8s ease-out;
}

.course-info h3 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.course-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-published {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

.status-draft {
    background: linear-gradient(135deg, #f6d55c, #feca57);
    color: var(--dark-color);
}

.status-pending {
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    color: white;
}

/* Performance Metrics */
.performance-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.metric {
    text-align: center;
    padding: 0.75rem;
    background: rgba(247, 250, 252, 0.8);
    border-radius: 10px;
    transition: var(--transition);
}

.metric:hover {
    background: rgba(247, 250, 252, 1);
    transform: scale(1.02);
}

.metric-value {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.2rem;
}

.metric-label {
    font-size: 0.7rem;
    color: #6c757d;
    font-weight: 500;
}

/* Growth Indicator */
.growth-indicator {
    display: inline-flex;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    margin-top: 0.5rem;
}

.growth-positive {
    background: rgba(76, 175, 80, 0.1);
    color: #2e7d32;
}

.growth-negative {
    background: rgba(244, 67, 54, 0.1);
    color: #c62828;
}

.growth-neutral {
    background: rgba(158, 158, 158, 0.1);
    color: #424242;
}

/* Progress Bars */
.progress-container {
    margin: 1rem 0;
}

.progress-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.animated-progress {
    height: 8px;
    background: rgba(0,0,0,0.1);
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 4px;
    width: 0%;
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 150px;
    margin: 0.75rem 0;
    padding: 0.75rem;
    background: rgba(247, 250, 252, 0.5);
    border-radius: 10px;
}

/* Recent Activity */
.activity-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--shadow-light);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 1;
    animation: fadeIn 0.8s ease-out;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    transition: var(--transition);
}

.activity-item:hover {
    background: rgba(247, 250, 252, 0.5);
    padding-left: 0.5rem;
    border-radius: 8px;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: linear-gradient(135deg, var(--info-color), #36d1dc);
    color: white;
    font-size: 0.9rem;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.activity-description {
    font-size: 0.9rem;
    color: #6c757d;
}

.activity-time {
    font-size: 0.8rem;
    color: #9ca3af;
    white-space: nowrap;
}

/* Responsive Design */
@media (max-width: 768px) {
    .analytics-page {
        padding: 1rem 0;
    }
    
    .page-header {
        padding: 1.5rem;
        margin-left: 1rem;
        margin-right: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .stats-overview {
        margin-left: 1rem;
        margin-right: 1rem;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .courses-grid {
        margin-left: 1rem;
        margin-right: 1rem;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .activity-section {
        margin-left: 1rem;
        margin-right: 1rem;
    }
    
    .performance-metrics {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Loading Animation */
.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
@endsection

@section('content')
<main class="analytics-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="page-title">Course Performance Analytics</h1>
                    <p class="page-subtitle">Track your course success with detailed insights and visual metrics</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <i class="fas fa-chart-line"></i>
                        <span class="fw-medium">Live Dashboard</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Statistics -->
        <div class="stats-overview">
            <div class="stat-card" style="animation-delay: 0.1s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-value" data-target="{{ $overallStats->total_courses }}">0</div>
                <div class="stat-label">Total Courses</div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.2s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value" data-target="{{ $overallStats->total_students }}">0</div>
                <div class="stat-label">Total Students</div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.3s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-value">৳<span data-target="{{ $overallStats->total_revenue }}">0</span></div>
                <div class="stat-label">Total Revenue</div>
            </div>
            
            <div class="stat-card" style="animation-delay: 0.4s;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value" data-target="{{ round($overallStats->average_rating, 1) }}">0</div>
                <div class="stat-label">Avg Rating</div>
            </div>
        </div>

        <!-- Course Performance Grid -->
        @if($courses->count() > 0)
            <div class="courses-grid">
                @foreach($courses as $index => $course)
                    <div class="course-performance-card" style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                        <div class="course-header">
                            @if($course->thumbnail)
                                <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="course-thumbnail">
                            @else
                                <div class="course-thumbnail d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="course-info flex-grow-1">
                                <h3>{{ Str::limit($course->title, 40) }}</h3>
                                <span class="course-status status-{{ $course->status }}">{{ ucfirst($course->status) }}</span>
                                
                                @if($course->monthly_growth != 0)
                                    <div class="growth-indicator {{ $course->monthly_growth > 0 ? 'growth-positive' : ($course->monthly_growth < 0 ? 'growth-negative' : 'growth-neutral') }}">
                                        <i class="fas fa-{{ $course->monthly_growth > 0 ? 'arrow-up' : ($course->monthly_growth < 0 ? 'arrow-down' : 'minus') }} me-1"></i>
                                        {{ abs($course->monthly_growth) }}% this month
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="performance-metrics">
                            <div class="metric">
                                <div class="metric-value text-primary" data-target="{{ $course->total_enrollments }}">0</div>
                                <div class="metric-label">Students</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value text-success">৳<span data-target="{{ $course->total_revenue }}">0</span></div>
                                <div class="metric-label">Revenue</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value text-warning" data-target="{{ $course->average_rating }}">0</div>
                                <div class="metric-label">Rating</div>
                            </div>
                            <div class="metric">
                                <div class="metric-value text-info" data-target="{{ $course->total_lessons }}">0</div>
                                <div class="metric-label">Lessons</div>
                            </div>
                        </div>

                        <!-- Progress Bars -->
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Completion Rate</span>
                                <span>{{ $course->completion_rate }}%</span>
                            </div>
                            <div class="animated-progress">
                                <div class="progress-fill" data-progress="{{ $course->completion_rate }}"></div>
                            </div>
                        </div>

                        <!-- Chart removed for performance -->
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="stat-card">
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Courses Found</h4>
                    <p class="text-muted">Create your first course to see analytics here</p>
                    <a href="{{ url('instructor/courses/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Course
                    </a>
                </div>
            </div>
        @endif

        <!-- Recent Activity -->
        <div class="activity-section">
            <h3 class="mb-4">
                <i class="fas fa-clock me-2"></i>
                Recent Activity
                <span class="text-muted" style="font-size: 0.9rem; font-weight: 400;">(Last 10)</span>
            </h3>
            
            @if($logs->count() > 0)
                @foreach($logs as $log)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">
                                @if($log->course)
                                    {{ $log->course->title }}
                                @else
                                    Unknown Course
                                @endif
                            </div>
                            <div class="activity-description">
                                @if($log->user)
                                    {{ $log->user->name }} accessed lesson content
                                @else
                                    Student accessed lesson content
                                @endif
                                @if($log->lesson)
                                    - {{ $log->lesson->title }}
                                @endif
                            </div>
                        </div>
                        <div class="activity-time">
                            {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="fas fa-history fa-2x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No recent activity found</p>
                    <small class="text-muted">Student interactions will appear here</small>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counter values
    const counters = document.querySelectorAll('[data-target]');
    
    const animateCounter = (counter) => {
        const targetValue = counter.getAttribute('data-target');
        const target = parseFloat(targetValue) || 0;
        
        // If target is 0, just set it directly
        if (target === 0) {
            counter.textContent = '0';
            return;
        }
        
        const options = {
            startVal: 0,
            endVal: target,
            duration: 3,
            separator: ',',
            decimal: '.',
            decimalPlaces: targetValue && targetValue.includes('.') ? 1 : 0
        };
        
        try {
            const countUp = new CountUp(counter, target, options);
            if (!countUp.error) {
                countUp.start();
            } else {
                // Fallback: set the value directly
                counter.textContent = target;
            }
        } catch (error) {
            // Fallback: set the value directly
            counter.textContent = target;
        }
    };
    
    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.hasAttribute('data-target')) {
                    setTimeout(() => {
                        animateCounter(entry.target);
                    }, 500);
                }
                
                if (entry.target.classList.contains('progress-fill')) {
                    const progress = entry.target.getAttribute('data-progress');
                    setTimeout(() => {
                        entry.target.style.width = progress + '%';
                    }, 1000);
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    // Observe all counters and progress bars
    counters.forEach(counter => observer.observe(counter));
    document.querySelectorAll('.progress-fill').forEach(bar => observer.observe(bar));
    
    // Charts removed for performance optimization
    
    // Add stagger animation to cards
    const cards = document.querySelectorAll('.course-performance-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${0.1 * (index + 1)}s`;
    });
    
    // Smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection