<!-- @extends('layouts.guest-modern') -->

@section('title', 'আব্দুর রউফ - AI Creative Training Platform')
@section('description',
    'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম। মাত্র ৩ দিনে আয়ত্ত করুন AI ইমেজ, ভিডিও ও
    মিউজিক জেনারেশন।')

@section('content')
    <!-- hero section start -->
    <section class="w-full pb-1 lg:pb-10 relative">

        {{-- Header --}}
        @include('partials.guest.header-modern')

        <img src="{{ asset('images/hero-ellipse.svg') }}" alt="ellipse"
            class="absolute left-0 top-0 lg:h-full lg:object-contain"> <!-- hero ellipse -->
        <div class="container-x">
            <div class="w-full text-center mt-10 md:mt-14 lg:mt-[90px] relative z-[99]">
                <h1
                    class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    সকল কোর্স
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h1>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">আপনার
                    ক্রিয়েটিভিটির ভবিষ্যৎ <span class="text-gradient">এখন আপনার হাতে</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                    AI Advertising Bootcamp-এ যোগ দিয়ে ডিজিটাল ক্রিয়েটিভিতে দক্ষ হয়ে উঠুন।</p>

                <ul class="flex justify-center gap-x-5 items-center mt-5 md:mt-10 lg:mt-11">
                    <li>
                        <a href="#"
                            class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim
               hover:!bg-lime md:text-base px-3 lg:text-lg
                hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5">
                            এখনই ভর্তি হোন
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="block font-normal text-sm lg:text-lg text-[#fff] anim hover:text-[#fff] underline">সার্টিফিকেট
                            পান
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </section>
    <!-- hero section end -->

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->

    <!-- Filter Section -->
    <section class="filter-section pt-10 lg:pt-20">
        <div class="container-x">
            <div class="w-full">
                <form method="GET" action="{{ route('courses') }}" class="filter-form relative z-40">
                    <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-y-4">
                        <div class="w-full flex gap-x-5 items-center lg:col-span-4">
                            <label for="search" class="text-[#fff] text-sm lg:text-base font-normal min-w-[15%]">কোর্স
                                খুঁজুন</label>
                            <input type="text"
                                class="text-[#fff] border border-[#fff]/20 rounded-md px-3 py-2 font-normal text-sm min-w-[72%] lg:min-w-[68%]"
                                id="search" name="search" value="{{ $search }}"
                                placeholder="কোর্সের নাম লিখুন...">
                        </div>

                        <div class="w-full flex gap-x-5 items-center lg:col-span-3">
                            <label for="category"
                                class="text-[#fff] text-sm lg:text-base font-normal min-w-[15%]">বিভাগ</label>
                            <select
                                class="text-[#fff] border border-[#fff]/20 rounded-md px-3 py-2 font-normal text-sm min-w-[72%] lg:min-w-[70%]"
                                id="category" name="category">
                                <option value="">সকল বিভাগ</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full flex gap-x-5 items-center lg:col-span-3">
                            <label for="sort"
                                class="text-[#fff] text-sm lg:text-base font-normal min-w-[15%]">সাজান</label>
                            <select
                                class="text-[#fff] border border-[#fff]/20 rounded-md px-3 py-2 font-normal text-sm min-w-[72%] lg:min-w-[80%]"
                                id="sort" name="sort">
                                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>নতুন</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>জনপ্রিয়</option>
                                <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>দাম (কম-বেশি)
                                </option>
                                <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>দাম (বেশি-কম)
                                </option>
                                <option value="title_asc" {{ $sort == 'title_asc' ? 'selected' : '' }}>নাম (ক-য)</option>
                            </select>
                        </div>

                        <div class="w-full lg:col-span-2">
                            <div class="flex gap-x-3 items-center justify-center lg:justify-end">
                                <button type="submit"
                                    class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim
               hover:!bg-lime md:text-base px-3 lg:text-lg cursor-pointer
                hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-2 lg:px-4">
                                    <i class="fas fa-search"></i>
                                    খুঁজুন
                                </button>
                                @if ($search || $category || $sort != 'latest')
                                    <a href="{{ route('courses') }}"
                                        class="block font-normal text-sm lg:text-lg text-[#fff] anim hover:text-[#fff] underline">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- our courses section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            @if ($courses->count() > 0)
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-5 lg: gap-x-6">
                    @foreach ($courses as $course)
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
                                        <span class=" text-[#fff]/50 line-through">৳{{ number_format($course->price) }}</s>
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

                @if ($courses->hasPages())
                    <div class=" text-[#fff] mt-4 md:mt-8 lg:mt-10">
                        {{ $courses->links() }}
                    </div>
                @endif
            @else
                <div class="flex justify-center items-center flex-col">
                    <i class="fas fa-search"></i>
                    <h3 class="text-[#fff] font-semibold text-2xl">কোনো কোর্স পাওয়া যায়নি!</h3>
                    <p class="text-[#fff]/40">আপনার অনুসন্ধানের সাথে মিল রয়েছে এমন কোনো কোর্স খুঁজে পাওয়া যায়নি।</p>
                    @if ($search || $category)
                        <a href="{{ route('courses') }}" class="text-[#fff] mt-3 lg:mt-5 font-medium underline">
                            <i class="fas fa-refresh"></i>
                            সব কোর্স দেখুন
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
    <!-- our courses section end -->


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

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to form submit
            const form = document.querySelector('.filter-form');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading"></span> খুঁজছি...';
                submitBtn.disabled = true;

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            });

            // Auto-submit form on select change
            const selects = form.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    // Small delay for better UX
                    setTimeout(() => {
                        form.submit();
                    }, 300);
                });
            });
        });
    </script>
@endsection
