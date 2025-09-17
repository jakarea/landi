@extends('layouts/student-modern')
@section('title', 'আমার প্রোফাইল')

@php
use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
/* Cover Photo Upload Styling */
    .profile-cover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        position: relative;
        overflow: hidden;
    }
    .profile-cover:hover {
        border-color: rgba(99, 102, 241, 0.4);
    }
    .profile-cover::before {
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
    .profile-cover:hover::before {
        transform: translateX(200%) translateY(200%);
    }
    .contact-card {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .contact-card:hover {
        border-color: rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    .contact-card::before {
        content: '';
        position: absolute;
        top: -100%;
    }
    .contact-card::before {
        transform: translateX(-100%) translateY(-100%);
        transition: transform 0.8s ease-in-out;
    }
    .contact-card:hover::before {
        transform: translateX(200%) translateY(200%);
    }
    .enrollment-table {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(148, 163, 184, 0.2);
        backdrop-filter: blur(12px);
    }
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
    opacity: 0.8 !important;
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

.cover-container:hover .upload-overlay {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
}

/* Ensure the overlay stays visible when hovering over the button itself */
.upload-overlay:hover {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
}

/* Like button styles */
.like-btn.active {
    background-color: #dc2626 !important;
    color: white !important;
}

.like-btn.active:hover {
    background-color: #b91c1c !important;
}
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">


    <!-- Cover Photo Section - SIMPLIFIED -->
    <div class="cover-container" style="position: relative; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 16px; overflow: hidden; height: 200px;">
        @if ($user->cover_photo)
            <img src="{{ asset($user->cover_photo) }}" alt="Cover Photo" 
                 style="width: 100%; height: 100%; object-fit: cover;" id="item-img-output">
        @else
            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white;">
                <div style="text-align: center;">
                    <i class="fas fa-image" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.7;"></i>
                    <p style="opacity: 0.8;">কোনো কভার ফটো আপলোড করা হয়নি</p>
                </div>
            </div>
        @endif
        
        <!-- Upload Overlay - HOVER ONLY -->
        <div class="upload-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6) !important; display: flex !important; align-items: center; justify-content: center; opacity: 0 !important; transition: all 0.3s ease; z-index: 10; pointer-events: none;">
            <!-- Make file input look like a button -->
            <label for="coverImage" style="background: linear-gradient(135deg, #10b981, #059669) !important; color: white !important; border: none !important; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex !important; align-items: center; z-index: 11; pointer-events: auto;">
                <i class="fas fa-camera" style="margin-right: 8px; color: white !important;"></i>
                <span style="color: white !important;">কভার ফটো পরিবর্তন করুন</span>
            </label>
        </div>
        
        <input type="file" id="coverImage" accept="image/png, image/jpeg, image/svg+xml" name="cover_photo" style="position: absolute; opacity: 0; width: 0; height: 0; overflow: hidden;"
        
        <!-- Upload Action Buttons -->
        <div style="position: absolute; top: 16px; right: 16px; display: none; z-index: 20;" id="uploadActions">
            <button id="cancelBtn" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 6px; margin-right: 8px; cursor: pointer;">
                বাতিল
            </button>
            <button id="uploadBtn" style="padding: 8px 16px; background: #8b5cf6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                সেভ করুন
            </button>
        </div>
    </div>

    <!-- Hidden input for base64 data -->
    <input type="hidden" name="coverImgBase64" id="coverImgBase64">
        
        <div class="relative -mt-16 px-6 pb-6">
            <div class="flex items-end space-x-6">
                <div class="relative">
                    @if ($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" 
                             class="w-32 h-32 rounded-full border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                            <span class="text-white text-3xl font-bold">{!! strtoupper($user->name[0]) !!}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 pb-4">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $user->name }}</h1>
                    <p class="text-gray-400 capitalize mb-4">{{ $user->user_role }}</p>
                </div>
                <div class="pb-4">
                    <a href="{{ url('student/profile/edit') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover">
                        <i class="fas fa-edit mr-2"></i>
                        প্রোফাইল সম্পাদনা
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($user->description)
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-3 text-purple-400"></i>
                    আমার সম্পর্কে
                </h2>
                <div class="text-gray-300 leading-relaxed">
                    {!! $user->description !!}
                </div>
            </div>
            @endif
            
            <div class="glass-effect rounded-2xl p-6 ray-hover glow-card">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-purple-400"></i>
                    নথিভুক্ত কোর্সের তালিকা
                    <span class="ml-2 bg-purple-600 text-xs px-2 py-1 rounded-full">{{ count($allEnrollments) }}</span>
                </h2>
                
                @if(count($allEnrollments) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-gray-600">
                            <tr class="text-gray-400">
                                <th class="text-left p-3">ক্রম</th>
                                <th class="text-left p-3">পেমেন্ট আইডি</th>
                                <th class="text-left p-3">কোর্সের নাম</th>
                                <th class="text-left p-3">প্রশিক্ষক</th>
                                <th class="text-left p-3">পেমেন্টের তারিখ</th>
                                <th class="text-left p-3">পরিমাণ</th>
                                <th class="text-left p-3">অবস্থা</th>
                                <th class="text-left p-3">পছন্দ</th>
                                <th class="text-left p-3">কার্যক্রম</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            @foreach ($allEnrollments as $key => $enrollment)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="p-3 text-gray-300">{{ $key + 1 }}</td>
                                <td class="p-3 text-gray-300">#{{ $enrollment['id'] }}</td>
                                <td class="p-3">
                                    <div class="text-white font-medium">{{ Str::limit($enrollment['course']->title, 40) }}</div>
                                </td>
                                <td class="p-3 text-gray-300">{{ $enrollment['instructor']->name }}</td>
                                <td class="p-3 text-gray-300">{{ $enrollment['date']->format('d M Y') }}</td>
                                <td class="p-3">
                                    @if($enrollment['amount'] > 0)
                                        <span class="text-green-400 font-semibold">৳ {{ number_format($enrollment['amount']) }}</span>
                                    @else
                                        <span class="text-blue-400 font-semibold">বিনামূল্যে</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if ($enrollment['status'] == 'Paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300 border border-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            পরিশোধিত
                                        </span>
                                    @elseif ($enrollment['status'] == 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-300 border border-blue-600">
                                            <i class="fas fa-check-double mr-1"></i>
                                            সম্পন্ন
                                        </span>
                                    @elseif ($enrollment['status'] == 'Free Access')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-900 text-cyan-300 border border-cyan-600">
                                            <i class="fas fa-gift mr-1"></i>
                                            বিনামূল্যে
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-300 border border-red-600">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            ব্যর্থ
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <!-- Like Button -->
                                    <button class="like-btn p-2 rounded-lg transition-all duration-300 {{ in_array($enrollment['course']->id, $userLikes) ? 'bg-red-600 text-white active' : 'bg-gray-700 text-gray-400 hover:text-red-400' }}" 
                                            data-course-id="{{ $enrollment['course']->id }}"
                                            data-instructor-id="{{ $enrollment['instructor']->id }}"
                                            onclick="toggleCourseLike(this)">
                                        <i class="fas fa-heart text-sm"></i>
                                    </button>
                                </td>
                                <td class="p-3">
                                    <a href="{{ url('student/courses/'.$enrollment['course']->slug.'/learn') }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300">
                                        <i class="fas fa-play mr-1"></i>
                                        কোর্স দেখুন
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="text-gray-500 mb-4">
                        <i class="fas fa-graduation-cap text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-400 mb-2">কোনো কোর্স নেই</h3>
                    <p class="text-gray-500 mb-6">আপনি এখনো কোনো কোর্সে ভর্তি হননি।</p>
                    <a href="{{ route('student.courses') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300">
                        <i class="fas fa-search mr-2"></i>
                        কোর্স খুঁজুন
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <div class="space-y-6">
            <div class="contact-card rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-address-book mr-3 text-purple-400"></i>
                    যোগায়োগের তথ্য
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-600/20 flex items-center justify-center">
                            <i class="fas fa-envelope text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">ইমেইল</p>
                            <a href="mailto:{{ $user->email }}" class="text-white hover:text-purple-400 transition-colors">{{ $user->email }}</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-green-600/20 flex items-center justify-center">
                            <i class="fas fa-phone text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">ফোন</p>
                            <p class="text-white">{{ $user->phone ?: 'যোগ করা হয়নি' }}</p>
                        </div>
                    </div>
                    
                    @if($user->short_bio)
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-600/20 flex items-center justify-center">
                            <i class="fas fa-globe text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">ওয়েবসাইট</p>
                            <p class="text-white">{{ $user->short_bio }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @php
                    $social_links = $user->social_links ? explode(",", $user->social_links) : [];
                    @endphp

                    @foreach ($social_links as $social_link)
                        @if(trim($social_link))
                            @php
                            $url = trim($social_link);
                            $host = parse_url($url, PHP_URL_HOST);
                            $domain = Str::after($host ?? '', 'www.');
                            $domain = Str::before($domain, '.');
                            @endphp

                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg bg-gray-600/20 flex items-center justify-center">
                                    @if ($domain == 'linkedin')
                                        <i class="fab fa-linkedin text-blue-500"></i>
                                    @elseif ($domain == 'instagram')
                                        <i class="fab fa-instagram text-pink-500"></i>
                                    @elseif ($domain == 'twitter')
                                        <i class="fab fa-twitter text-blue-400"></i>
                                    @elseif ($domain == 'facebook')
                                        <i class="fab fa-facebook text-blue-600"></i>
                                    @else
                                        <i class="fas fa-globe text-gray-400"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400 capitalize">{{ $domain ?: 'ওয়েবসাইট' }}</p>
                                    <a href="{{ $url }}" target="_blank" class="text-white hover:text-purple-400 transition-colors text-sm break-all">{{ $url }}</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
@endpush

<script>

document.addEventListener('DOMContentLoaded', function () {
    
    const coverImgOutput = document.getElementById('item-img-output');
    const uploadBtn = document.getElementById('uploadBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const uploadActions = document.getElementById('uploadActions');
    const coverImgBase64 = document.getElementById('coverImgBase64');
    const coverImageInput = document.getElementById('coverImage');
    
    
    if (!coverImageInput) {
        console.error('❌ CRITICAL: coverImageInput element not found!');
        return;
    }
    
    if (!uploadActions) {
        console.error('❌ CRITICAL: uploadActions element not found!');
        return;
    }
    

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
                    newImg.style.width = '100%';
                    newImg.style.height = '100%';
                    newImg.style.objectFit = 'cover';
                    newImg.id = 'item-img-output';
                    
                    // Find the cover photo container and add the image
                    const coverContainer = document.querySelector('input[id="coverImage"]').closest('div');
                    if (coverContainer) {
                        coverContainer.prepend(newImg);
                    } else {
                    }
                }
                
                // Store base64 data
                if (coverImgBase64) {
                    coverImgBase64.value = e.target.result;
                } else {
                }
                
                // Show action buttons
                if (uploadActions) {
                    uploadActions.classList.remove('hidden');
                    uploadActions.style.display = 'block';
                } else {
                }
            };
            
            reader.readAsDataURL(file);
        } else {
        }
    });

    // Handle upload button click
    uploadBtn.addEventListener('click', function () {
        const fileBase64 = coverImgBase64.value;
        
        if (fileBase64) {
            uploadFile(fileBase64);
        } else {
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

        const uploadURL = `${baseUrl}/student/profile/cover`;

        fetch(uploadURL, {
            method: 'POST',
            body: JSON.stringify(requestData),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => {
            
            return response.json();
        })
        .then(data => {
            
            if (data.message === 'UPLOADED') {
                // Success
                uploadBtn.innerHTML = '<i class="fas fa-check mr-2"></i>সফল হয়েছে';
                uploadBtn.className = 'px-4 py-2 bg-green-500 text-white rounded-lg font-semibold';
                
                setTimeout(() => {
                    uploadActions.classList.add('hidden');
                    uploadBtn.innerHTML = 'সেভ করুন';
                    uploadBtn.className = 'px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold';
                    uploadBtn.disabled = false;
                    cancelBtn.style.display = 'block';
                    
                    showAlert('কভার ফটো সফলভাবে আপলোড হয়েছে!', 'success');
                }, 2000);
            } else {
                throw new Error('Upload failed - unexpected response: ' + JSON.stringify(data));
            }
        })
        .catch(error => {
            
            uploadBtn.innerHTML = '<i class="fas fa-times mr-2"></i>ব্যর্থ';
            uploadBtn.className = 'px-4 py-2 bg-red-500 text-white rounded-lg font-semibold';
            cancelBtn.style.display = 'block';
            uploadBtn.disabled = false;
            
            showAlert('কভার ফটো আপলোড করতে সমস্যা হয়েছে: ' + error.message, 'error');
            
            setTimeout(() => {
                uploadBtn.innerHTML = 'সেভ করুন';
                uploadBtn.className = 'px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold';
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
            type === 'error' ? 'bg-red-500/20 border-red-500 text-red-500' : 
            type === 'success' ? 'bg-green-500/20 border-green-500 text-green-500' :
            'bg-blue-500/20 border-blue-500 text-blue-500'
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

// Like functionality for profile page
function toggleCourseLike(button) {
    const courseId = button.getAttribute('data-course-id');
    const instructorId = button.getAttribute('data-instructor-id');
    
    const currentURL = window.location.href;
    const baseUrl = currentURL.split('/').slice(0, 3).join('/');
    
    // Disable button during request
    button.disabled = true;
    
    fetch(`${baseUrl}/student/course-like/${courseId}/${instructorId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
    .then(response => {
        if (response.status === 302 || response.status === 401) {
            window.location.href = '/login';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (!data) return; // Prevent errors if redirected
        
        if (data.message === 'liked') {
            button.classList.add('active');
            button.classList.remove('bg-gray-700', 'text-gray-400');
            button.classList.add('bg-red-600', 'text-white');
        } else {
            button.classList.remove('active');
            button.classList.remove('bg-red-600', 'text-white');
            button.classList.add('bg-gray-700', 'text-gray-400');
        }
    })
    .catch(error => {
        // Handle error silently
    })
    .finally(() => {
        button.disabled = false;
    });
}
</script>
@endsection
