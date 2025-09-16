@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - দৃশ্যমানতা')
@section('header-title', 'কোর্সের দৃশ্যমানতা')
@section('header-subtitle', 'আপনার কোর্সের প্রকাশ এবং রিভিউ সেটিংস নির্ধারণ করুন')
@section('style')
<style>
/* Progress steps styling */
.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-x: auto;
    padding: 1rem 0;
    gap: 0.5rem;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 80px;
    position: relative;
    flex-shrink: 0;
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

.step-item.completed .step-circle i {
    font-size: 1rem;
}

.step-item:not(.current):not(.completed) .step-circle {
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.3);
    color: #9CA3AF;
}

.step-title {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.step-item.current .step-title {
    color: #5AEAF4;
}

.step-item.completed .step-title {
    color: #10B981;
}

.step-item:not(.current):not(.completed) .step-title {
    color: #9CA3AF;
}

.step-title a {
    text-decoration: none;
    color: inherit;
}

.step-title a.disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Connection lines between steps */
.step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: calc(100% + 0.25rem);
    width: calc(100% - 40px);
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    z-index: -1;
}

.step-item.completed:not(:last-child)::after {
    background: #10B981;
}

/* Modern form styling */
.form-input-modern {
    width: 100%;
    padding: 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #FFFFFF;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
}

.form-input-modern:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-input-modern::placeholder {
    color: #9CA3AF;
}

/* Select styling */
.form-select-modern {
    appearance: none;
    background: #091D3D url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="%235AEAF4" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 1rem center;
    background-size: 1.25rem;
    padding: 1rem 3rem 1rem 1rem;
    width: 100%;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #FFFFFF;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
}

.form-select-modern:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-select-modern option {
    background: #091D3D;
    color: #FFFFFF;
    padding: 0.5rem;
}

/* Switch styling */
.switch-container {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.2);
    transition: 0.3s;
    border-radius: 34px;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background: #FFFFFF;
    transition: 0.3s;
    border-radius: 50%;
}

.switch-input:checked + .switch-slider {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
}

.switch-input:checked + .switch-slider:before {
    transform: translateX(26px);
    background: #091D3D;
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: transparent;
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #C7C7C7;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    border-color: #F97316;
    color: #F97316;
    background-color: rgba(249, 115, 22, 0.1);
}

