@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - সার্টিফিকেট')
@section('header-title', 'কোর্সের সার্টিফিকেট')
@section('header-subtitle', 'আপনার কোর্সের জন্য একটি আকর্ষণীয় সার্টিফিকেট যোগ করুন')
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

/* Certificate upload dropzone styling */
.certificate-dropzone {
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

.certificate-dropzone.highlight {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    transform: scale(1.02);
    box-shadow: 0 0 30px rgba(90, 234, 244, 0.2);
}

.certificate-dropzone:hover {
    border-color: rgba(90, 234, 244, 0.5);
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.05), rgba(203, 251, 144, 0.02));
}

.certificate-upload-icon {
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

.certificate-upload-icon i {
    font-size: 2rem;
    color: #091D3D;
}

.certificate-upload-text {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.certificate-upload-hint {
    color: #C7C7C7;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.certificate-upload-formats {
    color: #9CA3AF;
    font-size: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
}

/* Certificate preview styling */
.certificate-preview-container {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    background: #091D3D;
    border: 2px solid rgba(90, 234, 244, 0.3);
}

.certificate-preview {
    width: 100%;
    max-height: 300px;
    object-fit: contain;
    display: block;
}

.certificate-overlay {
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

.certificate-preview-container:hover .certificate-overlay {
    opacity: 1;
}

.certificate-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.certificate-action-btn {
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

/* Certificate template styling */
.certificate-template-container {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.template-select {
    position: relative;
}

.template-select select {
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

.template-select select:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.template-select select option {
    background: #091D3D;
    color: #FFFFFF;
    padding: 0.5rem;
}

/* Template info */
.template-info {
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(90, 234, 244, 0.05);
    border: 1px solid rgba(90, 234, 244, 0.2);
    border-radius: 0.5rem;
}

.template-info p {
    color: #C7C7C7;
    font-size: 0.875rem;
    margin: 0;
}

.template-info a {
    color: #5AEAF4;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.template-info a:hover {
    color: #CBFB90;
    text-decoration: underline;
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
    
    .certificate-dropzone {
        padding: 2rem 1rem;
        min-height: 250px;
    }
    
    .certificate-upload-icon {
        width: 60px;
        height: 60px;
    }
    
    .certificate-upload-icon i {
        font-size: 1.5rem;
    }
    
    .certificate-upload-text {
        font-size: 1rem;
    }
    
    .certificate-template-container {
        padding: 1.5rem;
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
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
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

    <!-- Certificate Form -->
    <form action="{{ url('instructor/courses/create/'.$course->id.'/certificate') }}" method="POST" enctype="multipart/form-data" id="certificateForm">
        @csrf

        <!-- Certificate Preview Section -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-certificate"></i>
                    সার্টিফিকেট প্রিভিউ
                </h2>

                <!-- Current Certificate Display -->
                @if ($course->sample_certificates && file_exists(public_path($course->sample_certificates)))
                <div class="certificate-preview-container mb-8" id="currentCertificateContainer">
                    <div class="current-certificate-label absolute top-4 left-4 bg-gradient-to-r from-green-500 to-green-400 text-white px-3 py-1 rounded-full text-xs font-semibold z-10">
                        <i class="fas fa-check-circle mr-1"></i>
                        বর্তমান সার্টিফিকেট
                    </div>
                    <img src="{{ asset($course->sample_certificates) }}" 
                         alt="Current Certificate" 
                         class="certificate-preview"
                         id="currentCertificate"
                         onerror="this.parentElement.style.display='none';">
                    <div class="certificate-overlay">
                        <div class="certificate-actions">
                            <button type="button" class="certificate-action-btn btn-change" onclick="triggerCertificateInput()">
                                <i class="fas fa-camera"></i>
                            </button>
                            <button type="button" class="certificate-action-btn btn-remove" onclick="removeCertificate()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Upload/Drop Zone with label for reliable file selection -->
                <label for="certificateInput" class="certificate-dropzone {{ $course->sample_certificates ? 'hidden' : '' }}" id="certificateDropZone">
                    <!-- Hidden file input -->
                    <input 
                        type="file" 
                        id="certificateInput" 
                        name="sample_certificates" 
                        accept="image/*,.pdf"
                        style="position: absolute; left: -9999px; opacity: 0;">
                        
                    <div class="certificate-upload-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="certificate-upload-text">সার্টিফিকেট আপলোড করুন</div>
                    <div class="certificate-upload-hint">ক্লিক করুন অথবা ফাইল ড্র্যাগ করে ছেড়ে দিন</div>
                    <div class="certificate-upload-formats">
                        SVG, PNG, JPG, PDF (সর্বোচ্চ ৫ MB)
                    </div>
                </label>

                <!-- Certificate Preview Container (hidden by default) -->
                <div class="certificate-preview-container hidden mt-8" id="previewContainer">
                    <img src="" alt="Certificate Preview" class="certificate-preview" id="previewImage">
                    <div class="certificate-overlay">
                        <div class="certificate-actions">
                            <button type="button" class="certificate-action-btn btn-change" onclick="triggerCertificateInput()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" class="certificate-action-btn btn-remove" onclick="removeNewCertificate()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @error('sample_certificates')
                    <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Certificate Template Selection -->
        <div class="bg-card rounded-xl shadow-2">
            <div class="p-8">
                <h2 class="section-title">
                    <i class="fas fa-award"></i>
                    সার্টিফিকেট টেমপ্লেট
                </h2>

                <div class="certificate-template-container">
                    <div class="mb-4">
                        <label for="certificateStyle" class="block text-white font-medium mb-2">
                            সার্টিফিকেট নির্বাচন করুন
                        </label>
                        <div class="template-select">
                            <select name="certificateStyle" id="certificateStyle" class="w-full">
                                <option value="">নিচ থেকে নির্বাচন করুন</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}"
                                        {{ $certificate->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $certificate->course? $certificate->course->title: '--' }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('hascertificate')
                            <div class="text-red-400 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="template-info">
                        <p>
                            অথবা আপনি 
                            <a href="{{ url('instructor/certificates') }}" target="_blank">
                                এখানে নতুন সার্টিফিকেট তৈরি করুন
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="action-buttons">
            <a href="{{ url('instructor/courses/create/' . $course->id . '/content') }}" class="btn-back">
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
    const certificateDropZone = document.getElementById('certificateDropZone');
    const certificateInput = document.getElementById('certificateInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const currentCertificateContainer = document.getElementById('currentCertificateContainer');
    const submitBtn = document.getElementById('submitBtn');

    let hasNewCertificate = false;
    let droppedFile = null;

    // Drag and drop functionality
    if (certificateDropZone) {
        certificateDropZone.addEventListener('dragover', handleDragOver);
        certificateDropZone.addEventListener('dragleave', handleDragLeave);
        certificateDropZone.addEventListener('drop', handleDrop);
        // Note: Click handling is now automatic via the label element - no JavaScript needed!
    }

    certificateInput.addEventListener('change', handleFileSelect);

    function handleDragOver(e) {
        e.preventDefault();
        certificateDropZone.classList.add('highlight');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        if (!certificateDropZone.contains(e.relatedTarget)) {
            certificateDropZone.classList.remove('highlight');
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        certificateDropZone.classList.remove('highlight');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            droppedFile = files[0]; // Store the dropped file
            
            // Try to set the files to the input element
            try {
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                certificateInput.files = dt.files;
            } catch (error) {
                // DataTransfer not supported, will use FormData instead
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
        // Validate file
        if (!validateFile(file)) {
            return;
        }

        // Create preview for images, show filename for PDFs
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result);
            };
            reader.onerror = function() {
                showNotification('ফাইল লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', 'error');
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            // For PDFs, show a generic PDF icon or placeholder
            const pdfPreviewUrl = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 24 24' fill='%235AEAF4'%3E%3Cpath d='M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z' /%3E%3C/svg%3E";
            showPreview(pdfPreviewUrl, 'PDF Certificate: ' + file.name);
        }
    }

    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            showNotification('অসমর্থিত ফাইল ফরম্যাট। অনুগ্রহ করে JPG, PNG, GIF, WebP, SVG বা PDF ফাইল ব্যবহার করুন।', 'error');
            return false;
        }

        if (file.size > maxSize) {
            showNotification('ফাইলের সাইজ অনেক বড়। সর্বোচ্চ ৫ MB আকারের ফাইল আপলোড করুন।', 'error');
            return false;
        }

        return true;
    }

    // Show preview section
    function showPreview(imageSrc, altText = 'Certificate Preview') {
        previewImage.src = imageSrc;
        previewImage.alt = altText;
        previewContainer.classList.remove('hidden');
        certificateDropZone.classList.add('hidden');
        hasNewCertificate = true;
        
        // Hide current certificate when showing new preview
        if (currentCertificateContainer) {
            currentCertificateContainer.style.opacity = '0.5';
        }
        
        showNotification('সার্টিফিকেট সফলভাবে লোড হয়েছে!', 'success');
    }

    // Reset file input
    function resetFileInput() {
        certificateInput.value = '';
        droppedFile = null;
    }

    // Global functions for button clicks
    window.triggerCertificateInput = function() {
        certificateInput.click();
    };

    window.removeNewCertificate = function() {
        certificateInput.value = '';
        previewImage.src = '';
        previewContainer.classList.add('hidden');
        certificateDropZone.classList.remove('hidden');
        hasNewCertificate = false;
        droppedFile = null;
        
        // Show current certificate again
        if (currentCertificateContainer) {
            currentCertificateContainer.style.opacity = '1';
        }
        
        showNotification('সার্টিফিকেট সরানো হয়েছে', 'info');
    };

    // Remove existing certificate
    window.removeCertificate = function() {
        if (confirm('আপনি কি নিশ্চিত যে সার্টিফিকেটটি মুছে ফেলতে চান?')) {
            // Get course ID from URL
            const pathParts = window.location.pathname.split('/');
            const courseId = pathParts[pathParts.indexOf('create') + 1];
            
            // Show loading notification
            showNotification('সার্টিফিকেট মুছে ফেলা হচ্ছে...', 'info');
            
            // Make AJAX call to remove certificate from database
            fetch(`/instructor/courses/create/${courseId}/certificate/remove`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]')?.value,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide current certificate container
                    if (currentCertificateContainer) {
                        currentCertificateContainer.classList.add('hidden');
                    }
                    // Show upload section
                    certificateDropZone.classList.remove('hidden');
                    showNotification('সার্টিফিকেট সফলভাবে মুছে ফেলা হয়েছে', 'success');
                } else {
                    throw new Error(data.error || 'সার্টিফিকেট মুছে ফেলতে ব্যর্থ');
                }
            })
            .catch(error => {
                showNotification('সার্টিফিকেট মুছে ফেলতে সমস্যা হয়েছে: ' + error.message, 'error');
            });
        }
    };

    // Form submission
    document.getElementById('certificateForm').addEventListener('submit', function(e) {
        
        // Handle dropped file submission with AJAX if needed
        if (droppedFile && certificateInput.files.length === 0) {
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
        
        // Add certificate style
        const certificateStyle = document.getElementById('certificateStyle').value;
        formData.append('certificateStyle', certificateStyle);
        
        if (droppedFile) {
            formData.append('sample_certificates', droppedFile);
        } else if (certificateInput.files.length > 0) {
            formData.append('sample_certificates', certificateInput.files[0]);
        }
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>আপলোড করা হচ্ছে...';
        submitBtn.disabled = true;
        
        fetch(document.getElementById('certificateForm').action, {
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
            if (data.includes('visibility') || data.includes('redirect')) {
                // Redirect to next step
                window.location.href = document.getElementById('certificateForm').action.replace('/certificate', '/visibility');
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
});
</script>
@endsection
