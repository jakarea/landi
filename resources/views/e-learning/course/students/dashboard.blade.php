@extends('layouts/student-modern')
@section('title')
শিক্ষার্থী ড্যাশবোর্ড
@endsection

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
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.8s ease-in-out;
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
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<div class="p-6 max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="mb-8">
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            বার্ষিক বিশ্লেষণ
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 mt-2">আপনার শিক্ষার যাত্রার পূর্ণ চিত্র</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-play text-white text-sm"></i>
                    </div>
                    @php
                        $progPercentage = 0;
                        $totalCoureses = count($enrolments);
                        if($totalCoureses> 0 && $inProgressCount > 0)
                            $progPercentage = ($inProgressCount / $totalCoureses) * 100;
                    @endphp
                    <div class="flex items-center text-green-500 text-sm font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{number_format(abs($progPercentage), 2)}}%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-1">{{ $inProgressCount }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm">চলমান কোর্স</p>
            </div>

            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    @php
                        $cmpltPercentage = 0;
                        $totalCoureses = count($enrolments);
                        if($totalCoureses> 0 && $completedCount > 0)
                        $cmpltPercentage = ($completedCount / $totalCoureses) * 100;
                    @endphp
                    <div class="flex items-center text-green-500 text-sm font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ number_format(abs($cmpltPercentage), 2) }}%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-1">{{ $completedCount }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm">সম্পন্ন কোর্স</p>
            </div>

            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <div class="flex items-center {{ $percentageChange >= 0 ? 'text-green-500' : 'text-red-500' }} text-sm font-medium">
                        <i class="fas fa-arrow-{{ $percentageChange >= 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ number_format(abs($percentageChange), 2) }}%
                    </div>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-1">{{ $totalHours }}ঘ {{ $totalMinutes }}মি</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm">মোট দেখার সময়</p>
            </div>

            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-certificate text-white text-sm"></i>
                    </div>
                    @php
                        $cmpltPercentage = 0;
                        $totalCoureses = count($enrolments);
                        if($totalCoureses> 0 && $completedCount > 0)
                        $cmpltPercentage = ($completedCount / $totalCoureses) * 100;
                    @endphp
                    <div class="flex items-center text-green-500 text-sm font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ number_format(abs($cmpltPercentage), 2) }}%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-1">{{ $completedCount}}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm">সার্টিফিকেট অর্জন</p>
            </div>
        </div>
        <!-- Chart and Profile Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Time Spending Chart -->
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white">সময় ব্যয়</h3>
                            <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mt-1">
                                {{ $totalHours }}<span class="text-lg text-slate-500"> ঘণ্টা</span> {{ $totalMinutes }}<span class="text-lg text-slate-500"> মিনিট</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-area text-white"></i>
                        </div>
                    </div>
                    <div id="timeSpendingChart"></div>
                </div>
            </div>
            
            <!-- Profile Widget -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">আমার প্রোফাইল</h3>
                        <a href="{{ url('student/profile/myprofile') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium transition-colors">
                            প্রোফাইল দেখুন
                        </a>
                    </div>
                    
                    <div class="text-center mb-6">
                        @if (auth()->user()->avatar)
                        <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                            class="w-20 h-20 rounded-full mx-auto border-4 border-gradient-to-r from-blue-500 to-purple-600 object-cover">
                        @else
                        <div class="w-20 h-20 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                            {!! strtoupper(auth()->user()->name[0]) !!}
                        </div>
                        @endif
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-white mt-3">{{ auth()->user()->name }}</h4>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-trophy text-white"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800 dark:text-white">{{ $completedCount + 1 }}</h5>
                            <p class="text-slate-600 dark:text-slate-400 text-xs">র‍্যাঙ্ক</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800 dark:text-white">{{ $total_hr }}ঘ:{{ $total_min }}মি</h5>
                            <p class="text-slate-600 dark:text-slate-400 text-xs">গড় সময়</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800 dark:text-white">{{ $enrolled }}</h5>
                            <p class="text-slate-600 dark:text-slate-400 text-xs">নথিভুক্ত</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Liked Courses and Course Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Liked Courses -->
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">পছন্দের কোর্সসমূহ</h3>
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-red-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heart text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @if (count($likeCourses) > 0)
                        @foreach ($likeCourses as $likeCourse)
                        @php
                            $totalLessons = 0;
                            $course = $likeCourse->course;

                            if ($course && $course->modules) {
                                foreach ($course->modules as $module) {
                                    if ($module && $module->lessons) {
                                        $totalLessons += count($module->lessons);
                                    }
                                }
                            }
                        @endphp

                        <div class="flex items-center p-4 bg-white/50 dark:bg-slate-800/50 rounded-xl hover:bg-white/70 dark:hover:bg-slate-800/70 transition-all duration-300 ray-hover group">
                            <div class="flex-shrink-0">
                                @if ($likeCourse->course && $likeCourse->course->thumbnail)
                                <img src="{{ asset($likeCourse->course->thumbnail) }}" alt="Course thumbnail" 
                                     class="w-16 h-16 rounded-lg object-cover">
                                @else
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex-grow ml-4">
                                <h5 class="font-semibold text-slate-800 dark:text-white mb-1 hover:text-blue-600 transition-colors">
                                    <a href="{{ url('student/courses/overview/' . $likeCourse->course->slug) }}">
                                        {{ optional($likeCourse->course)->title }}
                                    </a>
                                </h5>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">
                                    <i class="fas fa-user mr-1"></i>{{ optional($likeCourse->course->user)->name }} - {{ optional($likeCourse->course)->platform }}
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-slate-500">
                                    <span class="flex items-center">
                                        <i class="fas fa-layer-group mr-1"></i>{{ count($likeCourse->course->modules) }} Modules
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-play-circle mr-1"></i>{{ $totalLessons }} Lessons
                                    </span>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <button class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu bg-white dark:bg-slate-800 rounded-lg shadow-lg border dark:border-slate-700">
                                    <form action="{{ route('student.courses.unlike', $likeCourse->course->slug) }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <i class="fas fa-heart-broken mr-2"></i>অপছন্দ
                                        </button>
                                    </form>
                                    <a href="{{ url('student/courses/'.$likeCourse->course->slug) }}" class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                        <i class="fas fa-play mr-2"></i>শুরু করুন
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-heart text-white text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-400 mb-2">কোন পছন্দের কোর্স নেই</h3>
                            <p class="text-slate-500 dark:text-slate-500">আপনার পছন্দের কোর্স যোগ করুন</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Course Statistics -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-2xl p-6 ray-hover glow-card h-full min-h-[400px] flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">কোর্সের পরিসংখ্যান</h3>
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-white text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h4 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ count($enrolments) }}
                        </h4>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">মোট কোর্স</p>
                    </div>
                    
                    <div class="relative flex-1 flex flex-col justify-center">
                        <div class="w-48 h-48 mx-auto mb-4">
                            <canvas id="myCourseStatics" class="max-w-full max-h-full"></canvas>
                        </div>
                        <div id="legend" class="space-y-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Status Table -->
        <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">কোর্সের অবস্থা</h3>
                @if (count($enrolments) > 3)
                <a href="{{ url('student/dashboard/enrolled') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    সব দেখুন <i class="fas fa-arrow-right ml-1"></i>
                </a>
                @endif
            </div>
            
            @if (count($enrolments) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">কোর্সের নাম</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">মূল্য</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">অগ্রগতি</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">শুরুর তারিখ</th>
                            <th class="text-right py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach ($enrolments->slice(0, 4) as $enrolment)
                        @if ($enrolment->course)
                        <tr class="hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset($enrolment->course->thumbnail) }}" alt="Course thumbnail"
                                        class="w-12 h-12 rounded-lg object-cover">
                                    <div>
                                        <h5 class="font-semibold text-slate-800 dark:text-white text-sm mb-1">
                                            <a href="{{ url('student/courses/my-courses/details/' . $enrolment->course->slug) }}" 
                                               class="hover:text-blue-600 transition-colors">
                                                {{$enrolment->course->title}}
                                            </a>
                                        </h5>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">{{ $enrolment->course->platform }}</p>
                                        @if($enrolment->status == 'pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                                <i class="fas fa-clock mr-1"></i> অনুমোদনের অপেক্ষায়
                                            </span>
                                        @elseif($enrolment->status == 'approved')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                <i class="fas fa-check-circle mr-1"></i> অনুমোদিত
                                            </span>
                                        @elseif($enrolment->status == 'payment_pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                                <i class="fas fa-credit-card mr-1"></i> পেমেন্ট অপেক্ষায়
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-semibold text-slate-800 dark:text-white">৳ {{$enrolment->amount}}</p>
                            </td>
                            @php
                            $courseProgress = null;
                            $courseProgress = StudentActitviesProgress(auth()->user()->id, $enrolment->course->id);
                            @endphp
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $courseProgress }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ $courseProgress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $enrolment->created_at->format('d-F-Y') }}</p>
                            </td>
                            <td class="py-4 px-4 text-right">
                                @if($enrolment->status == 'approved')
                                    <a href="{{ url('student/courses/'.$enrolment->course->slug) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
                                        <i class="fas fa-play mr-2"></i>শুরু করুন
                                    </a>
                                @elseif($enrolment->status == 'pending')
                                    <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">অনুমোদনের অপেক্ষায়</span>
                                @elseif($enrolment->status == 'payment_pending')
                                    <a href="{{ url('courses/'.$enrolment->course->slug.'/enroll') }}" 
                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-medium rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 ray-hover">
                                        <i class="fas fa-credit-card mr-2"></i>পেমেন্ট সম্পন্ন করুন
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-600 dark:text-slate-400 mb-2">কোন কোর্সে নথিভুক্ত নেই</h3>
                <p class="text-slate-500 dark:text-slate-500 mb-4">আপনার প্রথম কোর্সে নথিভুক্ত হয়ে শেখা শুরু করুন</p>
                <a href="{{ url('/courses/') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 ray-hover">
                    <i class="fas fa-search mr-2"></i>কোর্স খুঁজুন
                </a>
            </div>
            @endif
        </div>
