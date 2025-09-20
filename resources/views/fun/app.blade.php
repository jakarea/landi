<!-- @extends('layouts.guest-modern') -->

@section('title', 'আব্দুর রউফ - AI Creative Training Platform')
@section('description',
    'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম। মাত্র ৩ দিনে আয়ত্ত করুন AI ইমেজ, ভিডিও ও
    মিউজিক জেনারেশন।')

@section('styles')
<style>
    iframe{
        width: 100%;
        min-height: 820px;
        border-radius: 20px
    }
</style>
@endsection

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
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">এআই ফেস স্টাইল  <span class="text-gradient">ফিউশন</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                    আপনার ছবি মুহূর্তেই বদলে দিন আকর্ষণীয় নতুন স্টাইলে — এআই-এর শক্তিতে।</p>

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



    <!-- our courses section start -->
    <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <iframe src="https://ai-face-style-fusion-535507846138.us-west1.run.app/" frameborder="0"></iframe>
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
