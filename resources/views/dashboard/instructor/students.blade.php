@extends('layouts.latest.instructor')
@section('title', 'My Students')

@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<style>
.students-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stats-card h3 {
    color: white;
    margin-bottom: 0.5rem;
    font-size: 2rem;
    font-weight: 700;
}

.stats-card p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-size: 1.1rem;
}

.students-table {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
}

.search-box {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 0.8rem 1rem;
    color: white;
    width: 300px;
}

.search-box::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-box:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.btn-search {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 0.8rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-search:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.student-row {
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.student-row:hover {
    background: #f8f9ff;
}

.student-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #667eea;
}

.student-name {
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.student-email {
    color: #666;
    font-size: 0.9rem;
}

.payment-method {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.method-bkash {
    background: #e91e63;
    color: white;
}

.method-nogod {
    background: #ff9800;
    color: white;
}

.method-rocket {
    background: #9c27b0;
    color: white;
}

.method-other {
    background: #607d8b;
    color: white;
}

.amount-badge {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
}

.courses-count {
    background: #f0f7ff;
    color: #667eea;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 600;
}

.source-badge {
    padding: 0.2rem 0.6rem;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
}

.source-checkout {
    background: #e8f5e8;
    color: #4caf50;
}

.source-manual {
    background: #fff3e0;
    color: #ff9800;
}

.source-both {
    background: #e3f2fd;
    color: #2196f3;
}

.pagination-wrapper {
    padding: 2rem;
    display: flex;
    justify-content: center;
}
</style>
@endsection

@section('content')
<main class="dashboard-page-wrap">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="students-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-3">আমার শিক্ষার্থীরা</h1>
                    <p class="mb-0">আপনার সব কোর্সের নথিভুক্ত শিক্ষার্থীদের তালিকা</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-card">
                                <h3>{{ $totalStudents }}</h3>
                                <p>মোট শিক্ষার্থী</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <h3>৳{{ number_format($totalEarnings) }}</h3>
                                <p>মোট আয়</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="students-table">
            <div class="table-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">শিক্ষার্থীদের তালিকা</h4>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" class="d-flex justify-content-end">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="নাম বা ইমেইল দিয়ে খুঁজুন..." 
                                   class="search-box me-2">
                            <button type="submit" class="btn btn-search">
                                <i class="fas fa-search"></i> খুঁজুন
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="padding: 1rem;">শিক্ষার্থী</th>
                                <th style="padding: 1rem;">কোর্স</th>
                                <th style="padding: 1rem;">পেমেন্ট</th>
                                <th style="padding: 1rem;">পরিমাণ</th>
                                <th style="padding: 1rem;">নথিভুক্তির তারিখ</th>
                                <th style="padding: 1rem;">উৎস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="student-row">
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center">
                                        @if($student->user->avatar)
                                            <img src="{{ asset($student->user->avatar) }}" 
                                                 alt="{{ $student->user->name }}" 
                                                 class="student-avatar me-3">
                                        @else
                                            <div class="student-avatar me-3 d-flex align-items-center justify-content-center"
                                                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700; font-size: 1.2rem;">
                                                {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="student-name">{{ $student->user->name }}</div>
                                            <div class="student-email">{{ $student->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($student->course)
                                        <strong>{{ \Illuminate\Support\Str::limit($student->course->title, 30) }}</strong>
                                    @else
                                        <span class="text-muted">কোর্স পাওয়া যায়নি</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    @php
                                        $methodClass = match($student->payment_method) {
                                            'bkash' => 'method-bkash',
                                            'nogod' => 'method-nogod', 
                                            'rocket' => 'method-rocket',
                                            default => 'method-other'
                                        };
                                        $methodName = match($student->payment_method) {
                                            'bkash' => 'বিকাশ',
                                            'nogod' => 'নগদ',
                                            'rocket' => 'রকেট', 
                                            default => $student->payment_method
                                        };
                                    @endphp
                                    <span class="payment-method {{ $methodClass }}">{{ $methodName }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="amount-badge">৳{{ number_format($student->amount) }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    <div>{{ $student->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $student->created_at->format('h:i A') }}</small>
                                </td>
                                <td style="padding: 1rem;">
                                    @php
                                        $sourceClass = match($student->source) {
                                            'checkout' => 'source-checkout',
                                            'manual' => 'source-manual',
                                            'both' => 'source-both',
                                            default => 'source-checkout'
                                        };
                                        $sourceName = match($student->source) {
                                            'checkout' => 'স্বয়ংক্রিয়',
                                            'manual' => 'ম্যানুয়াল',
                                            'both' => 'উভয়',
                                            default => 'স্বয়ংক্রিয়'
                                        };
                                    @endphp
                                    <span class="source-badge {{ $sourceClass }}">{{ $sourceName }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-muted">কোন শিক্ষার্থী পাওয়া যায়নি</h3>
                    <p class="text-muted">
                        @if(request('search'))
                            "{{ request('search') }}" এর জন্য কোন শিক্ষার্থী খুঁজে পাওয়া যায়নি।
                        @else
                            এখনো কোন শিক্ষার্থী আপনার কোর্সে নথিভুক্ত হননি।
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('instructor.students') }}" class="btn btn-primary">সব শিক্ষার্থী দেখুন</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search form on Enter key
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }

    // Animate table rows on scroll
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

    // Observe all student rows
    document.querySelectorAll('.student-row').forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(row);
    });
});
</script>
@endsection