</div>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    
    // Confirmation prompts for delete buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation to all delete/unlike buttons
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
    
    // Legacy mode call for compatibility
    const modess = document.documentElement.classList.contains('dark') ? 'dark-mode' : '';
    if (typeof modeCall === 'function') {
        modeCall(modess);
    }
</script>

{{-- time spend chart start --}}
<script>
    jQuery(document).ready(function() {
            var timeSpentData = @json($timeSpentData);

            var options = {
                series: [{
                    name: "Time spend",
                    data: timeSpentData.map(item => item.time_spent),
                }],
                chart: {
                    height: 280,
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#294CFF'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: timeSpentData.map(item => item.month),
                }
            };
            var chart = new ApexCharts(document.querySelector("#timeSpendingChart"), options);
            chart.render();
        });
</script>
{{-- time spend chart end --}}

{{-- course statics chart start --}}
<script>
    let completedCount = @json($completedCount);
    let notStartedCount = @json($notStartedCount);
    let inProgressCount = @json($inProgressCount);

    var data = [completedCount, inProgressCount, notStartedCount];
    var total = data.reduce((a, b) => a + b, 0);
    var percentages = data.map((value) => ((value / total) * 100).toFixed(0) + "%");

    var ctx = document.getElementById('myCourseStatics').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'সম্পন্ন',
                'চলমান',
                'শুরু হয়নি',
            ],
            datasets: [{
                label: 'কোর্সের অগ্রগতি',
                data: data,
                backgroundColor: [
                    'rgb(34 197 94)',   // Green gradient
                    'rgb(59 130 246)',  // Blue gradient  
                    'rgb(245 158 11)'   // Orange gradient
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            cutout: '70%',
            radius: '85%',
            animation: {
                animateRotate: true,
                duration: 1000,
                easing: 'easeInOutCubic'
            }
        },
    });

    // Create modern legend
    var legendItems = [
        { label: 'সম্পন্ন', color: 'rgb(34 197 94)', count: completedCount },
        { label: 'চলমান', color: 'rgb(59 130 246)', count: inProgressCount },
        { label: 'শুরু হয়নি', color: 'rgb(245 158 11)', count: notStartedCount }
    ];

    var legendHtml = "";
    legendItems.forEach((item, index) => {
        var percentage = percentages[index];
        if (percentage === "NaN%") {
            percentage = "0%";
        }
        legendHtml += `
            <div class="flex items-center justify-between p-3 bg-white/50 dark:bg-slate-800/50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 rounded-full" style="background: ${item.color}"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${item.label}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-bold text-slate-800 dark:text-white">${item.count}</span>
                    <span class="text-xs text-slate-500">(${percentage})</span>
                </div>
            </div>
        `;
    });

    document.getElementById("legend").innerHTML = legendHtml;
</script>
{{-- course statics chart end --}}
@endsection
{{-- page script @E --}}
