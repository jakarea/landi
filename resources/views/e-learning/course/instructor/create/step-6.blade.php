@extends('layouts.instructor-tailwind')
@section('title', 'কোর্স তৈরি করুন - ধাপ ৫')
@section('header-title', 'কোর্স কন্টেন্ট ম্যানেজমেন্ট')
@section('header-subtitle', 'আপনার কোর্সের মডিউল এবং লেসন সংগঠিত করুন')

@section('style')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
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

/* Module container styling */
.module-container {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.2);
    border-radius: 1rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: move;
}

.module-container:hover {
    border-color: rgba(90, 234, 244, 0.4);
    box-shadow: 0 4px 20px rgba(90, 234, 244, 0.1);
    transform: translateY(-2px);
}

.module-container.ui-sortable-helper {
    transform: rotate(3deg) scale(1.05);
    box-shadow: 0 8px 30px rgba(90, 234, 244, 0.3);
}

.module-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.module-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.module-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.module-icon i {
    font-size: 1.5rem;
    color: #091D3D;
}

.module-details h3 {
    color: #FFFFFF;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.module-details p {
    color: #C7C7C7;
    font-size: 0.875rem;
    margin: 0;
}

.module-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.module-toggle {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #FFFFFF;
    padding: 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.module-toggle:hover {
    background: rgba(90, 234, 244, 0.2);
    color: #5AEAF4;
    transform: scale(1.1);
}

.module-toggle.active {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    color: #091D3D;
    transform: rotate(180deg);
}

/* Dropdown menu styling */
.dropdown-modern {
    position: relative;
}

.dropdown-trigger {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #FFFFFF;
    padding: 0.75rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dropdown-trigger:hover {
    background: rgba(90, 234, 244, 0.2);
    color: #5AEAF4;
}

.dropdown-menu-modern {
    position: absolute;
    top: 100%;
    right: 0;
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(90, 234, 244, 0.3);
    border-radius: 0.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    min-width: 200px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.dropdown-menu-modern.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item-modern {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #C7C7C7;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    transition: all 0.3s ease;
    cursor: pointer;
}

.dropdown-item-modern:hover {
    background: rgba(90, 234, 244, 0.1);
    color: #5AEAF4;
}

.dropdown-item-modern.danger:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

/* Lesson container styling */
.lessons-container {
    padding: 0;
    background: rgba(9, 29, 61, 0.3);
    max-height: 0;
    overflow: hidden;
    transition: all 0.5s ease;
}

.lessons-container.expanded {
    padding: 1.5rem;
    max-height: none;
}

.lesson-item {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    cursor: move;
}

.lesson-item:hover {
    border-color: rgba(90, 234, 244, 0.3);
    box-shadow: 0 2px 12px rgba(90, 234, 244, 0.1);
    transform: translateX(5px);
}

.lesson-item.ui-sortable-helper {
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 4px 20px rgba(90, 234, 244, 0.2);
}

.lesson-item:last-child {
    margin-bottom: 0;
}

.lesson-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.lesson-type-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.lesson-type-video {
    background: linear-gradient(135deg, #EF4444, #F87171);
}

.lesson-type-audio {
    background: linear-gradient(135deg, #F59E0B, #FBBF24);
}

.lesson-type-text {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
}

.lesson-type-icon i {
    color: #FFFFFF;
    font-size: 1.125rem;
}

.lesson-details h4 {
    color: #FFFFFF;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.lesson-details p {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.lesson-status {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-complete {
    background: rgba(16, 185, 129, 0.2);
    color: #10B981;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-pending {
    background: rgba(239, 68, 68, 0.2);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.status-public {
    background: rgba(90, 234, 244, 0.2);
    color: #5AEAF4;
    border: 1px solid rgba(90, 234, 244, 0.3);
}

/* Add buttons */
.add-button {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    border: 2px dashed rgba(90, 234, 244, 0.3);
    border-radius: 0.75rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    color: #5AEAF4;
    font-weight: 500;
}

.add-button:hover {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.2), rgba(203, 251, 144, 0.1));
    border-color: #5AEAF4;
    transform: scale(1.02);
}

.add-button i {
    margin-right: 0.5rem;
    font-size: 1.125rem;
}

/* Modal styling */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-content-modern {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 2px solid rgba(90, 234, 244, 0.3);
    border-radius: 1rem;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.modal-overlay.show .modal-content-modern {
    transform: scale(1);
}

.modal-header {
    padding: 2rem 2rem 0;
    text-align: center;
}

.modal-header h3 {
    color: #FFFFFF;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.modal-body {
    padding: 2rem;
}

.form-group-modern {
    margin-bottom: 1.5rem;
}

.form-label-modern {
    display: block;
    color: #FFFFFF;
    font-weight: 500;
    margin-bottom: 0.5rem;
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

.form-input-modern::placeholder {
    color: #9CA3AF;
}

/* Lesson type selector */
.lesson-types {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.lesson-type-option {
    flex: 1;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #C7C7C7;
}

.lesson-type-option:hover {
    border-color: rgba(90, 234, 244, 0.3);
    background: rgba(90, 234, 244, 0.1);
}

.lesson-type-option.active {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.2), rgba(203, 251, 144, 0.1));
    color: #5AEAF4;
}

.lesson-type-option i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Switch styling */
.switch-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.75rem;
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.2);
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Action buttons */
.modal-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-cancel {
    flex: 1;
    padding: 0.75rem 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #C7C7C7;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
}

.btn-submit {
    flex: 1;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border: none;
    color: #091D3D;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(90, 234, 244, 0.3);
}

/* Navigation buttons */
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

.btn-next.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #9CA3AF;
}

.empty-state i {
    font-size: 3rem;
    color: #5AEAF4;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #FFFFFF;
}

.empty-state p {
    margin-bottom: 2rem;
}

/* Drag placeholder */
.ui-sortable-placeholder {
    background: rgba(90, 234, 244, 0.1) !important;
    border: 2px dashed #5AEAF4 !important;
    border-radius: 1rem !important;
    visibility: visible !important;
    height: 60px !important;
    margin-bottom: 1rem !important;
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
    
    .module-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .module-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .lesson-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .lesson-types {
        flex-direction: column;
    }
    
    .modal-actions {
        flex-direction: column;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
}

/* Animation for new items */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.item-new {
    animation: slideInUp 0.5s ease;
}

/* Drag handle */
.drag-handle {
    cursor: move;
    padding: 0.5rem;
    color: rgba(255, 255, 255, 0.5);
    transition: color 0.3s ease;
}

.drag-handle:hover {
    color: #5AEAF4;
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
                    <a href="{{ route('instructor.courses.create.facts', ['id' => request()->route('id')]) }}">তথ্যাবলী</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.objectives', ['id' => request()->route('id')]) }}">উদ্দেশ্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.pricing', ['id' => request()->route('id')]) }}">মূল্য</a>
                </div>
            </div>
            <div class="step-item completed">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.design', ['id' => request()->route('id')]) }}">ডিজাইন</a>
                </div>
            </div>
            <div class="step-item current">
                <div class="step-circle">5</div>
                <div class="step-title">
                    <a href="{{ route('instructor.courses.create.content', ['id' => request()->route('id')]) }}">কন্টেন্ট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">6</div>
                <div class="step-title">
                    <a href="#">সার্টিফিকেট</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">7</div>
                <div class="step-title">
                    <a href="#">দৃশ্যমানতা</a>
                </div>
            </div>
            <div class="step-item">
                <div class="step-circle">8</div>
                <div class="step-title">
                    <a href="#">প্রকাশ</a>
                </div>
            </div>
        </div>

        @if ( session()->has('course_id') )
            <div class="text-center mt-6 pt-6 border-t border-[#fff]/20">
                <a href="{{ url('instructor/courses') }}" 
                   class="inline-flex items-center gap-2 bg-lime text-primary rounded-lg px-6 py-3 font-semibold anim hover:bg-orange hover:text-primary">
                    <i class="fas fa-save"></i>
                    সংরক্ষণ করুন এবং সমাপ্ত করুন
                </a>
            </div>
        @endif
    </div>

    <!-- Content Management -->
    <div class="bg-card rounded-xl shadow-2">
        <div class="p-8">
            <!-- Error Messages -->
            <div class="mb-4">
                @error('module_name')
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-2 rounded-lg">
                        {{ $message }}
                    </div>
                @enderror
                @error('lesson_name')
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-2 rounded-lg">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if(count($modules) > 0)
                <!-- Modules List -->
                <div id="moduleResorting" class="space-y-6">
                    @foreach ($modules as $module)
                    <div class="module-container" data-module-id="{{ $module->id }}">
                        <!-- Module Header -->
                        <div class="module-header">
                            <div class="module-info">
                                <div class="drag-handle">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="module-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="module-details">
                                    <h3>{{ $module->title}} {{ $module->checkNumber() ? $loop->iteration : ""}}</h3>
                                    <p>{{ count($module->lessons) }} টি লেসন সহ মডিউল</p>
                                </div>
                            </div>
                            <div class="module-actions">
                                <div class="dropdown-modern">
                                    <button class="dropdown-trigger" onclick="toggleDropdown(this)">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-modern">
                                        <button class="dropdown-item-modern" onclick="editModule('{{ $module->id }}', '{{ $module->title }}', '{{ $module->publish_at ? $module->publish_at->format('Y-m-d\TH:i') : '' }}')">
                                            <i class="fas fa-edit"></i>
                                            মডিউল সম্পাদনা
                                        </button>
                                        <form action="{{ route('instructor.modules.delete', ['id' => $module->id]) }}" method="post" class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item-modern danger" onclick="return confirm('আপনি কি নিশ্চিত যে এই মডিউলটি মুছে ফেলতে চান?')">
                                                <i class="fas fa-trash"></i>
                                                মডিউল মুছুন
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <button class="module-toggle" onclick="toggleModule(this)" data-module-id="{{ $module->id }}">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Lessons Container -->
                        <div class="lessons-container lessonResorting {{ request()->input('tab') == $module->id ? 'expanded' : ''}} {{ request()->tab == 'active' ? 'expanded' : ''}}" data-module-id="{{ $module->id }}">
                            @if(count($module->lessons) > 0)
                                @foreach ($module->lessons()->orderBy('reorder', 'ASC')->get() as $lesson)
                                <div class="lesson-item" data-module-lession-id="{{ $lesson->id }}">
                                    <div class="lesson-info">
                                        <div class="drag-handle">
                                            <i class="fas fa-grip-lines"></i>
                                        </div>
                                        <div class="lesson-type-icon lesson-type-{{ $lesson->type }}">
                                            @if ($lesson->type == 'text')
                                                <i class="fas fa-file-alt"></i>
                                            @elseif ($lesson->type == 'video')
                                                <i class="fas fa-play"></i>
                                            @elseif ($lesson->type == 'audio')
                                                <i class="fas fa-volume-up"></i>
                                            @endif
                                        </div>
                                        <div class="lesson-details">
                                            <h4>{{ $lesson->title }}</h4>
                                            <p>
                                                <span class="capitalize">{{ $lesson->type }}</span>
                                                @if($lesson->status == 'pending')
                                                    <span class="lesson-status status-pending">কন্টেন্ট নেই</span>
                                                @else
                                                    <span class="lesson-status status-complete">সম্পূর্ণ</span>
                                                @endif
                                                @if($lesson->is_public)
                                                    <span class="lesson-status status-public">পাবলিক</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dropdown-modern">
                                        <button class="dropdown-trigger" onclick="toggleDropdown(this)">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu-modern">
                                            @if ($lesson->type == 'audio')
                                                <a class="dropdown-item-modern" href="{{ url('instructor/courses/create/'.$lesson->course_id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    কন্টেন্ট যোগ করুন
                                                </a>
                                            @elseif($lesson->type == 'video')
                                                <a class="dropdown-item-modern" href="{{ url('instructor/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    কন্টেন্ট যোগ করুন
                                                </a>
                                            @elseif($lesson->type == 'text')
                                                <a class="dropdown-item-modern" href="{{ url('instructor/courses/create/'.$lesson->course_id.'/text/'.$lesson->module_id.'/content/'.$lesson->id) }}">
                                                    <i class="fas fa-plus"></i>
                                                    কন্টেন্ট যোগ করুন
                                                </a>
                                            @endif
                                            <button class="dropdown-item-modern" onclick="editLesson('{{ $lesson->id }}', '{{ $module->course_id }}', '{{ $module->id }}', '{{ $lesson->title }}', '{{ $lesson->type }}', {{ $lesson->is_public ? 'true' : 'false' }})">
                                                <i class="fas fa-edit"></i>
                                                লেসন সম্পাদনা
                                            </button>
                                            <form action="{{ route('instructor.lessons.delete', ['id' => $lesson->id]) }}" method="post" class="inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="dropdown-item-modern danger" onclick="return confirm('আপনি কি নিশ্চিত যে এই লেসনটি মুছে ফেলতে চান?')">
                                                    <i class="fas fa-trash"></i>
                                                    লেসন মুছুন
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-video"></i>
                                    <h3>কোনো লেসন নেই</h3>
                                    <p>এই মডিউলে এখনও কোনো লেসন যোগ করা হয়নি</p>
                                </div>
                            @endif

                            <!-- Add Lesson Button -->
                            <div class="add-button" onclick="showAddLessonModal('{{ $module->id }}', '{{ $module->course_id }}')">
                                <i class="fas fa-plus"></i>
                                লেসন যোগ করুন
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state py-12">
                    <i class="fas fa-book-open"></i>
                    <h3>কোনো মডিউল নেই</h3>
                    <p>আপনার কোর্সে এখনও কোনো মডিউল যোগ করা হয়নি। শুরু করতে একটি মডিউল যোগ করুন।</p>
                </div>
            @endif

            <!-- Add Module Button -->
            <div class="add-button mt-6" onclick="showAddModuleModal()">
                <i class="fas fa-plus"></i>
                মডিউল যোগ করুন
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="action-buttons">
        <a href="{{ route('instructor.courses.create.design', ['id' => request()->route('id')]) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            পূর্ববর্তী ধাপ
        </a>
        
        @if (count($modules) > 0)
            <a href="{{ url('instructor/courses/create/'.request()->route('id').'/certificate') }}" class="btn-next">
                পরবর্তী ধাপ
                <i class="fas fa-arrow-right"></i>
            </a>
        @else
            <a href="#" class="btn-next disabled" onclick="showAddModuleModal(); return false;">
                প্রথমে মডিউল যোগ করুন
                <i class="fas fa-plus"></i>
            </a>
        @endif
    </div>
</div>

<!-- Add Module Modal -->
<div class="modal-overlay" id="moduleModal">
    <div class="modal-content-modern">
        <div class="modal-header">
            <h3>নতুন মডিউল যোগ করুন</h3>
        </div>
        <div class="modal-body">
            <form action="{{ route('instructor.modules.create', ['course_id' => request()->route('id')]) }}" method="post">
                @csrf
                <input type="hidden" name="module_id" id="editModuleId" value="">
                
                <div class="form-group-modern">
                    <label class="form-label-modern">মডিউলের নাম *</label>
                    <input type="text" name="module_name" id="moduleNameInput" class="form-input-modern" placeholder="মডিউলের নাম লিখুন" required>
                </div>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">প্রকাশের সময়</label>
                    <input type="datetime-local" name="publish_at" id="modulePublishAt" class="form-input-modern">
                    <p class="text-secondary-200 text-sm mt-2">খালি রাখলে তৎক্ষণাৎ প্রকাশিত হবে</p>
                    <div id="publishAtError" class="text-red-500 text-sm mt-1" style="display: none;">
                        ভবিষ্যতের সময় নির্বাচন করুন
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('moduleModal')">বাতিল</button>
                    <button type="submit" class="btn-submit">সংরক্ষণ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add/Edit Lesson Modal -->
<div class="modal-overlay" id="lessonModal">
    <div class="modal-content-modern">
        <div class="modal-header">
            <h3 id="lessonModalTitle">নতুন লেসন যোগ করুন</h3>
        </div>
        <div class="modal-body">
            <form id="lessonForm" method="post">
                @csrf
                <input type="hidden" name="_method" id="lessonFormMethod" value="POST">
                <input type="hidden" name="course_id" id="lessonCourseId" value="">
                <input type="hidden" name="module_id" id="lessonModuleId" value="">
                <input type="hidden" name="lesson_id" id="editLessonId" value="">
                
                <div class="form-group-modern">
                    <label class="form-label-modern">লেসনের নাম *</label>
                    <input type="text" name="lesson_name" id="lessonNameInput" class="form-input-modern" placeholder="লেসনের নাম লিখুন" required>
                </div>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">লেসনের ধরন *</label>
                    <div class="lesson-types">
                        <div class="lesson-type-option" onclick="selectLessonType('text', this)">
                            <i class="fas fa-file-alt"></i>
                            <span>টেক্সট</span>
                        </div>
                        <div class="lesson-type-option" onclick="selectLessonType('audio', this)">
                            <i class="fas fa-volume-up"></i>
                            <span>অডিও</span>
                        </div>
                        <div class="lesson-type-option active" onclick="selectLessonType('video', this)">
                            <i class="fas fa-play"></i>
                            <span>ভিডিও</span>
                        </div>
                    </div>
                    <input type="hidden" name="lesson_type" id="selectedLessonType" value="video">
                </div>
                
                <div class="form-group-modern">
                    <label class="form-label-modern">পাবলিক লেসন</label>
                    <div class="switch-container">
                        <label class="switch">
                            <input type="checkbox" name="is_public" id="isPublicSwitch" value="1">
                            <span class="slider"></span>
                        </label>
                        <span class="text-secondary-200">ভিজিটররা লগইন ছাড়াই দেখতে পারবে</span>
                    </div>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('lessonModal')">বাতিল</button>
                    <button type="submit" class="btn-submit">সংরক্ষণ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
// Dropdown functionality
function toggleDropdown(trigger) {
    const dropdown = trigger.parentElement.querySelector('.dropdown-menu-modern');
    
    // Close all other dropdowns
    document.querySelectorAll('.dropdown-menu-modern').forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.remove('show');
        }
    });
    
    dropdown.classList.toggle('show');
    
    // Close dropdown when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeDropdown(e) {
            if (!trigger.parentElement.contains(e.target)) {
                dropdown.classList.remove('show');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }, 0);
}

