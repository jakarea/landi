@extends('layouts.latest.instructor')
@section('title', 'My Earnings')

@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<style>
.earnings-header {
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

.earnings-table {
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

.filter-box {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 0.8rem 1rem;
    color: white;
    margin-right: 1rem;
}

.filter-box:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.btn-filter {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 0.8rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.earning-row {
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.earning-row:hover {
    background: #f8f9ff;
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

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #667eea;
}

.student-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.student-email {
    color: #666;
    font-size: 0.8rem;
}

.course-title {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.pagination-wrapper {
    padding: 2rem;
    display: flex;
    justify-content: center;
}

.add-earning-btn {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.add-earning-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
}
</style>
@endsection

@section('content')
<main class="dashboard-page-wrap">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="earnings-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-3">আমার আয়</h1>
                    <p class="mb-0">বিকাশ, নগদ ও রকেট থেকে আসা সকল পেমেন্টের তালিকা</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-card">
                                <h3>৳{{ number_format($monthlyEarnings) }}</h3>
                                <p>এই মাসের আয়</p>
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

        <!-- Earnings Table -->
        <div class="earnings-table">
            <div class="table-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-0">পেমেন্ট তালিকা</h4>
                    </div>
                    <div class="col-md-4">
                        <form method="GET" class="d-flex justify-content-end flex-wrap">
                            <select name="method" class="filter-box me-2">
                                <option value="">সকল মাধ্যম</option>
                                <option value="bkash" {{ request('method') == 'bkash' ? 'selected' : '' }}>বিকাশ</option>
                                <option value="nogod" {{ request('method') == 'nogod' ? 'selected' : '' }}>নগদ</option>
                                <option value="rocket" {{ request('method') == 'rocket' ? 'selected' : '' }}>রকেট</option>
                            </select>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-box me-2" placeholder="From Date">
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-box me-2" placeholder="To Date">
                            <button type="submit" class="btn btn-filter">
                                <i class="fas fa-search"></i> খুঁজুন
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($earnings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="padding: 1rem;">শিক্ষার্থী</th>
                                <th style="padding: 1rem;">কোর্স</th>
                                <th style="padding: 1rem;">পেমেন্ট মাধ্যম</th>
                                <th style="padding: 1rem;">পরিমাণ</th>
                                <th style="padding: 1rem;">তারিখ</th>
                                <th style="padding: 1rem;">ট্রানজেকশন আইডি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earnings as $earning)
                            <tr class="earning-row">
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center">
                                        @php
                                            // Handle both Checkout and CourseEnrollment models
                                            $user = $earning->user ?? $earning->student;
                                        @endphp
                                        @if($user && $user->avatar)
                                            <img src="{{ asset($user->avatar) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="student-avatar me-3">
                                        @else
                                            <div class="student-avatar me-3 d-flex align-items-center justify-content-center"
                                                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700; font-size: 1rem;">
                                                {{ $user ? strtoupper(substr($user->name, 0, 1)) : 'N' }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="student-name">{{ $user ? $user->name : 'N/A' }}</div>
                                            <div class="student-email">{{ $user ? $user->email : 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($earning->course)
                                        <div class="course-title">{{ \Illuminate\Support\Str::limit($earning->course->title, 30) }}</div>
                                    @else
                                        <span class="text-muted">কোর্স পাওয়া যায়নি</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    @php
                                        $methodClass = match($earning->payment_method) {
                                            'bkash' => 'method-bkash',
                                            'nogod' => 'method-nogod', 
                                            'rocket' => 'method-rocket',
                                            default => 'method-other'
                                        };
                                        $methodName = match($earning->payment_method) {
                                            'bkash' => 'বিকাশ',
                                            'nogod' => 'নগদ',
                                            'rocket' => 'রকেট', 
                                            default => $earning->payment_method
                                        };
                                    @endphp
                                    <span class="payment-method {{ $methodClass }}">{{ $methodName }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    <span class="amount-badge">৳{{ number_format($earning->amount) }}</span>
                                </td>
                                <td style="padding: 1rem;">
                                    <div>{{ $earning->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $earning->created_at->format('h:i A') }}</small>
                                </td>
                                <td style="padding: 1rem;">
                                    <code class="text-muted">{{ $earning->transaction_id ?? 'N/A' }}</code>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $earnings->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-muted">কোন আয় পাওয়া যায়নি</h3>
                    <p class="text-muted">
                        @if(request()->hasAny(['method', 'date_from', 'date_to']))
                            নির্দিষ্ট ফিল্টারে কোন আয়ের তথ্য খুঁজে পাওয়া যায়নি।
                        @else
                            এখনো কোন শিক্ষার্থী আপনার কোর্সের জন্য পেমেন্ট করেননি।
                        @endif
                    </p>
                    @if(request()->hasAny(['method', 'date_from', 'date_to']))
                        <a href="{{ route('instructor.earnings') }}" class="btn btn-primary">সব আয় দেখুন</a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Manual Payment Addition -->
        <div class="mt-4">
            <button type="button" class="add-earning-btn" data-bs-toggle="modal" data-bs-target="#addEarningModal">
                <i class="fas fa-plus me-2"></i> ম্যানুয়াল পেমেন্ট যুক্ত করুন
            </button>
        </div>
    </div>
</main>

<!-- Add Earning Modal -->
<div class="modal fade" id="addEarningModal" tabindex="-1" aria-labelledby="addEarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEarningModalLabel">ম্যানুয়াল পেমেন্ট যুক্ত করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('instructor.earnings.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_search" class="form-label">শিক্ষার্থী নির্বাচন করুন</label>
                                <input type="text" class="form-control typeahead-input" id="user_search" placeholder="শিক্ষার্থীর নাম বা ইমেইল লিখুন..." autocomplete="off">
                                <input type="hidden" name="user_id" id="selected_user_id" required>
                                <small class="text-muted">টাইপ করুন এবং তালিকা থেকে শিক্ষার্থী নির্বাচন করুন</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">কোর্স নির্বাচন করুন</label>
                                <select class="form-control" name="course_id" required>
                                    <option value="">কোর্স নির্বাচন করুন</option>
                                    @if(isset($instructorCourses))
                                        @foreach($instructorCourses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">পেমেন্ট মাধ্যম</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="">পেমেন্ট মাধ্যম নির্বাচন করুন</option>
                                    <option value="bkash">বিকাশ</option>
                                    <option value="nogod">নগদ</option>
                                    <option value="rocket">রকেট</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">পরিমাণ (৳)</label>
                                <input type="number" class="form-control" name="amount" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">ট্রানজেকশন আইডি (ঐচ্ছিক)</label>
                                <input type="text" class="form-control" name="transaction_id" placeholder="TXN123456789">
                                <small class="text-muted">বিকাশ/নগদ/রকেট থেকে পাওয়া ট্রানজেকশন আইডি (যদি থাকে)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sender_number" class="form-label">প্রেরকের নম্বর (ঐচ্ছিক)</label>
                                <input type="text" class="form-control" name="sender_number" placeholder="০১xxxxxxxxx">
                                <small class="text-muted">যে নম্বর থেকে পেমেন্ট এসেছে</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">পেমেন্টের তারিখ (ঐচ্ছিক)</label>
                                <input type="date" class="form-control" name="payment_date" max="{{ date('Y-m-d') }}">
                                <small class="text-muted">যদি আজকের তারিখ না হয়</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="notes" class="form-label">মন্তব্য (ঐচ্ছিক)</label>
                                <input type="text" class="form-control" name="notes" placeholder="অতিরিক্ত কোনো তথ্য">
                                <small class="text-muted">পেমেন্ট সম্পর্কে অতিরিক্ত তথ্য</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- jQuery (required for Typeahead) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Twitter Typeahead -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<style>
.twitter-typeahead {
    width: 100%;
}

.tt-menu {
    width: 100%;
    min-width: 100%;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
}

.tt-suggestion {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
}

.tt-suggestion:last-child {
    border-bottom: none;
}

.tt-suggestion:hover,
.tt-suggestion.tt-cursor {
    background-color: #f8f9fa;
}

.student-suggestion {
    display: flex;
    align-items: center;
    width: 100%;
}

.student-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 12px;
}

.student-info h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.student-info small {
    color: #666;
    font-size: 12px;
}

.typeahead-input {
    background-color: #fff !important;
}

.tt-input {
    background-color: #fff !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize student typeahead
    @if(isset($students))
    var students = [
        @foreach($students as $student)
        {
            id: {{ $student->id }},
            name: "{{ $student->name }}",
            email: "{{ $student->email }}",
            avatar: "{{ $student->avatar ? asset($student->avatar) : '' }}",
            initials: "{{ strtoupper(substr($student->name, 0, 1)) }}"
        },
        @endforeach
    ];

    // Configure Bloodhound engine
    var studentsBloodhound = new Bloodhound({
        datumTokenizer: function(datum) {
            return Bloodhound.tokenizers.whitespace(datum.name + ' ' + datum.email);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: students,
        limit: 10
    });

    // Initialize typeahead
    $('#user_search').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'students',
        source: studentsBloodhound,
        display: function(student) {
            return student.name + ' (' + student.email + ')';
        },
        templates: {
            suggestion: function(student) {
                var avatarHtml = student.avatar 
                    ? '<img src="' + student.avatar + '" class="student-avatar" alt="' + student.name + '">'
                    : '<div class="student-avatar">' + student.initials + '</div>';
                
                return '<div class="student-suggestion">' +
                    avatarHtml +
                    '<div class="student-info">' +
                        '<h6>' + student.name + '</h6>' +
                        '<small>' + student.email + '</small>' +
                    '</div>' +
                '</div>';
            }
        }
    }).on('typeahead:select', function(event, student) {
        $('#selected_user_id').val(student.id);
    }).on('typeahead:change', function(event) {
        // Clear hidden input if text is manually changed
        if (!$(this).val()) {
            $('#selected_user_id').val('');
        }
    });
    @endif

    // Auto-submit filter form on change
    const methodSelect = document.querySelector('select[name="method"]');
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    if (methodSelect) {
        methodSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
    
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

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

    // Observe all earning rows
    document.querySelectorAll('.earning-row').forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(row);
    });
});
</script>
@endsection