@extends('layouts.latest.instructor')
@section('title') Lesson Video Upload @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- lesson video upload page --}}
<main class="lesson-create-page">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="user-header">
                    <h2>Upload a new Lesson Video</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="user-header-bttn">
                    <a href="{{url('instructor/lessons')}}"><img src="{{asset('assets/images/icons/list.svg')}}" alt="user"
                            class="img-fluid"> All Lessons </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form id="uploadForm" action="/instructor/lessons/upload-vimeo-submit" method="POST" class="upload-video-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-group form-error">
                                        <label for="course_id">Selected Course <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="course_id" id="course_id"
                                            class="form-control @error('course_id') is-invalid @enderror" disabled>
                                            <option value="" disabled>Select Below</option>
                                            @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">@error('course_id'){{ $message }}
                                            @enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-error">
                                        <label for="module_id">Selected Module <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="module_id" id="module_id"
                                            class="form-control @error('module_id') is-invalid @enderror" disabled>
                                            <option value="" disabled>Select Below</option>
                                            @foreach($modules as $module)
                                            <option value="{{$module->id}}">{{$module->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback">@error('module_id'){{ $message }}
                                            @enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-9 col-12">
                                    <div class="video-upload-wrap">
                                        <div class="uploadOuter">
                                            <span class="dragBox">
                                                <i class="fas fa-plus"></i>
                                                <span class="file-name"></span>
                                                Darg and Drop Video here or <br> click to upload
                                                <input type="file" onChange="dragNdrop(event)" name="video_link"
                                                    ondragover="drag()" ondrop="drop()" id="uploadFile" />
                                            </span>
                                        </div>
                                        <div id="preview"></div>
                                        <div class="upload-progress">
                                            <div class="progress" role="progressbar" aria-label="Basic example"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width: 0%"></div>
                                            </div>
                                            <h3>0%</h3>
                                            <p>Please, while uploading the video. don't close the window or dont't
                                                change the URL *</p>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback">@error('video_link'){{ $message }}
                                        @enderror</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-submit-bttns">
                                <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                <button type="submit" class="btn btn-submit">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
{{-- lesson video upload page --}}
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="{{asset('assets/js/file-upload.js')}}" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
<script>
    function dragNdrop(event) {
        // While selecting file, only allow video file
        var fileInput = document.getElementById('uploadFile');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.mp4|\.mov|\.avi|\.wmv|\.flv|\.mkv)$/i;
        if (!allowedExtensions.exec(filePath)) {
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
        e.preventDefault();

        var formData = new FormData(this);
        var urlParams = new URLSearchParams(window.location.search);
        var lesson_id = urlParams.get('lesson_id');
        // get lesson id from browser and add to form data
        formData.append('lesson_id', lesson_id);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $('.progress-bar').css('width', percentComplete + '%');
                        $('.upload-progress h3').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            beforeSend: function() {
                // set button state to loading and disable with spinner
                $('.btn-submit').attr('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...'
                );
                // check if file is not empty
                var fileInput = document.getElementById('uploadFile');
                var filePath = fileInput.value;
                if (filePath === '') {
                    alert('Please select a file');
                    $('.btn-submit').attr('disabled', false).text('Upload');
                    return false;
                }

                // upload-progress p tag add style as warning
                $('.upload-progress p').css('color', '#fff');
                // $('.upload-progress p').css('background-color', '#ffc107');
                $('.upload-progress p').css('background-color', '#ff0000');
                $('.upload-progress p').css('padding', '10px');
                $('.upload-progress p').css('border-radius', '5px');
                $('.upload-progress p').css('margin-top', '10px');
            },
            success: function(response) {
                // reset button state
                $('.btn-submit').attr('disabled', false).text('Upload');
                var uri = response.uri;
                checkProgress(uri);
            },
            // handle all types of errors
            error: function(xhr) {
                var errors = xhr.responseJSON.errors || xhr.responseJSON.message;
                alert(errors);
                cosnole.log(errors);
                // reset button state
                $('.btn-submit').attr('disabled', false).text('Upload');
            }
        });
    });

    function checkProgress(uri) {
        var interval = setInterval(function() {
            $.ajax({
                url: '/instructor/lessons/progress',
                type: 'GET',
                data: { uri: uri },
                dataType: 'json',
                success: function(response) {
                    var progress = response.progress;
                    $('.progress-bar').css('width', progress + '%');
                    $('.upload-progress h3').text(progress + '%');
                    if (progress === 100) {
                        clearInterval(interval);
                        // redirect to lesson page
                        setTimeout(function() {
                            window.location.href = '/instructor/courses';
                            // redirect to course single page
                            // var urlParams = new URLSearchParams(window.location.search);
                            // var lesson_slug = urlParams.get('lesson_slug');
                            // window.location.href = '{{ route('course.show', ':lesson_slug') }}'.replace(
                            //     ':lesson_slug', lesson_slug);

                        }, 3000);
                    }
                },
                error: function(error) {
                    // get all errors and display
                    var errors = error.responseJSON.errors;
                    // alert(errors);
                    alert('Something went wrong. Please try again.');
                }
            });
        }, 1000);
    }
});

</script>
@endsection
{{-- page script @E --}}