// Module toggle functionality
function toggleModule(button) {
    const moduleId = button.getAttribute('data-module-id');
    const lessonsContainer = button.closest('.module-container').querySelector('.lessons-container');
    const icon = button.querySelector('i');
    
    if (lessonsContainer.classList.contains('expanded')) {
        lessonsContainer.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        button.classList.remove('active');
    } else {
        lessonsContainer.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        button.classList.add('active');
    }
}

// Modal functionality
function showAddModuleModal() {
    document.getElementById('moduleModalTitle') ? document.getElementById('moduleModalTitle').textContent = 'নতুন মডিউল যোগ করুন' : null;
    document.getElementById('editModuleId').value = '';
    document.getElementById('moduleNameInput').value = '';
    document.getElementById('modulePublishAt').value = '';
    showModal('moduleModal');
}

function editModule(moduleId, title, publishAt) {
    document.getElementById('editModuleId').value = moduleId;
    document.getElementById('moduleNameInput').value = title;
    document.getElementById('modulePublishAt').value = publishAt;
    showModal('moduleModal');
}

function showAddLessonModal(moduleId, courseId) {
    document.getElementById('lessonModalTitle').textContent = 'নতুন লেসন যোগ করুন';
    document.getElementById('editLessonId').value = '';
    document.getElementById('lessonCourseId').value = courseId;
    document.getElementById('lessonModuleId').value = moduleId;
    document.getElementById('lessonNameInput').value = '';
    document.getElementById('selectedLessonType').value = 'video';
    document.getElementById('isPublicSwitch').checked = false;
    
    // Reset lesson type selection
    document.querySelectorAll('.lesson-type-option').forEach(option => {
        option.classList.remove('active');
    });
    document.querySelector('.lesson-type-option:nth-child(3)').classList.add('active'); // Video option
    
    // Set form action and method
    document.getElementById('lessonForm').action = `/instructor/lessons/create/${courseId}/${moduleId}`;
    document.getElementById('lessonFormMethod').value = 'POST';
    
    showModal('lessonModal');
}

