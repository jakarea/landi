@extends('layouts/student-modern')
@section('title', 'প্রোফাইল সেটিংস')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />
<style>
    /* Minimal Bootstrap modal styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1055;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal.fade {
        opacity: 0;
        transition: opacity 0.15s linear;
    }
    .modal.show {
        opacity: 1;
    }
    .modal-dialog {
        position: relative;
        width: auto;
        margin: 1.75rem;
        pointer-events: none;
    }
    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 0.3rem;
        outline: 0;
    }
    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
    }
    .btn {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        text-decoration: none;
    }
    .btn-submit {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-cancel {
        color: #6c757d;
        background-color: transparent;
        border-color: #6c757d;
    }
    .profile-tab-button {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .profile-tab-button.active {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
        border-color: rgba(99, 102, 241, 0.4);
    }
    .profile-tab-button:hover {
        border-color: rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    .profile-tab-button::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        transform: translateX(-100%) translateY(-100%);
        transition: transform 0.8s ease-in-out;
    }
    .profile-tab-button:hover::before {
        transform: translateX(200%) translateY(200%);
    }
    .form-floating {
        position: relative;
    }
    .form-floating input, .form-floating textarea {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(148, 163, 184, 0.2);
        color: white;
    }
    .form-floating input:focus, .form-floating textarea:focus {
        background: rgba(30, 41, 59, 0.7);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .form-floating label {
        color: rgba(148, 163, 184, 0.8);
    }
    .form-floating input:focus ~ label, .form-floating textarea:focus ~ label {
        color: rgba(99, 102, 241, 1);
    }
    .avatar-upload {
        background: rgba(15, 23, 42, 0.7);
        border: 2px dashed rgba(148, 163, 184, 0.3);
        transition: all 0.3s ease;
    }
    .avatar-upload:hover {
        border-color: rgba(99, 102, 241, 0.4);
        background: rgba(99, 102, 241, 0.1);
    }
    .profile-upload-area {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(90, 234, 244, 0.1) 0%, rgba(203, 251, 144, 0.1) 100%);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .avatar-upload {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto;
        border-radius: 50%;
        border: 4px solid rgba(90, 234, 244, 0.3);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    /* if avatarpic has image or value then hide text-powder-blue */
    #avatarpic.has-image + .text-powder-blue {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">প্রোফাইল সেটিংস</h1>
            <p class="text-gray-400">আপনার ব্যক্তিগত তথ্য এবং পাসওয়ার্ড পরিবর্তন করুন</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-800 bg-opacity-50 border border-green-600 text-green-200 px-4 py-3 rounded-lg mb-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-800 bg-opacity-50 border border-red-600 text-red-200 px-4 py-3 rounded-lg mb-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="glass-effect rounded-2xl overflow-hidden">
        <div class="flex border-b border-gray-600">
            <button class="profile-tab-button active flex-1 px-6 py-4 text-left font-medium text-white rounded-none" 
                    id="profile-tab" data-tab="profile">
                <i class="fas fa-user mr-2"></i>
                আমার প্রোফাইল
            </button>
            <button class="profile-tab-button flex-1 px-6 py-4 text-left font-medium text-gray-400 rounded-none" 
                    id="password-tab" data-tab="password">
                <i class="fas fa-lock mr-2"></i>
                পাসওয়ার্ড পরিবর্তন
            </button>
        </div>

        <div class="p-6">
            <div id="profile-content" class="tab-content">
                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <div class="lg:col-span-1">
                            <div class="space-y-6">
                                <div class="text-center">
                                    <div class="relative inline-block">
                                        <div class="avatar-upload profile-upload-container w-40 h-40 rounded-full flex items-center justify-center cursor-pointer relative overflow-hidden">
                                            <input type="file" name="avatar" accept="image/*" id="avatar" class="hidden" onchange="document.getElementById('avatarpic').src = window.URL.createObjectURL(this.files[0])">
                                            
                                            <label for="avatar" class="profile-upload-area">
                                                @if($user->avatar)
                                                    <img src="{{ asset($user->avatar) }}" alt="Profile" class="profile-preview" id="profile-preview">
                                                @else
                                                <img id="avatarpic" />
                                                    <div class="text-center text-gray-400 mt-[35px]">
                                                        <i class="fas fa-camera text-4xl mb-2"></i>
                                                        <p class="text-gray-400 text-sm">ছবি আপলোড করুন</p>
                                                    </div>
                                                @endif
                                            </label>                                            
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-400">JPG, PNG, GIF সমর্থিত</p>
                                            <p class="text-sm text-gray-400">সর্বোচ্চ সাইজ: 3MB</p>
                                        </div>
                                        @error('avatar')
                                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="space-y-3">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" name="recivingMessage" value="1" 
                                               {{ old('recivingMessage', $user->recivingMessage) == 1 ? 'checked' : '' }}
                                               class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 focus:ring-2 bg-gray-700 border-gray-600">
                                        <span class="text-white">বার্তা গ্রহণ করুন</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-3 space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="lg:col-span-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control w-full px-4 py-3 rounded-lg" 
                                               id="name" name="name" value="{{ $user->name }}" 
                                               placeholder="আপনার নাম" required>
                                        <label for="name">পুরো নাম</label>
                                        @error('name')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-floating">
                                        <input type="email" class="form-control w-full px-4 py-3 rounded-lg" 
                                               id="email" name="email" value="{{ $user->email }}" 
                                               placeholder="ইমেইল" required>
                                        <label for="email">ইমেইল ঠিকানা</label>
                                        @error('email')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-floating">
                                        <input type="tel" class="form-control w-full px-4 py-3 rounded-lg" 
                                               id="phone" name="phone" value="{{ $user->phone }}" 
                                               placeholder="ফোন নম্বর" required>
                                        <label for="phone">ফোন নম্বর</label>
                                        @error('phone')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control w-full px-4 py-3 rounded-lg" 
                                               id="company_name" name="company_name" value="{{ $user->company_name }}" 
                                               placeholder="কোম্পানির নাম">
                                        <label for="company_name">কোম্পানির নাম</label>
                                        @error('company_name')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="form-floating">
                                        <input type="url" class="form-control w-full px-4 py-3 rounded-lg" 
                                               id="website" name="website" value="{{ $user->short_bio }}" 
                                               placeholder="ওয়েবসাইট">
                                        <label for="website">ওয়েবসাইট</label>
                                        @error('website')
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <label class="text-white font-medium">সামাজিক মাধ্যমের লিংক</label>
                                    <button type="button" id="social_increment" 
                                            class="text-purple-400 hover:text-purple-300 transition-colors">
                                        <i class="fas fa-plus mr-1"></i>
                                        যোগ করুন
                                    </button>
                                </div>
                                
                                <div id="social-links-container" class="space-y-3">
                                    @php $socialLinks = $user->social_links ? explode(',', $user->social_links) : [''] @endphp
                                    @foreach ($socialLinks as $index => $socialLink)
                                    <div class="social-link-item flex items-center space-x-2">
                                        <div class="form-floating flex-1">
                                            <input type="url" class="form-control w-full px-4 py-3 rounded-lg" 
                                                   name="social_links[]" value="{{ trim($socialLink) }}" 
                                                   placeholder="https://facebook.com/username">
                                            <label>সামাজিক মাধ্যমের লিংক</label>
                                        </div>
                                        @if($index > 0 || count($socialLinks) > 1)
                                        <button type="button" onclick="removeSocialLink(this)" 
                                                class="text-red-400 hover:text-red-300 p-2 transition-colors">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @error('social_links')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <div class="form-floating">
                                    <textarea class="form-control w-full px-4 py-3 rounded-lg h-32 resize-none" 
                                              id="description" name="description" 
                                              placeholder="নিজের সম্পর্কে লিখুন..." required>{{ $user->description }}</textarea>
                                    <label for="description">আমার সম্পর্কে</label>
                                    @error('description')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4 pt-4">
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover">
                                    <i class="fas fa-save mr-2"></i>
                                    পরিবর্তন সংরক্ষণ করুন
                                </button>
                                <button type="button" onclick="history.back()" 
                                        class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    বাতিল
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            
            <div id="password-content" class="tab-content hidden">
                <form action="{{ route('student.profile.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div>
                            <div class="form-floating">
                                <input type="email" class="form-control w-full px-4 py-3 rounded-lg" 
                                       id="current-email" value="{{ $user->email }}" disabled>
                                <label for="current-email">বর্তমান ইমেইল</label>
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-floating relative">
                                <input type="password" class="form-control w-full px-4 py-3 rounded-lg pr-12" 
                                       id="password" name="password" placeholder="নতুন পাসওয়ার্ড" required>
                                <label for="password">নতুন পাসওয়ার্ড</label>
                                <button type="button" onclick="togglePassword('password', 'eye-click')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="eye-click"></i>
                                </button>
                                @error('password')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-floating relative">
                                <input type="password" class="form-control w-full px-4 py-3 rounded-lg pr-12" 
                                       id="password_confirmation" name="password_confirmation" placeholder="পাসওয়ার্ড নিশ্চিত করুন" required>
                                <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye-click2')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="eye-click2"></i>
                                </button>
                                @error('password_confirmation')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 pt-4">
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover">
                            <i class="fas fa-save mr-2"></i>
                            পাসওয়ার্ড পরিবর্তন করুন
                        </button>
                        <button type="button" onclick="history.back()" 
                                class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            বাতিল
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="{{ asset('assets/js/crop-image.js') }}"></script>
<script src="{{ asset('assets/js/form-change.js') }}"></script>