.btn-next {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-next:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Error styling */
.error-alert {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 2rem;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-list li {
    color: #FCA5A5;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.error-list li::before {
    content: '•';
    color: #EF4444;
    font-weight: bold;
    display: inline-block;
    width: 1rem;
}

/* Section titles */
.section-title {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #5AEAF4;
    font-size: 1.5rem;
}

/* Form section styling */
.form-section {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.form-field {
    margin-bottom: 2rem;
}

.form-field:last-child {
    margin-bottom: 0;
}

.field-label {
    display: block;
    color: #FFFFFF;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.field-description {
    color: #C7C7C7;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    line-height: 1.5;
}

.field-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1.5rem;
}

.field-content {
    flex: 1;
}

.field-control {
    flex-shrink: 0;
}

/* Status indicator */
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #5AEAF4;
    margin-bottom: 0.5rem;
}

.status-indicator i {
    font-size: 0.625rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .step-progress {
        padding: 0.5rem;
    }
    
    .step-item {
        min-width: 60px;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    
    .step-title {
        font-size: 0.6875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-back,
    .btn-next {
        width: 100%;
        justify-content: center;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .field-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .field-control {
        align-self: flex-start;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="step-progress">
            <div class="step-item completed">
                <div class="step-circle">1</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">2</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">3</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">5</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/visibility' }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/share' }}">প্রকাশ</a>
                </div>
            </div>
        </div>

        @if ( session()->has('course_id') )
            <div class="text-center mt-6 pt-6 border-t border-[#fff]/20">
                <a href="{{ url('instructor/courses') }}" 
                   class="inline-flex items-center gap-2 bg-lime text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-orange hover:text-primary">
                    <i class="fas fa-save"></i>
                    সংরক্ষণ করুন এবং সমাপ্ত করুন
                </a>
            </div>
        @endif
    </div>
    <!-- Error Messages -->
    @if ($errors->any())
    <div class="error-alert">
        <ul class="error-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Visibility Form -->
    <form action="{{ route('instructor.courses.create.visibility.store', ['id' => $course->id]) }}" method="POST" id="visibilityForm">
        @csrf

        <!-- Visibility Settings Section -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-eye"></i>
                    কোর্সের দৃশ্যমানতা
                </h2>

                <div class="form-section">
                    <!-- Course Status Field -->
                    <div class="form-field">
                        <label for="status" class="field-label">
                            <div class="status-indicator">
                                <i class="fas fa-circle"></i>
                                কোর্সের স্ট্যাটাস
                            </div>
                        </label>
                        <select name="status" id="status" class="form-select-modern">
                            <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>
                                খসড়া (অপ্রকাশিত)
                            </option>
                            <option value="published" {{ $course->status == 'published' ? 'selected' : '' }}>
                                প্রকাশিত
                            </option>
                        </select>
                        @error('status')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                        <div class="field-description">
                            খসড়া অবস্থায় কোর্সটি শুধুমাত্র আপনার কাছে দেখা যাবে। প্রকাশিত করলে সবাই দেখতে পাবে।
                        </div>
                    </div>

                    <!-- Review Settings Field -->
                    <div class="form-field">
                        <div class="field-row">
                            <div class="field-content">
                                <label for="allow_review" class="field-label">
                                    কোর্সের জন্য রিভিউ
                                </label>
                                <div class="field-description">
                                    যদি আপনি আপনার কোর্স সম্পর্কে কোন রিভিউ চান না তাহলে চেকমার্ক বন্ধ করে দিন।
                                </div>
                            </div>
                            <div class="field-control">
                                <label class="switch-container">
                                    <input type="checkbox" 
                                           name="allow_review" 
                                           value="1" 
                                           class="switch-input"
                                           id="allow_review"
                                           {{ $course->allow_review == '1' ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>
                        </div>
                        @error('allow_review')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="action-buttons">
            <a href="{{ url('instructor/courses/create/' . $course->id . '/certificate') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                পূর্ববর্তী ধাপ
            </a>
            
            <button type="submit" class="btn-next" id="submitBtn">
                পরবর্তী ধাপ
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const submitBtn = document.getElementById('submitBtn');
    const statusSelect = document.getElementById('status');
    const allowReviewSwitch = document.getElementById('allow_review');
    
    // Status change handler
    statusSelect.addEventListener('change', function() {
        const value = this.value;
        
        // Visual feedback for status change
        if (value === 'published') {
            showNotification('কোর্সটি প্রকাশের জন্য প্রস্তুত। পরবর্তী ধাপে ক্লিক করুন।', 'success');
        } else {
            showNotification('কোর্সটি খসড়া অবস্থায় রাখা হবে।', 'info');
        }
    });
    
    // Review switch change handler
    allowReviewSwitch.addEventListener('change', function() {
        if (this.checked) {
            showNotification('শিক্ষার্থীরা এই কোর্সে রিভিউ দিতে পারবে।', 'info');
        } else {
            showNotification('কোর্সে রিভিউ বন্ধ করা হয়েছে।', 'info');
        }
    });
    
    // Form submission
    document.getElementById('visibilityForm').addEventListener('submit', function(e) {
        
        // Show loading state for submission
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>সংরক্ষণ করা হচ্ছে...';
        submitBtn.disabled = true;
        
        // Reset after potential failure
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 10000);
    });
    
    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg text-white font-medium shadow-lg transform translate-x-full transition-transform duration-300`;
        
        // Set background based on type
        const backgrounds = {
            success: 'bg-gradient-to-r from-green-500 to-green-400',
            error: 'bg-gradient-to-r from-red-500 to-red-400', 
            info: 'bg-gradient-to-r from-blue-500 to-blue-400'
        };
        
        notification.classList.add(backgrounds[type] || backgrounds.info);
        
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            info: 'info-circle'
        };
        
        const icon = icons[type] || icons.info;
        notification.innerHTML = `<i class="fas fa-${icon} mr-2"></i>${message}`;
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        
        // Hide and remove notification
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
    
    // Initialize page
});
</script>
@endsection
