@extends('layouts.instructor-tailwind')
@section('title', 'লাইভ ক্লাস সেটআপ - ' . $lesson->title)
@section('header-title', 'লাইভ ক্লাস সেটআপ')
@section('header-subtitle', $lesson->title . ' - এর জন্য লাইভ ক্লাসের তথ্য যোগ করুন')

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="glass-effect rounded-xl border border-white/20 p-6">
        <div class="step-progress">
            <div class="step-item completed">
                <div class="step-circle">1</div>
                <span class="text-white/70 text-sm mt-2">বেসিক তথ্য</span>
            </div>
            <div class="step-connector completed"></div>
            <div class="step-item completed">
                <div class="step-circle">2</div>
                <span class="text-white/70 text-sm mt-2">কোর্স ডিটেইল</span>
            </div>
            <div class="step-connector completed"></div>
            <div class="step-item completed">
                <div class="step-circle">3</div>
                <span class="text-white/70 text-sm mt-2">মডিউল</span>
            </div>
            <div class="step-connector completed"></div>
            <div class="step-item current">
                <div class="step-circle">4</div>
                <span class="text-white text-sm mt-2">লাইভ ক্লাস</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-circle">5</div>
                <span class="text-white/70 text-sm mt-2">প্রকাশ</span>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex items-center mb-6">
        <a href="{{ url('instructor/courses/create/'. $lesson->course_id .'/content?tab='. $lesson->module_id) }}" 
           class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg font-medium transition-colors ray-hover">
            <i class="fas fa-arrow-left mr-2"></i>
            ফিরে যান
        </a>
        <div class="ml-4">
            <h2 class="text-xl font-bold text-white">{{ $lesson->title }}</h2>
            <p class="text-white/80 text-sm">লাইভ ক্লাস সেটআপ</p>
        </div>
    </div>

    <!-- Live Class Setup Form -->
    <div class="glass-effect rounded-xl border border-white/20 p-8">
        <form action="{{ url('instructor/courses/create/'. $lesson->course_id .'/live/'. $lesson->module_id .'/content/'. $lesson->id) }}" method="POST">
            @csrf
            @method('POST')

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle mr-3 mt-0.5"></i>
                        <div>
                            <p class="font-medium mb-2 text-red-400">নিম্নলিখিত ত্রুটি গুলো ঠিক করুন:</p>
                            <ul class="list-disc list-inside space-y-1 text-red-400">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Live Class Schedule -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="form-group">
                    <label for="live_start_time" class="block text-white font-medium mb-2">
                        শুরুর সময় <span class="text-red-400">*</span>
                    </label>
                    <input type="datetime-local" 
                           name="live_start_time" 
                           id="live_start_time" 
                           value="{{ old('live_start_time', $lesson->live_start_time?->format('Y-m-d\TH:i')) }}"
                           min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue focus:outline-none transition-colors"
                           required>
                    @error('live_start_time')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-secondary-200 text-xs mt-1">ভবিষ্যতের তারিখ ও সময় নির্বাচন করুন</p>
                </div>

                <div class="form-group">
                    <label for="live_duration_minutes" class="block text-white font-medium mb-2">
                        সময়কাল (মিনিট) <span class="text-red-400">*</span>
                    </label>
                    <select name="live_duration_minutes" 
                            id="live_duration_minutes" 
                            class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white focus:border-blue focus:outline-none transition-colors"
                            required>
                        <option value="" class="bg-primary text-secondary-200">সময়কাল নির্বাচন করুন</option>
                        <option value="15" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '15' ? 'selected' : '' }}>১৫ মিনিট</option>
                        <option value="30" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '30' ? 'selected' : '' }}>৩০ মিনিট</option>
                        <option value="45" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '45' ? 'selected' : '' }}>৪৫ মিনিট</option>
                        <option value="60" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '60' ? 'selected' : '' }}>১ ঘন্টা</option>
                        <option value="90" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '90' ? 'selected' : '' }}>১.৫ ঘন্টা</option>
                        <option value="120" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '120' ? 'selected' : '' }}>২ ঘন্টা</option>
                        <option value="180" class="bg-primary text-secondary-200" {{ old('live_duration_minutes', $lesson->live_duration_minutes) == '180' ? 'selected' : '' }}>৩ ঘন্টা</option>
                    </select>
                    @error('live_duration_minutes')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Zoom Meeting Details -->
            <div class="space-y-6 bg-blue-900/20 border border-blue-800 rounded-xl p-6 mb-6">
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
                               value="{{ old('zoom_meeting_id', $lesson->zoom_meeting_id) }}"
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
                               value="{{ old('zoom_password', $lesson->zoom_password) }}"
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
                           value="{{ old('zoom_join_url', $lesson->zoom_join_url) }}"
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-white/60 focus:border-blue focus:outline-none transition-colors"
                           placeholder="https://zoom.us/j/1234567890"
                           required>
                    @error('zoom_join_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 p-4 rounded-xl">
                    <div class="flex">
                        <i class="fas fa-info-circle mr-3 mt-0.5 text-yellow-400"></i>
                        <div>
                            <p class="font-medium mb-2 text-yellow-400">নির্দেশনা</p>
                            <ul class="text-sm space-y-1 text-secondary-200">
                                <li>• আপনার Zoom অ্যাকাউন্ট থেকে একটি মিটিং তৈরি করুন</li>
                                <li>• মিটিং ID এবং Join URL এখানে পেস্ট করুন</li>
                                <li>• পাসওয়ার্ড সেট করা থাকলে তা দিন</li>
                                <li>• স্টুডেন্টরা নির্ধারিত সময়ে এই লিংক দিয়ে ক্লাসে যোগ দিতে পারবে</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-white/10">
                <a href="{{ url('instructor/courses/create/'. $lesson->course_id .'/content?tab='. $lesson->module_id) }}" 
                   class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-lg font-medium transition-colors ray-hover">
                    বাতিল
                </a>
                
                <div class="space-x-4">
                    <button type="submit" name="action" value="save_continue" 
                            class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-lg font-medium transition-colors ray-hover">
                        <i class="fas fa-save mr-2"></i>
                        সংরক্ষণ করুন
                    </button>
                    <button type="submit" name="action" value="save_next"
                            class="bg-gradient-to-r from-blue to-lime text-primary px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 ray-hover">
                        <i class="fas fa-arrow-right mr-2"></i>
                        সংরক্ষণ ও পরবর্তী
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Step Progress Styling */
.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: 2px solid;
}

.step-item.current .step-circle {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-color: #5AEAF4;
    color: #091D3D;
    transform: scale(1.1);
}

.step-item.completed .step-circle {
    background-color: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
}

.step-item:not(.current):not(.completed) .step-circle {
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.3);
    color: rgba(255, 255, 255, 0.6);
}

.step-connector {
    width: 50px;
    height: 2px;
    background-color: rgba(255, 255, 255, 0.2);
    margin: 0 0.5rem;
}

.step-connector.completed {
    background-color: #10B981;
}

@media (max-width: 768px) {
    .step-progress {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .step-connector {
        width: 2px;
        height: 20px;
        margin: 0.25rem 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum datetime to current time + 1 hour
    const startTimeInput = document.getElementById('live_start_time');
    if (startTimeInput) {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        const minDateTime = now.toISOString().slice(0, 16);
        startTimeInput.min = minDateTime;
    }
});
</script>
@endsection