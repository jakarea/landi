@extends('layouts.latest.admin')
@section('title')
Course Update - Course Name
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
                    <div class="step-box active">
                        <span class="circle">
                            <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                class="img-fluid">
                        </span>
                        <p><a href="{{ url('admin/courses/create', optional(request())->route('id')) }}">Contents</a></p>
                    </div>
                    <div class="step-box current">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/objects' }}">Objects</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/price' }}">Price</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/design' }}">Design</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/certificate' }}">Certificate</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/visibility' }}">Visibility</a></p>
                    </div>
                    <div class="step-box">
                        <span class="circle"></span>
                        <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/share' }}">Share</a></p>
                    </div>
                </div>
                {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <form action="{{ route('admin.course.store.step-1', [$course ? $course->id : '']) }}" method="POST">
                    @csrf
                    <div class="content-settings-form-wrap">
                        <h4>Course Information</h4>
                        <div class="form-group">
                            <input id="title" name="title" class="form-control" type="text"
                                value="{{ $course ? $course->title : old('title') }}">
                            <label for="title">Title</label>
                            <span class="invalid-feedback">
                                @error('title')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <input id="slug" name="slug" class="form-control" type="text"
                                value="{{ $course ? $course->slug : old('slug') }}">
                            <label for="slug">Slug</label>
                        </div>
                        <div class="form-group">
                            <h6>Short Description</h6>
                            <textarea class="form-control" placeholder="Enter Short Description"
                                name="short_description"
                                id="short_description">{{ $course ? $course->short_description : old('short_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <h6>Description</h6>
                            <textarea class="form-control" name="description"
                                id="description">{{ $course ? $course->description : old('description') }}</textarea>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <h6>User must manually tick off each lesson</h6>
                            <div class="form-check form-switch">
                                123<input class="form-check-input" type="checkbox" name="auto_complete" role="switch"
                                    id="flexSwitchCheckChecked" checked>
                            </div>
                        </div>

                        <div class="form-group">
                            <h6>Total Curriculum</h6>
                            <input id="curriculum" name="curriculum" class="form-control" placeholder="Total Curriculum" type="text"
                                value="{{ $course ? $course->curriculum : old('curriculum') }}">
                        </div>

                        <div class="form-group">
                            <h6>Language</h6>
                            <input id="language" name="language" class="form-control" placeholder="Language" type="text"
                                value="{{ $course ? $course->language : old('language') }}">
                        </div>
                        <div class="form-group">
                            <h6>Category</h6>
                            <input id="categories" data-role="tagsinput" name="categories" class="form-control"
                                placeholder="ex: Figma, Adobe XD, Photoshop" type="text"
                                value="{{ $course ? $course->categories : old('categories') }}"> 
                        </div>
                    </div>

                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('admin/courses/create/' . $course->id) }}" class="btn-cancel">Back</a>
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