@extends('layouts.instructor-tailwind')
@section('title', 'আমার আয়')
@section('header-title', 'আমার আয়')
@section('header-subtitle', 'বিকাশ, নগদ ও রকেট থেকে আসা সকল পেমেন্টের তালিকা')

@section('style')
<!-- jQuery and Typeahead CSS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

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

.method-other {
    background: linear-gradient(135deg, #607D8B, #455A64);
    color: white;
}

/* Student avatar gradient */
.student-avatar-gradient {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
}

:root.light-theme .student-avatar-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
}

/* Earning table hover effects */
.earning-row {
    transition: all 0.3s ease;
}

.earning-row:hover {
    transform: translateY(-1px);
}

:root.light-theme .earning-row:hover {
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

/* Custom scrollbar for table */
.table-container {
    scrollbar-width: thin;
    scrollbar-color: #5AEAF4 transparent;
}

.table-container::-webkit-scrollbar {
    height: 6px;
}

.table-container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #5AEAF4;
    border-radius: 3px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #CBFB90;
}

/* Typeahead styles */
.twitter-typeahead {
    width: 100%;
}

.tt-menu {
    width: 100%;
    min-width: 100%;
    background-color: var(--color-card);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
}

:root.light-theme .tt-menu {
    background-color: #FFFFFF;
    border-color: #E5E7EB;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.tt-suggestion {
    padding: 12px;
    cursor: pointer;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    color: #C7C7C7;
}

:root.light-theme .tt-suggestion {
    border-bottom-color: #F3F4F6;
    color: #374151;
}

.tt-suggestion:last-child {
    border-bottom: none;
}

.tt-suggestion:hover,
.tt-suggestion.tt-cursor {
    background-color: rgba(255, 255, 255, 0.05);
}

:root.light-theme .tt-suggestion:hover,
:root.light-theme .tt-suggestion.tt-cursor {
    background-color: #F9FAFB;
}

.student-suggestion {
    display: flex;
    align-items: center;
    width: 100%;
}

.typeahead-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    margin-right: 12px;
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #021A30;
    font-weight: bold;
    font-size: 12px;
    flex-shrink: 0;
}

.student-info h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: inherit;
}

.student-info small {
    color: #ABABAB;
    font-size: 12px;
}

:root.light-theme .student-info small {
    color: #6B7280;
}

/* Modal customizations */
.modal-content {
    background-color: var(--color-card);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
}

:root.light-theme .modal-content {
    background-color: #FFFFFF;
    border-color: #E5E7EB;
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
}

:root.light-theme .modal-header {
    border-bottom-color: #E5E7EB;
    color: #1F2937;
}

.modal-body {
    color: #C7C7C7;
}

:root.light-theme .modal-body {
    color: #374151;
}

.modal-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

:root.light-theme .modal-footer {
    border-top-color: #E5E7EB;
}

/* Form controls in modal */
.modal .form-control {
    background-color: var(--color-body);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
}

:root.light-theme .modal .form-control {
    background-color: #FFFFFF;
    border-color: #D1D5DB;
    color: #374151;
}

.modal .form-control:focus {
    background-color: var(--color-body);
    border-color: #5AEAF4;
    color: #FFFFFF;
    box-shadow: 0 0 0 2px rgba(90, 234, 244, 0.2);
}

