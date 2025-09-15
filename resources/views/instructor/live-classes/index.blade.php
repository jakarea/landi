@extends('layouts.instructor-tailwind')
@section('title', 'লাইভ ক্লাস ম্যানেজমেন্ট')
@section('header-title', 'লাইভ ক্লাস')
@section('header-subtitle', 'আপনার লাইভ ক্লাস পরিচালনা করুন')

@php
    use Illuminate\Support\Str;
@endphp
@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">লাইভ ক্লাস ম্যানেজমেন্ট</h1>
            <p class="text-secondary-200 mt-1">আপনার সকল লাইভ ক্লাস দেখুন ও পরিচালনা করুন</p>
        </div>
        <a href="{{ route('instructor.live-classes.create') }}" 
           class="bg-gradient-to-r from-blue to-lime text-primary px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 ray-hover">
            <i class="fas fa-plus mr-2"></i>
            নতুন লাইভ ক্লাস
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

    <!-- Live Classes Table -->
    <div class="glass-effect rounded-xl border border-white/20 overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <h2 class="text-xl font-semibold text-white">সকল লাইভ ক্লাস</h2>
        </div>

        @if($liveClasses->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-secondary-200 font-medium">ক্লাসের নাম</th>
                            <th class="px-6 py-4 text-left text-secondary-200 font-medium">কোর্স</th>
                            <th class="px-6 py-4 text-left text-secondary-200 font-medium">শুরুর সময়</th>
                            <th class="px-6 py-4 text-left text-secondary-200 font-medium">সময়কাল</th>
                            <th class="px-6 py-4 text-left text-secondary-200 font-medium">স্ট্যাটাস</th>
                            <th class="px-6 py-4 text-center text-secondary-200 font-medium">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($liveClasses as $liveClass)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-white font-medium">{{ $liveClass->title }}</p>
                                    @if($liveClass->description)
                                        <p class="text-secondary-300 text-sm mt-1">{{ Str::limit($liveClass->description, 60) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-blue font-medium">
                                    {{ $liveClass->course?->title ?? $liveClass->course_name ?? 'কোর্স উল্লেখ নেই' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-white">{{ $liveClass->start_time_bangla }}</p>
                                @if($liveClass->is_upcoming)
                                    <p class="text-yellow-400 text-sm">{{ $liveClass->time_until_start }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-secondary-200">{{ $liveClass->duration_human }}</p>
                            </td>
                            <td class="px-6 py-4">
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
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($liveClass->canStart(auth()->id()))
                                        <form action="{{ route('instructor.live-classes.start', $liveClass) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors ray-hover">
                                                <i class="fas fa-play text-xs mr-1"></i>
                                                শুরু করুন
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('instructor.live-classes.show', $liveClass) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors ray-hover">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    @if($liveClass->status === 'scheduled')
                                        <a href="{{ route('instructor.live-classes.edit', $liveClass) }}" 
                                           class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors ray-hover">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>

                                        <form action="{{ route('instructor.live-classes.destroy', $liveClass) }}" 
                                              method="POST" class="inline" 
                                              onsubmit="return confirm('আপনি কি নিশ্চিত যে এই লাইভ ক্লাসটি মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors ray-hover">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-white/10">
                {{ $liveClasses->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="text-secondary-400 mb-4">
                    <i class="fas fa-video text-6xl opacity-50"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">কোন লাইভ ক্লাস নেই</h3>
                <p class="text-secondary-300 mb-6">আপনি এখনও কোন লাইভ ক্লাস তৈরি করেননি।</p>
                <a href="{{ route('instructor.live-classes.create') }}" 
                   class="bg-gradient-to-r from-blue to-lime text-primary px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 ray-hover">
                    <i class="fas fa-plus mr-2"></i>
                    প্রথম লাইভ ক্লাস তৈরি করুন
                </a>
            </div>
        @endif
    </div>
</div>
@endsection