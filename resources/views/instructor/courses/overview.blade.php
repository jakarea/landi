@extends('layouts.latest.instructor')

@section('title', 'Course Overview - ' . $course->title)

@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .course-description-content {
            font-size: 1rem;
            line-height: 1.7;
            color: #555;
        }
        
        .course-description-content p {
            margin-bottom: 1rem;
        }
        
        .course-description-content h1,
        .course-description-content h2,
        .course-description-content h3,
        .course-description-content h4,
        .course-description-content h5,
        .course-description-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #333;
        }
        
        .course-description-content ul,
        .course-description-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        
        .course-description-content li {
            margin-bottom: 0.25rem;
        }
        
        .course-description-content strong,
        .course-description-content b {
            font-weight: 600;
            color: #333;
        }
        
        .stats-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stats-item {
            text-align: center;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Course Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" 
                                     class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 100%; height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h2 class="mb-3">{{ $course->title }}</h2>
                            <div class="mb-3">
                                <span class="badge badge-{{ $course->status == 'published' ? 'success' : 'warning' }} me-2">
                                    {{ ucfirst($course->status) }}
                                </span>
                                @if($course->categories)
                                    @foreach(explode(',', $course->categories) as $category)
                                        <span class="badge badge-secondary me-1">{{ trim($category) }}</span>
                                    @endforeach
                                @endif
                            </div>
                            
                            @if($course->short_description)
                                <p class="text-muted">{{ $course->short_description }}</p>
                            @endif
                            
                            <!-- Course Stats -->
                            <div class="stats-card">
                                <div class="row">
                                    <div class="col-md-3 stats-item">
                                        <div class="stats-number">{{ $course->total_lessons }}</div>
                                        <div class="stats-label">Total Lessons</div>
                                    </div>
                                    <div class="col-md-3 stats-item">
                                        <div class="stats-number">{{ $course->total_duration_minutes }}</div>
                                        <div class="stats-label">Minutes</div>
                                    </div>
                                    <div class="col-md-3 stats-item">
                                        <div class="stats-number">{{ $course->enrolled_count }}</div>
                                        <div class="stats-label">Students Enrolled</div>
                                    </div>
                                    <div class="col-md-3 stats-item">
                                        <div class="stats-number">{{ number_format($course->average_rating, 1) }}</div>
                                        <div class="stats-label">Average Rating ({{ $course->review_count }} reviews)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Course Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('instructor.courses.edit', $course->slug) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit"></i> Edit Course
                            </a>
                            <a href="{{ route('courses.overview', $course->slug) }}" target="_blank" class="btn btn-info me-2">
                                <i class="fas fa-external-link-alt"></i> View Public Page
                            </a>
                            @if($course->status == 'published')
                                <button class="btn btn-success me-2" disabled>
                                    <i class="fas fa-check"></i> Published
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Objectives -->
            @if($course->objectives)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">What Students Will Learn</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @php
                                $objectives = explode("\n", $course->objectives);
                            @endphp
                            @foreach ($objectives as $objective)
                                @if (trim($objective) !== '')
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> {{ trim($objective) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            <!-- Course Description -->
            @if($course->description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Course Description</h4>
                    </div>
                    <div class="card-body">
                        <div class="course-description-content">
                            {!! $course->description !!} 
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Course Content -->
            @if($course->modules->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Course Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="courseContentAccordion">
                            @foreach ($course->modules as $module)
                                <div class="accordion-item mb-2">
                                    <div class="accordion-header" id="heading_{{ $module->id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $module->id }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $module->id }}">
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">{{ $module->title }}
                                                        @if($module->lessons->count() > 0)
                                                            <span class="badge badge-info ms-2">{{ $module->lessons->count() }} lessons</span>
                                                        @endif
                                                    </h6>
                                                    <i class="fas fa-angle-down"></i>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="collapse_{{ $module->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading_{{ $module->id }}" data-bs-parent="#courseContentAccordion">
                                        <div class="accordion-body">
                                            @if($module->lessons->count() > 0)
                                                <ul class="list-unstyled">
                                                    @foreach($module->lessons as $lesson)
                                                        <li class="mb-2 d-flex justify-content-between align-items-center">
                                                            <span>
                                                                <i class="fas fa-play-circle text-primary me-2"></i>
                                                                {{ $lesson->title }}
                                                            </span>
                                                            @if(isset($lesson->duration))
                                                                <small class="text-muted">
                                                                    {{ gmdate("i:s", $lesson->duration) }}
                                                                </small>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">No lessons added yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pricing Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Pricing Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Regular Price:</strong> 
                                @if($course->price > 0)
                                    ৳{{ number_format($course->price) }}
                                @else
                                    Free
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Offer Price:</strong> 
                                @if($course->offer_price > 0)
                                    ৳{{ number_format($course->offer_price) }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection