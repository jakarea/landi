@extends('layouts.instructor-tailwind')
@section('title', 'ভিডিও আপলোড - কোর্স তৈরি করুন')
@section('header-title', 'ভিডিও কন্টেন্ট আপলোড')
@section('header-subtitle', 'আপনার লেসনের জন্য ভিডিও যোগ করুন')

@section('style')
<style>
/* Video upload specific styles */
.video-type-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.video-type-option {
    position: relative;
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #C7C7C7;
}

.video-type-option:hover {
    border-color: rgba(90, 234, 244, 0.3);
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
}

.video-type-option.selected {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.2), rgba(203, 251, 144, 0.1));
    color: #5AEAF4;
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(90, 234, 244, 0.2);
}

.video-type-option.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: linear-gradient(135deg, #374151, #4B5563);
}

.video-type-option i {
    font-size: 2rem;
    margin-bottom: 0.75rem;
    display: block;
}

.video-type-option h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: inherit;
}

.video-type-option p {
    font-size: 0.875rem;
    opacity: 0.8;
    margin: 0;
}

.video-type-option input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

/* Upload zone styling */
.upload-zone {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 3px dashed rgba(90, 234, 244, 0.3);
    border-radius: 1.5rem;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.upload-zone:hover {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    transform: scale(1.02);
}

.upload-zone.dragover {
    border-color: #CBFB90;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.2), rgba(203, 251, 144, 0.1));
    transform: scale(1.05);
}

.upload-zone.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: linear-gradient(135deg, #374151, #4B5563);
}

.upload-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.upload-icon i {
    font-size: 2rem;
    color: #091D3D;
}

.upload-text {
    color: #FFFFFF;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.upload-subtext {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

.file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

/* Progress bar styling */
.progress-container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1rem;
    display: none;
}

.progress-container.show {
    display: block;
    animation: slideInUp 0.5s ease;
}

.progress-bar-container {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    height: 8px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-radius: 0.5rem;
    transition: width 0.3s ease;
    width: 0%;
}

.progress-text {
    color: #FFFFFF;
    font-weight: 600;
    text-align: center;
    margin-bottom: 0.5rem;
}

.progress-warning {
    color: #F59E0B;
    font-size: 0.875rem;
    text-align: center;
}

/* Current video preview */
.current-video-preview {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.video-preview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.video-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.video-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #EF4444, #F87171);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.video-icon i {
    color: #FFFFFF;
    font-size: 1.5rem;
}

.video-details h4 {
    color: #FFFFFF;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.video-details p {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin: 0;
}

.video-actions button {
    background: rgba(239, 68, 68, 0.2);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #EF4444;
    padding: 0.75rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.video-actions button:hover {
    background: rgba(239, 68, 68, 0.3);
    border-color: #EF4444;
    transform: scale(1.1);
}

/* YouTube section styling */
.youtube-section {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.2);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.youtube-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #EF4444, #F87171);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.youtube-icon i {
    font-size: 1.75rem;
    color: #FFFFFF;
}

/* Form styling */
.form-group-modern {
    margin-bottom: 1.5rem;
}

.form-label-modern {
    display: block;
    color: #FFFFFF;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-input-modern {
    width: 100%;
    padding: 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
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

.form-textarea-modern {
    width: 100%;
    padding: 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
    color: #FFFFFF;
    font-size: 1rem;
    min-height: 120px;
    resize: vertical;
    transition: all 0.3s ease;
    outline: none;
}

.form-textarea-modern:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-help {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.error-message {
    color: #EF4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Warning alerts */
.warning-alert {
    background: rgba(245, 158, 11, 0.1);
    border: 2px solid rgba(245, 158, 11, 0.3);
    color: #F59E0B;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.danger-alert {
    background: rgba(239, 68, 68, 0.1);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #EF4444;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Navigation buttons */
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
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    border-color: #F97316;
    color: #F97316;
    background-color: rgba(249, 115, 22, 0.1);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
    border-radius: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .video-type-selector {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-back,
    .btn-submit {
        width: 100%;
        justify-content: center;
    }
    
    .upload-zone {
        padding: 2rem 1rem;
    }
    
    .video-preview-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .video-info {
        width: 100%;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl p-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $vimeoConnected = isVimeoConnected(auth()->user()->id)[1] === 'Connected';
    @endphp

    <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Video Upload Card -->
        <div class="bg-card rounded-xl shadow-2 p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">ভিডিও কন্টেন্ট আপলোড করুন</h2>
                <p class="text-secondary-200">আপনার লেসনের জন্য ভিডিও নির্বাচন করুন</p>
            </div>

            <!-- Video Type Selection -->
            <div class="mb-8">
                <h3 class="form-label-modern mb-4">
                    <i class="fas fa-video mr-2"></i>
                    ভিডিও ধরন নির্বাচন করুন
                </h3>
                <div class="video-type-selector">
                    <label class="video-type-option {{ $vimeoConnected ? '' : 'disabled' }} {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'vimeo' ? 'selected' : '' }}">
                        <input type="radio" name="video_type" value="vimeo" 
                               {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'vimeo' ? 'checked' : '' }}
                               {{ !$vimeoConnected ? 'disabled' : '' }}>
                        <i class="fab fa-vimeo-v"></i>
                        <h4>Vimeo আপলোড</h4>
                        <p>সরাসরি ভিডিও ফাইল আপলোড করুন</p>
                        @if(!$vimeoConnected)
                            <small class="text-red-400">(সংযুক্ত নয়)</small>
                        @endif
                    </label>
                    
                    <label class="video-type-option {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'youtube' ? 'selected' : '' }}">
                        <input type="radio" name="video_type" value="youtube"
                               {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'youtube' ? 'checked' : '' }}>
                        <i class="fab fa-youtube"></i>
                        <h4>YouTube ভিডিও</h4>
                        <p>YouTube ভিডিও লিংক যোগ করুন</p>
                    </label>
                </div>

                @if(!$vimeoConnected)
                    <div class="warning-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Vimeo অ্যাকাউন্ট সংযুক্ত নয়।</strong><br>
                            <a href="{{ route('instructor.profile.settings') }}" target="_blank" class="text-cyan underline">
                                Vimeo অ্যাকাউন্ট সংযুক্ত করুন
                            </a> অথবা YouTube বিকল্প ব্যবহার করুন।
                        </div>
                    </div>
                @endif
            </div>

            <!-- Vimeo Upload Section -->
            <div id="vimeo_upload_section" class="mb-8" style="{{ old('video_type', $lesson->video_type ?? 'vimeo') == 'vimeo' ? '' : 'display: none;' }}">
                <div class="upload-zone {{ !$vimeoConnected ? 'disabled' : '' }}" onclick="{{ $vimeoConnected ? 'document.getElementById(\'uploadFile\').click()' : '' }}">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">
                        @if($vimeoConnected)
                            এখানে ক্লিক করুন বা ভিডিও ড্র্যাগ করুন
                        @else
                            Vimeo সংযুক্ত নয়
                        @endif
                    </div>
                    <p class="upload-subtext">
                        @if($vimeoConnected)
                            সমর্থিত ফরম্যাট: MP4, MOV, AVI, WMV, FLV, MKV (সর্বোচ্চ 2GB)
                        @else
                            ভিডিও আপলোড করতে Vimeo অ্যাকাউন্ট সংযুক্ত করুন
                        @endif
                    </p>
                    
                    <input type="file" 
                           id="uploadFile" 
                           name="video_link" 
                           class="file-input"
                           accept=".mp4,.mov,.avi,.wmv,.flv,.mkv"
                           {{ !$vimeoConnected ? 'disabled' : '' }}>
                </div>

                <input type="hidden" name="duration" id="duration">
                <div id="preview"></div>

                <!-- Progress Container -->
                <div class="progress-container" id="uploadProgress">
                    <div class="progress-text" id="progressText">0%</div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" id="progressBarFill"></div>
                    </div>
                    <p class="progress-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ভিডিও আপলোড করার সময় ব্রাউজার বন্ধ করবেন না বা পেজ পরিবর্তন করবেন না
                    </p>
                </div>

                <div id="videoErrorMessage" class="error-message" style="display: none;">
                    @error('video_link')
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    @enderror
                </div>

                @if(!$vimeoConnected)
                    <div class="danger-alert">
                        <i class="fas fa-times-circle"></i>
                        <div>
                            <strong>Vimeo আপলোড নিষ্ক্রিয়।</strong><br>
                            ভিডিও আপলোড করতে <a href="{{ route('instructor.profile.settings') }}" target="_blank" class="text-cyan underline">আপনার Vimeo অ্যাকাউন্ট সংযুক্ত করুন</a>।
                        </div>
                    </div>
                @endif
            </div>

            <!-- Current Video Preview -->
            @if ($lesson->video_link)
                <div class="current-video-preview mb-8">
                    <h4 class="form-label-modern mb-4">
                        <i class="fas fa-play mr-2"></i>
                        বর্তমান ভিডিও
                    </h4>
                    <div class="video-preview-header">
                        <div class="video-info">
                            <div class="video-icon">
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-details">
                                @if($lesson->video_type == 'youtube')
                                    <h4>YouTube ভিডিও</h4>
                                    <p>URL: {{ $lesson->video_link }}</p>
                                @else
                                    <h4>{{ $lesson->slug . '.mp4' }}</h4>
                                    <p>Vimeo ভিডিও</p>
                                @endif
                                <p>আপডেট হয়েছে: {{ $lesson->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="video-actions">
                            <button type="button" onclick="if(confirm('আপনি কি নিশ্চিত যে এই ভিডিওটি মুছে ফেলতে চান?')) { window.location.href='{{ url('instructor/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id.'/remove') }}' }">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- YouTube URL Section -->
            <div id="youtube_url_section" class="mb-8" style="{{ old('video_type', $lesson->video_type ?? 'vimeo') == 'youtube' ? 'display: block;' : 'display: none;' }}">
                <div class="youtube-section">
                    <div class="youtube-icon">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <h4 class="form-label-modern text-center mb-6">YouTube ভিডিও যোগ করুন</h4>
                    
                    <div class="form-group-modern">
                        <label for="youtube_url" class="form-label-modern">
                            <i class="fas fa-link mr-2"></i>
                            YouTube ভিডিও URL
                        </label>
                        <input type="url" 
                               id="youtube_url" 
                               name="youtube_url" 
                               class="form-input-modern" 
                               placeholder="https://www.youtube.com/watch?v=..."
                               value="{{ old('youtube_url', $lesson->video_type == 'youtube' ? $lesson->video_link : '') }}"
                               pattern="^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$">
                        <p class="form-help">
                            একটি বৈধ YouTube URL প্রবেশ করান (youtube.com/watch এবং youtu.be ফরম্যাট সমর্থিত)
                        </p>
                        <div id="youtubeErrorMessage" class="error-message" style="display: none;">
                            @error('youtube_url')
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label for="youtube_duration" class="form-label-modern">
                            <i class="fas fa-clock mr-2"></i>
                            ভিডিও সময়কাল (সেকেন্ডে)
                        </label>
                        <input type="number" 
                               id="youtube_duration" 
                               name="youtube_duration" 
                               class="form-input-modern" 
                               min="1" 
                               placeholder="যেমন: ৩০০ (৫ মিনিটের জন্য)"
                               value="{{ old('youtube_duration', $lesson->video_type == 'youtube' && $lesson->duration ? $lesson->duration : '') }}">
                        <p class="form-help">
                            ভিডিওর সময়কাল সেকেন্ডে প্রবেশ করান (যেমন: ৫ মিনিটের ভিডিওর জন্য ৩০০)
                        </p>
                        <div id="youtubeDurationErrorMessage" class="error-message" style="display: none;">
                            @error('youtube_duration')
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Short Description -->
            <div class="form-group-modern">
                <label for="description" class="form-label-modern">
                    <i class="fas fa-align-left mr-2"></i>
                    ভিডিওর সংক্ষিপ্ত বিবরণ
                </label>
                <textarea id="description" 
                          name="short_description" 
                          class="form-textarea-modern" 
                          placeholder="এই ভিডিও সম্পর্কে সংক্ষিপ্ত বিবরণ লিখুন...">{!! $lesson->short_description !!}</textarea>
                <div class="error-message" style="display: none;">
                    @error('short_description')
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="action-buttons">
            <a href="{{ url('instructor/courses/create/'.$lesson->course_id.'/content') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                পূর্ববর্তী ধাপ
            </a>
            <button type="submit" class="btn-submit">
                পরবর্তী ধাপ
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>
@endsection
{{-- page content @E --}}

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var baseUrl = "{{ url('') }}";
var currentURL = window.location.href;
var urlObject = new URL(currentURL);
var pathname = urlObject.pathname;
var pathnameParts = pathname.split('/');
var course_id = pathnameParts[4];
var module_id = pathnameParts[6];
var lesson_id = pathnameParts[8];

// Modern drag and drop functionality
function initializeDragAndDrop() {
    const uploadZone = document.querySelector('.upload-zone');
    const fileInput = document.getElementById('uploadFile');
    
    if (!uploadZone || !fileInput) return;
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    uploadZone.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        uploadZone.classList.add('dragover');
    }

    function unhighlight() {
        uploadZone.classList.remove('dragover');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelection(files[0]);
        }
    }
}

function handleFileSelection(file) {
    // Validate file type
    const allowedExtensions = /\.(mp4|mov|avi|wmv|flv|mkv)$/i;
    if (!allowedExtensions.test(file.name)) {
        showNotification('অবৈধ ফাইল টাইপ। শুধুমাত্র ভিডিও ফাইল সমর্থিত।', 'error');
        document.getElementById('uploadFile').value = '';
        return false;
    }

    // Update UI to show selected file
    const uploadText = document.querySelector('.upload-text');
    const uploadSubtext = document.querySelector('.upload-subtext');
    const uploadIcon = document.querySelector('.upload-icon i');
    
    if (uploadText) uploadText.textContent = file.name;
    if (uploadSubtext) uploadSubtext.textContent = `ফাইল নির্বাচিত: ${(file.size / (1024*1024)).toFixed(2)} MB`;
    if (uploadIcon) uploadIcon.className = 'fas fa-check-circle';
    
    return true;
}

// Video type selection handling
function handleVideoTypeSelection() {
    const videoTypeOptions = document.querySelectorAll('.video-type-option');
    const radioInputs = document.querySelectorAll('input[name="video_type"]');
    
    videoTypeOptions.forEach(option => {
        option.addEventListener('click', function() {
            if (this.classList.contains('disabled')) return;
            
            const input = this.querySelector('input[type="radio"]');
            if (input && !input.disabled) {
                input.checked = true;
                updateVideoTypeUI(input.value);
                triggerVideoTypeChange(input.value);
            }
        });
    });
    
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateVideoTypeUI(this.value);
            triggerVideoTypeChange(this.value);
        });
    });
}

function updateVideoTypeUI(selectedType) {
    // Update visual selection
    document.querySelectorAll('.video-type-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    const selectedOption = document.querySelector(`input[value="${selectedType}"]`)?.closest('.video-type-option');
    if (selectedOption) {
        selectedOption.classList.add('selected');
    }
}

function triggerVideoTypeChange(selectedType) {
    const vimeoSection = document.getElementById('vimeo_upload_section');
    const youtubeSection = document.getElementById('youtube_url_section');
    
    if (selectedType === 'youtube') {
        if (vimeoSection) vimeoSection.style.display = 'none';
        if (youtubeSection) youtubeSection.style.display = 'block';
    } else {
        if (vimeoSection) vimeoSection.style.display = 'block';
        if (youtubeSection) youtubeSection.style.display = 'none';
    }
}

// Form validation and submission
function initializeFormHandling() {
    const form = document.getElementById('uploadForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        const videoType = document.querySelector('input[name="video_type"]:checked')?.value;
        const fileInput = document.getElementById('uploadFile');
        const youtubeUrl = document.getElementById('youtube_url');

        // Clear previous error messages
        clearErrorMessages();

        if (videoType === 'youtube') {
            // YouTube validation
            if (!youtubeUrl?.value.trim()) {
                e.preventDefault();
                showError('youtubeErrorMessage', 'YouTube URL প্রবেশ করান');
                return false;
            }
            
            const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$/;
            if (!youtubeRegex.test(youtubeUrl.value.trim())) {
                e.preventDefault();
                showError('youtubeErrorMessage', 'বৈধ YouTube URL প্রবেশ করান (যেমন: https://www.youtube.com/watch?v=...)');
                return false;
            }
            
            return true; // Allow form submission for YouTube
        }

        // Vimeo file upload handling
        if (fileInput && fileInput.files.length > 0) {
            e.preventDefault();
            startFileUpload();
            return false;
        } else {
            e.preventDefault();
            showNotification('একটি ভিডিও ফাইল নির্বাচন করুন', 'error');
            return false;
        }
    });
}

function startFileUpload() {
    const fileInput = document.getElementById('uploadFile');
    const submitBtn = document.querySelector('.btn-submit');
    const progressContainer = document.getElementById('uploadProgress');
    const progressText = document.getElementById('progressText');
    const progressBarFill = document.getElementById('progressBarFill');
    
    // Show progress container
    if (progressContainer) {
        progressContainer.classList.add('show');
    }
    
    // Disable submit button and show loading state
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>আপলোড হচ্ছে...';
    }

    const formData = new FormData(document.getElementById('uploadForm'));
    const selectedFile = fileInput.files[0];
    const fileSizeBytes = selectedFile.size;
    const fileSizeMB = fileSizeBytes / (1024 * 1024);

    // Progress simulation
    let currentPercentage = 0;
    const maxPercentage = Math.floor(Math.random() * 15) + 85;
    const progressPercentage = Math.max(1, Math.floor(70 / fileSizeMB));
    
    const progressInterval = setInterval(() => {
        const increment = Math.ceil(progressPercentage * (Math.random() * 0.5 + 0.75));
        currentPercentage += increment;
        
        if (currentPercentage >= maxPercentage) {
            currentPercentage = maxPercentage;
            clearInterval(progressInterval);
        }
        
        updateProgress(currentPercentage);
    }, 500 + Math.random() * 1000);

    // AJAX upload
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            clearInterval(progressInterval);
            updateProgress(100);
            
            setTimeout(() => {
                showNotification('ভিডিও সফলভাবে আপলোড হয়েছে!', 'success');
                setTimeout(() => {
                    window.location.href = baseUrl + '/instructor/courses/create/' + course_id + '/lesson/' + module_id + '/institute/' + lesson_id;
                }, 1500);
            }, 500);
        },
        error: function(xhr) {
            clearInterval(progressInterval);
            hideProgress();
            
            const errors = xhr.responseJSON?.errors || {};
            if (errors.video_link) {
                showError('videoErrorMessage', errors.video_link[0]);
            } else {
                showNotification('আপলোড করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
            }
            
            // Reset submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'পরবর্তী ধাপ <i class="fas fa-arrow-right ml-2"></i>';
            }
        }
    });
}

