@extends('layouts.latest.admin')
@section('title')
Course Update - Add Objective
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
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('admin/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a></p>
                </div>
                <div class="step-box current">
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
                <form action="" method="POST" id="objectForm">
                    @csrf
                    <div class="content-settings-form-wrap">
                        <h4>Here’s what you’ll learn</h4>

                        <div class="object-list-wrap">
                            @if (!empty($course->objective))
                            @foreach (explode('[objective]', $course->objective) as $index => $objective)
                            <div class="item">
                                <i class="fas fa-check"></i>
                                <input autocomplete="off" type="text" value="{{ $objective }}" class="form-control" disabled>
                                <div class="actions">
                                    <a href="#" class="me-2 edit-item" data-index="{{ $index }}">
                                        <img src="{{ asset('assets/images/icons/pen-m.svg') }}" alt="Edit"
                                            class="img-fluid">
                                    </a>
                                    <a href="#" class="delete-item" data-index="{{ $index }}">
                                        <img src="{{ asset('assets/images/icons/minus-m.svg') }}" alt="Delete"
                                            class="img-fluid">
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div id="appendItems"></div>
                        </div>
                        <input type="hidden" id="itemIndex" value="">
                        <div class="form-group">
                            <h6>Object Title</h6>
                            <textarea class="form-control" name="objective[]" placeholder="Enter objective"
                                id="objective" required>{{ old('objective') }}</textarea>
                        </div>
                        <div class="submit-bttns-box">
                            <button class="btn btn-cancel" type="reset">Cancel</button>
                            <button class="btn btn-submit" type="submit">Save</button>
                        </div>
                        {{-- <div class="add-object">
                            <button class="btn btn-add" type="button" id="add-item-button"><i class="fas fa-plus"></i>
                                Add Object</button>
                        </div> --}}
                    </div>

                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{url('admin/courses/create/'.$course->id.'/facts')}}" class="btn-cancel">Back</a>
                        <a href="{{url('admin/courses/create/'.$course->id.'/price')}}" class="btn-submit">Next</a>
                    </div>
                    {{-- step next bttns --}}
                </form>
            </div>
        </div>
</main>
@endsection
{{-- page content @E --}}

{{-- script js --}}
@section('script')

{{-- delete object ajax js --}}
<script> 
    document.addEventListener('DOMContentLoaded', function () {
        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/'); 
        const deleteItem = document.querySelectorAll('.delete-item');
 
        deleteItem.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                item.parentNode.parentNode.style.display = 'none'; 
                let courseId = @json($course->id);  
                let dataIndex = item.getAttribute('data-index');  
                 
                    if (courseId) {
                        fetch(`${baseUrl}/admin/courses/create/${courseId}/delete-objects/${dataIndex}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'DONE') {
                                    item.parentNode.parentNode.style.display = 'none'; 

                                } else {
                                    item.parentNode.parentNode.style.display = 'block'; 
                                }
                            })
                            .catch(error => {
                                item.parentNode.parentNode.style.display = 'block'; 
                            });
                    }
                });


            });
        });
         
</script>

{{-- frontend value assigned object js --}}
<script> 
    document.addEventListener('DOMContentLoaded', function () { 
        let editItem = document.querySelectorAll('.edit-item');
        let itemIndex = document.querySelector('#itemIndex');
        let objectiveTextArea = document.querySelector('#objective');
 
        editItem.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                let dataIndex = item.getAttribute('data-index');
                itemIndex.value = dataIndex; 
                objectiveTextArea.value = item.parentNode.parentNode.querySelector('input').value;
                objectiveTextArea.focus(); 
                });
            });
        });
         
</script>

{{-- add object ajax js --}}
<script> 
    document.addEventListener('DOMContentLoaded', function () {
        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/'); 
        const objectForm = document.querySelector('#objectForm');
        let itemIndex = document.querySelector('#itemIndex');
        let objectiveTextArea = document.querySelector('#objective');
  
        objectForm.addEventListener('submit', function(e) {

            e.preventDefault();
 
                let courseId = @json($course->id);  
                let dataIndex = itemIndex.value;  
                 
                    if (courseId) {

                        const requestBody = JSON.stringify({
                            dataIndex: dataIndex,
                            objective: objectiveTextArea.value,
                        });


                        fetch(`${baseUrl}/admin/courses/create/${courseId}/objects`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: requestBody,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'ADDED') {  

                                    let appendItems = document.querySelector('#appendItems'); 

                                    const newItem = document.createElement('div');
                                    newItem.className = 'item';
                                    newItem.innerHTML = `
                                        <i class="fas fa-check"></i>
                                        <input type="text" value="${objectiveTextArea.value}" class="form-control" disabled>
                                        <div class="actions">
                                            <span class="badge text-bg-success">New</span>
                                        </div>
                                    `;

                                    // Append the new item to the container
                                    appendItems.appendChild(newItem);

                                    objectiveTextArea.value = '';

                                } else if(data.message === 'UPDATED') {  

                                    let updatedItems = e.target.querySelectorAll('.edit-item');

                                    updatedItems.forEach(itm => {
                                        if (itm.getAttribute('data-index') == dataIndex) {
                                            itm.parentNode.parentNode.querySelector('input').value = objectiveTextArea.value;
                                        }
                                    });

                                    objectiveTextArea.value = '';
                                }
                            })
                            .catch(error => { 
                            });
                    }
                });

            });          
</script>

@endsection
{{-- script js --}}