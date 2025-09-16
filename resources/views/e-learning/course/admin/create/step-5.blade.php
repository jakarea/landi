@extends('layouts.latest.admin')
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
                        <p><a href="{{ url('admin/courses/create', optional(request())->route('id')) }}">Contents</a></p>
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
                        <div class="lesson-edit-form-wrap mt-4">
                            <div class="highlighted-area-upload dragBox">
                                <img src="{{asset('assets/images/icons/big-video.svg')}}" alt="a" class="img-fluid">
                                <input type="file" onChange="dragNdrop(event)" name="video_link" ondragover="drag()" ondrop="drop()" id="uploadFile" />
                                <p class="file-name"><label for="uploadFile">Click here</label> to set the Lesson video</p>
                            </div>
                            <input type="hidden" name="duration" id="duration" />
                            <div id="preview" class="mt-2"></div>
                            <div class="upload-progress mt-4">
                                <div class="progress d-none">
                                <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" 
                                    aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                            </div>
                            <h3 class="h33 d-none">0%</h3>
                            <p class="warnm d-none">Please, while uploading the video. don't close the window or dont't
                                change the URL *</p> 
                            <span class="invalid-feedback text-danger" id="videoErrorMessage">
                                @error('video_link')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mt-4">
                            <label for="file-input" class="txt mb-2" style="font-weight: 600">A Short description for this video</label> 
                            <textarea class="form-control" id="description" name="short_description" placeholder="Type here" col></textarea> 

                            <span class="invalid-feedback text-danger">
                                @error('short_description')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
 
                        @if ($lesson->video_link)
                        <div class="form-group form-upload mb-0">
                            <label for="file-input" class="txt mb-0">Current Video</label> 
                        </div> 
                        <div class="course-content-box course-page-edit-box">
                            <div class="title">
                                <div class="media">
                                    <img src="{{ asset('assets/images/icons/video.svg') }}" alt="File"
                                        class="img-fluid">
                                    <div class="media-body">
                                        <h5>{{ $lesson->slug .'.mp4' }} </h5>
                                        <p>Uploaded at: {{ $lesson->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('admin/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id.'/remove') }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div> 
                        @endif

                    </div>
                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('admin/courses/create/'.$lesson->course_id) }}">Back</a>
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
    $('#uploadForm').submit(function(e) {
       
        var fileInput = document.getElementById('uploadFile');

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

                    // Adjust the redirect URL based on your requirement
                    window.location.href = baseUrl + '/admin/courses/create/' + course_id + '/lesson/' + module_id + '/institute/' + lesson_id;
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
        }
    });
});

</script>
@endsection
