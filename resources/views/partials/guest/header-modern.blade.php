<!-- header section start -->
<header class="w-full pt-5 lg:pt-10 relative z-[9999]">
    <div class="container-x">
        <div class="w-full grid grid-cols-12 relative bg-[#fff]/10 rounded-md p-2 lg:p-2.5 lg:rounded-[14px] lg:items-center lg:px-5">
            <!-- logo -->
            <div class="text-start col-span-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="max-w-20 md:max-w-[95px] lg:max-w-[110px]">
                </a>
            </div>
            <!-- logo -->

            <div class="navbar flex flex-col gap-y-4 justify-center items-center col-span-10 lg:flex-row">
                <!-- menu -->
                <div class="w-full absolute left-0 top-10 min-h-[130px] bg-card z-50 flex justify-center p-4 rounded-md hidden lg:!flex lg:relative lg:bg-transparent lg:min-h-auto lg:left-auto lg:top-auto min-w-[75%]" id="mobile-menu">
                    <ul class="flex flex-col lg:flex-row gap-y-3 lg:gap-y-0 lg:gap-x-[30px] text-center">
                        <li>
                            <a href="{{ route('home') }}" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('home') ? 'text-[#fff]' : '' }}">
                                হোম
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                কোর্সসমূহ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                এক্সপার্ট কানেকশন
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                AI আপডেট
                            </a>
                        </li> 
                    </ul>
                </div>
                <!-- menu -->

                <!-- actions -->
                <div class="w-full lg:min-w-[25%]">
                    <ul class="flex gap-x-3 lg:gap-x-[30px] text-center items-center justify-end">
                        @if (auth()->user() && auth()->user()->user_role == 'instructor')
                            <li>
                                <a href="{{ route('instructor.dashboard') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                    প্রশিক্ষক প্যানেল
                                </a>
                            </li>
                        @elseif (auth()->user() && auth()->user()->user_role == 'student')
                            <li>
                                <a href="{{ route('student.dashboard') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                    ড্যাশবোর্ড
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                    লগইন
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim hover:!bg-lime md:text-base px-3 pr-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5 lg:pr-4">
                                    ফ্রি টুলস
                                    <svg class="w-5 lg:w-8" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="29.5" width="29" height="29" rx="14.5" transform="rotate(-90 0.5 29.5)" stroke="white" />
                                        <path d="M18.3154 16.9887L18.3154 11.6854M18.3154 11.6854L13.0121 11.6854M18.3154 11.6854L11.6862 18.3146" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                        @endif
                        <li class="lg:hidden">
                            <button type="button" id="mobile-menu-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#fff]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>