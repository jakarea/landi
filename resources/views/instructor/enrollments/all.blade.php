@extends('layouts.latest.instructor')

@section('title', 'All Enrollments')
@php
    use Illuminate\Support\Str;
@endphp
@section('style')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.filter-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.enrollment-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.enrollment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e7ff 100%);
    border: none;
    color: #4a5568;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.table-modern th:first-child {
    border-radius: 10px 0 0 0;
}

.table-modern th:last-child {
    border-radius: 0 10px 0 0;
}

.table-modern td {
    border: none;
    padding: 1rem 0.75rem;
    vertical-align: middle;
    background: white;
    border-bottom: 1px solid #f1f3f4;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:last-child td:first-child {
    border-radius: 0 0 0 10px;
}

.table-modern tbody tr:last-child td:last-child {
    border-radius: 0 0 10px 0;
}

.student-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 3px solid #e2e8f0;
    transition: all 0.3s ease;
}

.student-avatar:hover {
    border-color: #667eea;
    transform: scale(1.05);
}

.avatar-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
    border: 3px solid #e2e8f0;
    transition: all 0.3s ease;
}

.avatar-placeholder:hover {
    border-color: #667eea;
    transform: scale(1.05);
}

.amount-badge {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.status-pending {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 500;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-approved {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 500;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-rejected {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 500;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payment-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 500;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payment-bkash {
    background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
    color: white;
}

.payment-nogod {
    background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
    color: white;
}

.payment-rocket {
    background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
    color: white;
}

.payment-cash {
    background: linear-gradient(135deg, #607d8b 0%, #455a64 100%);
    color: white;
}

.transaction-code {
    background: #f7fafc;
    color: #2d3748;
    padding: 0.3rem 0.6rem;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    border: 1px solid #e2e8f0;
}

.header-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.header-btn:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.filter-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.filter-input {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.filter-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-select {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    background: white;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.empty-state {
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e7ff 100%);
    border-radius: 15px;
    padding: 3rem;
    text-align: center;
}

.empty-icon {
    color: #a0aec0;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .page-header {
        margin-left: -15px;
        margin-right: -15px;
        border-radius: 0;
    }
    
    .table-responsive {
        border-radius: 10px;
    }
    
    .filter-card .row > div {
        margin-bottom: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-list me-2"></i> সকল নথিভুক্তি</h2>
                    <p class="mb-0 opacity-90">আপনার কোর্সের সকল নথিভুক্তি এবং তাদের অবস্থা দেখুন</p>
                </div>
                <div>
                    <a href="{{ route('instructor.enrollments.pending') }}" class="header-btn">
                        <i class="fas fa-clock me-2"></i> অপেক্ষমাণ নথিভুক্তি
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Filters -->
        <div class="filter-card">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('instructor.enrollments.all') }}">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label fw-semibold">অনুসন্ধান</label>
                            <input type="text" class="form-control filter-input" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="শিক্ষার্থী বা কোর্সের নাম">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="status" class="form-label fw-semibold">অবস্থা</label>
                            <select class="form-select filter-select" id="status" name="status">
                                <option value="">সব</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>অপেক্ষমাণ</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>অনুমোদিত</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>প্রত্যাখ্যাত</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="payment_method" class="form-label fw-semibold">পেমেন্ট</label>
                            <select class="form-select filter-select" id="payment_method" name="payment_method">
                                <option value="">সব</option>
                                <option value="bkash" {{ request('payment_method') == 'bkash' ? 'selected' : '' }}>বিকাশ</option>
                                <option value="nogod" {{ request('payment_method') == 'nogod' ? 'selected' : '' }}>নগদ</option>
                                <option value="rocket" {{ request('payment_method') == 'rocket' ? 'selected' : '' }}>রকেট</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>ক্যাশ</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="course" class="form-label fw-semibold">কোর্স</label>
                            <select class="form-select filter-select" id="course" name="course">
                                <option value="">সব কোর্স</option>
                                @foreach(auth()->user()->courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                        {{ Str::limit($course->title, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="filter-btn">
                                    <i class="fas fa-search me-1"></i> ফিল্টার
                                </button>
                                <a href="{{ route('instructor.enrollments.all') }}" class="btn btn-outline-secondary" style="border-radius: 25px;">
                                    <i class="fas fa-refresh me-1"></i> রিসেট
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($enrollments->count() > 0)
                    <div class="enrollment-card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th>শিক্ষার্থী</th>
                                            <th>কোর্স</th>
                                            <th>পরিমাণ</th>
                                            <th>পেমেন্ট মেথড</th>
                                            <th>ট্রানজেকশন আইডি</th>
                                            <th>অবস্থা</th>
                                            <th>আবেদনের তারিখ</th>
                                            <th>কার্যক্রম</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enrollments as $enrollment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($enrollment->student->avatar)
                                                            <img src="{{ asset($enrollment->student->avatar) }}" alt="{{ $enrollment->student->name }}" 
                                                                 class="student-avatar me-3">
                                                        @else
                                                            <div class="avatar-placeholder me-3">
                                                                {{ strtoupper(substr($enrollment->student->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold text-dark">{{ $enrollment->student->name }}</div>
                                                            <small class="text-muted">{{ $enrollment->student->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold text-dark">{{ $enrollment->course->title }}</div>
                                                        <small class="text-muted">{{ $enrollment->course->categories }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="amount-badge">৳{{ number_format($enrollment->amount) }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $methodClasses = [
                                                            'bkash' => 'payment-bkash',
                                                            'nogod' => 'payment-nogod',
                                                            'rocket' => 'payment-rocket',
                                                            'cash' => 'payment-cash'
                                                        ];
                                                    @endphp
                                                    <span class="payment-badge {{ $methodClasses[$enrollment->payment_method] ?? 'payment-cash' }}">
                                                        {{ \App\Models\CourseEnrollment::PAYMENT_METHODS[$enrollment->payment_method] ?? ucfirst($enrollment->payment_method) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($enrollment->transaction_id)
                                                        <span class="transaction-code">{{ $enrollment->transaction_id }}</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($enrollment->status == 'pending')
                                                        <span class="status-pending">অপেক্ষমাণ</span>
                                                    @elseif($enrollment->status == 'approved')
                                                        <span class="status-approved">অনুমোদিত</span>
                                                    @elseif($enrollment->status == 'rejected')
                                                        <span class="status-rejected">প্রত্যাখ্যাত</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-dark">{{ $enrollment->created_at->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $enrollment->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    @if($enrollment->status == 'rejected')
                                                        <button class="btn btn-sm btn-success me-1" onclick="showReapproveModal({{ $enrollment->id }})" title="পুনরায় অনুমোদন">
                                                            <i class="fas fa-redo"></i> পুনরায় অনুমোদন
                                                        </button>
                                                    @elseif($enrollment->status == 'pending')
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-sm btn-success" onclick="showApproveModal({{ $enrollment->id }}, 'with_payment')" title="পেমেন্ট সহ অনুমোদন">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-info" onclick="showApproveModal({{ $enrollment->id }}, 'without_payment')" title="ফ্রি অ্যাক্সেস">
                                                                <i class="fas fa-gift"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $enrollment->id }})" title="প্রত্যাখ্যান">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">কোনো কার্যক্রম নেই</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 py-3">
                            {{ $enrollments->links() }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-users fa-4x empty-icon"></i>
                        <h4 class="text-dark mb-2">কোনো নথিভুক্তি পাওয়া যায়নি</h4>
                        <p class="text-muted mb-0">এখনো কোনো শিক্ষার্থী আপনার কোর্সে নথিভুক্ত হয়নি।</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Re-approve Modal -->
<div class="modal fade" id="reapproveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <form id="reapproveForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-redo me-2"></i> পুনরায় অনুমোদন</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark">এই প্রত্যাখ্যাত এনরোলমেন্ট পুনরায় অনুমোদন করতে চান?</p>
                    
                    <div class="form-group mt-3">
                        <label class="form-label fw-semibold">অনুমোদনের ধরন</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="approve_type" id="withPayment" value="with_payment" checked>
                            <label class="form-check-label" for="withPayment">
                                <i class="fas fa-check-circle text-success me-1"></i> পেমেন্ট সহ অনুমোদন
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="approve_type" id="withoutPayment" value="without_payment">
                            <label class="form-check-label" for="withoutPayment">
                                <i class="fas fa-gift text-info me-1"></i> ফ্রি অ্যাক্সেস প্রদান
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="reapprove_admin_notes" class="form-label fw-semibold">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="reapprove_admin_notes" class="form-control" rows="3" 
                                  style="border-radius: 10px; border: 2px solid #e2e8f0;" 
                                  placeholder="পুনরায় অনুমোদনের জন্য কোনো নোট যোগ করুন..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #f7fafc; color: #4a5568; border-radius: 25px; padding: 0.5rem 1.5rem;">বাতিল</button>
                    <button type="submit" class="btn btn-success" style="border-radius: 25px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-redo me-2"></i> পুনরায় অনুমোদন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Copy modals from pending.blade.php if they don't exist -->
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <form id="approveForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-check me-2"></i> নথিভুক্তি অনুমোদন</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark" id="approveMessage">আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? শিক্ষার্থী কোর্সে প্রবেশাধিকার পাবে।</p>
                    
                    <div class="alert alert-info" id="freeAccessInfo" style="display: none;">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>ফ্রি অ্যাক্সেস:</strong> এই শিক্ষার্থীকে বিনামূল্যে কোর্স অ্যাক্সেস দেওয়া হবে। কোনো পেমেন্ট যাচাই করা হবে না।
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="admin_notes" class="form-label fw-semibold">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                                  style="border-radius: 10px; border: 2px solid #e2e8f0;" 
                                  placeholder="এই অনুমোদনের জন্য কোনো নোট যোগ করুন..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #f7fafc; color: #4a5568; border-radius: 25px; padding: 0.5rem 1.5rem;">বাতিল</button>
                    <button type="submit" class="btn btn-success" style="border-radius: 25px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-check me-2"></i> অনুমোদন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title"><i class="fas fa-times me-2"></i> নথিভুক্তি প্রত্যাখ্যান</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark">এই নথিভুক্তি প্রত্যাখ্যানের কারণ উল্লেখ করুন:</p>
                    <div class="form-group mt-3">
                        <label for="rejection_reason" class="form-label fw-semibold">প্রত্যাখ্যানের কারণ</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" 
                                  style="border-radius: 10px; border: 2px solid #f56565;" 
                                  placeholder="প্রত্যাখ্যানের বিস্তারিত কারণ লিখুন..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #f7fafc; color: #4a5568; border-radius: 25px; padding: 0.5rem 1.5rem;">বাতিল</button>
                    <button type="submit" class="btn btn-danger" style="border-radius: 25px; padding: 0.5rem 1.5rem;">
                        <i class="fas fa-times me-2"></i> প্রত্যাখ্যান করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showReapproveModal(enrollmentId) {
    document.getElementById('reapproveForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reapprove`;
    new bootstrap.Modal(document.getElementById('reapproveModal')).show();
}

function showApproveModal(enrollmentId, approveType = 'with_payment') {
    const form = document.getElementById('approveForm');
    const freeAccessInfo = document.getElementById('freeAccessInfo');
    const approveMessage = document.getElementById('approveMessage');
    
    if (approveType === 'without_payment') {
        form.action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/approve-without-payment`;
        freeAccessInfo.style.display = 'block';
        approveMessage.textContent = 'এই শিক্ষার্থীকে ফ্রি অ্যাক্সেস দিতে চান? কোনো পেমেন্ট যাচাই করা হবে না।';
    } else {
        form.action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/approve`;
        freeAccessInfo.style.display = 'none';
        approveMessage.textContent = 'আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? পেমেন্ট যাচাই করা হবে।';
    }
    
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function showRejectModal(enrollmentId) {
    document.getElementById('rejectForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

@endsection