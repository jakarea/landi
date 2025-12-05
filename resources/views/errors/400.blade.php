@extends('layouts.guest-modern')

@section('title', '400 - ভুল রিকোয়েস্ট')
@section('description', 'দুঃখিত, আপনার রিকোয়েস্টটি সঠিক নয়।')

@section('content')

<!-- 400 Error Page -->
<section class="w-full relative overflow-hidden min-h-screen flex items-center justify-center bg-gradient-to-b from-[#000] to-[#0a0a0a]">
    <!-- Header -->
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
        @include('partials.guest.header-modern')
    </div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#E850FF]/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#4941C8]/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <div class="container-x relative z-10 py-20 lg:py-32">
        <div class="max-w-3xl mx-auto text-center">
            <!-- 400 Number -->
            <div class="mb-8 lg:mb-12">
                <h1 class="font-bold text-[120px] md:text-[180px] lg:text-[240px] leading-none text-gradient opacity-20">
                    400
                </h1>
            </div>

            <!-- Icon -->
            <div class="mb-8 -mt-32 lg:-mt-48">
                <div class="inline-flex items-center justify-center w-24 h-24 lg:w-32 lg:h-32 rounded-full bg-gradient-to-br from-[#E850FF] to-[#4941C8] p-1">
                    <div class="w-full h-full rounded-full bg-[#0a0a0a] flex items-center justify-center">
                        <svg class="w-12 h-12 lg:w-16 lg:h-16 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] leading-[120%] mb-4">
                ভুল রিকোয়েস্ট!
            </h2>

            <!-- Description -->
            <p class="font-normal text-base md:text-lg text-[#ABABAB] leading-[160%] mb-8 lg:mb-12 max-w-xl mx-auto">
                দুঃখিত, আপনার রিকোয়েস্টটি সঠিক নয় বা সার্ভার বুঝতে পারছে না। অনুগ্রহ করে আপনার ইনপুট চেক করুন এবং আবার চেষ্টা করুন।
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button onclick="window.history.back()" class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-lg px-8 py-3 font-medium text-base lg:text-lg text-[#fff] anim hover:text-primary group">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    পেছনে যান
                </button>
                <a href="{{ route('home') }}" class="inline-flex font-golos justify-center items-center bg-[#fff]/10 hover:bg-[#fff]/20 border border-[#fff]/20 rounded-lg px-8 py-3 font-medium text-base lg:text-lg text-[#fff] anim group">
                    হোমপেজে যান
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Common Issues -->
            <div class="mt-12 lg:mt-16 pt-8 border-t border-[#232323]">
                <p class="text-[#ABABAB] text-sm mb-4">সাধারণ সমস্যা:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                    <div class="p-4 bg-[#fff]/5 rounded-lg border border-[#fff]/10">
                        <h4 class="text-[#E2E8F0] font-medium text-sm mb-1">ভুল ডেটা</h4>
                        <p class="text-[#ABABAB] text-xs">ফর্মে ভুল তথ্য দেওয়া হয়েছে</p>
                    </div>
                    <div class="p-4 bg-[#fff]/5 rounded-lg border border-[#fff]/10">
                        <h4 class="text-[#E2E8F0] font-medium text-sm mb-1">ভুল ফরম্যাট</h4>
                        <p class="text-[#ABABAB] text-xs">ডেটা ফরম্যাট সঠিক নয়</p>
                    </div>
                    <div class="p-4 bg-[#fff]/5 rounded-lg border border-[#fff]/10">
                        <h4 class="text-[#E2E8F0] font-medium text-sm mb-1">মিসিং ফিল্ড</h4>
                        <p class="text-[#ABABAB] text-xs">প্রয়োজনীয় ফিল্ড খালি রয়েছে</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .delay-1000 {
        animation-delay: 1s;
    }
</style>

@endsection
