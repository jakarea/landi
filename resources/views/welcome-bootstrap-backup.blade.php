@extends('layouts.guest')
@section('title', 'শিখুন - আধুনিক অনলাইন শিক্ষা প্ল্যাটফর্ম')
@php
    use Illuminate\Support\Str;
@endphp

@section('style')
<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.btn-cta {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    margin: 0 10px;
    transition: all 0.3s ease;
}

.btn-cta:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    text-decoration: none;
}

.features-section {
    padding: 80px 0;
    background: white;
}

.feature-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.feature-description {
    color: #666;
    line-height: 1.6;
}

.stats-section {
    background: #f8f9fa;
    padding: 60px 0;
}

.stat-card {
    text-align: center;
    margin-bottom: 2rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: #667eea;
    display: block;
}

.stat-label {
    color: #666;
    font-size: 1.1rem;
    margin-top: 0.5rem;
}

.courses-section {
    padding: 80px 0;
    background: white;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1rem;
    color: #333;
}

.section-subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 3rem;
    font-size: 1.1rem;
}

.course-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
    transition: transform 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
}

.course-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #ff6b6b;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.course-content {
    padding: 1.5rem;
}

.course-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.course-title a {
    color: inherit;
    text-decoration: none;
}

.course-title a:hover {
    color: #667eea;
}

.course-description {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.course-meta {
    margin-bottom: 1rem;
}

.course-category {
    background: #e3f2fd;
    color: #1976d2;
    padding: 3px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.course-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
}

.course-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #667eea;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    font-size: 1rem;
    margin-left: 0.5rem;
}

.course-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-stars {
    color: #ffc107;
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-subtitle {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .cta-title {
        font-size: 2rem;
    }
    
    .feature-card,
    .course-card {
        margin-bottom: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="hero-title">শিখুন নতুন দক্ষতা, গড়ুন উজ্জ্বল ভবিষ্যৎ</h1>
                <p class="hero-subtitle">
                    দেশের সেরা প্রশিক্ষকদের কাছ থেকে শিখুন প্রোগ্রামিং, ডিজাইন, মার্কেটিং এবং আরও অনেক কিছু
                </p>
                <div>
                    @guest
                        <a href="{{ route('register') }}" class="btn-cta">
                            <i class="fas fa-user-plus"></i> নিবন্ধন করুন
                        </a>
                        <a href="{{ route('login') }}" class="btn-cta">
                            <i class="fas fa-sign-in-alt"></i> লগইন করুন
                        </a>
                    @else
                        @if(auth()->user()->user_role === 'student')
                            <a href="{{ url('/student/dashboard') }}" class="btn-cta">
                                <i class="fas fa-book-open"></i> আমার কোর্স
                            </a>
                        @else
                            <a href="{{ url('/instructor/dashboard') }}" class="btn-cta">
                                <i class="fas fa-tachometer-alt"></i> ড্যাশবোর্ড
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title">কেন আমাদের প্ল্যাটফর্ম বেছে নেবেন?</h2>
                <p class="section-subtitle">আমাদের রয়েছে আধুনিক শিক্ষা ব্যবস্থা এবং অভিজ্ঞ প্রশিক্ষক দল</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <h3 class="feature-title">ভিডিও লেকচার</h3>
                    <p class="feature-description">
                        HD মানের ভিডিও লেকচার যা আপনি যেকোনো সময় যেকোনো জায়গা থেকে দেখতে পারবেন।
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="feature-title">সার্টিফিকেট</h3>
                    <p class="feature-description">
                        কোর্স সম্পূর্ণ করার পর পাবেন ভেরিফাইড সার্টিফিকেট যা আপনার ক্যারিয়ারে কাজে লাগবে।
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">কমিউনিটি সাপোর্ট</h3>
                    <p class="feature-description">
                        অন্যান্য শিক্ষার্থী ও প্রশিক্ষকদের সাথে যোগাযোগ করে জ্ঞান বিনিময় করুন।
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <span class="stat-number">১০০+</span>
                    <p class="stat-label">কোর্স</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <span class="stat-number">৫০০+</span>
                    <p class="stat-label">শিক্ষার্থী</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <span class="stat-number">২৫+</span>
                    <p class="stat-label">প্রশিক্ষক</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <span class="stat-number">৯৮%</span>
                    <p class="stat-label">সন্তুষ্টি</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Courses Section -->
@if(isset($latestCourses) && $latestCourses->count() > 0)
<section class="courses-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title">সর্বশেষ কোর্সগুলি</h2>
                <p class="section-subtitle">আমাদের নতুন এবং জনপ্রিয় কোর্সগুলি দেখুন</p>
            </div>
        </div>
        
        <div class="row">
            @foreach($latestCourses as $course)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="course-card">
                    <div class="course-image">
                        <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                             alt="{{ $course->title }}" 
                             class="img-fluid">
                        @if($course->offer_price)
                            <span class="course-badge">অফার</span>
                        @endif
                    </div>
                    
                    <div class="course-content">
                        <div class="course-meta">
                            <span class="course-category">{{ explode(',', $course->categories)[0] ?? 'সাধারণ' }}</span>
                        </div>
                        
                        <h3 class="course-title">
                            <a href="{{ route('courses.overview', $course->slug) }}">
                                {{ Str::limit($course->title, 60) }}
                            </a>
                        </h3>
                        
                        <p class="course-description">
                            {{ Str::limit(strip_tags($course->description), 100) }}
                        </p>
                        
                        <div class="course-stats">
                            <div>
                                @if($course->offer_price)
                                    <span class="course-price">৳{{ number_format($course->offer_price) }}</span>
                                    <span class="original-price">৳{{ number_format($course->price) }}</span>
                                @else
                                    <span class="course-price">৳{{ number_format($course->price) }}</span>
                                @endif
                            </div>
                            
                            <div class="course-rating">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= 4 ? '#ffc107' : '#e0e0e0' }}"></i>
                                    @endfor
                                </div>
                                <span>(4.0)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('courses') }}" class="btn-cta" style="background: #667eea; border-color: #667eea;">
                    সব কোর্স দেখুন
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">আজই শুরু করুন আপনার শিক্ষা যাত্রা</h2>
        <p class="cta-subtitle">
            হাজারো শিক্ষার্থীর সাথে যুক্ত হয়ে নিজেকে দক্ষ করে তুলুন। আমাদের প্ল্যাটফর্মে রয়েছে সব ধরনের কোর্স।
        </p>
        <div>
            @guest
                <a href="{{ route('register') }}" class="btn-cta">
                    <i class="fas fa-user-plus"></i> নতুন একাউন্ট তৈরি করুন
                </a>
                <a href="{{ route('login') }}" class="btn-cta">
                    <i class="fas fa-sign-in-alt"></i> লগইন করুন
                </a>
            @else
                @if(auth()->user()->user_role === 'student')
                    <a href="{{ url('/student/dashboard') }}" class="btn-cta">
                        <i class="fas fa-book-open"></i> আমার কোর্স দেখুন
                    </a>
                @else
                    <a href="{{ url('/instructor/dashboard') }}" class="btn-cta">
                        <i class="fas fa-tachometer-alt"></i> ড্যাশবোর্ড
                    </a>
                @endif
            @endguest
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple animations on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.feature-card, .course-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
});
</script>
@endsection