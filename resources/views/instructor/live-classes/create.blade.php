@extends('layouts.instructor-tailwind')
@section('title', 'নতুন লাইভ ক্লাস তৈরি করুন')
@section('header-title', 'লাইভ ক্লাস')
@section('header-subtitle', 'নতুন লাইভ ক্লাস তৈরি করুন')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">নতুন লাইভ ক্লাস তৈরি করুন</h1>
            <p class="text-secondary-200 mt-1">আপনার স্টুডেন্টদের জন্য একটি নতুন লাইভ ক্লাস সেট আপ করুন</p>
        </div>
        <a href="{{ route('instructor.live-classes.index') }}" 
           class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-medium transition-colors ray-hover">
            <i class="fas fa-arrow-left mr-2"></i>
            ফিরে যান
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-xl">
            <div class="flex">
                <i class="fas fa-exclamation-circle mr-3 mt-0.5"></i>
                <div>
                    <p class="font-medium mb-2">নিম্নলিখিত ত্রুটি গুলো ঠিক করুন:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-xl">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Create Form -->
    <div class="glass-effect rounded-xl border border-white/20 p-8">
        <form action="{{ route('instructor.live-classes.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Class Title -->
            <div class="form-group">
                <label for="title" class="block text-white font-medium mb-2">
                    ক্লাসের নাম <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}"
                       class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                       placeholder="উদাহরণ: React.js এর মূল বিষয়সমূহ"
                       required>
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-white font-medium mb-2">
                    বিবরণ
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                          placeholder="এই ক্লাসে কি শেখানো হবে তার সংক্ষিপ্ত বিবরণ লিখুন...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Selection -->
            <div class="form-group">
                <label for="course_id" class="block text-white font-medium mb-2">
                    কোর্স নির্বাচন করুন <span class="text-red-400">*</span>
                </label>
                <select name="course_id" 
                        id="course_id" 
                        class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue focus:outline-none transition-colors"
                        required>
                    <option value="" class="bg-slate-800 text-white">কোর্স নির্বাচন করুন</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" class="bg-slate-800 text-white" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                @if($courses->isEmpty())
                    <div class="bg-yellow-900/20 border border-yellow-800 text-yellow-200 p-4 rounded-xl mt-3">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle mr-3 mt-0.5"></i>
                            <div>
                                <p class="font-medium mb-2">কোন কোর্স নেই</p>
                                <p class="text-sm">লাইভ ক্লাস তৈরি করতে প্রথমে একটি কোর্স তৈরি করুন।</p>
                                <a href="{{ route('instructor.courses.create') }}" class="inline-block mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    নতুন কোর্স তৈরি করুন
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="start_time" class="block text-white font-medium mb-2">
                        শুরুর সময় <span class="text-red-400">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="start_time" 
                           id="start_time" 
                           value="{{ old('start_time') }}"
                           min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue focus:outline-none transition-colors"
                           required>
                    @error('start_time')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-white/80 text-xs mt-1">ভবিষ্যতের তারিখ ও সময় নির্বাচন করুন</p>
                </div>

                <div class="form-group">
                    <label for="duration_minutes" class="block text-white font-medium mb-2">
                        সময়কাল (মিনিট) <span class="text-red-400">*</span>
                    </label>
                    <select name="duration_minutes" 
                            id="duration_minutes" 
                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue focus:outline-none transition-colors"
                            required>
                        <option value="" class="bg-slate-800 text-white">সময়কাল নির্বাচন করুন</option>
                        <option value="15" class="bg-slate-800 text-white" {{ old('duration_minutes') == '15' ? 'selected' : '' }}>১৫ মিনিট</option>
                        <option value="30" class="bg-slate-800 text-white" {{ old('duration_minutes') == '30' ? 'selected' : '' }}>৩০ মিনিট</option>
                        <option value="45" class="bg-slate-800 text-white" {{ old('duration_minutes') == '45' ? 'selected' : '' }}>৪৫ মিনিট</option>
                        <option value="60" class="bg-slate-800 text-white" {{ old('duration_minutes') == '60' ? 'selected' : '' }}>১ ঘন্টা</option>
                        <option value="90" class="bg-slate-800 text-white" {{ old('duration_minutes') == '90' ? 'selected' : '' }}>১.৫ ঘন্টা</option>
                        <option value="120" class="bg-slate-800 text-white" {{ old('duration_minutes') == '120' ? 'selected' : '' }}>২ ঘন্টা</option>
                        <option value="150" class="bg-slate-800 text-white" {{ old('duration_minutes') == '150' ? 'selected' : '' }}>২.৫ ঘন্টা</option>
                        <option value="180" class="bg-slate-800 text-white" {{ old('duration_minutes') == '180' ? 'selected' : '' }}>৩ ঘন্টা</option>
                    </select>
                    @error('duration_minutes')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Zoom Meeting Details -->
            <div class="space-y-6 bg-blue-900/20 border border-blue-800 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-video text-blue-400 mr-3"></i>
                    <h3 class="text-lg font-semibold text-white">Zoom মিটিং তথ্য</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="zoom_meeting_id" class="block text-white font-medium mb-2">
                            মিটিং ID <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="zoom_meeting_id" 
                               id="zoom_meeting_id" 
                               value="{{ old('zoom_meeting_id') }}"
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                               placeholder="উদাহরণ: 123-456-7890"
                               required>
                        @error('zoom_meeting_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="zoom_password" class="block text-white font-medium mb-2">
                            পাসওয়ার্ড
                        </label>
                        <input type="text" 
                               name="zoom_password" 
                               id="zoom_password" 
                               value="{{ old('zoom_password') }}"
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                               placeholder="মিটিং পাসওয়ার্ড (যদি থাকে)">
                        @error('zoom_password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="zoom_join_url" class="block text-white font-medium mb-2">
                        Zoom যোগদান লিংক <span class="text-red-400">*</span>
                    </label>
                    <input type="url" 
                           name="zoom_join_url" 
                           id="zoom_join_url" 
                           value="{{ old('zoom_join_url') }}"
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                           placeholder="https://zoom.us/j/1234567890"
                           required>
                    @error('zoom_join_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-900/20 border border-yellow-800 text-yellow-200 p-4 rounded-xl">
                    <div class="flex">
                        <i class="fas fa-info-circle mr-3 mt-0.5"></i>
                        <div>
                            <p class="font-medium mb-2">নির্দেশনা</p>
                            <ul class="text-sm space-y-1">
                                <li>• আপনার Zoom অ্যাকাউন্ট থেকে একটি মিটিং তৈরি করুন</li>
                                <li>• মিটিং ID এবং Join URL এখানে পেস্ট করুন</li>
                                <li>• পাসওয়ার্ড সেট করা থাকলে তা দিন</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('instructor.live-classes.index') }}" 
                   class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    বাতিল
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-blue to-lime text-primary px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 ray-hover">
                    <i class="fas fa-plus mr-2"></i>
                    লাইভ ক্লাস তৈরি করুন
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum datetime to current time + 1 hour
    const startTimeInput = document.getElementById('start_time');
    const now = new Date();
    now.setHours(now.getHours() + 1);
    const minDateTime = now.toISOString().slice(0, 16);
    startTimeInput.min = minDateTime;
});
</script>
@endsection