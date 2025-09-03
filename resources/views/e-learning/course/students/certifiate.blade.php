@extends('layouts/student-modern')
@section('title', 'আমার সার্টিফিকেট')

@php
    use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
    .progress-ring {
        transform: rotate(-90deg);
    }
    .progress-ring-circle {
        stroke-dasharray: 157;
        stroke-dashoffset: 157;
        transition: stroke-dashoffset 1s ease-in-out;
        transform-origin: 50% 50%;
    }
    .certificate-card {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .certificate-card:hover {
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(99, 102, 241, 0.1);
        transform: translateY(-2px);
    }
    .certificate-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        transform: translateX(-100%) translateY(-100%);
        transition: transform 0.8s ease-in-out;
    }
    .certificate-card:hover::before {
        transform: translateX(200%) translateY(200%);
    }
    .empty-state {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.7) 0%, rgba(30, 41, 59, 0.7) 100%);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">আমার সার্টিফিকেট</h1>
            <p class="text-gray-400">সম্পন্ন কোর্সের সার্টিফিকেট দেখুন ও ডাউনলোড করুন</p>
        </div>
        <div class="glass-effect px-4 py-2 rounded-lg">
            <span class="text-purple-400 font-semibold">{{ count($certificateCourses) }} টি সার্টিফিকেট</span>
        </div>
    </div>

    @if (count($certificateCourses) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($certificateCourses as $certificateCourse)
                @php
                    $totalDurationMinutes = 0;
                    foreach ($certificateCourse->modules as $module) {
                        foreach ($module->lessons as $lesson) {
                            $totalDurationMinutes += $lesson->duration;
                        }
                    }
                    
                    $totalPorgressPercent = StudentActitviesProgress(auth()->user()->id, $certificateCourse->id);
                    $showPercentage = $totalPorgressPercent > 92 && $totalPorgressPercent < 100 ? $totalPorgressPercent - 4 : $totalPorgressPercent;
                    
                    $totalLessons = 0;
                    $completedLessons = 0;
                    foreach ($certificateCourse->modules as $module) {
                        $totalLessons += count($module->lessons);
                        $completedLessons += $module->lessons->where('completed', 1)->count();
                    }
                    
                    $circumference = 2 * pi() * 25;
                    $strokeDasharray = $circumference;
                    $strokeDashoffset = $circumference - ($totalPorgressPercent / 100) * $circumference;
                @endphp
                
                <div class="certificate-card rounded-2xl p-6 space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <img src="{{ asset($certificateCourse->thumbnail) }}" 
                                 alt="{{ $certificateCourse->title }}"
                                 class="w-20 h-20 rounded-lg object-cover border-2 border-gray-600">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2">
                                <a href="{{ url('student/courses/' . $certificateCourse->slug) }}" 
                                   class="hover:text-purple-400 transition-colors">
                                    {{ $certificateCourse->title }}
                                </a>
                            </h3>
                            <p class="text-gray-400 text-sm mb-2">{{ $certificateCourse->categories }}</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ number_format($totalDurationMinutes / 60, 2) }} ঘন্টা</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="relative w-16 h-16">
                                <svg class="w-16 h-16 progress-ring" viewBox="0 0 60 60">
                                    <circle cx="30" cy="30" r="25" 
                                            stroke="rgba(148, 163, 184, 0.2)" 
                                            stroke-width="4" 
                                            fill="transparent"></circle>
                                    <circle cx="30" cy="30" r="25"
                                            stroke="{{ $totalPorgressPercent >= 100 ? '#10b981' : ($totalPorgressPercent > 50 ? '#f59e0b' : '#ef4444') }}"
                                            stroke-width="4"
                                            fill="transparent"
                                            class="progress-ring-circle"
                                            stroke-linecap="round"
                                            style="stroke-dasharray: {{ $strokeDasharray }}; stroke-dashoffset: {{ $strokeDashoffset }};"></circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">{{ $totalPorgressPercent }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <div class="text-sm text-gray-400">স্ট্যাটাস</div>
                                @if ($totalPorgressPercent >= 100)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300 border border-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        সম্পন্ন
                                    </span>
                                @elseif($totalPorgressPercent < 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-300 border border-red-600">
                                        <i class="fas fa-pause-circle mr-1"></i>
                                        শুরু হয়নি
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300 border border-yellow-600">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        চলমান
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-gray-400">পাঠ</div>
                                <div class="text-sm text-white font-semibold">{{ $completedLessons }}/{{ $totalLessons }}</div>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            @if ($totalPorgressPercent > 99 && $totalPorgressPercent < 101)
                                <a href="{{ url('student/certificates/' . $certificateCourse->slug) }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover"
                                   target="_blank">
                                    <i class="fas fa-eye mr-2"></i>
                                    দেখুন
                                </a>
                                <a href="{{ url('student/certificates/' . $certificateCourse->slug . '/download') }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-300 ray-hover">
                                    <i class="fas fa-download mr-2"></i>
                                    ডাউনলোড
                                </a>
                            @else
                                <button disabled 
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                    <i class="fas fa-eye mr-2"></i>
                                    দেখুন
                                </button>
                                <button disabled 
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                    <i class="fas fa-download mr-2"></i>
                                    ডাউনলোড
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    @if ($totalPorgressPercent < 100)
                        <div class="pt-4 border-t border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-400">সম্পূর্ণ করার জন্য {{ 100 - $totalPorgressPercent }}% বাকি</span>
                                <a href="{{ url('student/courses/' . $certificateCourse->slug . '/learn') }}" 
                                   class="text-sm text-purple-400 hover:text-purple-300 transition-colors">
                                    কোর্স চালিয়ে যান →
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="flex justify-center mt-8">
            {{ $certificateCourses->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-state rounded-2xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-certificate text-3xl text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">কোন সার্টিফিকেট নেই</h3>
                    <p class="text-gray-400 mb-6">আপনার কোন কোর্স সম্পূর্ণ করা হয়নি। প্রথমে কোর্স সম্পূর্ণ করুন।</p>
                </div>
                <a href="{{ route('student.courses') }}" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    আমার কোর্স দেখুন
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressRings = document.querySelectorAll('.progress-ring-circle');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const circle = entry.target;
                const dashoffset = circle.style.strokeDashoffset;
                circle.style.strokeDashoffset = '157';
                setTimeout(() => {
                    circle.style.strokeDashoffset = dashoffset;
                }, 100);
            }
        });
    });
    
    progressRings.forEach(ring => {
        observer.observe(ring);
    });
});
</script>
@endpush
@endsection
