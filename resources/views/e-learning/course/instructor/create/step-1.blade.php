@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - ধাপ ১')
@section('header-title', 'নতুন কোর্স তৈরি')
@section('header-subtitle', 'আপনার জ্ঞান শেয়ার করুন এবং শিক্ষার্থীদের সাহায্য করুন')

@section('style')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
/* Quill editor custom styling for dark theme */
.ql-toolbar {
    border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-left: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
    background-color: #0F2342 !important;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.ql-container {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-left: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.2) !important;
    background-color: #091D3D !important;
    color: #FFFFFF !important;
    border-radius: 0 0 0.5rem 0.5rem !important;
}

.ql-editor {
    color: #FFFFFF !important;
    min-height: 120px;
}

.ql-editor.ql-blank::before {
    color: #9CA3AF !important;
}

.ql-toolbar .ql-stroke {
    stroke: #FFFFFF !important;
}

.ql-toolbar .ql-fill {
    fill: #FFFFFF !important;
}

.ql-toolbar button:hover .ql-stroke {
    stroke: #5AEAF4 !important;
}

.ql-toolbar button:hover .ql-fill {
    fill: #5AEAF4 !important;
}

.ql-toolbar button.ql-active .ql-stroke {
    stroke: #5AEAF4 !important;
}

.ql-toolbar button.ql-active .ql-fill {
    fill: #5AEAF4 !important;
}

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

