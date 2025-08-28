@extends('layouts.latest.instructor')
@section('title') Create a new Module @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/subscription.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- get course id from url @S --}}
@php
$course_id = isset($_GET['course']) ? $_GET['course'] : '';
@endphp
{{-- get course id from url @E --}}

{{-- module create page @s --}}
<main class="module-create-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- session message @S --}}
                @include('partials/session-message')
                {{-- session message @E --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="package-list-header package-header-2">
                    <h5>Create a new Module</h5>
                    <div class="bttn text-end">
                        <a href="{{url('instructor/modules')}}" class="common-bttn">All Modules</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="subscription-package-form">
                    <form action="{{route('module.store')}}" method="POST" class="create-form-box">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-error ">
                                    <label for="course_id">Select Course <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="course_id" id="course_id"
                                        class="form-control @error('course_id') is-invalid @enderror">
                                        <option value="" disabled>Select Below</option>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}" {{ $course->id == $course_id ?
                                            'selected' : '' }}>{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback">@error('course_id'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group form-error">
                                    <label for="title">Title <sup class="text-danger">*</sup>
                                    </label>
                                    <input autocomplete="off" type="text" placeholder="Enter Module Title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title')}}" id="title">
                                    <span class="invalid-feedback">@error('title'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="number_of_lesson">Total Lesson
                                    </label>
                                    <input type="number" placeholder="Enter total lesson"
                                        name="number_of_lesson"
                                        class="form-control @error('number_of_lesson') is-invalid @enderror"
                                        value="{{ old('number_of_lesson')}}" id="number_of_lesson" min="0">
                                    <span class="invalid-feedback">@error('number_of_lesson'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="number_of_attachment">Total File
                                    </label>
                                    <input type="number" placeholder="Enter total File"
                                        name="number_of_attachment"
                                        class="form-control @error('number_of_attachment') is-invalid @enderror"
                                        value="{{ old('number_of_attachment')}}" id="number_of_attachment"
                                        min="0">
                                    <span class="invalid-feedback">@error('number_of_attachment'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="number_of_video">Total Video
                                    </label>
                                    <input type="number" placeholder="Enter total video" name="number_of_video"
                                        class="form-control @error('number_of_video') is-invalid @enderror"
                                        value="{{ old('number_of_video')}}" id="number_of_video" min="0">
                                    <span class="invalid-feedback">@error('number_of_video'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="duration">Total Duration
                                    </label>
                                    <input type="number" placeholder="Enter duration" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        value="{{ old('duration')}}" id="duration" min="0">
                                    <span class="invalid-feedback">@error('duration'){{ $message }}
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
                                    <i class="fas fa-angle-down"></i>
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
{{-- module create page @e --}}
@endsection
{{-- page content @E --}}