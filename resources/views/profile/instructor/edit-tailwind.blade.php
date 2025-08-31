@extends('layouts.instructor-tailwind')
@section('title', 'অ্যাকাউন্ট ব্যবস্থাপনা')
@section('header-title', 'অ্যাকাউন্ট ব্যবস্থাপনা')
@section('header-subtitle', 'আপনার প্রোফাইল এবং সার্টিফিকেট সেটিংস পরিচালনা করুন')

@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />

<style>
/* Tab styles */
.tab-nav {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

:root.light-theme .tab-nav {
    border-bottom-color: #E5E7EB;
}

.tab-button {
    padding: 1rem 1.5rem;
    border-bottom: 2px solid transparent;
    color: #ABABAB;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.tab-button:hover {
    color: #5AEAF4;
    border-bottom-color: #5AEAF4;
}

.tab-button.active {
    color: #5AEAF4;
    border-bottom-color: #5AEAF4;
}

:root.light-theme .tab-button {
    color: #6B7280;
}

:root.light-theme .tab-button:hover {
    color: #3B82F6;
    border-bottom-color: #3B82F6;
}

:root.light-theme .tab-button.active {
    color: #3B82F6;
    border-bottom-color: #3B82F6;
}

/* Profile picture upload styles */
.profile-upload-area {
    position: relative;
    width: 200px;
    height: 200px;
    border: 2px dashed rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: var(--color-body);
}

:root.light-theme .profile-upload-area {
    border-color: #D1D5DB;
    background: #F9FAFB;
}

.profile-upload-area:hover {
    border-color: #5AEAF4;
    background: rgba(90, 234, 244, 0.1);
}

:root.light-theme .profile-upload-area:hover {
    border-color: #3B82F6;
    background: rgba(59, 130, 246, 0.1);
}

.profile-preview {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #5AEAF4;
}

.avatar-placeholder-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #021A30;
    font-size: 3rem;
    font-weight: bold;
}

/* Form styles */
.form-group {
    margin-bottom: 1.5rem;
}

