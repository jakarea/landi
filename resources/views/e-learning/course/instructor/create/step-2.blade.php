@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - ধাপ ২')
@section('header-title', 'কোর্সের লক্ষ্য ও উদ্দেশ্য')
@section('header-subtitle', 'আপনার কোর্সের শিক্ষণীয় বিষয় এবং টার্গেট অডিয়েন্স নির্ধারণ করুন')

@section('style')
<style>
/* Progress steps styling */
.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-x: auto;
    padding: 1rem 0;
    gap: 0.5rem;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 80px;
    position: relative;
    flex-shrink: 0;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: 2px solid;
}

.step-item.current .step-circle {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-color: #5AEAF4;
    color: #091D3D;
    transform: scale(1.1);
}

.step-item.completed .step-circle {
    background-color: #10B981;
    border-color: #10B981;
    color: #FFFFFF;
}

.step-item.completed .step-circle i {
    font-size: 1rem;
}

.step-item:not(.current):not(.completed) .step-circle {
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.3);
    color: #9CA3AF;
}

.step-title {
    margin-top: 0.5rem;
    font-size: 0.75rem;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.step-item.current .step-title {
    color: #5AEAF4;
}

.step-item.completed .step-title {
    color: #10B981;
}

.step-item:not(.current):not(.completed) .step-title {
    color: #9CA3AF;
}

.step-title a {
    text-decoration: none;
    color: inherit;
}

.step-title a.disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Connection lines between steps */
.step-item:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: calc(100% + 0.25rem);
    width: calc(100% - 40px);
    height: 2px;
    background: rgba(255, 255, 255, 0.2);
    z-index: -1;
}

.step-item.completed:not(:last-child)::after {
    background: #10B981;
}

/* Items list styling */
.items-container {
    background-color: #0F2342;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    min-height: 120px;
    padding: 1rem;
    position: relative;
}

.items-list-item {
    background-color: #091D3D;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.items-list-item:hover {
    border-color: #5AEAF4;
    box-shadow: 0 4px 12px rgba(90, 234, 244, 0.1);
    transform: translateY(-1px);
}

.items-list-item:last-child {
    margin-bottom: 0;
}

.empty-state-message {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #9CA3AF;
    font-style: italic;
    pointer-events: none;
    opacity: 0.7;
}

.empty-state-message i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
    color: #5AEAF4;
}

/* Form styling */
.form-textarea-modern {
    width: 100%;
    padding: 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #FFFFFF;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
    resize: vertical;
    min-height: 100px;
}

.form-textarea-modern:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-textarea-modern::placeholder {
    color: #9CA3AF;
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: transparent;
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #C7C7C7;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    border-color: #F97316;
    color: #F97316;
    background-color: rgba(249, 115, 22, 0.1);
}

.btn-next {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-secondary {
    background-color: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #C7C7C7;
}

.btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    color: #FFFFFF;
}

.btn-primary {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(90, 234, 244, 0.3);
}

.btn-danger {
    background-color: rgba(239, 68, 68, 0.1);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #FCA5A5;
}

.btn-danger:hover {
    background-color: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.5);
    color: #EF4444;
}

/* Item action buttons */
.item-action-btn {
    padding: 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2rem;
    height: 2rem;
}

.item-action-btn:hover {
    transform: translateY(-1px);
}

.btn-edit {
    background-color: rgba(59, 130, 246, 0.1);
    color: #60A5FA;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.btn-edit:hover {
    background-color: rgba(59, 130, 246, 0.2);
    color: #3B82F6;
}

