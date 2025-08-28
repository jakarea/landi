@extends('layouts.latest.instructor')
@section('title')
Course Create - Design Step
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
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">Design</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
                    </div>
                   
                    <div class="step-box">
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
                <form action="{{ url('instructor/courses/create/'.$course->id.'/design') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- error message --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{-- error message --}}
                    <div class="top-image-upload-box">
                        <h4>Promo Video URL <sup class="text-danger" style="font-size: 0.8rem">(youtube)</sup> </h4>
                        <input autocomplete="off" type="url" class="mt-2 form-control" name="promo_video" placeholder="Only youtube video"
                            value="{{ $course->promo_video ? $course->promo_video : old('promo_video')  }}">
                        <span class="invalid-feedback d-block">@error('promo_video'){{ $message }}
                            @enderror</span>
                    </div>
                    
                    <div class="top-image-upload-box mt-2">
                        <h4><img src="{{ asset('assets/images/icons/gallery-icon.svg') }}" alt="gallery-icon"
                                class="img-fluid"> Thumbnail</h4>
                        
                        @if ($course->thumbnail)
                        <div class="current-thumbnail mb-3">
                            <img src="{{ asset($course->thumbnail) }}" alt="" class="img-fluid rounded d-block w-100" style="max-height: 300px; object-fit: cover;">
                            <div class="text-center mt-2">
                                <small class="text-muted">Current thumbnail</small>
                            </div>
                        </div>
                        @endif
                        
                        {{-- Drag and drop area with integrated preview --}}
                        <div class="drag-drop-areaa" id="dragDropArea">
                            <input type="file" class="d-none" id="thumbnail" name="thumbnail" accept="image/*">
                            
                            {{-- Default upload interface --}}
                            <div id="uploadInterface">
                                <label for="thumbnail" class="file-up-box">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="gallery-icon"
                                        class="img-fluid light-ele">
                                    <img src="{{ asset('assets/images/icons/upload-5.svg') }}" alt="gallery-icon"
                                        class="img-fluid dark-ele">
                                    <p><label for="thumbnail">Click to upload</label> or drag and drop <br> SVG, PNG, JPG, or
                                        GIF (max. 800x300px)</p>
                                </label>
                            </div>
                            
                            {{-- Preview interface (hidden by default) --}}
                            <div id="previewInterface" style="display: none;">
                                <div class="image-area position-relative">
                                    <img src="" alt="" class="img-fluid rounded d-block w-100" id="thumbnailImage" style="max-height: 300px; object-fit: cover;">
                                    <button class="btn position-absolute" type="button" id="close-button" style="top: 10px; right: 10px; background: rgba(254, 37, 27, 0.9); border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('instructor/courses/create/'.$course->id.'/price')}} ">Back</a>
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

{{-- thumbnail image preview --}}
<script>
    const dragDropArea = document.getElementById('dragDropArea');
    const thumbnailInput = document.getElementById('thumbnail');
    const thumbnailImage = document.getElementById('thumbnailImage');
    const closeButton = document.getElementById('close-button');
    const currentThumbnail = document.querySelector('.current-thumbnail');
    const uploadInterface = document.getElementById('uploadInterface');
    const previewInterface = document.getElementById('previewInterface');

    thumbnailInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            handleFiles([file]);
        }
    });

    dragDropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dragDropArea.classList.add('highlight');
    });

    dragDropArea.addEventListener('dragleave', function () {
        dragDropArea.classList.remove('highlight');
    });

    dragDropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        dragDropArea.classList.remove('highlight');

        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            const fileArray = Array.from(files);
            handleFiles(fileArray);
            
            // Manually set files to input (workaround for security restrictions)
            thumbnailInput.files = files;
        }
    });

    function handleFiles(files) {
        if (!files || files.length === 0) {
            return;
        }

        const file = files[0];
        
        // Check if it's an image file
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            thumbnailImage.src = e.target.result;
            
            // Switch from upload interface to preview interface
            uploadInterface.style.display = 'none';
            previewInterface.style.display = 'block';
            
            // Hide current thumbnail when showing preview
            if (currentThumbnail) {
                currentThumbnail.style.opacity = '0.5';
            }
        };
        reader.readAsDataURL(file);
    }

    if (closeButton) {
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            thumbnailInput.value = '';
            thumbnailImage.src = '';
            
            // Switch back from preview interface to upload interface
            previewInterface.style.display = 'none';
            uploadInterface.style.display = 'block';
            
            // Show current thumbnail again
            if (currentThumbnail) {
                currentThumbnail.style.opacity = '1';
            }
        });
    }
</script>

@endsection
