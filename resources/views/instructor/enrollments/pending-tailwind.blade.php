@extends('layouts.instructor-tailwind')
@section('title', 'অপেক্ষমাণ নথিভুক্তি')
@section('header-title', 'অপেক্ষমাণ নথিভুক্তি')
@section('header-subtitle', 'নতুন নথিভুক্তির আবেদন পর্যালোচনা করুন এবং অনুমোদন করুন')

@section('style')
<style>
/* Payment method badges */
.method-bkash {
    background: linear-gradient(135deg, #E91E63, #AD1457);
    color: white;
}

.method-nogod {
    background: linear-gradient(135deg, #FF5722, #D84315);
    color: white;
}

.method-rocket {
    background: linear-gradient(135deg, #9C27B0, #7B1FA2);
    color: white;
}

.method-cash {
    background: linear-gradient(135deg, #607D8B, #455A64);
    color: white;
}

/* Status badges */
.status-pending {
    background: linear-gradient(135deg, #FF9800, #F57700);
    color: white;
}

/* Student avatar gradient */
.student-avatar-gradient {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    color: #091D3D;
}

:root.light-theme .student-avatar-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
    color: white;
}

/* Amount badge */
.amount-badge {
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
}

/* Transaction code styling */
.transaction-code {
    background: rgba(255, 255, 255, 0.1);
    color: #ABABAB;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 0.25rem 0.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.75rem;
}

:root.light-theme .transaction-code {
    background: #F3F4F6;
    color: #374151;
    border-color: #E5E7EB;
}

/* Modal styling */
.modal-backdrop {
    background: rgba(9, 29, 61, 0.8) !important;
}

/* Button hover effects */
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Empty state styling */
.empty-state-bg {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    border: 2px dashed rgba(90, 234, 244, 0.3);
}

:root.light-theme .empty-state-bg {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-color: rgba(59, 130, 246, 0.3);
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-2 text-secondary-100">
            <i class="fas fa-clock text-blue"></i>
            <span class="text-sm">{{ $enrollments->total() }} টি অপেক্ষমাণ আবেদন</span>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('instructor.enrollments') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-card hover:bg-primary border border-[#fff]/20 hover:border-blue text-secondary-100 hover:text-blue rounded-lg anim">
                <i class="fas fa-list text-sm"></i>
                <span>সকল নথিভুক্তি</span>
            </a>
        </div>
    </div>

    @if($enrollments->count() > 0)
        <!-- Enrollments Table -->
        <div class="bg-card rounded-xl border border-[#fff]/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-primary border-b border-[#fff]/20">
                        <tr>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">শিক্ষার্থী</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">কোর্স</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">পরিমাণ</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">পেমেন্ট মেথড</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">ট্রানজেকশন আইডি</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">আবেদনের তারিখ</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">স্ক্রিনশট</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">পদক্ষেপ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#fff]/10">
                        @foreach($enrollments as $enrollment)
                            <tr class="hover:bg-[#fff]/5 anim">
                                <!-- Student Info -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($enrollment->student->avatar)
                                            <img src="{{ asset($enrollment->student->avatar) }}" 
                                                 alt="{{ $enrollment->student->name }}" 
                                                 class="w-12 h-12 rounded-full border-2 border-[#fff]/20 object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full student-avatar-gradient flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($enrollment->student->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-white font-semibold text-sm">{{ $enrollment->student->name }}</div>
                                            <div class="text-secondary-200 text-xs">{{ $enrollment->student->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Course Info -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-white font-semibold text-sm">{{ $enrollment->course->title }}</div>
                                        <div class="text-secondary-200 text-xs">{{ $enrollment->course->categories }}</div>
                                    </div>
                                </td>

                                <!-- Amount -->
                                <td class="px-6 py-4">
                                    <span class="amount-badge px-3 py-1 rounded-full text-sm font-semibold">
                                        ৳{{ number_format($enrollment->amount) }}
                                    </span>
                                </td>

                                <!-- Payment Method -->
                                <td class="px-6 py-4">
                                    @php
                                        $methodClasses = [
                                            'bkash' => 'method-bkash',
                                            'nogod' => 'method-nogod',
                                            'rocket' => 'method-rocket',
                                            'cash' => 'method-cash'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $methodClasses[$enrollment->payment_method] ?? 'method-cash' }}">
                                        {{ \App\Models\CourseEnrollment::PAYMENT_METHODS[$enrollment->payment_method] ?? ucfirst($enrollment->payment_method) }}
                                    </span>
                                </td>

                                <!-- Transaction ID -->
                                <td class="px-6 py-4">
                                    @if($enrollment->transaction_id)
                                        <span class="transaction-code">{{ $enrollment->transaction_id }}</span>
                                    @else
                                        <span class="text-secondary-200 text-sm">N/A</span>
                                    @endif
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <div class="text-white font-semibold text-sm">{{ $enrollment->created_at->format('M d, Y') }}</div>
                                    <div class="text-secondary-200 text-xs">{{ $enrollment->created_at->format('h:i A') }}</div>
                                </td>

                                <!-- Screenshot -->
                                <td class="px-6 py-4">
                                    @if($enrollment->payment_screenshot)
                                        <button onclick="viewScreenshot('{{ asset('storage/'.$enrollment->payment_screenshot) }}')"
                                                class="flex items-center gap-2 px-3 py-1 bg-blue hover:bg-blue/80 text-primary rounded-lg text-xs font-semibold anim">
                                            <i class="fas fa-image"></i>
                                            <span>দেখুন</span>
                                        </button>
                                    @else
                                        <span class="text-secondary-200 text-sm">কোনো স্ক্রিনশট নেই</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <button onclick="showApproveModal({{ $enrollment->id }}, 'with_payment')"
                                                class="btn-action flex items-center justify-center gap-2 px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold anim">
                                            <i class="fas fa-check-circle"></i>
                                            <span class="hidden sm:inline">পেমেন্ট সহ অনুমোদন</span>
                                            <span class="sm:hidden">অনুমোদন</span>
                                        </button>
                                        <button onclick="showApproveModal({{ $enrollment->id }}, 'without_payment')"
                                                class="btn-action flex items-center justify-center gap-2 px-3 py-2 bg-lime hover:bg-lime/80 text-primary rounded-lg text-xs font-semibold anim">
                                            <i class="fas fa-gift"></i>
                                            <span class="hidden sm:inline">ফ্রি অ্যাক্সেস</span>
                                            <span class="sm:hidden">ফ্রি</span>
                                        </button>
                                        <button onclick="showRejectModal({{ $enrollment->id }})"
                                                class="btn-action flex items-center justify-center gap-2 px-3 py-2 bg-orange hover:bg-orange/80 text-primary rounded-lg text-xs font-semibold anim">
                                            <i class="fas fa-times"></i>
                                            <span>প্রত্যাখ্যান</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($enrollments->hasPages())
                <div class="px-6 py-4 border-t border-[#fff]/20">
                    {{ $enrollments->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-bg rounded-xl p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-blue to-lime flex items-center justify-center">
                <i class="fas fa-clipboard-list text-3xl text-primary"></i>
            </div>
            <h3 class="text-white font-semibold text-xl mb-2">কোনো অপেক্ষমাণ নথিভুক্তি নেই</h3>
            <p class="text-secondary-200">সকল নথিভুক্তির আবেদন প্রক্রিয়া সম্পন্ন হয়েছে।</p>
            <div class="mt-6">
                <a href="{{ route('instructor.enrollments') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim">
                    <i class="fas fa-list"></i>
                    <span>সকল নথিভুক্তি দেখুন</span>
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Screenshot Modal -->
<div id="screenshotModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/80" onclick="closeModal('screenshotModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-card rounded-xl border border-[#fff]/20 max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-[#fff]/20">
                <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                    <i class="fas fa-image text-blue"></i>
                    পেমেন্ট স্ক্রিনশট
                </h3>
                <button onclick="closeModal('screenshotModal')" class="text-secondary-100 hover:text-white anim">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 text-center">
                <img id="screenshotImage" src="" alt="Payment Screenshot" class="max-w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/80" onclick="closeModal('approveModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-card rounded-xl border border-[#fff]/20 max-w-lg w-full">
            <form id="approveForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-6 border-b border-[#fff]/20">
                    <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        নথিভুক্তি অনুমোদন
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <p id="approveMessage" class="text-secondary-100">
                        আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? শিক্ষার্থী কোর্সে প্রবেশাধিকার পাবে।
                    </p>
                    
                    <div id="freeAccessInfo" class="hidden p-4 bg-lime/20 border border-lime rounded-lg">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-lime mt-1"></i>
                            <div>
                                <div class="text-lime font-semibold mb-1">ফ্রি অ্যাক্সেস</div>
                                <div class="text-secondary-100 text-sm">
                                    এই শিক্ষার্থীকে বিনামূল্যে কোর্স অ্যাক্সেস দেওয়া হবে। কোনো পেমেন্ট যাচাই করা হবে না।
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="admin_notes" class="block text-secondary-100 font-semibold mb-2">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" 
                                  class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-secondary-200 focus:border-blue focus:outline-none anim resize-none"
                                  placeholder="এই অনুমোদনের জন্য কোনো নোট যোগ করুন..."></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 p-6 border-t border-[#fff]/20">
                    <button type="button" onclick="closeModal('approveModal')" 
                            class="px-6 py-2 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg anim">
                        বাতিল
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold anim flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        অনুমোদন করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/80" onclick="closeModal('rejectModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-card rounded-xl border border-[#fff]/20 max-w-lg w-full">
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-6 border-b border-[#fff]/20">
                    <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                        <i class="fas fa-times text-orange"></i>
                        নথিভুক্তি প্রত্যাখ্যান
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-secondary-100">এই নথিভুক্তি প্রত্যাখ্যানের কারণ উল্লেখ করুন:</p>
                    
                    <div>
                        <label for="rejection_reason" class="block text-secondary-100 font-semibold mb-2">
                            প্রত্যাখ্যানের কারণ <span class="text-orange">*</span>
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3" required
                                  class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-secondary-200 focus:border-orange focus:outline-none anim resize-none"
                                  placeholder="প্রত্যাখ্যানের স্পষ্ট কারণ উল্লেখ করুন..."></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 p-6 border-t border-[#fff]/20">
                    <button type="button" onclick="closeModal('rejectModal')" 
                            class="px-6 py-2 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg anim">
                        বাতিল
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-orange hover:bg-orange/80 text-primary rounded-lg font-semibold anim flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        প্রত্যাখ্যান করুন
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function viewScreenshot(url) {
    document.getElementById('screenshotImage').src = url;
    document.getElementById('screenshotModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function showApproveModal(enrollmentId, approveType = 'with_payment') {
    const form = document.getElementById('approveForm');
    const freeAccessInfo = document.getElementById('freeAccessInfo');
    const approveMessage = document.getElementById('approveMessage');
    
    if (approveType === 'without_payment') {
        form.action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/approve-without-payment`;
        freeAccessInfo.classList.remove('hidden');
        approveMessage.textContent = 'এই শিক্ষার্থীকে ফ্রি অ্যাক্সেস দিতে চান? কোনো পেমেন্ট যাচাই করা হবে না।';
    } else {
        form.action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/approve`;
        freeAccessInfo.classList.add('hidden');
        approveMessage.textContent = 'আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? পেমেন্ট যাচাই করা হবে।';
    }
    
    document.getElementById('approveModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function showRejectModal(enrollmentId) {
    document.getElementById('rejectForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modals with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        ['screenshotModal', 'approveModal', 'rejectModal'].forEach(modalId => {
            if (!document.getElementById(modalId).classList.contains('hidden')) {
                closeModal(modalId);
            }
        });
    }
});
</script>
@endsection