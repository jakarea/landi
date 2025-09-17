<!doctype html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="/src/style.css" rel="stylesheet">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    <title>আব্দুর রউফ</title>
</head>

<body class="bg-[#0A0A0A]">

    <!-- hero section start -->
    <section class="w-full pb-1 lg:pb-10 relative min-h-[600px]">
        <!-- header section start -->
        <header class="w-full pt-5 lg:pt-10 relative z-[9999]">
            <div class="container-x">
                <div
                    class="w-full grid grid-cols-12 relative bg-[#fff]/10 rounded-md p-2 lg:p-2.5 lg:rounded-[14px] lg:items-center lg:px-5">
                    <!-- logo -->
                    <div class="text-start col-span-4">
                        <a href="#">
                            <img src="{{ asset('/images/logo.svg') }}" alt="logo" class="max-w-24 lg:max-w-[145px]">
                        </a>
                    </div>
                    <!-- logo -->

                    <div class="navbar flex flex-col gap-y-4 justify-center items-center col-span-8 lg:flex-row">
                        <!-- menu -->
                        <div
                            class="w-full absolute left-0 top-10 min-h-[130px] bg-card z-50 flex justify-center p-4 rounded-md hidden lg:!flex lg:relative lg:bg-transparent lg:min-h-auto lg:left-auto lg:top-auto">
                            <ul class="flex flex-col lg:flex-row gap-y-3 lg:gap-y-0 lg:gap-x-[30px] text-center">
                                <li><a href="#"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff]">হোম</a>
                                </li>
                                <li><a href="#"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff]">কোর্সসমূহ</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff]">আমাদের
                                        সম্পর্কে</a>
                                </li>
                            </ul>
                        </div>
                        <!-- menu -->

                        <!-- actions -->
                        <div class="w-full">
                            <ul class="flex gap-x-3 lg:gap-x-[30px] text-center items-center justify-end">
                                <li><a href="#"
                                        class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">লগইন
                                    </a></li>
                                <li>
                                    <a href="#" class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim
               hover:!bg-lime md:text-base px-3 pr-2 lg:text-lg
                hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5 lg:pr-4">
                                        সাইন আপ
                                        <svg class="w-5 lg:w-8" viewBox="0 0 30 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="29.5" width="29" height="29" rx="14.5"
                                                transform="rotate(-90 0.5 29.5)" stroke="white" />
                                            <path
                                                d="M18.3154 16.9887L18.3154 11.6854M18.3154 11.6854L13.0121 11.6854M18.3154 11.6854L11.6862 18.3146"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                                <li class="lg:hidden">
                                    <button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 text-[#fff]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!-- actions -->
                    </div>
                </div>
            </div>
        </header>
        <!-- header section end -->
        <img src="{{ asset('/images/hero-ellipse.svg') }}" alt="ellipse"
            class="absolute left-0 top-0 lg:h-full lg:object-contain"> <!-- hero ellipse -->
        <div class="container-x">
            <div class="w-full text-center mt-10 md:mt-14 lg:mt-[90px] relative z-[99]">
                <h1
                    class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    আপনার ক্রিয়েটিভিটি আনলক করুন
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h1>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">সবচেয়ে সহজ ও
                    দ্রুত উপায়ে শিখুন <span class="text-gradient">এআই ক্রিয়েটিভিটি</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                    মাত্র ৩ দিনে আয়ত্ত করুন AI ইমেজ, ভিডিও ও মিউজিক জেনারেশন। লাইভ হ্যান্ডস-অন বুটক্যাম্প, বাস্তব
                    প্রজেক্ট ও ইন্ডাস্ট্রি এক্সপার্ট মোঃ আব্দরু রউফ (রাজু) এর গাইডলাইনে।</p>

                <ul class="flex justify-center gap-x-5 items-center mt-5 md:mt-10 lg:mt-11">
                    <li>
                        <a href="#" class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim
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

            <div class="w-full mt-8 md:mt-12 lg:mt-[62px] grid grid-cols-12 gap-x-4 lg:gap-x-6">
                <!-- card small -->
                <div
                    class="w-full bg-[#131620] border border-[#232323] p-3 lg:p-5 rounded-md lg:rounded-[20px] col-span-12 lg:col-span-3">
                    <div class="w-full bg-[#fff]/10 rounded-sm p-2 lg:p-2.5 lg:rounded-[10px] text-center">
                        <h6
                            class="font-normal text-sm lg:text-lg text-[#7E76FF] flex items-center gap-x-2.5 justify-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="4" cy="4" r="4" transform="matrix(-1 0 0 1 16.5 3.5)"
                                    stroke="url(#paint0_linear_404_6825)" stroke-width="1.5" />
                                <path
                                    d="M5.5 17.4347C5.5 16.5743 6.04085 15.8068 6.85109 15.5175V15.5175C10.504 14.2128 14.496 14.2128 18.1489 15.5175V15.5175C18.9591 15.8068 19.5 16.5743 19.5 17.4347V18.7502C19.5 19.9376 18.4483 20.8498 17.2728 20.6818L16.3184 20.5455C13.7856 20.1837 11.2144 20.1837 8.68162 20.5455L7.72721 20.6818C6.5517 20.8498 5.5 19.9376 5.5 18.7502V17.4347Z"
                                    stroke="url(#paint1_linear_404_6825)" stroke-width="1.5" />
                                <defs>
                                    <linearGradient id="paint0_linear_404_6825" x1="4" y1="0" x2="4" y2="8"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#E850FF" />
                                        <stop offset="1" stop-color="#4941C8" />
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_404_6825" x1="12.5" y1="13.5" x2="12.5" y2="21"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#E850FF" />
                                        <stop offset="1" stop-color="#4941C8" />
                                    </linearGradient>
                                </defs>
                            </svg>

                            আপনার কোর্স ইন্সট্রাক্টর</h6>
                    </div>
                    <div class="w-full my-2 lg:my-2.5">
                        <img src="{{ asset('/images/speaking-person.png') }}" alt="speking person"
                            class="w-full h-[208px] rounded-md lg:rounded-[10px] object-cover">
                    </div>
                    <div class="w-full bg-[#fff]/10 rounded-sm p-2 lg:p-2.5 lg:rounded-[10px] text-center">
                        <h6
                            class="font-normal text-sm lg:text-lg text-[#7E76FF] flex items-center gap-x-2.5 justify-center">
                            মোঃ আব্দরু রউফ (রাজু)</h6>
                        <ul class="flex items-center justify-center gap-x-2.5 mt-1">
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                    <img src="{{ asset('/images/icons/call.svg') }}" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                    <img src="images/icons/mail.svg" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                    <img src="{{ asset('images/icons/linkedin.svg') }}" alt="call" class="w-full">
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                    <img src="{{ asset('/images/icons/facebook.svg') }}" alt="call" class="w-full">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- card big -->
                <div
                    class="w-full bg-[#131620] border border-[#232323] p-3 lg:p-5 rounded-md lg:rounded-[20px] col-span-12 lg:col-span-8 grid grid-cols-1 lg:grid-cols-11 gap-2 lg:gap-2.5">
                    <!-- box -->
                    <div class="w-full lg:col-span-5">
                        <div class="w-full bg-[#fff]/10 rounded-sm p-2 lg:p-2.5 lg:rounded-[10px] text-center">
                            <h6
                                class="font-normal text-sm lg:text-lg text-[#7E76FF] flex items-center gap-x-2.5 justify-center">
                                <img src="{{ asset('/images/icons/ai.svg') }}" alt="ai">

                                তার এআই ক্রিয়েশন</h6>
                        </div>
                        <div class="w-full mt-2 lg:mt-2.5 grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-2.5">
                            <img src="{{ asset('/images/project-07.png') }}" alt="speking person"
                                class="w-full h-[100px] rounded-md lg:rounded-[10px] object-cover">
                            <img src="{{ asset('/images/project-03.png') }}" alt="speking person"
                                class="w-full h-[100px] rounded-md lg:rounded-[10px] object-cover">
                            <img src="{{ asset('/images/project-02.png') }}" alt="speking person"
                                class="w-full h-[100px] rounded-md lg:rounded-[10px] object-cover lg:col-span-2">
                        </div>
                    </div>
                    <!-- box -->
                    <div class="w-full lg:col-span-3 relative">
                        <img src="{{ asset('/images/home/robot.png') }}" alt="robot"
                            class="w-full h-[269px] object-cover rounded-md lg:rounded-[10px]">
                        <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                            <button type="button"
                                class="w-12 h-12 rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                                <img src="{{ asset('/images/icons/play.svg') }}" alt="play" class="w-4">
                            </button>
                        </div>
                    </div>
                    <!-- box -->
                    <div class="w-full lg:col-span-3 relative">
                        <img src="{{ asset('/images/home/joker.png') }}" alt="joker"
                            class="w-full h-[269px] object-cover rounded-md lg:rounded-[10px]">
                        <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                            <button type="button"
                                class="w-12 h-12 rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                                <img src="{{ asset('/images/icons/play.svg') }}" alt="play" class="w-4">
                            </button>
                        </div>
                    </div>
                    <!-- box -->
                    <div
                        class="w-full lg:col-span-8 bg-[#fff]/10 rounded-sm p-2 lg:p-2.5 lg:rounded-[10px] text-center flex items-center gap-x-3 lg:gap-x-5">
                        <span
                            class="flex w-8 h-8 lg:w-11 lg:h-11 bg-[#131620] shrink-0 rounded-full justify-center items-center p-1">
                            <img src="{{ asset('/images/icons/play.svg') }}" alt="play" class="w-4">
                        </span>
                        <div class="w-full">
                            <img src="{{ asset('/images/home/waves.svg') }}" alt="waves"
                                class="w-full max-h-[65px] object-contain">
                        </div>
                    </div>
                    <!-- box -->
                    <div
                        class="w-full lg:col-span-3 bg-[#fff]/10 rounded-sm p-2 lg:p-2.5 lg:rounded-[10px] text-center flex items-center justify-center">
                        <h6
                            class="font-normal text-sm lg:text-lg text-[#7E76FF] flex items-center gap-x-2.5 justify-center">
                            <img src="{{ asset('/images/icons/ai.svg') }}" alt="ai">

                            তার এআই ক্রিয়েশন</h6>
                    </div>
                </div>
            </div>

            <div class="w-full relative z-[99] mt-3 lg:mt-5 ">
                <ul class="flex flex-col lg:flex-row gap-y-4 lg:gap-y-0 justify-center lg:gap-x-6 w-full">
                    <li>
                        <a href="#"
                            class="inline-flex items-center p-2 lg:p-2.5 rounded-md lg:rounded-[10px] border border-[#232323] bg-[#0A0C19] py-2 lg:py-2.5 px-4 lg:px-5 font-normal text-sm md:text-base lg:text-lg text-[#7E76FF] gap-x-2 lg:gap-x-2.5 anim hover:bg-blue hover:text-[#fff] group">
                            <img src="{{ asset('/images/icons/btn-1.svg') }}" alt="btn-1"
                                class="w-5 lg:w-6 anim group-hover:text-[#fff]" />
                            ইমেজ জেনারেশন
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="inline-flex items-center p-2 lg:p-2.5 rounded-md lg:rounded-[10px] border border-[#232323] bg-[#0A0C19] py-2 lg:py-2.5 px-4 lg:px-5 font-normal text-sm md:text-base lg:text-lg text-[#7E76FF] gap-x-2 lg:gap-x-2.5 anim hover:bg-blue hover:text-[#fff] group">
                            <img src="{{ asset('/images/icons/btn-1.svg') }}" alt="btn-1"
                                class="w-5 lg:w-6 anim group-hover:text-[#fff]" />
                            ইমেজ জেনারেশন
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="inline-flex items-center p-2 lg:p-2.5 rounded-md lg:rounded-[10px] border border-[#232323] bg-[#0A0C19] py-2 lg:py-2.5 px-4 lg:px-5 font-normal text-sm md:text-base lg:text-lg text-[#7E76FF] gap-x-2 lg:gap-x-2.5 anim hover:bg-blue hover:text-[#fff] group">
                            <img src="{{ asset('/images/icons/btn-1.svg') }}" alt="btn-1"
                                class="w-5 lg:w-6 anim group-hover:text-[#fff]" />
                            ইমেজ জেনারেশন
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- hero section end -->

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('/images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->

    <!-- feature section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    মূল বৈশিষ্ট্য
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">আপনার
                    আইডিয়াকে বদলে দিন <span class="text-gradient">এআই ক্রিয়েশনে</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[50%] lg:mx-auto">
                    শিখুন কীভাবে আকর্ষণীয় ইমেজ, এনগেজিং ভিডিও ও প্রফেশনাল মিউজিক/ভয়েসওভার তৈরি করা যায় মুহূর্তেই।</p>
            </div>

            <!-- feat card -->
            <div class="w-full grid grid-cols-1 gap-y-5 md:grid-cols-2 gap-5 lg:grid-cols-3 lg:gap-x-6">
                <div
                    class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                    <img src="{{ asset('/images/home/feat-card.svg') }}" alt="feat card"
                        class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                    <div
                        class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                        <div
                            class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                            <img src="{{ asset('/images/icons/b-camp-01.svg') }}" alt="icons 1" class="w-6 md:w-8 lg:w-10">
                            <img src="{{ asset('/images/icons/curve.svg') }}" alt="curve 1"
                                class="w-[86%] absolute left-1 top-4">
                        </div>
                    </div>

                    <div class="mt-10 lg:mt-[60px]">
                        <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">এআই
                            ইমেজ জেনারেশন ও প্রম্পটিং</h5>
                        <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">টেক্সট
                            প্রম্পট থেকে ভিজ্যুয়াল, পোস্টার, ক্যারেক্টার ডিজাইন ও ফেস এডিট শিখুন।</p>
                    </div>
                </div>
                <div
                    class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                    <img src="{{ asset('/images/home/feat-card.svg') }}" alt="feat card"
                        class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                    <div
                        class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                        <div
                            class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                            <img src="{{ asset('/images/icons/b-camp-02.svg') }}" alt="icons 2" class="w-6 md:w-8 lg:w-10">
                            <img src="{{ asset('/images/icons/curve.svg') }}" alt="curve 2"
                                class="w-[86%] absolute left-1 top-4">
                        </div>
                    </div>

                    <div class="mt-10 lg:mt-[60px]">
                        <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">এআই
                            ভিডিও ক্রিয়েশন</h5>
                        <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">
                            টেক্সট/ইমেজ থেকে ভিডিও, লিপ-সিঙ্ক, ভয়েস ও ইফেক্টসহ বিজ্ঞাপন ও শর্টস তৈরি করুন।</p>
                    </div>
                </div>
                <div
                    class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                    <img src="{{ asset('/images/home/feat-card.svg') }}" alt="feat card"
                        class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                    <div
                        class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                        <div
                            class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                            <img src="{{ asset('/images/icons/b-camp-03.svg') }}" alt="icons 3" class="w-6 md:w-8 lg:w-10">
                            <img src="{{ asset('/images/icons/curve.svg') }}" alt="curve 3"
                                class="w-[86%] absolute left-1 top-4">
                        </div>
                    </div>

                    <div class="mt-10 lg:mt-[60px]">
                        <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">এআই
                            মিউজিক ও ভয়েস জেনারেশন</h5>
                        <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">এআই দিয়ে
                            জিঙ্গেল, ব্যাকগ্রাউন্ড স্কোর, ভয়েসওভার ও সাউন্ড ইফেক্ট তৈরি করুন।</p>
                    </div>

                </div>
            </div>
            <!-- feat card -->
        </div>
    </section>
    <!-- feature section end -->

    <!-- change your idea section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="text-center mb-10 md:mb-16 lg:mb-20">
                <h6
                    class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    শেখার ধাপ
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h6>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">আপনার
                    আইডিয়াকে বদলে দিন <span class="text-gradient">এআই ক্রিয়েশনে</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[50%] lg:mx-auto">
                    এই বুটক্যাম্পে শেখার সঠিক পদ্ধতি, ধাপে ধাপে নির্দেশনা এবং ব্যবহারিক কৌশল যা আপনাকে দ্রুত দক্ষ করে
                    তুলবে</p>
            </div>

            <!-- first step -->
             <div class="w-full grid grid-cols-1 gap-y-10 lg:grid-cols-2 lg:gap-y-[200px] lg:gap-x-12 lg:items-center relative">
                <!-- line -->
                 <div class="hidden lg:block bg-[#232323] w-[2px] h-full absolute left-[50%] top-0 translate-x-[-50%]"></div>
                <!-- line -->
               
                 <!-- txt -->
                 <div class="w-full ">
                    <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl mb-3 lg:mb-5">প্রথম ধাপ </h4>
                    <h6 class="font-medium text-base lg:text-lg text-[#E2E8F0] mb-3 lg:mb-5">প্রম্পট থেকে প্রফেশনাল ভিজ্যুয়াল</h6>

                    <ul class="flex flex-col gap-y-2 lg:max-w-[70%]">
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">প্রম্পট লিখুন: সঠিক ও ইউনিক প্রম্পট তৈরি করা শিখুন।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">ইমেজ তৈরি: এআই ব্যবহার করে কাস্টম গ্রাফিক্স, ফেস এডিটিং ও অ্যাড ডিজাইন বানান।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">ফাইনাল টাচ: রঙ, লেআউট এবং স্টাইল এডজাস্ট করে প্রফেশনাল লুক নিশ্চিত করুন।</p>
                        </li>
                    </ul>
                 </div> 

                  <!-- img -->
                 <div class="w-full lg:max-w-[80%] lg:ml-auto">
                    <div class="bg-step-img rounded-lg lg:rounded-[30px] p-4 lg:p-5 border border-[#232323]">
                        <img src="{{ asset('/images/home/step-01.png') }}" alt="step-01" class="w-full rounded-md lg:rouned-[10px] ">
                    </div>
                 </div>

                 <!-- img -->
                 <div class="w-full lg:max-w-[80%] lg:mr-auto">
                    <div class="bg-step-img rounded-lg lg:rounded-[30px] p-4 lg:p-5 border border-[#232323]">
                        <img src="{{ asset('/images/home/step-02.png') }}" alt="step-02" class="w-full rounded-md lg:rouned-[10px] ">
                    </div>
                 </div>

                  <div class="w-full lg:max-w-[80%] lg:ml-auto">
                    <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl mb-3 lg:mb-5">দ্বিতীয় ধাপ  </h4>
                    <h6 class="font-medium text-base lg:text-lg text-[#E2E8F0] mb-3 lg:mb-5">টেক্সট বা ইমেজ থেকে আকর্ষণীয় ভিডিও তৈরি করুন</h6>

                    <ul class="flex flex-col gap-y-2">
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">ভিডিও জেনারেট করুন: টেক্সট বা ইমেজ থেকে ভিডিও তৈরি করা শিখুন।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">অডিও ও ভয়েস এড করুন: ভয়েসওভার, লিপ-সিঙ্ক ও ব্যাকগ্রাউন্ড মিউজিক যোগ করুন।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">এফেক্ট ও ফাইনাল টাচ: ট্রানজিশন, ফিল্টার ও এফেক্ট দিয়ে ভিডিওকে আরও প্রফেশনাল করুন।</p>
                        </li>
                    </ul>
                 </div> 

                  <!-- txt -->
                 <div class="w-full ">
                    <h4 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl mb-3 lg:mb-5">তৃতীয় ধাপ  </h4>
                    <h6 class="font-medium text-base lg:text-lg text-[#E2E8F0] mb-3 lg:mb-5">সাউন্ড দিয়ে ভিডিওকে প্রাণ দিন</h6>

                    <ul class="flex flex-col gap-y-2 lg:max-w-[70%]">
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">মিউজিক জেনারেশন: জিঙ্গেল, ব্যাকগ্রাউন্ড সাউন্ড বা টিউন তৈরি করুন।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">ভয়েসওভার তৈরি করুন: এআই ভয়েস দিয়ে প্রফেশনাল ভয়েসওভার তৈরি করা শিখুন।</p>
                        </li>
                        <li class="flex items-center gap-x-2 lg:gap-x-3">
                            <span class="block w-1 h-1 bg-[#ABABAB] rounded-full"></span>
                            <p class="text-[#ABABAB] font-normal text-sm lg:text-base">সাউন্ড এফেক্ট: মিউজিক ও ভয়েসের সাথে সাউন্ড ইফেক্ট যোগ করুন।</p>
                        </li>
                    </ul>
                 </div> 

                  <!-- img -->
                 <div class="w-full lg:max-w-[80%] lg:ml-auto">
                    <div class="bg-step-img rounded-lg lg:rounded-[30px] p-4 lg:p-5 border border-[#232323]">
                        <img src="{{ asset('/images/home/step-03.png') }}" alt="step-03" class="w-full rounded-md lg:rouned-[10px] ">
                    </div>
                 </div>

             </div>
            <!-- first step -->
        </div>
    </section>
    <!-- change your idea section end -->

    <!-- get start section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="get-bg relative py-12 px-8 lg:py-[94px] lg:px-[220px] rounded-[20px] lg:min-h-[365px]">
                <div class="absolute left-0 bottom-0 z-20 w-full h-full flex justify-between">
                    <img src="{{ asset('/images/home/get-start-bottom-left.svg') }}" alt="get left"
                        class="rounded-bl-[20px] lg:object-contain rounded-tl-[20px] max-w-[50%]">
                    <img src="{{ asset('/images/home/get-start-top-right.svg') }}" alt="get right"
                        class="rounded-tr-[20px] rounded-br-[20px] max-w-[50%] lg:object-contain">
                </div>
                <div class="text-center relative z-30 w-full">
                    <h2 class="font-bold text-2xl lg:text-[44px] text-[#fff] leading-[120%] mb-1">ক্রিয়েটিভিটির ভবিষ্যৎ
                        <span class="text-gradient">এখন আপনার হাতে</span></h2>
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
        <img src="{{ asset('/images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line -->

    <!-- footer section start -->
    <footer class="w-full pt-10 lg:pt-20 pb-3 lg:pb-5">
        <div class="container-x">

            <div class="w-full grid grid-cols-2 lg:grid-cols-12 gap-y-10 gap-x-5 lg:gap-x-16 mb-5 lg:mb-10">
                <!-- card -->
                <div class="w-full lg:col-span-4">
                    <a href="#">
                        <img src="{{ asset('/images/logo.svg') }}" alt="logo white" class="w-full max-w-[108px]">
                    </a>
                    <p class="text-[#ABABAB] font-normal text-base mt-5 mb-3 lg:mt-[30px] lg:mb-5">বাংলাদেশের শীর্ষ এআই
                        ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম</p>

                    <p class="text-[#ABABAB] mt-[20px] lg:mt-7 font-normal text-sm font-golos">আমাদের সাথে যুক্ত হন</p>

                    <ul class="flex items-center justify-center gap-x-2.5 mt-2.5 lg:justify-start">
                        <li>
                            <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                <img src="{{ asset('/images/icons/call.svg') }}" alt="call" class="w-full">
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                <img src="{{ asset('/images/icons/mail.svg') }}" alt="call" class="w-full">
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                <img src="{{ asset('/images/icons/linkedin.svg') }}" alt="call" class="w-full">
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block w-[30px] h-[30px] rounded-full">
                                <img src="{{ asset('/images/icons/facebook.svg') }}" alt="call" class="w-full">
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="w-full lg:col-span-2">
                    <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">কুইক লিঙ্কস</h6>
                    <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">হোম</a>
                        </li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">কোর্স
                                সমূহ </a></li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">আমাদের
                                সম্পর্কে</a></li>
                    </ul>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="w-full lg:col-span-3">
                    <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">যোগাযোগ করুন</h6>
                    <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">ঢাকা,
                                বাংলাদেশ</a>
                        </li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">+880
                                1712-345678</a></li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">info@roufai.com</a>
                        </li>
                    </ul>
                </div>
                <!-- card -->
                <!-- card -->
                <div class="w-full lg:col-span-3">
                    <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">কোর্স সমূহ </h6>
                    <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                                Creative Mastery</a>
                        </li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">Prompt
                                Engineering Pro</a></li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                                Video & Content Lab</a></li>
                    </ul>
                </div>
                <!-- card -->
            </div>

            <div
                class="w-full border-t border-[#232323] flex justify-center flex-col items-center lg:flex-row lg:justify-between lg:items-center gap-y-4 lg:gap-x-4 lg:gap-y-0 mt-3 pt-3 lg:mt-4 lg:pt-4">
                <p class="font-normal text-sm lg:text-base text-[#ABABAB]">&copy; 2025 Rouf AI - সর্বস্বত্ব সংরক্ষিত।
                </p>
                <p class="font-normal text-sm lg:text-base text-[#ABABAB]">Developed with ❤️ by Giopio</p>
            </div>
        </div>
    </footer>
    <!-- footer section end -->


</body>

</html>