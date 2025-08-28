@extends('layouts.latest.instructor')
@section('title')
    Course Create - Add Objective
@endsection
{{-- page style @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /* Enhanced Sections Styling */
        .objective-items-list,
        .who-items-list {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            min-height: 60px;
        }
        
        .objective-item,
        .who-item {
            background: white;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            transition: all 0.2s ease;
        }
        
        .objective-item:hover,
        .who-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-color: #007bff;
        }
        
        .objective-item-content p,
        .who-item-content p {
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        
        .objective-item-actions .btn,
        .who-item-actions .btn {
            border-radius: 4px;
            padding: 4px 8px;
            transition: all 0.2s ease;
        }
        
        .objective-item-actions .btn:hover,
        .who-item-actions .btn:hover {
            transform: translateY(-1px);
        }
        
        .objective-form-actions,
        .who-form-actions {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        
        .objective-form-actions .btn,
        .who-form-actions .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .objective-form-actions .btn:hover,
        .who-form-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .objective-form-actions .btn-secondary,
        .who-form-actions .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .objective-form-actions .btn-primary,
        .who-form-actions .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }
        
        /* Empty state styling */
        .objective-items-list.empty-state::before {
            content: "No learning objectives added yet. Add your first objective below.";
            display: block;
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
        
        .who-items-list.empty-state::before {
            content: "No target audience added yet. Add your first item below.";
            display: block;
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
        
        /* Form label styling */
        .form-label.fw-semibold {
            color: #495057;
            margin-bottom: 8px;
        }
        
        /* Textarea styling */
        #objective,
        #who_should_join {
            border-radius: 6px;
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        #objective:focus,
        #who_should_join:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection
{{-- page style @E --}}

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
                        <div class="step-box current">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/objectives' }}">Objects</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/pricing' }}">Price</a>
                            </p>
                        </div>
                         <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/design' }}">Design</a>
                            </p>
                        </div>
                        
                        <div class="step-box">
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a>
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
                    {{-- course step --}}

                    @if ( session()->has('course_id') )
                        @include('e-learning.course.instructor.create.save-finish')
                    @endif

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
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
                    <div class="content-settings-form-wrap">
                        <h4>Here's what you'll learn</h4>

                        <div class="objective-items-list mb-3 {{ empty($course->objective) ? 'empty-state' : '' }}" id="objectiveItemsList">
                            @if (!empty($course->objective))
                                @foreach (explode('[objective]', $course->objective) as $index => $objective)
                                    @if(trim($objective) !== '')
                                        <div class="objective-item d-flex align-items-center justify-content-between mb-2 p-2">
                                            <div class="objective-item-content d-flex align-items-center flex-grow-1">
                                                <i class="fas fa-check text-success me-2"></i>
                                                <p class="mb-0">{{ $objective }}</p>
                                            </div>
                                            <div class="objective-item-actions">
                                                <a href="#" class="btn btn-sm btn-outline-primary me-1 edit-item" data-index="{{ $index }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-danger delete-item" data-index="{{ $index }}" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div id="appendItems"></div>
                        </div>
                        
                        <input type="hidden" id="itemIndex" value="">
                        <div class="form-group mb-3">
                            <textarea class="form-control" placeholder="Enter what students will learn..." id="objective" rows="3">{{ old('objective') }}</textarea>
                        </div>
                        
                        <div class="objective-form-actions d-flex gap-2 justify-content-end">
                            <button class="btn btn-secondary px-4" type="button" id="cancel-objective-button">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </button>
                            <button class="btn btn-primary px-4" type="button" id="save-objective-button">
                                <i class="fas fa-save me-1"></i>
                                Save
                            </button>
                        </div>
                    </div>

                        {{-- Who Should Join Section --}}
                        <div class="content-settings-form-wrap mt-4">
                            <h4>Who Should Join?</h4>

                            <div class="who-items-list mb-3 {{ empty($course->who_should_join) ? 'empty-state' : '' }}" id="whoItemsList">
                                @if (!empty($course->who_should_join))
                                    @foreach (explode('[who_should_join]', $course->who_should_join) as $index => $who_item)
                                        @if(trim($who_item) !== '')
                                            <div class="who-item d-flex align-items-center justify-content-between mb-2 p-2">
                                                <div class="who-item-content d-flex align-items-center flex-grow-1">
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    <p class="mb-0">{{ $who_item }}</p>
                                                </div>
                                                <div class="who-item-actions">
                                                    <a href="#" class="btn btn-sm btn-outline-primary me-1 edit-who-item" data-index="{{ $index }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger delete-who-item" data-index="{{ $index }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div id="appendWhoItems"></div>
                            </div>
                            
                            <input type="hidden" id="whoItemIndex" value="">
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="who_should_join[]" placeholder="Who Item Title - Enter who should join this course..." id="who_should_join" rows="3" required>{{ old('who_should_join') }}</textarea>
                            </div>
                            
                            <div class="who-form-actions d-flex gap-2 justify-content-end">
                                <button class="btn btn-secondary px-4" type="button" id="cancel-who-button">
                                    <i class="fas fa-times me-1"></i>
                                    Cancel
                                </button>
                                <button class="btn btn-primary px-4" type="button" id="save-who-button">
                                    <i class="fas fa-save me-1"></i>
                                    Save
                                </button>
                            </div>
                        </div>

                    {{-- step next bttns --}}
                    <div class="back-next-bttns">
                        <a href="{{ url('instructor/courses/create/' . $course->id . '/facts') }}"
                            class="btn-cancel">Back</a>
                        <a href="{{ url('instructor/courses/create/' . $course->id . '/pricing') }}"
                            class="btn-submit">Next</a>
                    </div>
                    {{-- step next bttns --}}
                </div>
            </div>
    </main>
@endsection
{{-- page content @E --}}

{{-- script js --}}
@section('script')
    {{-- delete object ajax js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentURL = window.location.href;
            const baseUrl = currentURL.split('/').slice(0, 3).join('/');
            const deleteItem = document.querySelectorAll('.delete-item');

            deleteItem.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    item.closest('.objective-item').style.display = 'none';
                    let courseId = @json($course->id);
                    let dataIndex = item.getAttribute('data-index');

                    if (courseId) {
                        fetch(`${baseUrl}/instructor/courses/create/${courseId}/objectives/${dataIndex}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'DONE') {
                                    item.closest('.objective-item').remove();
                                    
                                    // Check if objectives list is empty and add empty state class
                                    let objectivesList = document.querySelector('#objectiveItemsList');
                                    let remainingItems = document.querySelectorAll('#appendItems .objective-item');
                                    if (remainingItems.length === 0 && objectivesList) {
                                        objectivesList.classList.add('empty-state');
                                    }

                                } else {
                                    item.closest('.objective-item').style.display = 'block';
                                }
                            })
                            .catch(error => {
                                item.closest('.objective-item').style.display = 'block';
                            });
                    }
                });


            });
        });
    </script>

    {{-- frontend value assigned object js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let editItem = document.querySelectorAll('.edit-item');
            let itemIndex = document.querySelector('#itemIndex');
            let objectiveTextArea = document.querySelector('#objective');

            editItem.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    let dataIndex = item.getAttribute('data-index');
                    itemIndex.value = dataIndex;
                    objectiveTextArea.value = item.closest('.objective-item').querySelector('p').textContent;
                    objectiveTextArea.focus();
                });
            });
        });
    </script>

    {{-- add object ajax js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentURL = window.location.href;
            const baseUrl = currentURL.split('/').slice(0, 3).join('/');
            const saveObjectiveButton = document.querySelector('#save-objective-button');
            let itemIndex = document.querySelector('#itemIndex');
            let objectiveTextArea = document.querySelector('#objective');

            saveObjectiveButton.addEventListener('click', function(e) {

                e.preventDefault();

                // Validate that objective is not empty
                if (!objectiveTextArea.value || objectiveTextArea.value.trim() === '') {
                    alert('Objective cannot be empty. Please enter an objective.');
                    objectiveTextArea.focus();
                    return;
                }

                let courseId = @json($course->id);
                let dataIndex = itemIndex.value;

                if (courseId) {

                    const requestBody = JSON.stringify({
                        dataIndex: dataIndex,
                        objective: objectiveTextArea.value,
                    });


                    fetch(`${baseUrl}/instructor/courses/create/${courseId}/objectives`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: requestBody,
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.message === 'ADDED') {

                                let appendItems = document.querySelector('#appendItems');
                                let objectivesList = document.querySelector('#objectiveItemsList');

                                const newItem = document.createElement('div');
                                newItem.className = 'objective-item d-flex align-items-center justify-content-between mb-2 p-2';
                                newItem.innerHTML = `
                                    <div class="objective-item-content d-flex align-items-center flex-grow-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <p class="mb-0">${objectiveTextArea.value}</p>
                                    </div>
                                    <div class="objective-item-actions">
                                        <span class="badge bg-success">New</span>
                                    </div>
                                `;

                                // Append the new item to the container
                                appendItems.appendChild(newItem);

                                // Remove empty state class when first item is added
                                if (objectivesList && objectivesList.classList.contains('empty-state')) {
                                    objectivesList.classList.remove('empty-state');
                                }

                                objectiveTextArea.value = '';
                                itemIndex.value = '';

                            } else if (data.message === 'UPDATED') {

                                let updatedItems = document.querySelectorAll('.edit-item');

                                updatedItems.forEach(itm => {
                                    if (itm.getAttribute('data-index') == dataIndex) {
                                        itm.closest('.objective-item').querySelector('p').textContent =
                                            objectiveTextArea.value;
                                    }
                                });

                                objectiveTextArea.value = '';
                                itemIndex.value = '';
                            }
                        })
                        .catch(error => {
                            if (error.error) {
                                alert(error.error);
                            } else {
                                alert('An error occurred while saving the objective.');
                            }
                            objectiveTextArea.focus();
                        });
                }
            });

            // Cancel objective button functionality
            const cancelObjectiveButton = document.querySelector('#cancel-objective-button');
            if (cancelObjectiveButton) {
                cancelObjectiveButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('#objective').value = '';
                    document.querySelector('#itemIndex').value = '';
                });
            }

        });
    </script>

    {{-- Who Should Join Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentURL = window.location.href;
            const baseUrl = currentURL.split('/').slice(0, 3).join('/');
            
            // Delete who item
            const deleteWhoItem = document.querySelectorAll('.delete-who-item');
            deleteWhoItem.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    item.closest('.who-item').style.display = 'none';
                    let courseId = @json($course->id);
                    let dataIndex = item.getAttribute('data-index');

                    if (courseId) {
                        fetch(`${baseUrl}/instructor/courses/create/${courseId}/audience/${dataIndex}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'DONE') {
                                    item.closest('.who-item').remove();
                                    
                                    // Check if who items list is empty and add empty state class
                                    let whoItemsList = document.querySelector('#whoItemsList');
                                    let remainingItems = document.querySelectorAll('#appendWhoItems .who-item');
                                    if (remainingItems.length === 0 && whoItemsList) {
                                        whoItemsList.classList.add('empty-state');
                                    }
                                } else {
                                    item.closest('.who-item').style.display = 'block';
                                }
                            })
                            .catch(error => {
                                item.closest('.who-item').style.display = 'block';
                            });
                    }
                });
            });

            // Edit who item
            let editWhoItem = document.querySelectorAll('.edit-who-item');
            let whoItemIndex = document.querySelector('#whoItemIndex');
            let whoShouldJoinTextArea = document.querySelector('#who_should_join');

            editWhoItem.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    let dataIndex = item.getAttribute('data-index');
                    whoItemIndex.value = dataIndex;
                    whoShouldJoinTextArea.value = item.closest('.who-item').querySelector('p').textContent;
                    whoShouldJoinTextArea.focus();
                });
            });

            // Save who item
            const saveWhoButton = document.querySelector('#save-who-button');
            const cancelWhoButton = document.querySelector('#cancel-who-button');

            saveWhoButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!whoShouldJoinTextArea.value || whoShouldJoinTextArea.value.trim() === '') {
                    alert('Who should join field cannot be empty. Please enter a description.');
                    whoShouldJoinTextArea.focus();
                    return;
                }

                let courseId = @json($course->id);
                let dataIndex = whoItemIndex.value;

                if (courseId) {
                    const requestBody = JSON.stringify({
                        dataIndex: dataIndex,
                        who_should_join: whoShouldJoinTextArea.value,
                    });

                    fetch(`${baseUrl}/instructor/courses/create/${courseId}/audience`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: requestBody,
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.message === 'ADDED') {
                                let appendWhoItems = document.querySelector('#appendWhoItems');
                                let whoItemsList = document.querySelector('#whoItemsList');
                                
                                const newItem = document.createElement('div');
                                newItem.className = 'who-item d-flex align-items-center justify-content-between mb-2 p-2';
                                newItem.innerHTML = `
                                    <div class="who-item-content d-flex align-items-center flex-grow-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <p class="mb-0">${whoShouldJoinTextArea.value}</p>
                                    </div>
                                    <div class="who-item-actions">
                                        <span class="badge bg-success">New</span>
                                    </div>
                                `;
                                appendWhoItems.appendChild(newItem);
                                
                                // Remove empty state class when first item is added
                                if (whoItemsList && whoItemsList.classList.contains('empty-state')) {
                                    whoItemsList.classList.remove('empty-state');
                                }
                                
                                whoShouldJoinTextArea.value = '';
                                whoItemIndex.value = '';
                            } else if (data.message === 'UPDATED') {
                                let updatedWhoItems = document.querySelectorAll('.edit-who-item');
                                updatedWhoItems.forEach(itm => {
                                    if (itm.getAttribute('data-index') == dataIndex) {
                                        itm.closest('.who-item').querySelector('p').textContent = whoShouldJoinTextArea.value;
                                    }
                                });
                                whoShouldJoinTextArea.value = '';
                                whoItemIndex.value = '';
                            }
                        })
                        .catch(error => {
                            if (error.error) {
                                alert(error.error);
                            } else {
                                alert('An error occurred while saving the who should join item.');
                            }
                            whoShouldJoinTextArea.focus();
                        });
                }
            });

            cancelWhoButton.addEventListener('click', function(e) {
                e.preventDefault();
                whoShouldJoinTextArea.value = '';
                whoItemIndex.value = '';
            });
        });
    </script>
@endsection
{{-- script js --}}
