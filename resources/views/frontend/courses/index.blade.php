@extends('layouts.guest')
@section('title', $title)

@section('style')
<style>
/* Course Listing Page Styles */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --glass-bg: rgba(255, 255, 255, 0.25);
    --glass-border: rgba(255, 255, 255, 0.18);
    --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
}

body {
    background: var(--primary-gradient);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, 'SolaimanLipi';
}

.courses-header {
    padding: 120px 0 60px;
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.courses-title {
    color: white;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.courses-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.2rem;
    margin-bottom: 0;
}

.filters-section {
    padding: 40px 0;
    background: rgba(255, 255, 255, 0.05);
}

.filters-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid var(--glass-border);
    padding: 30px;
    margin-bottom: 30px;
}

.filter-group {
    margin-bottom: 20px;
}

.filter-label {
    color: white;
    font-weight: 600;
    margin-bottom: 10px;
    display: block;
}

.filter-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--glass-border);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.filter-input:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
}

.filter-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.filter-select {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'><path fill='%23ffffff' d='M2 0L0 2h4zm0 5L0 3h4z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 12px;
    padding-right: 40px;
}

.filter-btn {
    background: var(--accent-gradient);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    color: white;
}

.results-info {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 30px;
    font-size: 1.1rem;
}

.course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.course-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid var(--glass-border);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow);
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

