@extends('layouts.guest')
@section('title', 'সকল কোর্স - ' . config('app.name'))

@section('style')
<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4338ca;
    --secondary: #10b981;
    --accent: #f59e0b;
    --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    --gradient-secondary: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --glass-bg: rgba(255, 255, 255, 0.1);
    --glass-border: rgba(255, 255, 255, 0.2);
    --shadow-soft: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    line-height: 1.6;
}

/* Hero Section */
.hero-section {
    background: var(--gradient-primary);
    color: white;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.05"><circle cx="36" cy="24" r="1"/></g></svg>');
    opacity: 0.5;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    text-align: center;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 2rem;
}

/* Filter Section */
.filter-section {
    background: white;
    padding: 2rem 0;
    box-shadow: var(--shadow-soft);
    position: sticky;
    top: 0;
    z-index: 100;
}

.filter-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: var(--shadow-soft);
    border: 1px solid rgba(0,0,0,0.05);
}

.filter-form .form-control, .filter-form .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.filter-form .form-control:focus, .filter-form .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    outline: none;
}

.btn-filter {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    color: white;
}

.btn-clear {
    background: #f3f4f6;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-clear:hover {
    background: #e5e7eb;
    color: #374151;
    transform: translateY(-1px);
}

/* Course Grid */
.courses-section {
    padding: 3rem 0;
    background: #f8fafc;
    min-height: 60vh;
}

.course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

/* Course Card */
.course-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
}

.course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.course-image {
    position: relative;
    height: 200px;
    background: var(--gradient-primary);
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

.course-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--gradient-accent);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: var(--shadow-soft);
}

.course-stats {
    position: absolute;
    bottom: 15px;
    left: 15px;
    display: flex;
    gap: 1rem;
}

.stat-item {
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.course-content {
    padding: 1.5rem;
}

.course-instructor {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #6b7280;
    font-size: 0.9rem;
}

.instructor-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.course-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.8rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-description {
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 1.2rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.course-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stars {
    color: #fbbf24;
    display: flex;
    gap: 0.1rem;
}

.rating-text {
    color: #6b7280;
    font-size: 0.9rem;
}

.course-students {
    color: #6b7280;
    font-size: 0.9rem;
}

.course-footer {
    display: flex;
    justify-content: between;
    align-items: center;
    gap: 1rem;
}

.course-price {
    flex: 1;
}

.price-current {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--secondary);
    margin-right: 0.5rem;
}

.price-original {
    font-size: 1rem;
    color: #9ca3af;
    text-decoration: line-through;
}

.course-discount {
    background: #fee2e2;
    color: #dc2626;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.btn-enroll {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 140px;
    justify-content: center;
}

.btn-enroll:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #d1d5db;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #374151;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    color: var(--primary);
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    margin: 0 0.2rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .course-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .filter-section {
        padding: 1.5rem 0;
    }
    
    .course-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .btn-enroll {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .hero-section {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .course-content {
        padding: 1.2rem;
    }
}

/* Loading Animation */
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">সকল কোর্স</h1>
            <p class="hero-subtitle">
                আপনার ক্যারিয়ার গড়ুন দক্ষতা উন্নয়নের মাধ্যমে। হাজারো শিক্ষার্থীর পছন্দের অনলাইন কোর্স প্ল্যাটফর্ম।
            </p>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-card">
            <form method="GET" action="{{ route('courses') }}" class="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">কোর্স খুঁজুন</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ $search }}" placeholder="কোর্সের নাম লিখুন...">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="category" class="form-label fw-semibold">বিভাগ</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">সকল বিভাগ</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="sort" class="form-label fw-semibold">সাজান</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>নতুন</option>
                            <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>জনপ্রিয়</option>
                            <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>দাম (কম-বেশি)</option>
                            <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>দাম (বেশি-কম)</option>
                            <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>নাম (ক-য)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filter">
                                <i class="fas fa-search"></i>
                                খুঁজুন
                            </button>
                            @if($search || $category || $sort != 'latest')
                                <a href="{{ route('courses') }}" class="btn btn-clear">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        @if($courses->count() > 0)
            <div class="course-grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-image">
                            <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/default-course.jpg') }}" 
                                 alt="{{ $course->title }}"
                                 onerror="this.src='https://via.placeholder.com/350x200/6366f1/ffffff?text=কোর্স'">
                            
                            @if($course->offer_price && $course->price > $course->offer_price)
                                @php
                                    $discount = round((($course->price - $course->offer_price) / $course->price) * 100);
                                @endphp
                                <div class="course-badge">{{ $discount }}% ছাড়</div>
                            @endif
                            
                            <div class="course-stats">
                                <div class="stat-item">
                                    <i class="fas fa-play-circle"></i>
                                    {{ $course->total_lessons ?? 0 }} লেকচার
                                </div>
                                @if($course->total_hours > 0 || $course->total_minutes > 0)
                                    <div class="stat-item">
                                        <i class="fas fa-clock"></i>
                                        @if($course->total_hours > 0)
                                            {{ $course->total_hours }}ঘ 
                                        @endif
                                        {{ $course->total_minutes ?? 0 }}মি
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="course-content">
                            <div class="course-instructor">
                                <img src="{{ $course->user->avatar ? asset($course->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($course->user->name) . '&background=6366f1&color=ffffff' }}" 
                                     alt="{{ $course->user->name }}" class="instructor-avatar">
                                <span>{{ $course->user->name }}</span>
                            </div>
                            
                            <h3 class="course-title">{{ $course->title }}</h3>
                            
                            @if($course->short_description)
                                <p class="course-description">{{ $course->short_description }}</p>
                            @endif
                            
                            <div class="course-meta">
                                <div class="course-rating">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa{{ $i <= ($course->average_rating ?? 0) ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="rating-text">
                                        {{ number_format($course->average_rating ?? 0, 1) }} 
                                        ({{ $course->review_count ?? 0 }})
                                    </span>
                                </div>
                                
                                <div class="course-students">
                                    <i class="fas fa-users"></i>
                                    {{ $course->enrolled_count ?? 0 }} শিক্ষার্থী
                                </div>
                            </div>
                            
                            <div class="course-footer">
                                <div class="course-price">
                                    @if($course->offer_price && $course->price > $course->offer_price)
                                        <span class="price-current">৳{{ number_format($course->offer_price) }}</span>
                                        <span class="price-original">৳{{ number_format($course->price) }}</span>
                                    @else
                                        <span class="price-current">
                                            {{ $course->price > 0 ? '৳' . number_format($course->price) : 'ফ্রি' }}
                                        </span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('courses.overview', $course->slug) }}" class="btn btn-enroll">
                                    <i class="fas fa-eye"></i>
                                    বিস্তারিত দেখুন
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="pagination-wrapper">
                    {{ $courses->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>কোনো কোর্স পাওয়া যায়নি</h3>
                <p>আপনার অনুসন্ধানের সাথে মিল রয়েছে এমন কোনো কোর্স খুঁজে পাওয়া যায়নি।</p>
                @if($search || $category)
                    <a href="{{ route('courses') }}" class="btn btn-filter mt-3">
                        <i class="fas fa-refresh"></i>
                        সব কোর্স দেখুন
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading animation to form submit
    const form = document.querySelector('.filter-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="loading"></span> খুঁজছি...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
    
    // Auto-submit form on select change
    const selects = form.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            // Small delay for better UX
            setTimeout(() => {
                form.submit();
            }, 300);
        });
    });
});
</script>
@endsection