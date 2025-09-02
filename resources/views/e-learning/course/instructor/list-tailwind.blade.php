@extends('layouts.instructor-tailwind')
@section('title', 'সব কোর্স')
@section('header-title', 'আমার কোর্স')
@section('header-subtitle', 'আপনার কোর্স পোর্টফোলিও পরিচালনা করুন')

@php
    use Illuminate\Support\Str;
@endphp

@section('style')
<style>
/* Light theme specific overrides */
:root.light-theme {
    --color-text-white: #1F2937;
    --color-border: #E5E7EB;
    --color-hover: #F3F4F6;
    --color-shadow: rgba(0, 0, 0, 0.1);
}

/* Dark theme specific overrides */
:root:not(.light-theme) {
    --color-text-white: #FFFFFF;
    --color-border: rgba(255, 255, 255, 0.2);
    --color-hover: #1E3A5F;
    --color-shadow: rgba(90, 234, 244, 0.1);
}

.theme-text-primary {
    color: var(--color-text-white);
}

.theme-border {
    border-color: var(--color-border);
}

.theme-hover:hover {
    background-color: var(--color-hover);
}

.theme-shadow {
    box-shadow: 0 4px 6px -1px var(--color-shadow), 0 2px 4px -1px var(--color-shadow);
}

/* Status badge colors for light theme */
:root.light-theme .status-published {
    background: #10B981;
    color: #FFFFFF;
}

:root.light-theme .status-draft {
    background: #F59E0B;
    color: #FFFFFF;
}

:root.light-theme .status-pending {
    background: #EF4444;
    color: #FFFFFF;
}

/* Card hover effects for light theme */
:root.light-theme .course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Pagination styling for both themes */
.pagination-wrapper .pagination {
    display: flex;
    justify-content: center;
    gap: 0.25rem;
    margin: 0;
    padding: 0;
    list-style: none;
}

.pagination-wrapper .page-item {
    margin: 0;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    padding: 0;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #C7C7C7;
    background-color: transparent;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link:hover {
    background-color: #5AEAF4;
    border-color: #5AEAF4;
    color: #021A30;
    transform: translateY(-1px);
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #5AEAF4;
    border-color: #5AEAF4;
    color: #021A30;
    font-weight: 600;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #6B7280;
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.1);
    cursor: not-allowed;
    transform: none;
}

/* Light theme pagination */
:root.light-theme .pagination-wrapper .page-link {
    border-color: #E5E7EB;
    color: #6B7280;
    background-color: #FFFFFF;
}

:root.light-theme .pagination-wrapper .page-link:hover {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
}

:root.light-theme .pagination-wrapper .page-item.active .page-link {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
}

:root.light-theme .pagination-wrapper .page-item.disabled .page-link {
    color: #9CA3AF;
    background-color: #F9FAFB;
    border-color: #E5E7EB;
}

