@extends('layouts.latest.instructor')
@section('title')
Course Create - Step 3
@endsection
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<style>
    .content-preview-wrap {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .content-overview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 2rem;
        margin: 2rem;
        position: relative;
    }

    .content-overview-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0 4px 4px 0;
    }

    .content-title {
        color: #1a202c;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .content-meta .badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    .content-slug code {
        background: #e2e8f0;
        color: #4a5568;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .content-type-icon {
        opacity: 0.7;
    }

    .editable-fields-section {
        padding: 2rem;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
    }

    .section-title {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
        font-size: 1.1rem;
    }

    .professional-form-group {
        margin-bottom: 1.5rem;
    }

    .professional-form-group .form-label {
        color: #4a5568;
        font-weight: 500;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .professional-form-group .form-control-lg {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .professional-form-group .form-control-lg:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: #ffffff;
    }

    .professional-form-group .form-control-lg[readonly] {
        background: #f8fafc;
        cursor: not-allowed;
        color: #4a5568;
    }

    .professional-form-group .form-text {
        color: #718096;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .content-type-display {
        padding: 2rem;
        background: #f7fafc;
        border-top: 1px solid #e2e8f0;
    }

    .content-type-options {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .type-option {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
        flex: 1;
    }

    .type-option.selected {
        border-color: #48bb78;
        background: #f0fff4;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.15);
    }

    .type-option.disabled {
        opacity: 0.5;
        background: #f7fafc;
    }

    .type-option i {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .type-option.selected i {
        color: #48bb78;
    }

    .type-option span {
        font-weight: 500;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .type-option .fa-check-circle {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        font-size: 1.2rem;
    }

    .back-next-bttns {
        margin-top: 2rem;
        padding: 1.5rem 2rem;
        background: #f8fafc;
        border-radius: 0 0 12px 12px;
        border-top: 1px solid #e2e8f0;
    }

    .back-next-bttns a {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .back-next-bttns a:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .back-next-bttns a:first-child {
        background: #6c757d;
        margin-right: 1rem;
    }

    .back-next-bttns a:first-child:hover {
        background: #5a6268;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    @media (max-width: 768px) {
        .content-overview-card,
        .editable-fields-section,
        .content-type-display {
            padding: 1.5rem;
        }
        
        
        .back-next-bttns a {
            display: block;
            text-align: center;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="course-create-step-page-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-4 col-xl-3">
                
                <div class="course-create-step-wrap page-create-step">
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{asset('assets/images/icons/check-mark.svg')}}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
                    </div>
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p>Institutions</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7"> 
                <form action="" id="contentSettingsForm">
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
                    
                    {{-- Professional Preview Card --}}
                    <div class="content-preview-wrap">
                        {{-- session message @S --}}
                        @include('partials/session-message')
                        {{-- session message @E --}}

                        @php 
                            $module = \App\Models\Module::find($lesson->module_id);
                        @endphp

                        {{-- Content Overview Card --}}
                        <div class="content-overview-card">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="content-info">
                                        <h5 class="content-title">{{ $lesson->title }}</h5>
                                        <div class="content-meta">
                                            <span class="badge bg-light text-dark me-2">
                                                <i class="fas fa-folder me-1"></i>
                                                Module: {{ $module->title }}
                                            </span>
                                            <span class="badge bg-success text-white">
                                                @if($lesson->type == 'text')
                                                    <i class="fas fa-file-alt me-1"></i>
                                                @elseif($lesson->type == 'audio')  
                                                    <i class="fas fa-volume-up me-1"></i>
                                                @elseif($lesson->type == 'video')
                                                    <i class="fas fa-play-circle me-1"></i>
                                                @endif
                                                {{ ucfirst($lesson->type) }} Content
                                            </span>
                                        </div>
                                        <div class="content-slug mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-link me-1"></i>
                                                Slug: <code>{{ $lesson->slug }}</code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="content-type-icon">
                                        @if($lesson->type == 'text')
                                            <i class="fas fa-file-alt fa-3x text-primary"></i>
                                        @elseif($lesson->type == 'audio')
                                            <i class="fas fa-volume-up fa-3x text-warning"></i>
                                        @elseif($lesson->type == 'video')
                                            <i class="fas fa-play-circle fa-3x text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Editable Fields Section --}}
                        <div class="editable-fields-section">
                            <h5 class="section-title">
                                <i class="fas fa-edit me-2"></i>
                                Edit Content Details
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="professional-form-group">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-tag me-1"></i>
                                            Lesson Name
                                        </label>
                                        <input id="name" class="form-control form-control-lg" type="text" 
                                               value="{{ $lesson->title }}" readonly>
                                        <div class="form-text">This will be displayed as the lesson title</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="professional-form-group">
                                        <label for="slug" class="form-label">
                                            <i class="fas fa-link me-1"></i>
                                            Lesson Slug
                                        </label>
                                        <input id="slug" class="form-control form-control-lg" type="text" 
                                               value="{{ $lesson->slug }}" readonly>
                                        <div class="form-text">URL-friendly version of the lesson name</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="professional-form-group">
                                    <label for="cls" class="form-label">
                                        <i class="fas fa-folder me-1"></i>
                                        Module Name
                                    </label>
                                    <input id="cls" class="form-control form-control-lg" type="text" 
                                           value="{{ $module->title }}" readonly>
                                    <div class="form-text">The module that will contain this lesson</div>
                                </div>
                            </div>
                        </div>

                        {{-- Content Type Display --}}
                        <div class="content-type-display">
                            <h5 class="section-title">
                                <i class="fas fa-cog me-2"></i>
                                Content Type
                            </h5>
                            <div class="content-type-options">
                                <div class="type-option {{ $lesson->type == 'text' ? 'selected' : 'disabled' }}">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Text Content</span>
                                    @if($lesson->type == 'text')
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                </div>
                                <div class="type-option {{ $lesson->type == 'audio' ? 'selected' : 'disabled' }}">
                                    <i class="fas fa-volume-up"></i>
                                    <span>Audio Content</span>
                                    @if($lesson->type == 'audio')
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                </div>
                                <div class="type-option {{ $lesson->type == 'video' ? 'selected' : 'disabled' }}">
                                    <i class="fas fa-play-circle"></i>
                                    <span>Video Content</span>
                                    @if($lesson->type == 'video')
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        @if ($lesson->type == 'audio')
                            <a href="{{ url('instructor/courses/create/'.$course->id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id) }}">Edit</a>
                        @elseif ($lesson->type == 'text')
                            <a href="{{ url('instructor/courses/create/'.$course->id.'/text/'.$lesson->module_id.'/content/'.$lesson->id) }}">Edit</a>
                        @elseif ($lesson->type == 'video')
                            <a href="{{ url('instructor/courses/create/'.$course->id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}">Edit</a>
                        @endif
                         
                        <a href="{{url('instructor/courses/create/'.$course->id.'/content')}}">Next</a>
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