/* Form styling */
.form-group-modern {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-input-modern {
    width: 100%;
    padding: 1rem;
    background-color: #091D3D;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.5rem;
    color: #FFFFFF;
    font-size: 1rem;
    transition: all 0.3s ease;
    outline: none;
}

.form-input-modern:focus {
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-label-modern {
    position: absolute;
    left: 1rem;
    top: 1rem;
    color: #9CA3AF;
    font-size: 1rem;
    pointer-events: none;
    transition: all 0.3s ease;
    background-color: #091D3D;
    padding: 0 0.25rem;
}

.form-input-modern:focus + .form-label-modern,
.form-input-modern:not(:placeholder-shown) + .form-label-modern {
    top: -0.5rem;
    left: 0.75rem;
    font-size: 0.875rem;
    color: #5AEAF4;
}

.form-section-title {
    color: #FFFFFF;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2rem;
    text-align: center;
}

/* Tags input styling */
.bootstrap-tagsinput {
    background-color: #091D3D !important;
    border: 2px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 0.5rem !important;
    box-shadow: none !important;
    padding: 0.75rem !important;
    width: 100% !important;
    min-height: 50px !important;
    color: #FFFFFF !important;
}

.bootstrap-tagsinput:focus-within {
    border-color: #5AEAF4 !important;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1) !important;
}

.bootstrap-tagsinput .tag {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90) !important;
    border: none !important;
    color: #091D3D !important;
    font-weight: 500 !important;
    padding: 0.25rem 0.75rem !important;
    margin-right: 0.5rem !important;
    margin-bottom: 0.25rem !important;
    border-radius: 1rem !important;
}

.bootstrap-tagsinput .tag [data-role="remove"] {
    color: #091D3D !important;
    margin-left: 0.5rem !important;
}

.bootstrap-tagsinput input {
    color: #FFFFFF !important;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
    margin: 0 !important;
    padding: 0.25rem !important;
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
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-next:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
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
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Progress Steps -->
    <div class="bg-card rounded-xl p-6 shadow-2">
        <div class="step-progress">
            <div class="step-item current">
                <div class="step-circle">1</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.facts', ['id' => $course->id]) : route('instructor.courses.create') }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.objectives', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.pricing', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">4</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.design', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.content', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.certificate', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.visibility', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="{{ $course->id ? route('instructor.courses.create.publish', ['id' => $course->id]) : '#' }}" class="{{ !$course->id ? 'disabled' : '' }}">প্রকাশ</a>
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

    <!-- Main Form -->
    <div class="bg-card rounded-xl shadow-2">
        <div class="p-8">
            @if($course->id)
            <form action="{{ route('instructor.courses.create.facts.store', ['id' => $course->id]) }}" method="POST" id="courseForm">
            @else
            <form action="{{ route('instructor.courses.create.start') }}" method="POST" id="courseForm">
            @endif
                @csrf

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

                <!-- Form Title -->
                <h2 class="form-section-title">
                    <i class="fas fa-info-circle text-blue mr-3"></i>
                    কোর্সের মূল তথ্য
                </h2>

                <!-- Course Title -->
                <div class="form-group-modern">
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-input-modern" 
                           placeholder=" "
                           value="{{ old('title', $course->title ?? '') }}"
                           required>
                    <label for="title" class="form-label-modern">কোর্সের শিরোনাম *</label>
                    @error('title')
                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Course Slug -->
                <div class="form-group-modern">
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           class="form-input-modern" 
                           placeholder=" "
                           value="{{ old('slug', $course->slug ?? '') }}"
                           readonly>
                    <label for="slug" class="form-label-modern">কোর্স URL (স্বয়ংক্রিয় তৈরি)</label>
                    <div class="text-secondary-200 text-sm mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        আপনার কোর্সের URL: 
                        <span class="text-blue font-mono text-xs">
                            {{ config('app.url') }}/courses/<span id="liveSlugPreview">{{ $course->slug ?? 'your-course-url' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="form-group-modern">
                    <label class="block text-white font-medium mb-3">
                        <i class="fas fa-align-left text-blue mr-2"></i>
                        সংক্ষিপ্ত বিবরণ *
                    </label>
                    <div id="short_description" class="bg-body border border-[#fff]/20 rounded-lg"></div>
                    <input type="hidden" name="short_description" id="short_description_hidden" value="{{ old('short_description', $course->short_description ?? '') }}">
                    <div class="text-secondary-200 text-sm mt-1">
                        <i class="fas fa-lightbulb mr-1"></i>
                        কোর্সের একটি আকর্ষণীয় সংক্ষিপ্ত বিবরণ লিখুন (১৫০-২০০ শব্দ)
                    </div>
                    @error('short_description')
                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Full Description -->
                <div class="form-group-modern">
                    <label class="block text-white font-medium mb-3">
                        <i class="fas fa-align-justify text-blue mr-2"></i>
                        বিস্তারিত বিবরণ *
                    </label>
                    <div id="description" class="bg-body border border-[#fff]/20 rounded-lg"></div>
                    <input type="hidden" name="description" id="description_hidden" value="{{ old('description', $course->description ?? '') }}">
                    <div class="text-secondary-200 text-sm mt-1">
                        <i class="fas fa-info-circle mr-1"></i>
                        কোর্সের বিস্তারিত বিবরণ, শিখার উপকারিতা এবং প্রত্যাশা লিখুন
                    </div>
                    @error('description')
                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categories -->
                <div class="form-group-modern">
                    <label class="block text-white font-medium mb-3">
                        <i class="fas fa-tags text-blue mr-2"></i>
                        বিভাগ/ট্যাগসমূহ *
                    </label>
                    <input id="categories" 
                           data-role="tagsinput" 
                           name="categories" 
                           class="form-control"
                           placeholder="যেমন: প্রোগ্রামিং, ওয়েব ডেভেলপমেন্ট, জাভাস্ক্রিপ্ট" 
                           type="text"
                           value="{{ old('categories', $course->categories ?? '') }}">
                    <div class="text-secondary-200 text-sm mt-1">
                        <i class="fas fa-keyboard mr-1"></i>
                        Enter চেপে ট্যাগ যোগ করুন। প্রাসঙ্গিক কীওয়ার্ড ব্যবহার করুন যা শিক্ষার্থীরা খুঁজতে পারে
                    </div>
                    @error('categories')
                        <div class="text-red-400 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('instructor.courses') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        পূর্ববর্তী
                    </a>
                    
                    <button type="submit" class="btn-next" id="submitBtn">
                        পরবর্তী ধাপ
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/tags.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editors
    const shortDescriptionEditor = new Quill('#short_description', {
        theme: 'snow',
        placeholder: 'কোর্সের একটি আকর্ষণীয় সংক্ষিপ্ত বিবরণ লিখুন...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                ['link'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });
    
    const descriptionEditor = new Quill('#description', {
        theme: 'snow',
        placeholder: 'কোর্সের বিস্তারিত বিবরণ লিখুন...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                ['link'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['clean']
            ]
        }
    });

    // Set initial content
    const initialShortDescription = document.getElementById('short_description_hidden').value;
    const initialDescription = document.getElementById('description_hidden').value;

    if (initialShortDescription && initialShortDescription.trim() !== '') {
        shortDescriptionEditor.root.innerHTML = initialShortDescription;
    }
    
    if (initialDescription && initialDescription.trim() !== '') {
        descriptionEditor.root.innerHTML = initialDescription;
    }

    // Update hidden fields on content change
    shortDescriptionEditor.on('text-change', function() {
        const content = shortDescriptionEditor.root.innerHTML;
        const hiddenInput = document.getElementById('short_description_hidden');
        
        if (content === '<p><br></p>' || content === '<p></p>' || content.trim() === '') {
            hiddenInput.value = '';
        } else {
            hiddenInput.value = content;
        }
    });

    descriptionEditor.on('text-change', function() {
        const content = descriptionEditor.root.innerHTML;
        const hiddenInput = document.getElementById('description_hidden');

        if (content === '<p><br></p>' || content === '<p></p>' || content.trim() === '') {
            hiddenInput.value = '';
        } else {
            hiddenInput.value = content;
        }
    });

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const liveSlugPreview = document.getElementById('liveSlugPreview');

    titleInput.addEventListener('keyup', function() {
        const titleValue = titleInput.value;
        const slugValue = slugify(titleValue);
        slugInput.value = slugValue;
        
        // Update live preview
        if (liveSlugPreview) {
            liveSlugPreview.textContent = slugValue || 'your-course-url';
        }
    });

    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word characters
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    // Form submission handling
    const form = document.getElementById('courseForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(event) {
        // Update hidden fields before submission
        const shortDescriptionContent = shortDescriptionEditor.root.innerHTML;
        if (shortDescriptionContent === '<p><br></p>' || shortDescriptionContent === '<p></p>' || shortDescriptionContent.trim() === '') {
            document.getElementById('short_description_hidden').value = '';
        } else {
            document.getElementById('short_description_hidden').value = shortDescriptionContent;
        }

        const descriptionContent = descriptionEditor.root.innerHTML;
        if (descriptionContent === '<p><br></p>' || descriptionContent === '<p></p>' || descriptionContent.trim() === '') {
            document.getElementById('description_hidden').value = '';
        } else {
            document.getElementById('description_hidden').value = descriptionContent;
        }

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>প্রক্রিয়াকরণ...';
        submitBtn.disabled = true;
    });

    // Form validation
    const requiredFields = [titleInput];
    
    function validateForm() {
        let isValid = true;
        const shortDescContent = shortDescriptionEditor.root.textContent.trim();
        const descContent = descriptionEditor.root.textContent.trim();
        
        // Check required text inputs
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
            }
        });
        
        // Check editors
        if (!shortDescContent) isValid = false;
        if (!descContent) isValid = false;
        
        submitBtn.disabled = !isValid;
        
        if (isValid) {
            submitBtn.classList.remove('opacity-50');
        } else {
            submitBtn.classList.add('opacity-50');
        }
    }

    // Add validation listeners
    titleInput.addEventListener('input', validateForm);
    shortDescriptionEditor.on('text-change', validateForm);
    descriptionEditor.on('text-change', validateForm);
    
    // Initial validation
    setTimeout(validateForm, 100);

    // Tags input enhancement
    $(document).ready(function() {
        $('#categories').tagsinput({
            confirmKeys: [13, 188], // Enter and comma
            maxTags: 10,
            maxChars: 25
        });
    });
});
</script>
@endsection