function updateProgress(percentage) {
    const progressText = document.getElementById('progressText');
    const progressBarFill = document.getElementById('progressBarFill');
    
    if (progressText) progressText.textContent = percentage + '%';
    if (progressBarFill) progressBarFill.style.width = percentage + '%';
}

function hideProgress() {
    const progressContainer = document.getElementById('uploadProgress');
    if (progressContainer) {
        progressContainer.classList.remove('show');
    }
}

// Error handling functions
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.style.display = 'flex';
        errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i>' + message;
    }
}

function clearErrorMessages() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(element => {
        element.style.display = 'none';
        element.innerHTML = '';
    });
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
    } else if (type === 'error') {
        notification.classList.add('bg-red-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
    } else {
        notification.classList.add('bg-blue-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-info-circle mr-2"></i>${message}`;
    }
    
    document.body.appendChild(notification);
    
    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Slide out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
    handleVideoTypeSelection();
    initializeFormHandling();
    
    // Set initial video type selection
    const selectedType = document.querySelector('input[name="video_type"]:checked')?.value || 'vimeo';
    updateVideoTypeUI(selectedType);
    triggerVideoTypeChange(selectedType);
    
    // Handle file input change
    const fileInput = document.getElementById('uploadFile');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelection(e.target.files[0]);
            }
        });
    }
});
</script>
@endsection