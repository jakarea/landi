@extends('layouts.latest.admin')
@section('title')
Course Create - Step 4
@endsection
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="course-create-step-page-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-4 col-xl-3">
                {{-- course step --}}
                {{-- add class "active" to "step-box" for the done step and add a checkmark image icon inside "circle"
                class --}}
                {{-- add class "current" to "step-box" for the current step --}}
                <div class="course-create-step-wrap page-create-step">
                    <div class="step-box current">
                        <span class="circle">
                            {{-- <img src="{{asset('assets/images/icons/check-mark.svg')}}" alt="icon"
                                class="img-fluid"> --}}
                        </span>
                        <p>Content</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Institutions</p>
                    </div>
                </div>
                {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="highlighted-area-upload">
                    <img src="{{asset('assets/images/icons/big-audio.svg')}}" alt="a" class="img-fluid">

                    <p><label for="audio">Click here</label> to set the highlighted audio</p>
                </div> 
                
                <div class="lesson-edit-form-wrap course-content-box course-page-edit-box flex-column mt-2 align-items-start" id="frontAudio">
                    <h4>Uploading Audio:</h4>
                    <div class="title d-flex w-100 justify-content-between">
                        <div class="media">
                            <img id="audio-thumbnail" src="{{asset('assets/images/icons/big-audio.svg')}}" alt="Audio" class="img-fluid" style="width: 2rem"> 
                            <div class="media-body">
                                <h5 id="file-name"></h5> 
                                <p>Size:  <span id="file-size"></span> MB</p>
                            </div>
                        </div>
                        <div>
                            <a href="javascript:void(0)" class="text-danger cursor-pointer" id="remove-audio">
                                <i class="fas fa-close"></i>
                            </a>
                        </div>
                    </div>
                </div> 
                {{-- uploaded audio preview --}}

                @if ($lesson->audio) 
                <div class="lesson-edit-form-wrap course-content-box course-page-edit-box flex-column mt-2 align-items-start" id="dbAudio">
                    <h4>Current Audio:</h4>
                    <div class="title d-flex w-100 justify-content-between">
                        <div class="media">
                            <img id="audio-thumbnail" src="{{asset('assets/images/icons/big-audio.svg')}}" alt="Audio" class="img-fluid" style="width: 2rem"> 
                            <div class="media-body">
                                <h5>{{ basename($lesson->audio) }} </h5> 
                                <p>Uploaded: {{ $lesson->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ url('admin/courses/create/'.$lesson->course_id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id.'/remove') }}" class="text-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div> 
                @endif 

                <div class="lesson-edit-form-wrap mt-4">
                    <h4>{{$lesson->title}}</h4>

                    <form
                        action="{{ route('admin.course.lesson.audio.create',['id' => $lesson->course_id, 'module_id' => $lesson->module_id, 'lesson_id' => $lesson->id ,'subdomain' => config('app.subdomain')]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="d-none" id="audio" name="audio">
                        <div class="form-group">
                            <textarea class="form-control" id="description" name="short_description">
                                @if ($lesson->short_description)
                                {!! $lesson->short_description !!}
                                @endif
                            </textarea>
                            <span class="invalid-feedback">@error('short_description'){{ $message }}
                                @enderror</span>
                        </div>
                        <div class="form-group form-upload">
                            <label for="file-input" class="txt">Upload New File</label>
                            <input type="file" id="file-input" class="d-none" name="lesson_file">
                            <span class="invalid-feedback">@error('lesson_file'){{ $message }}
                                @enderror</span>
                            <label for="file-input" id="upload-box">
                                <img src="{{asset('assets/images/icons/upload.svg')}}" alt="Bar" class="img-fluid"> Upload
                            </label>
                            <span>*.doc, *.pdf, *.xls file (max 5 mb)</span>
                        </div>

                        {{-- course page file box start --}}
                        <div id="file-list">
                            <!-- Uploaded files will be displayed here -->
                        </div>

                        @if ($lesson->lesson_file) 
                        <div class="lesson-edit-form-wrap course-content-box course-page-edit-box flex-column mt-2 align-items-start">
                            <h4>Current Lesson File:</h4>
                            <div class="title d-flex w-100 justify-content-between">
                                <div class="media">
                                    <img id="audio-thumbnail" src="{{ asset('assets/images/icons/file.svg') }}" alt="Audio" class="img-fluid" style="width: 2rem"> 
                                    <div class="media-body">
                                        <h5> {{ basename($lesson->lesson_file) }}</h5> 
                                        <p>Uploaded: {{ $lesson->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ url('admin/courses/create/file/remove/'.$lesson->id) }}" class="text-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div> 
                    @endif 
                        {{-- course page file box end --}}

                </div>

                {{-- step next bttns --}}
                <div class="back-next-bttns">
                    <a href="{{ url('admin/courses/create/'.$lesson->course_id.'content') }}" class="btn-cancel">Back</a>
                    <button type="submit" class="btn btn-submit">Next</button>
                </div>
                {{-- step next bttns --}}
                </form>
            </div>
        </div>
</main>
@endsection
{{-- page content @E --}}

@section('script')
<script src="{{asset('assets/js/tinymce.js')}}" type="text/javascript"></script>
<script>
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list'); 

    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];

        if (!isValidFile(file)) {
            alert('Invalid file format or size: ' + file.name);
            return;
        }

        const listItem = document.createElement('div');
        listItem.classList.add('course-content-box', 'course-page-edit-box');

        listItem.innerHTML = `
            <div class="title">
                <div class="media">
                    <img src="{{ asset('assets/images/icons/file.svg') }}" alt="File" class="img-fluid">
                    <div class="media-body">
                        <h5>${file.name}</h5>
                        <p>Uploaded: ${new Date().toLocaleString()}</p>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <span>${formatBytes(file.size)}</span>
                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item remove-file-button" href="javascript:void(0)">Remove file</a></li> 
                </ul>
            </div>
        `;

        fileList.innerHTML = ''; // Clear existing files
        fileList.appendChild(listItem);

        dbAudio.classList.add('d-none');
    });

    // Add an event listener for the "Remove file" button
    fileList.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-file-button')) {
            fileList.innerHTML = ''; // Clear the file list
            fileInput.value = ''; // Clear the file input
        }
    });

    function isValidFile(file) {
        const allowedExtensions = ['.doc', '.pdf', '.xls'];
        const maxFileSize = 25 * 1024 * 1024; // 25 MB

        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes('.' + fileExtension)) {
            return false;
        }

        if (file.size > maxFileSize) {
            return false;
        }

        return true;
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>

