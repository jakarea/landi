@extends('layouts.instructor-tailwind')
@section('title', 'সকল নথিভুক্তি')
@section('header-title', 'সকল নথিভুক্তি')
@section('header-subtitle', 'আপনার কোর্সের সকল নথিভুক্তি এবং তাদের অবস্থা দেখুন')

@php
    use Illuminate\Support\Str;
@endphp

@section('style')
<style>
/* Payment method badges */
.method-bkash {
    background: linear-gradient(135deg, #E91E63, #AD1457);
    color: white;
}

.method-nogod {
    background: linear-gradient(135deg, #FF9800, #F57700);
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

.status-approved {
    background: linear-gradient(135deg, #4CAF50, #388E3C);
    color: white;
}

.status-rejected {
    background: linear-gradient(135deg, #F44336, #D32F2F);
    color: white;
}

/* Student avatar gradient */
.student-avatar-gradient {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
}

:root.light-theme .student-avatar-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
}

/* Enrollment row hover effects */
.enrollment-row {
    transition: all 0.3s ease;
}

.enrollment-row:hover {
    transform: translateY(-1px);
}

:root.light-theme .enrollment-row:hover {
    background-color: #F9FAFB;
}

/* Animation for table rows */
.animate-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.animate-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Action buttons */
.action-btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.action-btn-approve {
    background: linear-gradient(135deg, #4CAF50, #388E3C);
    color: white;
}

.action-btn-approve:hover {
    background: linear-gradient(135deg, #388E3C, #2E7D32);
    transform: translateY(-1px);
}

.action-btn-free {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.action-btn-free:hover {
    background: linear-gradient(135deg, #1976D2, #1565C0);
    transform: translateY(-1px);
}

.action-btn-reject {
    background: linear-gradient(135deg, #F44336, #D32F2F);
    color: white;
}

.action-btn-reject:hover {
    background: linear-gradient(135deg, #D32F2F, #C62828);
    transform: translateY(-1px);
}

.action-btn-reapprove {
    background: linear-gradient(135deg, #FF9800, #F57700);
    color: white;
}

.action-btn-reapprove:hover {
    background: linear-gradient(135deg, #F57700, #EF6C00);
    transform: translateY(-1px);
}

/* Responsive table adjustments */
@media (max-width: 768px) {
    .responsive-table {
        font-size: 0.875rem;
    }
    
    .student-avatar {
        width: 40px;
        height: 40px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filter-form {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Header -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-white theme-text-primary font-bold text-2xl mb-2">সকল নথিভুক্তি</h1>
                <p class="text-secondary-200">আপনার কোর্সের সকল নথিভুক্তি এবং তাদের অবস্থা পরিচালনা করুন</p>
            </div>
            
            <div class="flex gap-4">
                <a href="{{ route('instructor.enrollments.pending') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-orange to-lime text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1">
                    <i class="fas fa-clock"></i>
                    অপেক্ষমাণ নথিভুক্তি
                </a>
                <a href="{{ route('instructor.enrollments.payment-pending') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue to-purple text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1">
                    <i class="fas fa-credit-card"></i>
                    পেমেন্ট অপেক্ষমাণ
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-white theme-text-primary font-semibold text-lg mb-1">নথিভুক্তি তালিকা</h2>
                <p class="text-secondary-200 text-sm">{{ $enrollments->total() }} টি নথিভুক্তি পাওয়া গেছে</p>
            </div>
        </div>
        
        <form method="GET" action="{{ route('instructor.enrollments') }}" class="filter-form">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">অনুসন্ধান</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="শিক্ষার্থী বা কোর্সের নাম"
                           class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">অবস্থা</label>
                    <select name="status" 
                            class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                        <option value="">সব</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>অপেক্ষমাণ</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>অনুমোদিত</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>প্রত্যাখ্যাত</option>
                    </select>
                </div>
                
                <!-- Payment Method Filter -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">পেমেন্ট মাধ্যম</label>
                    <select name="payment_method" 
                            class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                        <option value="">সব</option>
                        <option value="bkash" {{ request('payment_method') == 'bkash' ? 'selected' : '' }}>বিকাশ</option>
                        <option value="nogod" {{ request('payment_method') == 'nogod' ? 'selected' : '' }}>নগদ</option>
                        <option value="rocket" {{ request('payment_method') == 'rocket' ? 'selected' : '' }}>রকেট</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>ক্যাশ</option>
                    </select>
                </div>
                
                <!-- Course Filter -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">কোর্স</label>
                    <select name="course" 
                            class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                        <option value="">সব কোর্স</option>
                        @foreach(auth()->user()->courses as $course)
                            <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                {{ Str::limit($course->title, 30) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex flex-col justify-end">
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="flex-1 bg-blue text-primary rounded-lg px-4 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                            <i class="fas fa-search mr-2"></i>ফিল্টার
                        </button>
                        @if(request()->hasAny(['search', 'status', 'payment_method', 'course']))
                        <a href="{{ route('instructor.enrollments') }}" 
                           class="px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-orange hover:text-orange">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Enrollments Table -->
    @if($enrollments->count() > 0)
    <div class="bg-card rounded-xl shadow-2 theme-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-card border-b border-[#fff]/20 theme-border">
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">শিক্ষার্থী</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কোর্স</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পরিমাণ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পেমেন্ট মাধ্যম</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">ট্রানজেকশন আইডি</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">অবস্থা</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">আবেদনের তারিখ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $index => $enrollment)
                    <tr class="enrollment-row animate-in border-b border-[#fff]/10 theme-border hover:bg-card theme-hover" 
                        style="animation-delay: {{ $index * 0.1 }}s">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($enrollment->student->avatar)
                                    <img src="{{ asset($enrollment->student->avatar) }}" 
                                         alt="{{ $enrollment->student->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-blue student-avatar">
                                @else
                                    <div class="w-12 h-12 rounded-full student-avatar-gradient flex items-center justify-center text-primary font-bold text-lg">
                                        {{ strtoupper(substr($enrollment->student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white theme-text-primary font-semibold">{{ $enrollment->student->name }}</div>
                                    <div class="text-secondary-200 text-sm">{{ $enrollment->student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-medium">
                                {{ Str::limit($enrollment->course->title, 30) }}
                            </div>
                            @if($enrollment->course->categories)
                                <div class="text-secondary-200 text-xs mt-1">{{ $enrollment->course->categories }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-lime to-blue rounded-full text-primary font-bold">
                                <i class="fas fa-taka-sign text-xs"></i>
                                {{ number_format($enrollment->amount) }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $methodClass = match($enrollment->payment_method) {
                                    'bkash' => 'method-bkash',
                                    'nogod' => 'method-nogod', 
                                    'rocket' => 'method-rocket',
                                    'cash' => 'method-cash',
                                    default => 'method-cash'
                                };
                                $methodName = match($enrollment->payment_method) {
                                    'bkash' => 'বিকাশ',
                                    'nogod' => 'নগদ',
                                    'rocket' => 'রকেট',
                                    'cash' => 'ক্যাশ',
                                    default => $enrollment->payment_method
                                };
                                $methodIcon = match($enrollment->payment_method) {
                                    'bkash' => 'fas fa-mobile-alt',
                                    'nogod' => 'fas fa-wallet',
                                    'rocket' => 'fas fa-rocket',
                                    'cash' => 'fas fa-money-bill',
                                    default => 'fas fa-credit-card'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $methodClass }}">
                                <i class="{{ $methodIcon }}"></i>
                                {{ $methodName }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($enrollment->transaction_id)
                                <code class="bg-body px-2 py-1 rounded text-blue text-xs font-mono">{{ $enrollment->transaction_id }}</code>
                            @else
                                <span class="text-secondary-200 text-sm">N/A</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusClass = match($enrollment->status) {
                                    'pending' => 'status-pending',
                                    'approved' => 'status-approved',
                                    'rejected' => 'status-rejected',
                                    default => 'status-pending'
                                };
                                $statusName = match($enrollment->status) {
                                    'pending' => 'অপেক্ষমাণ',
                                    'approved' => 'অনুমোদিত',
                                    'rejected' => 'প্রত্যাখ্যাত',
                                    default => $enrollment->status
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $statusName }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-medium text-sm">
                                {{ $enrollment->created_at->format('d M Y') }}
                            </div>
                            <div class="text-secondary-200 text-xs">
                                {{ $enrollment->created_at->format('h:i A') }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex gap-2 action-buttons">
                                @if($enrollment->status == 'rejected')
                                    <button type="button" 
                                            onclick="showReapproveModal({{ $enrollment->id }})"
                                            class="action-btn action-btn-reapprove"
                                            title="পুনরায় অনুমোদন">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                @elseif($enrollment->status == 'pending')
                                    <button type="button" 
                                            onclick="showApproveModal({{ $enrollment->id }}, 'with_payment')"
                                            class="action-btn action-btn-approve"
                                            title="পেমেন্ট সহ অনুমোদন">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" 
                                            onclick="showApproveModal({{ $enrollment->id }}, 'without_payment')"
                                            class="action-btn action-btn-free"
                                            title="ফ্রি অ্যাক্সেস">
                                        <i class="fas fa-gift"></i>
                                    </button>
                                    <button type="button" 
                                            onclick="showRejectModal({{ $enrollment->id }})"
                                            class="action-btn action-btn-reject"
                                            title="প্রত্যাখ্যান">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @else
                                    <span class="text-secondary-200 text-sm">কোনো কার্যক্রম নেই</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($enrollments->hasPages())
        <div class="px-6 py-4 border-t border-[#fff]/20 theme-border">
            <div class="flex justify-center">
                <div class="pagination-wrapper">
                    {{ $enrollments->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-card rounded-xl p-12 text-center shadow-2 theme-shadow">
        <div class="w-20 h-20 bg-orange/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-users text-orange text-3xl"></i>
        </div>
        <h3 class="text-white theme-text-primary font-semibold text-xl mb-3">কোন নথিভুক্তি পাওয়া যায়নি</h3>
        <p class="text-secondary-200 mb-6 max-w-md mx-auto">
            @if(request()->hasAny(['search', 'status', 'payment_method', 'course']))
                নির্দিষ্ট ফিল্টারে কোন নথিভুক্তি খুঁজে পাওয়া যায়নি। ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।
            @else
                এখনো কোন শিক্ষার্থী আপনার কোর্সে নথিভুক্ত হয়নি। আপনার কোর্সগুলি প্রচার করুন।
            @endif
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(request()->hasAny(['search', 'status', 'payment_method', 'course']))
                <a href="{{ route('instructor.enrollments') }}" 
                   class="inline-flex items-center gap-2 bg-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                    <i class="fas fa-users"></i>
                    সব নথিভুক্তি দেখুন
                </a>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Re-approve Modal -->
<div id="reapproveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-lg w-full shadow-1 anim transform scale-95 opacity-0" id="reapproveModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#fff]/20 theme-border">
            <h5 class="text-white theme-text-primary font-semibold text-xl">
                <i class="fas fa-redo mr-2"></i>পুনরায় অনুমোদন
            </h5>
            <button type="button" id="closeReapproveModal" class="p-2 text-secondary-200 hover:text-orange anim">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form id="reapproveForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="p-6">
                <p class="text-secondary-200 mb-4">এই প্রত্যাখ্যাত এনরোলমেন্ট পুনরায় অনুমোদন করতে চান?</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-secondary-200 text-sm font-medium mb-3">অনুমোদনের ধরন</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 bg-body border border-[#fff]/20 theme-border rounded-lg cursor-pointer hover:border-blue anim">
                                <input type="radio" name="approve_type" value="with_payment" checked class="text-blue focus:ring-blue">
                                <i class="fas fa-check-circle text-lime"></i>
                                <span class="text-white theme-text-primary">পেমেন্ট সহ অনুমোদন</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 bg-body border border-[#fff]/20 theme-border rounded-lg cursor-pointer hover:border-blue anim">
                                <input type="radio" name="approve_type" value="without_payment" class="text-blue focus:ring-blue">
                                <i class="fas fa-gift text-blue"></i>
                                <span class="text-white theme-text-primary">ফ্রি অ্যাক্সেস প্রদান</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="reapprove_admin_notes" class="block text-secondary-200 text-sm font-medium mb-2">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" 
                                  id="reapprove_admin_notes" 
                                  rows="3"
                                  placeholder="পুনরায় অনুমোদনের জন্য কোনো নোট যোগ করুন..."
                                  class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-4 p-6 border-t border-[#fff]/20 theme-border">
                <button type="button" 
                        id="cancelReapproveBtn"
                        class="px-6 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-secondary-200 hover:text-white">
                    বাতিল
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-lime to-orange text-primary rounded-lg font-semibold anim hover:shadow-1">
                    <i class="fas fa-redo mr-2"></i>
                    পুনরায় অনুমোদন করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-lg w-full shadow-1 anim transform scale-95 opacity-0" id="approveModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#fff]/20 theme-border">
            <h5 class="text-white theme-text-primary font-semibold text-xl">
                <i class="fas fa-check mr-2"></i>নথিভুক্তি অনুমোদন
            </h5>
            <button type="button" id="closeApproveModal" class="p-2 text-secondary-200 hover:text-orange anim">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form id="approveForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="p-6">
                <p class="text-secondary-200 mb-4" id="approveMessage">আপনি কি এই নথিভুক্তি অনুমোদন করতে চান? শিক্ষার্থী কোর্সে প্রবেশাধিকার পাবে।</p>
                
                <div id="freeAccessInfo" class="hidden bg-blue/20 border border-blue/30 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-2 text-blue">
                        <i class="fas fa-info-circle"></i>
                        <strong>ফ্রি অ্যাক্সেস:</strong>
                    </div>
                    <p class="text-secondary-200 text-sm mt-1">এই শিক্ষার্থীকে বিনামূল্যে কোর্স অ্যাক্সেস দেওয়া হবে। কোনো পেমেন্ট যাচাই করা হবে না।</p>
                </div>
                
                <div>
                    <label for="admin_notes" class="block text-secondary-200 text-sm font-medium mb-2">নোট (ঐচ্ছিক)</label>
                    <textarea name="admin_notes" 
                              id="admin_notes" 
                              rows="3"
                              placeholder="এই অনুমোদনের জন্য কোনো নোট যোগ করুন..."
                              class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"></textarea>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-4 p-6 border-t border-[#fff]/20 theme-border">
                <button type="button" 
                        id="cancelApproveBtn"
                        class="px-6 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-secondary-200 hover:text-white">
                    বাতিল
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-lime to-blue text-primary rounded-lg font-semibold anim hover:shadow-1">
                    <i class="fas fa-check mr-2"></i>
                    অনুমোদন করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-lg w-full shadow-1 anim transform scale-95 opacity-0" id="rejectModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#fff]/20 theme-border">
            <h5 class="text-white theme-text-primary font-semibold text-xl">
                <i class="fas fa-times mr-2"></i>নথিভুক্তি প্রত্যাখ্যান
            </h5>
            <button type="button" id="closeRejectModal" class="p-2 text-secondary-200 hover:text-orange anim">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="p-6">
                <p class="text-secondary-200 mb-4">এই নথিভুক্তি প্রত্যাখ্যানের কারণ উল্লেখ করুন:</p>
                
                <div>
                    <label for="rejection_reason" class="block text-secondary-200 text-sm font-medium mb-2">প্রত্যাখ্যানের কারণ</label>
                    <textarea name="rejection_reason" 
                              id="rejection_reason" 
                              rows="4"
                              placeholder="প্রত্যাখ্যানের বিস্তারিত কারণ লিখুন..."
                              required
                              class="w-full px-4 py-3 bg-body border border-orange/50 rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-orange focus:ring-2 focus:ring-orange/20 anim"></textarea>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-4 p-6 border-t border-[#fff]/20 theme-border">
                <button type="button" 
                        id="cancelRejectBtn"
                        class="px-6 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-secondary-200 hover:text-white">
                    বাতিল
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-orange to-red text-primary rounded-lg font-semibold anim hover:shadow-1">
                    <i class="fas fa-times mr-2"></i>
                    প্রত্যাখ্যান করুন
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filter form on change
    const statusSelect = document.querySelector('select[name="status"]');
    const paymentSelect = document.querySelector('select[name="payment_method"]');
    const courseSelect = document.querySelector('select[name="course"]');
    
    [statusSelect, paymentSelect, courseSelect].forEach(select => {
        if (select) {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }
    });

    // Animate table rows on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all enrollment rows
    document.querySelectorAll('.animate-in').forEach(row => {
        observer.observe(row);
    });

    // Enhanced table row hover effects
    document.querySelectorAll('.enrollment-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Modal functionality for Reapprove Modal
    const reapproveModal = document.getElementById('reapproveModal');
    const reapproveModalContent = document.getElementById('reapproveModalContent');
    const closeReapproveModal = document.getElementById('closeReapproveModal');
    const cancelReapproveBtn = document.getElementById('cancelReapproveBtn');

    function openReapproveModal() {
        reapproveModal.classList.remove('hidden');
        setTimeout(() => {
            reapproveModalContent.classList.remove('scale-95', 'opacity-0');
            reapproveModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeReapproveModalFn() {
        reapproveModalContent.classList.remove('scale-100', 'opacity-100');
        reapproveModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            reapproveModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Clear form
            reapproveModal.querySelector('form').reset();
        }, 300);
    }

    // Event listeners for reapprove modal
    if (closeReapproveModal) {
        closeReapproveModal.addEventListener('click', closeReapproveModalFn);
    }
    
    if (cancelReapproveBtn) {
        cancelReapproveBtn.addEventListener('click', closeReapproveModalFn);
    }

    // Modal functionality for Approve Modal
    const approveModal = document.getElementById('approveModal');
    const approveModalContent = document.getElementById('approveModalContent');
    const closeApproveModal = document.getElementById('closeApproveModal');
    const cancelApproveBtn = document.getElementById('cancelApproveBtn');

    function openApproveModal() {
        approveModal.classList.remove('hidden');
        setTimeout(() => {
            approveModalContent.classList.remove('scale-95', 'opacity-0');
            approveModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeApproveModalFn() {
        approveModalContent.classList.remove('scale-100', 'opacity-100');
        approveModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            approveModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Clear form
            approveModal.querySelector('form').reset();
        }, 300);
    }

    // Event listeners for approve modal
    if (closeApproveModal) {
        closeApproveModal.addEventListener('click', closeApproveModalFn);
    }
    
    if (cancelApproveBtn) {
        cancelApproveBtn.addEventListener('click', closeApproveModalFn);
    }

    // Modal functionality for Reject Modal
    const rejectModal = document.getElementById('rejectModal');
    const rejectModalContent = document.getElementById('rejectModalContent');
    const closeRejectModal = document.getElementById('closeRejectModal');
    const cancelRejectBtn = document.getElementById('cancelRejectBtn');

    function openRejectModal() {
        rejectModal.classList.remove('hidden');
        setTimeout(() => {
            rejectModalContent.classList.remove('scale-95', 'opacity-0');
            rejectModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeRejectModalFn() {
        rejectModalContent.classList.remove('scale-100', 'opacity-100');
        rejectModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            rejectModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Clear form
            rejectModal.querySelector('form').reset();
        }, 300);
    }

    // Event listeners for reject modal
    if (closeRejectModal) {
        closeRejectModal.addEventListener('click', closeRejectModalFn);
    }
    
    if (cancelRejectBtn) {
        cancelRejectBtn.addEventListener('click', closeRejectModalFn);
    }

    // Close modals when clicking outside
    [reapproveModal, approveModal, rejectModal].forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                if (modal === reapproveModal) closeReapproveModalFn();
                else if (modal === approveModal) closeApproveModalFn();
                else if (modal === rejectModal) closeRejectModalFn();
            }
        });
    });

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!reapproveModal.classList.contains('hidden')) closeReapproveModalFn();
            else if (!approveModal.classList.contains('hidden')) closeApproveModalFn();
            else if (!rejectModal.classList.contains('hidden')) closeRejectModalFn();
        }
    });

    // Make modal functions globally available
    window.showReapproveModal = function(enrollmentId) {
        document.getElementById('reapproveForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reapprove`;
        openReapproveModal();
    };

    window.showApproveModal = function(enrollmentId, approveType = 'with_payment') {
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
        
        openApproveModal();
    };

    window.showRejectModal = function(enrollmentId) {
        document.getElementById('rejectForm').action = `{{ url('/instructor/enrollments') }}/${enrollmentId}/reject`;
        openRejectModal();
    };

    // Add loading state to filter button
    const filterForm = document.querySelector('form');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>খুঁজছি...';
                submitBtn.disabled = true;
                
                // Reset after 3 seconds to prevent permanent loading state
                setTimeout(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    }
});
</script>
@endsection