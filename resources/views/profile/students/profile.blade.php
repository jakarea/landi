@extends('layouts/student-modern')
@section('title', 'আমার প্রোফাইল')

@php
use Illuminate\Support\Str;
@endphp

@push('styles')
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
<style>
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
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
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
    .upload-overlay {
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .profile-cover:hover .upload-overlay {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    <div class="profile-cover rounded-2xl overflow-hidden relative" id="coverImgContainer">
        <div class="h-48 bg-cover bg-center relative">
            @if ($user->cover_photo)
                <img src="{{ asset($user->cover_photo) }}" alt="Cover Photo" 
                     class="w-full h-48 object-cover" id="item-img-output">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center" id="item-img-output">
                    <i class="fas fa-image text-white text-4xl opacity-50"></i>
                </div>
            @endif
            
            <input type="file" class="hidden" id="coverImage"
                   accept="image/png, image/jpeg, image/svg+xml" name="cover_photo">
            <input type="hidden" name="coverImgBase64" id="coverImgBase64">
            
            <div class="upload-overlay absolute inset-0 flex items-center justify-center">
                <label class="cursor-pointer bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg hover:bg-opacity-70 transition-all duration-300" for="coverImage">
                    <i class="fas fa-camera mr-2"></i>
                    কভার ফটো পরিবর্তন করুন
                </label>
            </div>
            
            <div class="absolute bottom-4 right-4 space-x-2">
                <button id="cancelBtn" class="hidden px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors" type="button">বাতিল</button>
                <button id="uploadBtn" class="hidden px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors" type="button">সংরক্ষণ</button>
            </div>
        </div>
        
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

{{-- upload banner modal start --}}
@include('modals/banner-resize')
{{-- upload banner modal end --}}

@push('scripts')
<script src='https://foliotek.github.io/Croppie/croppie.js'></script>
{{-- crop banenr image js --}}
<script src="{{ asset('assets/js/banner-crop.js') }}"></script>
{{-- set user cover photo js --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const coverImgOutput = document.getElementById('item-img-output');
    const uploadBtn = document.getElementById('uploadBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    // Handle upload button click
    const coverImgBase64 = document.getElementById('coverImgBase64');
    uploadBtn.addEventListener('click', function () {
        let fileBase64 = coverImgBase64.value;
        uploadFile(fileBase64);
    });

    // Handle cancel button click
    cancelBtn.addEventListener('click', function () {
        cancelUpload();
    });

    // Function to handle file upload
    function uploadFile(fileBase64) {

        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');

        if (fileBase64) {
            const userId = "{{ $user->id }}";
            const requestData = {
                cover_photo: fileBase64,
                userId: userId,
            };
            cancelBtn.classList.add('hidden');
            uploadBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin-pulse"></i> Uploading`;

            fetch(`${baseUrl}/student/profile/cover`, {
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
                        uploadBtn.innerHTML = `সংরক্ষণ`;
                        uploadBtn.classList.add('hidden');
                        cancelBtn.classList.add('hidden');
                        location.reload();
                    }
                })
                .catch(error => {
                    uploadBtn.innerHTML = `ব্যর্থ`;
                });
        }
    }

    // Function to handle cancel button click
        function cancelUpload() {
            const userCoverPhoto = "{{ $user->cover_photo ?? null }}";
            if (userCoverPhoto) {
                coverImgOutput.src = "{{ asset('') }}" + userCoverPhoto;
            } else {
                coverImgOutput.innerHTML = '<div class="w-full h-48 bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center"><i class="fas fa-image text-white text-4xl opacity-50"></i></div>';
            }
            coverImgBase64.value = '';
            uploadBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