function editLesson(lessonId, courseId, moduleId, title, type, isPublic) {
    document.getElementById('lessonModalTitle').textContent = 'লেসন সম্পাদনা করুন';
    document.getElementById('editLessonId').value = lessonId;
    document.getElementById('lessonCourseId').value = courseId;
    document.getElementById('lessonModuleId').value = moduleId;
    document.getElementById('lessonNameInput').value = title;
    document.getElementById('selectedLessonType').value = type;
    document.getElementById('isPublicSwitch').checked = isPublic;
    
    // Set lesson type selection
    document.querySelectorAll('.lesson-type-option').forEach(option => {
        option.classList.remove('active');
    });
    selectLessonType(type, document.querySelector(`[onclick*="${type}"]`));
    
    // Set form action and method
    document.getElementById('lessonForm').action = `/instructor/lessons/update/${lessonId}`;
    document.getElementById('lessonFormMethod').value = 'PUT';
    
    showModal('lessonModal');
}

function selectLessonType(type, element) {
    document.querySelectorAll('.lesson-type-option').forEach(option => {
        option.classList.remove('active');
    });
    element.classList.add('active');
    document.getElementById('selectedLessonType').value = type;
}

function showModal(modalId) {
    document.getElementById(modalId).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            closeModal(overlay.id);
        }
    });
});

