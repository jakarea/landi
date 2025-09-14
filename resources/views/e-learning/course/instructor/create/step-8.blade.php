@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - ধাপ ৪')
@section('header-title', 'কোর্সের ডিজাইন ও মিডিয়া')
@section('header-subtitle', 'আপনার কোর্সের জন্য আকর্ষণীয় থাম্বনেইল এবং প্রমো ভিডিও যোগ করুন')

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

/* Drag and drop area styling */
.upload-dropzone {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 3px dashed rgba(90, 234, 244, 0.3);
    border-radius: 1rem;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    user-select: none;
}

.upload-dropzone.dragover {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    transform: scale(1.02);
    box-shadow: 0 0 30px rgba(90, 234, 244, 0.2);
}

.upload-dropzone:hover {
    border-color: rgba(90, 234, 244, 0.5);
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.05), rgba(203, 251, 144, 0.02));
}

.upload-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.upload-icon i {
    font-size: 2rem;
    color: #091D3D;
}

.upload-text {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.upload-hint {
    color: #C7C7C7;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.upload-formats {
    color: #9CA3AF;
    font-size: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
}

/* Image preview styling */
.image-preview-container {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    background: #091D3D;
    border: 2px solid rgba(90, 234, 244, 0.3);
}

.image-preview {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(9, 29, 61, 0.8), rgba(90, 234, 244, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.image-preview-container:hover .image-overlay {
    opacity: 1;
}

.image-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.image-action-btn {
    padding: 0.75rem;
    border-radius: 50%;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
}

.btn-change {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    color: #091D3D;
}

.btn-change:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(90, 234, 244, 0.3);
}

.btn-remove {
    background: linear-gradient(135deg, #EF4444, #F87171);
    color: #FFFFFF;
}

.btn-remove:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Current image display */
.current-image-container {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 2rem;
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.2);
}

.current-image-label {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: linear-gradient(135deg, #10B981, #34D399);
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 10;
}

/* Video input styling */
.video-input-container {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.video-input-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #EF4444, #F87171);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.video-input-icon i {
    font-size: 1.5rem;
    color: #FFFFFF;
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

/* File validation feedback */
.validation-feedback {
    margin-top: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.validation-feedback.show {
    opacity: 1;
    transform: translateY(0);
}

.validation-feedback.success {
    background-color: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #34D399;
}

.validation-feedback.error {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #FCA5A5;
}

/* Loading state */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(9, 29, 61, 0.9);
    border-radius: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loading-overlay.show {
    opacity: 1;
    visibility: visible;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 3px solid rgba(90, 234, 244, 0.3);
    border-top: 3px solid #5AEAF4;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-text {
    color: #5AEAF4;
    font-size: 1rem;
    font-weight: 500;
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
    
    .upload-dropzone {
        padding: 2rem 1rem;
        min-height: 250px;
    }
    
    .upload-icon {
        width: 60px;
        height: 60px;
    }
    
    .upload-icon i {
        font-size: 1.5rem;
    }
    
    .upload-text {
        font-size: 1rem;
    }
    
    .video-input-container {
        padding: 1.5rem;
    }
}

/* YouTube URL validation */
.url-validation-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.25rem;
    opacity: 0;
    transition: all 0.3s ease;
}

.url-validation-icon.valid {
    color: #10B981;
    opacity: 1;
}

.url-validation-icon.invalid {
    color: #EF4444;
    opacity: 1;
}

/* Notification system */
.notification {
    position: fixed;
    top: 2rem;
    right: 2rem;
    z-index: 1000;
    max-width: 400px;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.notification.show {
    transform: translateX(0);
}

.notification.success {
    background: linear-gradient(135deg, #10B981, #34D399);
}

.notification.error {
    background: linear-gradient(135deg, #EF4444, #F87171);
}

.notification.info {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="step-progress">
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.facts', ['id' => $course->id]) }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.objectives', ['id' => $course->id]) }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.pricing', ['id' => $course->id]) }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.design', ['id' => $course->id]) }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.content', ['id' => $course->id]) }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.certificate', ['id' => $course->id]) }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.visibility', ['id' => $course->id]) }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.publish', ['id' => $course->id]) }}">প্রকাশ</a>
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

    <!-- Design Form -->
    <form action="{{ route('instructor.courses.create.design.store', ['id' => $course->id]) }}" method="POST" enctype="multipart/form-data" id="designForm">
        @csrf

        <!-- Promo Video Section -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-video"></i>
                    প্রমো ভিডিও URL
                </h2>

                <div class="video-input-container">
                    <div class="flex items-start gap-4">
                        <div class="video-input-icon flex-shrink-0">
                            <i class="fab fa-youtube"></i>
                        </div>
                        <div class="flex-1">
                            <div class="relative">
                                <input 
                                    type="url" 
                                    id="promo_video"
                                    name="promo_video" 
                                    class="form-input-modern pr-12" 
                                    placeholder="https://www.youtube.com/watch?v="
                                    value="{{ $course->promo_video ? $course->promo_video : old('promo_video') }}">
                                <div class="url-validation-icon" id="urlValidationIcon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            @error('promo_video')
                                <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                            @enderror
                            <div class="text-secondary-200 text-sm mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                শুধুমাত্র YouTube ভিডিও URL যোগ করুন। এটি আপনার কোর্সের প্রচারণায় সাহায্য করবে।
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thumbnail Section -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-image"></i>
                    কোর্স থাম্বনেইল
                </h2>

                <!-- Current Thumbnail Display -->
                @if ($course->thumbnail && file_exists(public_path($course->thumbnail)))
                <div class="current-image-container">
                    <div class="current-image-label">
                        <i class="fas fa-check-circle mr-1"></i>
                        বর্তমান থাম্বনেইল
                    </div>
                    <img src="{{ asset($course->thumbnail) }}" 
                         alt="Current Thumbnail" 
                         class="image-preview"
                         id="currentThumbnail"
                         onerror="this.parentElement.style.display='none';">
                    <div class="image-overlay">
                        <div class="image-actions">
                            <button type="button" class="image-action-btn btn-change" onclick="triggerFileInput()">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Upload/Drop Zone with label for reliable file selection -->
                <label for="thumbnailInput" class="upload-dropzone" id="dropZone">
                    <!-- Hidden file input -->
                    <input 
                        type="file" 
                        id="thumbnailInput" 
                        name="thumbnail" 
                        accept="image/*"
                        style="position: absolute; left: -9999px; opacity: 0;">
                        
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">থাম্বনেইল আপলোড করুন</div>
                    <div class="upload-hint">ক্লিক করুন অথবা ফাইল ড্র্যাগ করে ছেড়ে দিন</div>
                    <div class="upload-formats">
                        SVG, PNG, JPG, WebP, GIF (সর্বোচ্চ ৫ MB)
                    </div>
                    
                    <!-- Loading overlay -->
                    <div class="loading-overlay" id="loadingOverlay">
                        <div class="loading-spinner"></div>
                        <div class="loading-text">আপলোড প্রস্তুতি...</div>
                    </div>
                </label>

                <!-- Image Preview Container (hidden by default) -->
                <div class="image-preview-container" id="previewContainer" style="display: none;">
                    <img src="" alt="Preview" class="image-preview" id="previewImage">
                    <div class="image-overlay">
                        <div class="image-actions">
                            <button type="button" class="image-action-btn btn-change" onclick="triggerFileInput()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" class="image-action-btn btn-remove" onclick="removeImage()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Validation feedback -->
                <div class="validation-feedback" id="validationFeedback"></div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="action-buttons">
            <a href="{{ route('instructor.courses.create.pricing', ['id' => $course->id]) }}" class="btn-back">
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
    const dropZone = document.getElementById('dropZone');
    const thumbnailInput = document.getElementById('thumbnailInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const currentThumbnail = document.getElementById('currentThumbnail');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const validationFeedback = document.getElementById('validationFeedback');
    const promoVideoInput = document.getElementById('promo_video');
    const urlValidationIcon = document.getElementById('urlValidationIcon');
    const submitBtn = document.getElementById('submitBtn');

    let hasNewImage = false;
    let droppedFile = null;

    // Check if all required elements exist
    if (!dropZone || !thumbnailInput) {
        return;
    }

    // Drag and drop functionality
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('dragleave', handleDragLeave);
    dropZone.addEventListener('drop', handleDrop);
    
    // Note: Click handling is now automatic via the label element - no JavaScript needed!

    thumbnailInput.addEventListener('change', handleFileSelect);

    function handleDragOver(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        if (!dropZone.contains(e.relatedTarget)) {
            dropZone.classList.remove('dragover');
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            droppedFile = files[0]; // Store the dropped file
            
            // Try to set the files to the input element
            try {
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                thumbnailInput.files = dt.files;
            } catch (error) {
                console.log('DataTransfer not supported, will use FormData instead');
            }
            
            handleFile(files[0]);
        }
    }

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            droppedFile = null; // Clear dropped file when selecting normally
            handleFile(file);
        }
    }

    function handleFile(file) {
        // Show loading
        showLoading();

        // Validate file
        if (!validateFile(file)) {
            hideLoading();
            return;
        }

        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            showPreview();
            hideLoading();
            showValidationFeedback('ফাইল সফলভাবে লোড হয়েছে!', 'success');
            hasNewImage = true;
        };
        reader.onerror = function() {
            hideLoading();
            showValidationFeedback('ফাইল লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', 'error');
        };
        reader.readAsDataURL(file);
    }

    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            showValidationFeedback('অসমর্থিত ফাইল ফরম্যাট। অনুগ্রহ করে JPEG, JPG, PNG, GIF, WebP বা SVG ফাইল ব্যবহার করুন।', 'error');
            return false;
        }

        if (file.size > maxSize) {
            showValidationFeedback('ফাইলের সাইজ অনেক বড়। সর্বোচ্চ ৫ MB আকারের ফাইল আপলোড করুন।', 'error');
            return false;
        }

        return true;
    }

    function showPreview() {
        dropZone.style.display = 'none';
        previewContainer.style.display = 'block';
        
        // Hide current thumbnail when showing new preview
        if (currentThumbnail) {
            currentThumbnail.parentElement.style.opacity = '0.5';
        }
    }

    function showLoading() {
        loadingOverlay.classList.add('show');
    }

    function hideLoading() {
        loadingOverlay.classList.remove('show');
    }

    function showValidationFeedback(message, type) {
        validationFeedback.textContent = message;
        validationFeedback.className = `validation-feedback ${type} show`;
        
        setTimeout(() => {
            validationFeedback.classList.remove('show');
        }, 5000);
    }

    // Global functions for button clicks
    window.triggerFileInput = function() {
        if (thumbnailInput) {
            thumbnailInput.click();
        }
    };

    window.removeImage = function() {
        thumbnailInput.value = '';
        previewImage.src = '';
        previewContainer.style.display = 'none';
        dropZone.style.display = 'flex';
        hasNewImage = false;
        droppedFile = null; // Clear dropped file
        
        // Show current thumbnail again
        if (currentThumbnail) {
            currentThumbnail.parentElement.style.opacity = '1';
        }
        
        showValidationFeedback('ছবি সরানো হয়েছে', 'info');
    };

    // YouTube URL validation
    promoVideoInput.addEventListener('input', function() {
        const url = this.value.trim();
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$/;
        
        if (url === '') {
            urlValidationIcon.classList.remove('valid', 'invalid');
            return;
        }
        
        if (youtubeRegex.test(url)) {
            urlValidationIcon.classList.remove('invalid');
            urlValidationIcon.classList.add('valid');
            urlValidationIcon.innerHTML = '<i class="fas fa-check-circle"></i>';
        } else {
            urlValidationIcon.classList.remove('valid');
            urlValidationIcon.classList.add('invalid');
            urlValidationIcon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
        }
    });

    // Form submission
    document.getElementById('designForm').addEventListener('submit', function(e) {
        
        const promoUrl = promoVideoInput.value.trim();
        
        // Validate YouTube URL if provided
        if (promoUrl && promoUrl !== '') {
            const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$/;
            if (!youtubeRegex.test(promoUrl)) {
                e.preventDefault();
                showNotification('অবৈধ YouTube URL। অনুগ্রহ করে সঠিক YouTube ভিডিও লিঙ্ক দিন।', 'error');
                promoVideoInput.focus();
                return;
            }
        }
        
        // Handle dropped file submission with AJAX if needed
        if (droppedFile && thumbnailInput.files.length === 0) {
            e.preventDefault();
            submitWithFormData();
            return;
        }
        
        // Show loading state for normal submission
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>আপলোড করা হচ্ছে...';
        submitBtn.disabled = true;
        
        // Reset after potential failure
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 10000);
    });
    
    function submitWithFormData() {
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('promo_video', promoVideoInput.value);
        
        if (droppedFile) {
            formData.append('thumbnail', droppedFile);
        } else if (thumbnailInput.files.length > 0) {
            formData.append('thumbnail', thumbnailInput.files[0]);
        }
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>আপলোড করা হচ্ছে...';
        submitBtn.disabled = true;
        
        fetch(document.getElementById('designForm').action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else {
                throw new Error('Upload failed');
            }
        })
        .then(data => {
            // Check if response is a redirect (success)
            if (data.includes('content') || data.includes('redirect')) {
                // Redirect to next step
                window.location.href = document.getElementById('designForm').action.replace('/design', '/content');
            } else {
                showNotification('আপলোড সফল হয়েছে!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        })
        .catch(error => {
            showNotification('আপলোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        const icon = type === 'success' ? 'check-circle' : 
                    type === 'error' ? 'exclamation-circle' : 'info-circle';
        
        notification.innerHTML = `<i class="fas fa-${icon} mr-2"></i>${message}`;
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Hide and remove notification
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Initialize URL validation on page load
    promoVideoInput.dispatchEvent(new Event('input'));
});
</script>
@endsection