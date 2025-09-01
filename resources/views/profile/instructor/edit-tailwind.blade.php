@extends('layouts.instructor-tailwind')
@section('title', 'প্রোফাইল সেটিংস')
@section('header-title', 'প্রোফাইল সেটিংস')
@section('header-subtitle', 'আপনার প্রোফাইল তথ্য এবং অ্যাকাউন্ট সেটিংস পরিচালনা করুন')

@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />

<style>
/* Modern Tab Design */
.tab-navigation {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.05) 0%, rgba(203, 251, 144, 0.05) 100%);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.tab-item {
    position: relative;
    padding: 1.25rem 1.75rem;
    color: #ABABAB;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    background: transparent;
    border: none;
    outline: none;
}

.tab-item:hover {
    color: #5AEAF4;
    background: rgba(90, 234, 244, 0.05);
}

.tab-item.active {
    color: #5AEAF4;
    border-bottom-color: #5AEAF4;
    background: rgba(90, 234, 244, 0.1);
}

.tab-item.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
}

:root.light-theme .tab-item {
    color: #6B7280;
}

:root.light-theme .tab-item:hover {
    color: #3B82F6;
    background: rgba(59, 130, 246, 0.05);
}

:root.light-theme .tab-item.active {
    color: #3B82F6;
    border-bottom-color: #3B82F6;
    background: rgba(59, 130, 246, 0.1);
}

/* Form Sections */
.form-section {
    background: var(--color-card);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 1.5rem;
}

.form-section-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 2rem;
    padding-bottom: 1rem;
}

/* Profile Picture Upload */
.profile-upload-container {
    position: relative;
    width: 180px;
    height: 180px;
    margin: 0 auto;
    border-radius: 50%;
    border: 4px solid rgba(90, 234, 244, 0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-upload-container:hover {
    border-color: #5AEAF4;
    transform: scale(1.02);
    box-shadow: 0 8px 32px rgba(90, 234, 244, 0.2);
}

.profile-upload-area {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.profile-upload-area:hover {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.2) 0%, rgba(203, 251, 144, 0.2) 100%);
}

.profile-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-upload-container:hover .upload-overlay {
    opacity: 1;
}

/* Form Controls */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: #ABABAB;
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    background: var(--color-primary);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    color: white;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #5AEAF4;
    box-shadow: 0 0 0 3px rgba(90, 234, 244, 0.1);
}

.form-control::placeholder {
    color: #666;
}

:root.light-theme .form-control {
    background: white;
    color: #374151;
    border-color: #E5E7EB;
}

:root.light-theme .form-control:focus {
    border-color: #3B82F6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Action Buttons */
.btn-primary {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    color: #091D3D;
    padding: 0.875rem 2rem;
    border-radius: 0.75rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.3);
}

