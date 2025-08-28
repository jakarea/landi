@extends('layouts.latest.instructor')
@section('title')
Course Create - Step 1
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
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                {{-- course step --}}
                <div class="course-create-step-wrap">
                    <div class="step-box">
                        <span class="circle">
                        </span>
                        <p>Contents</p>
                    </div>
                    <div class="step-box">
                        <span class="circle">
                        </span>
                        <p>Facts</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Objects</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Price</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Design</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Certificate</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Visibility</p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p>Share</p>
                    </div>
                </div>
                {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <div class="content-step-wrap">
                    <div class="text-center mb-2">
                        <span class="invalid-feedback">@error('module_name'){{ $message }} @enderror</span>
                        <span class="invalid-feedback">@error('lesson_name'){{ $message }} @enderror</span>
                    </div>
                    <form action="" method="POST" id="myForm">
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
                        {{-- course content add box start --}}
                        <div class="add-content-box">
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#moduleModal"><i
                                class="fas fa-plus"></i> Add Content</button>
                        </div>
                        {{-- course content add box end --}}

                        {{-- step next bttns --}}
                        <div class="back-next-bttns">
                            <button type="button" class="btn btn-submit" data-bs-toggle="modal" data-bs-target="#moduleModal"> Next</button> 
                        </div>
                        {{-- step next bttns --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- course name modal --}}
<div class="course-name-modal">
    <div class="modal fade" id="moduleModal" tabindex="-1" aria-labelledby="moduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="course-name-txt">
                        <h5>Module name</h5>

                        <form action="" method="post">
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
                                <input autocomplete="off" type="text" placeholder="Enter Module Name" name="module_name"
                                    class="form-control">
                            </div>
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_module">Is a Module</label>
                                <input class="form-check-input" type="checkbox" name="is_module" value="1" role="switch"
                                    id="is_module" checked>
                            </div>
                            <p>Disable this if you want a separate content page.</p>
                            <div class="form-submit">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-submit">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- course name modal --}}
@endsection
{{-- page content @E --}}
