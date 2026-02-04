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
        <div class="container-x">
            <div class="w-full text-center mt-10 md:mt-14 lg:mt-[90px] relative z-[99]">
                <h1
                    class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                    <span class="block h-[2px] w-5 bg-line"></span>
                    সকল এক্সপার্ট 
                    <span class="block h-[2px] w-5 bg-line-2"></span>
                </h1>
                <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">আপনার
                    একসাথে বেড়ে উঠুন - <span class="text-gradient"> ক্যারিয়ারে আনুন গতির ঝড়</span></h2>
                <p
                    class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                    নতুন সুযোগের দ্বার উন্মুক্ত করে এমন সম্পর্ক গড়ে তুলতে সহকর্মী, পরামর্শদাতা এবং শিল্প বিশেষজ্ঞদের একটি
প্রাণবন্ত পেশাদার সম্প্রদায়ের সাথে যোগ দিন।</p>

            </div>
        </div>
    </section>
   
    <!-- hero section end -->

    <!-- border line -->
    <div class="container-x">
        <img src="{{ asset('images/line.svg') }}" alt="line" class="w-full mx-auto">
    </div>
    <!-- border line --> 

    <!-- expert list section start -->
     <section class="w-full py-10 lg:py-20">
        <div class="container-x">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-x-10 lg:gap-y-[64px]">
                <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                  <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                  <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
                                 <!-- card -->
                 <div class="w-full">
                    <div class="img">
                        <img src="{{ asset('assets/landing/images/expert-image.png') }}" alt="expert image" class="w-full lg:w-[90%] mx-auto">
                    </div>
                    <div class="txt mt-4 lg:mt-8 text-center">
                        <h5 class="font-medium text-base lg:text-xl text-[#F2F2F7]">Swdeep Billah</h5>
                        <h6 class="font-normal text-xs lg:text-sm text-[#fff]">Visual Artist | Senior Visualizer</h6>
                        <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">Branding • Motion • AI-Driven Visual Storytelling A visionary with a passion for aesthetics and storytelling. </p>
                        <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                            <a href="#"><img src="{{ asset('assets/landing/images/facebook.svg') }}" alt="facebook"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/instagram.svg') }}" alt="instagram"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/linkedin.svg') }}" alt="linkedin"></a>
                            <a href="#"><img src="{{ asset('assets/landing/images/twitter.svg') }}" alt="twitter"></a>
                        </div>
                    </div>
                 </div>
                <!-- card -->
            </div>
        </div>
     </section>
    <!-- expert list section end -->

   


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

 
