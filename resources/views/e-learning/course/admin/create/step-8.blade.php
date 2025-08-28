@extends('layouts.latest.admin')
@section('title')
Course Update - Design Step
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
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                {{-- course step --}}
                <div class="course-create-step-wrap">
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a
                                href="{{ url('admin/courses/create', optional(request())->route('id')) }}">Contents</a>
                        </p>
                    </div>
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a>
                        </p>
                    </div>
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/objects' }}">Objects</a>
                        </p>
                    </div>
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/price' }}">Price</a>
                        </p>
                    </div>
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/design' }}">Design</a>
                        </p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/certificate' }}">Certificate</a>
                        </p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/visibility' }}">Visibility</a>
                        </p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a
                                href="{{ url('admin/courses/create',optional(request())->route('id')).'/share' }}">Share</a>
                        </p>
                    </div>
                </div>
                {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="top-image-upload-box">
                        <h4>Promo Video URL <sup class="text-danger" style="font-size: 0.8rem">(youtube)</sup> </h4>
                        <input autocomplete="off" type="url" class="mt-2 form-control" name="promo_video" placeholder="Only youtube video"
                            value="{{ $course->promo_video ? $course->promo_video : old('promo_video')  }}">
                        <span class="invalid-feedback d-block">@error('promo_video'){{ $message }}
                            @enderror</span>
                    </div>
                    <div class="top-image-upload-box mt-2 drag-drop-areaa" id="dragDropArea">
                        <h4><img src="{{ asset('assets/images/icons/gallery-icon.svg') }}" alt="gallery-icon" class="img-fluid"> Thumbnail</h4>
                        <input type="file" class="d-none" id="thumbnail" name="thumbnail">
                        <label for="thumbnail" class="file-up-box">
                            <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="gallery-icon" class="img-fluid light-ele">
                            <img src="{{ asset('assets/images/icons/upload-5.svg') }}" alt="gallery-icon" class="img-fluid dark-ele">
                            <p><label for="thumbnail">Click to upload</label> or drag and drop <br> SVG, PNG, JPG, or GIF (max. 800x300px)</p>
                        </label>
                    </div>
                    
                    {{-- Previous image upload component --}}
                    <div class="top-image-upload-box mt-2"> 
                        @if ($course->thumbnail) 
                            <div class="old-thumb">
                                <img src="{{ asset($course->thumbnail) }}" alt="" class="img-fluid rounded d-block w-100"> 
                            </div>
                        @endif
                        <label class="image-area">
                            <img src="" alt="" class="img-fluid rounded d-block w-100" id="thumbnailImage">
                            <button class="btn" type="button" id="close-button"><i class="fas fa-close"></i></button>
                        </label>
                    </div>

                    <div class="content-settings-form-wrap mt-0">
                        <h4>Appearance Course</h4>
                        <div class="form-group">
                            <input id="name" class="form-control" type="text" value="{{ $course->title }}" required>
                            <label for="name">Appearance Product Overview</label>
                            <span class="d-block mt-3"><img src="{{asset('assets/images/icons/eye-2.svg')}}"
                                    alt="gallery-icon" class="img-fluid"> <a
                                    href="{{url('admin/courses/'.$course->slug)}}" target="_blank">Preview</a></span>
                        </div>
                        <div class="media auto-text">
                            <div class="media-body">
                                <h6>Automatically Add Numbers</h6>
                                <p>For example: Module 1 (Name), Module 2 (Name) etc.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckChecked" checked>
                            </div>
                        </div>
                    </div>

                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('admin/courses/create/'.$course->id.'/price')}} ">Back</a>
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
    const lpBgImageInput = document.getElementById('thumbnail');
    const lpLogoPreview = document.getElementById('thumbnailImage');
    const lpCloseButton = document.getElementById('close-button');
    const oldThumb = document.querySelector('.old-thumb');

    lpCloseButton.style.display = 'none';

    lpBgImageInput.addEventListener('change', function () {
        const file = this.files[0];
        handleFiles([file]);
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
        handleFiles(files);
    });

    function handleFiles(files) {
        if (!files || files.length === 0) {
            return;
        }

        const file = files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                lpLogoPreview.src = e.target.result;
                lpCloseButton.style.display = 'block';
                oldThumb.style.display = 'none';
            };
            reader.readAsDataURL(file);

            // Set the file to the input element
            lpBgImageInput.files = files;
        }
    }

    lpCloseButton.addEventListener('click', function () {
        lpBgImageInput.value = '';
        lpLogoPreview.src = '';
        lpCloseButton.style.display = 'none';
        oldThumb.style.display = 'block';
    });
</script>

@endsection