<script>
// Simple tab switching functionality
function switchTab(tabName) {
    console.log('Switching to tab:', tabName);
    
    // Reset all tabs
    document.getElementById('profile-tab').classList.remove('active', 'text-white');
    document.getElementById('profile-tab').classList.add('text-gray-400');
    document.getElementById('password-tab').classList.remove('active', 'text-white'); 
    document.getElementById('password-tab').classList.add('text-gray-400');
    
    // Hide all content
    document.getElementById('profile-content').classList.add('hidden');
    document.getElementById('password-content').classList.add('hidden');
    
    // Show selected tab
    if (tabName === 'profile') {
        document.getElementById('profile-tab').classList.add('active', 'text-white');
        document.getElementById('profile-tab').classList.remove('text-gray-400');
        document.getElementById('profile-content').classList.remove('hidden');
    } else if (tabName === 'password') {
        document.getElementById('password-tab').classList.add('active', 'text-white');
        document.getElementById('password-tab').classList.remove('text-gray-400');
        document.getElementById('password-content').classList.remove('hidden');
    }
    
    updateURL(tabName);
}

function updateURL(tab) {
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.pushState(null, '', url);
}

// Password visibility toggle
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Social links management
function addSocialLink() {
    const container = document.getElementById('social-links-container');
    const newItem = document.createElement('div');
    newItem.className = 'social-link-item flex items-center space-x-2';
    
    newItem.innerHTML = `
        <div class="form-floating flex-1">
            <input type="url" class="form-control w-full px-4 py-3 rounded-lg" 
                   name="social_links[]" value="" placeholder="https://facebook.com/username">
            <label>সামাজিক মাধ্যমের লিংক</label>
        </div>
        <button type="button" onclick="removeSocialLink(this)" 
                class="text-red-400 hover:text-red-300 p-2 transition-colors">
            <i class="fas fa-minus"></i>
        </button>
    `;
    
    container.appendChild(newItem);
}

