@extends('layouts.latest.instructor')
@section('title')
Course Create - Step 2
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
                <div class="lesson-edit-form-wrap">
                    <h4>Description</h4>
                    <form action="" method="POST" enctype="multipart/form-data">
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
                            <textarea class="form-control" id="description" name="description"> {{ $course->description ? $course->description : old('description')}}</textarea>
                            <span class="invalid-feedback">@error('description'){{ $message }} @enderror</span>
                        </div>  
                    
                </div>

                {{-- step next bttns --}}
                <div class="back-next-bttns">
                    <a href="{{ url('instructor/courses/create/'.request()->route('id')) }}">Back</a>
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
<script src="{{asset('assets/js/tinymce.js')}}" type="text/javascript"></script>

<script>
    function previewImage() {
        var preview = document.getElementById('preview');
        var fileInput = document.getElementById('imageInput');
        var file = fileInput.files[0];
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
