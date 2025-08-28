@extends('layouts.latest.instructor')
@section('title')
Course Create - Initial Step
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
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/facts' }}">Facts</a>
                            </p>
                        </div>
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/objects' }}">Objects</a>
                            </p>
                        </div>
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/price' }}">Price</a>
                            </p>
                        </div>
                         <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/design' }}">Design</a>
                            </p>
                        </div>
                        <div class="step-box current">
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a
                                    href="{{ url('instructor/courses/creater'.request()->route('id')).'/content' }}">Contents</a>
                            </p>
                        </div>
                       
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/certificate' }}">Certificate</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/visibility' }}">Visibility</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/share' }}">Share</a>
                            </p>
                        </div>
                    </div>
                
                @if ( session()->has('course_id') )
                    @include('e-learning.course.instructor.create.save-finish')
                @endif
            </div>
        </div>

        <!-- Blade view file -->

        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <div class="content-step-wrap">
                    <div class="text-center mb-2">
                        <span class="invalid-feedback">@error('module_name'){{ $message }} @enderror</span>
                        <span class="invalid-feedback">@error('lesson_name'){{ $message }} @enderror</span>
                    </div>
                    <div id="moduleResorting">
                        @foreach ($modules as $module)

                        {{-- course with page --}}
                            <div class="course-with-page" data-module-id="{{ $module->id }}">
                                {{-- course content box start --}}
                                <div class="course-content-box course-content-inside">
                                    <div class="title">
                                        <div class="media">
                                            <img src="{{asset('assets/images/icons/book.svg')}}" alt="Bar"
                                                class="img-fluid">
                                            <div class="media-body">
                                                <h5>{{ $module->title}} {{ $module->checkNumber() ? $loop->iteration : ""}}</h5>
                                                <p>Module with {{ count($module->lessons) }} lessons</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions module-dropdown-box">
                                        <div class="dropdown">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop_{{$module->id}}">Edit Module</a>
                                                </li>
                                                <form action="{{ route('instructor.modules.delete', ['id' => $module->id]) }}" method="post"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <li>
                                                        <button type="submit" class="btn dropdown-item">Remove Module</button>
                                                    </li>
                                                </form>
                                            </ul>

                                            {{-- module update modal --}}
                                            <div class="course-name-modal">
                                                <div class="modal fade" id="staticBackdrop_{{$module->id}}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdrop_{{$module->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="course-name-txt">
                                                                    <h5>Module name</h5>
                                                                    <form action="{{ route('instructor.modules.create', ['course_id' => request()->route('id')]) }}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="module_id" value="{{$module->id}}">
                                                                        <div class="form-group form-error">
                                                                            <input autocomplete="off" type="text" placeholder="Enter Module Name"
                                                                                name="module_name" class="form-control @error('module_name') is-invalid @enderror"
                                                                                value="{{$module->title}}">

                                                                            {{-- <span class="invalid-feedback">@error('module_name'){{ $message }} @enderror</span> --}}
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="publish_at_{{ $module->id }}">Publish At</label>
                                                                            <input type="datetime-local" id="publish_at_{{ $module->id }}" name="publish_at" class="form-control"
                                                                                value="{{ $module->publish_at ? $module->publish_at->format('Y-m-d\TH:i') : '' }}">
                                                                            <small class="form-text text-muted">Leave empty to publish immediately. Set a date to schedule publishing.</small>
                                                                        </div>
                                                                        <div class="form-submit">
                                                                            <button type="button" class="btn btn-cancel"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-submit">Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- module update modal --}}
                                        </div>
                                        <a href="#" class="accrodin-bttn"><i class="fas fa-angle-down"></i></a>
                                    </div>
                                </div>
                                {{-- course content box end --}}

                                <div class="toggle-box-wrap {{ request()->input('tab') == $module->id ? 'active' : ''}} {{ request()->tab == 'active' ? 'active' : ''}} lessonResorting">
                                    @foreach ($module->lessons()->orderBy('reorder', 'ASC')->get() as $lesson)
                                    {{-- course page box start --}}
                                        <div class="course-content-box course-page-box" data-module-lession-id="{{ $lesson->id }}">
                                            <div class="title">
                                                <img src="{{asset('assets/images/icons/bars-2.svg')}}" alt="Bar"
                                                    class="img-fluid me-4">
                                                <div class="media">
                                                    @if ($lesson->type == 'text')
                                                    <img src="{{asset('assets/images/icons/file.svg')}}" alt="file"
                                                        class="img-fluid">
                                                    @elseif ($lesson->type == 'video')
                                                    <img src="{{asset('assets/images/icons/video.svg')}}" alt="file"
                                                        class="img-fluid">
                                                    @elseif ($lesson->type == 'audio')
                                                    <img src="{{asset('assets/images/icons/audio.svg')}}" alt="file"
                                                        class="img-fluid">
                                                    @endif

                                                    <div class="media-body">
                                                        <h5>{{ $lesson->title }}</h5>
                                                        <p>{{ $lesson->type }}</p>
                                                        @if($lesson->status == 'pending')
                                                            <span class="badge text-danger ms-0">No content</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        @if ($lesson->type == 'audio')
                                                        <a class="dropdown-item"
                                                            href="{{ url('instructor/courses/create/'.$lesson->course_id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id) }}">Add Content</a>
                                                        @elseif($lesson->type == 'video')
                                                        <a class="dropdown-item"
                                                            href="{{ url('instructor/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}">Add Content </a>
                                                        @elseif($lesson->type == 'text')
                                                        <a class="dropdown-item"
                                                            href="{{ url('instructor/courses/create/'.$lesson->course_id.'/text/'.$lesson->module_id.'/content/'.$lesson->id) }}">Add  Content </a>

                                                        @else
                                                        <a class="dropdown-item" href="#">Invalid Type</a>
                                                        @endif

                                                    </li>
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#lessonAddModal_{{ $lesson->id }}">Edit Lesson</a></li>
                                                    <form action="{{ route('instructor.lessons.delete', ['id' => $lesson->id]) }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <li>
                                                            <button type="submit" class="btn dropdown-item">Remove Lesson</button>
                                                        </li>
                                                    </form>
                                                </ul>

                                                <div class="course-name-modal">
                                                    <div class="modal fade" id="lessonAddModal_{{ $lesson->id }}" tabindex="-1"
                                                        aria-labelledby="lessonAddModal_{{ $lesson->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="course-name-txt">
                                                                        <h5>Lesson name</h5>
                                                                        <form
                                                                            action="{{ route('instructor.lessons.update', ['id' => $lesson->id]) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="course_id"
                                                                                value="{{$module->course_id}}">
                                                                            <input type="hidden" name="module_id"
                                                                                value="{{$module->id}}">
                                                                            <input type="hidden" name="lesson_id"
                                                                                value="{{$lesson->id}}">
                                                                            <div class="form-group form-error">
                                                                                <input autocomplete="off" type="text" placeholder="Enter Lesson Name"
                                                                                    name="lesson_name" value="{{ $lesson->title }}"
                                                                                    class="form-control @error('lesson_name') is-invalid @enderror">

                                                                                {{-- <span class="invalid-feedback">@error('lesson_name'){{ $message }} @enderror</span> --}}
                                                                            </div>
                                                                            <div class="page-type mb-4">
                                                                                <h6>Type</h6>

                                                                                <input type="radio" name="lesson_type"
                                                                                    class="opacity-0" id="les_text_{{$lesson->id}}"
                                                                                    value="text" {{ $lesson->type == 'text' ?
                                                                                'checked' : ''}}>
                                                                                <input type="radio" name="lesson_type"
                                                                                    class="opacity-0" id="les_audio_{{$lesson->id}}"
                                                                                    value="audio" {{ $lesson->type == 'audio' ?
                                                                                'checked' : ''}}>
                                                                                <input type="radio" name="lesson_type"
                                                                                    class="opacity-0" id="les_video_{{$lesson->id}}"
                                                                                    value="video" {{ $lesson->type == 'video' ?
                                                                                'checked' : ''}}>

                                                                                <div class="d-flex lesson-types2">

                                                                                    <label for="les_text_{{$lesson->id}}"
                                                                                        class="{{ $lesson->type == 'text' ? 'active' : '' }}"><img
                                                                                            src="{{asset('assets/images/icons/file.svg')}}"
                                                                                            alt="a" class="img-fluid"> Text</label>
                                                                                    <label for="les_audio_{{$lesson->id}}"
                                                                                        class="{{ $lesson->type == 'audio' ? 'active' : '' }}"><img
                                                                                            src="{{asset('assets/images/icons/audio.svg')}}"
                                                                                            alt="a" class="img-fluid"> Audio</label>
                                                                                    <label for="les_video_{{$lesson->id}}"
                                                                                        class="{{ $lesson->type == 'video' ? 'active' : '' }}"><img
                                                                                            src="{{asset('assets/images/icons/video.svg')}}"
                                                                                            alt="a" class="img-fluid"> Video</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="page-type mb-4">
                                                                                <h6>Is Public Lesson</h6>                        

                                                                                <div class="d-flex lesson-types2">

                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" name="is_public" value="1" role="switch" id="is_public_edit_{{$lesson->id}}" {{ $lesson->is_public ? 'checked' : '' }}>
                                                                                    </div>
                                                                                </div>
                                                                                <p>Allow visitors to access without login</p>
                                                                            </div>


                                                                            

                                                                            <div class="form-submit">
                                                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="submit" class="btn btn-submit">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        {{-- course page box end --}}
                                    @endforeach

                                    {{-- course page add box start --}}
                                    <div class="add-content-box mt-3">
                                        <button type="button" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#lessonModal_{{$module->id}}"><i class="fas fa-plus"></i> Add Lesson
                                        </button>
                                    </div>
                                    {{-- course page add box end --}}

                                    {{-- lesson modal --}}
                                    <div class="course-name-modal">
                                        <div class="modal fade" id="lessonModal_{{$module->id}}" tabindex="-1"
                                            aria-labelledby="lessonModal_{{$module->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="course-name-txt">
                                                            <h5>Lesson name</h5>
                                                            <form action="{{ route('instructor.lessons.create', ['course_id' => $module->course_id, 'module_id' => $module->id]) }}" method="post">
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
                                                                <input type="hidden" name="module_id" value="{{$module->id}}">
                                                                <div class="form-group form-error">
                                                                    <input autocomplete="off" type="text" placeholder="Enter Lesson Name"
                                                                        name="lesson_name" class="form-control @error('lesson_name') is-invalid @enderror">

                                                                    {{-- <span class="invalid-feedback">@error('lesson_name'){{ $message }} @enderror</span> --}}
                                                                </div>
                                                                <div class="page-type mb-4">
                                                                    <h6>Type</h6>

                                                                    <input type="radio" name="lesson_type" class="opacity-0"
                                                                        id="les_text_{{$module->id}}" value="text">
                                                                    <input type="radio" name="lesson_type" class="opacity-0"
                                                                        id="les_audio_{{$module->id}}" value="audio">
                                                                    <input type="radio" name="lesson_type" class="opacity-0"
                                                                        id="les_video_{{$module->id}}" value="video" checked>

                                                                    <div class="d-flex lesson-types">
                                                                        <label for="les_text_{{$module->id}}"
                                                                            class=""><img
                                                                                src="{{asset('assets/images/icons/file.svg')}}"
                                                                                alt="a" class="img-fluid"> Text</label>
                                                                        <label for="les_audio_{{$module->id}}"
                                                                            class=""><img
                                                                                src="{{asset('assets/images/icons/audio.svg')}}"
                                                                                alt="a" class="img-fluid"> Audio</label>
                                                                        <label for="les_video_{{$module->id}}"
                                                                            class="active"><img
                                                                                src="{{asset('assets/images/icons/video.svg')}}"
                                                                                alt="a" class="img-fluid"> Video</label>
                                                                    </div>
                                                                </div>
                                                                
                                                            
                                                                <div class="page-type mb-4">
                                                                                <h6>Is Public Lesson</h6>                        

                                                                                <div class="d-flex lesson-types2">

                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" name="is_public" value="1" role="switch" id="is_public_new_{{$module->id}}">
                                                                                    </div>
                                                                                </div>
                                                                                <p>Allow visitors to access without login</p>
                                                                            </div>
                                                                
                                                                <div class="form-submit">
                                                                    <button type="button" class="btn btn-cancel"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-submit">Confirm</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Lesson modal --}}
                                </div>
                            </div>
                        {{-- course with page --}}
                        @endforeach
                    </div>
                    {{-- course content add box start --}}
                    <div class="add-content-box">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#moduleModal"><i
                                class="fas fa-plus"></i> Add Module</button>
                    </div>
                    {{-- course content add box end --}}
                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('instructor/courses/create/') }}">Back</a>

                        @if (count($modules) > 0)
                            <a href="{{ url('instructor/courses/create/'.request()->route('id').'/certificate') }}">Next</a>
                        @else
                            <a href="#" data-bs-toggle="modal" data-bs-target="#moduleModal">Add Module</a>
                        @endif
                    </div>
                    {{-- step next bttns --}}
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

                        <form action="{{ route('instructor.modules.create', ['course_id' => request()->route('id')]) }}" method="post">
                            @csrf
                            <div class="form-group form-error">
                                <input autocomplete="off" type="text" placeholder="Enter Module Name" name="module_name"
                                    class="form-control @error('module_name') is-invalid @enderror">

                            </div>
                            <div class="form-group">
                                <label for="publish_at">Publish At</label>
                                <input type="datetime-local" id="publish_at" name="publish_at" class="form-control">
                                <small class="form-text text-muted">Leave empty to publish immediately. Set a date to schedule publishing.</small>
                            </div>
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

