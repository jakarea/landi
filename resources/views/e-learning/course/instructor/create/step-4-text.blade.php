@extends('layouts.latest.instructor')
@section('title')
Course Create - Lesson Text Content Add
@endsection
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
                        <span class="circle"></span>
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
                <div class="lesson-edit-form-wrap mt-4">
                    <h4>{{ $lesson->title }}</h4>

                    <form action="{{ route('course.lesson.text.update', ['lesson_id' => $lesson->id ,'subdomain' => config('app.subdomain')]) }}" method="POST"
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
                        {{-- error message --}}
                        <div class="form-group">
                            <div id="editor-container" style="height: 300px;">
                                @if ($lesson->text)
                                {!! $lesson->text !!}
                                @endif
                            </div>
                            <input type="hidden" name="text" id="text">
                            <span class="invalid-feedback">@error('text'){{ $message }}
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
                                    <a href="{{ url('instructor/courses/create/'.$lesson->course_id.'/file/'.$lesson->module_id.'/content/'.$lesson->id.'/remove') }}" class="text-danger">
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
                    <a href="{{ url('instructor/courses/create/'.$lesson->course_id.'/content') }}" class="btn-cancel">Back</a>
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
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Write your lesson content here...',
        });

        var form = document.querySelector('form');
        var textInput = document.getElementById('text');

        form.addEventListener('submit', function (event) {
            var editorContent = quill.root.innerHTML;
            if (editorContent === '<p><br></p>' || editorContent === '<p></p>') {
                textInput.value = '';
            } else {
                textInput.value = editorContent;
            }
        });
    });
</script>
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
@endsection