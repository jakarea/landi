@extends('layouts.guest-modern')

@section('title', '500 - সার্ভার এরর')
@section('description', 'দুঃখিত, সার্ভারে একটি সমস্যা হয়েছে। আমরা এটি ঠিক করার চেষ্টা করছি।')

@section('content')

<!-- 500 Error Page -->
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
            <!-- 500 Number -->
            <div class="mb-8 lg:mb-12">
                <h1 class="font-bold text-[120px] md:text-[180px] lg:text-[240px] leading-none text-gradient opacity-20">
                    500
                </h1>
            </div>

            <!-- Icon -->
            <div class="mb-8 -mt-32 lg:-mt-48">
                <div class="inline-flex items-center justify-center w-24 h-24 lg:w-32 lg:h-32 rounded-full bg-gradient-to-br from-[#E850FF] to-[#4941C8] p-1 animate-pulse">
                    <div class="w-full h-full rounded-full bg-[#0a0a0a] flex items-center justify-center">
                        <svg class="w-12 h-12 lg:w-16 lg:h-16 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] leading-[120%] mb-4">
                সার্ভার এরর!
            </h2>

            <!-- Description -->
            <p class="font-normal text-base md:text-lg text-[#ABABAB] leading-[160%] mb-8 lg:mb-12 max-w-xl mx-auto">
                দুঃখিত, আমাদের সার্ভারে একটি সমস্যা হয়েছে। আমাদের টিম এটি ঠিক করার জন্য কাজ করছে। অনুগ্রহ করে কিছুক্ষণ পরে আবার চেষ্টা করুন।
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button onclick="location.reload()" class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-lg px-8 py-3 font-medium text-base lg:text-lg text-[#fff] anim hover:text-primary group">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    পুনরায় চেষ্টা করুন
                </button>
                <a href="{{ route('home') }}" class="inline-flex font-golos justify-center items-center bg-[#fff]/10 hover:bg-[#fff]/20 border border-[#fff]/20 rounded-lg px-8 py-3 font-medium text-base lg:text-lg text-[#fff] anim group">
                    হোমপেজে যান
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Error Code (for developers) -->
            @if(config('app.debug') && isset($exception))
            <div class="mt-12 lg:mt-16 pt-8 border-t border-[#232323]">
                <details class="text-left">
                    <summary class="text-[#ABABAB] text-sm cursor-pointer hover:text-[#E850FF] transition-colors">
                        ডেভেলপার ইনফো দেখুন
                    </summary>
                    <div class="mt-4 p-4 bg-[#131620] rounded-lg border border-[#232323] text-xs text-[#ABABAB] font-mono overflow-x-auto">
                        <p><strong class="text-[#E850FF]">Error:</strong> {{ $exception->getMessage() }}</p>
                        <p><strong class="text-[#E850FF]">File:</strong> {{ $exception->getFile() }}</p>
                        <p><strong class="text-[#E850FF]">Line:</strong> {{ $exception->getLine() }}</p>
                    </div>
                </details>
            </div>
            @endif
        </div>
    </div>
</section>

<style>
    .delay-1000 {
        animation-delay: 1s;
    }
</style>

@endsection
