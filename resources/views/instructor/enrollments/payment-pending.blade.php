@extends('layouts.latest.instructor')

@section('title', 'Payment Pending Enrollments')

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

.btn-modern {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
}

.btn-approve {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
}

.btn-approve:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
}

.btn-reject {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
}

.btn-reject:hover {
    background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(245, 101, 101, 0.4);
}

.btn-screenshot {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
}

.btn-screenshot:hover {
    background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(66, 153, 225, 0.4);
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

@media (max-width: 768px) {
    .page-header {
        margin-left: -15px;
        margin-right: -15px;
        border-radius: 0;
    }
    
    .table-responsive {
        border-radius: 10px;
    }
    
    .btn-modern {
        padding: 0.4rem 1rem;
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
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
                    <h2 class="mb-1"><i class="fas fa-credit-card me-2"></i> পেমেন্ট অপেক্ষমাণ নথিভুক্তি</h2>
                    <p class="mb-0 opacity-90">যে শিক্ষার্থীরা এখনও পেমেন্ট করেননি তাদের তালিকা দেখুন</p>
                </div>
                <div>
                    <a href="{{ route('instructor.enrollments.all') }}" class="header-btn">
                        <i class="fas fa-list me-2"></i> সকল নথিভুক্তি
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
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
                                        <th>আবেদনের তারিখ</th>
                                        <th>স্ক্রিনশট</th>
                                        <th>পদক্ষেপ</th>
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
                                                <div class="fw-semibold text-dark">{{ $enrollment->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $enrollment->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                @if($enrollment->payment_screenshot)
                                                    <button class="btn btn-modern btn-screenshot btn-sm" onclick="viewScreenshot('{{ asset('storage/'.$enrollment->payment_screenshot) }}')">
                                                        <i class="fas fa-image"></i> দেখুন
                                                    </button>
                                                @else
                                                    <span class="text-muted">কোনো স্ক্রিনশট নেই</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-modern btn-approve btn-sm" onclick="showApproveModal({{ $enrollment->id }})">
                                                        <i class="fas fa-check"></i> অনুমোদন
                                                    </button>
                                                    <button class="btn btn-modern btn-reject btn-sm" onclick="showRejectModal({{ $enrollment->id }})">
                                                        <i class="fas fa-times"></i> প্রত্যাখ্যান
                                                    </button>
                                                </div>
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
                    <i class="fas fa-clipboard-list fa-4x empty-icon"></i>
                    <h4 class="text-dark mb-2">কোনো অপেক্ষমাণ নথিভুক্তি নেই</h4>
                    <p class="text-muted mb-0">সকল নথিভুক্তির আবেদন প্রক্রিয়া সম্পন্ন হয়েছে।</p>
                </div>
            @endif
        </div>
    </div>
    </div>
</div>

<!-- Screenshot Modal -->
<div class="modal fade" id="screenshotModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="fas fa-image me-2"></i> পেমেন্ট স্ক্রিনশট</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="screenshotImage" src="" alt="Payment Screenshot" class="img-fluid" style="border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            </div>
        </div>
    </div>
</div>

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
                    <p class="text-dark">আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? শিক্ষার্থী কোর্সে প্রবেশাধিকার পাবে।</p>
                    <div class="form-group mt-3">
                        <label for="admin_notes" class="form-label fw-semibold">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                                  style="border-radius: 10px; border: 2px solid #e2e8f0;" 
                                  placeholder="এই অনুমোদনের জন্য কোনো নোট যোগ করুন..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #f7fafc; color: #4a5568; border-radius: 25px; padding: 0.5rem 1.5rem;">বাতিল</button>
                    <button type="submit" class="btn btn-modern btn-approve">
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
                        <label for="rejection_reason" class="form-label fw-semibold">প্রত্যাখ্যানের কারণ <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" 
                                  style="border-radius: 10px; border: 2px solid #e2e8f0;"
                                  placeholder="প্রত্যাখ্যানের স্পষ্ট কারণ উল্লেখ করুন..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #f7fafc; color: #4a5568; border-radius: 25px; padding: 0.5rem 1.5rem;">বাতিল</button>
                    <button type="submit" class="btn btn-modern btn-reject">
                        <i class="fas fa-times me-2"></i> প্রত্যাখ্যান করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function viewScreenshot(url) {
    document.getElementById('screenshotImage').src = url;
    new bootstrap.Modal(document.getElementById('screenshotModal')).show();
}

function showApproveModal(enrollmentId) {
    document.getElementById('approveForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/approve`;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function showRejectModal(enrollmentId) {
    document.getElementById('rejectForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection