@extends('layouts.guest-modern')

@section('title', 'এক্সপার্ট কানেকশন - শীঘ্রই আসছে')
@section('description', 'এক্সপার্ট কানেকশন ফিচার শীঘ্রই চালু হবে। AI এক্সপার্টদের সাথে সরাসরি যোগাযোগ করুন এবং আপনার প্রশ্নের উত্তর পান।')

@section('content')

<!-- Coming Soon Section -->
<section class="w-full relative overflow-hidden min-h-screen flex items-center justify-center bg-gradient-to-b from-[#000] to-[#0a0a0a]">
    <!-- Header -->
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
        @include('partials.guest.header-modern')
    </div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#E850FF]/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#4941C8]/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#CDFF5C]/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>

    <div class="container-x relative z-10 py-20 lg:py-32">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Icon -->
            <div class="mb-8 lg:mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 lg:w-32 lg:h-32 rounded-full bg-gradient-to-br from-[#E850FF] to-[#4941C8] p-1 animate-bounce-slow">
                    <div class="w-full h-full rounded-full bg-[#0a0a0a] flex items-center justify-center">
                        <svg class="w-12 h-12 lg:w-16 lg:h-16 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Badge -->
            <div class="mb-6">
                <span class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-full py-2 px-4 lg:py-2.5 lg:px-6 font-normal text-sm lg:text-base text-[#E2E8F0]">
                    <span class="block h-2 w-2 bg-[#CDFF5C] rounded-full animate-pulse"></span>
                    শীঘ্রই আসছে
                </span>
            </div>

            <!-- Title -->
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-6">
                <span class="text-gradient">এক্সপার্ট কানেকশন</span>
            </h1>

            <!-- Description -->
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[160%] mb-8 lg:mb-12 max-w-2xl mx-auto">
                AI এবং ক্রিয়েটিভ টেকনোলজির এক্সপার্টদের সাথে সরাসরি যোগাযোগ করুন। আপনার প্রশ্নের উত্তর পান, পরামর্শ নিন এবং আপনার স্কিল ডেভেলপমেন্টে এগিয়ে যান।
            </p>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-12 lg:mb-16">
                <!-- Feature 1 -->
                <div class="p-6 lg:p-8 rounded-lg lg:rounded-[20px] bg-[#fff]/5 border border-[#fff]/10 hover:border-[#E850FF]/50 transition-all duration-300">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-gradient-to-br from-[#E850FF]/20 to-[#E850FF]/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-[#E2E8F0] mb-2">১-অন-১ মেন্টরশিপ</h3>
                    <p class="text-sm text-[#ABABAB]">এক্সপার্টদের সাথে সরাসরি কথা বলুন</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 lg:p-8 rounded-lg lg:rounded-[20px] bg-[#fff]/5 border border-[#fff]/10 hover:border-[#4941C8]/50 transition-all duration-300">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-gradient-to-br from-[#4941C8]/20 to-[#4941C8]/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-[#4941C8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-[#E2E8F0] mb-2">দ্রুত সাপোর্ট</h3>
                    <p class="text-sm text-[#ABABAB]">তাৎক্ষণিক সমাধান পান</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 lg:p-8 rounded-lg lg:rounded-[20px] bg-[#fff]/5 border border-[#fff]/10 hover:border-[#CDFF5C]/50 transition-all duration-300">
                    <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-full bg-gradient-to-br from-[#CDFF5C]/20 to-[#CDFF5C]/5 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-[#CDFF5C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-[#E2E8F0] mb-2">প্রমাণিত এক্সপার্ট</h3>
                    <p class="text-sm text-[#ABABAB]">অভিজ্ঞ পেশাদারদের সাথে</p>
                </div>
            </div>

            <!-- Notify Form -->
            <div class="max-w-md mx-auto">
                <p class="text-[#E2E8F0] font-medium mb-4">লঞ্চের আপডেট পেতে চান?</p>
                <form action="#" method="POST" class="flex gap-3">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="আপনার ইমেইল এড্রেস" 
                        class="flex-1 bg-[#131620] border border-[#232323] rounded-lg py-3 px-4 text-[#fff] placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                        required
                    >
                    <button 
                        type="submit" 
                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-lg px-6 py-3 font-medium text-base text-[#fff] anim hover:text-primary whitespace-nowrap"
                    >
                        নোটিফাই করুন
                    </button>
                </form>
                <p class="text-xs text-[#ABABAB] mt-3">আমরা আপনার ইমেইল শেয়ার করি না</p>
            </div>

            <!-- Back to Home -->
            <div class="mt-12 lg:mt-16">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-[#ABABAB] hover:text-[#E850FF] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="font-medium">হোমপেজে ফিরে যান</span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }

    .delay-1000 {
        animation-delay: 1s;
    }

    .delay-2000 {
        animation-delay: 2s;
    }
</style>

@endsection