/* Experience item styles */
.experience-item {
    background: var(--color-body);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

:root.light-theme .experience-item {
    background: #FFFFFF;
    border-color: #E5E7EB;
}

.experience-item:hover {
    border-color: #5AEAF4;
    transform: translateY(-2px);
}

:root.light-theme .experience-item:hover {
    border-color: #3B82F6;
}

/* Certificate template styles */
.certificate-template {
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

:root.light-theme .certificate-template {
    border-color: #E5E7EB;
}

.certificate-template:hover {
    border-color: #5AEAF4;
    transform: scale(1.02);
}

:root.light-theme .certificate-template:hover {
    border-color: #3B82F6;
}

.certificate-template.selected {
    border-color: #5AEAF4;
    box-shadow: 0 0 20px rgba(90, 234, 244, 0.3);
}

:root.light-theme .certificate-template.selected {
    border-color: #3B82F6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
}

/* Color picker styles */
.color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.color-option:hover,
.color-option.selected {
    border-color: #5AEAF4;
    transform: scale(1.1);
}

:root.light-theme .color-option:hover,
:root.light-theme .color-option.selected {
    border-color: #3B82F6;
}

/* File upload styles */
.file-upload-area {
    border: 2px dashed rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

:root.light-theme .file-upload-area {
    border-color: #D1D5DB;
}

.file-upload-area:hover {
    border-color: #5AEAF4;
    background: rgba(90, 234, 244, 0.1);
}

:root.light-theme .file-upload-area:hover {
    border-color: #3B82F6;
    background: rgba(59, 130, 246, 0.1);
}

/* Social media connect styles */
.social-connect {
    background: var(--color-body);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

:root.light-theme .social-connect {
    background: #FFFFFF;
    border-color: #E5E7EB;
}

.social-connect:hover {
    border-color: #5AEAF4;
}

:root.light-theme .social-connect:hover {
    border-color: #3B82F6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .profile-upload-area {
        width: 150px;
        height: 150px;
    }
    
    .avatar-placeholder-large {
        width: 90px;
        height: 90px;
        font-size: 2rem;
    }
    
    .tab-nav {
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .tab-button {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Settings Container -->
    <div class="bg-card rounded-xl shadow-2 theme-shadow overflow-hidden">
        <!-- Tab Navigation -->
        <div class="tab-nav bg-card">
            <div class="flex overflow-x-auto">
                <button class="tab-button active" data-tab="profile">
                    <i class="fas fa-user mr-2"></i>আমার প্রোফাইল
                </button>
                <button class="tab-button" data-tab="experience">
                    <i class="fas fa-briefcase mr-2"></i>অভিজ্ঞতা
                </button>
                <button class="tab-button" data-tab="certificate">
                    <i class="fas fa-certificate mr-2"></i>সার্টিফিকেট
                </button>
                <button class="tab-button" data-tab="app">
                    <i class="fas fa-link mr-2"></i>অ্যাকাউন্ট সংযোগ
                </button>
                <button class="tab-button" data-tab="password">
                    <i class="fas fa-lock mr-2"></i>পাসওয়ার্ড
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Profile Tab -->
            <div id="tab-profile" class="tab-content active">
                <form action="{{ route('instructor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Profile Picture Section -->
                        <div class="lg:col-span-1">
                            <div class="text-center">
                                <h3 class="text-white theme-text-primary font-semibold text-lg mb-4">প্রোফাইল ছবি</h3>
                                
                                <div class="profile-upload-area mx-auto mb-4">
                                    <input type="file" name="avatar" accept="image/*" id="avatar" class="hidden">
                                    <input type="hidden" name="base64_avatar" id="base64_avatar" value="">
                                    
                                    <label for="avatar" class="cursor-pointer">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="Avatar" id="profile-preview" class="profile-preview">
                                        @else
                                            <div class="flex flex-col items-center justify-center h-full">
                                                <div class="avatar-placeholder-large mb-4">
                                                    {{ strtoupper($user->name[0]) }}
                                                </div>
                                                <div class="text-center">
                                                    <i class="fas fa-camera-plus text-secondary-200 text-2xl mb-2"></i>
                                                    <p class="text-secondary-200 text-sm">ছবি আপলোড করুন</p>
                                                </div>
                                            </div>
                                        @endif
                                    </label>
                                </div>
                                
                                <p class="text-secondary-200 text-xs">
                                    অনুমোদিত: *.jpeg, *.jpg, *.png, *.gif<br>
                                    সর্বোচ্চ আকার: ৩.১ MB
                                </p>
                                
                                @error('avatar')
                                    <p class="text-orange text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Profile Form Section -->
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                <!-- Basic Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label class="block text-secondary-200 text-sm font-medium mb-2">নাম *</label>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ old('name', $user->name) }}"
                                               required
                                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                        @error('name')
                                            <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="block text-secondary-200 text-sm font-medium mb-2">ইমেইল *</label>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ old('email', $user->email) }}"
                                               required
                                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                        @error('email')
                                            <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label class="block text-secondary-200 text-sm font-medium mb-2">ফোন নম্বর</label>
                                        <input type="tel" 
                                               name="phone" 
                                               value="{{ old('phone', $user->phone) }}"
                                               placeholder="০১xxxxxxxxx"
                                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                        @error('phone')
                                            <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="block text-secondary-200 text-sm font-medium mb-2">লিঙ্গ</label>
                                        <select name="gender" 
                                                class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                        </select>
                                        @error('gender')
                                            <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="block text-secondary-200 text-sm font-medium mb-2">জন্ম তারিখ</label>
                                    <input type="date" 
                                           name="date_of_birth" 
                                           value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                           class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                    @error('date_of_birth')
                                        <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="block text-secondary-200 text-sm font-medium mb-2">বায়ো</label>
                                    <textarea name="bio" 
                                              rows="4"
                                              placeholder="আপনার সম্পর্কে কিছু লিখুন..."
                                              class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="block text-secondary-200 text-sm font-medium mb-2">ঠিকানা</label>
                                    <textarea name="address" 
                                              rows="3"
                                              placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন..."
                                              class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end mt-8 pt-6 border-t border-[#fff]/20 theme-border">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue to-lime text-primary rounded-lg px-8 py-3 font-semibold anim hover:shadow-1">
                            <i class="fas fa-save"></i>
                            প্রোফাইল আপডেট করুন
                        </button>
                    </div>
                </form>
            </div>

            <!-- Experience Tab -->
            <div id="tab-experience" class="tab-content hidden">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-white theme-text-primary font-semibold text-lg mb-1">কর্মঅভিজ্ঞতা</h3>
                            <p class="text-secondary-200 text-sm">আপনার শিক্ষামূলক এবং কর্মগত অভিজ্ঞতা যোগ করুন</p>
                        </div>
                        <button type="button" 
                                id="addExperienceBtn"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-lime to-blue text-primary rounded-lg px-6 py-3 font-semibold anim hover:shadow-1">
                            <i class="fas fa-plus"></i>
                            অভিজ্ঞতা যোগ করুন
                        </button>
                    </div>
                    
                    <!-- Experience List -->
                    <div id="experienceList" class="space-y-4">
                        @if(isset($user->experiences) && $user->experiences->count() > 0)
                            @foreach($user->experiences as $experience)
                            <div class="experience-item">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-white theme-text-primary font-semibold">{{ $experience->title }}</h4>
                                        <p class="text-blue font-medium">{{ $experience->company }}</p>
                                        <p class="text-secondary-200 text-sm">{{ $experience->duration }}</p>
                                        @if($experience->description)
                                            <p class="text-secondary-200 text-sm mt-2">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" 
                                                class="p-2 text-blue hover:text-lime anim" 
                                                onclick="editExperience({{ $experience->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="p-2 text-orange hover:text-red anim" 
                                                onclick="deleteExperience({{ $experience->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-briefcase text-orange text-2xl"></i>
                                </div>
                                <h4 class="text-white theme-text-primary font-semibold mb-2">কোন অভিজ্ঞতা যোগ করা হয়নি</h4>
                                <p class="text-secondary-200 text-sm">আপনার কর্মঅভিজ্ঞতা যোগ করুন</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Certificate Tab -->
            <div id="tab-certificate" class="tab-content hidden">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-white theme-text-primary font-semibold text-lg mb-1">সার্টিফিকেট সেটিংস</h3>
                        <p class="text-secondary-200 text-sm">আপনার কোর্সের জন্য সার্টিফিকেট টেমপ্লেট এবং সেটিংস কাস্টমাইজ করুন</p>
                    </div>
                    
                    <!-- Certificate Templates -->
                    <div>
                        <h4 class="text-white theme-text-primary font-medium mb-4">সার্টিফিকেট টেমপ্লেট নির্বাচন করুন</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="certificate-template" data-template="{{ $i }}">
                                <div class="aspect-video bg-gradient-to-br from-blue/20 to-purple/20 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-certificate text-4xl text-blue mb-2"></i>
                                        <p class="text-white theme-text-primary font-medium">টেমপ্লেট {{ $i }}</p>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Certificate Customization -->
                    <form action="{{ route('instructor.certificates.settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Logo Upload -->
                            <div>
                                <label class="block text-secondary-200 text-sm font-medium mb-2">সংস্থার লোগো</label>
                                <div class="file-upload-area">
                                    <input type="file" name="logo" accept="image/*" id="logo" class="hidden">
                                    <label for="logo" class="cursor-pointer">
                                        <i class="fas fa-upload text-blue text-2xl mb-2"></i>
                                        <p class="text-secondary-200">লোগো আপলোড করুন</p>
                                        <p class="text-secondary-200 text-xs mt-1">PNG, JPG (সর্বোচ্চ 2MB)</p>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Signature Upload -->
                            <div>
                                <label class="block text-secondary-200 text-sm font-medium mb-2">স্বাক্ষর</label>
                                <div class="file-upload-area">
                                    <input type="file" name="signature" accept="image/*" id="signature" class="hidden">
                                    <label for="signature" class="cursor-pointer">
                                        <i class="fas fa-signature text-blue text-2xl mb-2"></i>
                                        <p class="text-secondary-200">স্বাক্ষর আপলোড করুন</p>
                                        <p class="text-secondary-200 text-xs mt-1">PNG, JPG (সর্বোচ্চ 1MB)</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Certificate Colors -->
                        <div class="mt-6">
                            <label class="block text-secondary-200 text-sm font-medium mb-4">সার্টিফিকেট রঙ</label>
                            <div class="flex gap-4">
                                @php
                                $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'];
                                @endphp
                                @foreach($colors as $color)
                                <div class="color-option" style="background-color: {{ $color }}" data-color="{{ $color }}"></div>
                                @endforeach
                            </div>
                            <input type="hidden" name="certificate_color" id="certificate_color" value="#3B82F6">
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end mt-8 pt-6 border-t border-[#fff]/20 theme-border">
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue to-lime text-primary rounded-lg px-8 py-3 font-semibold anim hover:shadow-1">
                                <i class="fas fa-save"></i>
                                সেটিংস সংরক্ষণ করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- App/Connect Account Tab -->
            <div id="tab-app" class="tab-content hidden">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-white theme-text-primary font-semibold text-lg mb-1">অ্যাকাউন্ট সংযোগ</h3>
                        <p class="text-secondary-200 text-sm">আপনার সোশ্যাল মিডিয়া অ্যাকাউন্ট সংযুক্ত করুন</p>
                    </div>
                    
                    <form action="{{ route('instructor.social.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Facebook -->
                            <div class="social-connect">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-blue rounded-full flex items-center justify-center">
                                        <i class="fab fa-facebook-f text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white theme-text-primary font-medium">Facebook</h4>
                                        <p class="text-secondary-200 text-sm">আপনার Facebook প্রোফাইল</p>
                                    </div>
                                </div>
                                <input type="url" 
                                       name="facebook_url" 
                                       value="{{ old('facebook_url', $user->facebook_url) }}"
                                       placeholder="https://facebook.com/username"
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                            </div>
                            
                            <!-- LinkedIn -->
                            <div class="social-connect">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-blue rounded-full flex items-center justify-center">
                                        <i class="fab fa-linkedin-in text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white theme-text-primary font-medium">LinkedIn</h4>
                                        <p class="text-secondary-200 text-sm">আপনার LinkedIn প্রোফাইল</p>
                                    </div>
                                </div>
                                <input type="url" 
                                       name="linkedin_url" 
                                       value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                       placeholder="https://linkedin.com/in/username"
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                            </div>
                            
                            <!-- YouTube -->
                            <div class="social-connect">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-red rounded-full flex items-center justify-center">
                                        <i class="fab fa-youtube text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white theme-text-primary font-medium">YouTube</h4>
                                        <p class="text-secondary-200 text-sm">আপনার YouTube চ্যানেল</p>
                                    </div>
                                </div>
                                <input type="url" 
                                       name="youtube_url" 
                                       value="{{ old('youtube_url', $user->youtube_url) }}"
                                       placeholder="https://youtube.com/channel/..."
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                            </div>
                            
                            <!-- Website -->
                            <div class="social-connect">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-lime rounded-full flex items-center justify-center">
                                        <i class="fas fa-globe text-primary text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white theme-text-primary font-medium">ওয়েবসাইট</h4>
                                        <p class="text-secondary-200 text-sm">আপনার ব্যক্তিগত ওয়েবসাইট</p>
                                    </div>
                                </div>
                                <input type="url" 
                                       name="website_url" 
                                       value="{{ old('website_url', $user->website_url) }}"
                                       placeholder="https://yourwebsite.com"
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end mt-8 pt-6 border-t border-[#fff]/20 theme-border">
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue to-lime text-primary rounded-lg px-8 py-3 font-semibold anim hover:shadow-1">
                                <i class="fas fa-save"></i>
                                সংযোগ সংরক্ষণ করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Tab -->
            <div id="tab-password" class="tab-content hidden">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-white theme-text-primary font-semibold text-lg mb-1">পাসওয়ার্ড পরিবর্তন</h3>
                        <p class="text-secondary-200 text-sm">আপনার অ্যাকাউন্টের নিরাপত্তার জন্য শক্তিশালী পাসওয়ার্ড ব্যবহার করুন</p>
                    </div>
                    
                    <form action="{{ route('instructor.password.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div class="form-group">
                                <label class="block text-secondary-200 text-sm font-medium mb-2">বর্তমান পাসওয়ার্ড *</label>
                                <input type="password" 
                                       name="current_password" 
                                       required
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                @error('current_password')
                                    <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="block text-secondary-200 text-sm font-medium mb-2">নতুন পাসওয়ার্ড *</label>
                                <input type="password" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                                @error('password')
                                    <p class="text-orange text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="block text-secondary-200 text-sm font-medium mb-2">নতুন পাসওয়ার্ড নিশ্চিত করুন *</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       required
                                       minlength="8"
                                       class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim">
                            </div>
                            
                            <!-- Password Requirements -->
                            <div class="bg-blue/10 border border-blue/30 rounded-lg p-4">
                                <h5 class="text-blue font-medium mb-2">পাসওয়ার্ড প্রয়োজনীয়তা:</h5>
                                <ul class="text-secondary-200 text-sm space-y-1">
                                    <li><i class="fas fa-check text-lime mr-2"></i>কমপক্ষে ৮ অক্ষর</li>
                                    <li><i class="fas fa-check text-lime mr-2"></i>বড় ও ছোট হাতের অক্ষর</li>
                                    <li><i class="fas fa-check text-lime mr-2"></i>কমপক্ষে একটি সংখ্যা</li>
                                    <li><i class="fas fa-check text-lime mr-2"></i>কমপক্ষে একটি বিশেষ চিহ্ন</li>
                                </ul>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 bg-gradient-to-r from-orange to-red text-primary rounded-lg px-8 py-3 font-semibold anim hover:shadow-1">
                                    <i class="fas fa-lock"></i>
                                    পাসওয়ার্ড আপডেট করুন
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Handle URL hash for direct tab access
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'profile';
    
    function showTab(tabName) {
        // Update buttons
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.tab === tabName) {
                btn.classList.add('active');
            }
        });
        
        // Update content
        tabContents.forEach(content => {
            content.classList.add('hidden');
            if (content.id === `tab-${tabName}`) {
                content.classList.remove('hidden');
            }
        });
        
        // Update URL without reload
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('tab', tabName);
        window.history.pushState({}, '', newUrl);
    }
    
    // Initialize with URL tab
    showTab(activeTab);
    
    // Tab click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            showTab(this.dataset.tab);
        });
    });
    
    // Profile picture preview
    const avatarInput = document.getElementById('avatar');
    const profilePreview = document.getElementById('profile-preview');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (profilePreview) {
                        profilePreview.src = e.target.result;
                        profilePreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Certificate template selection
    const templateElements = document.querySelectorAll('.certificate-template');
    templateElements.forEach(template => {
        template.addEventListener('click', function() {
            templateElements.forEach(t => t.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
    
    // Color picker
    const colorOptions = document.querySelectorAll('.color-option');
    const colorInput = document.getElementById('certificate_color');
    
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            colorOptions.forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            if (colorInput) {
                colorInput.value = this.dataset.color;
            }
        });
    });
    
    // Set default color
    if (colorOptions.length > 0) {
        colorOptions[0].classList.add('selected');
    }
    
    // Experience management
    let experienceCounter = 0;
    
    function addExperience() {
        experienceCounter++;
        const experienceHtml = `
            <div class="experience-item" id="experience-${experienceCounter}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-secondary-200 text-sm font-medium mb-2">পদবী *</label>
                        <input type="text" 
                               name="experiences[${experienceCounter}][title]" 
                               required
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"
                               placeholder="যেমন: সিনিয়র ডেভেলপার">
                    </div>
                    <div>
                        <label class="block text-secondary-200 text-sm font-medium mb-2">প্রতিষ্ঠান *</label>
                        <input type="text" 
                               name="experiences[${experienceCounter}][company]" 
                               required
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"
                               placeholder="যেমন: Google Bangladesh">
                    </div>
                    <div>
                        <label class="block text-secondary-200 text-sm font-medium mb-2">সময়কাল *</label>
                        <input type="text" 
                               name="experiences[${experienceCounter}][duration]" 
                               required
                               class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"
                               placeholder="যেমন: জানুয়ারি ২০২০ - বর্তমান">
                    </div>
                    <div class="flex items-end">
                        <button type="button" 
                                onclick="removeExperience(${experienceCounter})"
                                class="w-full bg-orange text-primary rounded-lg px-4 py-3 font-semibold anim hover:bg-red">
                            <i class="fas fa-trash mr-2"></i>মুছে ফেলুন
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-secondary-200 text-sm font-medium mb-2">বিবরণ</label>
                    <textarea name="experiences[${experienceCounter}][description]" 
                              rows="3"
                              placeholder="এই পদে আপনার দায়িত্ব এবং অর্জন..."
                              class="w-full px-4 py-3 bg-body border border-[#fff]/20 theme-border rounded-lg text-white theme-text-primary placeholder-secondary-200 focus:border-blue focus:ring-2 focus:ring-blue/20 anim"></textarea>
                </div>
            </div>
        `;
        
        document.getElementById('experienceList').insertAdjacentHTML('beforeend', experienceHtml);
    }
    
    function removeExperience(id) {
        const experienceElement = document.getElementById(`experience-${id}`);
        if (experienceElement) {
            experienceElement.remove();
        }
    }
    
    // Make functions global
    window.addExperience = addExperience;
    window.removeExperience = removeExperience;
    
    // Add experience button
    const addExperienceBtn = document.getElementById('addExperienceBtn');
    if (addExperienceBtn) {
        addExperienceBtn.addEventListener('click', addExperience);
    }
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>সংরক্ষণ করছি...';
                
                // Re-enable after 5 seconds as safety
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = submitBtn.innerHTML.replace('<i class="fas fa-spinner fa-spin mr-2"></i>সংরক্ষণ করছি...', '<i class="fas fa-save mr-2"></i>সংরক্ষণ করুন');
                }, 5000);
            }
        });
    });
});
</script>
@endsection