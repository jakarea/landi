@extends('layouts.latest.instructor')
@section('title')
Course Create - Video Upload
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
                <div class="course-create-step-wrap page-create-step">
                    <div class="step-box current">
                        <span class="circle">
                        </span>
                        <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
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
                <form id="uploadForm" action="" method="POST" class="create-form-box custom-select"
      enctype="multipart/form-data">
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

    @php
        $vimeoConnected = isVimeoConnected(auth()->user()->id)[1] === 'Connected';
    @endphp

    <div class="form-content-wrapper">

        {{-- Video Type Selection --}}
        <div class="form-group mb-4">
            <label class="txt mb-2" style="font-weight: 600">Video Type</label>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="video_type" id="vimeo_type" value="vimeo" 
                       {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'vimeo' ? 'checked' : '' }}
                       {{ !$vimeoConnected ? 'disabled' : '' }}>
                <label class="form-check-label" for="vimeo_type">
                    Vimeo Upload
                    @if(!$vimeoConnected)
                        <span class="text-danger">(Not Connected)</span>
                    @endif
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="video_type" id="youtube_type" value="youtube"
                       {{ old('video_type', $lesson->video_type ?? 'vimeo') == 'youtube' ? 'checked' : '' }}>
                <label class="form-check-label" for="youtube_type">
                    YouTube Video Link
                </label>
            </div>

            @if(!$vimeoConnected)
                <div class="alert alert-warning mt-2">
                    <small>Vimeo account not connected. 
                        <a href="{{ route('instructor.profile.settings') }}" target="_blank">Connect Vimeo Account</a> 
                        or use YouTube option.
                    </small>
                </div>
            @endif
        </div>

        {{-- Vimeo Upload Section --}}
        <div class="lesson-edit-form-wrap mt-4" id="vimeo_upload_section"
             style="{{ old('video_type', $lesson->video_type ?? 'vimeo') == 'vimeo' ? '' : 'display: none;' }}">

            <div class="highlighted-area-upload dragBox{{ !$vimeoConnected ? ' disabled' : '' }}">
                <img src="{{ asset('assets/images/icons/big-video.svg') }}" alt="a" class="img-fluid">
                <input type="file" onChange="dragNdrop(event)" name="video_link"
                       ondragover="drag()" ondrop="drop()" id="uploadFile"
                       {{ !$vimeoConnected ? 'disabled' : '' }} />
                <p class="file-name">
                    <label for="uploadFile">
                        {{ !$vimeoConnected ? 'Vimeo not connected' : 'Click here' }}
                    </label>
                    {{ !$vimeoConnected ? '- Connect Vimeo to upload' : 'to set the Lesson video' }}
                </p>
            </div>

            <input type="hidden" name="duration" id="duration" />
            <div id="preview" class="mt-2"></div>

            <div class="upload-progress mt-4">
                <div class="progress d-none">
                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                         role="progressbar" aria-valuenow="0"
                         aria-valuemin="0" aria-valuemax="100"
                         style="width: 0%"></div>
                </div>
                <h3 class="h33 d-none">0%</h3>
                <p class="warnm d-none">
                    Please, while uploading the video, don't close the window or change the URL *
                </p>
                <span class="invalid-feedback text-danger" id="videoErrorMessage">
                    @error('video_link')
                        {{ $message }}
                    @enderror
                </span>

                @if(!$vimeoConnected)
                    <div class="alert alert-danger mt-2">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i> Vimeo upload is disabled. 
                            Please <a href="{{ route('instructor.profile.settings') }}" target="_blank">
                                connect your Vimeo account
                            </a> to enable video uploads.
                        </small>
                    </div>
                @endif
            </div>
        </div> {{-- END Vimeo Section --}}

        {{-- Current Video Preview --}}
        @if ($lesson->video_link)
            <div class="form-group form-upload mb-0">
                <label for="file-input" class="txt mb-0">Current Video</label>
            </div>
            <div class="course-content-box course-page-edit-box">
                <div class="title">
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/video.svg') }}" alt="File" class="img-fluid">
                        <div class="media-body">
                            @if($lesson->video_type == 'youtube')
                                <h5>YouTube Video</h5>
                                <p>URL: {{ $lesson->video_link }}</p>
                            @else
                                <h5>{{ $lesson->slug . '.mp4' }}</h5>
                            @endif
                            <p>Updated at: {{ $lesson->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ url('instructor/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id.'/remove') }}">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        @endif

        {{-- YouTube URL Input Section --}}
        <div class="form-group mb-4" id="youtube_url_section"
             style="{{ old('video_type', $lesson->video_type ?? 'vimeo') == 'youtube' ? 'display: block;' : 'display: none;' }}">
            <label for="youtube_url" class="txt mb-2" style="font-weight: 600">YouTube Video URL</label>
            <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                   placeholder="https://www.youtube.com/watch?v=..." 
                   value="{{ old('youtube_url', $lesson->video_type == 'youtube' ? $lesson->video_link : '') }}"
                   pattern="^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$">
            <small class="form-text text-muted">
                Enter a valid YouTube URL (supports youtube.com/watch and youtu.be formats)
            </small>
            <span class="invalid-feedback text-danger" id="youtubeErrorMessage">
                @error('youtube_url')
                    {{ $message }}
                @enderror
            </span>
            
            {{-- YouTube Duration Field --}}
            <div class="mt-3">
                <label for="youtube_duration" class="txt mb-2" style="font-weight: 600">Video Duration (seconds)</label>
                <input type="number" class="form-control" id="youtube_duration" name="youtube_duration" 
                       min="1" placeholder="e.g., 300 (for 5 minutes)" 
                       value="{{ old('youtube_duration', $lesson->video_type == 'youtube' && $lesson->duration ? $lesson->duration : '') }}">
                <small class="form-text text-muted">
                    Enter the video duration in seconds (e.g., 300 for a 5-minute video)
                </small>
                <span class="invalid-feedback text-danger" id="youtubeDurationErrorMessage">
                    @error('youtube_duration')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div> {{-- END YouTube Section --}}

        {{-- Short Description --}}
        <div class="form-group mt-4">
            <label for="file-input" class="txt mb-2" style="font-weight: 600">
                A Short description for this video
            </label>
            <textarea class="form-control" id="description" name="short_description" placeholder="Type here">
                {!! $lesson->short_description !!}
            </textarea>
            <span class="invalid-feedback text-danger">
                @error('short_description')
                    {{ $message }}
                @enderror
            </span>
        </div>
    </div> {{-- END form-content-wrapper --}}

    {{-- step next bttns --}}
    <div class="back-next-bttns">
        <a href="{{ url('instructor/courses/create/'.$lesson->course_id.'/content') }}">Back</a>
        <button class="btn btn-primary btn-submit" type="submit">Next</button>
    </div>
    {{-- step next bttns --}}
</form>

            </div>
        </div>
</main>
@endsection
{{-- page content @E --}}

@section('script')
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{-- file upload preview --}}
<script>
    var baseUrl = "{{ url('') }}";
    var progressBAR = document.querySelector('.progress-bar');
    var currentURL = window.location.href
    var urlObject = new URL(currentURL);
    var pathname = urlObject.pathname;
    var pathnameParts = pathname.split('/');
    var course_id = pathnameParts[4];
    var module_id = pathnameParts[6];
    var lesson_id = pathnameParts[8];
    const uploadProgress = document.querySelector('.progress');
    const warnm = document.querySelector('.warnm');
    const h33 = document.querySelector('.h33');

function dragNdrop(event) {
    // While selecting file, only allow video file
    var fileInput = document.getElementById('uploadFile');

    var filePath = fileInput.value;
    var allowedExtensions = /(\.mp4|\.mov|\.avi|\.wmv|\.flv|\.mkv)$/i;
    if (filePath && !allowedExtensions.exec(filePath)) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }

    var fileName = event.target.files[0].name;
    document.querySelector('.file-name').innerHTML = fileName;
    document.querySelector('.file-name').style.display = 'block';
    document.querySelector('.file-name').style.border = '1px solid #ccc';
    document.querySelector('.file-name').style.padding = '10px';
    document.querySelector('.file-name').style.borderRadius = '5px';
    document.querySelector('.file-name').style.marginTop = '10px';
    document.querySelector('.dragBox').firstElementChild.className = 'fas fa-times';
}

function drag() {
    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
}

function drop() {
    document.getElementById('uploadFile').parentNode.className = 'dragBox';
}

$(document).ready(function() {
    // Handle video type selection - show/hide sections
    $('input[name="video_type"]').change(function() {
        var selectedType = $(this).val();
        if (selectedType === 'youtube') {
            $('#youtube_url_section').show();
            $('#vimeo_upload_section').hide();
        } else {
            $('#youtube_url_section').hide();
            $('#vimeo_upload_section').show();
        }
    });

    // Initialize on page load
    var selectedType = $('input[name="video_type"]:checked').val();
    if (selectedType === 'youtube') {
        $('#youtube_url_section').show();
        $('#vimeo_upload_section').hide();
    } else {
        $('#youtube_url_section').hide();
        $('#vimeo_upload_section').show();
    }

    // Form submission handling
    $('#uploadForm').submit(function(e) {
        var videoType = $('input[name="video_type"]:checked').val();
        var fileInput = document.getElementById('uploadFile');
        var youtubeUrl = document.getElementById('youtube_url');

        if (videoType === 'youtube') {
            if (!youtubeUrl.value.trim()) {
                e.preventDefault();
                $('#youtubeErrorMessage').text('Please enter a YouTube URL');
                return false;
            }
            
            // Validate YouTube URL format
            var youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)*$/;
            if (!youtubeRegex.test(youtubeUrl.value.trim())) {
                e.preventDefault();
                $('#youtubeErrorMessage').text('Please enter a valid YouTube URL (e.g., https://www.youtube.com/watch?v=...)');
                return false;
            }
            
            // Clear any previous error messages
            $('#youtubeErrorMessage').text('');
            return true;
        }

        if (fileInput && fileInput.files.length > 0) {
            // Only proceed if there are files selected
            e.preventDefault();

            uploadProgress.classList.remove('d-none');
            warnm.classList.remove('d-none');
            h33.classList.remove('d-none');

            var formData = new FormData(this);
            var urlParams = new URLSearchParams(window.location.search);
            var url = window.location.href;

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    // set button state to loading and disable with spinner
                    $('.btn-submit').attr('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...'
                    );

                    var selectedFile = fileInput.files[0];
                    const fileSizeBytes = selectedFile.size;
                    const fileSizeKB = fileSizeBytes / 1024;
                    const fileSizeMB = fileSizeKB / 1024;

                    var fixedMax = Math.floor(Math.random() * 12) + 83;
                    var currentPercentage = 0;
                    var progressPercentage = Math.floor(70 / fileSizeMB);
                    var randomFraction = 1;
                    var randomNumberInRange = 1;
                    let progressId;

                    function updateProgress() {
                        randomFraction = Math.random();
                        randomNumberInRange = Math.floor(1 + (randomFraction * (4 - 1)));
                        currentPercentage += Math.ceil(progressPercentage ? progressPercentage : 1);
                        $('.progress-bar').css('width', currentPercentage + '%');
                        $('.upload-progress h3').text(currentPercentage + '%');

                        if (currentPercentage >= fixedMax) {
                            clearInterval(progressId);
                        }
                    }

                    progressId = setInterval(updateProgress, randomNumberInRange * 500);
                },
                success: function(response) {
                    $('.btn-submit').attr('disabled', false).text('Upload');
                    var uri = response.uri;
                    var price = response.price;

                    // Handle success, update UI, etc.

                    window.location.href = baseUrl + '/instructor/courses/create/' + course_id + '/lesson/' + module_id + '/institute/' + lesson_id;
                },
                error: function(xhr) {
                    progressBAR.classList.remove('bg-danger');
                    uploadProgress.classList.add('d-none');
                    warnm.classList.add('d-none');
                    var errors = xhr.responseJSON.errors || xhr.responseJSON.message;

                    if (errors.video_link) {
                        document.querySelector('#videoErrorMessage').innerHTML = errors.video_link[0];
                    }

                    // Handle errors, update UI, etc.

                    $('.upload-progress').css('display', 'none');
                    $('.btn-submit').attr('disabled', false).html(
                        'Next'
                    );
                }
            });
        } else {
            // No files selected, handle this case or do nothing
            console.log('No file selected');
        }
    });
});

</script>
@endsection