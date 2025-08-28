@extends('layouts.latest.instructor')
@section('title')
    Course Create - Certificate
@endsection
{{-- page style @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .image-area {
            position: relative;
        }

        #close-button {
            position: absolute;
            right: -10px;
            top: -10px;
            width: 2.2rem;
            height: 2.2rem;
            border-radius: 6px;
            background: #fe251b;
            display: none;
        }

        #close-button i {
            color: #fff;
        }

        .drag-drop-areaa {
            border: 2px dashed #666;
            padding: 20px;
            text-align: center;
        }

        .drag-drop-areaa.highlight {
            background-color: #f0f0f0;
        }
        
        .link.blue{
            color: #294CFF;
        }
        
        .certificate-preview-container {
            margin: 15px 0;
        }
        
        .preview-image-wrapper {
            position: relative;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
        
        .preview-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }
        
        .preview-controls .btn {
            padding: 5px 8px;
            font-size: 12px;
            border-radius: 4px;
            opacity: 0.9;
        }
        
        .preview-controls .btn:hover {
            opacity: 1;
        }
        
        #previewImage {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        
        .file-up-box {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-up-box:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <main class="course-create-step-page-wrap">
        <div class="container-fluid">
            <div class="row justify-content-center position-relative">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    {{-- course step --}}
                    <div class="course-create-step-wrap">
                    
                    <div class="step-box active">
                        <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a></p>
                    </div>
                    <div class="step-box active">
                        <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">Objects</a></p>
                    </div>
                    <div class="step-box active">
                        <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">Price</a></p>
                    </div>
                     <div class="step-box active">
                        <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">Design</a></p>
                    </div>
                   
                    <div class="step-box active">
                        <span class="circle ">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
                    </div>

                    <div class="step-box current">
                        <span class="circle"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">Certificate</a></p>
                    </div>

                    
                    
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/visibility' }}">Visibility</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/share' }}">Share</a></p>
                    </div>
                </div>
                    {{-- course step --}}
                    
                    @if ( session()->has('course_id') )
                        @include('e-learning.course.instructor.create.save-finish')
                    @endif
                </div>
                
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    <form action="{{ url('instructor/courses/create/'.$course->id.'/certificate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="top-image-upload-box drag-drop-areaa" id="dragDropArea">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h4><img src="{{ asset('assets/images/icons/gallery-icon.svg') }}" alt="gallery-icon"
                                    class="img-fluid">Certificate Preview</h4>
                            
                            {{-- Preview section - shows either existing certificate or new upload --}}
                            <div id="certificatePreview" class="certificate-preview-container" style="{{ $course->sample_certificates ? '' : 'display: none;' }}">
                                <div class="preview-image-wrapper position-relative">
                                    <img id="previewImage" 
                                         src="{{ $course->sample_certificates ? asset($course->sample_certificates) : '' }}" 
                                         alt="Certificate Preview" 
                                         class="img-fluid rounded d-block w-100" 
                                         style="max-height: 300px; object-fit: contain;">
                                    <div class="preview-controls">
                                        <button type="button" id="removeButton" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                        <button type="button" id="changeButton" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Change
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Upload section - shows when no certificate is selected --}}
                            <div id="uploadSection" class="{{ $course->sample_certificates ? 'd-none' : '' }}">
                                <input type="file" class="d-none" id="thumbnail" name="sample_certificates" accept="image/*,.pdf">
                                <label for="thumbnail" class="file-up-box">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="gallery-icon"
                                        class="img-fluid light-ele">
                                    <img src="{{ asset('assets/images/icons/upload-5.svg') }}" alt="gallery-icon"
                                        class="img-fluid dark-ele">
                                    <p><label for="thumbnail">Click to upload</label> or drag and drop <br> SVG, PNG, JPG or PDF (max. 5MB)</p>
                                </label>
                            </div>
                            
                            <span class="invalid-feedback">
                                @error('sample_certificates')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="content-settings-form-wrap mt-0">
                            <h4>Certificate</h4>
                            <hr>
                            <div class="form-group">
                                <h6>Select Certificate</h6>
                                <select class="form-control" name="certificateStyle">
                                    <option value="">Select Below</option>
                                    @foreach ($certificates as $certificate)
                                        <option value="{{ $certificate->id }}"
                                            {{ $certificate->course_id == $course->id ? 'selected' : '' }}>
                                            {{ $certificate->course? $certificate->course->title: '--' }}</option>
                                    @endforeach
                                </select>
                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" alt="arrow-down"
                                    class="img-fluid euro" style="top: 3rem">
                                <span class="invalid-feedback">
                                    @error('hascertificate')
                                        {{ $message }}
                                    @enderror
                                </span>
                                
                               
                                    <div class="mt-3">
                                        <p class="text-muted">Or you can <a href="{{ url('instructor/profile/account-settings?tab=certificate') }}" 
                                           class="link blue" target="_blank">create new certificate</a> from here.</p>
                                        
                                    </div>
                                
                            </div>
                            <hr class="mb-0">
                        </div>

                        {{-- step next bttns --}}
                        <div class="back-next-bttns">
                            <a href="{{ url('instructor/courses/create/' . $course->id . '/design') }}">Back</a>
                            <button class="btn btn-primary" type="submit">Next</button>
                        </div>
                        {{-- step next bttns --}}
                    </form>
                </div>
            </div>
    </main>
