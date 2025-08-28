@extends('layouts.latest.instructor')
@section('title')
    Course Create - Step 10
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
            <div class="row justify-content-center position-relative">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    {{-- course step --}}
                    <div class="course-create-step-wrap">
                        
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a></p>
                        </div>
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">Objects</a></p>
                        </div>
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">Price</a></p>
                        </div>
                         <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">Design</a></p>
                        </div>
                        <div class="step-box active">
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
                        </div>
                       
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">Certificate</a></p>
                        </div>
                        <div class="step-box current">
                            <span class="circle"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/visibility' }}">Visibility</a></p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/share' }}">Share</a></p>
                        </div>
                    </div>
                    {{-- course step --}}
                
                @if ( session()->has('course_id') )
                    @include('e-learning.course.instructor.create.save-finish')
                @endif
            </div>
        </div>
        
        <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    <form action="{{ route('course.visibility.store', ['id' => $course->id]) }}" method="POST">
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
                        <div class="content-settings-form-wrap visibility-form-wrap">
                            <h4>Visibility</h4>
                            <hr>
                            <div class="form-group">
                                <h6>Status of the Course</h6>
                                <i class="fas fa-circle"></i>
                                <select class="form-control" name="status">
                                    <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="published" {{ $course->status == 'published' ? 'selected' : '' }}>
                                        Publish</option>
                                </select>
                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" alt="arrow-down"
                                    class="img-fluid euro" style="top: 3rem">
                                <span class="invalid-feedback d-block">
                                    @error('status')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="media auto-text">
                                <div class="media-body">
                                    <h6>Review for the course</h6>
                                    <p>If you don't want any review about your course please turn off checkmark.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="allow_review" role="switch"
                                        id="flexSwitchCheckChecked" value="1"
                                        {{ $course->allow_review == '1' ? 'checked' : '' }}>
                                    <span class="invalid-feedback d-block">
                                        @error('allow_review')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- step next bttns --}}
                        <div class="back-next-bttns">
                            <a href="{{ url('instructor/courses/create/' . $course->id . '/certificate') }}">Back</a>
                            <button class="btn btn-primary" type="submit">Next</button>
                        </div>
                        {{-- step next bttns --}}
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
{{-- page content @E --}}

@section('script')
@endsection
