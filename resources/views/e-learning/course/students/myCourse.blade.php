@extends('layouts/latest/students')
@section('title')
    My Course Details
@endsection
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\DB;
@endphp
{{-- style section @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .donut-chart-container {
            margin: 0 auto;
        }
        
        .donut-chart {
            transform: rotate(0deg);
            filter: drop-shadow(0 4px 12px rgba(34, 197, 94, 0.4));
        }
        
        .progress-circle {
            filter: drop-shadow(0 0 8px rgba(34, 197, 94, 0.6));
            stroke-dashoffset: 377;
        }
        
        .progress-circle.animate {
            animation: progress-fill 3s ease-out forwards;
        }
        
        .donut-center h5 {
            background: linear-gradient(135deg, #22c55e, #16a34a, #15803d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .overall-progress {
            text-align: center;
            padding: 10px;
        }
        
        .overall-progress h6 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .percent {
            justify-content: center;
            padding: 20px;
        }
        
        /* LIGHT/WHITE MODE - Clean & Bright */
        .modern-modules-header {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        /* DARK MODE - Rich & Deep */
        .dark-mode .modern-modules-header {
            background: #111827;
            border: 2px solid #374151;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        }
        
        /* LIGHT MODE Typography - Clean & Professional */
        .modules-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        
        .modules-subtitle {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0;
        }
        
        /* DARK MODE Typography - Bright & Clear */
        .dark-mode .modules-title {
            color: #ffffff;
        }
        
        .dark-mode .modules-subtitle {
            color: #d1d5db;
        }
        
        /* LIGHT/WHITE MODE Cards - Pure & Clean */
        .modern-module-card {
            background: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .modern-module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #3b82f6;
        }
        
        /* DARK MODE Cards - Rich & Deep */
        .dark-mode .modern-module-card {
            background: #1f2937;
            border: 2px solid #4b5563;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }
        
        .dark-mode .modern-module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6), 0 10px 10px -5px rgba(0, 0, 0, 0.3);
            border-color: #60a5fa;
        }
        
        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        /* LIGHT MODE Module Content */
        .module-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }
        
        .module-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .lesson-count, .completion-status {
            font-size: 0.875rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .lesson-count i, .completion-status i {
            color: #3b82f6;
            margin-right: 0.5rem;
        }
        
        .completion-status i {
            color: #10b981;
        }
        
        /* DARK MODE Module Content */
        .dark-mode .module-title {
            color: #ffffff;
        }
        
        .dark-mode .lesson-count, .dark-mode .completion-status {
            color: #d1d5db;
        }
        
        .dark-mode .lesson-count i, .dark-mode .completion-status i {
            color: #60a5fa;
        }
        
        .dark-mode .completion-status i {
            color: #34d399;
        }
        
        .progress-circle-container {
            flex-shrink: 0;
        }
        
        .progress-circle-wrapper {
            position: relative;
            width: 70px;
            height: 70px;
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        /* LIGHT MODE Progress Ring */
        .progress-ring-bg {
            fill: none;
            stroke: #e5e7eb;
            stroke-width: 6;
        }
        
        .progress-ring-fill {
            fill: none;
            stroke: #10b981;
            stroke-width: 6;
            stroke-linecap: round;
            transition: stroke-dashoffset 1s ease-in-out;
        }
        
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        
        .progress-number {
            font-size: 1.125rem;
            font-weight: 700;
            color: #10b981;
        }
        
        .progress-symbol {
            font-size: 0.75rem;
            color: #10b981;
            font-weight: 600;
        }
        
        /* DARK MODE Progress Ring */
        .dark-mode .progress-ring-bg {
            stroke: #4b5563;
        }
        
        .dark-mode .progress-ring-fill {
            stroke: #34d399;
        }
        
        .dark-mode .progress-number {
            color: #34d399;
        }
        
        .dark-mode .progress-symbol {
            color: #34d399;
        }
        
        .progress-bar-section {
            margin-bottom: 1.5rem;
        }
        
        .progress-bar-wrapper {
            margin-bottom: 0.5rem;
        }
        
        .progress-labels {
            display: flex;
            justify-content: space-between;
        }
        
        /* LIGHT MODE Divider */
        .module-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 1.5rem 0;
        }
        
        /* DARK MODE Divider */
        .dark-mode .module-divider {
            background: #4b5563;
        }
        
        .lessons-container {
            margin-bottom: 1rem;
        }
        
        /* Light Mode Lesson Items */
        .lesson-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .lesson-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .lesson-item:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            transform: translateX(8px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 4px 12px 0 rgba(59, 130, 246, 0.15);
        }
        
        .lesson-item:hover::before {
            transform: scaleY(1);
        }
        
        /* Dark Mode Lesson Items */
        .dark-mode .lesson-item {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid rgba(51, 65, 85, 0.8);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
        }
        
        .dark-mode .lesson-item::before {
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
        }
        
        .dark-mode .lesson-item:hover {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            border-color: rgba(96, 165, 250, 0.4);
            box-shadow: 0 4px 12px 0 rgba(96, 165, 250, 0.2);
        }
        
        .lesson-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .lesson-icon {
            margin-right: 0.75rem;
        }
        
        /* Light Mode Icons & Badges */
        .icon-completed, .icon-pending {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .icon-completed {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #15803d;
            border: 2px solid #22c55e;
        }
        
        .icon-pending {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #475569;
            border: 2px solid #cbd5e1;
        }
        
        .lesson-title {
            font-weight: 600;
            color: #0f172a;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        /* DARK MODE Lesson Icons */
        .dark-mode .icon-completed {
            background: #14532d !important;
            color: #4ade80 !important;
            border-color: #22c55e !important;
        }
        
        .dark-mode .icon-pending {
            background: #4b5563 !important;
            color: #d1d5db !important;
            border-color: #6b7280 !important;
        }
        
        /* DARK MODE Lesson Content */
        .dark-mode .lesson-title {
            color: #f9fafb !important;
        }
        
        .status-badge {
            padding: 0.375rem 1rem;
            border-radius: 24px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid;
        }
        
        .status-badge.completed {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #15803d;
            border-color: #22c55e;
        }
        
        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        /* DARK MODE Status Badges */
        .dark-mode .status-badge.completed {
            background: #14532d;
            color: #4ade80;
        }
        
        .dark-mode .status-badge.pending {
            background: #451a03;
            color: #fbbf24;
        }
        
        /* LIGHT MODE Show More Button */
        .show-more-section {
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .show-more-btn {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            color: #374151;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .show-more-btn:hover {
            background: #f1f5f9;
            border-color: #d1d5db;
        }
        
        /* DARK MODE Show More Button */
        .dark-mode .show-more-section {
            border-top-color: #4b5563;
        }
        
        .dark-mode .show-more-btn {
            background: #4b5563;
            border-color: #6b7280;
            color: #f9fafb;
        }
        
        .dark-mode .show-more-btn:hover {
            background: #6b7280;
            border-color: #9ca3af;
        }
        
        .transition-icon {
            transition: transform 0.2s ease;
        }
        
        /* DARK MODE Progress Bar */
        .dark-mode .progress {
            background-color: #4b5563 !important;
        }
        
        /* DARK MODE Progress Labels */
        .dark-mode .progress-labels small {
            color: #d1d5db !important;
        }
        
        .show-more-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 auto;
        }
        
        .dark-mode .show-more-btn {
            background: #334155;
            border-color: #475569;
            color: #94a3b8;
        }
        
        .show-more-btn:hover {
            background: #e2e8f0;
            border-color: #3b82f6;
            color: #3b82f6;
        }
        
        .dark-mode .show-more-btn:hover {
            background: #475569;
            color: #60a5fa;
        }
        
        .transition-icon {
            transition: transform 0.2s ease;
        }
        
        .show-more-btn[aria-expanded="true"] .transition-icon {
            transform: rotate(180deg);
        }
        
    </style>
@endsection
{{-- style section @E --}}

@section('seo')
    <meta name="keywords" content="{{ ($course->categories ?? '') . ', ' . ($course->meta_keyword ?? '') }}" />
    <meta name="description" content="{{ $course->meta_description ?? '' }}" itemprop="description">
@endsection

@section('content')
    <main class="course-overview-page">
        <div class="overview-banner-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-8">
                        <div class="banner-title">
                            <h1>{{ $course->title }}</h1>
                            <p>{{ $course->sub_title ?? '' }}</p>

                            @if ($course->user)
                                <div class="media">
                                    @if ($course->user && $course->user->avatar)
                                        <img src="{{ asset( $course->user->avatar) }}" alt="Place" class="img-fluid">
                                    @else
                                    <span class="user-name-avatar me-3">{!! strtoupper($course->user->name[0]) !!}</span>
                                    @endif
                                    <div class="media-body">
                                        <h5>{{ $course->user->name }}</h5>
                                        <h6>Instructor</h6>
                                    </div>
                                </div>
                            @endif

                            {{-- course lesson duration calculation --}}
                            @php
                                $totalDurationSeconds = 0;
                                $completedDurationSeconds = 0;
                            @endphp
                            @if($course->modules)
                                @foreach ($course->modules as $module)
                                    @if($module->lessons)
                                        @foreach ($module->lessons as $lesson)
                                        @php
                                        $totalDurationSeconds += $lesson->duration ?? 0;
                                        @endphp
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif

                            @php
                                // Get completed duration for this user and course
                                $completedDurationSeconds = DB::table('course_activities')
                                    ->where('course_id', $course->id)
                                    ->where('user_id', auth()->id())
                                    ->sum('duration');

                                // Calculate remaining duration
                                $remainingDurationSeconds = max(0, $totalDurationSeconds - $completedDurationSeconds);
                                
                                // Convert remaining seconds to hours and minutes
                                $hours = floor($remainingDurationSeconds / 3600);
                                $minutes = floor(($remainingDurationSeconds % 3600) / 60);
                            @endphp
                            {{-- course lesson duration calculation --}}

                            <h4>
                            @if ($remainingDurationSeconds > 0)
                                @if ($hours > 0)
                                    {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                @endif
                                {{ $minutes }} {{ $minutes > 1 ? 'Minutes' : 'Minute' }} Remaining
                            @else
                                Course Completed
                            @endif
                            . {{ $course->modules ? $course->modules->count() : 0 }} Modules in Course

                                @if ($course->allow_review)
                                   . {{ count($course_reviews) }} {{ count($course_reviews) > 1 ? 'Reviews' : 'Review' }}
                                @endif
                            </h4>

                            <a href="{{ url('student/courses/' . $course->slug.'/learn') }}" class="common-bttn"
                                style="border-radius: 6.25rem; margin-top: 2rem"><img src="{{ asset('assets/images/icons/play-circle.svg') }}" alt="a" class="img-fluid me-1"> Start Learning</a>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="overall-progress">
                            <h6>Overall Progress</h6>
                            <div class="circle-prog-big">
                                <div class="cards">
                                    <div class="percent flex items-center align-items-center mx-auto">

                                        @php
                                        $totalLessons = 0;
                                        $completedLessons = 0;
                                    @endphp
                                    @if($course->modules)
                                        @foreach ($course->modules as $module)
                                            @php
                                                $totalLessons += $module->lessons ? count($module->lessons) : 0;
                                                $completedLessons += $module->lessons ? $module->lessons->where('completed', 1)->count() : 0;
                                            @endphp
                                        @endforeach
                                    @endif

                                        @php
                                        // Use the more accurate progress calculation from StudentActitviesProgress function
                                        $totalPorgressPercent = StudentActitviesProgress(auth()->user()->id, $course->id);
                                        
                                        // Calculate overall progress
                                        
                                        // Use the function result as the main percentage (more accurate than lesson count)
                                        $overallPercentage = $totalPorgressPercent;
                                        
                                        // Fallback to lesson-based calculation if function returns 0
                                        if ($overallPercentage == 0 && $totalLessons > 0) {
                                            $overallPercentage = ($completedLessons / $totalLessons) * 100;
                                        }
                                        
                                        // Ensure percentage is never negative
                                        if ($overallPercentage < 0) {
                                            $overallPercentage = 0;
                                        }
                                        
                                        // Round to 1 decimal place for precision
                                        $overallDisplayPercentage = round($overallPercentage, 1);
                                        
                                        @endphp
                                        
                                        <style>
                                        @keyframes progress-fill {
                                            from {
                                                stroke-dashoffset: 377;
                                            }
                                            to {
                                                stroke-dashoffset: {{ 377 - (377 * $overallPercentage / 100) }};
                                            }
                                        }
                                        </style>
                                        <!-- Donut Chart -->
                                        <div class="donut-chart-container" style="position: relative; width: 150px; height: 150px;">
                                            <svg width="150" height="150" class="donut-chart">
                                                <!-- Background circle -->
                                                <circle 
                                                    cx="75" 
                                                    cy="75" 
                                                    r="60" 
                                                    fill="none" 
                                                    stroke="#374151" 
                                                    stroke-width="10"
                                                    opacity="0.5"
                                                ></circle>
                                                
                                                <!-- Progress circle -->
                                                <circle 
                                                    cx="75" 
                                                    cy="75" 
                                                    r="60" 
                                                    fill="none" 
                                                    stroke="#22c55e" 
                                                    stroke-width="10"
                                                    stroke-linecap="round"
                                                    stroke-dasharray="377"
                                                    transform="rotate(-90 75 75)"
                                                    class="progress-circle"
                                                ></circle>
                                            </svg>
                                            
                                            <!-- Center text -->
                                            <div class="donut-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                                <h5 style="margin: 0; font-size: 24px; font-weight: bold; color: #10b981;">
                                                    <span class="counter-number">0</span><span style="font-size: 16px;">%</span>
                                                </h5>
                                                <p style="margin: 5px 0 0 0; font-size: 14px; color: #6b7280;">
                                                    {{ $completedLessons }}/{{ $totalLessons }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="course-description-box">
                        <h4>Course Description</h4>
                        {!! $course->description !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="course-details">
                        <h4>Course Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <p><img src="{{asset('assets/images/icons/users.svg')}}" alt="users"
                                    class="img-fluid"> {{ $courseEnrolledNumber }} Enrolled</p>

                                    <p><img src="{{ asset('assets/images/icons/alerm.svg') }}" alt="users"
                                        class="img-fluid">
                                        @if ($hours > 0)
                                        {{ $hours }} {{ $hours > 1 ? 'Hours' : 'Hour' }}
                                        @endif

                                        {{ $minutes }} {{ $hours > 1 ? 'Minute' : 'Minutes' }} to Completed</p>

                                        <p><img src="{{ asset('assets/images/icons/carriculam.svg') }}" alt="users"
                                            class="img-fluid">{{ $course->modules ? $course->modules->sum(function($module) { return $module->lessons ? $module->lessons->count() : 0; }) : 0 }} Lessons in {{ $course->modules ? $course->modules->count() : 0 }} Modules</p>

                                {{-- <p><img src="{{asset('assets/images/icons/carriculam.svg')}}" alt="users"
                                            class="img-fluid"> {{ $course->curriculum ? $course->curriculum : 0 }} Curriculum</p> --}}

                                <p><img src="{{asset('assets/images/icons/trophy.svg')}}" alt="users" class="img-fluid">
                                                Certificate of Completion</p>

                            </div>
                            <div class="col-lg-6">
                                @if ($course->language)
                                <p><img src="{{asset('assets/images/icons/english.svg')}}" alt="users" class="img-fluid">
                                    {{ $course->language }}</p>
                                @endif
                                @if ($course->platform)
                                <p><img src="{{asset('assets/images/icons/platform.svg')}}" alt="platform" class="img-fluid">
                                    {{ $course->platform }}</p>
                                @endif
                                <p><img src="{{asset('assets/images/icons/loop.svg')}}" alt="users"
                                    class="img-fluid">  Full Lifetime Access</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="modern-modules-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="modules-title">
                                    <i class="fas fa-layer-group text-primary me-3"></i>
                                    Course Modules
                                </h2>
                                <p class="modules-subtitle">Track your progress through each learning module</p>
                            </div>
                            <div class="modules-counter">
                                <span class="badge bg-primary fs-6 px-3 py-2">
                                    {{ $course->modules ? count($course->modules) : 0 }} Modules
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @if($course->modules)
                    @foreach ($course->modules as $module)
                    @php
                        $totalLessons = $module->lessons ? count($module->lessons) : 0;
                        $completedLessons = $module->lessons ? $module->lessons->where('completed', 1)->count() : 0;
                        $percentage = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
                    @endphp
                    <div class="col-12 col-lg-6 col-xl-4 mb-4">
                        <div class="modern-module-card">
                            <!-- Module Header -->
                            <div class="module-header">
                                <div class="module-info">
                                    <h4 class="module-title">{{ $module->title }}</h4>
                                    <div class="module-meta">
                                        <span class="lesson-count">
                                            <i class="fas fa-play-circle me-1"></i>
                                            {{ $totalLessons }} {{ $totalLessons == 1 ? 'Lesson' : 'Lessons' }}
                                        </span>
                                        <span class="completion-status">
                                            <i class="fas fa-check-circle me-1 text-success"></i>
                                            {{ $completedLessons }} Completed
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Enhanced Progress Circle -->
                                <div class="progress-circle-container">
                                    <div class="progress-circle-wrapper">
                                        <svg class="progress-ring" width="70" height="70">
                                            <defs>
                                                <linearGradient id="progressGradientLight{{ $loop->index }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                                    <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                                    <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                                                </linearGradient>
                                                <linearGradient id="progressGradientDark{{ $loop->index }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                                    <stop offset="0%" style="stop-color:#34d399;stop-opacity:1" />
                                                    <stop offset="100%" style="stop-color:#10b981;stop-opacity:1" />
                                                </linearGradient>
                                            </defs>
                                            <circle class="progress-ring-bg" cx="35" cy="35" r="30" />
                                            <circle class="progress-ring-fill" cx="35" cy="35" r="30" 
                                                    style="stroke: url(#progressGradientLight{{ $loop->index }});
                                                           stroke-dasharray: {{ 2 * pi() * 30 }}; 
                                                           stroke-dashoffset: {{ 2 * pi() * 30 * (1 - $percentage / 100) }};" />
                                        </svg>
                                        <div class="progress-text">
                                            <span class="progress-number">{{ round($percentage) }}</span>
                                            <span class="progress-symbol">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="progress-bar-section">
                                <div class="progress-bar-wrapper">
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-labels">
                                    <small class="text-muted">Progress</small>
                                    <small class="text-muted">{{ $completedLessons }}/{{ $totalLessons }}</small>
                                </div>
                            </div>
                            
                            <div class="module-divider"></div>
                            <!-- Enhanced Lessons List -->
                            <div class="lessons-container">
                                @if($module->lessons)
                                    @foreach ($module->lessons->slice(0, 3) as $lesson)
                                    <div class="lesson-item">
                                        <div class="lesson-info">
                                            <div class="lesson-icon">
                                                @if ($lesson->completed == 1)
                                                    <div class="icon-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                @else
                                                    <div class="icon-pending">
                                                        @if ($lesson->type == 'text')
                                                            <i class="fas fa-file-alt"></i>
                                                        @elseif($lesson->type == 'audio')
                                                            <i class="fas fa-headphones"></i>
                                                        @elseif($lesson->type == 'video')
                                                            <i class="fas fa-play"></i>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="lesson-content">
                                                <span class="lesson-title">{{ Str::limit($lesson->title, 40) }}</span>
                                            </div>
                                        </div>
                                        <div class="lesson-status">
                                            @if ($lesson->completed == 1)
                                                <span class="status-badge completed">
                                                    <i class="fas fa-check me-1"></i>Done
                                                </span>
                                            @else
                                                <span class="status-badge pending">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                <!-- Collapsible Additional Lessons -->
                                <div class="collapse" id="collapseExample{{ $module->id }}">
                                    @if($module->lessons)
                                        @foreach ($module->lessons->slice(3, 10) as $lesson)
                                        <div class="lesson-item">
                                            <div class="lesson-info">
                                                <div class="lesson-icon">
                                                    @if ($lesson->completed == 1)
                                                        <div class="icon-completed">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    @else
                                                        <div class="icon-pending">
                                                            @if ($lesson->type == 'text')
                                                                <i class="fas fa-file-alt"></i>
                                                            @elseif($lesson->type == 'audio')
                                                                <i class="fas fa-headphones"></i>
                                                            @elseif($lesson->type == 'video')
                                                                <i class="fas fa-play"></i>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="lesson-content">
                                                    <span class="lesson-title">{{ Str::limit($lesson->title, 40) }}</span>
                                                </div>
                                            </div>
                                            <div class="lesson-status">
                                                @if ($lesson->completed == 1)
                                                    <span class="status-badge completed">
                                                        <i class="fas fa-check me-1"></i>Done
                                                    </span>
                                                @else
                                                    <span class="status-badge pending">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            @if ($module->lessons && count($module->lessons) > 3)
                                <div class="show-more-section">
                                    <button class="show-more-btn" data-bs-toggle="collapse" data-bs-target="#collapseExample{{ $module->id }}" aria-expanded="false" aria-controls="collapseExample{{ $module->id }}">
                                        <span class="show-text">Show {{ count($module->lessons) - 3 }} More Lessons</span>
                                        <span class="hide-text d-none">Show Less</span>
                                        <i class="fas fa-chevron-down transition-icon"></i>
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
                @endif

            </div>
        </div>
    </main>
@endsection

@section('script')

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Existing script
    document.querySelectorAll('.text-center a').forEach(function(element) {
        element.addEventListener('click', function() {
            var ariaExpandedValue = element.getAttribute('aria-expanded');
            element.innerHTML = (ariaExpandedValue === 'false') ? 'Show More <i class="fas fa-angle-down"></i>' : 'Show Less <i class="fas fa-angle-up"></i>';
        });
    });
    
    // Donut chart animation using CSS keyframes with counter
    function animateProgress() {
        const progressCircle = document.querySelector('.progress-circle');
        const counterNumber = document.querySelector('.counter-number');
        
        // Check PHP value
        let targetPercentage = {{ round($overallPercentage, 1) }};
        
        // Ensure percentage is valid
        if (targetPercentage < 0) {
            targetPercentage = 0;
        }
        
        // Cap at 100% maximum
        targetPercentage = Math.min(targetPercentage, 100);
        
        if (progressCircle && counterNumber) {
            // Set initial value to 0
            counterNumber.textContent = '0';
            
            // Start animation after short delay
            setTimeout(() => {
                let currentValue = 0;
                const targetValue = Math.round(targetPercentage); // Round to integer
                const stepDelay = targetValue > 0 ? 3000 / targetValue : 0; // Spread over 3 seconds
                
                function incrementCounter() {
                    currentValue += 1;
                    const displayValue = Math.min(currentValue, targetValue);
                    counterNumber.textContent = displayValue;
                    
                    if (currentValue < targetValue) {
                        setTimeout(incrementCounter, stepDelay);
                    }
                }
                
                if (targetValue > 0) {
                    incrementCounter();
                }
                
            }, 500);
            
            // Trigger donut CSS animation
            setTimeout(() => {
                progressCircle.classList.add('animate');
            }, 500);
        }
    }
    
    // Start animation after page load
    setTimeout(animateProgress, 200);
    
    // Enhanced module interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Handle show more/less functionality
        const showMoreBtns = document.querySelectorAll('.show-more-btn');
        
        showMoreBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const showText = this.querySelector('.show-text');
                const hideText = this.querySelector('.hide-text');
                const icon = this.querySelector('.transition-icon');
                
                // Toggle text and icon
                if (this.getAttribute('aria-expanded') === 'true') {
                    showText.classList.remove('d-none');
                    hideText.classList.add('d-none');
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    showText.classList.add('d-none');
                    hideText.classList.remove('d-none');
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
        
        // Add entrance animations to module cards
        const moduleCards = document.querySelectorAll('.modern-module-card');
        moduleCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });
        
        // Handle theme-based progress ring gradients
        function updateProgressGradients() {
            const isDark = document.body.classList.contains('dark-mode') || document.documentElement.classList.contains('dark');
            const progressRings = document.querySelectorAll('.progress-ring-fill');
            
            progressRings.forEach((ring, index) => {
                const gradientId = isDark ? `progressGradientDark${index}` : `progressGradientLight${index}`;
                ring.style.stroke = `url(#${gradientId})`;
            });
        }
        
        // Update gradients on theme change
        updateProgressGradients();
        
        // Listen for theme changes (if you have a theme toggle)
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                setTimeout(updateProgressGradients, 100);
            });
        }
    });
});
</script>

@endsection
