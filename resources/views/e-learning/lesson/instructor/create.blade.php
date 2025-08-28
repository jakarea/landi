@extends('layouts.latest.instructor')
@section('title') Lesson Create Page @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
@php
$course_id = isset($_GET['course']) ? $_GET['course'] : '';
$module_id = isset($_GET['module']) ? $_GET['module'] : '';
@endphp

{{-- lesson create page @s --}}
<main class="lesson-create-page">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6">
                <div class="user-header">
                    <h2>Create a new Lesson</h2>
                </div>
            </div>
            <div class="col-6">
                <div class="user-header-bttn">
                    <a href="{{url('instructor/lessons')}}"><img src="{{asset('assets/images/icons/list.svg')}}"
                            alt="user" class="img-fluid"> All Lessons </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="user-add-form-wrap">
                    <form action="{{route('lesson.store')}}" method="POST" class="create-form-box"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group form-error">
                                    <label for="course_id">Select Course <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="course_id" id="course_id"
                                        class="form-control @error('course_id') is-invalid @enderror">
                                        <option value="" disabled>Select Below</option>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}" {{ $course->id == $course_id ? 'selected' :
                                            ''}}>{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">@error('course_id'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-error">
                                    <label for="module_id">Select Module <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="module_id" id="module_id"
                                        class="form-control @error('module_id') is-invalid @enderror">
                                        <option value="" disabled>Select Below</option>
                                        @foreach($modules as $module)
                                        <option value="{{$module->id}}" {{ $module->id == $module_id ? 'selected' :
                                            ''}}>{{$module->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">@error('module_id'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group form-error">
                                    <label for="title">Title <sup class="text-danger">*</sup>
                                    </label>
                                    <input autocomplete="off" type="text" placeholder="Enter Lesson Title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title')}}" id="title">
                                    <span class="invalid-feedback">@error('title'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group lesson-files-upload">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input type="file" id="thumbnail" class="d-none" name="thumbnail">
                                    <label class="media" for="thumbnail">
                                        <img src="{{asset('assets/images/placeholder.svg')}}" alt="Logo"
                                            class="img-fluid">
                                        <div class="media-body">
                                            <h5>Select Image</h5>
                                            <p><u>Click here</u> and browse thorough your Device.
                                                Accepted file type (.jpg .png .webp)</p>
                                        </div>
                                    </label>

                                    <div class="uploaded-image">
                                        <img id="uploadedImg" src="{{asset('assets/images/placeholder.svg')}}" alt="Uploaded Logo" class="img-fluid">
                                        <span id="removeImage" class="close-icon">&#10006;</span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group lesson-files-upload">
                                    <label for="lesson_file">File</label>
                                    <input type="file" id="lesson_file" class="d-none" name="lesson_file">
                                    <label class="media media2" for="lesson_file">
                                        <img src="{{asset('assets/images/placeholder.svg')}}" alt="Logo"
                                            class="img-fluid">
                                        <div class="media-body">
                                            <h5>Select Image</h5>
                                            <p><u>Click here</u> and browse thorough your Device.
                                                Accepted file type (.jpg .png .webp)</p>
                                        </div>
                                    </label>
                                    <div class="uploaded-image2">
                                        <img id="uploadedImg2" src="{{asset('assets/images/placeholder.svg')}}" alt="Uploaded Logo" class="img-fluid">
                                        <span id="removeImage2" class="close-icon">&#10006;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mt-4">
                                    <label for="short_description">Short Description </label>
                                    <textarea name="short_description" id="short_description"
                                        class="form-control @error('short_description') is-invalid @enderror"
                                        placeholder="Enter Short Description">{{ old('short_description')}}</textarea>
                                    <span class="invalid-feedback">@error('short_description'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_keyword">Meta Keyboard </label>
                                    <modular-behaviour name="Keyword"
                                        src="https://cdn.jsdelivr.net/npm/bootstrap5-tags@1.4/tags.min.js" lazy>
                                        <select class="form-select @error('meta_keyword') is-invalid @enderror"
                                            id="meta_keyword" name="meta_keyword[]" multiple data-allow-clear="1"
                                            data-allow-new="true" data-separator="|,|">
                                            <option selected="selected" disabled hidden value="">Add meta keyword
                                            </option>
                                        </select>
                                    </modular-behaviour>
                                    <i class="fa-solid fa-angle-down"></i>
                                    <span class="invalid-feedback">@error('meta_keyword'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_description">Meta Description </label>
                                    <textarea name="meta_description" id="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        placeholder="Enter Meta Description">{{ old('meta_description')}}</textarea>
                                    <span class="invalid-feedback">@error('meta_description'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="" disabled>Select Below</option> 
                                        <option value="pending">Pending</option>
                                        <option value="published">Published</option>
                                    </select>
                                    <i class="fa-solid fa-angle-down"></i>
                                    <span class="invalid-feedback">@error('status'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-submit-bttns">
                                    <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- lesson create page @e --}}
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="https://cdn.jsdelivr.net/npm/modular-behaviour.js@3.1/modular-behaviour.js" type="module"></script>
<script src="{{asset('assets/js/tag-handler.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/lesson-file-1.js')}}" type="text/javascript"></script>
@endsection
{{-- page script @E --}}