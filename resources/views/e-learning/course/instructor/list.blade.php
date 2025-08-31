@extends('layouts.latest.instructor')
@section('title')
All Courses
@endsection
@php
    use Illuminate\Support\Str;
@endphp
{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<style>
/* Modern Course Listing Page Styles */
:root {
    --primary-color: #4f46e5;
    --secondary-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark-color: #1f2937;
    --gray-color: #6b7280;
    --light-gray: #f3f4f6;
    --white: #ffffff;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --border-radius: 16px;
    --border-radius-sm: 8px;
}

/* Page Header Styles */
.courses-lists-pages {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.page-header {
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
}

.page-title {
    color: var(--dark-color);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: var(--gray-color);
    font-size: 1rem;
    margin-bottom: 0;
}

/* Search and Filter Section */
.search-filter-section {
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-md);
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper .fas {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-color);
    z-index: 10;
}

.search-input {
    padding: 0.875rem 1rem 0.875rem 2.5rem;
    border: 2px solid #e5e7eb;
    border-radius: var(--border-radius-sm);
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    outline: none;
}

.filter-dropdown {
    position: relative;
}

.filter-btn {
    background: var(--white);
    border: 2px solid #e5e7eb;
    border-radius: var(--border-radius-sm);
    padding: 0.875rem 1.5rem;
    font-weight: 500;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.add-course-btn {
    background: linear-gradient(135deg, var(--primary-color), #6366f1);
    color: var(--white);
    border: none;
    border-radius: var(--border-radius-sm);
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.add-course-btn:hover {
    background: linear-gradient(135deg, #4338ca, var(--primary-color));
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
    color: var(--white);
}

/* Professional Course List Styles */
.professional-course-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.course-card {
    background: var(--white);
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.course-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
    transform: translateY(-4px);
}

/* Course Image Container */
.course-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.course-image-wrapper {
    width: 100%;
    height: 100%;
    position: relative;
}

.course-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.course-card:hover .course-image {
    transform: scale(1.08);
}

/* Status Badge */
.status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.status-pending {
    background: rgba(251, 191, 36, 0.9);
    color: #ffffff;
}

.status-draft {
    background: rgba(107, 114, 128, 0.9);
    color: #ffffff;
}

.status-published {
    background: rgba(34, 197, 94, 0.9);
    color: #ffffff;
}

/* Course Content */
.course-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: 1rem;
}

/* Course Header */
.course-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.course-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    flex: 1;
}

.course-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.2s ease;
}

.course-title a:hover {
    color: #667eea;
}

.course-price {
    flex-shrink: 0;
    text-align: right;
}

.price-current {
    color: #059669;
    font-weight: 700;
    font-size: 1.1rem;
    display: block;
}

.price-original {
    color: #6b7280;
    text-decoration: line-through;
    font-size: 0.85rem;
    display: block;
    margin-top: 2px;
}

.price-free {
    color: #059669;
    font-weight: 700;
    font-size: 1.1rem;
    display: block;
}

/* Course Description */
.course-description {
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

/* Course Statistics */
.course-stats {
    margin-top: auto;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    padding: 1rem 0;
    border-top: 1px solid #f3f4f6;
}

.stat-item {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.stat-item i {
    font-size: 1.1rem;
    margin-bottom: 2px;
}

.stat-number {
    font-weight: 700;
    font-size: 1rem;
    color: #1f2937;
    line-height: 1;
}

.stat-label {
    font-size: 0.7rem;
    color: #6b7280;
    font-weight: 500;
    line-height: 1;
}

/* Course Footer */
.course-footer {
    padding-top: 0.75rem;
    border-top: 1px solid #f3f4f6;
}

.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    color: #6b7280;
}

.meta-date,
.meta-modules {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Course Actions */
.course-actions {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 10;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.course-card:hover .course-actions {
    opacity: 1;
    transform: translateY(0);
}

.action-buttons {
    display: flex;
    gap: 6px;
    background: rgba(255, 255, 255, 0.95);
    padding: 8px;
    border-radius: 8px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.action-buttons .btn {
    padding: 6px 8px;
    border-radius: 6px;
    border: none;
    transition: all 0.2s ease;
    font-size: 0.85rem;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
}

/* Bootstrap Color Classes */
.text-primary { color: #667eea !important; }
.text-success { color: #059669 !important; }
.text-warning { color: #d97706 !important; }
.text-info { color: #0891b2 !important; }

.professional-course-item {
    background: var(--white);
    border-radius: var(--border-radius);
    border: 1px solid #e5e7eb;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    overflow: hidden;
    min-height: 200px;
}

.professional-course-item:hover {
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.course-main-content {
    display: flex;
    flex: 1;
    gap: 1.5rem;
    padding: 1.5rem;
}

.course-thumbnail-wrapper {
    flex-shrink: 0;
    position: relative;
    width: 180px;
    height: 120px;
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.course-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.status-badge {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
}

.badge-published, .badge-pending, .badge-draft {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge-published {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.badge-pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.badge-draft {
    background: rgba(107, 114, 128, 0.1);
    color: #374151;
    border: 1px solid rgba(107, 114, 128, 0.2);
}

.course-info-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.course-header {
    margin-bottom: 1rem;
}

.course-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.4;
}

.course-title a {
    color: var(--dark-color);
    text-decoration: none;
    transition: color 0.2s ease;
}

.course-title a:hover {
    color: var(--primary-color);
}

.course-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: var(--gray-color);
    font-size: 0.875rem;
    font-weight: 500;
}

.meta-item i {
    font-size: 0.75rem;
    color: var(--primary-color);
}

.course-description {
    color: var(--gray-color);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.course-stats-row {
    display: flex;
    gap: 2rem;
    margin-top: auto;
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray-color);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-value {
    font-weight: 600;
    color: var(--dark-color);
}

.rating-stars {
    display: flex;
    gap: 0.125rem;
    margin-bottom: 0.25rem;
}

.rating-stars i {
    font-size: 0.875rem;
    color: #fbbf24;
}

.rating-number {
    font-size: 0.875rem;
    color: var(--gray-color);
    margin-left: 0.5rem;
}

.price-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.current-price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--secondary-color);
}

.original-price {
    font-size: 0.875rem;
    text-decoration: line-through;
    color: var(--gray-color);
}

.free-price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--secondary-color);
}

.revenue {
    color: var(--secondary-color) !important;
    font-size: 1rem;
}

.course-actions-panel {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    border-left: 1px solid #f3f4f6;
    background: #fafbfc;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: var(--border-radius-sm);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    background: transparent;
    color: var(--gray-color);
    white-space: nowrap;
}

.action-btn:hover {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary-color);
}

.btn-view:hover {
    background: rgba(16, 185, 129, 0.1);
    color: var(--secondary-color);
}

.btn-edit:hover {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-color);
}

.btn-preview:hover {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary-color);
}

.course-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: #e5e7eb;
}

.course-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-card:hover .course-image img {
    transform: scale(1.05);
}

.course-status-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 10;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
}

.status-published {
    background: var(--secondary-color);
    color: var(--white);
}

.status-draft {
    background: var(--warning-color);
    color: var(--white);
}

.status-pending {
    background: var(--danger-color);
    color: var(--white);
}

.course-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 10;
}

.action-btn {
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.action-btn:hover {
    background: var(--white);
    box-shadow: var(--shadow-md);
}

.course-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-title:hover {
    color: var(--primary-color);
}

.course-description {
    color: var(--gray-color);
    font-size: 0.875rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.rating-stars {
    display: flex;
    gap: 0.25rem;
}

.rating-stars i {
    color: #fbbf24;
    font-size: 0.875rem;
}

.rating-text {
    color: var(--gray-color);
    font-size: 0.875rem;
    font-weight: 500;
}

.course-footer {
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: between;
    gap: 1rem;
}

.course-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

.original-price {
    color: var(--gray-color);
    text-decoration: line-through;
    font-size: 1rem;
    font-weight: 400;
    margin-left: 0.5rem;
}

.sales-info {
    font-size: 0.75rem;
    color: var(--secondary-color);
    font-weight: 600;
    background: rgba(16, 185, 129, 0.1);
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
}

/* Pagination */
.pagination-wrapper {
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .professional-course-list {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }
}

@media (max-width: 768px) {
    .courses-lists-pages {
        padding: 1rem 0;
    }
    
    .page-header,
    .search-filter-section {
        margin-left: 1rem;
        margin-right: 1rem;
        padding: 1.5rem;
    }
    
    .professional-course-list {
        grid-template-columns: 1fr;
        margin-left: 1rem;
        margin-right: 1rem;
        gap: 1rem;
    }
    
    .course-image-container {
        height: 180px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }
    
    .stat-item {
        gap: 2px;
    }
    
    .stat-number {
        font-size: 0.9rem;
    }
    
    .stat-label {
        font-size: 0.65rem;
    }
    
    .course-content {
        padding: 1rem;
    }
    
    .course-title {
        font-size: 1rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
}

@media (max-width: 480px) {
    .professional-course-list {
        grid-template-columns: 1fr;
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        gap: 0.75rem;
    }
    
    .course-image-container {
        height: 160px;
    }
    
    .course-content {
        padding: 0.75rem;
    }
    
    .course-title {
        font-size: 0.95rem;
        line-height: 1.3;
    }
    
    .course-description {
        font-size: 0.85rem;
    }
    
    .stats-grid {
        padding: 0.75rem 0;
    }
    
    .action-buttons .btn {
        padding: 4px 6px;
        font-size: 0.8rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection
{{-- style section @E --}}

@section('content')
<main class="courses-lists-pages">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="page-title">My Courses</h1>
                    <p class="page-subtitle">Manage and track your course portfolio</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <i class="fas fa-chart-line"></i>
                        <span class="fw-medium">{{ count($courses) }} Courses</span>
                    </div>
                    <a href="{{ url('instructor/courses/create') }}" class="add-course-btn">
                        <i class="fas fa-plus"></i>
                        <span>Create Course</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <form action="" method="GET" id="myForm">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-6">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" 
                                   class="search-input" 
                                   name="title"
                                   placeholder="Search courses by title or description..."
                                   value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                        </div>
                        <input type="hidden" name="status" id="inputField">
                    </div>
                    <div class="col-lg-3">
                        <div class="filter-dropdown">
                            <div class="dropdown">
                                <button class="filter-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownBttn">
                                    <span>All Courses</span>
                                    <i class="fas fa-chevron-down ms-2"></i>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li><a class="dropdown-item filterItem" href="#">All Courses</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="best_rated">
                                        <i class="fas fa-star me-2 text-warning"></i>Best Rated</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="most_purchased">
                                        <i class="fas fa-fire me-2 text-danger"></i>Most Purchased</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="newest">
                                        <i class="fas fa-clock me-2 text-info"></i>Newest</a></li>
                                    <li><a class="dropdown-item filterItem" href="#" data-value="oldest">
                                        <i class="fas fa-history me-2 text-secondary"></i>Oldest</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href = '{{ url('instructor/courses') }}'">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Professional Course List -->
        @if (count($courses) > 0)
        <div class="professional-course-list">
            @foreach ($courses as $course)
            @php
                $review_sum = 0;
                $review_avg = 0;
                $total = 0;
                foreach ($course->reviews as $review) {
                    $total++;
                    $review_sum += $review->star;
                }
                if ($total) {
                    $review_avg = round($review_sum / $total, 1);
                }
                
                $enrollmentCount = \App\Models\CourseEnrollment::where('course_id', $course->id)->count();
                $moduleCount = \App\Models\Module::where('course_id', $course->id)->count();
                $lessonCount = \App\Models\Lesson::where('course_id', $course->id)->count();
                $revenueCount = \App\Models\Checkout::where('course_id', $course->id)
                    ->whereIn('payment_method', ['bkash', 'nogod', 'rocket', 'manual'])
                    ->whereIn('payment_status', ['completed', 'Paid'])
                    ->sum('amount');
            @endphp
            
            <div class="course-card">
                <!-- Course Image Container -->
                <div class="course-image-container">
                    <div class="course-image-wrapper">
                        <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                             alt="{{ $course->title }}" 
                             class="course-image"
                             loading="lazy">
                        
                        <!-- Status Badge -->
                        @if ($course->status == 'pending')
                        <div class="status-badge status-pending">
                            <i class="fas fa-clock"></i>
                            <span>Pending</span>
                        </div>
                        @elseif ($course->status == 'draft')
                        <div class="status-badge status-draft">
                            <i class="fas fa-edit"></i>
                            <span>Draft</span>
                        </div>
                        @elseif ($course->status == 'published')
                        <div class="status-badge status-published">
                            <i class="fas fa-check-circle"></i>
                            <span>Live</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Course Content -->
                <div class="course-content">
                    <!-- Course Header -->
                    <div class="course-header">
                        <h3 class="course-title">
                            <a href="{{ url('instructor/courses/' . $course->slug) }}">
                                {{ $course->title ? $course->title : 'Untitled course' }}
                            </a>
                        </h3>
                        
                        <div class="course-price">
                            @if ($course->offer_price)
                                <span class="price-current">৳{{ number_format($course->offer_price) }}</span>
                                <span class="price-original">৳{{ number_format($course->price) }}</span>
                            @elseif(!$course->offer_price && !$course->price)
                                <span class="price-free">Free</span>
                            @else
                                <span class="price-current">৳{{ number_format($course->price) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Course Description -->
                    <div class="course-description">
                        {!! Str::limit(strip_tags($course->short_description), 120, '...') !!}
                    </div>
                    
                    <!-- Course Statistics -->
                    <div class="course-stats">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <i class="fas fa-play-circle text-primary"></i>
                                <span class="stat-number">{{ $lessonCount }}</span>
                                <span class="stat-label">লেসন</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users text-success"></i>
                                <span class="stat-number">{{ $enrollmentCount }}</span>
                                <span class="stat-label">শিক্ষার্থী</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star text-warning"></i>
                                <span class="stat-number">{{ number_format($review_avg, 1) }}</span>
                                <span class="stat-label">({{ $total }})</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-taka-sign text-info"></i>
                                <span class="stat-number">{{ number_format($revenueCount) }}</span>
                                <span class="stat-label">আয়</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Course Footer -->
                    <div class="course-footer">
                        <div class="course-meta">
                            <span class="meta-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $course->created_at->format('M d, Y') }}
                            </span>
                            <span class="meta-modules">
                                <i class="fas fa-layer-group"></i>
                                {{ $moduleCount }} মডিউল
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Course Actions -->
                <div class="course-actions">
                    <div class="action-buttons">
                        <a href="{{ url('instructor/courses/' . $course->slug) }}" 
                           class="btn btn-outline-primary btn-sm" 
                           title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <a href="{{ url('instructor/courses/create/' . $course->id.'/facts') }}" 
                           class="btn btn-outline-secondary btn-sm" 
                           title="Edit Course">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <a href="{{ url('courses/' . $course->slug) }}" 
                           class="btn btn-outline-success btn-sm" 
                           title="Preview Course">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-dark btn-sm dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false"
                                    title="More Actions">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="post" class="d-inline w-100" action="{{ route('instructor.courses.destroy', $course->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="dropdown-item text-danger"
                                                onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                            <i class="fas fa-trash me-2"></i>Delete Course
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <div class="text-center">
                <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                <h3 class="text-muted mb-3">No Courses Found</h3>
                <p class="text-muted mb-4">You haven't created any courses yet. Start building your first course to share your knowledge!</p>
                <a href="{{ url('instructor/courses/create') }}" class="add-course-btn">
                    <i class="fas fa-plus"></i>
                    <span>Create Your First Course</span>
                </a>
            </div>
        </div>
        @endif

       <!-- Pagination -->
        @if ($courses->hasPages())
            <div class="pagination-wrapper">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</main>
@endsection


{{-- page script @S --}}
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize form elements
        const inputField = document.getElementById("inputField");
        const dropbtn = document.getElementById("dropdownBttn");
        const form = document.getElementById("myForm");
        const dropdownItems = document.querySelectorAll(".filterItem");
        
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        
        // Update dropdown button text based on current filter
        const filterLabels = {
            'best_rated': 'Best Rated',
            'most_purchased': 'Most Purchased',
            'newest': 'Newest',
            'oldest': 'Oldest'
        };
        
        if (status && filterLabels[status]) {
            dropbtn.querySelector('span').textContent = filterLabels[status];
        }
        
        // Set hidden field value
        if (inputField) {
            inputField.value = status || '';
        }
        
        // Handle filter dropdown clicks
        dropdownItems.forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                
                const value = this.getAttribute("data-value");
                const text = this.textContent.trim();
                
                // Update UI
                dropbtn.querySelector('span').textContent = text;
                if (inputField) {
                    inputField.value = value || '';
                }
                
                // Submit form
                form.submit();
            });
        });
        
        // Enhanced search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            // Auto-submit on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    form.submit();
                }
            });
        }
        
        // Add loading states to buttons
        const searchBtn = document.querySelector('button[type="submit"]');
        if (searchBtn) {
            searchBtn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Searching...';
                this.disabled = true;
            });
        }
        
        // Course card interactions
        const courseCards = document.querySelectorAll('.course-card');
        courseCards.forEach(card => {
            // Add subtle animation on hover
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Smooth scroll to top when filters change
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Add click handlers for course actions
        const actionDropdowns = document.querySelectorAll('.course-actions .dropdown-toggle');
        actionDropdowns.forEach(dropdown => {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endsection
{{-- page script @E --}}