<script> 
   // Replace with the appropriate event that triggers this function
   $('#frontAudio').css('display', 'none'); 
    $('#audio-thumbnail').css('display', 'none');

    $('#audio').change(function () {
        var audioInput = $(this)[0];
        var audioPreview = $('#audio-preview');
        var fileNameSpan = $('#file-name');
        var fileSizeSpan = $('#file-size');
        var removeAudioIcon = $('#remove-audio');

        $('#dbAudio').css('display', 'none');

        if (audioInput.files.length > 0) {
            // Display the selected file name
            fileNameSpan.text(audioInput.files[0].name);
            var fileSizeMb = (audioInput.files[0].size / (1024 * 1024)).toFixed(2);
            fileSizeSpan.text(fileSizeMb);            

            // Hide the placeholder image by setting display: none
            $('#audio-thumbnail').css('display', 'block'); 
            $('#frontAudio').css('display', 'block'); 

            // Show the remove audio icon
            removeAudioIcon.css('display', 'inline-block');
        } else {
            // No file selected, reset to the placeholder image
            fileNameSpan.text('');
            $('#audio-thumbnail').css('display', 'none');
            $('#frontAudio').css('display', 'none'); 
            removeAudioIcon.hide();
            $('#dbAudio').css('display', 'block'); 
        }
    });

    // Click event for the remove audio icon
    $('#remove-audio').click(function () {
        // Reset the input field
        $('#audio').val('');

        // Clear the file name and hide the remove audio icon
        $('#file-name').text('');
        $(this).hide();

        // Reset the display property of the placeholder image
        $('#audio-thumbnail').css('display', 'none');
        $('#dbAudio').css('display', 'block'); 
        $('#frontAudio').css('display', 'none'); 
    });

</script>
@endsection