.btn-secondary {
    background: var(--color-secondary);
    color: #ABABAB;
    padding: 0.875rem 2rem;
    border-radius: 0.75rem;
    font-weight: 500;
    border: 1px solid rgba(255, 255, 255, 0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: var(--color-card);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 0.75rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
}

/* Form Actions */
.form-actions {
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin: 2rem -2rem -2rem -2rem;
    padding: 1.5rem 2rem;
    border-radius: 0 0 1rem 1rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Certificate Upload */
.certificate-upload-area {
    border: 2px dashed rgba(90, 234, 244, 0.3);
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.certificate-upload-area:hover {
    border-color: #5AEAF4;
    background: rgba(90, 234, 244, 0.05);
}

/* Experience List */
.experience-item {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

/* Social Media Icons */
.social-platform {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    margin-bottom: 1rem;
}

.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.social-facebook { background: linear-gradient(135deg, #1877F2 0%, #0C63D4 100%); }
.social-linkedin { background: linear-gradient(135deg, #0A66C2 0%, #004182 100%); }
.social-youtube { background: linear-gradient(135deg, #FF0000 0%, #CC0000 100%); }
.social-website { background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%); }

/* Responsive */
@media (max-width: 768px) {
    .tab-navigation {
        overflow-x: auto;
    }
    
    .tab-item {
        padding: 1rem;
        font-size: 0.875rem;
        white-space: nowrap;
    }
    
    .form-section {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-actions button {
        width: 100%;
    }
}

/* Loading States */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Tab Navigation -->
    <div class="bg-card rounded-xl border border-[#fff]/20 overflow-hidden">
        <div class="tab-navigation">
            <div class="flex overflow-x-auto">
                <button class="tab-item active" data-tab="profile">
                    <i class="fas fa-user mr-2"></i>
                    <span class="hidden sm:inline">প্রোফাইল তথ্য</span>
                    <span class="sm:hidden">প্রোফাইল</span>
                </button>
                <button class="tab-item" data-tab="experience">
                    <i class="fas fa-briefcase mr-2"></i>
                    <span class="hidden sm:inline">কর্মঅভিজ্ঞতা</span>
                    <span class="sm:hidden">অভিজ্ঞতা</span>
                </button>
                <button class="tab-item" data-tab="certificate">
                    <i class="fas fa-certificate mr-2"></i>
                    <span class="hidden sm:inline">সার্টিফিকেট</span>
                    <span class="sm:hidden">সার্টিফিকেট</span>
                </button>
                <button class="tab-item" data-tab="social">
                    <i class="fas fa-share-alt mr-2"></i>
                    <span class="hidden sm:inline">সামাজিক যোগাযোগ</span>
                    <span class="sm:hidden">সামাজিক</span>
                </button>
                <button class="tab-item" data-tab="password">
                    <i class="fas fa-lock mr-2"></i>
                    <span class="hidden sm:inline">নিরাপত্তা</span>
                    <span class="sm:hidden">নিরাপত্তা</span>
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            <!-- Profile Information Tab -->
            <div id="tab-profile" class="tab-content active">
                <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">ব্যক্তিগত তথ্য</h3>
                                    <p class="text-secondary-200 text-sm">আপনার প্রোফাইল তথ্য আপডেট করুন</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Profile Picture -->
                            <div class="lg:col-span-1">
                                <div class="text-center">
                                    <h4 class="text-white font-semibold mb-4">প্রোফাইল ছবি</h4>
                                    
                                    <div class="profile-upload-container">
                                        <input type="file" name="avatar" accept="image/*" id="avatar" class="hidden">
                                        <input type="hidden" name="base64_avatar" id="base64_avatar">
                                        
                                        <label for="avatar" class="profile-upload-area">
                                            @if($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" alt="Profile" class="profile-preview" id="profile-preview">
                                            @else
                                                <div class="text-center">
                                                    <i class="fas fa-camera text-4xl text-blue mb-2"></i>
                                                    <p class="text-secondary-200 text-sm">ছবি আপলোড করুন</p>
                                                </div>
                                            @endif
                                        </label>
                                        
                                        
                                    </div>
                                    
                                    <p class="text-secondary-200 text-xs mt-3">সর্বোচ্চ ৫MB, JPG/PNG ফরম্যাট</p>
                                </div>
                            </div>

                            <!-- Profile Information Form -->
                            <div class="lg:col-span-2 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label class="form-label">পূর্ণ নাম *</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                               class="form-control" placeholder="আপনার পূর্ণ নাম" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">ফোন নম্বর *</label>
                                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                               class="form-control" placeholder="+880 1XXXXXXXXX" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">ইমেইল</label>
                                    <input type="email" value="{{ $user->email }}" 
                                           class="form-control bg-secondary cursor-not-allowed" readonly>
                                    <p class="text-secondary-200 text-xs mt-1">ইমেইল পরিবর্তন করতে সাপোর্টে যোগাযোগ করুন</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">ওয়েবসাইট</label>
                                    <input type="url" name="website" value="{{ old('website', $user->short_bio) }}" 
                                           class="form-control" placeholder="https://yourwebsite.com">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">আপনার সম্পর্কে</label>
                                    <textarea name="description" rows="4" class="form-control resize-none" 
                                              placeholder="আপনার পেশাগত অভিজ্ঞতা এবং দক্ষতা সম্পর্কে লিখুন...">{{ old('description', $user->description) }}</textarea>
                                </div>

                                <div class="flex items-center gap-3 p-4 bg-blue/20 border border-blue rounded-lg">
                                    <div>
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" name="recivingMessage" value="1" 
                                                   {{ $user->recivingMessage ? 'checked' : '' }}
                                                   class="w-5 h-5 text-blue bg-transparent border-2 border-blue rounded focus:ring-blue focus:ring-2">
                                            <div>
                                                <span class="text-white font-medium">বার্তা গ্রহণ করুন</span>
                                                <p class="text-secondary-200 text-sm">শিক্ষার্থীদের থেকে সরাসরি বার্তা পেতে চান</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="history.back()" class="btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                ফিরে যান
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                প্রোফাইল আপডেট করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Experience Tab -->
            <div id="tab-experience" class="tab-content hidden">
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">কর্মঅভিজ্ঞতা</h3>
                                    <p class="text-secondary-200 text-sm">আপনার পেশাগত অভিজ্ঞতা পরিচালনা করুন</p>
                                </div>
                            </div>
                            <button type="button" onclick="showAddExperienceModal()" class="btn-primary">
                                <i class="fas fa-plus"></i>
                                নতুন যোগ করুন
                            </button>
                        </div>
                    </div>

                    @if($experiences && $experiences->count() > 0)
                        <div class="space-y-4">
                            @foreach($experiences as $experience)
                                <div class="experience-item">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-building text-primary"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-semibold text-lg">{{ $experience->profession }}</h4>
                                                <div class="flex items-center gap-2 text-secondary-200 text-sm mb-2">
                                                    <span class="font-medium">{{ $experience->company_name }}</span>
                                                    <span>•</span>
                                                    <span>{{ $experience->job_type }}</span>
                                                    <span>•</span>
                                                    <span>{{ $experience->experience }}</span>
                                                </div>
                                                <p class="text-secondary-100">{{ $experience->short_description }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('instructor.profile.experience.edit', $experience->id) }}?tab=experience" 
                                               class="w-8 h-8 bg-blue/20 text-blue rounded-lg flex items-center justify-center hover:bg-blue hover:text-primary anim">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('instructor.profile.experience.delete', $experience->id) }}" 
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('আপনি কি এই অভিজ্ঞতা মুছে ফেলতে চান?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-8 h-8 bg-red-500/20 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white anim">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-briefcase text-3xl text-purple-500"></i>
                            </div>
                            <h4 class="text-white font-semibold mb-2">কোনো অভিজ্ঞতা যোগ করা হয়নি</h4>
                            <p class="text-secondary-200 mb-6">আপনার পেশাগত অভিজ্ঞতা যোগ করুন</p>
                            <button type="button" onclick="showAddExperienceModal()" class="btn-primary">
                                <i class="fas fa-plus"></i>
                                প্রথম অভিজ্ঞতা যোগ করুন
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Certificate Tab -->
            <div id="tab-certificate" class="tab-content hidden">
                <form action="{{ route('instructor.certificates.settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-certificate text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">সার্টিফিকেট সেটিংস</h3>
                                    <p class="text-secondary-200 text-sm">আপনার কোর্সের সার্টিফিকেট কাস্টমাইজ করুন</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="form-group">
                                <label class="form-label">কোর্স নির্বাচন করুন *</label>
                                <select name="course_id" class="form-control" required>
                                    <option value="">কোর্স নির্বাচন করুন</option>
                                    @if(isset($courses))
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">সার্টিফিকেট টেমপ্লেট *</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="certificate-template cursor-pointer">
                                        <input type="radio" name="certificate_style" value="1" class="hidden">
                                        <div class="p-4 border-2 border-transparent rounded-lg bg-gradient-to-br from-blue-500/20 to-purple-500/20 hover:border-blue anim">
                                            <div class="text-center">
                                                <i class="fas fa-certificate text-3xl text-blue mb-2"></i>
                                                <h4 class="text-white font-semibold">ক্লাসিক</h4>
                                                <p class="text-secondary-200 text-sm">ঐতিহ্যবাহী নকশা</p>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="certificate-template cursor-pointer">
                                        <input type="radio" name="certificate_style" value="2" class="hidden">
                                        <div class="p-4 border-2 border-transparent rounded-lg bg-gradient-to-br from-green-500/20 to-blue-500/20 hover:border-green-500 anim">
                                            <div class="text-center">
                                                <i class="fas fa-award text-3xl text-green-500 mb-2"></i>
                                                <h4 class="text-white font-semibold">আধুনিক</h4>
                                                <p class="text-secondary-200 text-sm">আধুনিক নকশা</p>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="certificate-template cursor-pointer">
                                        <input type="radio" name="certificate_style" value="3" class="hidden">
                                        <div class="p-4 border-2 border-transparent rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-500/20 hover:border-purple-500 anim">
                                            <div class="text-center">
                                                <i class="fas fa-medal text-3xl text-purple-500 mb-2"></i>
                                                <h4 class="text-white font-semibold">প্রিমিয়াম</h4>
                                                <p class="text-secondary-200 text-sm">প্রিমিয়াম নকশা</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label class="form-label">লোগো আপলোড</label>
                                    <div class="certificate-upload-area">
                                        <input type="file" name="logo" accept="image/*" id="logo" class="hidden">
                                        <label for="logo" class="cursor-pointer">
                                            <i class="fas fa-image text-3xl text-blue mb-3"></i>
                                            <p class="text-white font-semibold mb-1">লোগো আপলোড করুন</p>
                                            <p class="text-secondary-200 text-sm">PNG, JPG (সর্বোচ্চ ৫MB)</p>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">স্বাক্ষর আপলোড</label>
                                    <div class="certificate-upload-area">
                                        <input type="file" name="signature" accept="image/*" id="signature" class="hidden">
                                        <label for="signature" class="cursor-pointer">
                                            <i class="fas fa-signature text-3xl text-lime mb-3"></i>
                                            <p class="text-white font-semibold mb-1">স্বাক্ষর আপলোড করুন</p>
                                            <p class="text-secondary-200 text-sm">PNG, JPG (সর্বোচ্চ ৫MB)</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="previewCertificate()" class="btn-secondary">
                                <i class="fas fa-eye"></i>
                                প্রিভিউ দেখুন
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                সার্টিফিকেট সেভ করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Social Media Tab -->
            <div id="tab-social" class="tab-content hidden">
                <form action="{{ route('instructor.profile.update') }}" method="POST">
                    @csrf
                    @php
                        // Parse existing social links
                        $social_links = explode(",", $user->social_links ?? '');
                        $facebook_url = '';
                        $linkedin_url = '';
                        $youtube_url = '';
                        $website_url = '';
                        
                        foreach($social_links as $link) {
                            $link = trim($link);
                            if(empty($link)) continue;
                            
                            if(str_contains($link, 'facebook.com')) {
                                $facebook_url = $link;
                            } elseif(str_contains($link, 'linkedin.com')) {
                                $linkedin_url = $link;
                            } elseif(str_contains($link, 'youtube.com')) {
                                $youtube_url = $link;
                            } else {
                                $website_url = $link;
                            }
                        }
                    @endphp
                    
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-share-alt text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">সামাজিক যোগাযোগ</h3>
                                    <p class="text-secondary-200 text-sm">আপনার সামাজিক মাধ্যমের লিংক যোগ করুন</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Facebook -->
                            <div class="social-platform">
                                <div class="social-icon social-facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold mb-1">Facebook</h4>
                                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $facebook_url) }}" 
                                           class="form-control" placeholder="https://facebook.com/your-profile">
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="social-platform">
                                <div class="social-icon social-linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold mb-1">LinkedIn</h4>
                                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $linkedin_url) }}" 
                                           class="form-control" placeholder="https://linkedin.com/in/your-profile">
                                </div>
                            </div>

                            <!-- YouTube -->
                            <div class="social-platform">
                                <div class="social-icon social-youtube">
                                    <i class="fab fa-youtube"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold mb-1">YouTube</h4>
                                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $youtube_url) }}" 
                                           class="form-control" placeholder="https://youtube.com/channel/your-channel">
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="social-platform">
                                <div class="social-icon social-website">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold mb-1">অন্যান্য ওয়েবসাইট</h4>
                                    <input type="url" name="website_url" value="{{ old('website_url', $website_url) }}" 
                                           class="form-control" placeholder="https://your-website.com">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                সামাজিক লিংক সংরক্ষণ করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Tab -->
            <div id="tab-password" class="tab-content hidden">
                <form action="{{ route('instructor.profile.password.update') }}" method="POST">
                    @csrf
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-lock text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-lg">পাসওয়ার্ড পরিবর্তন</h3>
                                    <p class="text-secondary-200 text-sm">আপনার অ্যাকাউন্টের নিরাপত্তা বৃদ্ধি করুন</p>
                                </div>
                            </div>
                        </div>

                        <div class="max-w-md mx-auto space-y-6">
                            <div class="form-group">
                                <label class="form-label">বর্তমান পাসওয়ার্ড *</label>
                                <div class="relative">
                                    <input type="password" name="current_password" class="form-control pr-12" 
                                           placeholder="বর্তমান পাসওয়ার্ড" required>
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-secondary-200 hover:text-white anim"
                                            onclick="togglePassword(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">নতুন পাসওয়ার্ড *</label>
                                <div class="relative">
                                    <input type="password" name="password" class="form-control pr-12" 
                                           placeholder="নতুন পাসওয়ার্ড" required minlength="8">
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-secondary-200 hover:text-white anim"
                                            onclick="togglePassword(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন *</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" class="form-control pr-12" 
                                           placeholder="পাসওয়ার্ড পুনরায় টাইপ করুন" required minlength="8">
                                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-secondary-200 hover:text-white anim"
                                            onclick="togglePassword(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="bg-yellow-500/20 border border-yellow-500 rounded-lg p-4">
                                <h4 class="text-yellow-500 font-semibold mb-2 flex items-center gap-2">
                                    <i class="fas fa-shield-alt"></i>
                                    নিরাপদ পাসওয়ার্ডের শর্ত
                                </h4>
                                <ul class="text-secondary-200 text-sm space-y-1">
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        কমপক্ষে ৮ অক্ষর হতে হবে
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        বড় ও ছোট হাতের অক্ষর
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-check text-green-500"></i>
                                        সংখ্যা এবং বিশেষ চিহ্ন
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-danger">
                                <i class="fas fa-lock"></i>
                                পাসওয়ার্ড পরিবর্তন করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Experience Modal -->
