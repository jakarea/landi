@extends('layouts.student-modern')
@section('title', 'লাইভ ক্লাস')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">লাইভ ক্লাস</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">আপনার সকল লাইভ ক্লাস দেখুন</p>
        </div>
        <div class="text-sm text-slate-500 dark:text-slate-400">
            <i class="fas fa-sync-alt mr-2"></i>
            <span id="last-updated">এখনই আপডেট হয়েছে</span>
        </div>
    </div>

    <!-- Live Classes Section -->
    @if($liveClasses->count() > 0)
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-xl">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-broadcast-tower text-red-500 text-xl animate-pulse"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-red-800 dark:text-red-200">
                        এখন চলমান ক্লাস ({{ $liveClasses->count() }}টি)
                    </h3>
                    <p class="text-red-600 dark:text-red-300 text-sm">এখনই যোগ দিন এবং শেখা শুরু করুন!</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($liveClasses as $liveClass)
                <div class="glass-effect rounded-xl p-6 border-2 border-red-500/50 bg-gradient-to-br from-red-500/10 to-pink-500/10 animate-pulse-slow">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            লাইভ
                        </span>
                        <div class="text-red-500 text-sm font-medium">
                            {{ $liveClass->duration_human }}
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                        {{ $liveClass->title }}
                    </h3>
                    
                    <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">
                        {{ $liveClass->course->title }}
                    </p>

                    @if($liveClass->description)
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-4 line-clamp-2">
                            {{ $liveClass->description }}
                        </p>
                    @endif

                    <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-user-tie mr-2"></i>
                            {{ $liveClass->instructor->name }}
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            {{ $liveClass->start_time->format('h:i A') }}
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        @if($liveClass->canJoin(auth()->id()))
                            <form action="{{ route('student.live-classes.join', $liveClass) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-300 ray-hover">
                                    <i class="fas fa-video mr-2"></i>
                                    এখনই যোগ দিন
                                </button>
                            </form>
                        @else
                            <div class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-4 py-3 rounded-xl font-medium text-center">
                                <i class="fas fa-lock mr-2"></i>
                                কোর্স কিনুন
                            </div>
                        @endif

                        <a href="{{ route('student.live-classes.show', $liveClass) }}" 
                           class="bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors ray-hover">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Upcoming Classes Section -->
    @if($upcomingClasses->count() > 0)
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                আসছে শীঘ্রই ({{ $upcomingClasses->count() }}টি)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($upcomingClasses as $liveClass)
                    <div class="glass-effect rounded-xl p-6 border border-white/20 hover:border-blue-500/50 transition-all duration-300 ray-hover">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-blue-500/20 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $liveClass->time_until_start }}
                            </span>
                            <div class="text-slate-500 dark:text-slate-400 text-sm">
                                {{ $liveClass->duration_human }}
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                            {{ $liveClass->title }}
                        </h3>
                        
                        <p class="text-slate-600 dark:text-slate-300 text-sm mb-3">
                            {{ $liveClass->course->title }}
                        </p>

                        @if($liveClass->description)
                            <p class="text-slate-500 dark:text-slate-400 text-sm mb-4 line-clamp-2">
                                {{ $liveClass->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                {{ $liveClass->instructor->name }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $liveClass->start_time_bangla }}
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            @if($liveClass->canJoin(auth()->id()))
                                <div class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-4 py-3 rounded-xl font-medium text-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    অপেক্ষা করুন
                                </div>
                            @else
                                <a href="{{ route('student.courses.show', $liveClass->course->slug) }}" 
                                   class="flex-1 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-4 py-3 rounded-xl font-semibold text-center transition-all duration-300 ray-hover">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    কোর্স কিনুন
                                </a>
                            @endif

                            <a href="{{ route('student.live-classes.show', $liveClass) }}" 
                               class="bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 px-4 py-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors ray-hover">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Classes Section -->
    @if($recentClasses->count() > 0)
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <i class="fas fa-history text-slate-500 mr-3"></i>
                সাম্প্রতিক ক্লাস ({{ $recentClasses->count() }}টি)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($recentClasses as $liveClass)
                    <div class="glass-effect rounded-xl p-6 border border-white/20 opacity-75">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-slate-500/20 text-slate-500 dark:text-slate-400 px-3 py-1 rounded-full text-sm">
                                সম্পন্ন
                            </span>
                            <div class="text-slate-500 dark:text-slate-400 text-sm">
                                {{ $liveClass->duration_human }}
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ $liveClass->title }}
                        </h3>
                        
                        <p class="text-slate-500 dark:text-slate-400 text-sm mb-3">
                            {{ $liveClass->course->title }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                {{ $liveClass->instructor->name }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ $liveClass->start_time_bangla }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($liveClasses->count() == 0 && $upcomingClasses->count() == 0 && $recentClasses->count() == 0)
        <div class="text-center py-16">
            <div class="text-slate-400 mb-6">
                <i class="fas fa-video text-6xl opacity-50"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">কোন লাইভ ক্লাস নেই</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md mx-auto">
                আপনি এখনও কোন কোর্সে ভর্তি হননি যেখানে লাইভ ক্লাস রয়েছে। নতুন কোর্স দেখুন এবং শেখা শুরু করুন।
            </p>
            <a href="{{ route('courses') }}" 
               class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 ray-hover inline-flex items-center">
                <i class="fas fa-search mr-2"></i>
                কোর্স খুঁজুন
            </a>
        </div>
    @endif
</div>

<style>
.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}

@keyframes pulse-slow {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.95;
        transform: scale(1.01);
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
// Auto-refresh live classes status
setInterval(function() {
    fetch('{{ route("student.api.live-classes.live") }}')
        .then(response => response.json())
        .then(data => {
            // Update live classes if needed
            document.getElementById('last-updated').textContent = 'এইমাত্র আপডেট হয়েছে';
        })
        .catch(error => {
            console.log('Auto-refresh error:', error);
        });
}, 30000); // Refresh every 30 seconds
</script>
@endsection