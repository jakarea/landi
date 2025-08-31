@extends('layouts.instructor-tailwind')
@section('title', 'পেমেন্ট অপেক্ষমাণ নথিভুক্তি')
@section('header-title', 'পেমেন্ট অপেক্ষমাণ নথিভুক্তি')
@section('header-subtitle', 'পেমেন্ট প্রক্রিয়াধীন নথিভুক্তির আবেদনগুলি দেখুন')

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
.status-payment-pending {
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

/* Empty state styling */
.empty-state-bg {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    border: 2px dashed rgba(90, 234, 244, 0.3);
}

:root.light-theme .empty-state-bg {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-color: rgba(59, 130, 246, 0.3);
}

/* Warning badge for payment pending */
.payment-pending-badge {
    background: linear-gradient(135deg, #FBBF24, #F59E0B);
    color: #92400E;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 text-secondary-100">
                <i class="fas fa-hourglass-half text-orange"></i>
                <span class="text-sm">{{ $enrollments->total() }} টি পেমেন্ট অপেক্ষমাণ</span>
            </div>
            <div class="payment-pending-badge px-3 py-1 rounded-full text-xs font-semibold">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                পেমেন্ট প্রয়োজন
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('instructor.enrollments.pending') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-card hover:bg-primary border border-[#fff]/20 hover:border-blue text-secondary-100 hover:text-blue rounded-lg anim">
                <i class="fas fa-clock text-sm"></i>
                <span>অপেক্ষমাণ</span>
            </a>
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
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">অবস্থা</th>
                            <th class="text-left px-6 py-4 text-secondary-100 font-semibold text-sm">স্ক্রিনশট</th>
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

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-orange rounded-full animate-pulse"></div>
                                        <span class="status-payment-pending px-3 py-1 rounded-full text-xs font-semibold">
                                            পেমেন্ট অপেক্ষমাণ
                                        </span>
                                    </div>
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
                                        <div class="flex items-center gap-2 text-secondary-200">
                                            <i class="fas fa-exclamation-triangle text-orange"></i>
                                            <span class="text-sm">প্রয়োজন</span>
                                        </div>
                                    @endif
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

        <!-- Payment Instructions Card -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange to-yellow-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-primary text-lg"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg mb-2">পেমেন্ট অপেক্ষমাণ নথিভুক্তি সম্পর্কে</h3>
                    <div class="text-secondary-200 space-y-2">
                        <p>• এই নথিভুক্তিগুলির জন্য শিক্ষার্থীরা পেমেন্ট সম্পূর্ণ করেননি</p>
                        <p>• শিক্ষার্থীরা তাদের পেমেন্ট স্ট্যাটাস চেক করে আবশ্যকীয় পেমেন্ট সম্পন্ন করতে পারবেন</p>
                        <p>• পেমেন্ট সম্পন্ন হলে এগুলি স্বয়ংক্রিয়ভাবে 'অনুমোদনের জন্য অপেক্ষমাণ' তালিকায় চলে যাবে</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state-bg rounded-xl p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-orange to-yellow-500 flex items-center justify-center">
                <i class="fas fa-hourglass-half text-3xl text-primary"></i>
            </div>
            <h3 class="text-white font-semibold text-xl mb-2">কোনো পেমেন্ট অপেক্ষমাণ নথিভুক্তি নেই</h3>
            <p class="text-secondary-200">সকল নথিভুক্তির পেমেন্ট সম্পন্ন হয়েছে বা প্রক্রিয়াধীন নেই।</p>
            <div class="mt-6 space-x-4">
                <a href="{{ route('instructor.enrollments.pending') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim">
                    <i class="fas fa-clock"></i>
                    <span>অপেক্ষমাণ নথিভুক্তি</span>
                </a>
                <a href="{{ route('instructor.enrollments') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-card hover:bg-primary border border-[#fff]/20 hover:border-blue text-secondary-100 hover:text-blue rounded-lg font-semibold anim">
                    <i class="fas fa-list"></i>
                    <span>সকল নথিভুক্তি</span>
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
@endsection

@section('script')
<script>
function viewScreenshot(url) {
    document.getElementById('screenshotImage').src = url;
    document.getElementById('screenshotModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('screenshotModal');
        if (!modal.classList.contains('hidden')) {
            closeModal('screenshotModal');
        }
    }
});
</script>
@endsection