function removeSocialLink(button) {
    const container = document.getElementById('social-links-container');
    const item = button.closest('.social-link-item');
    
    // Don't remove if it's the only item
    if (container.children.length > 1) {
        container.removeChild(item);
    }
}

// Override the crop-image.js cropImageBtn handler to also handle our placeholder
// $(document).off('click', '#cropImageBtn').on('click', '#cropImageBtn', function (ev) {
//     $uploadCrop.croppie('result', {
//         type: 'base64',
//         backgroundColor: "#000000",
//         format: 'png',
//         size: { width: 260, height: 260 }
//     }).then(function (resp) {
//         $('#item-img-output').attr('src', resp);
//         $('#base64_avatar').attr('value', resp);
        
//         // Show preview and hide placeholder
//         const preview = document.getElementById('item-img-output');
//         const placeholder = document.getElementById('avatar-placeholder');
//         if (preview) {
//             preview.classList.remove('hidden');
//         }
//         if (placeholder) {
//             placeholder.classList.add('hidden');
//         }
        
//         $('#cropImagePop').modal('hide');
//         $('.item-img').val('');
//     });
// });

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check for password validation errors by looking for actual error elements
    const passwordErrors = document.querySelector('#password-content .text-red-400') !== null;
    
    // Handle URL tab parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tabToOpen = urlParams.get('tab');
    
    // Auto-switch to password tab if there are password validation errors or tab parameter
    if (passwordErrors || tabToOpen === 'password') {
        console.log('Opening password tab due to:', passwordErrors ? 'validation errors' : 'URL parameter');
        switchTab('password');
    } else {
        console.log('Opening profile tab (default)');
        switchTab('profile');
    }
    
    // Add event listeners
    document.getElementById('social_increment').addEventListener('click', addSocialLink);
    
    // Simple tab event listeners
    document.getElementById('profile-tab').onclick = function() {
        switchTab('profile');
    };
    
    document.getElementById('password-tab').onclick = function() {
        switchTab('password');
    };
});
</script>
@endpush
@endsection
