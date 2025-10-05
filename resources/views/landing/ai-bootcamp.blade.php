<!doctype html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    @yield('style')
 

    <title>আব্দুর রউফ</title>

    {{-- Marketing Tracking Codes --}}
    @include('partials.tracking-codes')
</head>

<body class="bg-[#0A0A0A]">

    {{-- cta sticky --}}
    <div class="fixed right-6 bottom-10 z-50 hidden lg:inline-block">
        <button id="scroll-button" type="button" onclick="scrollToEnrollmentForm(); return false;"
            class="inline-flex font-golos justify-center items-center bg-cta rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-primary gap-x-3 anim opacity-0
               !bg-lime md:text-base px-3 lg:text-lg
                hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5">
            এখনই ভর্তি হোন
        </button>
    </div>

    {{-- Marketing Tracking Codes (Body) --}}
    @include('partials.tracking-codes-body')

    <!-- first section start -->
    <section class="w-full pt-12 pb-20 first-gradient relative overflow-hidden border-b border-[#fff]/10 xl:py-[188px]">

        <div class="absolute inset-0 grid-background opacity-[7%] z-10" style="pointer-events: none;"></div>
        <!-- line elements -->

        <img src="/images/section-one-shadow.svg" class="absolute inset-0 left-0 top-0 w-full h-full z-30"
            alt="shadow" style="pointer-events: none;">

        <div class="container-x">
            <div class="w-full grid grid-cols-1 lg:grid-cols-2 lg:gap-x-20 xl:gap-x-[105px] lg:items-center">
                <div class="w-full">
                    <div class="w-full flex justify-center items-center gap-x-2.5 relative z-40 lg:justify-start">
                        <!-- icon -->
                        <div
                            class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                            <img src="/images/icons/b-camp-01.svg" alt="icon 1" class="w-6">
                        </div>
                        <!-- icon -->
                        <!-- icon -->
                        <div
                            class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                            <img src="/images/icons/b-camp-02.svg" alt="icon 2" class="w-6">
                        </div>
                        <!-- icon -->
                        <!-- icon -->
                        <div
                            class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                            <img src="/images/icons/b-camp-03.svg" alt="icon 3" class="w-6">
                        </div>
                        <!-- icon -->
                    </div>
                    <div class="text-center relative z-40 lg:text-start">
                        <h1 class="text-orange font-medium text-sm my-2.5 lg:text-base">বিজ্ঞাপনের জন্য AI বুটক্যাম্প -
                            ২৫</h1>
                        <h2 class="font-bold text-[28px] leading-[110%] text-[#fff] lg:text-[40px]">Ai অ্যাডভার্টাইজিং
                            <span class="text-gradient">বুটক্যাম্প -
                                ২৫</span>
                        </h2>
                        <h3 class="text-[#ABABAB] mt-2 font-medium text-sm lg:text-base">৩ দিনের অনলাইন লাইভ ওয়ার্কশপ |
                            প্রশিক্ষক: আব্দুর
                            রউফ
                        </h3>
                        <p
                            class="text-[#ABABAB] mt-[30px] font-normal text-sm md:text-base lg:text-lg lg:max-w-[80%] xl:max-w-[80%]">
                            এই বুটক্যাম্পে আপনি হাতে-কলমে শিখবেন AI ইমেজ,
                            ভিডিও
                            ও মিউজিক ক্রিয়েশন যা বিজ্ঞাপন, কনটেন্ট ক্রিয়েশন এবং
                            আধুনিক মার্কেটিং জগতে আপনাকে এগিয়ে রাখবে। আন্তর্জাতিক মানের টেকনিক, প্রম্পট ইঞ্জিনিয়ারিং,
                            টুলস এবং
                            প্রজেক্ট-ভিত্তিক শেখানোর মাধ্যমে আপনি হয়ে উঠবেন একজন AI-powered ক্রিয়েটিভ প্রফেশনাল।</p>

                        <div class="w-full lg:flex lg:items-center lg:gap-x-[30px] lg:mt-[30px]">
                            <h4
                                class="mt-[30px] mb-2.5 font-medium text-sm text-secondary-100 underline lg:my-0 lg:order-2 lg:text-lg">
                                কোর্স ফি
                                মাত্র <strong class="text-orange underline">৳৫,৩২০</strong> টাকা</h4>
                            <!-- Primary Enrollment Button -->
                            <button type="button" onclick="scrollToEnrollmentForm(); return false;"
                                class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] pl-4 gap-x-2.5 anim
               hover:!bg-lime md:text-base lg:text-base lg:p-2.5 lg:pl-4.5 hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 cursor-pointer z-50 pointer-events-auto"
                                style="position: relative; z-index: 1000 !important; pointer-events: auto !important;">
                                এখনই এনরোল করুন
                                <span
                                    class="w-[30px] h-[30px] rounded-full bg-[#fff]/40 flex items-center justify-center anim group-hover:bg-primary">
                                    <svg width="17" height="10" viewBox="0 0 17 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.3672 8.78662L15.6601 5.49373C16.0506 5.1032 16.0506 4.47004 15.6601 4.07951L12.3672 0.786621M15.3672 4.78662L1.36719 4.78662"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="text-center relative z-40 mt-7 lg:max-w-[90%] lg:mt-0">
                    {{-- work here --}}
                     <div class="w-full col-span-12 md:col-span-6 lg:col-span-4 grid grid-cols-12 gap-5">
 
                    <div class="w-full relative col-span-8 lg:col-span-6">
                        <div class="w-full relative mb-5">
                            <img src="/images/project-09.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Image</p>
                        </div>
                        <div class="w-full relative hidden lg:block">
                            <img src="/images/project-06.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai monalisa</p>
                        </div>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-4 lg:col-span-6">
                        <div class="w-full relative">
                            <img src="/images/project-05.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Music</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!-- first section end -->

    <!-- ai advertising section start -->
    <section class="w-full pt-20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/book.svg" alt="icon book" class="">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">এক নজরে আমাদের Ai অ্যাডভার্টাইজিং
                    <span class="text-gradient">বুটক্যাম্প-২৫</span>
                </h2>
                <p class="common-para text-secondary-200">এই কোর্সে যা যা থাকছে</p>
            </div>
            <!-- common title end -->
            <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 lg:gap-y-0 xl:gap-x-[45px]">
                <!-- card -->
                <div class="rounded-[10px] p-[30px] bg-black ai-card text-center min-h-[318px]">
                    <img src="/images/icons/feat-01.svg" alt="feat icon 01" class="w-10 mx-auto lg:w-[60px]">
                    <h4 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">AI ইমেজ জেনারেশন ও প্রম্পটিং
                    </h4>
                    <p class="common-para text-secondary-200 lg:!text-[15px] lg:leading-[150%]">বাংলাদেশ ও বিশ্বজুড়ে
                        বিজ্ঞাপনে AI এর প্রভাব,
                        প্রম্পট ইঞ্জিনিয়ারিং, শীর্ষ AI টুলস, পারফেক্ট ইমেজ কম্পোজিশন, ক্যারেক্টার ট্রেনিং, ফেস সোয়াপ ও
                        এডিটিং
                        শেখানো হবে।</p>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="rounded-[10px] p-[30px] bg-card ai-card ai-card-variant text-center min-h-[318px]">
                    <img src="/images/icons/feat-02.svg" alt="feat icon 02" class="w-10 mx-auto lg:w-[60px]">
                    <h4 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">AI ভিডিও জেনারেশন</h4>
                    <p class="common-para text-secondary-200 lg:!text-[15px] lg:leading-[150%]">ভিডিও প্রম্পট তৈরি,
                        প্রম্পট থেকে ভিডিও, ইমেজ থেকে
                        ভিডিও, অডিও সহ ভিডিও, লিপসিঙ্ক এবং ভয়েস অ্যানিমেশন কৌশল শেখানো হবে।</p>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="rounded-[10px] p-[30px] bg-card ai-card text-center min-h-[318px]">
                    <img src="/images/icons/feat-03.svg" alt="feat icon 02" class="w-10 mx-auto lg:w-[60px]">
                    <h4 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">AI মিউজিক ও ভয়েস জেনারেশন</h4>
                    <p class="common-para text-secondary-200 lg:!text-[15px] lg:leading-[150%]">AI দিয়ে জিঙ্গল,
                        ব্যাকগ্রাউন্ড স্কোর, গান, ভয়েসওভার
                        স্ক্রিপ্ট লেখা, ভয়েসওভার জেনারেশন এবং ভিডিওর জন্য সাউন্ড ইফেক্ট তৈরি শেখানো হবে।</p>
                </div>
                <!-- card -->
            </div>
        </div>
    </section>
    <!-- ai advertising section end -->

    <!-- module learning plan start -->
    <section class="w-full py-20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/check-list.svg" alt="icon book" class="">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">স্টেপ–বাই–স্টেপ মডিউল <span
                        class="text-gradient"> লার্নিং প্ল্যান</span></h2>
                <p class="common-para text-secondary-200">৩ ধাপে সাজানো কোর্স পরিকল্পনা</p>
            </div>
            <!-- common title end -->

            <!-- learning steps -->
            <div class="w-full grid grid-cols-1 lg:grid-cols-11 gap-y-10 lg:gap-y-0 lg:gap-x-[58px] lg:items-center">
                <div class="img order-2 lg:order-1 lg:col-span-5">
                    <img src="/images/learning-steps.webp" alt="learning-steps" class="w-full rounded-[10px]">
                </div>
                <div class="txt order-1 lg:order-2 lg:col-span-5">
                    <div class="flex flex-col gap-y-2.5 lg:gap-y-6">
                        <!-- card -->
                        <div
                            class="item bg-[#010101] rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-center gap-x-2.5 lg:pr-5 border border-[#49484E] lg:rounded-[20px] gradient-border-only">
                            <span
                                class="block bg-[#07101D] rounded-[10px] p-2.5 text-base font-bold text-[#2669D0] col-span-2 text-center lg:text-2xl lg:text-[#fff] lg:max-w-[85%] lg:py-4 shrink-0">Day
                                <br>
                                1</span>
                            <div class="w-full col-span-8 lg:pt-4">
                                <h5 class="text-[#E2E8F0] font-medium text-base lg:text-xl">AI Image Generation &amp;
                                    Prompting</h5>
                                <h6 class="text-[#ABABAB] font-normal text-xs lg:text-base mt-2 lg:mt-3">০৭ ধাপে শিখুন
                                    – হয়ে উঠুন ইমেজ
                                    জেনারেশনের সম্রাট</h6>
                            </div>
                            {{-- <button type="button" class="col-span-2 flex justify-end">
                                <img src="/images/icons/angle-down-circle.svg" alt="angle 1"
                                    class="w-5 lg:w-[30px]">
                            </button> --}}
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div
                            class="item bg-[#010101] rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-center gap-x-2.5 lg:pr-5 border border-[#49484E] lg:rounded-[20px] gradient-border-only gradient-border-only-variant">
                            <span
                                class="block bg-[#07101D] rounded-[10px] p-2.5 text-base font-bold text-[#2669D0] col-span-2 text-center lg:text-2xl lg:text-[#fff]  lg:max-w-[85%] lg:py-4 shrink-0">Day
                                <br>
                                2</span>
                            <div class="w-full col-span-8 lg:pt-4">
                                <h5 class="text-[#E2E8F0] font-medium text-base lg:text-xl">AI Video Generation</h5>
                                <h6 class="text-[#ABABAB] font-normal text-xs lg:text-base mt-2 lg:mt-3">৫ সহজ ধাপেই
                                    আয়ত্ত করুন ভিডিও
                                    কনটেন্ট তৈরির সম্পূর্ণ দক্ষতা</h6>
                            </div>
                            {{-- <button type="button" class="col-span-2 flex justify-end">
                                <img src="/images/icons/angle-down-circle.svg" alt="angle 2"
                                    class="w-5 lg:w-[30px]">
                            </button> --}}
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div
                            class="item bg-[#010101] rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-center gap-x-2.5 lg:pr-5 border border-[#49484E] lg:rounded-[20px] gradient-border-only">
                            <span
                                class="block bg-[#07101D] rounded-[10px] p-2.5 text-base font-bold text-[#2669D0] col-span-2 text-center lg:text-2xl lg:text-[#fff]  lg:max-w-[85%] lg:py-4 shrink-0">Day
                                <br>
                                3</span>
                            <div class="w-full col-span-8 lg:pt-4">
                                <h5 class="text-[#E2E8F0] font-medium text-base lg:text-xl">AI Song, Jingle, Voiceover
                                    &amp;
                                    SFX</h5>
                                <h6 class="text-[#ABABAB] font-normal text-xs lg:text-base mt-2 lg:mt-3">৫ সহজ ধাপেই
                                    আয়ত্ত করুন ভিডিও
                                    কনটেন্ট তৈরির সম্পূর্ণ দক্ষতা</h6>
                            </div>
                            {{-- <button type="button" class="col-span-2 flex justify-end">
                                <img src="/images/icons/angle-down-circle.svg" alt="angle 3"
                                    class="w-5 lg:w-[30px]">
                            </button> --}}
                        </div>
                        <!-- card -->
                    </div>
                </div>
            </div>
            <!-- learning steps -->
        </div>
    </section>
    <!-- module learning plan end -->

    <!-- tools used start -->
    <section class="w-full py-20 bg-tools border-y border-[#fff]/20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/tools.svg" alt="icon book" class="">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">কোর্সে যেসব AI টুলস সরাসরি <span
                        class="text-gradient"> ব্যবহার করবেন</span>
                </h2>
                <p class="common-para text-secondary-200">কোর্সে শিখবেন যে AI টুলস</p>
            </div>
            <!-- common title end -->

            <!-- tools -->
            <div class="w-full grid grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-6">
                <!-- tool -->
                <div
                    class="text-center bg-transparent anim hover:!bg-[#000] rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-01.svg" alt="tools-01" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool -->
                <!-- tool -->
                <div
                    class="text-center bg-transparent rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-02.svg" alt="tools-02" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool -->
                <!-- tool -->
                <div
                    class="text-center bg-transparent rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-03.svg" alt="tools-03" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool -->
                <!-- tool -->
                <div
                    class="text-center bg-transparent rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-04.svg" alt="tools-04" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool -->
                <!-- tool -->
                <div
                    class="text-center bg-transparent rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-05.svg" alt="tools-05" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool -->
                <!-- tool -->
                <div
                    class="text-center bg-transparent rounded-[10px] flex justify-center items-center px-2 py-4 anim group w-[111px] h-[111px] lg:w-[170px] lg:h-[170px] cursor-pointer border border-[#909090] tool-hover-glow">
                    <img src="/images/tools-06.svg" alt="tools-06" class="max-w-fit smooth-bounce">
                </div>
                <!-- tool --> 
            </div>
            <!-- tools -->
        </div>
    </section>
    <!-- tools used end -->

    <!-- projects section start -->
    {{-- <section class="w-full pt-20 lg:pt-[90px]">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/bulb.svg" alt="icon bulb" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">হাতে-কলমে প্র্যাকটিক্যাল <span
                        class="text-gradient"> প্রজেক্ট থাকবে</span></h2>
                <p class="common-para text-secondary-200">১৫টি বাস্তব প্রজেক্টের মাধ্যমে শিখবেন কার্যকরী স্কিল</p>
            </div>
            <!-- common title end -->

            <div class="w-full grid grid-cols-12 gap-5">
                <!-- group one -->
                <div class="w-full col-span-12 md:col-span-6 lg:col-span-4 grid grid-cols-12 gap-5">
                    <!-- item -->
                    <div class="w-full relative col-span-12">
                        <img src="/images/project-01.png" alt="project-01"
                            class="w-full rounded-[10px] project-image">
                        <p
                            class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                            Ai
                            video by prompt</p>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-8 lg:col-span-6">
                        <div class="w-full relative mb-5">
                            <img src="/images/project-04.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Image</p>
                        </div>
                        <div class="w-full relative hidden lg:block">
                            <img src="/images/project-06.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai monalisa</p>
                        </div>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-4 lg:col-span-6">
                        <div class="w-full relative">
                            <img src="/images/project-05.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Music</p>
                        </div>
                    </div>
                </div>
                <!-- group one -->
                <!-- group two -->
                <div class="w-full col-span-12 md:col-span-6 lg:col-span-4 grid-cols-12 gap-5 hidden md:grid">
                    <!-- item -->
                    <div class="w-full relative col-span-8 lg:col-span-6">
                        <div class="w-full relative mb-5">
                            <img src="/images/project-04.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Image</p>
                        </div>
                        <div class="w-full relative hidden lg:block">
                            <img src="/images/project-06.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai monalisa</p>
                        </div>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-4 lg:col-span-6">
                        <div class="w-full relative">
                            <img src="/images/project-05.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Music</p>
                        </div>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-12">
                        <img src="/images/project-01.png" alt="project-01"
                            class="w-full rounded-[10px] project-image">
                        <p
                            class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                            Ai
                            video by prompt</p>
                    </div>

                </div>
                <!-- group two -->
                <!-- group three -->
                <div class="w-full col-span-12 md:col-span-6 lg:col-span-4 grid-cols-12 gap-5 hidden lg:grid">
                    <!-- item -->
                    <div class="w-full relative col-span-12">
                        <img src="/images/project-01.png" alt="project-01"
                            class="w-full rounded-[10px] project-image">
                        <p
                            class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                            Ai
                            video by prompt</p>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-8 lg:col-span-6">
                        <div class="w-full relative mb-5">
                            <img src="/images/project-04.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Image</p>
                        </div>
                        <div class="w-full relative hidden lg:block">
                            <img src="/images/project-06.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai monalisa</p>
                        </div>
                    </div>
                    <!-- item -->
                    <div class="w-full relative col-span-4 lg:col-span-6">
                        <div class="w-full relative">
                            <img src="/images/project-05.png" alt="project-04"
                                class="w-full rounded-[10px] project-image">
                            <p
                                class="rounded-full py-1 px-2 lg:py-2 lg:px-4 bg-[#fff]/20 text-[#fff] text-xs md:textbase lg:text-xl absolute bottom-2 left-2 lg:bottom-6 lg:left-6">
                                Ai Music</p>
                        </div>
                    </div>
                </div>
                <!-- group three -->
            </div>
        </div>
    </section> --}}
    <!-- projects section end -->

    {{-- big video section start --}}
    <section class="w-full py-20">
        <div class="container-x">
            <div class="hero-image-wrap p-0 relative cursor-pointer"
                        onclick="openVideoModal('https://www.youtube.com/embed/tA0hYGfKSRc?autoplay=1'); return false;"
                        style="pointer-events: auto !important; z-index: 100 !important;">
                        <img src="/images/speaking-person.png" alt="speaking-person"
                            class="rounded-[calc(0.75rem-2px)] w-full hero-img shadow-1">
                        <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center z-0">
                            <button type="button"
                                onclick="openVideoModal('https://www.youtube.com/embed/tA0hYGfKSRc?autoplay=1'); return false;"
                                class="w-[90px] h-[90px] rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim hover:bg-[#fff]/60 transition-all duration-200"
                                style="pointer-events: auto !important; z-index: 101 !important;">
                                <img src="/images/icons/play.svg" alt="play" class="w-8">
                            </button>
                        </div>
                    </div>
        </div>
    </section>

    <!-- course achivement start -->
    <section class="w-full py-20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/achivement.svg" alt="achivement bulb" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">কোর্স শেষে আপনার <span
                        class="text-gradient"> অর্জন</span></h2>
                <p class="common-para text-secondary-200">এই কোর্স শেষ করলে যা যা শিখবেন ও পাবেন আমাদের কাছ থেকে</p>
            </div>
            <!-- common title end -->

            <!-- achovement -->
            <div
                class="w-full grid grid-cols-1 lg:grid-cols-3 lg:divide-x lg:divide-[#fff]/20 bg-card rounded-[10px] bg-all">
                <!-- card -->
                <div
                    class="bg-transparent rounded-t-[10px] text-center p-4 py-14 lg:rounded-none lg:rounded-l-[10px] lg:px-12 lg:py-24">
                    <img src="./images/icons/achivement-01.svg" alt="achivement 01" class="mx-auto lg:w-[77px]">
                    <h5 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">Live Hands-on Demos</h5>
                    <p class="common-para text-secondary-200 lg:!text-[15px]">রিয়েল-টাইমে শিখবেন AI ইমেজ, ভিডিও ও
                        মিউজিক তৈরির
                        টুলস এবং টেকনিক প্র্যাকটিক্যাল ওয়ার্কশপ স্টাইল সেশনে।</p>
                    <div class="bg-[#fff]/10 w-full h-px mt-20 lg:hidden"></div>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="bg-transparent text-center p-4 pb-14 lg:pb-4 lg:px-12 lg:py-24">
                    <img src="./images/icons/achivement-02.svg" alt="achivement 01" class="mx-auto lg:w-[64px]">
                    <h5 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">Certificate of Completion</h5>
                    <p class="common-para text-secondary-200 lg:!text-[15px]">কোর্স শেষে পাবেন অফিসিয়াল সার্টিফিকেট,
                        যা আপনার
                        প্রফেশনাল প্রোফাইল বা পোর্টফোলিওতে যুক্ত করতে পারবেন।</p>
                    <div class="bg-[#fff]/10 w-full h-px mt-20 lg:hidden"></div>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="bg-transparent rounded-b-[10px] text-center p-4 pb-14 lg:rounded-none lg:rounded-r-[10px] lg:px-12 lg:py-24">
                    <img src="./images/icons/achivement-02.svg" alt="achivement 01" class="mx-auto lg:w-[57px]">
                    <h5 class="mt-10 text-blue font-semibold text-lg mb-2.5 lg:text-xl">Q&A + Community Access</h5>
                    <p class="common-para text-secondary-200 lg:!text-[15px]">সরাসরি প্রশ্ন করার সুযোগ এবং বিশেষ
                        কমিউনিটিতে
                        অ্যাক্সেস যেখানে থাকছে সহায়তা, নেটওয়ার্কিং ও ভবিষ্যৎ আপডেট।</p>
                </div>
                <!-- card -->
            </div>
            <!-- achovement -->
        </div>
    </section>
    <!-- course achivement end -->

    <!-- instructor details -->
    <section class="w-full py-20 relative bg-instructor">
        <div class="absolute inset-0 grid-background opacity-[13%] z-10" style="pointer-events: none;"></div>
        <!-- line elements, animate-pulse -->
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/instructor.svg" alt="achivement bulb" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">আপনার কোর্স <span
                        class="text-gradient">
                        ইন্সট্রাক্টর</span></h2>
                <p class="common-para text-secondary-200">আপনার সাফল্যের সঙ্গী</p>
            </div>
            <!-- common title end -->

            <div class="w-full grid grid-cols-1 lg:grid-cols-2 lg:gap-x-20 xl:gap-x-[105px] lg:items-center">
                <div class="w-full">

                    <div class="text-center relative z-40 lg:text-start">

                        <h2 class="font-bold text-[28px] leading-[110%] text-blue lg:text-[40px]">Md Abdur Rouf (Razu)
                        </h2>
                        <h3 class="text-secondary-200 mt-2 font-medium text-sm lg:text-base lg:max-w-[80%]"><span
                                class="text-orange">AI Lead at Nagad</span> | Corporate AI Trainer
                            | Founder of Biggapon Biroti | AI Artist (Image, Video & Music)
                        </h3>
                        <p
                            class="text-secondary-100 mt-[30px] font-normal text-sm md:text-base lg:text-lg lg:max-w-[80%] xl:max-w-[85%]">
                            মোঃ আব্দুর রউফ (রাজু) বাংলাদেশের এআই–ভিত্তিক সৃজনশীলতার একজন পথপ্রদর্শক। ডিজাইন ও বিজ্ঞাপনে
                            ১২+ বছরের
                            অভিজ্ঞতা এবং এআই–এ ২.৫+ বছরের কাজের অভিজ্ঞতা নিয়ে তিনি বর্তমানে নগদ-এর ক্রিয়েটিভ লিড - এআই
                            হিসেবে কাজ
                            করছেন। একইসাথে তিনি প্রতিষ্ঠা করেছেন বিজ্ঞাপন বিরতি, দেশের প্রথম এআই-ফার্স্ট বিজ্ঞাপন
                            সংস্থা।
                        </p>

                        <p class="text-secondary-100 mt-[20px] lg:mt-7 font-normal text-sm md:text-base lg:text-base">
                            follow by</p>

                        <ul class="flex items-center justify-center gap-x-2.5 mt-2.5 lg:justify-start">
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full" title="Call">
                                    <img src="./images/icons/call.svg" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full" title="E-mail">
                                    <img src="./images/icons/mail.svg" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full" title="Linkedin">
                                    <img src="./images/icons/linkedin.svg" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full" title="Facebook">
                                    <img src="./images/icons/facebook.svg" alt="call" class="w-full">
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="text-center relative z-40 mt-7 lg:max-w-[90%] xl:max-w-[80%]">
                    <div class="gradient-border">
                        <div class="gradient-border-content p-0 relative">
                            <img src="/images/instructor.png" alt="speaking-person"
                                class="rounded-[calc(0.75rem-2px)] w-full shadow-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instructor details -->

    <!-- clients section start -->
    <div class="w-full py-10 lg:py-18">
        <div class="container-x">
            <div class="w-full grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 lg:gap-x-12">
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/nagad.svg" alt="naagd" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/prothomalo.svg" alt="prothomalo" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/undp.svg" alt="undp" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/square-food.svg" alt="square" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/yamaha.svg" alt="yamaha" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
                <!-- client -->
                <div class="text-center">
                    <a href="#" class="flex justify-center">
                        <img src="./images/clients/ifad.svg" alt="ifad" class="w-fit mx-auto">
                    </a>
                </div>
                <!-- client -->
            </div>
        </div>
    </div>
    <!-- clients section end -->

    <!-- who will attend here -->
    <section class="w-full py-20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-20 xl:mb-28">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/who.svg" alt="who icon" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">কারা অংশ নেবেন <span
                        class="text-gradient">
                        এখানে</span></h2>
                <p class="common-para text-secondary-200">সৃজনশীলতা ও ক্যারিয়ারের উন্নত ভবিষ্যৎ</p>
            </div>
            <!-- common title end -->

            <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-y-2.5 lg:gap-y-5 lg:gap-x-6">
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">ডিজাইনার</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow attend-card-glow-variant">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">কনটেন্ট ক্রিয়েটর</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">এআই শেখার আগ্রহী যেকোনো
                            ব্যক্তি</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow attend-card-glow-variant">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">শিক্ষার্থী</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">বিজ্ঞাপণ নির্মাতা</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow attend-card-glow-variant">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">মার্কেটার</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">ভিডিও এডিটর</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
                <!-- card -->
                <div
                    class="item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] attend-card-glow attend-card-glow-variant">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">মিউজিশিয়ান</h5>
                    </div>
                    <button type="button" class="col-span-2 flex justify-end">
                        <img src="/images/icons/user.svg" alt="angle 1" class="w-5 lg:w-[26px] !text-[#fff]">
                    </button>
                </div>
                <!-- card -->
            </div>
        </div>
    </section>
    <!-- who will attend here -->

    <!-- joiner feedback start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/joiner.svg" alt="joiner icon" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">অংশগ্রহণকারীদের <span
                        class="text-gradient">
                        অভিজ্ঞতা</span></h2>
                <p class="common-para text-secondary-200">যারা শিখেছেন, তাদের মুখে এআই শেখার গল্প</p>
            </div>
            <!-- common title end -->

            <div class="relative">
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- group one -->
                    <div class="w-full flex flex-col gap-y-6">
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1 anim group-hover:bg-qute-hvr">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">আমি একজন ডিজাইনার। আগে
                                ডিজাইন করতে
                                ঘন্টার পর ঘন্টা লাগত, কিন্তু এআই শেখার পর কাজ অনেক সহজ হয়েছে। কালার প্যালেট, লেআউট আর
                                ভিজ্যুয়াল তৈরিতে
                                এখন আর ঝামেলা নেই। প্রতিদিনের কাজের গতি বেড়েছে এবং মানও উন্নত হয়েছে। আমার ক্লায়েন্টরা
                                এখন আগের চেয়ে
                                অনেক বেশি সন্তুষ্ট।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>সাদিয়া রহমান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">গ্রাফিক ডিজাইনার</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">এআই দিয়ে মিউজিকে নতুন
                                সাউন্ড
                                এক্সপ্লোর করেছি। গান বানানো অনেক সহজ হয়েছে। শ্রোতারাও ভালো রেসপন্স দিচ্ছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>রাহাত খান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">মিউজিশিয়ান</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">এআই দিয়ে মিউজিকে নতুন
                                সাউন্ড
                                এক্সপ্লোর করেছি। গান বানানো অনেক সহজ হয়েছে। শ্রোতারাও ভালো রেসপন্স দিচ্ছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>রাহাত খান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">মিউজিশিয়ান</h6>
                        </div>
                        <!-- card -->
                    </div>
                    <!-- group one -->

                    <!-- group two -->
                    <div class="w-full flex-col gap-y-6 hidden md:flex">
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">এআই আমার মার্কেটিং
                                কাজকে বদলে দিয়েছে।
                                কম সময়ে টার্গেটেড ক্যাম্পেইন বানাতে পারি। রেজাল্টও অনেক ভালো আসছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>তানভীর আহমেদ</h5>
                            <h6 class="common-para text-secondary-200 ml-5">মার্কেটার</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">কনটেন্ট ক্রিয়েশনে
                                প্রতিদিন নতুন
                                আইডিয়া খুঁজতে হয়। এআই শেখার পর টপিক সাজেশন অনেক সহজে পাই। ট্রেন্ডি কনটেন্ট লেখা আর
                                ভিজ্যুয়াল বানানো
                                দ্রুত হয়। আমার কাজের মান অনেক উন্নত হয়েছে। প্রোডাক্টিভিটিও দ্বিগুণ বেড়েছে। এআই আমাকে
                                কনটেন্টে
                                প্রতিযোগিতায় এগিয়ে রেখেছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>নওশীন হোসেন</h5>
                            <h6 class="common-para text-secondary-200 ml-5">কনটেন্ট ক্রিয়েটর</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">কনটেন্ট ক্রিয়েশনে
                                প্রতিদিন নতুন
                                আইডিয়া খুঁজতে হয়। এআই শেখার পর টপিক সাজেশন অনেক সহজে পাই। ট্রেন্ডি কনটেন্ট লেখা আর
                                ভিজ্যুয়াল বানানো
                                দ্রুত হয়। আমার কাজের মান অনেক উন্নত হয়েছে। প্রোডাক্টিভিটিও দ্বিগুণ বেড়েছে। এআই আমাকে
                                কনটেন্টে
                                প্রতিযোগিতায় এগিয়ে রেখেছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>নওশীন হোসেন</h5>
                            <h6 class="common-para text-secondary-200 ml-5">কনটেন্ট ক্রিয়েটর</h6>
                        </div>
                        <!-- card -->
                    </div>
                    <!-- group two -->

                    <!-- group three -->
                    <div class="w-full flex-col gap-y-6 hidden lg:flex">
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">আমি একজন ডিজাইনার। আগে
                                ডিজাইন করতে
                                ঘন্টার পর ঘন্টা লাগত, কিন্তু এআই শেখার পর কাজ অনেক সহজ হয়েছে। কালার প্যালেট, লেআউট আর
                                ভিজ্যুয়াল তৈরিতে
                                এখন আর ঝামেলা নেই। প্রতিদিনের কাজের গতি বেড়েছে এবং মানও উন্নত হয়েছে। আমার ক্লায়েন্টরা
                                এখন আগের চেয়ে
                                অনেক বেশি সন্তুষ্ট।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>সাদিয়া রহমান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">গ্রাফিক ডিজাইনার</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">এআই দিয়ে মিউজিকে নতুন
                                সাউন্ড
                                এক্সপ্লোর করেছি। গান বানানো অনেক সহজ হয়েছে। শ্রোতারাও ভালো রেসপন্স দিচ্ছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>রাহাত খান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">মিউজিশিয়ান</h6>
                        </div>
                        <!-- card -->
                        <!-- card -->
                        <div class="w-full bg-[#0A0A0A] rounded-[10px] p-5 shadow-2 anim hover:bg-[#141414] group">
                            <span class="flex items-center justify-center w-10 h-10 rounded-full bg-quote p-1">
                                <img src="/images/icons/quote.svg" alt="quote" class="w-5">
                            </span>

                            <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">এআই দিয়ে মিউজিকে নতুন
                                সাউন্ড
                                এক্সপ্লোর করেছি। গান বানানো অনেক সহজ হয়েছে। শ্রোতারাও ভালো রেসপন্স দিচ্ছে।</p>

                            <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10"><span
                                    class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>রাহাত খান</h5>
                            <h6 class="common-para text-secondary-200 ml-5">মিউজিশিয়ান</h6>
                        </div>
                        <!-- card -->
                    </div>
                    <!-- group three -->
                </div>
                <div class="over-shaped absolute left-0 -bottom-4 w-full h-[30%] z-30"></div>
                <div class="text-center relative z-40 mt-10">
                    <a href="#"
                        class="inline-flex bg-[#0F2342] rounded-full py-2.5 px-5 font-medium text-base text-[#fff] md:text-lg lg:text-2xl">আরও
                        <span class="text-blue mx-[3px]"> ২০০+</span> রিভিউ</a>
                </div>
            </div>
        </div>
    </section>
    <!-- joiner feedback end -->

    <!-- faq section start -->
    <section class="w-full py-10 lg:py-20 bg-faq">
        <div class="container-x">
            <!-- common title start -->
            <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
                <div
                    class="text-center w-12 h-12 rounded-full bg-[#1870FF33] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
                    <img src="/images/icons/faq.svg" alt="faq icon" class="w-6">
                </div>

                <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">সচরাচর জানতে চাওয়া <span
                        class="text-gradient">
                        প্রশ্নের উত্তর</span></h2>
                <p class="common-para text-secondary-200">সবচেয়ে বেশি করা প্রশ্নের উত্তর এক জায়গায়</p>
            </div>
            <!-- common title end -->

            <div class="w-full grid grid-cols-1 gap-y-1 lg:gap-y-2">
                <!-- card -->
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow active"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">এই কোর্সে যোগ দেওয়ার
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
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">কোর্সের সময়কাল কতদিন এবং
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
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">কোর্স ফি কত এবং কি কোনো
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
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">কোর্স শেষ করার পর কি কোনো
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
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">আমি যদি একেবারে নতুন হই,
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
                <div class="faq-item item bg-transparent rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                    onclick="toggleFAQ(this)">
                    <div class="w-full col-span-10">
                        <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl">কোর্স শেষে আমি বাস্তবে কী
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
    <!-- faq section end -->

    <!-- payment section start -->
    <section class="w-full py-10 lg:py-20 border-t border-[#fff]/20">
        <div class="container-x">
            <div
                class="w-full bg-card/80 rounded-[10px] py-5 px-6 flex flex-col lg:flex-row justify-center items-center text-center lg:justify-between border border-[#49484E]/50">
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

    <!-- footer section start -->
    <footer class="w-full">
        <div class="container-x">
            <div
                class="w-full text-center lg:flex items-center justify-between border-t border-[#fff]/20 py-5 xl:py-10">
                <h6 class="font-medium text-sm text-[#ABABAB] lg:text-base">কপিরাইট &copy;2025 আব্দুর রউফ। সর্বস্বত্ব
                    সংরক্ষিত।</h6>
                <p class="font-semibold text-base text-[#ABABAB] lg:text-base">
                    Another idea turned into reality by - <a target="_blank" href="https://giopio.com"
                        class="font-semibold text-base text-[#ABABAB]">Giopio</a>

                </p>
            </div>
        </div>
    </footer>
    <!-- footer section end -->

    <!-- Lightbox Popup -->
    <div id="lightbox" class="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <button class="lightbox-nav lightbox-prev" onclick="previousImage()">&#8249;</button>
            <button class="lightbox-nav lightbox-next" onclick="nextImage()">&#8250;</button>
            <img id="lightbox-image" class="lightbox-image" src="" alt="Project Image">
        </div>
    </div>
    <!-- Lightbox End -->

    <script>
        // Lightbox functionality
        let currentImageIndex = 0;
        let projectImages = [];

        // Initialize lightbox
        document.addEventListener('DOMContentLoaded', function() {
            // Collect all project images
            const images = document.querySelectorAll('.project-image');

            images.forEach((img, index) => {
                projectImages.push({
                    src: img.src,
                    alt: img.alt
                });

                // Add click event to open lightbox
                img.addEventListener('click', function() {
                    openLightbox(index);
                });
            });
        });

        function openLightbox(imageIndex) {
            currentImageIndex = imageIndex;
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');

            lightboxImage.src = projectImages[currentImageIndex].src;
            lightboxImage.alt = projectImages[currentImageIndex].alt;

            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % projectImages.length;
            const lightboxImage = document.getElementById('lightbox-image');

            // Add fade transition
            lightboxImage.style.opacity = '0.5';

            setTimeout(() => {
                lightboxImage.src = projectImages[currentImageIndex].src;
                lightboxImage.alt = projectImages[currentImageIndex].alt;
                lightboxImage.style.opacity = '1';
            }, 150);
        }

        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + projectImages.length) % projectImages.length;
            const lightboxImage = document.getElementById('lightbox-image');

            // Add fade transition
            lightboxImage.style.opacity = '0.5';

            setTimeout(() => {
                lightboxImage.src = projectImages[currentImageIndex].src;
                lightboxImage.alt = projectImages[currentImageIndex].alt;
                lightboxImage.style.opacity = '1';
            }, 150);
        }

        // Close lightbox when clicking outside the image
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
            if (e.key === 'ArrowRight') {
                nextImage();
            }
            if (e.key === 'ArrowLeft') {
                previousImage();
            }
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

        // Video Modal functionality
        function openVideoModal(videoUrl) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            const loading = document.getElementById('videoLoading');

            if (!modal || !iframe) {
                return;
            }

            // Show loading indicator
            if (loading) {
                loading.style.display = 'flex';
            }

            // Force modal to be visible and accessible
            modal.style.display = 'flex';
            modal.style.pointerEvents = 'auto';
            modal.style.opacity = '1';
            modal.style.visibility = 'visible';

            // Show modal with fade effect
            modal.classList.add('show');

            // Set the video URL
            iframe.src = videoUrl;

            // Hide loading indicator when iframe loads
            iframe.onload = function() {
                if (loading) {
                    loading.style.display = 'none';
                }
            };

            // Hide loading after 3 seconds as fallback
            setTimeout(() => {
                if (loading) {
                    loading.style.display = 'none';
                }
            }, 3000);

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            const loading = document.getElementById('videoLoading');

            if (!modal || !iframe) return;

            // Hide modal with fade effect
            modal.classList.remove('show');

            // Hide modal completely after transition
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.pointerEvents = 'none';
                modal.style.opacity = '0';
                modal.style.visibility = 'hidden';

                // Stop video and reset loading
                iframe.src = '';
                if (loading) {
                    loading.style.display = 'flex';
                }
            }, 300);

            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Event listeners for modal
        document.addEventListener('DOMContentLoaded', function() {
            const heroImageWrap = document.querySelector('.hero-image-wrap');
            const closeModalBtn = document.getElementById('closeModal');
            const modal = document.getElementById('videoModal');

            // Open modal when hero image is clicked
            if (heroImageWrap) {
                heroImageWrap.addEventListener('click', function(e) {
                    e.preventDefault();
                    const videoUrl = 'https://www.youtube.com/embed/tA0hYGfKSRc?autoplay=1';
                    openVideoModal(videoUrl);
                });
            }

            // Close modal when close button is clicked
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeVideoModal);
            }

            // Close modal when clicking outside the modal content
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeVideoModal();
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeVideoModal();
                }
            });
        });

        // Scroll to enrollment form function
        function scrollToEnrollmentForm() {
            const targetForm = document.getElementById('enrollment-form');

            if (targetForm) {
                targetForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Add subtle highlight effect
                targetForm.style.background = 'rgba(0, 212, 255, 0.1)';
                targetForm.style.padding = '20px';
                targetForm.style.borderRadius = '10px';
                targetForm.style.transition = 'all 0.3s ease';

                // Remove highlight after 2 seconds
                setTimeout(() => {
                    targetForm.style.background = 'transparent';
                    targetForm.style.padding = '0';
                }, 2000);
            } else {
                // Fallback: scroll to bottom of page
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            }

            return false;
        }

        // Also make other buttons clickable
        document.addEventListener('DOMContentLoaded', function() {
            // Make all FAQ buttons work
            const faqButtons = document.querySelectorAll('.faq-item');
            faqButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    toggleFAQ(this);
                });
            });

            // Make accordion buttons work
            const accordionButtons = document.querySelectorAll('button[type="button"]');
            accordionButtons.forEach(function(button) {
                if (!button.onclick && button.closest('.faq-item')) {
                    button.addEventListener('click', function() {
                        toggleFAQ(this.closest('.faq-item'));
                    });
                }
            });

            // Add click functionality to all buttons
            addButtonFunctionality();
        });

        // Copy phone number function
        function copyPhoneNumber() {
            const phoneNumber = '01712345678';

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(phoneNumber).then(function() {
                    // Show visual feedback on button
                    const button = event.target;
                    const originalText = button.innerHTML;
                    button.innerHTML = '✓ কপি হয়েছে!';
                    button.style.backgroundColor = '#10B981';

                    setTimeout(function() {
                        button.innerHTML = originalText;
                        button.style.backgroundColor = '';
                    }, 2000);
                }).catch(function(err) {
                    // Fallback for older browsers
                    fallbackCopy(phoneNumber);
                });
            } else {
                fallbackCopy(phoneNumber);
            }

            return false;
        }

        // Fallback copy function
        function fallbackCopy(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    alert('Phone number copied: ' + text);
                } else {
                    alert('Copy failed. Phone number: ' + text);
                }
            } catch (err) {
                alert('Phone number: ' + text);
            }

            document.body.removeChild(textArea);
        }

        // Add functionality to all buttons
        function addButtonFunctionality() {
            // Course module accordion buttons
            const moduleButtons = document.querySelectorAll('.grid.grid-cols-12.items-center button[type="button"]');
            moduleButtons.forEach(function(button, index) {
                if (!button.onclick) {
                    button.addEventListener('click', function() {
                        // Simple accordion effect
                        const parentDiv = this.closest('.grid-cols-12');
                        const icon = this.querySelector('img');

                        // Toggle rotation
                        if (icon.style.transform === 'rotate(180deg)') {
                            icon.style.transform = 'rotate(0deg)';
                        } else {
                            icon.style.transform = 'rotate(180deg)';
                        }

                        // Add some visual feedback
                        parentDiv.style.backgroundColor = 'rgba(0, 212, 255, 0.1)';
                        setTimeout(function() {
                            parentDiv.style.backgroundColor = '';
                        }, 1000);
                    });
                }
            });

            // Add hover effects to all clickable elements
            const clickableElements = document.querySelectorAll('button, a');
            clickableElements.forEach(function(element) {
                if (!element.style.cursor) {
                    element.style.cursor = 'pointer';
                }
            });

            // Form validation and user feedback
            const enrollmentForm = document.getElementById('enrollment-form');
            if (enrollmentForm) {
                // Add real-time email validation feedback
                const emailInput = document.querySelector('input[name="email"]');
                if (emailInput) {
                    emailInput.addEventListener('blur', function() {
                        const email = this.value.trim();
                        if (email && !isValidEmail(email)) {
                            showFieldError(this, 'বৈধ ইমেইল ঠিকানা প্রদান করুন');
                        } else {
                            clearFieldError(this);
                        }
                    });
                }

                // Add form submission handling
                enrollmentForm.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>এনরোল হচ্ছে...';
                        submitBtn.disabled = true;
                    }
                });
            }

            // Helper functions
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function showFieldError(field, message) {
                clearFieldError(field);
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error text-red-400 text-xs mt-1 flex items-center';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>' + message;
                field.parentNode.appendChild(errorDiv);
                field.style.borderColor = '#ef4444';
            }

            function clearFieldError(field) {
                const existingError = field.parentNode.querySelector('.field-error');
                if (existingError) {
                    existingError.remove();
                }
                field.style.borderColor = '';
            }
        }
    </script>

    {{-- cta button show/hide --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollButton = document.getElementById('scroll-button');

            if (scrollButton) {
                // Initial state - hidden
                scrollButton.classList.add('opacity-0', 'translate-y-4');

                let ticking = false;

                function updateButtonVisibility() {
                    const scrollY = window.scrollY;
                    const triggerPoint = 500; // Trigger at 200px

                    if (scrollY > triggerPoint) {
                        // Show button with fade in
                        scrollButton.classList.remove('opacity-0', 'translate-y-4');
                        scrollButton.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        // Hide button with fade out
                        scrollButton.classList.remove('opacity-100', 'translate-y-0');
                        scrollButton.classList.add('opacity-0', 'translate-y-4');
                    }

                    ticking = false;
                }

                // Throttle scroll events for better performance
                window.addEventListener('scroll', function() {
                    if (!ticking) {
                        requestAnimationFrame(updateButtonVisibility);
                        ticking = true;
                    }
                });

                // Initial check
                updateButtonVisibility();
            }
        });
    </script> 

</body>

</html>