.btn-delete {
    background-color: rgba(239, 68, 68, 0.1);
    color: #FCA5A5;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.btn-delete:hover {
    background-color: rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

/* New item badge */
.new-badge {
    background: linear-gradient(135deg, #10B981, #34D399);
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Form buttons container */
.form-buttons {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 1rem;
}

.form-buttons .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid;
    cursor: pointer;
}

/* Error styling */
.error-alert {
    background-color: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 2rem;
}

.error-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-list li {
    color: #FCA5A5;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.error-list li::before {
    content: '•';
    color: #EF4444;
    font-weight: bold;
    display: inline-block;
    width: 1rem;
}

/* Section titles */
.section-title {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #5AEAF4;
    font-size: 1.5rem;
}

/* Responsive design */
@media (max-width: 768px) {
    .step-progress {
        padding: 0.5rem;
    }
    
    .step-item {
        min-width: 60px;
    }
    
    .step-circle {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    
    .step-title {
        font-size: 0.6875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-back,
    .btn-next {
        width: 100%;
        justify-content: center;
    }
    
    .form-buttons {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .form-buttons .btn {
        width: 100%;
    }
    
    .items-list-item {
        padding: 0.75rem;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="step-progress">
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.facts', ['id' => $course->id]) }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">2</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.objectives', ['id' => $course->id]) }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.pricing', ['id' => $course->id]) }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.design', ['id' => $course->id]) }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.content', ['id' => $course->id]) }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.certificate', ['id' => $course->id]) }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.visibility', ['id' => $course->id]) }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.publish', ['id' => $course->id]) }}">প্রকাশ</a>
                </div>
            </div>
        </div>

        @if ( session()->has('course_id') )
            <div class="text-center mt-6 pt-6 border-t border-[#fff]/20">
                <a href="{{ url('instructor/finish/edit') }}" 
                   class="inline-flex items-center gap-2 bg-lime text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-orange hover:text-primary">
                    <i class="fas fa-save"></i>
                    সংরক্ষণ করুন এবং সমাপ্ত করুন
                </a>
            </div>
        @endif
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="error-alert">
        <ul class="error-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Learning Objectives Section -->
    <div class="bg-card rounded-xl shadow-2">
        <div class="p-8">
            <h2 class="section-title">
                <i class="fas fa-graduation-cap"></i>
                শিক্ষার্থীরা এখানে কী শিখবে?
            </h2>

            <!-- Objectives List -->
            <div class="items-container {{ empty($course->objective) ? 'empty-state' : '' }}" id="objectiveItemsList">
                @if (empty($course->objective))
                    <div class="empty-state-message">
                        <i class="fas fa-lightbulb"></i>
                        <div>এখনও কোনো শিক্ষণীয় উদ্দেশ্য যোগ করা হয়নি</div>
                        <small>নিচে আপনার প্রথম উদ্দেশ্য যোগ করুন</small>
                    </div>
                @else
                    @foreach (explode('[objective]', $course->objective) as $index => $objective)
                        @if(trim($objective) !== '')
                            <div class="items-list-item">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-r from-blue to-lime flex items-center justify-center">
                                                <i class="fas fa-check text-primary text-xs"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium mb-0">{{ $objective }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4">
                                        <button class="item-action-btn btn-edit edit-item" data-index="{{ $index }}" title="সম্পাদনা করুন">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="item-action-btn btn-delete delete-item" data-index="{{ $index }}" title="মুছে ফেলুন">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                <div id="appendItems"></div>
            </div>

            <!-- Add Objective Form -->
            <div class="mt-6">
                <input type="hidden" id="itemIndex" value="">
                <div class="mb-4">
                    <label class="block text-white font-medium mb-3">
                        <i class="fas fa-plus-circle text-blue mr-2"></i>
                        নতুন শিক্ষণীয় উদ্দেশ্য যোগ করুন
                    </label>
                    <textarea class="form-textarea-modern" 
                              placeholder="শিক্ষার্থীরা এই কোর্স থেকে কী শিখবে তা লিখুন... (যেমন: JavaScript এর মৌলিক বিষয়গুলি শিখতে পারবেন)" 
                              id="objective" 
                              rows="4">{{ old('objective') }}</textarea>
                </div>
                
                <div class="form-buttons">
                    <button class="btn btn-secondary" type="button" id="cancel-objective-button">
                        <i class="fas fa-times mr-2"></i>
                        বাতিল
                    </button>
                    <button class="btn btn-primary" type="button" id="save-objective-button">
                        <i class="fas fa-save mr-2"></i>
                        সংরক্ষণ করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Who Should Join Section -->
    <div class="bg-card rounded-xl shadow-2">
        <div class="p-8">
            <h2 class="section-title">
                <i class="fas fa-users"></i>
                কারা এই কোর্সে অংশগ্রহণ করতে পারবে?
            </h2>

            <!-- Who Should Join List -->
            <div class="items-container {{ empty($course->who_should_join) ? 'empty-state' : '' }}" id="whoItemsList">
                @if (empty($course->who_should_join))
                    <div class="empty-state-message">
                        <i class="fas fa-user-plus"></i>
                        <div>এখনও কোনো টার্গেট অডিয়েন্স যোগ করা হয়নি</div>
                        <small>নিচে আপনার প্রথম অডিয়েন্স যোগ করুন</small>
                    </div>
                @else
                    @foreach (explode('[who_should_join]', $course->who_should_join) as $index => $who_item)
                        @if(trim($who_item) !== '')
                            <div class="items-list-item">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-r from-lime to-orange flex items-center justify-center">
                                                <i class="fas fa-user text-primary text-xs"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium mb-0">{{ $who_item }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 ml-4">
                                        <button class="item-action-btn btn-edit edit-who-item" data-index="{{ $index }}" title="সম্পাদনা করুন">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="item-action-btn btn-delete delete-who-item" data-index="{{ $index }}" title="মুছে ফেলুন">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
                <div id="appendWhoItems"></div>
            </div>

            <!-- Add Who Should Join Form -->
            <div class="mt-6">
                <input type="hidden" id="whoItemIndex" value="">
                <div class="mb-4">
                    <label class="block text-white font-medium mb-3">
                        <i class="fas fa-user-plus text-lime mr-2"></i>
                        নতুন টার্গেট অডিয়েন্স যোগ করুন
                    </label>
                    <textarea class="form-textarea-modern" 
                              placeholder="কারা এই কোর্সে অংশগ্রহণ করতে পারবে তা লিখুন... (যেমন: নতুন ওয়েব ডেভেলপাররা যারা প্রোগ্রামিং শিখতে চান)" 
                              id="who_should_join" 
                              rows="4">{{ old('who_should_join') }}</textarea>
                </div>
                
                <div class="form-buttons">
                    <button class="btn btn-secondary" type="button" id="cancel-who-button">
                        <i class="fas fa-times mr-2"></i>
                        বাতিল
                    </button>
                    <button class="btn btn-primary" type="button" id="save-who-button">
                        <i class="fas fa-save mr-2"></i>
                        সংরক্ষণ করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="action-buttons">
        <a href="{{ route('instructor.courses.create.facts', ['id' => $course->id]) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            পূর্ববর্তী ধাপ
        </a>
        
        <a href="{{ route('instructor.courses.create.pricing', ['id' => $course->id]) }}" class="btn-next">
            পরবর্তী ধাপ
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = window.location.origin;
    const courseId = @json($course->id);

    // Delete objective item
    function setupDeleteHandlers() {
        document.querySelectorAll('.delete-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!confirm('আপনি কি নিশ্চিত যে এই উদ্দেশ্যটি মুছে ফেলতে চান?')) {
                    return;
                }

                const itemElement = item.closest('.items-list-item');
                itemElement.style.opacity = '0.5';
                itemElement.style.pointerEvents = 'none';
                
                const dataIndex = item.getAttribute('data-index');

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
                        itemElement.remove();
                        checkEmptyState('objectives');
                        
                        // Show success animation
                        showNotification('উদ্দেশ্য সফলভাবে মুছে ফেলা হয়েছে', 'success');
                    } else {
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';
                        showNotification('মুছে ফেলতে সমস্যা হয়েছে', 'error');
                    }
                })
                .catch(error => {
                    itemElement.style.opacity = '1';
                    itemElement.style.pointerEvents = 'auto';
                    showNotification('একটি ত্রুটি হয়েছে', 'error');
                });
            });
        });
    }

    // Edit objective item
    function setupEditHandlers() {
        document.querySelectorAll('.edit-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const dataIndex = item.getAttribute('data-index');
                const objectiveText = item.closest('.items-list-item').querySelector('p').textContent.trim();
                
                document.getElementById('itemIndex').value = dataIndex;
                document.getElementById('objective').value = objectiveText;
                document.getElementById('objective').focus();
                
                // Scroll to form
                document.getElementById('objective').scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    }

    // Save objective
    document.getElementById('save-objective-button').addEventListener('click', function(e) {
        e.preventDefault();
        
        const objectiveTextArea = document.getElementById('objective');
        const itemIndex = document.getElementById('itemIndex');
        const saveButton = this;
        
        if (!objectiveTextArea.value.trim()) {
            showNotification('অনুগ্রহ করে একটি উদ্দেশ্য লিখুন', 'error');
            objectiveTextArea.focus();
            return;
        }

        // Show loading state
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>সংরক্ষণ করা হচ্ছে...';
        saveButton.disabled = true;

        const requestBody = JSON.stringify({
            dataIndex: itemIndex.value,
            objective: objectiveTextArea.value.trim(),
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
                const newItem = createObjectiveItem(objectiveTextArea.value, true);
                document.getElementById('appendItems').appendChild(newItem);
                removeEmptyState('objectives');
                showNotification('নতুন উদ্দেশ্য যোগ করা হয়েছে', 'success');
            } else if (data.message === 'UPDATED') {
                updateObjectiveItem(itemIndex.value, objectiveTextArea.value);
                showNotification('উদ্দেশ্য সফলভাবে আপডেট করা হয়েছে', 'success');
            }
            
            // Reset form
            objectiveTextArea.value = '';
            itemIndex.value = '';
            
            // Re-setup handlers for new items
            setupDeleteHandlers();
            setupEditHandlers();
        })
        .catch(error => {
            showNotification(error.error || 'একটি ত্রুটি হয়েছে', 'error');
        })
        .finally(() => {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
    });

    // Cancel objective
    document.getElementById('cancel-objective-button').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('objective').value = '';
        document.getElementById('itemIndex').value = '';
    });

    // WHO SHOULD JOIN SECTION
    
    // Delete who item
    function setupWhoDeleteHandlers() {
        document.querySelectorAll('.delete-who-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (!confirm('আপনি কি নিশ্চিত যে এই টার্গেট অডিয়েন্সটি মুছে ফেলতে চান?')) {
                    return;
                }

                const itemElement = item.closest('.items-list-item');
                itemElement.style.opacity = '0.5';
                itemElement.style.pointerEvents = 'none';
                
                const dataIndex = item.getAttribute('data-index');

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
                        itemElement.remove();
                        checkEmptyState('who');
                        showNotification('টার্গেট অডিয়েন্স সফলভাবে মুছে ফেলা হয়েছে', 'success');
                    } else {
                        itemElement.style.opacity = '1';
                        itemElement.style.pointerEvents = 'auto';
                        showNotification('মুছে ফেলতে সমস্যা হয়েছে', 'error');
                    }
                })
                .catch(error => {
                    itemElement.style.opacity = '1';
                    itemElement.style.pointerEvents = 'auto';
                    showNotification('একটি ত্রুটি হয়েছে', 'error');
                });
            });
        });
    }

    // Edit who item
    function setupWhoEditHandlers() {
        document.querySelectorAll('.edit-who-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const dataIndex = item.getAttribute('data-index');
                const whoText = item.closest('.items-list-item').querySelector('p').textContent.trim();
                
                document.getElementById('whoItemIndex').value = dataIndex;
                document.getElementById('who_should_join').value = whoText;
                document.getElementById('who_should_join').focus();
                
                // Scroll to form
                document.getElementById('who_should_join').scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    }

    // Save who item
    document.getElementById('save-who-button').addEventListener('click', function(e) {
        e.preventDefault();
        
        const whoTextArea = document.getElementById('who_should_join');
        const whoItemIndex = document.getElementById('whoItemIndex');
        const saveButton = this;
        
        if (!whoTextArea.value.trim()) {
            showNotification('অনুগ্রহ করে টার্গেট অডিয়েন্স লিখুন', 'error');
            whoTextArea.focus();
            return;
        }

        // Show loading state
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>সংরক্ষণ করা হচ্ছে...';
        saveButton.disabled = true;

        const requestBody = JSON.stringify({
            dataIndex: whoItemIndex.value,
            who_should_join: whoTextArea.value.trim(),
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
                const newItem = createWhoItem(whoTextArea.value, true);
                document.getElementById('appendWhoItems').appendChild(newItem);
                removeEmptyState('who');
                showNotification('নতুন টার্গেট অডিয়েন্স যোগ করা হয়েছে', 'success');
            } else if (data.message === 'UPDATED') {
                updateWhoItem(whoItemIndex.value, whoTextArea.value);
                showNotification('টার্গেট অডিয়েন্স সফলভাবে আপডেট করা হয়েছে', 'success');
            }
            
            // Reset form
            whoTextArea.value = '';
            whoItemIndex.value = '';
            
            // Re-setup handlers for new items
            setupWhoDeleteHandlers();
            setupWhoEditHandlers();
        })
        .catch(error => {
            showNotification(error.error || 'একটি ত্রুটি হয়েছে', 'error');
        })
        .finally(() => {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
    });

    // Cancel who
    document.getElementById('cancel-who-button').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('who_should_join').value = '';
        document.getElementById('whoItemIndex').value = '';
    });

    // Helper functions
    function createObjectiveItem(text, isNew = false) {
        const div = document.createElement('div');
        div.className = 'items-list-item';
        div.innerHTML = `
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3 flex-1">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-r from-blue to-lime flex items-center justify-center">
                            <i class="fas fa-check text-primary text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-medium mb-0">${text}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 ml-4">
                    ${isNew ? '<span class="new-badge">নতুন</span>' : ''}
                </div>
            </div>
        `;
        return div;
    }

    function createWhoItem(text, isNew = false) {
        const div = document.createElement('div');
        div.className = 'items-list-item';
        div.innerHTML = `
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3 flex-1">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-r from-lime to-orange flex items-center justify-center">
                            <i class="fas fa-user text-primary text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-white font-medium mb-0">${text}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 ml-4">
                    ${isNew ? '<span class="new-badge">নতুন</span>' : ''}
                </div>
            </div>
        `;
        return div;
    }

    function updateObjectiveItem(index, text) {
        document.querySelectorAll('.edit-item').forEach(item => {
            if (item.getAttribute('data-index') == index) {
                item.closest('.items-list-item').querySelector('p').textContent = text;
            }
        });
    }

    function updateWhoItem(index, text) {
        document.querySelectorAll('.edit-who-item').forEach(item => {
            if (item.getAttribute('data-index') == index) {
                item.closest('.items-list-item').querySelector('p').textContent = text;
            }
        });
    }

    function checkEmptyState(type) {
        const container = type === 'objectives' ? 
            document.getElementById('objectiveItemsList') : 
            document.getElementById('whoItemsList');
        
        const appendContainer = type === 'objectives' ? 
            document.getElementById('appendItems') : 
            document.getElementById('appendWhoItems');
        
        const existingItems = container.querySelectorAll('.items-list-item').length;
        const newItems = appendContainer.querySelectorAll('.items-list-item').length;
        
        if (existingItems + newItems === 0) {
            container.classList.add('empty-state');
            
            // Add empty state message if it doesn't exist
            if (!container.querySelector('.empty-state-message')) {
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'empty-state-message';
                emptyMessage.innerHTML = type === 'objectives' ? 
                    `<i class="fas fa-lightbulb"></i>
                     <div>এখনও কোনো শিক্ষণীয় উদ্দেশ্য যোগ করা হয়নি</div>
                     <small>নিচে আপনার প্রথম উদ্দেশ্য যোগ করুন</small>` :
                    `<i class="fas fa-user-plus"></i>
                     <div>এখনও কোনো টার্গেট অডিয়েন্স যোগ করা হয়নি</div>
                     <small>নিচে আপনার প্রথম অডিয়েন্স যোগ করুন</small>`;
                container.appendChild(emptyMessage);
            }
        }
    }

    function removeEmptyState(type) {
        const container = type === 'objectives' ? 
            document.getElementById('objectiveItemsList') : 
            document.getElementById('whoItemsList');
        
        container.classList.remove('empty-state');
        const emptyMessage = container.querySelector('.empty-state-message');
        if (emptyMessage) {
            emptyMessage.remove();
        }
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            notification.classList.add('bg-green-600', 'text-white');
            notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        } else if (type === 'error') {
            notification.classList.add('bg-red-600', 'text-white');
            notification.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
        }
        
        document.body.appendChild(notification);
        
        // Slide in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Initialize handlers
    setupDeleteHandlers();
    setupEditHandlers();
    setupWhoDeleteHandlers();
    setupWhoEditHandlers();
});
</script>
@endsection