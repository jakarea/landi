@extends('layouts.latest.instructor')
@section('title') Update Module  @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/subscription.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content') 
{{--  module update page @S --}} 
<main class="module-update-page">
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
                    <h5>Update Module</h5>
                    <div class="bttn text-end">
                        <a href="{{url('instructor/modules')}}" class="common-bttn">All Modules</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="subscription-package-form">
                    <form action="{{route('module.update',$module->slug)}}" method="POST" class="create-form-box">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-error">
                                    <label for="course_id">Select Course <sup class="text-danger">*</sup>
                                    </label> 
                                    <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                        <option value="" disabled>Select Below</option>
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}" {{ $course->id == $module->course_id ? 'selected' : '' }}>{{$course->title}}</option>
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
                                    <input autocomplete="off" type="text" placeholder="Enter Course Title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ $module->title }}" id="title">
                                    <span class="invalid-feedback">@error('title'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_lesson">Total Lesson
                                    </label>
                                    <input type="number" placeholder="Enter total lesson"
                                        name="number_of_lesson"
                                        class="form-control @error('number_of_lesson') is-invalid @enderror"
                                        value="{{ $module->number_of_lesson }}" id="number_of_lesson" min="0">
                                    <span class="invalid-feedback">@error('number_of_lesson'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_attachment">Total File
                                    </label>
                                    <input type="number" placeholder="Enter total File"
                                        name="number_of_attachment"
                                        class="form-control @error('number_of_attachment') is-invalid @enderror"
                                        value="{{ $module->number_of_attachment }}" id="number_of_attachment" min="0">
                                    <span class="invalid-feedback">@error('number_of_attachment'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_video">Total Video
                                    </label>
                                    <input type="number" placeholder="Enter total video"
                                        name="number_of_video"
                                        class="form-control @error('number_of_video') is-invalid @enderror"
                                        value="{{  $module->number_of_video }}" id="number_of_video" min="0">
                                    <span class="invalid-feedback">@error('number_of_video'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">Total Duration
                                    </label>
                                    <input type="number" placeholder="Enter duration" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        value="{{ $module->duration }}" id="duration" min="0">
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
                                        <option value="pending" {{ $module->status == 'pending' ? 'selected' : ''}}>Pending</option>
                                        <option value="published" {{ $module->status == 'published' ? 'selected' : ''}}>Published</option>
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
                                    <button type="submit" class="btn btn-submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

{{--  module update page @e --}}
@endsection
{{-- page content @E --}}