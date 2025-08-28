@extends('layouts.latest.instructor')
@section('title')
Course Create - Step 3
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
        <div class="row justify-content-center position-relative">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                {{-- course step --}}
                <div class="course-create-step-wrap">
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? route('instructor.courses.create.facts', ['id' => $course->id]) : route('instructor.courses.create') }}">Facts</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? route('instructor.courses.create.objectives', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Objects</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'.$course->id.'/price') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Price</a></p>
                    </div>
                     <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'.$course->id.'/design') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Design</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'. $course->id.'/content') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Contents</a></p>
                    </div>
                   
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'.$course->id.'/certificate') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Certificate</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'.$course->id.'/visibility') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Visibility</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ $course->id ? url('instructor/courses/create/'.$course->id.'/share') : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">Share</a></p>
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
                @if($course->id)
                <form action="{{ route('instructor.courses.create.facts.store', ['id' => $course->id]) }}" method="POST">
                @else
                <form action="{{ route('instructor.courses.create.start') }}" method="POST">
                @endif
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
                    <div class="content-settings-form-wrap">
                        <h4>Course Information</h4>
                        <div class="form-group">
                            <input id="title" name="title" class="form-control" type="text"
                                value="{{ old('title', $course->title ?? '') }}">
                            <label for="title">Title</label>
                            <span class="invalid-feedback">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input id="slug" name="slug" class="form-control" type="text"
                                value="{{ old('slug', $course->slug ?? '') }}">
                            <label for="slug">Slug</label>
                        </div>
                        <div class="form-group">
                            <h6>Short Description</h6>
                            <div id="short_description" style="height: 150px;"></div>
                            <input type="hidden" name="short_description" id="short_description_hidden" value="{{ old('short_description', $course->short_description ?? '') }}">
                        </div>
                        <div class="form-group">
                            <h6>Description</h6>
                            <div id="description" style="height: 250px;"></div>
                            <input type="hidden" name="description" id="description_hidden" value="{{ old('description', $course->description ?? '') }}">
                        </div>

                        <div class="form-group">
                            <h6>Category</h6>
                            <input id="categories" data-role="tagsinput" name="categories" class="form-control"
                                placeholder="ex: Figma, Adobe XD" type="text"
                                value="{{ old('categories', $course->categories ?? '') }}">
                        </div>
                    </div>

                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('instructor/courses') }}" class="btn-cancel">Back</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/tags.js') }}"></script>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get initial content from hidden fields
        var initialShortDescription = document.getElementById('short_description_hidden').value;
        var initialDescription = document.getElementById('description_hidden').value;

        var short_description = new Quill('#short_description', {
            theme: 'snow',
            placeholder: 'Enter Short Description'
        });
        
        var description = new Quill('#description', {
            theme: 'snow',
            placeholder: 'Enter Description'
        });

        // Set initial content if it exists and is not empty
        if (initialShortDescription && initialShortDescription.trim() !== '') {
            short_description.root.innerHTML = initialShortDescription;
        }
        
        if (initialDescription && initialDescription.trim() !== '') {
            description.root.innerHTML = initialDescription;
        }

        // Update hidden field on text change for short description
        short_description.on('text-change', function() {
            let content = short_description.root.innerHTML;
            const hiddenInput = document.getElementById('short_description_hidden');
            
            if (content === '<p><br></p>' || content === '<p></p>' || content.trim() === '') {
                hiddenInput.value = '';
            } else {
                hiddenInput.value = content;
            }
        });

        // Update hidden field on text change for description
        description.on('text-change', function() {
            let content = description.root.innerHTML;
            const hiddenInput = document.getElementById('description_hidden');

            if (content === '<p><br></p>' || content === '<p></p>' || content.trim() === '') {
                hiddenInput.value = '';
            } else {
                hiddenInput.value = content;
            }
        });

        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            // Populate hidden fields with Quill content before submission as a fallback
            var shortDescriptionContent = short_description.root.innerHTML;
            if (shortDescriptionContent === '<p><br></p>' || shortDescriptionContent === '<p></p>' || shortDescriptionContent.trim() === '') {
                document.getElementById('short_description_hidden').value = '';
            } else {
                document.getElementById('short_description_hidden').value = shortDescriptionContent;
            }

            var descriptionContent = description.root.innerHTML;
            if (descriptionContent === '<p><br></p>' || descriptionContent === '<p></p>' || descriptionContent.trim() === '') {
                document.getElementById('description_hidden').value = '';
            } else {
                document.getElementById('description_hidden').value = descriptionContent;
            }
        });
    });
</script>

<script>
    const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('keyup', function() {
            const titleValue = titleInput.value;
            const slugValue = slugify(titleValue);
            slugInput.value = slugValue; // Set the slug value
        });

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }
</script>
@endsection
