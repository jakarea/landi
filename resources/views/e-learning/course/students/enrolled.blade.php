@extends('layouts/student-modern')
@section('title')
    My Courses
@endsection

@php
    use Illuminate\Support\Str;
@endphp
{{-- page style @S --}}
@section('style')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        200: '#bfdbfe',
                        300: '#93c5fd',
                        400: '#60a5fa',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8',
                        800: '#1e40af',
                        900: '#1e3a8a',
                        950: '#172554',
                    },
                    dark: {
                        50: '#f8fafc',
                        100: '#f1f5f9',
                        200: '#e2e8f0',
                        300: '#cbd5e1',
                        400: '#94a3b8',
                        500: '#64748b',
                        600: '#475569',
                        700: '#334155',
                        800: '#1e293b',
                        900: '#0f172a',
                        950: '#020617',
                    }
                }
            }
        }
    }
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    .font-inter { font-family: 'Inter', sans-serif; }
    
    .ray-hover {
        position: relative;
        overflow: hidden;
    }
    
    .ray-hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .ray-hover:hover::before {
        left: 100%;
    }
    
    .glow-card {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
        transition: all 0.3s ease;
    }
    
    .glow-card:hover {
        box-shadow: 0 0 30px rgba(59, 130, 246, 0.25);
        transform: translateY(-2px);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .dark .glass-effect {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .course-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .dark .course-card {
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .course-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .dark .course-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<div class="p-6 max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                আমার কোর্সসমূহ
                            </h1>
                            <p class="text-slate-600 dark:text-slate-400 mt-2">আপনার এনরোল করা সমস্ত কোর্স এখানে দেখুন</p>
                        </div>
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="mb-8">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <form action="" method="GET" id="myForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                            <!-- Search Input -->
                            <div class="xl:col-span-2">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-slate-400"></i>
                                    </div>
                                    <input autocomplete="off" type="text" placeholder="কোর্স অনুসন্ধান করুন" 
                                           class="w-full pl-10 pr-4 py-3 bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-300"
                                           name="title" value="{{ request('title') }}">
                                </div>
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <select name="category" class="w-full py-3 px-4 bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white transition-all duration-300">
                                    <option value="">সব ক্যাটেগরি</option>
                                    @if(isset($availableCategories))
                                        @foreach($availableCategories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <!-- Instructor Filter -->
                            <div>
                                <select name="instructor" class="w-full py-3 px-4 bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white transition-all duration-300">
                                    <option value="">সব ইনস্ট্রাক্টর</option>
                                    @if(isset($availableInstructors))
                                        @foreach($availableInstructors as $instructorName)
                                            <option value="{{ $instructorName }}" {{ request('instructor') == $instructorName ? 'selected' : '' }}>
                                                {{ $instructorName }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <!-- Progress Filter -->
                            <div>
                                <select name="progress" class="w-full py-3 px-4 bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white transition-all duration-300">
                                    <option value="">সব অগ্রগতি</option>
                                    <option value="not_started" {{ request('progress') == 'not_started' ? 'selected' : '' }}>শুরু হয়নি</option>
                                    <option value="in_progress" {{ request('progress') == 'in_progress' ? 'selected' : '' }}>চলমান</option>
                                    <option value="completed" {{ request('progress') == 'completed' ? 'selected' : '' }}>সমাপ্ত</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Sort Dropdown -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                            <div class="relative">
                                <select name="status" id="statusSelect" class="w-full py-3 px-4 bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white transition-all duration-300 appearance-none">
                                    <option value="">সব</option>
                                    <option value="best_rated" {{ request('status') == 'best_rated' ? 'selected' : '' }}>সর্বোচ্চ রেটেড</option>
                                    <option value="most_purchased" {{ request('status') == 'most_purchased' ? 'selected' : '' }}>সর্বাধিক ক্রয়</option>
                                    <option value="newest" {{ request('status') == 'newest' ? 'selected' : '' }}>সর্বশেষ</option>
                                    <option value="recently_accessed" {{ request('status') == 'recently_accessed' ? 'selected' : '' }}>সাম্প্রতিক অ্যাক্সেস</option>
                                    <option value="oldest" {{ request('status') == 'oldest' ? 'selected' : '' }}>পুরাতন</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400"></i>
                                </div>
                                <input type="hidden" name="status" id="inputField" value="{{ request('status') }}">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex flex-wrap gap-3">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
                                    <i class="fas fa-search mr-2"></i>ফিল্টার প্রয়োগ
                                </button>
                                <a href="{{ route('student.courses') }}" class="inline-flex items-center px-6 py-3 bg-white/50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 font-medium rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-300 ray-hover">
                                    <i class="fas fa-refresh mr-2"></i>রিসেট
                                </a>
                            </div>
                            <a href="{{ url('student/courses-activies/list') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-medium rounded-xl hover:from-green-600 hover:to-teal-700 transition-all duration-300 ray-hover">
                                <i class="fas fa-chart-line mr-2"></i>কোর্স কার্যকলাপ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @if (count($enrolments) > 0)
                    @foreach ($enrolments as $enrolment)
                        {{-- course single box start --}}
                        @if ($enrolment->course)
                        @php
                            $review_sum = 0;
                            $review_avg = 0;
                            $total = 0;
                            foreach ($enrolment->course->reviews as $review) {
                                $total++;
                                $review_sum += $review->star;
                            }
                            if ($total) {
                                $review_avg = $review_sum / $total;
                            }
                        @endphp
                        
                        <div class="course-card rounded-2xl overflow-hidden ray-hover glow-card">
                            <!-- Course Thumbnail -->
                            <div class="relative">
                                <img src="{{ asset($enrolment->course->thumbnail) }}"
                                     alt="{{ $enrolment->course->slug }}" 
                                     class="w-full h-48 object-cover">
                                
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($enrolment->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                            <i class="fas fa-clock mr-1"></i> অনুমোদনের অপেক্ষায়
                                        </span>
                                    @elseif($enrolment->status == 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            <i class="fas fa-check-circle mr-1"></i> অনুমোদিত
                                        </span>
                                    @elseif($enrolment->status == 'payment_pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400">
                                            <i class="fas fa-credit-card mr-1"></i> পেমেন্ট ভেরিফিকেশন
                                        </span>
                                    @elseif($enrolment->status == 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            <i class="fas fa-times-circle mr-1"></i> প্রত্যাখ্যাত
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Play Button Overlay -->
                                @if($enrolment->status == 'approved')
                                <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                    <a href="{{ url('student/courses/' . $enrolment->course->slug) }}" 
                                       class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center text-blue-600 hover:scale-110 transition-all duration-300">
                                        <i class="fas fa-play ml-1"></i>
                                    </a>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Course Content -->
                            <div class="p-6">
                                <!-- Rating -->
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review_avg)
                                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                                            @else
                                                <i class="fas fa-star text-slate-300 dark:text-slate-600 text-sm"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300 ml-2">{{ number_format($review_avg, 1) }}</span>
                                    <span class="text-sm text-slate-500 dark:text-slate-400">({{ $total }})</span>
                                </div>
                                
                                <!-- Course Title -->
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <a href="{{ url('student/courses/' . $enrolment->course->slug) }}">
                                        {{ Str::limit($enrolment->course->title, 50) }}
                                    </a>
                                </h3>
                                
                                <!-- Course Description -->
                                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                                    {{ Str::limit(strip_tags($enrolment->course->short_description), 80, '...') }}
                                </p>
                                
                                <!-- Course Footer -->
                                @if($enrolment->status == 'approved')
                                    <!-- Progress Section -->
                                    @php
                                        $progress = StudentActitviesProgress(auth()->user()->id, $enrolment->course->id);
                                    @endphp
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">অগ্রগতি</span>
                                            <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $progress == 100 ? 'bg-gradient-to-r from-green-500 to-green-600' : 'bg-gradient-to-r from-blue-500 to-purple-600' }}" 
                                                 style="width: {{ $progress }}%"></div>
                                        </div>
                                        @if ($progress == 100)
                                            <div class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                                                <i class="fas fa-check-circle mr-2"></i>সম্পন্ন
                                            </div>
                                        @endif
                                    </div>
                                @elseif($enrolment->status == 'pending')
                                    <!-- Pending Status -->
                                    <div class="flex items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                        <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/40 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-hourglass-half text-yellow-600 dark:text-yellow-400"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-yellow-800 dark:text-yellow-300 text-sm">অনুমোদনের অপেক্ষায়</div>
                                            <div class="text-yellow-600 dark:text-yellow-400 text-xs">ইনস্ট্রাক্টর শীঘ্রই অনুমোদন করবেন</div>
                                        </div>
                                    </div>
                                @elseif($enrolment->status == 'payment_pending')
                                    <!-- Payment Pending -->
                                    <div class="flex items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl">
                                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/40 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-credit-card text-orange-600 dark:text-orange-400"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-orange-800 dark:text-orange-300 text-sm">পেমেন্ট ভেরিফিকেশন</div>
                                            <div class="text-orange-600 dark:text-orange-400 text-xs">পেমেন্ট যাচাই করা হচ্ছে</div>
                                        </div>
                                    </div>
                                @elseif($enrolment->status == 'rejected')
                                    <!-- Rejected Status -->
                                    <div class="space-y-3">
                                        <div class="flex items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/40 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-times-circle text-red-600 dark:text-red-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-red-800 dark:text-red-300 text-sm">আবেদন প্রত্যাখ্যাত</div>
                                                <div class="text-red-600 dark:text-red-400 text-xs">
                                                    @if(isset($enrolment->rejection_reason) && $enrolment->rejection_reason)
                                                        কারণ: {{ $enrolment->rejection_reason }}
                                                    @else
                                                        বিস্তারিত জানতে ইনস্ট্রাক্টরের সাথে যোগাযোগ করুন
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ url('courses/'.$enrolment->course->slug) }}"
                                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 ray-hover">
                                            <i class="fas fa-eye mr-2"></i>কোর্স বিস্তারিত দেখুন
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        {{-- course single box end --}}
                    @endforeach
                @else
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-graduation-cap text-white text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-slate-600 dark:text-slate-400 mb-3">কোন কোর্সে নথিভুক্ত নেই</h3>
                        <p class="text-slate-500 dark:text-slate-500 mb-6 max-w-md mx-auto">আপনার প্রথম কোর্সে নথিভুক্ত হয়ে শেখার যাত্রা শুরু করুন</p>
                        <a href="{{ url('/courses/') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
                            <i class="fas fa-search mr-2"></i>কোর্স খুঁজুন
                        </a>
                    </div>
                @endif
            </div>
            <!-- Pagination -->
            @if (count($enrolments) > 0)
            <div class="flex justify-center">
                <div class="glass-effect rounded-2xl p-4 ray-hover glow-card">
                    {{ $enrolments->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
</div>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script>
    // Initialize dark mode - default is dark mode as per instructions
    document.documentElement.classList.add('dark');
    
    // Dark mode toggle functionality
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
    }
    
    // Initialize from localStorage or default to dark
    if (localStorage.getItem('darkMode') === null) {
        localStorage.setItem('darkMode', 'true');
    }
    
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    
    
    document.addEventListener("DOMContentLoaded", function() {
        let inputField = document.getElementById("inputField");
        let statusSelect = document.getElementById("statusSelect");
        let form = document.getElementById("myForm");
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let status = urlParams.get('status');

        // Set initial value
        if (status) {
            inputField.value = status;
            statusSelect.value = status;
        }

        // Handle status select change
        statusSelect.addEventListener("change", function() {
            inputField.value = this.value;
            form.submit();
        });
        
        // Confirmation prompts for delete buttons
        const deleteButtons = document.querySelectorAll('button[type="submit"]');
        deleteButtons.forEach(button => {
            const buttonText = button.textContent.trim();
            if (buttonText.includes('অপছন্দ') || buttonText.includes('Delete') || buttonText.includes('delete')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('আপনি কি নিশ্চিত যে এই কার্যক্রমটি সম্পাদন করতে চান?')) {
                        this.closest('form').submit();
                    }
                });
            }
        });
        
        // Add smooth hover animations to all ray-hover elements
        const rayHoverElements = document.querySelectorAll('.ray-hover');
        rayHoverElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });
</script>
@endsection
{{-- page script @E --}}