.course-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--secondary-gradient);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.course-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.course-category, .course-level {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.course-category {
    background: rgba(102, 126, 234, 0.2);
    color: #667eea;
}

.course-level {
    background: rgba(245, 87, 108, 0.2);
    color: #f5576c;
}

.course-title {
    margin-bottom: 15px;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.4;
}

.course-title a {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
}

.course-title a:hover {
    color: #667eea;
}

.course-description {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
}

.course-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-item {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.stat-item i {
    color: #667eea;
    width: 16px;
}

.course-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.stars {
    display: flex;
    gap: 2px;
}

.stars i {
    color: #ddd;
    font-size: 1rem;
}

.stars i.active {
    color: #ffd700;
}

.rating-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.course-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.course-price {
    display: flex;
    align-items: center;
    gap: 10px;
}

.price-current {
    color: #4facfe;
    font-size: 1.25rem;
    font-weight: 700;
}

.price-original {
    color: rgba(255, 255, 255, 0.5);
    font-size: 1rem;
    text-decoration: line-through;
}

.price-free {
    color: #00f2fe;
    font-size: 1.25rem;
    font-weight: 700;
}

.course-instructor {
    color: rgba(255, 255, 255, 0.8);
    text-align: right;
    font-size: 0.9rem;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.pagination {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 10px;
    border: 1px solid var(--glass-border);
}

.page-link {
    color: rgba(255, 255, 255, 0.8);
    background: transparent;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin: 0 2px;
}

.page-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.page-item.active .page-link {
    background: var(--accent-gradient);
    color: white;
}

.no-courses {
    text-align: center;
    padding: 60px 20px;
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    border: 1px solid var(--glass-border);
}

.no-courses-icon {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.3);
    margin-bottom: 20px;
}

.no-courses-title {
    color: white;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.no-courses-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .courses-title {
        font-size: 2rem;
    }
    
    .course-grid {
        grid-template-columns: 1fr;
    }
    
    .course-meta {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .course-stats {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
@endsection
@php
     use Illuminate\Support\Str;
@endphp
@section('content')
<!-- Header Section -->
<section class="courses-header">
    <div class="container">
        <h1 class="courses-title">সকল কোর্স</h1>
        <p class="courses-subtitle">আপনার পছন্দের কোর্স খুঁজে নিন</p>
    </div>
</section>

<!-- Filters Section -->
<section class="filters-section">
    <div class="container">
        <div class="filters-card">
            <form method="GET" action="{{ route('courses') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label class="filter-label">খুঁজুন</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   placeholder="কোর্সের নাম লিখুন..." 
                                   class="filter-input">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="filter-group">
                            <label class="filter-label">ক্যাটেগরি</label>
                            <select name="category" class="filter-input filter-select">
                                <option value="">সব ক্যাটেগরি</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="filter-group">
                            <label class="filter-label">সাজান</label>
                            <select name="sort" class="filter-input filter-select">
                                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>নতুন আগে</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>জনপ্রিয়</option>
                                <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>নাম (ক-ম)</option>
                                <option value="title_desc" {{ $sort == 'title_desc' ? 'selected' : '' }}>নাম (ম-ক)</option>
                                <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>মূল্য (কম)</option>
                                <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>মূল্য (বেশি)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="filter-btn w-100">
                                <i class="fas fa-search"></i> খুঁজুন
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="courses-content">
    <div class="container">
        @if($courses->count() > 0)
            <div class="results-info">
                {{ $courses->total() }} টি কোর্স পাওয়া গেছে
                @if($search)
                    "{{ $search }}" এর জন্য
                @endif
            </div>
            
            <div class="course-grid">
                @foreach($courses as $course)
                <div class="course-card">
                    <div class="course-image">
                        <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                             alt="{{ $course->title }}">
                        @if($course->offer_price)
                            <span class="course-badge">অফার</span>
                        @elseif(!$course->price)
                            <span class="course-badge" style="background: var(--accent-gradient)">বিনামূল্যে</span>
                        @endif
                    </div>
                    
                    <div class="course-content">
                        <div class="course-meta">
                            <span class="course-category">{{ explode(',', $course->categories)[0] ?? 'সাধারণ' }}</span>
                        </div>
                        
                        <h5 class="course-title">
                            <a href="{{ route('courses.overview', $course->slug) }}">
                                {{ $course->title }}
                            </a>
                        </h5>
                        
                        <p class="course-description">
                            {!! Str::limit($course->short_description, 150) !!}
                        </p>
                        
                        <div class="course-stats">
                            <span class="stat-item">
                                <i class="fas fa-clock"></i>
                                @if($course->total_hours > 0)
                                    {{ $course->total_hours }}ঘ {{ $course->total_minutes }}মি
                                @elseif($course->total_minutes > 0)
                                    {{ $course->total_minutes }}মি
                                @else
                                    সময় নির্ধারিত নয়
                                @endif
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-book"></i>
                                {{ $course->total_lessons ?? 0 }} পাঠ
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-layer-group"></i>
                                {{ $course->total_modules ?? 0 }} মডিউল
                            </span>
                            <span class="stat-item">
                                <i class="fas fa-users"></i>
                                {{ number_format($course->enrolled_count ?? 0) }} শিক্ষার্থী
                            </span>
                        </div>
                        
                        @if($course->average_rating > 0)
                        <div class="course-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $course->average_rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="rating-text">{{ $course->average_rating }} ({{ $course->review_count }} রিভিউ)</span>
                        </div>
                        @endif
                        
                        <div class="course-footer">
                            <div class="course-price">
                                @if($course->offer_price)
                                    <span class="price-current">৳{{ number_format($course->offer_price) }}</span>
                                    <span class="price-original">৳{{ number_format($course->price) }}</span>
                                @elseif($course->price)
                                    <span class="price-current">৳{{ number_format($course->price) }}</span>
                                @else
                                    <span class="price-free">বিনামূল্যে</span>
                                @endif
                            </div>
                            
                            <div class="course-instructor">
                                <strong>{{ $course->user->name ?? 'প্রশিক্ষক' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $courses->links() }}
            </div>
        @else
            <div class="no-courses">
                <div class="no-courses-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="no-courses-title">কোন কোর্স পাওয়া যায়নি</h3>
                <p class="no-courses-text">
                    @if($search || $category || $level)
                        আপনার ফিল্টার অনুযায়ী কোন কোর্স খুঁজে পাওয়া যায়নি। অন্য কিছু চেষ্টা করুন।
                    @else
                        এখনো কোন কোর্স যোগ করা হয়নি।
                    @endif
                </p>
                <a href="{{ route('courses') }}" class="filter-btn" style="margin-top: 20px;">
                    সব কোর্স দেখুন
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on select change
    const selects = document.querySelectorAll('.filter-select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Animate course cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all course cards
    document.querySelectorAll('.course-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection