@extends('layouts/latest/students')
@section('title')
অর্জনসমূহ
@endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/ins-dashboard.css') }}" rel="stylesheet" type="text/css" />
<style>
.achievement-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
}

.achievement-card.locked {
    background: linear-gradient(135deg, #a8a8a8 0%, #777777 100%);
    opacity: 0.6;
}

.achievement-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
}

.achievement-title {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: white;
}

.achievement-description {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 15px;
}

.achievement-progress {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    height: 8px;
    overflow: hidden;
    margin-bottom: 10px;
}

.achievement-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #00f260, #0575e6);
    border-radius: 10px;
    transition: width 0.3s ease;
}

.achievement-date {
    font-size: 0.85rem;
    opacity: 0.8;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 10px;
}

.stat-label {
    color: #666;
    font-weight: 500;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 25px;
    color: #333;
    position: relative;
    padding-left: 15px;
}

.section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
}

.achievement-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
</style>
@endsection
{{-- page style @E --}}

{{-- page content @S --}}
@section('content')
<main class="student-dashboard-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="yearly-analitics">
                    <h1>আমার অর্জনসমূহ</h1>
                    <p class="text-muted">আপনার শেখার যাত্রায় অর্জিত সকল ব্যাজ এবং সার্টিফিকেট দেখুন</p>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalAchievements }}</div>
                <div class="stat-label">মোট অর্জন</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $completedCourses }}</div>
                <div class="stat-label">সম্পন্ন কোর্স</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalWatchHours }}</div>
                <div class="stat-label">মোট শিক্ষার ঘন্টা</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $currentStreak }}</div>
                <div class="stat-label">দিনের ধারাবাহিকতা</div>
            </div>
        </div>

        <!-- Recent Achievements -->
        @if(count($recentAchievements) > 0)
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">সাম্প্রতিক অর্জনসমূহ</h2>
            </div>
            @foreach($recentAchievements as $achievement)
            <div class="col-lg-6 col-xl-4">
                <div class="achievement-card">
                    <div class="achievement-badge">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="achievement-icon">{{ $achievement['icon'] }}</div>
                    <h3 class="achievement-title">{{ $achievement['title'] }}</h3>
                    <p class="achievement-description">{{ $achievement['description'] }}</p>
                    <div class="achievement-date">
                        অর্জিত: {{ \Carbon\Carbon::parse($achievement['earned_at'])->locale('bn')->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- All Achievements -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">সকল অর্জন</h2>
            </div>
            @foreach($allAchievements as $achievement)
            <div class="col-lg-6 col-xl-4">
                <div class="achievement-card {{ $achievement['earned'] ? '' : 'locked' }}">
                    @if($achievement['earned'])
                    <div class="achievement-badge">
                        <i class="fas fa-trophy"></i>
                    </div>
                    @else
                    <div class="achievement-badge">
                        <i class="fas fa-lock"></i>
                    </div>
                    @endif
                    
                    <div class="achievement-icon">{{ $achievement['icon'] }}</div>
                    <h3 class="achievement-title">{{ $achievement['title'] }}</h3>
                    <p class="achievement-description">{{ $achievement['description'] }}</p>
                    
                    @if($achievement['earned'])
                        <div class="achievement-date">
                            অর্জিত: {{ \Carbon\Carbon::parse($achievement['earned_at'])->locale('bn')->isoFormat('D MMMM YYYY') }}
                        </div>
                    @else
                        <div class="achievement-progress">
                            <div class="achievement-progress-bar" style="width: {{ $achievement['progress'] }}%"></div>
                        </div>
                        <div class="achievement-date">
                            অগ্রগতি: {{ $achievement['progress'] }}% ({{ $achievement['current'] }}/{{ $achievement['target'] }})
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Certificates Section -->
        @if(count($certificates) > 0)
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">সার্টিফিকেটসমূহ</h2>
            </div>
            @foreach($certificates as $certificate)
            <div class="col-lg-4 col-md-6">
                <div class="achievement-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="achievement-badge">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="achievement-icon">📜</div>
                    <h3 class="achievement-title">{{ $certificate['course_title'] }}</h3>
                    <p class="achievement-description">কোর্স সম্পন্ন করার জন্য সার্টিফিকেট</p>
                    <div class="achievement-date">
                        অর্জিত: {{ \Carbon\Carbon::parse($certificate['completed_at'])->locale('bn')->isoFormat('D MMMM YYYY') }}
                    </div>
                    <div class="mt-3">
                        <a href="{{ url('student/courses-certificate') }}" class="btn btn-light btn-sm">
                            সার্টিফিকেট ডাউনলোড
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Progress Towards Next Achievement -->
        @if(count($nextAchievements) > 0)
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">পরবর্তী লক্ষ্য</h2>
                <p class="text-muted mb-4">এই অর্জনগুলো আনলক করার জন্য চালিয়ে যান!</p>
            </div>
            @foreach($nextAchievements as $achievement)
            <div class="col-lg-6 col-xl-4">
                <div class="achievement-card locked">
                    <div class="achievement-badge">
                        <i class="fas fa-target"></i>
                    </div>
                    <div class="achievement-icon">{{ $achievement['icon'] }}</div>
                    <h3 class="achievement-title">{{ $achievement['title'] }}</h3>
                    <p class="achievement-description">{{ $achievement['description'] }}</p>
                    
                    <div class="achievement-progress">
                        <div class="achievement-progress-bar" style="width: {{ $achievement['progress'] }}%"></div>
                    </div>
                    <div class="achievement-date">
                        প্রয়োজন: {{ $achievement['remaining'] }} আরও ({{ $achievement['current'] }}/{{ $achievement['target'] }})
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</main>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to achievement cards
    const cards = document.querySelectorAll('.achievement-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
{{-- page script @E --}}