// Module resorting
$(function() {
    $("#moduleResorting").sortable({
        handle: '.drag-handle',
        placeholder: 'ui-sortable-placeholder',
        tolerance: 'pointer',
        update: function(event, ui) {
            var moduleOrder = $(this).sortable("toArray", { attribute: "data-module-id" });
            moduleOrder = moduleOrder.filter(function(item) {
                return item !== '';
            });
            updateModuleOrder(moduleOrder);
        }
    });
});

// Lesson resorting
$(function() {
    $(".lessonResorting").sortable({
        handle: '.lesson-item .drag-handle',
        placeholder: 'ui-sortable-placeholder',
        tolerance: 'pointer',
        update: function(event, ui) {
            var moduleLessonOrder = $(this).sortable("toArray", { attribute: "data-module-lession-id" });
            moduleLessonOrder = moduleLessonOrder.filter(function(item) {
                return item !== '';
            });
            updateModuleLessonOrder(moduleLessonOrder);
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
            // Show success notification
            showNotification('মডিউলের ক্রম সফলভাবে আপডেট হয়েছে', 'success');
        },
        error: function(xhr, status, error) {
            console.error("Error updating module order:", error);
            showNotification('ক্রম আপডেট করতে সমস্যা হয়েছে', 'error');
        }
    });
}

function updateModuleLessonOrder(moduleLessonOrder) {
    $.ajax({
        url: "/instructor/module/lesson/sortable",
        type: "POST",
        data: {
            lessonOrder: moduleLessonOrder,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            console.log("Module lesson reorder updated successfully");
            showNotification('লেসনের ক্রম সফলভাবে আপডেট হয়েছে', 'success');
        },
        error: function(xhr, status, error) {
            console.error("Error updating module lesson order:", error);
            showNotification('লেসনের ক্রম আপডেট করতে সমস্যা হয়েছে', 'error');
        }
    });
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
    } else if (type === 'error') {
        notification.classList.add('bg-red-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
    } else {
        notification.classList.add('bg-blue-600', 'text-white');
        notification.innerHTML = `<i class="fas fa-info-circle mr-2"></i>${message}`;
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
    }, 4000);
}

