@extends('layouts.instructor-tailwind')
@section('title', $liveClass->title . ' - লাইভ ক্লাস')
@section('header-title', 'লাইভ ক্লাস')
@section('header-subtitle', $liveClass->title)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $liveClass->title }}</h1>
            <p class="text-secondary-200 mt-1">{{ $liveClass->course->title }}</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($liveClass->canStart(auth()->id()))
                <form action="{{ route('instructor.live-classes.start', $liveClass) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors ray-hover">
                        <i class="fas fa-play mr-2"></i>
                        ক্লাস শুরু করুন
                    </button>
                </form>
            @endif

            @if($liveClass->status === 'scheduled')
                <a href="{{ route('instructor.live-classes.edit', $liveClass) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors ray-hover">
                    <i class="fas fa-edit mr-2"></i>
                    সম্পাদনা করুন
                </a>
            @endif

            <a href="{{ route('instructor.live-classes.index') }}" 
               class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-medium transition-colors ray-hover">
                <i class="fas fa-arrow-left mr-2"></i>
                ফিরে যান
            </a>
        </div>
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
            <!-- Class Details Card -->
            <div class="glass-effect rounded-xl border border-white/20 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-white">ক্লাসের বিবরণ</h2>
                    <div>
                        @if($liveClass->status === 'scheduled')
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm">
                                {{ $liveClass->status_bangla }}
                            </span>
                        @elseif($liveClass->status === 'live')
                            <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-sm animate-pulse">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{ $liveClass->status_bangla }}
                            </span>
                        @elseif($liveClass->status === 'ended')
                            <span class="bg-gray-500/20 text-gray-400 px-3 py-1 rounded-full text-sm">
                                {{ $liveClass->status_bangla }}
                            </span>
                        @else
                            <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-sm">
                                {{ $liveClass->status_bangla }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    @if($liveClass->description)
                        <div>
                            <p class="text-secondary-200 whitespace-pre-line">{{ $liveClass->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-secondary-200">
                                <i class="fas fa-calendar-alt text-blue mr-3"></i>
                                <div>
                                    <p class="text-sm text-secondary-300">শুরুর সময়</p>
                                    <p class="text-white font-medium">{{ $liveClass->start_time_bangla }}</p>
                                </div>
                            </div>

                            <div class="flex items-center text-secondary-200">
                                <i class="fas fa-clock text-blue mr-3"></i>
                                <div>
                                    <p class="text-sm text-secondary-300">সময়কাল</p>
                                    <p class="text-white font-medium">{{ $liveClass->duration_human }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center text-secondary-200">
                                <i class="fas fa-book text-blue mr-3"></i>
                                <div>
                                    <p class="text-sm text-secondary-300">কোর্স</p>
                                    <p class="text-white font-medium">{{ $liveClass->course->title }}</p>
                                </div>
                            </div>

                            @if($liveClass->is_upcoming)
                                <div class="flex items-center text-secondary-200">
                                    <i class="fas fa-hourglass-half text-yellow-400 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-secondary-300">অবশিষ্ট সময়</p>
                                        <p class="text-yellow-400 font-medium">{{ $liveClass->time_until_start }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zoom Integration Card -->
            @if($liveClass->zoom_meeting_id)
                <div class="glass-effect rounded-xl border border-white/20 p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <i class="fas fa-video text-blue mr-3"></i>
                        Zoom মিটিং তথ্য
                    </h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white/5 rounded-lg p-4">
                                <p class="text-secondary-300 text-sm mb-1">মিটিং ID</p>
                                <p class="text-white font-mono">{{ $liveClass->zoom_meeting_id }}</p>
                            </div>

                            @if($liveClass->zoom_password)
                                <div class="bg-white/5 rounded-lg p-4">
                                    <p class="text-secondary-300 text-sm mb-1">পাসওয়ার্ড</p>
                                    <p class="text-white font-mono">{{ $liveClass->zoom_password }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            @if($liveClass->zoom_start_url)
                                <a href="{{ $liveClass->zoom_start_url }}" 
                                   target="_blank"
                                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors ray-hover flex items-center justify-center">
                                    <i class="fas fa-play mr-2"></i>
                                    হোস্ট হিসেবে যোগ দিন
                                </a>
                            @endif

                            @if($liveClass->zoom_join_url)
                                <a href="{{ $liveClass->zoom_join_url }}" 
                                   target="_blank"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors ray-hover flex items-center justify-center">
                                    <i class="fas fa-users mr-2"></i>
                                    পার্টিসিপেন্ট লিংক
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="glass-effect rounded-xl border border-white/20 p-6">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-3xl mb-4"></i>
                        <h3 class="text-lg font-semibold text-white mb-2">Zoom মিটিং তৈরি হয়নি</h3>
                        <p class="text-secondary-300">এই ক্লাসের জন্য এখনও Zoom মিটিং তৈরি হয়নি। API কনফিগারেশন চেক করুন।</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="glass-effect rounded-xl border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">দ্রুত অ্যাকশন</h3>
                <div class="space-y-3">
                    @if($liveClass->canStart(auth()->id()))
                        <form action="{{ route('instructor.live-classes.start', $liveClass) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors ray-hover">
                                <i class="fas fa-play mr-2"></i>
                                ক্লাস শুরু করুন
                            </button>
                        </form>
                    @endif

                    @if($liveClass->status === 'scheduled')
                        <a href="{{ route('instructor.live-classes.edit', $liveClass) }}" 
                           class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-lg font-medium transition-colors ray-hover flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            সম্পাদনা করুন
                        </a>

                        <form action="{{ route('instructor.live-classes.destroy', $liveClass) }}" 
                              method="POST" class="w-full" 
                              onsubmit="return confirm('আপনি কি নিশ্চিত যে এই লাইভ ক্লাসটি মুছে ফেলতে চান?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium transition-colors ray-hover">
                                <i class="fas fa-trash mr-2"></i>
                                ক্লাস মুছে ফেলুন
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('instructor.courses.show', $liveClass->course->slug) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors ray-hover flex items-center justify-center">
                        <i class="fas fa-book mr-2"></i>
                        কোর্স দেখুন
                    </a>
                </div>
            </div>

            <!-- Course Info -->
            <div class="glass-effect rounded-xl border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">সংশ্লিষ্ট কোর্স</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-secondary-300 text-sm">কোর্সের নাম</p>
                        <p class="text-white font-medium">{{ $liveClass->course->title }}</p>
                    </div>
                    
                    @if($liveClass->course->enrolled_students_count)
                        <div>
                            <p class="text-secondary-300 text-sm">মোট স্টুডেন্ট</p>
                            <p class="text-blue font-medium">{{ $liveClass->course->enrolled_students_count }} জন</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tips -->
            <div class="glass-effect rounded-xl border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">টিপস</h3>
                <div class="space-y-3 text-sm text-secondary-300">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-400 mr-3 mt-1"></i>
                        <p>ক্লাস শুরুর ১০-১৫ মিনিট আগে প্রস্তুতি নিন।</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-microphone text-blue mr-3 mt-1"></i>
                        <p>ভাল অডিও ও ভিডিও কোয়ালিটি নিশ্চিত করুন।</p>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-wifi text-green-400 mr-3 mt-1"></i>
                        <p>স্থিতিশীল ইন্টারনেট কানেকশন ব্যবহার করুন।</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection