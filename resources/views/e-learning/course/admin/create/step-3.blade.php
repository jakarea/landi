@extends('layouts.latest.admin')
@section('title')
Course Create - Step 3
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
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{asset('assets/images/icons/check-mark.svg')}}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p>Content</p>
                    </div>
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p>Institutions</p>
                    </div>
                </div>
                {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7"> 
                <form action="">
                    <div class="content-settings-form-wrap">
                        {{-- session message @S --}}
                        @include('partials/session-message')
                        {{-- session message @E --}}
                        <h4>Content Settings</h4>
                        <div class="form-group">
                            <input id="name" class="form-control" type="text" value="{{ $lesson->title }}" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-group">
                            <input id="slug" class="form-control" type="text" value="{{ $lesson->slug }}" required>
                            <label for="slug">Slug</label>
                        </div>
                        <div class="content-type">
                            <h5>Type</h5>
                            <div class="d-flex">
                                <a href="#" class="{{ $lesson->type == 'text' ? 'active' : ''}}"><img src="{{asset('assets/images/icons/file.svg')}}" alt="a" class="img-fluid"> Text</a>
                                <a href="#" class="{{ $lesson->type == 'audio' ? 'active' : ''}}"><img src="{{asset('assets/images/icons/audio.svg')}}" alt="a" class="img-fluid">Audio</a>
                                <a href="#" class="{{ $lesson->type == 'video' ? 'active' : ''}}"><img src="{{asset('assets/images/icons/video.svg')}}" alt="a" class="img-fluid">Video</a>
                            </div>
                        </div>
                        <hr>
                        <div class="element-txt">
                            <h6>Element of</h6>
                            <p>Module where this lesson will be added.</p>
                        </div>
                        @php 
                            $module = \App\Models\Module::find($lesson->module_id);
                        @endphp 

                        <div class="form-group">
                            <input id="cls" class="form-control" type="text" value="{{ $module->title }}">
                            <label for="cls">Course Name</label>
                        </div>
                    </div>
                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        @if ($lesson->type == 'audio')
                            <a href="{{ url('admin/courses/create/'.$course->id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id) }}">Back</a>
                        @elseif ($lesson->type == 'text')
                            <a href="{{ url('admin/courses/create/'.$course->id.'/text/'.$lesson->module_id.'/content/'.$lesson->id) }}">Back</a>
                        @elseif ($lesson->type == 'video')
                            <a href="{{ url('admin/courses/create/'.$course->id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}">Back</a>
                        @endif
                        <a href="{{url('admin/courses/create/'.$course->id)}}">Next</a>
                    </div>
                    {{-- step next bttns --}}
                </form>
            </div>
        </div>
</main>

@endsection
{{-- page content @E --}}

@section('script') 
@endsection