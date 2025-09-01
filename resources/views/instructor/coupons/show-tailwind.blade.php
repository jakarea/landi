@extends('layouts.instructor-tailwind')

@section('header-title', 'Coupon Details')
@section('header-subtitle', 'View and manage coupon: ' . $coupon->code)

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-orange to-yellow-500 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12,2A2,2 0 0,1 14,4V8A2,2 0 0,1 12,10A2,2 0 0,1 10,8V4A2,2 0 0,1 12,2M21,9V7L15,1H5A2,2 0 0,0 3,3V21A2,2 0 0,0 5,23H19A2,2 0 0,0 21,21V9M19,9H14V4H19V9Z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">{{ $coupon->name }}</h1>
                <p class="text-secondary-200 text-sm">Code: {{ $coupon->code }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.coupons.edit', $coupon) }}" 
               class="inline-flex items-center gap-2 bg-orange hover:bg-orange/80 rounded-lg px-4 py-2 text-white font-medium anim">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('instructor.coupons') }}" 
               class="inline-flex items-center gap-2 bg-secondary hover:bg-secondary/80 rounded-lg px-4 py-2 text-white font-medium anim">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Coupon Details Card -->
            <div class="bg-card rounded-xl p-6 border border-[#fff]/10">
                <div class="space-y-6">
                    <!-- Coupon Code -->
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange/20 to-yellow-500/20 rounded-lg border border-orange/30">
                        <div>
                            <p class="text-secondary-200 text-sm">Coupon Code</p>
                            <p class="text-2xl font-bold text-orange">{{ $coupon->code }}</p>
                        </div>
                        <button class="copy-code bg-orange hover:bg-orange/80 rounded-lg px-4 py-2 text-white font-medium anim" 
                                data-code="{{ $coupon->code }}" title="Copy to clipboard">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z"/>
                            </svg>
                            Copy
                        </button>
                    </div>

                    <!-- Basic Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-secondary-200 text-sm mb-1">Name</p>
                            <p class="text-white font-medium">{{ $coupon->name }}</p>
                        </div>

                        <div>
                            <p class="text-secondary-200 text-sm mb-1">Discount</p>
                            <div class="flex items-center gap-2">
                                @if($coupon->type === 'percentage')
                                    <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $coupon->value }}% OFF
                                    </span>
                                @else
                                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">
                                        ৳{{ number_format($coupon->value, 2) }} OFF
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($coupon->description)
                        <div>
                            <p class="text-secondary-200 text-sm mb-2">Description</p>
                            <p class="text-secondary-100">{{ $coupon->description }}</p>
                        </div>
                    @endif

                    <!-- Usage Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-secondary-200 text-sm">Usage Progress</p>
                            <p class="text-secondary-100 text-sm">{{ $coupon->used_count }} / {{ $coupon->usage_limit }} used</p>
                        </div>
                        <div class="w-full bg-secondary/30 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange to-yellow-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ ($coupon->used_count / $coupon->usage_limit) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Validity Period -->
                    <div>
                        <p class="text-secondary-200 text-sm mb-2">Valid Period</p>
                        <div class="flex items-center gap-4 flex-wrap">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M21,8V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V8H21Z"/>
                                </svg>
                                <span class="text-secondary-100 text-sm">{{ $coupon->valid_from->format('M d, Y g:i A') }}</span>
                            </div>
                            <span class="text-secondary-200">to</span>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-secondary-200" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M21,8V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V8H21Z"/>
                                </svg>
                                <span class="text-secondary-100 text-sm">{{ $coupon->valid_until->format('M d, Y g:i A') }}</span>
                            </div>
                            
                            @if(now() < $coupon->valid_from)
                                <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full text-xs">Not Started</span>
                            @elseif(now() > $coupon->valid_until)
                                <span class="bg-red-500/20 text-red-400 px-2 py-1 rounded-full text-xs">Expired</span>
                            @else
                                <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">Active</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center justify-between p-4 bg-primary/50 rounded-lg border border-[#fff]/10">
                        <div>
                            <p class="text-secondary-200 text-sm">Status</p>
                            <p class="text-white font-medium">{{ $coupon->is_active ? 'Active' : 'Inactive' }}</p>
                        </div>
                        <button class="toggle-status px-4 py-2 rounded-lg font-medium anim {{ $coupon->is_active ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-secondary hover:bg-secondary/80 text-secondary-100' }}"
                                data-id="{{ $coupon->id }}">
                            {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </div>

                    <!-- Applicable Courses -->
                    <div>
                        <p class="text-secondary-200 text-sm mb-2">Applicable Courses</p>
                        @if(empty($coupon->applicable_courses))
                            <p class="text-secondary-100">All your courses</p>
                        @else
                            <div class="flex flex-wrap gap-2">
                                @foreach($coupon->applicable_courses as $courseId)
                                    @php
                                        $course = $coupon->instructor->courses->find($courseId);
                                    @endphp
                                    @if($course)
                                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm">{{ $course->title }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Created Date -->
                    <div>
                        <p class="text-secondary-200 text-sm mb-1">Created</p>
                        <p class="text-secondary-100">{{ $coupon->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Share Coupon Card -->
            <div class="bg-card rounded-xl p-6 border border-[#fff]/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18,16.08C17.24,16.08 16.56,16.38 16.04,16.85L8.91,12.7C8.96,12.47 9,12.24 9,12C9,11.76 8.96,11.53 8.91,11.3L15.96,7.19C16.5,7.69 17.21,8 18,8A3,3 0 0,0 21,5A3,3 0 0,0 18,2A3,3 0 0,0 15,5C15,5.24 15.04,5.47 15.09,5.7L8.04,9.81C7.5,9.31 6.79,9 6,9A3,3 0 0,0 3,12A3,3 0 0,0 6,15C6.79,15 7.5,14.69 8.04,14.19L15.16,18.34C15.11,18.55 15.08,18.77 15.08,19C15.08,20.61 16.39,21.91 18,21.91C19.61,21.91 20.92,20.6 20.92,19A2.92,2.92 0 0,0 18,16.08Z"/>
                    </svg>
                    Share Coupon
                </h3>
                
                <div class="space-y-4">
                    <!-- Shareable Link -->
                    <div>
                        <label class="block text-secondary-200 text-sm mb-2">Shareable Link</label>
                        <div class="flex">
                            <input type="text" class="flex-1 bg-primary border border-[#fff]/20 rounded-l-lg px-4 py-2 text-white text-sm" 
                                   id="shareableLink" 
                                   value="{{ url('/') }}?coupon={{ $coupon->code }}" readonly>
                            <button class="copy-link bg-orange hover:bg-orange/80 px-3 py-2 rounded-r-lg text-white anim" title="Copy link">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Social Sharing -->
                    <div class="space-y-2">
                        <button class="share-social w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-white font-medium anim" data-platform="facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Share on Facebook
                        </button>
                        
                        <button class="share-social w-full flex items-center justify-center gap-2 bg-sky-500 hover:bg-sky-600 rounded-lg px-4 py-2 text-white font-medium anim" data-platform="twitter">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Share on Twitter
                        </button>
                        
                        <button class="share-social w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 rounded-lg px-4 py-2 text-white font-medium anim" data-platform="whatsapp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            Share on WhatsApp
                        </button>
                        
                        <button class="share-email w-full flex items-center justify-center gap-2 bg-secondary hover:bg-secondary/80 rounded-lg px-4 py-2 text-white font-medium anim">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                            </svg>
                            Share via Email
                        </button>
                    </div>
                </div>
            </div>

            <!-- Coupon Status Alert -->
            @if($coupon->isValid())
                <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span class="text-green-400 font-medium">Valid Coupon</span>
                    </div>
                    <p class="text-green-300 text-sm mt-1">This coupon is currently valid and can be used.</p>
                </div>
            @else
                <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                        <span class="text-yellow-400 font-medium">Invalid Coupon</span>
                    </div>
                    <p class="text-yellow-300 text-sm mt-1">
                        This coupon is currently not valid
                        @if(!$coupon->is_active)
                            (inactive)
                        @elseif(now() < $coupon->valid_from)
                            (not started yet)
                        @elseif(now() > $coupon->valid_until)
                            (expired)
                        @elseif($coupon->used_count >= $coupon->usage_limit)
                            (usage limit reached)
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy code to clipboard
    const copyCodeButtons = document.querySelectorAll('.copy-code');
    copyCodeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const code = this.dataset.code;
            navigator.clipboard.writeText(code).then(function() {
                // Simple success feedback
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>Copied!';
                setTimeout(() => {
                    button.innerHTML = originalText;
                }, 2000);
            });
        });
    });

    // Copy link to clipboard
    const copyLinkButtons = document.querySelectorAll('.copy-link');
    copyLinkButtons.forEach(button => {
        button.addEventListener('click', function() {
            const link = document.getElementById('shareableLink').value;
            navigator.clipboard.writeText(link).then(function() {
                // Simple success feedback
                const originalHTML = button.innerHTML;
                button.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>';
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                }, 2000);
            });
        });
    });

    // Toggle status
    const toggleButtons = document.querySelectorAll('.toggle-status');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const couponId = this.dataset.id;
            
            fetch(`/instructor/coupons/${couponId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(() => location.reload(), 500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Social sharing
    const shareButtons = document.querySelectorAll('.share-social');
    shareButtons.forEach(button => {
        button.addEventListener('click', function() {
            const platform = this.dataset.platform;
            const link = document.getElementById('shareableLink').value;
            const text = `Check out this discount coupon: {{ $coupon->code }}`;
            let shareUrl = '';

            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(link)}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + link)}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        });
    });

    // Email sharing
    const emailButton = document.querySelector('.share-email');
    if (emailButton) {
        emailButton.addEventListener('click', function() {
            const link = document.getElementById('shareableLink').value;
            const subject = 'Discount Coupon: {{ $coupon->code }}';
            const body = `I wanted to share this discount coupon with you:\n\nCoupon Code: {{ $coupon->code }}\nLink: ${link}`;
            
            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        });
    }
});
</script>
@endsection