// Initialize expanded modules on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.lessons-container.expanded').forEach(container => {
        const moduleId = container.getAttribute('data-module-id');
        const toggleButton = document.querySelector(`[data-module-id="${moduleId}"]`);
        if (toggleButton) {
            toggleButton.classList.add('active');
            const icon = toggleButton.querySelector('i');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    });
    
    // Add form validation for publish_at field
    const moduleForm = document.querySelector('form[action*="modules/create"]');
    if (moduleForm) {
        moduleForm.addEventListener('submit', function(e) {
            const publishAtField = document.getElementById('modulePublishAt');
            const publishAtError = document.getElementById('publishAtError');
            
            if (publishAtField && publishAtField.value.trim() !== '') {
                const selectedDateTime = new Date(publishAtField.value);
                const currentDateTime = new Date();
                
                if (selectedDateTime <= currentDateTime) {
                    e.preventDefault();
                    publishAtError.style.display = 'block';
                    publishAtField.focus();
                    showNotification('প্রকাশের জন্য ভবিষ্যতের সময় নির্বাচন করুন', 'error');
                    return false;
                } else {
                    publishAtError.style.display = 'none';
                }
            } else {
                publishAtError.style.display = 'none';
            }
        });
    }
    
    // Real-time validation when user changes the datetime
    const publishAtField = document.getElementById('modulePublishAt');
    if (publishAtField) {
        publishAtField.addEventListener('change', function() {
            const publishAtError = document.getElementById('publishAtError');
            
            if (this.value.trim() !== '') {
                const selectedDateTime = new Date(this.value);
                const currentDateTime = new Date();
                
                if (selectedDateTime <= currentDateTime) {
                    publishAtError.style.display = 'block';
                    this.style.borderColor = '#ef4444';
                } else {
                    publishAtError.style.display = 'none';
                    this.style.borderColor = '';
                }
            } else {
                publishAtError.style.display = 'none';
                this.style.borderColor = '';
            }
        });
    }
});
</script>
@endsection