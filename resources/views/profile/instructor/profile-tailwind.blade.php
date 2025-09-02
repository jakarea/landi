@extends('layouts.instructor-tailwind')
@section('title', 'আমার প্রোফাইল')
@section('header-title', 'প্রোফাইল')
@section('header-subtitle', 'আপনার প্রোফাইল তথ্য এবং অভিজ্ঞতা দেখুন')

@section('style')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />

<style>
/* Cover Photo Upload Styling */
.cover-upload-area {
    position: relative;
    overflow: hidden;
    border-radius: 1rem;
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    object-fit: cover;
    object-position: center;
    max-height: 250px;
}

.cover-upload-area:hover .upload-overlay {
    opacity: 1;
    backdrop-filter: blur(8px);
}

.upload-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-btn {
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    color: #091D3D;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(90, 234, 244, 0.4);
}

/* Avatar Styling */
.avatar-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin-top: -60px;
    margin-left: 2rem;
    z-index: 10;
}

.avatar-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #091D3D;
    object-fit: cover;
}

.avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #091D3D;
    background: linear-gradient(135deg, #5AEAF4 0%, #CBFB90 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: bold;
    color: #091D3D;
}

/* Experience Card Styling */
.experience-card {
    background: var(--color-card);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.experience-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    border-color: rgba(90, 234, 244, 0.3);
}

/* Contact Info Styling */
.contact-item {
    background: var(--color-card);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    transition: all 0.3s ease;
}

.contact-item:hover {
    border-color: rgba(90, 234, 244, 0.3);
    background: rgba(255, 255, 255, 0.02);
}

/* Social Media Icons */
.social-icon {
    width: 24px;
    height: 24px;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.social-icon:hover {
    opacity: 1;
}

/* No Data State */
.no-data-state {
    background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
    border: 2px dashed rgba(90, 234, 244, 0.3);
    border-radius: 1rem;
    padding: 3rem;
    text-align: center;
}

:root.light-theme .no-data-state {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-color: rgba(59, 130, 246, 0.3);
}

/* Action Buttons */
.action-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ABABAB;
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--color-blue);
    color: var(--color-primary);
    border-color: var(--color-blue);
    transform: translateY(-1px);
}