/* Responsive adjustments for 4-column grid */
@media (max-width: 1280px) {
    /* 3 columns on large screens */
    .grid.xl\\:grid-cols-4 {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 1024px) {
    /* 2 columns on medium screens */
    .grid.lg\\:grid-cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    /* 1 column on small screens */
    .grid.md\\:grid-cols-2 {
        grid-template-columns: repeat(1, 1fr);
    }
    
    .pagination-wrapper .page-link {
        width: 2rem;
        height: 2rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-white theme-text-primary font-bold text-2xl mb-2">আমার কোর্স</h1>
                <p class="text-secondary-200">আপনার কোর্স পোর্টফোলিও পরিচালনা এবং ট্র্যাক করুন</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-secondary-200">
                    <i class="fas fa-chart-line"></i>
                    <span class="font-medium">{{ count($courses) }} কোর্স</span>
                </div>
                <a href="{{ route('instructor.courses.create') }}" 
                   class="inline-flex items-center gap-2 bg-blue rounded-lg px-4 py-2 text-primary font-semibold anim hover:bg-lime hover:text-primary smooth-bounce">
                    <i class="fas fa-plus"></i>
                    <span>কোর্স তৈরি করুন</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <form action="" method="GET" id="courseFilterForm">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-secondary-200"></i>
                        <input type="text" 
                               name="title"
                               class="w-full pl-10 pr-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"
                               placeholder="শিরোনাম বা বিবরণ দিয়ে অনুসন্ধান করুন..."
                               value="{{ request('title') }}">
                    </div>
                    <input type="hidden" name="status" id="statusInput">
                </div>
                
                <!-- Filter Dropdown -->
                <div class="relative">
                    <button type="button" id="filterDropdownBtn" 
                            class="w-full flex items-center justify-between px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary anim hover:border-blue">
                        <span id="filterText">সব কোর্স</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    
                    <div id="filterDropdown" class="absolute top-full left-0 right-0 mt-2 bg-card border border-[#fff]/20 theme-border rounded-lg shadow-1 hidden z-10">
                        <div class="py-2">
                            <a href="#" class="filter-item flex items-center gap-2 px-4 py-2 text-secondary-100 theme-hover anim" data-value="">
                                <i class="fas fa-list text-xs w-4"></i>
                                সব কোর্স
                            </a>
                            <a href="#" class="filter-item flex items-center gap-2 px-4 py-2 text-secondary-100 theme-hover anim" data-value="best_rated">
                                <i class="fas fa-star text-xs w-4 text-orange"></i>
                                সর্বোচ্চ রেটিং
                            </a>
                            <a href="#" class="filter-item flex items-center gap-2 px-4 py-2 text-secondary-100 theme-hover anim" data-value="most_purchased">
                                <i class="fas fa-fire text-xs w-4 text-orange"></i>
                                সর্বাধিক বিক্রিত
                            </a>
                            <a href="#" class="filter-item flex items-center gap-2 px-4 py-2 text-secondary-100 theme-hover anim" data-value="newest">
                                <i class="fas fa-clock text-xs w-4 text-blue"></i>
                                সর্বশেষ
                            </a>
                            <a href="#" class="filter-item flex items-center gap-2 px-4 py-2 text-secondary-100 theme-hover anim" data-value="oldest">
                                <i class="fas fa-history text-xs w-4 text-secondary-200"></i>
                                পুরাতন
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Search Button -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue text-primary rounded-lg px-4 py-3 font-semibold anim hover:bg-lime hover:text-primary">
                        <i class="fas fa-search mr-2"></i>অনুসন্ধান
                    </button>
                    <button type="button" onclick="window.location.href = '{{ route('instructor.courses') }}'" 
                            class="px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-secondary-200 anim hover:border-orange hover:text-orange">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Course Grid -->
    @if (count($courses) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($courses as $course)
        @php
            $review_sum = 0;
            $review_avg = 0;
            $total = 0;
            foreach ($course->reviews as $review) {
                $total++;
                $review_sum += $review->star;
            }
            if ($total) {
                $review_avg = round($review_sum / $total, 1);
            }
            
            $enrollmentCount = \App\Models\CourseEnrollment::where('course_id', $course->id)->count();
            $moduleCount = \App\Models\Module::where('course_id', $course->id)->count();
            $lessonCount = \App\Models\Lesson::where('course_id', $course->id)->count();
            $revenueCount = \App\Models\Checkout::where('course_id', $course->id)
                ->whereIn('payment_method', ['bkash', 'nogod', 'rocket', 'manual'])
                ->whereIn('payment_status', ['completed', 'Paid'])
                ->sum('amount');
        @endphp
        
        <div class="course-card bg-card rounded-xl overflow-hidden shadow-2 theme-shadow anim smooth-bounce">
            <!-- Course Image Container -->
            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue/20 to-lime/20">
                <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                     alt="{{ $course->title }}" 
                     class="w-full h-full object-cover anim hover:scale-105"
                     loading="lazy">
                
                <!-- Status Badge -->
                @if ($course->status == 'pending')
                <div class="status-pending absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-clock"></i>
                    <span>অপেক্ষমান</span>
                </div>
                @elseif ($course->status == 'draft')
                <div class="status-draft absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-edit"></i>
                    <span>খসড়া</span>
                </div>
                @elseif ($course->status == 'published')
                <div class="status-published absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-check-circle"></i>
                    <span>লাইভ</span>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="absolute top-3 left-3 flex gap-2 opacity-0 course-actions anim">
                    <a href="{{ route('instructor.courses.show', $course->slug) }}" 
                       class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-primary hover:bg-white anim"
                       title="বিস্তারিত দেখুন">
                        <i class="fas fa-eye text-xs"></i>
                    </a>
                    <a href="{{ route('instructor.courses.create.facts', $course->id) }}" 
                       class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-primary hover:bg-white anim"
                       title="সম্পাদনা করুন">
                        <i class="fas fa-edit text-xs"></i>
                    </a>
                    <a href="{{ route('courses.overview', $course->slug) }}" 
                       class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-primary hover:bg-white anim"
                       title="প্রিভিউ">
                        <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Course Content -->
            <div class="p-6 flex flex-col">
                <!-- Course Header -->
                <div class="flex justify-between items-start gap-3 mb-3">
                    <h3 class="text-white theme-text-primary font-semibold text-lg leading-tight line-clamp-2 flex-1 truncate">
                        <a href="{{ route('instructor.courses.show', $course->slug) }}" class="hover:text-blue anim">
                            {{ $course->title ? $course->title : 'শিরোনামহীন কোর্স' }}
                        </a>
                    </h3>
                    
                    <div class="text-right flex-shrink-0">
                        @if ($course->offer_price)
                            <span class="text-lime font-bold text-lg">৳{{ number_format($course->offer_price) }}</span>
                            <span class="block text-secondary-200 line-through text-sm">৳{{ number_format($course->price) }}</span>
                        @elseif(!$course->offer_price && !$course->price)
                            <span class="text-lime font-bold text-lg">বিনামূল্যে</span>
                        @else
                            <span class="text-lime font-bold text-lg">৳{{ number_format($course->price) }}</span>
                        @endif
                    </div>
                </div>
                
                <!-- Course Description -->
                <p class="text-secondary-200 text-sm mb-4 leading-relaxed line-clamp-2">
                    {!! Str::limit(strip_tags($course->short_description), 120, '...') !!}
                </p>
                
                <!-- Course Statistics -->
                <div class="grid grid-cols-4 gap-3 py-4 border-t border-[#fff]/10 theme-border mt-auto">
                    <div class="text-center">
                        <i class="fas fa-play-circle text-blue text-lg mb-1"></i>
                        <div class="text-white theme-text-primary font-semibold text-sm">{{ $lessonCount }}</div>
                        <div class="text-secondary-200 text-xs">লেসন</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-users text-lime text-lg mb-1"></i>
                        <div class="text-white theme-text-primary font-semibold text-sm">{{ $enrollmentCount }}</div>
                        <div class="text-secondary-200 text-xs">শিক্ষার্থী</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-star text-orange text-lg mb-1"></i>
                        <div class="text-white theme-text-primary font-semibold text-sm">{{ number_format($review_avg, 1) }}</div>
                        <div class="text-secondary-200 text-xs">({{ $total }})</div>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-donate text-blue text-lg mb-1"></i>
                        <div class="text-white theme-text-primary font-semibold text-sm">{{ number_format($revenueCount) }}</div>
                        <div class="text-secondary-200 text-xs">আয়</div>
                    </div>
                </div>
                
                <!-- Course Footer -->
                <div class="flex items-center justify-between pt-4 border-t border-[#fff]/10 theme-border">
                    <div class="flex items-center gap-4 text-secondary-200 text-xs">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $course->created_at->format('M d, Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-layer-group"></i>
                            {{ $moduleCount }} মডিউল
                        </span>
                    </div>
                    
                    <!-- More Actions Dropdown -->
                    <div class="relative">
                        <button class="more-actions-btn p-2 text-secondary-200 hover:text-blue anim" title="আরও অপশন">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="more-actions-menu absolute right-0 top-auto bottom-0 mt-2 w-48 bg-card border border-[#fff]/20 theme-border rounded-lg shadow-1 hidden z-10">
                            <div class="py-2">
                                <form method="POST" action="{{ route('instructor.courses.destroy', $course->id) }}" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full flex items-center gap-2 px-4 py-2 text-orange hover:bg-orange/10 anim text-left"
                                            onclick="return confirm('আপনি কি নিশ্চিত যে এই কোর্সটি মুছে ফেলতে চান? এই কাজটি পূর্বাবস্থায় ফিরিয়ে আনা যাবে না।')">
                                        <i class="fas fa-trash text-xs w-4"></i>
                                        কোর্স মুছে ফেলুন
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-card rounded-xl p-12 text-center shadow-2 theme-shadow">
        <div class="w-20 h-20 bg-blue/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-graduation-cap text-blue text-3xl"></i>
        </div>
        <h3 class="text-white theme-text-primary font-semibold text-xl mb-3">কোন কোর্স পাওয়া যায়নি</h3>
        <p class="text-secondary-200 mb-6 max-w-md mx-auto">আপনি এখনও কোনো কোর্স তৈরি করেননি। আপনার জ্ঞান শেয়ার করতে প্রথম কোর্স তৈরি করা শুরু করুন!</p>
        <a href="{{ route('instructor.courses.create') }}" 
           class="inline-flex items-center gap-2 bg-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-lime hover:text-primary">
            <i class="fas fa-plus"></i>
            <span>আপনার প্রথম কোর্স তৈরি করুন</span>
        </a>
    </div>
    @endif

    <!-- Pagination -->
    @if ($courses->hasPages())
    <div class="bg-card rounded-xl p-6 shadow-2 theme-shadow">
        <div class="flex justify-center">
            <div class="pagination-wrapper">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter dropdown functionality
    const filterBtn = document.getElementById('filterDropdownBtn');
    const filterDropdown = document.getElementById('filterDropdown');
    const filterText = document.getElementById('filterText');
    const statusInput = document.getElementById('statusInput');
    const form = document.getElementById('courseFilterForm');
    
    // Set initial filter text based on current status
    const currentStatus = new URLSearchParams(window.location.search).get('status');
    const filterLabels = {
        'best_rated': 'সর্বোচ্চ রেটিং',
        'most_purchased': 'সর্বাধিক বিক্রিত',
        'newest': 'সর্বশেষ',
        'oldest': 'পুরাতন'
    };
    
    if (currentStatus && filterLabels[currentStatus]) {
        filterText.textContent = filterLabels[currentStatus];
        statusInput.value = currentStatus;
    }

    // Toggle filter dropdown
    filterBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        filterDropdown.classList.toggle('hidden');
    });

    // Handle filter item clicks
    document.querySelectorAll('.filter-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const value = this.getAttribute('data-value');
            const text = this.textContent.trim();
            
            filterText.textContent = text;
            statusInput.value = value;
            filterDropdown.classList.add('hidden');
            form.submit();
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
        filterDropdown.classList.add('hidden');
        document.querySelectorAll('.more-actions-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Course card hover effects
    document.querySelectorAll('.course-card').forEach(card => {
        const actions = card.querySelector('.course-actions');
        
        card.addEventListener('mouseenter', function() {
            if (actions) actions.style.opacity = '1';
        });
        
        card.addEventListener('mouseleave', function() {
            if (actions) actions.style.opacity = '0';
        });
    });

    // More actions dropdown
    document.querySelectorAll('.more-actions-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            
            // Close all other menus
            document.querySelectorAll('.more-actions-menu').forEach(otherMenu => {
                if (otherMenu !== menu) {
                    otherMenu.classList.add('hidden');
                }
            });
            
            menu.classList.toggle('hidden');
        });
    });

    // Search on Enter key
    const searchInput = document.querySelector('input[name="title"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                form.submit();
            }
        });
    }

    // Loading state for search button
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>অনুসন্ধান করা হচ্ছে...';
        submitBtn.disabled = true;
        
        // Reset after 3 seconds to prevent permanent loading state
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>
@endsection