@section('script')



<script>
    // Module resorting
    $(function() {
        $("#moduleResorting").sortable({
            update: function(event, ui) {
                var moduleOrder = $(this).sortable("toArray", { attribute: "data-module-id" });
                moduleOrder = moduleOrder.filter(function(item) {
                    return item !== '';
                });
                updateModuleOrder( moduleOrder );
            }
        });
    });


    // Lession resorting
    $(function() {
        $(".lessonResorting").sortable({
            update: function(event, ui) {
                var moduleLessonOrder = $(this).sortable("toArray", { attribute: "data-module-lession-id" });
                moduleLessonOrder = moduleLessonOrder.filter(function(item) {
                    return item !== '';
                });

                updateModuleLessionOrder( moduleLessonOrder );
            }
        });
    });


    function updateModuleOrder(moduleOrder) {
        $.ajax({
            url: "/instructor/module/sortable",
            type: "POST",
            data: {
                moduleOrder: moduleOrder,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log("Module reorder updated successfully");
            },
            error: function(xhr, status, error) {
                console.error("Error updating module order:", error);
            }
        });
    }

    function updateModuleLessionOrder(moduleLessonOrder){
        $.ajax({
            url: "/instructor/module/lesson/sortable",
            type: "POST",
            data: {
                lessonOrder: moduleLessonOrder,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // console.log("Module lession reorder updated successfully");
            },
            error: function(xhr, status, error) {
                // console.error("Error updating module order:", error);
            }
        });
    }


</script>






<script>
    document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".accrodin-bttn");
    buttons.forEach(function(button) {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const toggleBoxWrap = this.parentElement.parentElement.parentElement.querySelector(".toggle-box-wrap");

            if (toggleBoxWrap) {

                this.querySelector(".fa-angle-down").classList.toggle("rotate");

                if (toggleBoxWrap.style.maxHeight) {
                    toggleBoxWrap.style.maxHeight = null;
                } else {
                    toggleBoxWrap.style.maxHeight = toggleBoxWrap.scrollHeight + "px";
                }
            }
        });
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const typeBttns = document.querySelectorAll(".lesson-types label");

    typeBttns.forEach(function(bttn) {
        bttn.addEventListener("click", function(e) {
            typeBttns.forEach(c => c.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const typeBttns2 = document.querySelectorAll(".lesson-types2 label");
    typeBttns2.forEach(function(bttn2) {
        bttn2.addEventListener("click", function(e) {
            typeBttns2.forEach(c2 => c2.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

</script>
@endsection