.action-btn.delete:hover {
    background: var(--color-orange);
    border-color: var(--color-orange);
}
</style>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Profile Header Section -->
    <div class="bg-card rounded-xl border border-[#fff]/20 overflow-hidden">
        <!-- Cover Photo Section -->
        <div class="cover-upload-area relative max-h-64">
            @if ($user->cover_photo)
                <img src="{{ asset($user->cover_photo) }}" alt="Cover Photo" 
                     class="w-full h-full object-cover" id="item-img-output">
            @else
                <div class="w-full h-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-image text-6xl text-secondary-100 mb-4"></i>
                        <p class="text-secondary-100">কোনো কভার ফটো আপলোড করা হয়নি</p>
                    </div>
                </div>
            @endif
            
            <div class="upload-overlay">
                <button class="upload-btn" onclick="document.getElementById('coverImage').click()">
                    <i class="fas fa-camera mr-2"></i>
                    কভার ফটো পরিবর্তন করুন
                </button>
            </div>
            
            <input type="file" class="hidden" id="coverImage"
                   accept="image/png, image/jpeg, image/svg+xml" name="cover_photo">
            <input type="hidden" name="coverImgBase64" id="coverImgBase64">
            
            <!-- Upload Action Buttons -->
            <div class="absolute top-4 right-4 hidden" id="uploadActions">
                <div class="flex gap-2">
                    <button id="cancelBtn" class="px-4 py-2 bg-secondary hover:bg-secondary/80 text-secondary-100 rounded-lg anim">
                        বাতিল
                    </button>
                    <button id="uploadBtn" class="px-4 py-2 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim">
                        সেভ করুন
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Profile Info Section -->
        <div class="px-8 pb-8" style="padding-bottom: 24px; padding-top: 10px;">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between">
                <!-- Avatar and Name -->
                <div class="flex items-end gap-6">
                    <div class="avatar-container flex-shrink-0">
                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar_img) }}" alt="{{ $user->name }}" 
                                 class="avatar-image">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper($user->name[0]) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="pb-4">
                        <h1 class="text-white font-bold text-3xl mb-2">{{ $user->name }}</h1>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-blue to-lime text-primary rounded-full text-sm font-semibold">
                                {{ ucwords(str_replace('_', ' ', $user->user_role)) }}
                            </span>
                            <span class="text-secondary-200 text-sm">
                                যোগ দিয়েছেন {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Profile Button -->
                <div class="pb-4 mt-4 lg:mt-2">
                    <a href="{{ route('instructor.profile.edit') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue to-lime hover:from-blue/80 hover:to-lime/80 text-primary rounded-lg font-semibold anim">
                        <i class="fas fa-edit"></i>
                        <span>প্রোফাইল সম্পাদনা</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- About Section -->
            <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <h2 class="text-white font-semibold text-xl">আমার সম্পর্কে</h2>
                </div>
                
                @if($user->description)
                    <div class="prose prose-invert max-w-none">
                        <div class="text-secondary-100 leading-relaxed">
                            {!! $user->description !!}
                        </div>
                    </div>
                @else
                    <div class="no-data-state">
                        <i class="fas fa-pen-alt text-4xl text-blue mb-4"></i>
                        <h3 class="text-white font-semibold mb-2">কোনো বিবরণ যোগ করা হয়নি</h3>
                        <p class="text-secondary-200 mb-4">আপনার সম্পর্কে কিছু লিখুন যা অন্যদের আকৃষ্ট করবে।</p>
                        <a href="{{ route('instructor.profile.edit') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim">
                            <i class="fas fa-plus"></i>
                            <span>বিবরণ যোগ করুন</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Experience Section -->
            <div class="bg-card rounded-xl border border-[#fff]/20 p-6 mt-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-briefcase text-white"></i>
                        </div>
                        <h2 class="text-white font-semibold text-xl">অভিজ্ঞতা</h2>
                    </div>
                    
                    <a href="{{ route('instructor.profile.settings') }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue to-lime hover:from-blue/80 hover:to-lime/80 text-primary rounded-lg font-semibold anim">
                        <i class="fas fa-plus"></i>
                        <span class="hidden sm:inline">নতুন যোগ করুন</span>
                    </a>
                </div>
                
                @if (count($experiences) > 0)
                    <div class="space-y-4">
                        @foreach ($experiences as $experience)
                            <div class="experience-card p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue to-lime rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-building text-primary"></i>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-white font-semibold text-lg mb-1">{{ $experience->profession }}</h3>
                                                <div class="flex items-center gap-2 text-secondary-200 text-sm mb-3">
                                                    <span class="font-medium">{{ $experience->company_name }}</span>
                                                    <i class="fas fa-circle text-xs"></i>
                                                    <span>{{ $experience->job_type }}</span>
                                                    <i class="fas fa-circle text-xs"></i>
                                                    <span>{{ $experience->experience }}</span>
                                                </div>
                                                <p class="text-secondary-100 leading-relaxed">{{ $experience->short_description }}</p>
                                            </div>
                                            
                                            <div class="flex items-center gap-2 ml-4 hidden">
                                                <a href="{{ route('instructor.profile.experience.edit', ['experienceId' => $experience->id]) }}?tab=experience"
                                                   class="action-btn" title="সম্পাদনা করুন">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                                
                                                <form method="POST" action="{{ route('instructor.profile.experience.delete', ['experienceId' => $experience->id]) }}" 
                                                      class="inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই অভিজ্ঞতা মুছে ফেলতে চান?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" title="মুছে ফেলুন">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-data-state">
                        <i class="fas fa-briefcase text-4xl text-purple-400 mb-4"></i>
                        <h3 class="text-white font-semibold mb-2">কোনো অভিজ্ঞতা যোগ করা হয়নি</h3>
                        <p class="text-secondary-200 mb-4">আপনার পেশাগত অভিজ্ঞতা যোগ করুন যা আপনার দক্ষতা প্রদর্শন করবে।</p>
                        <a href="{{ route('instructor.profile.settings') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-semibold anim">
                            <i class="fas fa-plus"></i>
                            <span>অভিজ্ঞতা যোগ করুন</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Information -->
            <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-address-book text-white"></i>
                    </div>
                    <h2 class="text-white font-semibold text-xl">যোগাযোগ</h2>
                </div>
                
                <div class="space-y-4">
                    <!-- Email -->
                    <div class="contact-item">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-blue"></i>
                            </div>
                            <div>
                                <p class="text-secondary-200 text-sm">ইমেইল</p>
                                <a href="mailto:{{ $user->email }}" class="text-white hover:text-blue anim">
                                    {{ $user->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    @if ($user->phone)
                        <div class="contact-item">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-green-500"></i>
                                </div>
                                <div>
                                    <p class="text-secondary-200 text-sm">ফোন</p>
                                    <a href="tel:{{ $user->phone }}" class="text-white hover:text-green-500 anim">
                                        {{ $user->phone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Website -->
                    @if ($user->short_bio)
                        <div class="contact-item">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-lime/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-globe text-lime"></i>
                                </div>
                                <div>
                                    <p class="text-secondary-200 text-sm">ওয়েবসাইট</p>
                                    @php
                                        $website = $user->short_bio;
                                        $urlPrefix = 'https://www.';
                                        $formattedWebsite = \Illuminate\Support\Str::startsWith($website, $urlPrefix) ? $website : $urlPrefix . $website;
                                    @endphp
                                    <a href="{{ $formattedWebsite }}" target="_blank" class="text-white hover:text-lime anim">
                                        {{ $formattedWebsite }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Social Media Links -->
            @php
                $social_links = explode(",", $user->social_links);
                use Illuminate\Support\Str;
                $validSocialLinks = array_filter($social_links, function($link) {
                    return !empty(trim($link));
                });
            @endphp
            
            @if(count($validSocialLinks) > 0)
                <div class="bg-card rounded-xl border border-[#fff]/20 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="text-white font-semibold text-xl">সামাজিক মাধ্যম</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach ($validSocialLinks as $social_link)
                            @php
                                $url = trim($social_link);
                                if(empty($url)) continue;
                                
                                $host = parse_url($url, PHP_URL_HOST);
                                $domain = Str::after($host, 'www.');
                                $domain = Str::before($domain, '.');
                            @endphp
                            
                            <div class="contact-item">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                        {{ $domain == 'linkedin' ? 'bg-blue-600/20' : '' }}
                                        {{ $domain == 'instagram' ? 'bg-pink-500/20' : '' }}
                                        {{ $domain == 'twitter' ? 'bg-sky-500/20' : '' }}
                                        {{ $domain == 'facebook' ? 'bg-blue-700/20' : '' }}
                                        {{ !in_array($domain, ['linkedin', 'instagram', 'twitter', 'facebook']) ? 'bg-gray-500/20' : '' }}">
                                        
                                        @if ($domain == 'linkedin')
                                            <i class="fab fa-linkedin text-blue-600"></i>
                                        @elseif ($domain == 'instagram')
                                            <i class="fab fa-instagram text-pink-500"></i>
                                        @elseif ($domain == 'twitter')
                                            <i class="fab fa-x-twitter text-sky-500"></i>
                                        @elseif ($domain == 'facebook')
                                            <i class="fab fa-facebook text-blue-700"></i>
                                        @else
                                            <i class="fas fa-link text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-secondary-200 text-sm capitalize">{{ $domain ?: 'লিংক' }}</p>
                                        <a href="{{ $url }}" target="_blank" class="text-white hover:text-blue anim text-sm">
                                            {{ Str::limit($url, 30) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Banner Resize Modal -->
@include('modals.banner-resize')
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const coverImgOutput = document.getElementById('item-img-output');
    const uploadBtn = document.getElementById('uploadBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const uploadActions = document.getElementById('uploadActions');
    const coverImgBase64 = document.getElementById('coverImgBase64');
    const coverImageInput = document.getElementById('coverImage');

    // Handle file selection
    coverImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Show preview
                if (coverImgOutput) {
                    coverImgOutput.src = e.target.result;
                } else {
                    // Create new img element if it doesn't exist
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'w-full h-full object-cover';
                    newImg.id = 'item-img-output';
                    document.querySelector('.cover-upload-area').prepend(newImg);
                }
                
                // Store base64 data
                coverImgBase64.value = e.target.result;
                
                // Show action buttons
                uploadActions.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle upload button click
    uploadBtn.addEventListener('click', function () {
        const fileBase64 = coverImgBase64.value;
        if (fileBase64) {
            uploadFile(fileBase64);
        }
    });

    // Handle cancel button click
    cancelBtn.addEventListener('click', function () {
        cancelUpload();
    });

    // Function to handle file upload
    function uploadFile(fileBase64) {
        const currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');

        const userId = "{{ $user->id }}";
        const requestData = {
            cover_photo: fileBase64,
            userId: userId,
        };

        // Update button state
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>আপলোড হচ্ছে...';
        uploadBtn.disabled = true;
        cancelBtn.style.display = 'none';

        fetch(`${baseUrl}/instructor/profile/cover`, {
            method: 'POST',
            body: JSON.stringify(requestData),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'UPLOADED') {
                // Success
                uploadBtn.innerHTML = '<i class="fas fa-check mr-2"></i>সফল হয়েছে';
                uploadBtn.className = 'px-4 py-2 bg-green-500 text-white rounded-lg font-semibold';
                
                setTimeout(() => {
                    uploadActions.classList.add('hidden');
                    uploadBtn.innerHTML = 'সেভ করুন';
                    uploadBtn.className = 'px-4 py-2 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim';
                    uploadBtn.disabled = false;
                    cancelBtn.style.display = 'block';
                    
                    showAlert('কভার ফটো সফলভাবে আপলোড হয়েছে!', 'success');
                }, 2000);
            } else {
                throw new Error('Upload failed');
            }
        })
        .catch(error => {
            uploadBtn.innerHTML = '<i class="fas fa-times mr-2"></i>ব্যর্থ';
            uploadBtn.className = 'px-4 py-2 bg-orange text-primary rounded-lg font-semibold';
            cancelBtn.style.display = 'block';
            uploadBtn.disabled = false;
            
            showAlert('কভার ফটো আপলোড করতে সমস্যা হয়েছে', 'error');
            
            setTimeout(() => {
                uploadBtn.innerHTML = 'সেভ করুন';
                uploadBtn.className = 'px-4 py-2 bg-blue hover:bg-blue/80 text-primary rounded-lg font-semibold anim';
            }, 3000);
        });
    }

    // Function to handle cancel button click
    function cancelUpload() {
        const userCoverPhoto = "{{ $user->cover_photo ?? null }}";
        
        if (coverImgOutput) {
            if (userCoverPhoto) {
                coverImgOutput.src = "{{ asset('') }}" + userCoverPhoto;
            } else {
                // Remove the image and show placeholder
                coverImgOutput.remove();
            }
        }
        
        coverImgBase64.value = '';
        coverImageInput.value = '';
        uploadActions.classList.add('hidden');
    }
    
    // Alert function
    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-lg border max-w-sm ${
            type === 'error' ? 'bg-orange/20 border-orange text-orange' : 
            type === 'success' ? 'bg-green-500/20 border-green-500 text-green-500' :
            'bg-blue/20 border-blue text-blue'
        }`;
        
        alertDiv.innerHTML = `
            <div class="flex items-start gap-3">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} mt-0.5"></i>
                <div class="flex-1">${message}</div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 hover:opacity-70">
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
});
</script>
@endsection