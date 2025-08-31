@extends('layouts.instructor-tailwind')
@section('title', 'নতুন কুপন তৈরি')
@section('header-title', 'নতুন কুপন তৈরি')
@section('header-subtitle', 'আপনার কোর্সের জন্য নতুন ডিসকাউন্ট কুপন তৈরি করুন')

@section('style')
<style>
/* Custom input styling for floating labels */
.floating-input {
    position: relative;
}

.floating-input input,
.floating-input select,
.floating-input textarea {
    padding-top: 1.25rem;
    padding-bottom: 0.5rem;
}

.floating-input label {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    color: #ABABAB;
    pointer-events: none;
    transition: all 0.3s ease;
    background: transparent;
    z-index: 1;
}

.floating-input input:focus + label,
.floating-input input:not(:placeholder-shown) + label,
.floating-input select:focus + label,
.floating-input select:valid + label,
.floating-input textarea:focus + label,
.floating-input textarea:not(:placeholder-shown) + label {
    top: 0.25rem;
    left: 0.75rem;
    font-size: 0.75rem;
    color: #5AEAF4;
    background: var(--color-card);
    padding: 0 0.25rem;
}

:root.light-theme .floating-input input:focus + label,
:root.light-theme .floating-input input:not(:placeholder-shown) + label,
:root.light-theme .floating-input select:focus + label,
:root.light-theme .floating-input select:valid + label,
:root.light-theme .floating-input textarea:focus + label,
:root.light-theme .floating-input textarea:not(:placeholder-shown) + label {
    color: #3B82F6;
    background: white;
}

