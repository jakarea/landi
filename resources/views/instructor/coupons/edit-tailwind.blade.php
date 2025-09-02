@extends('layouts.instructor-tailwind')
@section('title', 'কুপন সম্পাদনা')
@section('header-title', 'কুপন সম্পাদনা')
@section('header-subtitle', '{{ $coupon->name }} কুপনের তথ্য আপডেট করুন')

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

/* Usage statistics styling */
.usage-stats {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    border: 1px solid rgba(90, 234, 244, 0.3);
}

:root.light-theme .usage-stats {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-color: rgba(59, 130, 246, 0.3);
}

/* Copy button animation */
.copy-btn:hover {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    color: #091D3D;
    transform: translateY(-1px);
}

.copy-btn.copied {
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
}

/* Delete button styling */
.delete-btn:hover {
    background: linear-gradient(135deg, #EF4444, #DC2626);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Actions -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center">
                <i class="fas fa-edit text-primary text-lg"></i>
            </div>
            <div>
                <h2 class="text-white font-bold text-xl">{{ $coupon->name }}</h2>
                <div class="flex items-center gap-4 text-sm">
                    <span class="px-3 py-1 bg-blue/20 text-blue rounded-full font-medium">{{ strtoupper($coupon->code) }}</span>
                    <span class="text-secondary-200">{{ $coupon->used_count }}/{{ $coupon->usage_limit }} ব্যবহৃত</span>
                    <span class="px-2 py-1 rounded text-xs {{ $coupon->is_active ? 'bg-green-500/20 text-green-500' : 'bg-gray-500/20 text-gray-400' }}">
                        {{ $coupon->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('instructor.coupons.show', $coupon) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim">
                <i class="fas fa-eye"></i>
                <span>দেখুন</span>
            </a>
            <a href="{{ route('instructor.coupons') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-card hover:bg-primary border border-[#fff]/20 hover:border-blue text-secondary-100 hover:text-blue rounded-lg font-semibold anim">
                <i class="fas fa-arrow-left"></i>
                <span>ফিরে যান</span>
            </a>
        </div>
    </div>

    <!-- Usage Statistics -->
    <div class="usage-stats rounded-xl p-6 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue">{{ $coupon->used_count }}</div>
                <div class="text-secondary-200 text-sm">ব্যবহৃত</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-lime">{{ $coupon->usage_limit - $coupon->used_count }}</div>
                <div class="text-secondary-200 text-sm">অবশিষ্ট</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange">{{ floor(now()->diffInDays($coupon->valid_until, false)) }}</div>
                <div class="text-secondary-200 text-sm">দিন বাকি</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white">{{ round(($coupon->used_count / $coupon->usage_limit) * 100, 1) }}%</div>
                <div class="text-secondary-200 text-sm">ব্যবহারের হার</div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('instructor.coupons.update', $coupon) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
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
                           value="{{ old('name', $coupon->name) }}" 
                           placeholder="কুপনের নাম" required>
                    <label for="name">কুপনের নাম *</label>
                    @error('name')
                        <p class="mt-1 text-orange text-sm flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Coupon Code (Read-only) -->
                <div>
                    <label class="block text-secondary-100 font-semibold mb-2">কুপন কোড</label>
                    <div class="flex">
                        <input type="text" 
                               class="flex-1 px-4 py-3 bg-secondary border border-[#fff]/20 rounded-l-lg text-white"
                               value="{{ $coupon->code }}" readonly>
                        <button type="button" class="copy-btn px-4 py-3 bg-blue hover:bg-blue/80 text-primary rounded-r-lg border border-blue font-semibold anim"
                                onclick="copyCode('{{ $coupon->code }}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-secondary-200 text-sm">কুপন কোড তৈরির পর পরিবর্তন করা যাবে না</p>
                </div>
            </div>

            <!-- Description -->
            <div class="floating-input mt-6">
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-3 bg-primary border border-[#fff]/20 rounded-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim resize-none @error('description') border-orange @enderror"
                          placeholder="বিবরণ">{{ old('description', $coupon->description) }}</textarea>
                <label for="description">বিবরণ (ঐচ্ছিক)</label>
                @error('description')
                    <p class="mt-1 text-orange text-sm flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Discount Settings -->
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
                        <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>
                            শতাংশ (%)
                        </option>
                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>
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
                        <span id="valuePrefix" class="px-4 py-3 bg-secondary border border-[#fff]/20 rounded-l-lg text-secondary-100 font-semibold">
                            {{ $coupon->type === 'percentage' ? '%' : '৳' }}
                        </span>
                        <input id="value" name="value" type="number" 
                               class="flex-1 px-4 py-3 bg-primary border border-[#fff]/20 rounded-r-lg text-white placeholder-transparent focus:border-blue focus:outline-none anim @error('value') border-orange @enderror" 
                               value="{{ old('value', $coupon->value) }}" 
                               min="0" step="0.01" 
                               {{ $coupon->type === 'percentage' ? 'max=100' : '' }}
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

        <!-- Course Selection -->
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
                                {{ in_array($course->id, old('applicable_courses', $coupon->applicable_courses ?? [])) ? 'selected' : '' }}>
                            {{ $course->title }}
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

        <!-- Usage and Validity -->
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
                           value="{{ old('usage_limit', $coupon->usage_limit) }}" 
                           min="{{ $coupon->used_count }}"
                           placeholder="ব্যবহারের সীমা" required>
                    <label for="usage_limit">ব্যবহারের সীমা *</label>
                    <p class="mt-1 text-secondary-200 text-sm">
                        ইতিমধ্যে ব্যবহৃত: {{ $coupon->used_count }} বার
                        <br>সর্বনিম্ন সীমা: {{ $coupon->used_count }}
                    </p>
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
                           value="{{ old('valid_from', $coupon->valid_from->format('Y-m-d\TH:i')) }}" required>
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
                           value="{{ old('valid_until', $coupon->valid_until->format('Y-m-d\TH:i')) }}" required>
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
                        <h3 class="text-white font-semibold">কুপন অবস্থা</h3>
                        <p class="text-secondary-200 text-sm">কুপনটি সক্রিয় রাখুন</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                           class="sr-only peer">
                    <div class="w-14 h-7 bg-secondary peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue/25 rounded-full peer peer-checked:after:translate-x-7 peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue"></div>
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between gap-4 pt-6">
            <button type="button" onclick="openDeleteModal()" 
                    class="delete-btn flex items-center gap-2 px-6 py-3 bg-orange hover:bg-orange/80 text-primary rounded-lg font-semibold anim">
                <i class="fas fa-trash"></i>
                <span>কুপন মুছুন</span>
            </button>
            
            <button type="submit" 
                    class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue to-lime hover:from-blue/80 hover:to-lime/80 text-primary rounded-lg font-semibold anim">
                <i class="fas fa-save"></i>
                <span>আপডেট করুন</span>
            </button>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/80" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-card rounded-xl border border-[#fff]/20 max-w-md w-full">
            <div class="p-6 border-b border-[#fff]/20">
                <h3 class="text-white font-semibold text-lg flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-orange"></i>
                    কুপন মুছে ফেলুন
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-secondary-100">আপনি কি নিশ্চিত যে এই কুপনটি মুছে ফেলতে চান?</p>
                
                <div class="bg-orange/20 border border-orange rounded-lg p-4">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-secondary-100">কুপন কোড:</span>
                            <span class="text-white font-mono">{{ $coupon->code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-secondary-100">ব্যবহারের সংখ্যা:</span>
                            <span class="text-white">{{ $coupon->used_count }} বার</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-orange text-sm flex items-center gap-2">
                    <i class="fas fa-warning"></i>
                    এই কাজটি পূর্বাবস্থায় ফেরানো যাবে না।
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 p-6 border-t border-[#fff]/20">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-6 py-2 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg anim">
                    বাতিল
                </button>
                <form action="{{ route('instructor.coupons.delete', $coupon) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-2 bg-orange hover:bg-orange/80 text-primary rounded-lg font-semibold anim">
                        মুছে ফেলুন
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy code functionality
    window.copyCode = function(code) {
        navigator.clipboard.writeText(code).then(function() {
            const btn = document.querySelector('.copy-btn');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.add('copied');
            
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('copied');
            }, 2000);
            
            showAlert('কুপন কোড কপি হয়েছে!', 'success');
        }).catch(function() {
            showAlert('কপি করতে সমস্যা হয়েছে', 'error');
        });
    };

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
    });

    // Delete modal functions
    window.openDeleteModal = function() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };
    
    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

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

    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (!modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });

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