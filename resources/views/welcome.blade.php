@extends('layouts.guest-modern')

@section('title', 'আব্দুর রউফ - AI Creative Training Platform')
@section('description',
    'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম। মাত্র ৩ দিনে আয়ত্ত করুন AI ইমেজ, ভিডিও ও
    মিউজিক জেনারেশন।')

@section('content')



@php
    $heroSliderSection = $sections->where('sectionName', 'hero_slider')->first();
@endphp

@if ($heroSliderSection && $heroSliderSection['is_active'] && isset($heroSliderSection['content']['slides']))
<!-- hero slider section start -->
    <section class="w-full relative overflow-hidden ">
        {{-- Header --}}
        <div class="absolute inset-0 w-full h-full bg-[#000]/50">
             @include('partials.guest.header-modern')
         </div> 

        <!-- Hero Slider -->
        <div class="hero-slider relative w-full min-h-[500px] md:min-h-[600px] lg:min-h-[100vh] ">
            
            @foreach($heroSliderSection['content']['slides'] as $index => $slide)
            <!-- Slide {{ $index + 1 }} -->
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 w-full h-full {{ $index === 0 ? '' : 'opacity-0' }}">
                <div class="absolute inset-0 w-full h-full">
                    <img src="{{ asset($slide['bg_image'] ?? 'images/home/hero-1.png') }}" alt="Hero {{ $index + 1 }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-[#000]/50"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
                </div>
                <div class="container-x relative h-full flex items-center">
                    <div class="max-w-2xl py-20 md:py-28 lg:py-32">
                        <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                            {!! $slide['title'] ?? 'Hero Title' !!}
                        </h1>
                        <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                            {{ $slide['description'] ?? 'Hero description text' }}
                        </p>
                        <a href="{{ $slide['cta_link'] ?? '#' }}" 
                           class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                            {{ $slide['cta_text'] ?? 'Learn More' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Slider Controls -->
            <div class="absolute bottom-8 left-0 right-0 z-50">
                <div class="container-x">
                    <div class="flex items-center justify-between">
                        <!-- Navigation Dots -->
                        <div class="flex gap-3">
                            @foreach($heroSliderSection['content']['slides'] as $index => $slide)
                            <button class="slider-dot {{ $index === 0 ? 'active' : '' }} w-3 h-3 rounded-full {{ $index === 0 ? 'bg-[#E850FF]' : 'bg-[#fff]/30 hover:bg-[#fff]/50' }} transition-all duration-300" data-slide="{{ $index }}"></button>
                            @endforeach
                        </div>
                        
                        <!-- Arrow Navigation -->
                        <div class="flex gap-3">
                            <button class="slider-prev w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
                                <svg class="w-5 h-5 text-[#fff] transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <button class="slider-next w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
                                <svg class="w-5 h-5 text-[#fff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Gradient Mask for smooth transition -->
            <div class="absolute bottom-0 left-0 right-0 h-48 md:h-64 lg:h-80 bg-gradient-to-t from-[#0a0a0a] via-[#000]/50 to-transparent z-40 pointer-events-none"></div>
        </div>
    </section>
    <!-- hero slider section end -->
@endif

    <!-- why we're the best section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6 class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    আমাদের বিশেষত্ব
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                    কেন <span class="text-gradient">আমরাই সেরা?</span>
                </h2>
                <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                    আমাদের প্ল্যাটফর্মে পাবেন সম্পূর্ণ প্র্যাক্টিক্যাল এবং ইন্ডাস্ট্রি-ফোকাসড লার্নিং এক্সপেরিয়েন্স
                </p>
            </div>

            <!-- feature cards with unique design -->
            <div class="w-full grid grid-cols-1 gap-5 lg:gap-6">
                
                <!-- Card 1: Live Mentorship -->
                <div class="w-full rounded-lg lg:rounded-[20px] p-6 lg:p-8 border border-[#E850FF]/20 bg-gradient-to-br from-[#E850FF]/10 to-transparent hover:border-[#E850FF]/40 transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-5 lg:gap-8">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl bg-gradient-to-br from-[#E850FF] to-[#E850FF]/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 lg:w-10 text-[#fff]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <h5 class="font-bold text-lg lg:text-2xl text-[#E2E8F0] mb-2 lg:mb-3">
                                লাইভ মেন্টরশিপ সাপোর্ট
                            </h5>
                            <p class="font-normal text-sm lg:text-base text-[#ABABAB] leading-[160%]">
                                রেকর্ডেড ক্লাসের পাশাপাশি পাচ্ছেন মেন্টরের সাথে সরাসরি কথা বলার সুযোগ এবং মিট/জুম সেশন।
                            </p>
                        </div>
                        <!-- Arrow -->
                        <div class="hidden lg:block flex-shrink-0">
                            <svg class="w-6 h-6 text-[#E850FF] group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Project-Based Learning -->
                <div class="w-full rounded-lg lg:rounded-[20px] p-6 lg:p-8 border border-[#4941C8]/20 bg-gradient-to-br from-[#4941C8]/10 to-transparent hover:border-[#4941C8]/40 transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-5 lg:gap-8">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl bg-gradient-to-br from-[#4941C8] to-[#4941C8]/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 lg:w-10 text-[#fff]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <h5 class="font-bold text-lg lg:text-2xl text-[#E2E8F0] mb-2 lg:mb-3">
                                প্রজেক্ট-ভিত্তিক লার্নিং
                            </h5>
                            <p class="font-normal text-sm lg:text-base text-[#ABABAB] leading-[160%]">
                                শুধু থিওরি নয়, রিয়েল ক্লায়েন্ট বা মার্কেটের চাহিদা অনুযায়ী লাইভ প্রজেক্ট।
                            </p>
                        </div>
                        <!-- Arrow -->
                        <div class="hidden lg:block flex-shrink-0">
                            <svg class="w-6 h-6 text-[#4941C8] group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Career & Portfolio Guideline -->
                <div class="w-full rounded-lg lg:rounded-[20px] p-6 lg:p-8 border border-[#CDFF5C]/20 bg-gradient-to-br from-[#CDFF5C]/10 to-transparent hover:border-[#CDFF5C]/40 transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-5 lg:gap-8">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl bg-gradient-to-br from-[#CDFF5C] to-[#CDFF5C]/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 lg:w-10 text-[#000]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <h5 class="font-bold text-lg lg:text-2xl text-[#E2E8F0] mb-2 lg:mb-3">
                                ক্যারিয়ার ও পোর্টফোলিও গাইডলাইন
                            </h5>
                            <p class="font-normal text-sm lg:text-base text-[#ABABAB] leading-[160%]">
                                কোর্স শেষে আপনার সিভি এবং পোর্টফোলিও সাজিয়ে দেওয়া হবে যাতে জব পেতে সুবিধা হয়।
                            </p>
                        </div>
                        <!-- Arrow -->
                        <div class="hidden lg:block flex-shrink-0">
                            <svg class="w-6 h-6 text-[#CDFF5C] group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
            <!-- feature cards -->
        </div>
    </section>
    <!-- why we're the best section end -->

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line --> 

    @php
        $learningStepsSection = $sections->where('sectionName', 'learning_steps')->first();
    @endphp

    @if ($learningStepsSection && $learningStepsSection['is_active'])
    <!-- change your idea section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    {{ data_get($learningStepsSection, 'content.subtitle', 'শেখার ধাপ') }}
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                    {{ data_get($learningStepsSection, 'content.title', 'আপনার আইডিয়াকে বদলে দিন') }} <span class="text-gradient">{{ data_get($learningStepsSection, 'content.gradient_title', 'এআই ক্রিয়েশনে') }}</span>
                </h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[50%] lg:mx-auto">
                    {{ data_get($learningStepsSection, 'content.description', 'এই বুটক্যাম্পে শেখার সঠিক পদ্ধতি, ধাপে ধাপে নির্দেশনা এবং ব্যবহারিক কৌশল যা আপনাকে দ্রুত দক্ষ করে তুলবে') }}
                </p>
            </div>

            <div class="w-full grid grid-cols-1 gap-y-10 lg:grid-cols-2 lg:gap-y-[200px] lg:gap-x-12 lg:items-center relative" id="mainScrol">
                <!-- line -->
                <div class="hidden lg:block bg-[#232323] w-[2px] h-full absolute left-[50%] top-0 translate-x-[-50%]"></div>
                <div id="scrolling-line" class="hidden lg:block bg-gradient-to-b from-transparent via-[#E850FF] to-[#4941C8] w-[2px] absolute left-[50%] top-0 translate-x-[-50%] shadow-2xl" style="height: 0;"></div>
                <!-- line -->

                @foreach(data_get($learningStepsSection, 'content.steps', []) as $index => $step)
                    @php
                        $isEven = $index % 2 == 0;
                    @endphp

                    @if ($isEven)
                        <!-- Text Content -->
                        <div class="w-full">
                            <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl mb-3 lg:mb-5">{{ data_get($step, 'title') }}</h4>
                            <h6 class="font-medium text-base lg:text-lg text-[#E2E8F0] mb-3 lg:mb-5">{{ data_get($step, 'heading') }}</h6>
                            <ul class="flex flex-col gap-y-2 lg:max-w-[70%]">
                                @foreach(data_get($step, 'items', []) as $item)
                                <li class="flex items-center gap-x-2 lg:gap-x-3">
                                    <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                                    <p class="text-[#ABABAB] font-normal text-sm lg:text-base">{{ $item }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Image -->
                        <div class="w-full lg:max-w-[80%] lg:ml-auto">
                            <div class="bg-step-img rounded-lg lg:rounded-[30px] p-4 lg:p-5 border border-[#232323]">
                                <img src="{{ asset(data_get($step, 'image')) }}" alt="{{ data_get($step, 'title') }}" class="w-full rounded-md lg:rouned-[10px]">
                            </div>
                        </div>
                    @else
                        <!-- Image -->
                        <div class="w-full lg:max-w-[80%] lg:mr-auto">
                            <div class="bg-step-img rounded-lg lg:rounded-[30px] p-4 lg:p-5 border border-[#232323]">
                                <img src="{{ asset(data_get($step, 'image')) }}" alt="{{ data_get($step, 'title') }}" class="w-full rounded-md lg:rouned-[10px]">
                            </div>
                        </div>
                        <!-- Text Content -->
                        <div class="w-full lg:max-w-[80%] lg:ml-auto">
                            <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl mb-3 lg:mb-5">{{ data_get($step, 'title') }}</h4>
                            <h6 class="font-medium text-base lg:text-lg text-[#E2E8F0] mb-3 lg:mb-5">{{ data_get($step, 'heading') }}</h6>
                            <ul class="flex flex-col gap-y-2">
                                @foreach(data_get($step, 'items', []) as $item)
                                <li class="flex items-center gap-x-2 lg:gap-x-3">
                                    <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                                    <p class="text-[#ABABAB] font-normal text-sm lg:text-base">{{ $item }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- change your idea section end -->
    @endif

    <!-- our courses section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-start mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    আমাদের কোর্স সমূহ
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                    ফিউচার রেডি হতে বেছে নিন আপনার  <span class="text-gradient">পছন্দের স্কিল </span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mr-auto">
                    বিগিনার থেকে অ্যাডভান্সড, প্রতিটি কোর্স সাজানো হয়েছে বর্তমান মার্কেটের চাহিদা অনুযায়ী।</p>

                <div class="flex justify-start items-center gap-x-4  mt-5 lg:mt-10 lg:gap-x-5">
                    <a href="#"
                        class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
               hover:!bg-lime md:text-base px-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        এখনই এনরোল করুন
                    </a>
                    <a href="#"
                        class="inline-flex font-golos justify-center items-center bg-black rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
                 md:text-base lg:text-lg hover:text-orange px-2 group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        সার্টিফিকেট পান
                    </a>
                </div>
            </div>
            @if ($latestCourses->count() > 0)
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-5 lg: gap-x-6">
                    @foreach ($latestCourses->slice(0, 3) as $course)
                        {{-- card --}}
                        <div
                            class="w-full p-5 lg:p-[30px] border-[2px] !border-primary rounded-lg lg:rounded-[20px] bg-[#131620] anim effect-card relative flex flex-col justify-between">
                            <div class="w-full">

                                <div class="absolute right-3 top-1.5 lg:top-2.5 z-30 flex items-center gap-x-2">
                                    @if ($course->review_count > 0)
                                        <p
                                            class="rounded-full py-1 px-2 text-[#000] bg-orange text-xs font-normal h-5 flex justify-center items-center">
                                            {{ $course->review_count ?? 0 }} রিভিউ
                                        </p>
                                    @endif

                                    @if ($course->enrolled_count > 0)
                                        <p
                                            class="rounded-full py-1 px-2 text-[#000] bg-lime text-xs font-normal h-5 flex justify-center items-center">
                                            {{ $course->enrolled_count ?? 0 }} এনরোল
                                        </p>
                                    @endif
                                    {{-- offer badge --}}
                                    @if ($course->offer_price && $course->price > $course->offer_price)
                                        @php
                                            $discount = round(
                                                (($course->price - $course->offer_price) / $course->price) * 100,
                                            );
                                        @endphp
                                        <p
                                            class="rounded-full py-1 px-2 text-[#fff] bg-line text-xs font-normal h-5 flex justify-center items-center">
                                            {{ $discount }}% ছাড়</p>
                                    @endif
                                    {{-- offer badge --}}
                                </div>
                                <div class="w-full h-[220px] relative pt-3">
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/default-course.jpg') }}"
                                        alt="{{ $course->title }}" class="w-full rounded-[10px] h-full object-cover">

                                </div>

                                <div class="mt-5 lg:mt-10 relative z-40">
                                    <a href="{{ route('courses.overview', $course->slug) }}"
                                        class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">
                                        {{ $course->title }}</a>

                                    @if ($course->short_description)
                                        <div
                                            class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[90%] mt-2">
                                            {!! \Illuminate\Support\Str::limit($course->short_description, 100) !!}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="mt-5 w-full relative z-40">

                                @if ($course->offer_price && $course->price > $course->offer_price)
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="price-current text-orange text-base lg:text-lg">৳{{ number_format($course->offer_price) }}</span>
                                        <span
                                            class=" text-[#fff]/50 line-through">৳{{ number_format($course->price) }}</s>
                                    </div>
                                @else
                                    <span class="price-current text-[#fff]">
                                        {{ $course->price > 0 ? '৳' . number_format($course->price) : 'ফ্রি' }}
                                    </span>
                                @endif

                                <div class="flex lg:mt-[10px] justify-between items-center">
                                    <a href="#"
                                        class="block font-medium text-[#ABABAB] text-sm anim hover:text-[#E2E8F0] hover:underline">এখনই
                                        এনরোল করুন
                                    </a>
                                    <a href="{{ route('courses.overview', $course->slug) }}" class="group block">
                                        <svg class="w-5 text-[#ABABAB] group-hover:text-[#E850FF]" viewBox="0 0 25 16"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 14L22.9393 9.06066C23.5251 8.47487 23.5251 7.52513 22.9393 6.93934L18 2M22.5 8L1.5 8"
                                                stroke="currentColor" stroke-width="2.25" stroke-linecap="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex justify-center items-center flex-col">
                    <i class="fas fa-search"></i>
                    <h3 class="text-[#fff] font-semibold text-2xl">কোনো কোর্স পাওয়া যায়নি!</h3>
                    <p class="text-[#fff]/40">আপনার অনুসন্ধানের সাথে মিল রয়েছে এমন কোনো কোর্স খুঁজে পাওয়া যায়নি।</p>
                    {{-- <!-- @if ($search || $category) --> --}}
                        <a href="{{ route('courses') }}" class="text-[#fff] mt-3 lg:mt-5 font-medium underline">
                            <i class="fas fa-refresh"></i>
                            সব কোর্স দেখুন
                        </a>
                    {{-- <!-- @endif --> --}}
                </div>
            @endif
        </div>
    </section>
    <!-- our courses section end -->

    <!-- review section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    অভিজ্ঞতা সমূহ
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">যারা শিখেছেন,
                    <span class="text-gradient">তারাই বলছেন</span>
                </h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[50%] lg:mx-auto">
                    আমাদের বুটক্যাম্প থেকে শেখা শিক্ষার্থীদের রিয়েল রিভিউ – যা আপনাকেও এগিয়ে যেতে উৎসাহ দেবে।</p>
            </div>

            <div class="w-full grid grid-cols-12 gap-y-5 gap-5 lg:gap-6">
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-4 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">আগে একটা পোস্টার বানাতে ঘন্টার
                        পর ঘন্টা লাগত। এখন এআই প্রম্পট দিয়ে মিনিটেই ভিজ্যুয়াল তৈরি করতে পারি। কাজের মান বেড়েছে আর
                        ক্লায়েন্টও অনেক বেশি খুশি।</p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/icons/avatar.png') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain">

                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                    সাদিয়া রহমান</h5>
                                <h6 class="common-para !text-xs text-secondary-200">গ্রাফিক ডিজাইনার</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-4 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">আমি শিক্ষার্থী হলেও এআই শিখে
                        এখন ছোট প্রজেক্ট করছি। কাজ দ্রুত হয় আর এটা ভবিষ্যতের জন্য দারুণ ইনভেস্টমেন্ট মনে হচ্ছে।</p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/icons/avatar-2.png') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain">

                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                    মাহিন ইসলাম
                                </h5>
                                <h6 class="common-para !text-xs text-secondary-200">ভিডিও এডিটর</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-4 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">আগে একটা পোস্টার বানাতে ঘন্টার
                        পর ঘন্টা লাগত। এখন এআই প্রম্পট দিয়ে মিনিটেই ভিজ্যুয়াল তৈরি করতে পারি। কাজের মান বেড়েছে আর
                        ক্লায়েন্টও অনেক বেশি খুশি।</p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/avatar.webp') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain">

                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                    রাহাত খান</h5>
                                <h6 class="common-para !text-xs text-secondary-200">গ্রাফিক ডিজাইনার</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-3 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">এআই শেখার পর ভিডিও বানানো অনেক
                        সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক আর ইফেক্ট কয়েক মিনিটেই করা যায়। এখন আগের চেয়ে দ্বিগুণ
                        প্রজেক্ট ডেলিভার করছি। এআই শেখার পর ভিডিও বানানো অনেক সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক </p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/avatar.webp') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain">

                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                   নয়ন খান </h5>
                                <h6 class="common-para !text-xs text-secondary-200">গ্রাফিক ডিজাইনার</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-5 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">আমি মূলত একজন শিক্ষার্থী,
                        কিন্তু সবসময় কিছু ক্রিয়েটিভ স্কিল শিখতে চেয়েছি যা ভবিষ্যতে কাজে লাগবে। এআই বুটক্যাম্পে যোগ দিয়ে
                        শিখলাম ইমেজ, ভিডিও আর মিউজিক জেনারেশন – সবকিছু একসাথে। কোর্স শেষে ছোট ছোট ফ্রিল্যান্স প্রজেক্ট
                        নেওয়া শুরু করেছি, আর এআই টুলস দিয়ে দ্রুত কাজ শেষ করতে পারছি। এটা শুধু শেখা নয়, ভবিষ্যতের জন্য এক
                        অসাধারণ ইনভেস্টমেন্ট মনে হচ্ছে। আমি বিশ্বাস করি এই স্কিল আমাকে ক্যারিয়ারে অনেক দূর এগিয়ে দেবে।</p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/avatar.webp') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain"> 
                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                   সাইফুল ইসলাম </h5>
                                <h6 class="common-para !text-xs text-secondary-200">গ্রাফিক ডিজাইনার</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
                <!-- review card -->
                <div
                    class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-4 review-card">
                    <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">আগে একটা পোস্টার বানাতে ঘন্টার
                        পর ঘন্টা লাগত। এখন এআই প্রম্পট দিয়ে মিনিটেই ভিজ্যুয়াল তৈরি করতে পারি। কাজের মান বেড়েছে আর
                        ক্লায়েন্টও অনেক বেশি খুশি। এআই শেখার পর ভিডিও বানানো অনেক সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক
                        আর ইফেক্ট কয়েক মিনিটেই করা যায়। এখন আগের চেয়ে দ্বিগুণ প্রজেক্ট ডেলিভার করছি।</p>

                    <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                    <div class="w-full flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ asset('images/avatar.webp') }}" alt="get left"
                                class="w-10 h-10 rounded-full object-contain">

                            <div>
                                <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                    তুহিন </h5>
                                <h6 class="common-para !text-xs text-secondary-200">গ্রাফিক ডিজাইনার</h6>
                            </div>
                        </div>
                        <span
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                            <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                        </span>
                    </div>
                </div>
                <!-- review card -->
            </div>
        </div>
    </section>
    <!-- review section end -->

        @php
            $heroSection = $sections->where('sectionName', 'upcomming')->first();
        @endphp
         @if ($heroSection && $heroSection['is_active'])  

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->

    <!-- upcommin course section -->
    <section class="w-full pb-1 lg:pb-10 relative">   
        <div class="container-x"> 
        
                <div class="w-full text-center mt-10 md:mt-14 lg:mt-[90px] relative z-[99]">
                    <h1
                        class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                        <span class="block h-[2px] w-5 bg-line"></span>
                        {{ data_get($heroSection, 'content.title') }}
                        <span class="block h-[2px] w-5 bg-line-2"></span>
                    </h1>
                    <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                        {{ data_get($heroSection, 'content.title') }} <span
                            class="text-gradient">{{ data_get($heroSection, 'content.gradient_title') }}</span>
                    </h2>
                    <p
                        class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                        {{ data_get($heroSection, 'content.description') }}
                    </p>

                     <!-- Countdown Timer -->
                     <div class="flex justify-center gap-x-3 lg:gap-x-5 items-center mt-5 md:mt-10 lg:mt-11"> 
                        <div class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim md:text-base px-3 lg:text-lg lg:py-3 lg:px-5" id="countdown-timer" data-target-date="{{ data_get($heroSection, 'content.countdown_date', '2025-12-31 23:59:59') }}">
                            <span id="countdown-days">00</span> Days : 
                            <span id="countdown-hours">00</span> Hours : 
                            <span id="countdown-minutes">00</span> Minutes : 
                            <span id="countdown-seconds">00</span> Seconds
                        </div>
                     </div>

                     <script>
                        // Countdown Timer
                        function initCountdown() {
                            const countdownElement = document.getElementById('countdown-timer');
                            if (!countdownElement) return;

                            const targetDate = new Date(countdownElement.getAttribute('data-target-date')).getTime();
                            
                            const daysEl = document.getElementById('countdown-days');
                            const hoursEl = document.getElementById('countdown-hours');
                            const minutesEl = document.getElementById('countdown-minutes');
                            const secondsEl = document.getElementById('countdown-seconds');

                            function updateCountdown() {
                                const now = new Date().getTime();
                                const distance = targetDate - now;

                                if (distance < 0) {
                                    countdownElement.innerHTML = '<span class="text-[#E850FF]">কোর্স শুরু হয়ে গেছে!</span>';
                                    return;
                                }

                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                daysEl.textContent = String(days).padStart(2, '0');
                                hoursEl.textContent = String(hours).padStart(2, '0');
                                minutesEl.textContent = String(minutes).padStart(2, '0');
                                secondsEl.textContent = String(seconds).padStart(2, '0');
                            }

                            // Update immediately
                            updateCountdown();
                            
                            // Update every second
                            setInterval(updateCountdown, 1000);
                        }

                        // Initialize when DOM is ready
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', initCountdown);
                        } else {
                            initCountdown();
                        }
                     </script>



                </div>   
            <div class="w-full mt-8 md:mt-12 lg:mt-[62px] lg:max-w-[60%] mx-auto"> 
                <!-- video url -->
                <div
                    class="w-full bg-[#131620] border border-[#232323] p-3 lg:p-5 rounded-md lg:rounded-[20px] grid grid-cols-1 gap-2 lg:gap-2.5">
                    <div class="w-full relative" id="video-player" data-video-url="{{ data_get($heroSection, 'content.video_url') }}">   
                        <img src="{{ asset(data_get($heroSection, 'content.video_thumbnail')) }}" alt="robot"
                            class="w-full h-[349px] object-cover rounded-md lg:rounded-[10px] lg:h-[400px]">
                        <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                            <button type="button" id="play-video-button"
                                class="w-12 h-12 lg:w-20 lg:h-20 rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                                <img src="{{ asset('images/icons/play.svg') }}" alt="play" class="w-4 lg:w-6">
                            </button>
                        </div>
                    </div>
                    <!-- video box --> 
                </div>

                <ul class="flex justify-center gap-x-5 items-center mt-5 md:mt-10 lg:mt-11">
                        @foreach(data_get($heroSection, 'content.buttons', []) as $index => $button)
                            <a href="{{ $button['url'] }}"
                                class="inline-flex font-golos justify-center items-center {{ $index == 0 ? 'bg-submit border border-[#9F93A7]/70 hover:!bg-lime' : '!bg-transparent underline hover:!bg-blue' }} rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim  md:text-base px-3 lg:text-lg
                hover:text-primary group lg:my-0 lg:order-1  lg:py-3 lg:px-5">
                                {{ $button['label'] }}
                            </a>
                        @endforeach
                        <li> 
                    </ul>
            </div> 
        </div>  
    </section>
     @endif

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->

    @php
        $featureSection = $sections->where('sectionName', 'feature')->first();
    @endphp 

    @if ($featureSection && $featureSection['is_active']) 
    <!-- feature section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6 class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                        <span class="block h-[2px] w-5 bg-line"></span>
                        {{ data_get($featureSection, 'content.title') }}
                        <span class="block h-[2px] w-5 bg-line-2"></span>
                    </h6>
                    <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                        {{ data_get($featureSection, 'content.title') }} <span
                            class="text-gradient">{{ data_get($featureSection, 'content.gradient_title') }}</span>
                    </h2>
                    <p
                        class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                        {{ data_get($featureSection, 'content.description') }}
                    </p>
            </div>

            <!-- feat card -->
            <div class="w-full grid grid-cols-1 gap-y-5 md:grid-cols-2 gap-5 lg:grid-cols-3 lg:gap-x-6 ">

                 @foreach(data_get($featureSection, 'content.cards', []) as $index => $feat)
                    <div class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                        <img src="{{ asset('/images/home/feat-card.svg') }}" alt="feat card"
                            class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                        <div
                            class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                            <div
                                class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                            <img src="{{ asset('images/icons/b-camp-0' . ($index + 1) . '.svg') }}" alt="icons {{ $index + 1 }}"
        class="w-6 md:w-8 lg:w-10">
                                <img src="{{ asset('images/icons/curve.svg') }}" alt="curve 1"
                                    class="w-[86%] absolute {{ $index == 0 ? 'left-1 top-4' : ($index == 1 ? '!left-0 !top-1 !rotate-90' : 'left-inherit right-1 top-1 rotate-180') }}">
                            </div>
                        </div>

                        <div class="mt-10 lg:mt-[60px]">
                            <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">
                            {{ $feat['title'] }}    
                            </h5>
                            <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">{{ $feat['description'] }} </p>
                        </div>
                    </div>
                @endforeach 
            </div>
            <!-- feat card -->
        </div>
    </section>
    <!-- feature section end -->
    @endif

    <!-- get start section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="get-bg relative py-12 px-8 lg:py-[94px] lg:px-[220px] rounded-[20px] lg:min-h-[365px]">
                <div class="absolute left-0 bottom-0 z-20 w-full h-full flex justify-between">
                    <img src="{{ asset('images/home/get-start-bottom-left.svg') }}" alt="get left"
                        class="rounded-bl-[20px] lg:object-contain rounded-tl-[20px] max-w-[50%]">
                    <img src="{{ asset('images/home/get-start-top-right.svg') }}" alt="get right"
                        class="rounded-tr-[20px] rounded-br-[20px] max-w-[50%] lg:object-contain">
                </div>
                <div class="text-center relative z-30 w-full">
                    <h2 class="font-bold text-2xl lg:text-[44px] text-[#fff] leading-[120%] mb-1">ক্রিয়েটিভিটির ভবিষ্যৎ
                        <span class="text-gradient">এখন আপনার হাতে</span>
                    </h2>
                    <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[120%]">যোগ দিন AI
                        Advertising
                        Bootcamp – 25 এ, হয়ে উঠুন এআই-চালিত ক্রিয়েটিভ প্রফেশনাল।</p>

                    <div class="flex justify-center items-center gap-x-4  mt-5 lg:mt-10 lg:gap-x-5">
                        <a href="#"
                            class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
               hover:!bg-lime md:text-base px-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                            এখনই এনরোল করুন
                        </a>
                        <a href="#"
                            class="inline-flex font-golos justify-center items-center bg-black rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
                 md:text-base lg:text-lg hover:text-orange px-2 group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                            সার্টিফিকেট পান
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- get start section end -->

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const section = document.querySelector('#mainScrol');
            const scrollingLine = document.getElementById('scrolling-line');

            if (section && scrollingLine) {
                window.addEventListener('scroll', function() {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const scrollPosition = window.scrollY;
                    const windowHeight = window.innerHeight;

                    if (scrollPosition > sectionTop - windowHeight / 2 && scrollPosition < sectionTop +
                        sectionHeight - windowHeight / 2) {
                        const scrolled = scrollPosition - (sectionTop - windowHeight / 2);
                        const totalScrollable = sectionHeight;
                        const scrollPercentage = (scrolled / totalScrollable) * 100;
                        scrollingLine.style.height = scrollPercentage + '%';
                    }
                });
            }
        });
    </script>
    <script>
    document.getElementById('play-video-button').addEventListener('click', function(e) {
        e.preventDefault();
        let videoPlayer = document.getElementById('video-player');
        let videoUrl = videoPlayer.getAttribute('data-video-url');

        if (videoUrl) {
            let videoId = '';
            // Check for youtube.com/watch?v=...
            if (videoUrl.includes('youtube.com/watch?v=')) {
                videoId = videoUrl.split('v=')[1];
                const ampersandPosition = videoId.indexOf('&');
                if (ampersandPosition !== -1) {
                    videoId = videoId.substring(0, ampersandPosition);
                }
            }
            // Check for youtu.be/...
            else if (videoUrl.includes('youtu.be/')) {
                videoId = videoUrl.split('youtu.be/')[1];
                const ampersandPosition = videoId.indexOf('&');
                if (ampersandPosition !== -1) {
                    videoId = videoId.substring(0, ampersandPosition);
                }
            }
            // Check for youtube.com/embed/...
            else if (videoUrl.includes('youtube.com/embed/')) {
                videoId = videoUrl.split('embed/')[1];
                const questionMarkPosition = videoId.indexOf('?');
                if (questionMarkPosition !== -1) {
                    videoId = videoId.substring(0, questionMarkPosition);
                }
            }

            if (videoId) {
                videoPlayer.innerHTML = `<iframe class="w-full h-[349px] object-cover rounded-md lg:rounded-[10px] lg:h-[400px]" src="https://www.youtube.com/embed/${videoId}?autoplay=1&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
            } else {
                // Fallback or error message if the URL is not a valid YouTube URL
                console.error('Invalid YouTube URL provided.');
            }
        }
    });
</script>

<script>
    // Hero Slider Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        let currentSlide = 0;
        let slideInterval;

        // Function to show specific slide
        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => {
                slide.classList.remove('active');
                slide.style.opacity = '0';
                slide.style.zIndex = '1';
            });
            
            dots.forEach(dot => {
                dot.classList.remove('active');
                dot.classList.remove('bg-[#E850FF]');
                dot.classList.add('bg-[#fff]/30');
            });

            // Add active class to current slide and dot
            slides[index].classList.add('active');
            slides[index].style.opacity = '1';
            slides[index].style.zIndex = '10';
            
            dots[index].classList.add('active');
            dots[index].classList.add('bg-[#E850FF]');
            dots[index].classList.remove('bg-[#fff]/30');
            
            currentSlide = index;
        }

        // Function to go to next slide
        function nextSlide() {
            let next = (currentSlide + 1) % slides.length;
            showSlide(next);
        }

        // Function to go to previous slide
        function prevSlide() {
            let prev = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prev);
        }

        // Auto-play slider
        function startAutoPlay() {
            slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function stopAutoPlay() {
            clearInterval(slideInterval);
        }

        // Event listeners for navigation buttons
        nextBtn.addEventListener('click', function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });

        prevBtn.addEventListener('click', function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });

        // Event listeners for dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                stopAutoPlay();
                showSlide(index);
                startAutoPlay();
            });
        });

        // Pause auto-play on hover
        const heroSlider = document.querySelector('.hero-slider');
        heroSlider.addEventListener('mouseenter', stopAutoPlay);
        heroSlider.addEventListener('mouseleave', startAutoPlay);

        // Initialize slider
        showSlide(0);
        startAutoPlay();
    });
</script>