<div id="addExperienceModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-card rounded-xl max-w-2xl w-full p-6 border border-[#fff]/10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange to-yellow-500 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,2A3,3 0 0,1 15,5V7H19A2,2 0 0,1 21,9V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V9A2,2 0 0,1 5,7H9V5A3,3 0 0,1 12,2M12,4A1,1 0 0,0 11,5V7H13V5A1,1 0 0,0 12,4Z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">নতুন অভিজ্ঞতা যোগ করুন</h3>
            </div>
            <button onclick="closeAddExperienceModal()" class="text-secondary-200 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="addExperienceForm" method="POST" action="{{ route('instructor.profile.experience.store') }}">
            @csrf
            <div class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">পেশা *</label>
                        <input type="text" name="profession" required 
                               class="w-full bg-primary border border-[#fff]/20 rounded-lg px-4 py-3 text-white placeholder-secondary-200 focus:outline-none focus:border-orange transition-colors" 
                               placeholder="যেমন: সফটওয়্যার ইঞ্জিনিয়ার">
                        <div class="text-red-400 text-sm mt-1 hidden" id="profession-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">কোম্পানির নাম *</label>
                        <input type="text" name="company_name" required 
                               class="w-full bg-primary border border-[#fff]/20 rounded-lg px-4 py-3 text-white placeholder-secondary-200 focus:outline-none focus:border-orange transition-colors" 
                               placeholder="যেমন: Google, Microsoft">
                        <div class="text-red-400 text-sm mt-1 hidden" id="company_name-error"></div>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">চাকরির ধরন *</label>
                        <select name="job_type" required 
                                class="w-full bg-primary border border-[#fff]/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-orange transition-colors">
                            <option value="">নির্বাচন করুন</option>
                            <option value="Full-time">ফুল-টাইম</option>
                            <option value="Part-time">পার্ট-টাইম</option>
                            <option value="Contract">কন্ট্রাক্ট</option>
                            <option value="Freelance">ফ্রিল্যান্স</option>
                            <option value="Internship">ইন্টার্নশিপ</option>
                        </select>
                        <div class="text-red-400 text-sm mt-1 hidden" id="job_type-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">অভিজ্ঞতার সময়কাল *</label>
                        <input type="text" name="experience" required 
                               class="w-full bg-primary border border-[#fff]/20 rounded-lg px-4 py-3 text-white placeholder-secondary-200 focus:outline-none focus:border-orange transition-colors" 
                               placeholder="যেমন: ২ বছর, ৬ মাস">
                        <div class="text-red-400 text-sm mt-1 hidden" id="experience-error"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">বিবরণ</label>
                    <textarea name="short_description" rows="4" 
                              class="w-full bg-primary border border-[#fff]/20 rounded-lg px-4 py-3 text-white placeholder-secondary-200 focus:outline-none focus:border-orange transition-colors resize-none" 
                              placeholder="আপনার কাজের দায়িত্ব এবং অর্জনের সংক্ষিপ্ত বিবরণ লিখুন..."></textarea>
                    <div class="text-red-400 text-sm mt-1 hidden" id="short_description-error"></div>
                </div>
                
                <div class="flex items-center gap-4 pt-4 border-t border-[#fff]/10">
                    <button type="button" onclick="closeAddExperienceModal()" 
                            class="px-6 py-3 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg font-medium transition-colors">
                        বাতিল
                    </button>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-orange to-yellow-500 hover:from-yellow-500 hover:to-orange text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/>
                            </svg>
                            অভিজ্ঞতা যোগ করুন
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-item');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => {
                content.classList.remove('active');
                content.classList.add('hidden');
            });
            
            // Add active class to clicked tab and corresponding content
            button.classList.add('active');
            const targetContent = document.getElementById(`tab-${targetTab}`);
            if (targetContent) {
                targetContent.classList.add('active');
                targetContent.classList.remove('hidden');
            }
        });
    });

    // Profile picture upload
    const avatarInput = document.getElementById('avatar');
    const profilePreview = document.getElementById('profile-preview');
    const base64Avatar = document.getElementById('base64_avatar');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (profilePreview) {
                        profilePreview.src = e.target.result;
                    } else {
                        // Create new preview image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'profile-preview';
                        img.id = 'profile-preview';
                        
                        const uploadArea = document.querySelector('.profile-upload-area');
                        uploadArea.innerHTML = '';
                        uploadArea.appendChild(img);
                    }
                    
                    if (base64Avatar) {
                        base64Avatar.value = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Certificate template selection
    const certificateTemplates = document.querySelectorAll('.certificate-template');
    certificateTemplates.forEach(template => {
        template.addEventListener('click', function() {
            certificateTemplates.forEach(t => {
                t.querySelector('div').classList.remove('border-blue', 'border-green-500', 'border-purple-500');
                t.querySelector('div').classList.add('border-transparent');
            });
            
            const radioValue = this.querySelector('input').value;
            let borderColor = 'border-blue';
            if (radioValue === '2') borderColor = 'border-green-500';
            if (radioValue === '3') borderColor = 'border-purple-500';
            
            this.querySelector('div').classList.remove('border-transparent');
            this.querySelector('div').classList.add(borderColor);
        });
    });

    // Form submission handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('btn-loading')) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                
                // Re-enable after 10 seconds as safety
                setTimeout(() => {
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.disabled = false;
                }, 10000);
            }
        });
    });

    // Auto-select active tab based on URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam) {
        const tabButton = document.querySelector(`[data-tab="${tabParam}"]`);
        if (tabButton) {
            tabButton.click();
        }
    }
});