@endsection
{{-- page content @E --}}

@section('script')
    {{-- Certificate preview and upload functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dragDropArea = document.getElementById('dragDropArea');
            const fileInput = document.getElementById('thumbnail');
            const previewContainer = document.getElementById('certificatePreview');
            const previewImage = document.getElementById('previewImage');
            const uploadSection = document.getElementById('uploadSection');
            const removeButton = document.getElementById('removeButton');
            const changeButton = document.getElementById('changeButton');
            
            // File input change handler
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    handleFileSelection(file);
                }
            });

            // Drag and drop handlers
            dragDropArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                dragDropArea.classList.add('highlight');
            });

            dragDropArea.addEventListener('dragleave', function() {
                dragDropArea.classList.remove('highlight');
            });

            dragDropArea.addEventListener('drop', function(e) {
                e.preventDefault();
                dragDropArea.classList.remove('highlight');
                
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    const file = files[0];
                    
                    // Set the file to the input element
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                    
                    handleFileSelection(file);
                }
            });

            // Handle file selection and preview
            function handleFileSelection(file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/gif', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, SVG, GIF) or PDF.');
                    resetFileInput();
                    return;
                }

                // Validate file size (5MB limit)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB.');
                    resetFileInput();
                    return;
                }

                // Show preview for images, show filename for PDFs
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        showPreview(e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    // For PDFs, show a generic PDF icon or placeholder
                    const pdfPreviewUrl = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 24 24' fill='%23dc3545'%3E%3Cpath d='M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z' /%3E%3C/svg%3E";
                    showPreview(pdfPreviewUrl, 'PDF Certificate: ' + file.name);
                }
            }

            // Show preview section
            function showPreview(imageSrc, altText = 'Certificate Preview') {
                previewImage.src = imageSrc;
                previewImage.alt = altText;
                previewContainer.style.display = 'block';
                uploadSection.classList.add('d-none');
            }

            // Hide preview section
            function hidePreview() {
                previewContainer.style.display = 'none';
                uploadSection.classList.remove('d-none');
                previewImage.src = '';
            }

            // Reset file input
            function resetFileInput() {
                fileInput.value = '';
            }

            // Remove button handler
            removeButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove the certificate?')) {
                    // Get course ID from URL
                    const pathParts = window.location.pathname.split('/');
                    const courseId = pathParts[pathParts.indexOf('create') + 1];
                    
                    // Show loading state
                    removeButton.disabled = true;
                    removeButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Removing...';
                    
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
                            // Reset UI state
                            resetFileInput();
                            hidePreview();
                            // Show success message briefly
                            const successMsg = document.createElement('div');
                            successMsg.className = 'alert alert-success mt-2';
                            successMsg.innerHTML = data.message;
                            dragDropArea.appendChild(successMsg);
                            setTimeout(() => {
                                if (successMsg.parentNode) {
                                    successMsg.parentNode.removeChild(successMsg);
                                }
                            }, 3000);
                        } else {
                            throw new Error(data.error || 'Failed to remove certificate');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to remove certificate: ' + error.message);
                    })
                    .finally(() => {
                        // Reset button state
                        removeButton.disabled = false;
                        removeButton.innerHTML = '<i class="fas fa-times"></i> Remove';
                    });
                }
            });

            // Change button handler
            changeButton.addEventListener('click', function() {
                fileInput.click();
            });

            // Note: Upload section click is handled by the native label[for="thumbnail"] behavior
            // No additional click handler needed to avoid duplicate file dialogs
        });
    </script>
@endsection
