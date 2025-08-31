@extends('layouts.instructor-tailwind')
@section('title', 'আমার শিক্ষার্থীরা')
@section('header-title', 'আমার শিক্ষার্থীরা')
@section('header-subtitle', 'আপনার সব কোর্সের নথিভুক্ত শিক্ষার্থীদের তালিকা')

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

.method-other {
    background: linear-gradient(135deg, #607D8B, #455A64);
    color: white;
}

/* Source badges */
.source-checkout {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.source-manual {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

/* Light theme adjustments */
:root.light-theme .source-checkout {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

:root.light-theme .source-manual {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
}

/* Student table hover effects */
.student-row {
    transition: all 0.3s ease;
}

.student-row:hover {
    transform: translateY(-1px);
}

:root.light-theme .student-row:hover {
    background-color: #F9FAFB;
}

/* Avatar gradient */
.student-avatar-gradient {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
}

:root.light-theme .student-avatar-gradient {
    background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
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

/* Responsive table */
@media (max-width: 768px) {
    .responsive-table {
        font-size: 0.875rem;
    }
    
    .student-avatar {
        width: 40px;
        height: 40px;
    }
    
    .mobile-stack {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
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
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Header -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-white theme-text-primary font-bold text-2xl mb-2">আমার শিক্ষার্থীরা</h1>
                <p class="text-secondary-200">আপনার সব কোর্সের নথিভুক্ত শিক্ষার্থীদের তালিকা ও পরিসংখ্যান</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-blue/20 to-lime/20 rounded-xl p-4 text-center border border-[#fff]/10 theme-border">
                    <div class="w-12 h-12 bg-blue/20 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-users text-blue text-lg"></i>
                    </div>
                    <h3 class="text-white theme-text-primary font-bold text-2xl">{{ $totalStudents }}</h3>
                    <p class="text-secondary-200 text-sm">মোট শিক্ষার্থী</p>
                </div>
                
                <div class="bg-gradient-to-br from-lime/20 to-orange/20 rounded-xl p-4 text-center border border-[#fff]/10 theme-border">
                    <div class="w-12 h-12 bg-lime/20 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-taka-sign text-lime text-lg"></i>
                    </div>
                    <h3 class="text-white theme-text-primary font-bold text-2xl">৳{{ number_format($totalEarnings) }}</h3>
                    <p class="text-secondary-200 text-sm">মোট আয়</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-white theme-text-primary font-semibold text-lg mb-1">শিক্ষার্থীদের তালিকা</h2>
                <p class="text-secondary-200 text-sm">{{ $students->total() }} জন শিক্ষার্থী পাওয়া গেছে</p>
            </div>
            
            <form method="GET" class="flex gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-80">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-secondary-200"></i>
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}" 
                           placeholder="নাম বা ইমেইল দিয়ে খুঁজুন..."
                           class="w-full pl-10 pr-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-blue text-primary rounded-lg font-semibold anim hover:bg-lime hover:text-primary flex-shrink-0">
                    <i class="fas fa-search mr-2"></i>
                    <span class="hidden sm:inline">খুঁজুন</span>
                </button>
                @if(request('search'))
                <a href="{{ route('instructor.students') }}" 
                   class="px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-orange hover:text-orange flex-shrink-0">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Students Table -->
    @if($students->count() > 0)
    <div class="bg-card rounded-xl shadow-2 theme-shadow overflow-hidden">
        <div class="table-container overflow-x-auto">
            <table class="w-full responsive-table">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-card border-b border-[#fff]/20 theme-border">
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">শিক্ষার্থী</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">কোর্স</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পেমেন্ট</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">পরিমাণ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">তারিখ</th>
                        <th class="text-left py-4 px-6 text-secondary-100 font-semibold text-sm">উৎস</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                    <tr class="student-row animate-in border-b border-[#fff]/10 theme-border hover:bg-card theme-hover" 
                        style="animation-delay: {{ $index * 0.1 }}s">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($student->user->avatar)
                                    <img src="{{ asset($student->user->avatar) }}" 
                                         alt="{{ $student->user->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-blue student-avatar">
                                @else
                                    <div class="w-12 h-12 rounded-full student-avatar-gradient flex items-center justify-center text-primary font-bold text-lg">
                                        {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white theme-text-primary font-semibold">{{ $student->user->name }}</div>
                                    <div class="text-secondary-200 text-sm">{{ $student->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($student->course)
                                <div class="text-white theme-text-primary font-medium">
                                    {{ \Illuminate\Support\Str::limit($student->course->title, 30) }}
                                </div>
                                @if($student->course->thumbnail)
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
                                $paymentMethod = $student->payment_method ?? 'unknown';
                                $methodClass = match($paymentMethod) {
                                    'bkash' => 'method-bkash',
                                    'nogod' => 'method-nogod', 
                                    'rocket' => 'method-rocket',
                                    default => 'method-other'
                                };
                                $methodName = match($paymentMethod) {
                                    'bkash' => 'বিকাশ',
                                    'nogod' => 'নগদ',
                                    'rocket' => 'রকেট', 
                                    default => $paymentMethod ?? 'অজানা'
                                };
                                $methodIcon = match($paymentMethod) {
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
                                {{ number_format($student->amount ?? 0) }}
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if($student->created_at)
                                <div class="text-white theme-text-primary font-medium text-sm">
                                    {{ $student->created_at->format('d M Y') }}
                                </div>
                                <div class="text-secondary-200 text-xs">
                                    {{ $student->created_at->format('h:i A') }}
                                </div>
                            @else
                                <div class="text-secondary-200 text-sm">N/A</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $isManual = $student->is_manual ?? false;
                                $sourceClass = $isManual ? 'source-manual' : 'source-checkout';
                                $sourceName = $isManual ? 'ম্যানুয়াল' : 'স্বয়ংক্রিয়';
                                $sourceIcon = $isManual ? 'fas fa-user-cog' : 'fas fa-shopping-cart';
                            @endphp
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $sourceClass }}">
                                <i class="{{ $sourceIcon }}"></i>
                                {{ $sourceName }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
        <div class="px-6 py-4 border-t border-[#fff]/20 theme-border">
            <div class="flex justify-center">
                <div class="pagination-wrapper">
                    {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-card rounded-xl p-12 text-center shadow-2 theme-shadow">
        <div class="w-20 h-20 bg-blue/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-users text-blue text-3xl"></i>
        </div>
        <h3 class="text-white theme-text-primary font-semibold text-xl mb-3">কোন শিক্ষার্থী পাওয়া যায়নি</h3>
        <p class="text-secondary-200 mb-6 max-w-md mx-auto">
            @if(request('search'))
                "{{ request('search') }}" এর জন্য কোন শিক্ষার্থী খুঁজে পাওয়া যায়নি। অন্য কিওয়ার্ড দিয়ে চেষ্টা করুন।
            @else
                এখনো কোন শিক্ষার্থী আপনার কোর্সে নথিভুক্ত হননি। আপনার কোর্সগুলি প্রচার করুন এবং শিক্ষার্থীদের আকর্ষণ করুন।
            @endif
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(request('search'))
                <a href="{{ route('instructor.students') }}" 
                   class="inline-flex items-center gap-2 bg-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                    <i class="fas fa-users"></i>
                    সব শিক্ষার্থী দেখুন
                </a>
            @endif
            
            <a href="{{ route('instructor.courses') }}" 
               class="inline-flex items-center gap-2 bg-body border border-[#fff]/20 theme-border rounded-lg px-6 py-3 text-secondary-200 anim hover:border-blue hover:text-blue">
                <i class="fas fa-book"></i>
                কোর্স পরিচালনা করুন
            </a>
        </div>
    </div>
    @endif
</div>
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
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all student rows
    document.querySelectorAll('.animate-in').forEach(row => {
        observer.observe(row);
    });

    // Add loading state to search button
    const searchForm = document.querySelector('form');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span class="hidden sm:inline">খুঁজছি...</span>';
                submitBtn.disabled = true;
                
                // Reset after 3 seconds to prevent permanent loading state
                setTimeout(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    }

    // Smooth scroll to top when search changes
    if (window.location.search.includes('search=')) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Enhanced table row hover effects
    document.querySelectorAll('.student-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add keyboard navigation for table
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            const rows = Array.from(document.querySelectorAll('.student-row'));
            const currentRow = document.querySelector('.student-row:focus');
            
            if (rows.length > 0) {
                let nextIndex = 0;
                
                if (currentRow) {
                    const currentIndex = rows.indexOf(currentRow);
                    if (e.key === 'ArrowDown' && currentIndex < rows.length - 1) {
                        nextIndex = currentIndex + 1;
                    } else if (e.key === 'ArrowUp' && currentIndex > 0) {
                        nextIndex = currentIndex - 1;
                    } else {
                        nextIndex = currentIndex;
                    }
                }
                
                rows[nextIndex].focus();
                e.preventDefault();
            }
        }
    });

    // Make table rows focusable
    document.querySelectorAll('.student-row').forEach(row => {
        row.setAttribute('tabindex', '0');
    });
});
</script>
@endsection