/* Discount type badges */
.type-percentage {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.type-fixed {
    background: linear-gradient(135deg, #FF9800, #F57700);
    color: white;
}

/* Success animation */
.success-checkmark {
    animation: checkmark 0.6s ease-in-out;
}

@keyframes checkmark {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Code generation animation */
.code-generate-btn:hover {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    color: #091D3D;
    transform: translateY(-1px);
}

/* Form progress indicator */
.form-step {
    transition: all 0.3s ease;
}

.form-step.completed {
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
}

.form-step.active {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    color: #091D3D;
}
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Form Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="form-step active rounded-lg px-4 py-2 text-sm font-semibold">
                <i class="fas fa-plus-circle mr-2"></i>
                কুপন তথ্য
            </div>
            <div class="flex-1 h-px bg-[#fff]/20 mx-4"></div>
            <div class="form-step rounded-lg px-4 py-2 text-sm font-semibold bg-card text-secondary-100">
                <i class="fas fa-cog mr-2"></i>
                সেটিংস
            </div>
            <div class="flex-1 h-px bg-[#fff]/20 mx-4"></div>
            <div class="form-step rounded-lg px-4 py-2 text-sm font-semibold bg-card text-secondary-100">
                <i class="fas fa-check-circle mr-2"></i>
                সম্পন্ন
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-orange/20 border border-orange rounded-lg">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-orange mt-1"></i>
                <div>
                    <h4 class="text-orange font-semibold mb-2">ত্রুটি পাওয়া গেছে:</h4>
                    <ul class="text-secondary-100 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <i class="fas fa-dot-circle text-xs text-orange"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <form action="{{ route('instructor.coupons.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Basic Information Card -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center">
                    <i class="fas fa-tag text-primary"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">মৌলিক তথ্য</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coupon Name -->
                <div class="floating-input">
                    <input id="name" name="name" type="text" 
                           class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim @error('name') border-orange @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="কুপনের নাম" required>
                    <label for="name">কুপনের নাম *</label>
                    @error('name')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Coupon Code -->
                <div class="floating-input">
                    <div class="flex">
                        <input id="code" name="code" type="text" 
                               class="flex-1 px-4 py-3 bg-primary border border-[#fff]/20 rounded-l-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim @error('code') border-orange @enderror" 
                               value="{{ old('code') }}" 
                               placeholder="কুপন কোড"
                               style="text-transform: uppercase;">
                        <button type="button" id="generateCode" 
                                class="code-generate-btn px-4 py-3 bg-blue hover:bg-blue/80 text-primary rounded-r-lg border border-blue font-semibold anim">
                            <i class="fas fa-random mr-2"></i>
                            তৈরি করুন
                        </button>
                    </div>
                    <label for="code">কুপন কোড (খালি রাখলে স্বয়ংক্রিয় তৈরি হবে)</label>
                    @error('code')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="floating-input mt-6">
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim resize-none @error('description') border-orange @enderror"
                          placeholder="বিবরণ">{{ old('description') }}</textarea>
                <label for="description">বিবরণ (ঐচ্ছিক)</label>
                @error('description')
                    <p class="mt-1 text-orange text-sm flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Discount Settings Card -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-percentage text-white"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">ডিসকাউন্ট সেটিংস</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Discount Type -->
                <div class="floating-input">
                    <select id="type" name="type" 
                            class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white focus:border-blue focus:outline-none anim @error('type') border-orange @enderror" required>
                        <option value="">ডিসকাউন্ট ধরন নির্বাচন করুন</option>
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                            শতাংশ (%)
                        </option>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>
                            নির্দিষ্ট পরিমাণ (৳)
                        </option>
                    </select>
                    <label for="type">ডিসকাউন্ট ধরন *</label>
                    @error('type')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Discount Value -->
                <div class="floating-input">
                    <div class="flex">
                        <span id="valuePrefix" class="px-4 py-3 bg-secondary border border-[#fff]/20 rounded-l-lg text-secondary-100 font-semibold">৳</span>
                        <input id="value" name="value" type="number" 
                               class="flex-1 px-4 py-3 bg-primary border border-[#fff]/20 rounded-r-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim @error('value') border-orange @enderror" 
                               value="{{ old('value') }}" 
                               min="0" step="0.01" 
                               placeholder="ডিসকাউন্ট মান" required>
                    </div>
                    <label for="value">ডিসকাউন্ট মান *</label>
                    @error('value')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Course Selection Card -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-book text-white"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">প্রযোজ্য কোর্স</h3>
            </div>

            <div class="floating-input">
                <select id="applicable_courses" name="applicable_courses[]" multiple
                        class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white focus:border-blue focus:outline-none anim @error('applicable_courses') border-orange @enderror">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" 
                                {{ in_array($course->id, old('applicable_courses', [])) ? 'selected' : '' }}>
                            {{ $course->title }} - ৳{{ number_format($course->offer_price ?? $course->price, 2) }}
                        </option>
                    @endforeach
                </select>
                <label for="applicable_courses">প্রযোজ্য কোর্স (খালি রাখলে সব কোর্সে প্রযোজ্য)</label>
                <p class="mt-2 text-secondary-200 text-sm flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue"></i>
                    Ctrl/Cmd ধরে একাধিক কোর্স নির্বাচন করুন
                </p>
                @error('applicable_courses')
                    <p class="mt-1 text-orange text-sm flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Usage and Validity Card -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-orange to-red-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="text-white font-semibold text-lg">ব্যবহার এবং মেয়াদ</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Usage Limit -->
                <div class="floating-input">
                    <input id="usage_limit" name="usage_limit" type="number" 
                           class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim @error('usage_limit') border-orange @enderror" 
                           value="{{ old('usage_limit', 1) }}" 
                           min="1" 
                           placeholder="ব্যবহারের সীমা" required>
                    <label for="usage_limit">ব্যবহারের সীমা *</label>
                    @error('usage_limit')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Valid From -->
                <div class="floating-input">
                    <input id="valid_from" name="valid_from" type="datetime-local" 
                           class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white focus:border-blue focus:outline-none anim @error('valid_from') border-orange @enderror" 
                           value="{{ old('valid_from') }}" required>
                    <label for="valid_from">শুরুর তারিখ *</label>
                    @error('valid_from')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Valid Until -->
                <div class="floating-input">
                    <input id="valid_until" name="valid_until" type="datetime-local" 
                           class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white focus:border-blue focus:outline-none anim @error('valid_until') border-orange @enderror" 
                           value="{{ old('valid_until') }}" required>
                    <label for="valid_until">শেষের তারিখ *</label>
                    @error('valid_until')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Activation Settings -->
        <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-lime to-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-toggle-on text-primary"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold">কুপন সক্রিয়করণ</h3>
                        <p class="text-secondary-200 text-sm">তৈরির সাথে সাথে কুপন সক্রিয় করুন</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-14 h-7 bg-secondary peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue/25 rounded-full peer peer-checked:after:translate-x-7 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue"></div>
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4 pt-6">
            <a href="{{ route('instructor.coupons') }}" 
               class="flex items-center gap-2 px-6 py-3 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg font-semibold anim">
                <i class="fas fa-arrow-left"></i>
                <span>ফিরে যান</span>
            </a>
            
            <button type="submit" 
                    class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue to-lime hover:from-blue/80 hover:to-lime/80 text-primary rounded-lg font-semibold anim">
                <i class="fas fa-save"></i>
                <span>কুপন তৈরি করুন</span>
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate random code
    document.getElementById('generateCode').addEventListener('click', function() {
        const code = Math.random().toString(36).substring(2, 10).toUpperCase();
        document.getElementById('code').value = code;
        
        // Add success animation
        const btn = this;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check success-checkmark mr-2"></i>তৈরি হয়েছে';
        btn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '';
        }, 2000);
    });

    // Update prefix based on discount type
    document.getElementById('type').addEventListener('change', function() {
        const prefix = document.getElementById('valuePrefix');
        const valueInput = document.getElementById('value');
        
        if (this.value === 'percentage') {
            prefix.textContent = '%';
            valueInput.setAttribute('max', '100');
        } else {
            prefix.textContent = '৳';
            valueInput.removeAttribute('max');
        }
        
        // Update form progress
        updateFormProgress();
    });

    // Set default dates
    const now = new Date();
    const nextWeek = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
    
    const validFromInput = document.getElementById('valid_from');
    const validUntilInput = document.getElementById('valid_until');
    
    if (!validFromInput.value) {
        validFromInput.value = now.toISOString().slice(0, 16);
    }
    if (!validUntilInput.value) {
        validUntilInput.value = nextWeek.toISOString().slice(0, 16);
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const startDate = new Date(document.getElementById('valid_from').value);
        const endDate = new Date(document.getElementById('valid_until').value);
        
        if (endDate <= startDate) {
            e.preventDefault();
            showAlert('শেষের তারিখ শুরুর তারিখের পরে হতে হবে', 'error');
            return false;
        }
        
        const type = document.getElementById('type').value;
        if (type === 'percentage') {
            const percentage = parseFloat(document.getElementById('value').value);
            if (percentage > 100) {
                e.preventDefault();
                showAlert('শতাংশ ডিসকাউন্ট ১০০% এর বেশি হতে পারে না', 'error');
                return false;
            }
        }
    });

    // Form progress tracking
    function updateFormProgress() {
        const steps = document.querySelectorAll('.form-step');
        const nameField = document.getElementById('name').value;
        const typeField = document.getElementById('type').value;
        const valueField = document.getElementById('value').value;
        
        // Step 1: Basic info
        if (nameField.length > 0) {
            steps[0].classList.add('completed');
            steps[0].classList.remove('active');
        } else {
            steps[0].classList.remove('completed');
            steps[0].classList.add('active');
        }
        
        // Step 2: Settings
        if (nameField.length > 0 && typeField && valueField) {
            steps[1].classList.add('active');
            if (typeField && valueField) {
                steps[1].classList.add('completed');
                steps[1].classList.remove('active');
                steps[2].classList.add('active');
            }
        } else {
            steps[1].classList.remove('active', 'completed');
            steps[2].classList.remove('active', 'completed');
        }
    }
    
    // Add event listeners for form progress
    ['name', 'type', 'value'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updateFormProgress);
            element.addEventListener('change', updateFormProgress);
        }
    });
    
    // Initial progress check
    updateFormProgress();
    
    // Alert function
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-lg border max-w-sm ${
            type === 'error' ? 'bg-orange/20 border-orange text-orange' : 
            type === 'success' ? 'bg-green-500/20 border-green-500 text-green-500' :
            'bg-blue/20 border-blue text-blue'
        }`;
        
        alertDiv.innerHTML = `
            <div class="flex items-start gap-3">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} mt-0.5"></i>
                <div class="flex-1">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-70">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endsection