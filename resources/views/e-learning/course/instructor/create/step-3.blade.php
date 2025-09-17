@extends('layouts.instructor-tailwind')
@section('title', 'লেসন সারাংশ - কোর্স তৈরি করুন')
@section('header-title', 'লেসন সারাংশ')
@section('header-subtitle', 'আপনার লেসনের বিস্তারিত তথ্য এবং সম্পাদনা বিকল্প')

@section('style')
<style>
/* Lesson overview specific styles */
.lesson-overview-card {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.3);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.lesson-overview-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    border-radius: 0 2px 2px 0;
}

.lesson-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.lesson-type-icon-large {
    width: 80px;
    height: 80px;
    border-radius: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 2.5rem;
    color: #FFFFFF;
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

.lesson-info h1 {
    color: #FFFFFF;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.lesson-info p {
    color: #9CA3AF;
    font-size: 1rem;
    margin: 0;
}

.lesson-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
}

.meta-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    color: #FFFFFF;
    font-size: 0.875rem;
    font-weight: 500;
}

.meta-badge.success {
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.3);
    color: #10B981;
}

.meta-badge.warning {
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.3);
    color: #F59E0B;
}

.meta-badge.info {
    background: rgba(90, 234, 244, 0.2);
    border-color: rgba(90, 234, 244, 0.3);
    color: #5AEAF4;
}

.lesson-slug {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 0.5rem;
}

.lesson-slug code {
    background: rgba(90, 234, 244, 0.2);
    color: #5AEAF4;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-family: 'Courier New', monospace;
}

