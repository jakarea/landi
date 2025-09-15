@extends('layouts.student-modern')
@section('title', $liveClass->title . ' - লাইভ ক্লাস')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400 mb-2">
                <a href="{{ route('student.live-classes.index') }}" class="hover:text-blue-500">লাইভ ক্লাস</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-700 dark:text-slate-300">{{ $liveClass->title }}</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $liveClass->title }}</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $liveClass->course->title }}</p>
        </div>
        <a href="{{ route('student.live-classes.index') }}" 
           class="bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-6 py-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors ray-hover">
            <i class="fas fa-arrow-left mr-2"></i>
            ফিরে যান
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-xl">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-xl">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="glass-effect rounded-xl p-6 border border-white/20">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">ক্লাসের তথ্য</h2>
                    <div>
                        @if($liveClass->status === 'scheduled')
                            @if($liveClass->is_upcoming)
                                <span class="bg-blue-500/20 text-blue-600 dark:text-blue-400 px-4 py-2 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $liveClass->time_until_start }}
                                </span>
                            @endif
                        @elseif($liveClass->status === 'live')
                            <span class="bg-red-500/20 text-red-500 px-4 py-2 rounded-full text-sm font-medium animate-pulse">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                এখন লাইভ
                            </span>
                        @elseif($liveClass->status === 'ended')
                            <span class="bg-slate-500/20 text-slate-500 px-4 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-check mr-2"></i>
                                সম্পন্ন
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Live Class Action Button -->
                @if($liveClass->canJoin(auth()->id()))
                    @if($liveClass->is_live)
                        <div class="bg-gradient-to-r from-red-500 to-pink-500 p-6 rounded-xl text-white text-center mb-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="animate-pulse">
                                    <i class="fas fa-broadcast-tower text-3xl"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2">ক্লাস এখন লাইভ!</h3>
                            <p class="text-red-100 mb-6">এখনই যোগ দিন এবং শেখা শুরু করুন</p>
                            <form action="{{ route('student.live-classes.join', $liveClass) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-white text-red-500 hover:bg-red-50 px-8 py-4 rounded-xl font-bold text-lg transition-colors ray-hover">
                                    <i class="fas fa-video mr-2"></i>
                                    এখনই যোগ দিন
                                </button>
                            </form>
                        </div>
                    @elseif($liveClass->is_upcoming)
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-6 rounded-xl text-white text-center mb-6">
                            <div class="flex items-center justify-center mb-4">
                                <i class="fas fa-clock text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">ক্লাস শুরু হবে শীঘ্রই</h3>
                            <p class="text-blue-100 mb-4">{{ $liveClass->time_until_start }}</p>
                            <div class="bg-white/20 text-white px-6 py-3 rounded-xl font-medium">
                                <i class="fas fa-bell mr-2"></i>
                                আমরা আপনাকে জানিয়ে দেব
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-gradient-to-r from-slate-400 to-slate-500 p-6 rounded-xl text-white text-center mb-6">
                        <div class="flex items-center justify-center mb-4">
                            <i class="fas fa-lock text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">কোর্সে ভর্তি প্রয়োজন</h3>
                        <p class="text-slate-100 mb-6">এই লাইভ ক্লাসে অংশগ্রহণ করতে প্রথমে কোর্সে ভর্তি হন</p>
                        <a href="{{ route('student.courses.show', $liveClass->course->slug) }}" 
                           class="bg-white text-slate-500 hover:bg-slate-50 px-8 py-4 rounded-xl font-bold text-lg transition-colors ray-hover inline-block">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            কোর্স দেখুন
                        </a>
                    </div>
                @endif

                <!-- Class Description -->
                @if($liveClass->description)
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">বিবরণ</h4>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            <p class="text-slate-600 dark:text-slate-300 whitespace-pre-line">{{ $liveClass->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Class Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center text-slate-600 dark:text-slate-300">
                            <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">শুরুর সময়</p>
                                <p class="font-medium">{{ $liveClass->start_time_bangla }}</p>
                            </div>
                        </div>

                        <div class="flex items-center text-slate-600 dark:text-slate-300">
                            <i class="fas fa-clock text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">সময়কাল</p>
                                <p class="font-medium">{{ $liveClass->duration_human }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center text-slate-600 dark:text-slate-300">
                            <i class="fas fa-book text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">কোর্স</p>
                                <p class="font-medium">{{ $liveClass->course->title }}</p>
                            </div>
                        </div>

                        <div class="flex items-center text-slate-600 dark:text-slate-300">
                            <i class="fas fa-user-tie text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-slate-500 dark:text-slate-400">ইনস্ট্রাক্টর</p>
                                <p class="font-medium">{{ $liveClass->instructor->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meeting Information (for enrolled students) -->
            @if($liveClass->canJoin(auth()->id()) && $liveClass->zoom_meeting_id)
                <div class="glass-effect rounded-xl p-6 border border-white/20">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">
                        <i class="fas fa-video text-blue-500 mr-2"></i>
                        মিটিং তথ্য
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4">
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">মিটিং ID</p>
                            <p class="font-mono text-slate-900 dark:text-white">{{ $liveClass->zoom_meeting_id }}</p>
                        </div>

                        @if($liveClass->zoom_password)
                            <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4">
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">পাসওয়ার্ড</p>
                                <p class="font-mono text-slate-900 dark:text-white">{{ $liveClass->zoom_password }}</p>
                            </div>
                        @endif
                    </div>

                    @if($liveClass->zoom_join_url && ($liveClass->is_live || $liveClass->start_time->diffInMinutes(now(), false) <= 10))
                        <a href="{{ $liveClass->zoom_join_url }}" 
                           target="_blank"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors ray-hover inline-flex items-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Zoom-এ যোগ দিন
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="glass-effect rounded-xl p-6 border border-white/20">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">দ্রুত তথ্য</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-300">স্ট্যাটাস</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $liveClass->status_bangla }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-300">সময়কাল</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $liveClass->duration_human }}</span>
                    </div>
                    @if($liveClass->is_upcoming)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-slate-300">বাকি সময়</span>
                            <span class="font-medium text-blue-600 dark:text-blue-400">{{ $liveClass->time_until_start }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Information -->
            <div class="glass-effect rounded-xl p-6 border border-white/20">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">সংশ্লিষ্ট কোর্স</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">কোর্সের নাম</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $liveClass->course->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">ইনস্ট্রাক্টর</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $liveClass->instructor->name }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('student.courses.show', $liveClass->course->slug) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors ray-hover flex items-center justify-center">
                        <i class="fas fa-book mr-2"></i>
                        কোর্স দেখুন
                    </a>
                </div>
            </div>

            <!-- Tips -->
            <div class="glass-effect rounded-xl p-6 border border-white/20">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">টিপস</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 mr-3 mt-1"></i>
                        <p class="text-slate-600 dark:text-slate-300">ক্লাস শুরুর ১০ মিনিট আগে প্রস্তুত থাকুন।</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-headphones text-blue-500 mr-3 mt-1"></i>
                        <p class="text-slate-600 dark:text-slate-300">ভাল অডিও শোনার জন্য হেডফোন ব্যবহার করুন।</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-wifi text-green-500 mr-3 mt-1"></i>
                        <p class="text-slate-600 dark:text-slate-300">স্থিতিশীল ইন্টারনেট কানেকশন নিশ্চিত করুন।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($liveClass->canJoin(auth()->id()) && $liveClass->is_upcoming && $liveClass->start_time->diffInMinutes(now(), false) <= 60)
<script>
// Auto-refresh to check if class has started
setInterval(function() {
    const now = new Date();
    const classStart = new Date('{{ $liveClass->start_time->toISOString() }}');
    
    if (now >= classStart) {
        location.reload();
    }
}, 30000); // Check every 30 seconds if within 1 hour of start time
</script>
@endif
@endsection