:root.light-theme .modal .form-control:focus {
    background-color: #FFFFFF;
    border-color: #3B82F6;
    color: #374151;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

.modal .form-label {
    color: #ABABAB;
    font-weight: 500;
}

:root.light-theme .modal .form-label {
    color: #374151;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-form {
        flex-direction: column;
        gap: 1rem;
    }
    
    .filter-row {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .responsive-table {
        font-size: 0.875rem;
    }
    
    .student-avatar {
        width: 40px;
        height: 40px;
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
                <h1 class="text-white theme-text-primary font-bold text-2xl mb-2">আমার আয়</h1>
                <p class="text-secondary-200">বিকাশ, নগদ ও রকেট থেকে আসা সকল পেমেন্টের বিস্তারিত তালিকা</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 stats-grid">
                <div class="bg-gradient-to-br from-lime/20 to-blue/20 rounded-xl p-4 text-center border border-[#fff]/10 theme-border">
                    <div class="w-12 h-12 bg-lime/20 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-calendar-month text-lime text-lg"></i>
                    </div>
                    <h3 class="text-white theme-text-primary font-bold text-2xl">৳{{ number_format($monthlyEarnings) }}</h3>
                    <p class="text-secondary-200 text-sm">এই মাসের আয়</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange/20 to-lime/20 rounded-xl p-4 text-center border border-[#fff]/10 theme-border">
                    <div class="w-12 h-12 bg-orange/20 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-chart-line text-orange text-lg"></i>
                    </div>
                    <h3 class="text-white theme-text-primary font-bold text-2xl">৳{{ number_format($totalEarnings) }}</h3>
                    <p class="text-secondary-200 text-sm">মোট আয়</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-white theme-text-primary font-semibold text-lg mb-1">পেমেন্ট তালিকা</h2>
                <p class="text-secondary-200 text-sm">{{ $earnings->total() }} টি পেমেন্ট পাওয়া গেছে</p>
            </div>
            
            <button type="button" 
                    id="openModalBtn"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-lime to-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1 smooth-bounce">
                <i class="fas fa-plus"></i>
                ম্যানুয়াল পেমেন্ট যুক্ত করুন
            </button>
        </div>
        
        <form method="GET" class="filter-form">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Payment Method Filter -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">পেমেন্ট মাধ্যম</label>
                    <select name="method" 
                            class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                        <option value="">সকল মাধ্যম</option>
                        <option value="bkash" {{ request('method') == 'bkash' ? 'selected' : '' }}>বিকাশ</option>
                        <option value="nogod" {{ request('method') == 'nogod' ? 'selected' : '' }}>নগদ</option>
                        <option value="rocket" {{ request('method') == 'rocket' ? 'selected' : '' }}>রকেট</option>
                    </select>
                </div>
                
                <!-- Date From -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">শুরুর তারিখ</label>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                </div>
                
                <!-- Date To -->
                <div>
                    <label class="block text-secondary-200 text-sm font-medium mb-2">শেষ তারিখ</label>
                    <input type="date" 
                           name="date_to" 
                           value="{{ request('date_to') }}"
                           class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                </div>
                
                <!-- Filter Button -->
                <div class="flex flex-col justify-end">
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="flex-1 bg-blue text-primary rounded-lg px-4 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                            <i class="fas fa-search mr-2"></i>খুঁজুন
                        </button>
                        @if(request()->hasAny(['method', 'date_from', 'date_to']))
                        <a href="{{ route('instructor.earnings') }}" 
                           class="px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-orange hover:text-orange">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Earnings Table -->
    @if($earnings->count() > 0)
    <div class="bg-card rounded-xl shadow-2 theme-shadow overflow-hidden">
        <div class="table-container overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-card border-b border-[#fff]/20 theme-border">
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">শিক্ষার্থী</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কোর্স</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পেমেন্ট মাধ্যম</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পরিমাণ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">তারিখ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">ট্রানজেকশন আইডি</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($earnings as $index => $earning)
                    <tr class="earning-row animate-in border-b border-[#fff]/10 theme-border hover:bg-card theme-hover" 
                        style="animation-delay: {{ $index * 0.1 }}s">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @php
                                    $user = $earning->user ?? $earning->student;
                                @endphp
                                @if($user && $user->avatar)
                                    <img src="{{ asset($user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-blue student-avatar">
                                @else
                                    <div class="w-12 h-12 rounded-full student-avatar-gradient flex items-center justify-center text-primary font-bold text-lg">
                                        {{ $user ? strtoupper(substr($user->name, 0, 1)) : 'N' }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white theme-text-primary font-semibold">{{ $user ? $user->name : 'N/A' }}</div>
                                    <div class="text-secondary-200 text-sm">{{ $user ? $user->email : 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($earning->course)
                                <div class="text-white theme-text-primary font-medium">
                                    {{ \Illuminate\Support\Str::limit($earning->course->title, 30) }}
                                </div>
                                @if($earning->course->thumbnail)
                                    <div class="text-secondary-200 text-xs mt-1">
                                        <i class="fas fa-image mr-1"></i>থাম্বনেইল আছে
                                    </div>
                                @endif
                            @else
                                <span class="text-secondary-200">কোর্স পাওয়া যায়নি</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
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
                                $methodIcon = match($earning->payment_method) {
                                    'bkash' => 'fas fa-mobile-alt',
                                    'nogod' => 'fas fa-wallet',
                                    'rocket' => 'fas fa-rocket',
                                    default => 'fas fa-credit-card'
                                };
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $methodClass }}">
                                <i class="{{ $methodIcon }}"></i>
                                {{ $methodName }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-lime to-blue rounded-full text-primary font-bold">
                                <i class="fas fa-taka-sign text-xs"></i>
                                {{ number_format($earning->amount) }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-white theme-text-primary font-medium text-sm">
                                {{ $earning->created_at->format('d M Y') }}
                            </div>
                            <div class="text-secondary-200 text-xs">
                                {{ $earning->created_at->format('h:i A') }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($earning->transaction_id)
                                <code class="bg-body px-2 py-1 rounded text-blue text-xs font-mono">{{ $earning->transaction_id }}</code>
                            @else
                                <span class="text-secondary-200 text-sm">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($earnings->hasPages())
        <div class="px-6 py-4 border-t border-[#fff]/20 theme-border">
            <div class="flex justify-center">
                <div class="pagination-wrapper">
                    {{ $earnings->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-card rounded-xl p-12 text-center shadow-2 theme-shadow">
        <div class="w-20 h-20 bg-orange/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-money-bill-wave text-orange text-3xl"></i>
        </div>
        <h3 class="text-white theme-text-primary font-semibold text-xl mb-3">কোন আয় পাওয়া যায়নি</h3>
        <p class="text-secondary-200 mb-6 max-w-md mx-auto">
            @if(request()->hasAny(['method', 'date_from', 'date_to']))
                নির্দিষ্ট ফিল্টারে কোন আয়ের তথ্য খুঁজে পাওয়া যায়নি। ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।
            @else
                এখনো কোন শিক্ষার্থী আপনার কোর্সের জন্য পেমেন্ট করেননি। আপনার কোর্সগুলি প্রচার করুন।
            @endif
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(request()->hasAny(['method', 'date_from', 'date_to']))
                <a href="{{ route('instructor.earnings') }}" 
                   class="inline-flex items-center gap-2 bg-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                    <i class="fas fa-money-bill-wave"></i>
                    সব আয় দেখুন
                </a>
            @endif
            
            <button type="button" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-lime to-orange text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1"
                    onclick="openModal()">
                <i class="fas fa-plus"></i>
                ম্যানুয়াল পেমেন্ট যুক্ত করুন
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Add Earning Modal -->
<div id="addEarningModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-1 anim transform scale-95 opacity-0" id="modalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#fff]/20 theme-border">
            <h5 class="text-white theme-text-primary font-semibold text-xl">ম্যানুয়াল পেমেন্ট যুক্ত করুন</h5>
            <button type="button" id="closeModalBtn" class="p-2 text-secondary-200 hover:text-orange anim">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form action="{{ route('instructor.earnings.add') }}" method="POST" id="earningForm">
            @csrf
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="user_search" class="block text-secondary-200 text-sm font-medium mb-2">শিক্ষার্থী নির্বাচন করুন</label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim typeahead-input" 
                               id="user_search" 
                               placeholder="শিক্ষার্থীর নাম বা ইমেইল লিখুন..." 
                               autocomplete="off">
                        <input type="hidden" name="user_id" id="selected_user_id" required>
                        <small class="text-secondary-200 text-xs mt-1 block">টাইপ করুন এবং তালিকা থেকে শিক্ষার্থী নির্বাচন করুন</small>
                    </div>
                    
                    <!-- Course Selection -->
                    <div>
                        <label for="course_id" class="block text-secondary-200 text-sm font-medium mb-2">কোর্স নির্বাচন করুন</label>
                        <select class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim" name="course_id" required>
                            <option value="">কোর্স নির্বাচন করুন</option>
                            @if(isset($instructorCourses))
                                @foreach($instructorCourses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-secondary-200 text-sm font-medium mb-2">পেমেন্ট মাধ্যম</label>
                        <select class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim" name="payment_method" required>
                            <option value="">পেমেন্ট মাধ্যম নির্বাচন করুন</option>
                            <option value="bkash">বিকাশ</option>
                            <option value="nogod">নগদ</option>
                            <option value="rocket">রকেট</option>
                        </select>
                    </div>
                    
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-secondary-200 text-sm font-medium mb-2">পরিমাণ (৳)</label>
                        <input type="number" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim" 
                               name="amount" 
                               step="0.01" 
                               placeholder="0.00"
                               required>
                    </div>
                    
                    <!-- Transaction ID -->
                    <div>
                        <label for="transaction_id" class="block text-secondary-200 text-sm font-medium mb-2">ট্রানজেকশন আইডি (ঐচ্ছিক)</label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim" 
                               name="transaction_id" 
                               placeholder="TXN123456789">
                        <small class="text-secondary-200 text-xs mt-1 block">বিকাশ/নগদ/রকেট থেকে পাওয়া ট্রানজেকশন আইডি</small>
                    </div>
                    
                    <!-- Sender Number -->
                    <div>
                        <label for="sender_number" class="block text-secondary-200 text-sm font-medium mb-2">প্রেরকের নম্বর (ঐচ্ছিক)</label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim" 
                               name="sender_number" 
                               placeholder="০১xxxxxxxxx">
                        <small class="text-secondary-200 text-xs mt-1 block">যে নম্বর থেকে পেমেন্ট এসেছে</small>
                    </div>
                    
                    <!-- Payment Date -->
                    <div>
                        <label for="payment_date" class="block text-secondary-200 text-sm font-medium mb-2">পেমেন্টের তারিখ (ঐচ্ছিক)</label>
                        <input type="date" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim" 
                               name="payment_date" 
                               max="{{ date('Y-m-d') }}">
                        <small class="text-secondary-200 text-xs mt-1 block">যদি আজকের তারিখ না হয়</small>
                    </div>
                    
                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-secondary-200 text-sm font-medium mb-2">মন্তব্য (ঐচ্ছিক)</label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim" 
                               name="notes" 
                               placeholder="অতিরিক্ত কোনো তথ্য">
                        <small class="text-secondary-200 text-xs mt-1 block">পেমেন্ট সম্পর্কে অতিরিক্ত তথ্য</small>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-4 p-6 border-t border-[#fff]/20 theme-border">
                <button type="button" 
                        id="cancelBtn"
                        class="px-6 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-secondary-200 hover:text-white">
                    বাতিল
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue to-lime text-primary rounded-lg font-semibold anim hover:shadow-1">
                    <i class="fas fa-save mr-2"></i>
                    সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
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
                    ? '<img src="' + student.avatar + '" class="typeahead-avatar" alt="' + student.name + '">'
                    : '<div class="typeahead-avatar">' + student.initials + '</div>';
                
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
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all earning rows
    document.querySelectorAll('.animate-in').forEach(row => {
        observer.observe(row);
    });

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

    // Enhanced table row hover effects
    document.querySelectorAll('.earning-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Modal form validation
    const modalForm = document.querySelector('#addEarningModal form');
    if (modalForm) {
        modalForm.addEventListener('submit', function(e) {
            const selectedUserId = document.getElementById('selected_user_id').value;
            if (!selectedUserId) {
                e.preventDefault();
                alert('দয়া করে একজন শিক্ষার্থী নির্বাচন করুন');
                document.getElementById('user_search').focus();
                return false;
            }
        });
    }

    // Modal functionality
    const modal = document.getElementById('addEarningModal');
    const modalContent = document.getElementById('modalContent');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Clear form
            modal.querySelector('form').reset();
            $('#selected_user_id').val('');
            $('#user_search').typeahead('val', '');
        }, 300);
    }

    // Event listeners
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Make openModal function globally available
    window.openModal = openModal;

    // Smooth scroll to top when filters change
    if (window.location.search.includes('method=') || 
        window.location.search.includes('date_from=') || 
        window.location.search.includes('date_to=')) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
});
</script>
@endsection