/* Details sections */
.details-section {
    background: linear-gradient(135deg, #0F2342, #1A365D);
    border: 2px solid rgba(90, 234, 244, 0.2);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.section-header h2 {
    color: #FFFFFF;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

.section-header i {
    color: #5AEAF4;
    font-size: 1.25rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-field {
    margin-bottom: 1.5rem;
}

.form-field:last-child {
    margin-bottom: 0;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #FFFFFF;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.field-label i {
    color: #5AEAF4;
    font-size: 0.875rem;
}

.field-input {
    width: 100%;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    color: #9CA3AF;
    font-size: 1rem;
    cursor: not-allowed;
    transition: all 0.3s ease;
}

.field-input:focus {
    outline: none;
    border-color: rgba(90, 234, 244, 0.3);
}

.field-help {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

/* Content type display */
.content-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.content-type-card {
    background: linear-gradient(135deg, #091D3D, #0F2342);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
}

.content-type-card.active {
    border-color: #5AEAF4;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1), rgba(203, 251, 144, 0.05));
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.2);
}

.content-type-card.inactive {
    opacity: 0.4;
}

.content-type-card i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
    color: #9CA3AF;
}

.content-type-card.active i {
    color: #5AEAF4;
}

.content-type-card h3 {
    color: #FFFFFF;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.content-type-card p {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin: 0;
}

.content-type-card .check-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #10B981;
    font-size: 1.5rem;
}

/* Status indicators */
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.875rem;
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

.status-info {
    background: rgba(90, 234, 244, 0.2);
    color: #5AEAF4;
    border: 1px solid rgba(90, 234, 244, 0.3);
}

/* Action buttons */
.action-buttons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-edit {
    background: linear-gradient(135deg, #5AEAF4, #CBFB90);
    color: #091D3D;
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-back {
    background: rgba(255, 255, 255, 0.1);
    color: #C7C7C7;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-back:hover {
    background: rgba(249, 115, 22, 0.1);
    border-color: #F97316;
    color: #F97316;
}

.btn-next {
    background: linear-gradient(135deg, #10B981, #34D399);
    color: #FFFFFF;
}

.btn-next:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

/* Completion checklist */
.completion-checklist {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.checklist-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.checklist-item:last-child {
    border-bottom: none;
}

.checklist-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.checklist-icon.complete {
    background: #10B981;
    color: #FFFFFF;
}

.checklist-icon.pending {
    background: rgba(239, 68, 68, 0.2);
    border: 2px solid #EF4444;
    color: #EF4444;
}

.checklist-text {
    color: #FFFFFF;
    font-size: 0.875rem;
}

.checklist-text.complete {
    opacity: 0.7;
}

/* Responsive design */
@media (max-width: 768px) {
    .lesson-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .lesson-info h1 {
        font-size: 1.5rem;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .content-types-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons-grid {
        grid-template-columns: 1fr;
    }
    
    .lesson-meta {
        justify-content: center;
    }
}

/* Animation */
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

.animate-slide-up {
    animation: slideInUp 0.6s ease-out;
}
</style>
@endsection

@section('content')
<div class="space-y-6 animate-slide-up">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl p-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $module = \App\Models\Module::find($lesson->module_id);
        $hasContent = $lesson->video_link || $lesson->audio_link || $lesson->text_content;
        $contentStatus = $lesson->status ?? 'pending';
    @endphp

    <!-- Lesson Overview Card -->
    <div class="lesson-overview-card">
        <div class="lesson-header">
            <div class="lesson-type-icon-large lesson-type-{{ $lesson->type }}">
                @if($lesson->type == 'text')
                    <i class="fas fa-file-alt"></i>
                @elseif($lesson->type == 'audio')
                    <i class="fas fa-volume-up"></i>
                @elseif($lesson->type == 'video')
                    <i class="fas fa-play"></i>
                @endif
            </div>
            <div class="lesson-info">
                <h1>{{ $lesson->title }}</h1>
                <p>{{ ucfirst($lesson->type) }} লেসন - {{ $module->title }} মডিউল</p>

                <div class="lesson-meta">
                    @if($hasContent)
                        @if($contentStatus == 'published' || $contentStatus == 'active')
                            <div class="meta-badge success">
                                <i class="fas fa-check-circle"></i>
                                কন্টেন্ট সম্পূর্ণ
                            </div>
                        @else
                            <div class="meta-badge warning">
                                <i class="fas fa-clock"></i>
                                কন্টেন্ট যোগ করা হয়েছে
                            </div>
                        @endif
                    @else
                        <div class="meta-badge warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            কন্টেন্ট নেই
                        </div>
                    @endif

                    @if($lesson->is_public)
                        <div class="meta-badge info">
                            <i class="fas fa-globe"></i>
                            পাবলিক লেসন
                        </div>
                    @endif
                </div>

                <div class="lesson-slug">
                    <i class="fas fa-link text-cyan"></i>
                    <span class="text-secondary-200">URL Slug:</span>
                    <code>{{ $lesson->slug }}</code>
                </div>
            </div>
        </div>

        <!-- Completion Checklist -->
        <div class="completion-checklist">
            <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                <i class="fas fa-tasks text-cyan"></i>
                লেসন সম্পূর্ণতার চেকলিস্ট
            </h3>
            <div class="space-y-2">
                <div class="checklist-item">
                    <div class="checklist-icon complete">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="checklist-text complete">লেসন তৈরি এবং নাম নির্ধারণ</div>
                </div>
                <div class="checklist-item">
                    <div class="checklist-icon {{ $hasContent ? 'complete' : 'pending' }}">
                        @if($hasContent)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-exclamation"></i>
                        @endif
                    </div>
                    <div class="checklist-text {{ $hasContent ? 'complete' : '' }}">
                        {{ $lesson->type == 'video' ? 'ভিডিও আপলোড' : ($lesson->type == 'audio' ? 'অডিও আপলোড' : 'টেক্সট কন্টেন্ট') }}
                    </div>
                </div>
                <div class="checklist-item">
                    <div class="checklist-icon {{ $lesson->short_description ? 'complete' : 'pending' }}">
                        @if($lesson->short_description)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-exclamation"></i>
                        @endif
                    </div>
                    <div class="checklist-text {{ $lesson->short_description ? 'complete' : '' }}">লেসন বিবরণ</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Type Section -->
    <div class="details-section">
        <div class="section-header">
            <i class="fas fa-cogs"></i>
            <h2>কন্টেন্টের ধরন</h2>
        </div>

        <div class="content-types-grid">
            <div class="content-type-card {{ $lesson->type == 'text' ? 'active' : 'inactive' }}">
                <i class="fas fa-file-alt"></i>
                <h3>টেক্সট কন্টেন্ট</h3>
                <p>লিখিত বিষয়বস্তু এবং তথ্য</p>
                @if($lesson->type == 'text')
                    <i class="fas fa-check-circle check-icon"></i>
                @endif
            </div>

            <div class="content-type-card {{ $lesson->type == 'audio' ? 'active' : 'inactive' }}">
                <i class="fas fa-volume-up"></i>
                <h3>অডিও কন্টেন্ট</h3>
                <p>শ্রবণযোগ্য বিষয়বস্তু এবং পডকাস্ট</p>
                @if($lesson->type == 'audio')
                    <i class="fas fa-check-circle check-icon"></i>
                @endif
            </div>

            <div class="content-type-card {{ $lesson->type == 'video' ? 'active' : 'inactive' }}">
                <i class="fas fa-play-circle"></i>
                <h3>ভিডিও কন্টেন্ট</h3>
                <p>দৃশ্যমান বিষয়বস্তু এবং টিউটোরিয়াল</p>
                @if($lesson->type == 'video')
                    <i class="fas fa-check-circle check-icon"></i>
                @endif
            </div>
        </div>

        @if($lesson->short_description)
            <div class="mt-6">
                <label class="field-label">
                    <i class="fas fa-align-left"></i>
                    লেসনের বিবরণ
                </label>
                <div class="field-input min-h-[100px] cursor-text" style="height: auto; padding-top: 1rem; padding-bottom: 1rem;">
                    {{ $lesson->short_description }}
                </div>
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-grid">
        @if ($lesson->type == 'audio')
            <a href="{{ url('instructor/courses/create/'.$course->id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id) }}"
               class="btn-action btn-edit">
                <i class="fas fa-edit"></i>
                অডিও কন্টেন্ট সম্পাদনা
            </a>
        @elseif ($lesson->type == 'text')
            <a href="{{ url('instructor/courses/create/'.$course->id.'/text/'.$lesson->module_id.'/content/'.$lesson->id) }}"
               class="btn-action btn-edit">
                <i class="fas fa-edit"></i>
                টেক্সট কন্টেন্ট সম্পাদনা
            </a>
        @elseif ($lesson->type == 'video')
            <a href="{{ url('instructor/courses/create/'.$course->id.'/video/'.$lesson->module_id.'/content/'.$lesson->id) }}"
               class="btn-action btn-edit">
                <i class="fas fa-edit"></i>
                ভিডিও কন্টেন্ট সম্পাদনা
            </a>
        @endif

        <a href="{{url('instructor/courses/create/'.$course->id.'/content')}}" class="btn-action btn-next">
            <i class="fas fa-arrow-right"></i>
            পরবর্তী ধাপ
        </a>
    </div>
</div>

@endsection
{{-- page content @E --}}

@section('script')
<script>
function toggleTechnicalDetails() {
    const details = document.getElementById('technicalDetails');
    const toggle = document.getElementById('technicalToggle');

    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        toggle.style.transform = 'rotate(180deg)';
    } else {
        details.classList.add('hidden');
        toggle.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection