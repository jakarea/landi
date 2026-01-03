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
                            <button class="slider-prev cursor-pointer w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
                                <svg class="w-5 h-5 text-[#fff] transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <button class="slider-next cursor-pointer w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
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
    {{-- <section class="w-full py-10 lg:py-20">
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
                            <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5 mb-3 lg:mb-5">{{ data_get($step, 'title') }}</h4>
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
                            <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5 mb-3 lg:mb-5">{{ data_get($step, 'title') }}</h4>
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
    </section> --}}
    <!-- change your idea section end -->
    @endif

    <!-- our courses section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    আমাদের কোর্স সমূহ
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                    ফিউচার রেডি হতে বেছে নিন   <span class="text-gradient">আপনার পছন্দের স্কিল </span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                    বিগিনার থেকে অ্যাডভান্সড, প্রতিটি কোর্স সাজানো হয়েছে বর্তমান মার্কেটের চাহিদা অনুযায়ী।</p>

                {{-- <div class="flex justify-center items-center gap-x-4  mt-5 lg:mt-10 lg:gap-x-5">
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
                </div> --}}
            </div>
            @if ($latestCourses->count() > 0)
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-5 lg: gap-x-6">
                    @foreach ($latestCourses->slice(0, 3) as $course)
                        {{-- card --}}
                        <div
                            class="w-full border-[1px] border-[#fff] rounded-lg lg:rounded-[21px] bg-[#232323] anim effect-card relative flex flex-col justify-between">
                            <div class="w-full"> 
                                <div class="absolute right-3 top-4 z-30 flex items-center gap-x-2">
                                    @if ($course->review_count > 0)
                                        <p
                                            class="rounded-lg py-1 px-2 text-[#000] bg-orange text-xs font-normal h-5 flex justify-center items-center">
                                            {{ $course->review_count ?? 0 }} রিভিউ
                                        </p>
                                    @endif

                                    @if ($course->enrolled_count > 0)
                                        <p
                                            class="rounded-lg py-1 px-2 text-[#000] bg-lime text-xs font-normal h-5 flex justify-center items-center">
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
                                            class="rounded-lg py-1 px-2 text-[#fff] bg-line text-xs font-normal h-5 flex justify-center items-center border border-[#9F93A7]">
                                            {{ $discount }}% ছাড়</p>
                                    @endif
                                    {{-- offer badge --}}
                                </div>
                                <div class="w-full h-[220px] lg:h-[297px] relative">
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/default-course.jpg') }}"
                                        alt="{{ $course->title }}" class="w-full rounded-t-lg lg:rounded-t-[21px] h-full object-cover"> 
                                </div> 
                            </div> 

                            <div class="p-5 lg:p-7">
                                 <div class="relative z-40">
                                    <a href="{{ route('courses.overview', $course->slug) }}"
                                        class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5 block">
                                        {{ $course->title }}</a>
                                       <p class="text-xs font-normal text-[#ababab]">
                                            {{ \Illuminate\Support\Str::limit($course->short_description, 50) }}

                                            <ul class="flex items-center gap-x-2 mt-2 lg:mt-2.5">
                                                <li>
                                                    <span class="text-xs font-normal text-[#ababab] block">
                                                        🎥 ২০টি ভিডিও  
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="text-xs font-normal text-[#ababab] block">
                                                        |
                                                    </span>
                                                </li>
                                                 <li>
                                                    <span class="text-xs font-normal text-[#ababab] block">
                                                        📁 ১০টি প্রজেক্ট  
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="text-xs font-normal text-[#ababab] block">
                                                        |
                                                    </span>
                                                </li>
                                                 <li>
                                                    <span class="text-xs font-normal text-[#ababab] block">
                                                        ⏰ লাইফটাইম এক্সেস
                                                    </span>
                                                </li>
                                            </ul>
                                        </p>

                                         @if ($course->user)
                                        <div class="flex items-center justify-between mt-3 lg:mt-5">
                                            <div class="w-full flex items-center gap-x-2 lg:gap-x-3">
                                                <img src="http://127.0.0.1:8000/storage/uploads/courses/kylie-solomon-68c94ad38da75.jpg" alt="avatar" class="w-8 h-8 lg:w-[42px] lg:h-[42px] rounded-full object-fill border border-[#fff]">
                                                <p class="text-xs font-normal text-[#ababab]">
                                                    {{ $course->user->name }} <br>
                                                     {{ $course->user->short_bio ? $course->user->short_bio : $course->user->user_role  }}
                                                </p> 
                                            </div>
                                            <p class="text-xs font-normal text-[#ababab] shrink-0"> 
                                                ⭐ {{ number_format($course->average_rating ?? 0, 1) }}
                                            </p>
                                        </div>
                                        @endif 
                                </div>

                                <div class="w-full relative z-40 mt-5 flex items-center justify-between">

                                    @if ($course->offer_price && $course->price > $course->offer_price)
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="price-current text-[#fff] font-semibold text-base lg:text-lg">৳{{ number_format($course->offer_price) }}</span>
                                            <span
                                                class="text-[#E2E8F0]/50 text-xs font-normal">৳{{ number_format($course->price) }}</span>
                                        </div>
                                    @else
                                        <div class="mb-3 lg:mb-4">
                                            <span class="price-current text-[#E2E8F0] font-bold text-lg lg:text-xl">
                                                {{ $course->price > 0 ? '৳' . number_format($course->price) : 'ফ্রি' }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-x-3">
                                        <a href="{{ route('courses.overview', $course->slug) }}" class="text-[#fff] font-normal text-xs">
                                            বিস্তারিত দেখুন
                                        </a>
                                        <a href="{{ route('courses.overview', $course->slug) }}"
                                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1 lg:p-1.5 px-2 lg:px-4 font-medium text-xs text-[#fff] anim hover:text-primary group">
                                        এনরোল করুন
                                    </a>
                                    </div> 
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

    {{-- faq section start --}}
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <!-- common title start -->
           <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    প্রশ্ন উত্তর
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                    সচরাচর জানতে চাওয়া <span class="text-gradient"> প্রশ্নের উত্তর </span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                    আমাদের বুটক্যাম্প থেকে শেখা শিক্ষার্থীদের রিয়েল রিভিউ – যা আপনাকেও এগিয়ে যেতে উৎসাহ দেবে।
                </p>
            </div>
            <!-- common title end -->

            <div class="w-full grid grid-cols-1 gap-y-1 lg:gap-y-4">
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow active"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">এই কোর্সে যোগ দেওয়ার
                            জন্য কি কোনো
                            বিশেষ যোগ্যতার প্রয়োজন আছে?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base active">আমি একজন ডিজাইনার। আগে
                            ডিজাইন করতে ঘন্টার পর ঘন্টা
                            লাগত, কিন্তু এআই শেখার পর কাজ অনেক সহজ হয়েছে। কালার প্যালেট, লেআউট আর ভিজ্যুয়াল তৈরিতে এখন
                            আর ঝামেলা
                            নেই। প্রতিদিনের কাজের গতি বেড়েছে এবং মানও উন্নত হয়েছে। আমার ক্লায়েন্টরা এখন আগের চেয়ে
                            অনেক বেশি
                            সন্তুষ্ট।</p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্সের সময়কাল কতদিন এবং
                            কীভাবে
                            ক্লাসগুলো পরিচালিত হয়?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base">এই কোর্সটি ৩ দিনের জন্য ডিজাইন
                            করা হয়েছে। প্রতিদিন ২-৩ ঘন্টা করে লাইভ ক্লাস থাকবে। ক্লাসগুলো জুম প্ল্যাটফর্মে অনুষ্ঠিত হবে
                            এবং সব ক্লাসের রেকর্ডিং পাবেন যাতে পরে আবার দেখতে পারেন।
                        </p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স ফি কত এবং কি কোনো
                            লুকানো চার্জ
                            আছে?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base">কোর্স ফি মাত্র ৫,৩২০ টাকা। কোনো
                            লুকানো চার্জ নেই। একবার পেমেন্ট করলেই সমস্ত কন্টেন্ট, লাইভ ক্লাস, রেকর্ডেড ক্লাস, এবং
                            সাপোর্ট পাবেন। তাছাড়া বিকাশ, নগদ অন ডেলিভারি সুবিধাও পাবেন।
                        </p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স শেষ করার পর কি কোনো
                            সার্টিফিকেট
                            পাওয়া যাবে?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base">হ্যাঁ, কোর্স সম্পন্ন করার পর
                            আপনার একটি ভেরিফাইড সার্টিফিকেট পাবেন যা আপনার LinkedIn এ শেয়ার করতে পারবেন অথবা চাকরির
                            ইন্টারভিউতে দেখাতে পারবেন। তাছাড়া প্রজেক্ট পোর্টফোলিও পাবেন।
                        </p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">আমি যদি একেবারে নতুন হই,
                            তাহলে কি
                            কোর্সটি বুঝতে পারব?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base">বিলকুল! এই কোর্সটি সম্পূর্ণভাবে
                            বিগিনার-ফ্রেন্ডলি। আমরা সমস্ত টুলস এবং প্রক্রিয়া শূন্য থেকে শেখাবো। কোনো পূর্ব অভিজ্ঞতার
                            প্রয়োজন নেই। প্রতিটি লেসন স্টেপ-বাই-স্টেপ সহজ ভাষায় করা হয়েছে।
                        </p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স শেষে আমি বাস্তবে কী
                            কী কাজে
                            লাগাতে পারব?</h5>

                        <p class="faq-answer text-sm text-secondary-200 lg:text-base">এই কোর্স শেষে আপনি প্রফেশনাল
                            মানের বিজ্ঞাপন, সোশ্যাল মিডিয়া কন্টেন্ট, প্রডাক্ট ভিজুয়াল, ভিডিও তৈরি, মিউজিক এবং ভয়েসওভার
                            তৈরি করতে পারবেন। ফ্রিল্যান্সার হিসেবে কাজ করতে পারবেন অথবা নিজের বিজনেসের জন্য ব্যবহার করতে
                            পারবেন।
                        </p>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                        <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                            class="w-5 lg:w-[26px] faq-icon">
                    </button>
                </div>
                <!-- card -->
            </div>
        </div>
    </section>
    {{-- ?faq section end  --}}

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
                @foreach($reviews as $index => $review)
                    <!-- review card -->
                    <div class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] 
                        {{ $index == 0 ? 'col-span-12 md:col-span-6 lg:col-span-4' : ($index == 1 ? 'col-span-12 md:col-span-6 lg:col-span-3' : ($index == 2 ? 'col-span-12 md:col-span-6 lg:col-span-5' : 'col-span-12 md:col-span-6 lg:col-span-4')) }} review-card">
                        <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">
                            {{ $review->review_text }}
                        </p>

                        <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                        <div class="w-full flex items-center justify-between">
                            <div class="flex items-center gap-x-3">
                                <img src="{{ asset($review->reviewer_avatar ?? 'images/avatar.webp') }}" alt="{{ $review->reviewer_name }}"
                                    class="w-10 h-10 rounded-full object-contain">

                                <div>
                                    <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                        {{ $review->reviewer_name }}
                                    </h5>
                                    <h6 class="common-para !text-xs text-secondary-200">{{ $review->reviewer_designation }}</h6>
                                </div>
                            </div>
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>
                        </div>
                    </div>
                    <!-- review card -->
                @endforeach
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
                       আপকামিং লাইভ বুটক্যাম্প 
                        <span class="block h-[2px] w-5 bg-line-2"></span>
                    </h1>
                    <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                       মাত্র ৩ দিনে শিখুন AI ক্রিয়েটিভ -  <span
                            class="text-gradient">ক্যারিয়ারে আনুন গতির ঝড়</span>
                    </h2>
                    <p
                        class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                       ৩ দিনের এই ইনটেনসিভ বুটক্যাম্পে মেন্টর আব্দুর রউফ এর সাথে শিখুন প্রফেশনাল কন্টেন্ট ক্রিয়েশন।
বুটক্যাম্পে চলবে আগামী ১লা জানুয়ারি ২০২৬ থেকে ৪ঠা জানুয়ারি পর্যন্ত।

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
            <div class="w-full mt-8 md:mt-12 lg:mt-[62px] lg:max-w-[80%] mx-auto"> 
                <!-- video url -->
                <div
                    class="w-full bg-[#131620] border border-[#232323] p-3 lg:p-5 rounded-md lg:rounded-[20px] grid grid-cols-1 gap-2 lg:gap-2.5">
                    <div class="w-full relative" id="video-player" data-video-url="{{ data_get($heroSection, 'content.video_url') }}">   
                        <img src="{{asset('/images/speaking-person.png')}}" alt="robot"
                            class="w-full h-[349px] object-cover rounded-md lg:rounded-[10px] lg:h-[700px]">
                        <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                            <button type="button" id="play-video-button"
                                class="w-12 h-12 lg:w-20 lg:h-20 rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                                <img src="{{ asset('images/icons/play.svg') }}" alt="play" class="w-4 lg:w-6">
                            </button>
                        </div>
                    </div>
                    <!-- video box --> 
                </div> 
            </div> 
        </div>  
    </section>
     @endif

     <!-- payment section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div
                class="w-full bg-submit rounded-[10px] py-5 px-6 flex flex-col lg:flex-row justify-center items-center text-center lg:justify-between border border-[#49484E]/50">
                <div class="lg:text-start">
                    <h5 class="font-medium text-lg white-70 lg:text-2xl">Ai অ্যাডভার্টাইজিং <span
                            class="text-gradient">বুটক্যাম্প -
                            ২৫</span></h5>
                    <p class="font-medium text-sm text-[#ABABAB] mt-1 lg:text-base">৩ দিনের অনলাইন লাইভ ওয়ার্কশপ |
                        প্রশিক্ষক: আব্দুর রউফ</p>
                </div>
                <h6 class="font-medium text-base text-[#C7C7C7] mt-6 lg:text-2xl lg:mt-0">কোর্স ফি মাত্র <span
                        class="text-orange font-bold lg:text-3xl">৳৫,৩২০</span> টাকা</h6>
            </div>

            <div
                class="w-full bg-card/80 rounded-[10px] py-5 px-4 mt-10 divide-y lg:divide-x lg:divide-y-0 divide-[#fff]/10 lg:p-10 lg:mt-12 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-10 border border-[#49484E]/50">
                <div class="left pb-10 lg:pb-0">
                    <h3 class="text-center font-medium text-2xl text-[#fff] lg:text-start lg:text-[32px]">এখনই সহজে
                        পেমেন্ট করুন</h3>
                    <p
                        class="font-medium text-sm text-[#ABABAB] mt-1 text-center lg:text-start lg:text-base lg:max-w-[80%]">
                        আমাদের কোর্সে ভর্তি হতে পেমেন্ট করা একেবারেই
                        সহজ। বিকাশ, নগদ বা রকেট দিয়ে পেমেন্ট করলেই সঙ্গে সঙ্গে কোর্স এক্সেস পাবেন।</p>

                    <h4
                        class="mt-10 font-medium text-base white-70 text-center mb-2.5 lg:mt-[60px] lg:text-xl lg:text-start">
                        এই নম্বরে পেমেন্ট করুন</h4>

                    <div
                        class="flex bg-[#011330] justify-between items-center max-w-[80%] rounded-[4px] mx-auto p-1.5 pl-4 lg:mx-0 lg:mr-auto lg:max-w-[46%] lg:rounded-lg">
                        <h5 class="font-bold text-xl text-gradient lg:text-2xl">০১৭১২৩৪৫৬৭৮</h5>
                        <button type="button" onclick="copyPhoneNumber(); return false;"
                            class="bg-[#0B2042] rounded-[2px] py-2 px-3 font-normal text-xs text-blue lg:text-sm anim hover:bg-orange hover:text-primary cursor-pointer anim animate-pulse z-50 pointer-events-auto"
                            style="position: relative; z-index: 1000 !important; pointer-events: auto !important;">কপি
                            করুন</button>
                    </div>

                    <h6 class="mt-6 font-medium white-70 text-base lg:mt-[30px] lg:text-lg">বিশেষ দ্রষ্টব্য</h6>

                    <ul class="mt-2.5 flex flex-col gap-y-1">
                        <li class="flex items-center gap-x-2">
                            <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                            <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                                Transaction ID সংরক্ষণ করুন, ভুল নম্বরে পাঠালে দায়ভার আমাদের নয়।
                            </p>
                        </li>
                        <li class="flex items-center gap-x-2">
                            <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                            <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                                সফল পেমেন্টে SMS/ইমেইল পাবেন।
                            </p>
                        </li>
                        <li class="flex items-center gap-x-2">
                            <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                            <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                                টাকা ফেরতযোগ্য নয়, সমস্যায় <a href="#" class="text-orange underline">সাপোর্টে
                                    যোগাযোগ করুন।</a>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="right pt-10 lg:pt-0">
                    <h5 class="font-medium text-base white-70 text-center mb-2.5 lg:text-lg lg:text-start">আপনার
                        পেমেন্ট করা মাধ্যমটি বেছে নিন</h5>

                    <!-- Error and Success Messages -->
                    @if (session('success'))
                        <div
                            class="bg-green-600/30 border-2 border-green-400 text-green-300 p-5 rounded-xl mb-6 animate-pulse shadow-lg">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-xl"></i>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-green-200 mb-2">🎉 নিবন্ধন সফল হয়েছে!</h4>
                                    <p class="text-green-300 mb-4">{{ session('success') }}</p>
                                    <div class="bg-green-800/40 border border-green-500/50 rounded-lg p-4">
                                        <p class="text-sm text-green-200 font-semibold mb-2">
                                            <i class="fas fa-arrow-right mr-2"></i>পরবর্তী পদক্ষেপ:
                                        </p>
                                        <ul class="text-sm text-green-300 space-y-1">
                                            <li><i class="fas fa-key mr-2"></i>লগিন করে পাসওয়ার্ড আপডেট করুন</li>
                                            <li><i class="fas fa-graduation-cap mr-2"></i>কোর্সে অ্যাক্সেস পান</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="bg-red-600/30 border-2 border-red-400 text-red-300 p-5 rounded-xl mb-6 animate-bounce shadow-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-400 mr-3 text-xl"></i>
                                <div>
                                    <h4 class="font-bold text-lg text-red-200 mb-1">ত্রুটি!</h4>
                                    <p class="text-red-300">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-600/30 border-2 border-red-400 text-red-300 p-5 rounded-xl mb-6 shadow-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-1 text-xl"></i>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-red-200 mb-3">নিবন্ধনে সমস্যা হয়েছে</h4>
                                    <div class="space-y-2">
                                        @foreach ($errors->all() as $error)
                                            <div
                                                class="flex items-start bg-red-800/30 border border-red-500/50 rounded-lg p-3">
                                                <i class="fas fa-times-circle text-red-400 mr-2 mt-0.5"></i>
                                                <p class="text-red-200 text-sm">
                                                    @if (str_contains(strtolower($error), 'email'))
                                                        <strong>ইমেইল সমস্যা:</strong> এই ইমেইল ঠিকানা দিয়ে ইতিমধ্যে
                                                        একটি অ্যাকাউন্ট রয়েছে! অন্য ইমেইল ব্যবহার করুন।
                                                    @else
                                                        {{ $error }}
                                                    @endif
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="enrollment-form" action="{{ route('ai-bootcamp.enroll') }}" method="POST"
                        class="block mt-5 lg:mt-3 lg:grid lg:grid-cols-12 lg:gap-x-5">
                        @csrf
                        <!-- Hidden Fields -->
                        <input type="hidden" name="course_id" value="1">
                        <input type="hidden" name="instructor_id" value="2">
                        <input type="hidden" name="amount" value="320" id="course-amount">
                        <div
                            class="flex w-full justify-between items-center gap-x-5 lg:justify-start lg:gap-x-6 lg:mb-[60px] lg:col-span-12">
                            <label for="nagad"
                                class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                                <input type="radio" name="payment" id="nagad" value="nogod" checked>
                                <img src="./images/icons/nagad.svg" alt="nagad" class="max-w-20">
                            </label>
                            <label for="bkash"
                                class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                                <input type="radio" name="payment" id="bkash" value="bkash">
                                <img src="./images/icons/bkash.svg" alt="bkash" class="max-w-20">
                            </label>
                            <label for="rocket"
                                class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-24 h-12">
                                <input type="radio" name="payment" id="rocket" value="rocket">
                                <img src="./images/icons/rocket.svg" alt="rocket" class="max-w-[50px]">
                            </label>
                        </div>
                        <div class="w-full mt-5 lg:col-span-6">
                            <label for="name" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                                নাম</label>
                            <input type="text" name="name" id="name" placeholder="নাম"
                                class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                required>
                        </div>
                        <div class="w-full mt-5 lg:col-span-6">
                            <label for="email" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                                ইমেইল</label>
                            <input type="email" name="email" id="email" placeholder="ইমেইল"
                                class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                required>
                        </div>
                        <div class="w-full mt-5 lg:col-span-6">
                            <label for="phone" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                                নম্বর</label>
                            <input type="text" name="phone" id="phone" placeholder="নম্বর"
                                class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                                required>
                        </div>
                        <div class="w-full mt-5 lg:col-span-6">
                            <label for="transaction_id"
                                class="font-medium text-base white-70 block w-full mb-2.5">পেমেন্ট ট্রানজেকশন
                                ID</label>
                            <input type="text" name="transaction_id" id="transaction_id"
                                placeholder="ট্রানজেকশন ID"
                                class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400">
                        </div>

                        <div class="w-full flex justify-center lg:col-span-12 lg:justify-end">
                            <button type="submit"
                                class="bg-submit hover:!bg-lime hover:text-primary py-2 px-4 font-medium text-base white-70 mt-5 anim cursor-pointer lg:text-xl lg:py-3.5 lg:px-6 rounded-[10px] ">কনফার্ম
                                করুন</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- payment section end -->  

    <!-- get start section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">

             <div class="text-center mb-10 md:mb-16 lg:mb-20">
                
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                   আপনার আইডিয়াকে বদলে দিন <span class="text-gradient"> এআই ক্রিয়েশনে </span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                   সঠিক পদ্ধতিতে, ধাপে ধাপে এবং কৌশল ব্যবহার করে আপনার স্কিলকে দ্রুত দক্ষ করে তুলুন
                </p>
            </div>

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
                videoPlayer.innerHTML = `<iframe class="w-full h-[349px] object-cover rounded-md lg:rounded-[10px] lg:h-[700px]" src="https://www.youtube.com/embed/${videoId}?autoplay=1&controls=0&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
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

     // FAQ Accordion functionality
        function toggleFAQ(element) {
            const faqItems = document.querySelectorAll('.faq-item');
            const answer = element.querySelector('.faq-answer');
            const isCurrentlyActive = element.classList.contains('active');

            // Close all FAQ items first
            faqItems.forEach(item => {
                const itemAnswer = item.querySelector('.faq-answer');
                item.classList.remove('active');
                itemAnswer.classList.remove('active');
            });

            // If the clicked item wasn't active, open it
            if (!isCurrentlyActive) {
                element.classList.add('active');
                answer.classList.add('active');
            }
        }

        // Initialize FAQ - Make first item active by default
        document.addEventListener('DOMContentLoaded', function() {
            const firstFAQItem = document.querySelector('.faq-item');
            if (firstFAQItem) {
                // The first FAQ already has 'active' class in HTML, so no need to set it again
                // This ensures the first FAQ is open by default
            }
        });
</script>