// Password visibility toggle
function togglePassword(button) {
    const input = button.parentElement.querySelector('input');
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Add experience modal functions
function showAddExperienceModal() {
    const modal = document.getElementById('addExperienceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeAddExperienceModal() {
    const modal = document.getElementById('addExperienceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    
    // Clear form
    document.getElementById('addExperienceForm').reset();
    // Clear error messages
    document.querySelectorAll('[id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

// Handle form submission for add experience
document.getElementById('addExperienceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="w-4 h-4 animate-spin" fill="currentColor" viewBox="0 0 24 24"><path d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z"/></svg>যোগ করা হচ্ছে...</span>';
    
    // Clear previous errors
    document.querySelectorAll('[id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAddExperienceModal();
            showSuccessMessage('অভিজ্ঞতা সফলভাবে যোগ করা হয়েছে!');
            // Reload page to show new experience
            setTimeout(() => {
                window.location.href = '{{ route("instructor.profile.settings") }}?tab=experience';
            }, 1500);
        } else {
            // Show validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const errorEl = document.getElementById(field + '-error');
                    if (errorEl) {
                        errorEl.textContent = data.errors[field][0];
                        errorEl.classList.remove('hidden');
                    }
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showSuccessMessage('কিছু ভুল হয়েছে, আবার চেষ্টা করুন।');
    })
    .finally(() => {
        // Restore button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"/></svg>অভিজ্ঞতা যোগ করুন</span>';
    });
});

// Certificate preview (placeholder)
function previewCertificate() {
    alert('সার্টিফিকেট প্রিভিউ ফিচার শীঘ্রই আসছে!');
}

// Success message display
function showSuccessMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 z-50 p-4 bg-green-500/20 border border-green-500 text-green-500 rounded-lg max-w-sm';
    alertDiv.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <div class="flex-1">${message}</div>
            <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Check for success messages
@if(session('success'))
    showSuccessMessage('{{ session('success') }}');
@endif
</script>
@endsection