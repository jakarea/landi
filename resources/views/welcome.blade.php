@extends('layouts.guest')
@section('title', 'শিখুন - আধুনিক অনলাইন শিক্ষা প্ল্যাটফর্ম')
@php
    use Illuminate\Support\Str;
@endphp

@section('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
  rel="stylesheet">
@vite(['resources/css/tailwind.css'])
<style>
/* Override Bootstrap styles for this page */
body {
  font-family: "Hind Siliguri", sans-serif !important;
  padding-top: 0 !important;
  background-color: #091D3D !important;
}
.container-fluid, .container {
  max-width: none !important;
  padding: 0 !important;
  margin: 0 !important;
}
.modern-navbar {
  display: none !important;
}
.modern-footer {
  display: none !important;
}
main {
  display: contents !important;
}
</style>
@endsection

@section('content')
<body class="bg-body">

  <!-- Hero Section -->
  <section class="w-full pt-12 pb-20 first-gradient relative overflow-hidden border-b border-[#fff]/20 xl:py-[188px]">
    <div class="absolute inset-0 grid-background opacity-[13%] z-10"></div>
    
    <div class="container-x">
      <div class="w-full grid grid-cols-1 lg:grid-cols-2 lg:gap-x-20 xl:gap-x-[105px] lg:items-center">
        <div class="w-full">
          <div class="w-full flex justify-center items-center gap-x-2.5 relative z-40 lg:justify-start">
            <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
              <i class="fas fa-graduation-cap text-[#5AEAF4] text-lg lg:text-xl"></i>
            </div>
            <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
              <i class="fas fa-book-open text-[#5AEAF4] text-lg lg:text-xl"></i>
            </div>
            <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
              <i class="fas fa-users text-[#5AEAF4] text-lg lg:text-xl"></i>
            </div>
          </div>
          
          <div class="text-center relative z-40 lg:text-start">
            <h1 class="text-orange font-medium text-sm my-2.5 lg:text-base">অনলাইন শিক্ষা প্ল্যাটফর্ম - ২০২৫</h1>
            <h2 class="font-bold text-[28px] leading-[110%] text-[#fff] lg:text-[40px]">শিখুন নতুন <span class="text-gradient">দক্ষতা, গড়ুন</span> উজ্জ্বল ভবিষ্যৎ</h2>
            <h3 class="text-secondary-200 mt-2 font-medium text-sm lg:text-base">দেশের সেরা প্রশিক্ষকদের কাছ থেকে শিখুন</h3>
            <p class="text-secondary-100 mt-[30px] font-normal text-sm md:text-base lg:text-base lg:max-w-[80%] xl:max-w-[70%]">
              প্রোগ্রামিং, ডিজাইন, মার্কেটিং এবং আরও অনেক বিষয়ে আমাদের কোর্সগুলি দিয়ে নিজেকে দক্ষ করে তুলুন। 
              আন্তর্জাতিক মানের শিক্ষা, প্রজেক্ট-ভিত্তিক শেখানোর মাধ্যমে আপনি হয়ে উঠবেন একজন পেশাদার।
            </p>

            <div class="w-full lg:flex lg:items-center lg:gap-x-[30px] lg:mt-[30px]">
              <h4 class="mt-[30px] mb-2.5 font-medium text-sm text-secondary-100 underline lg:my-0 lg:order-2 lg:text-lg">১০০+ কোর্স উপলব্ধ</h4>
              @guest
                <a href="{{ route('register') }}" class="inline-flex justify-center items-center bg-primary rounded-full p-1.5 font-medium text-sm text-secondary-100 pl-4 gap-x-2.5 anim hover:bg-orange md:text-base lg:text-lg lg:p-2.5 lg:pl-4.5 hover:text-primary group lg:my-0 lg:order-1">
                  নিবন্ধন করুন
                  <span class="w-[30px] h-[30px] rounded-full bg-[#fff]/40 flex items-center justify-center anim group-hover:bg-primary">
                    <i class="fas fa-arrow-right text-white text-sm"></i>
                  </span>
                </a>
              @else
                @if(auth()->user()->user_role === 'student')
                  <a href="{{ url('/student/dashboard') }}" class="inline-flex justify-center items-center bg-primary rounded-full p-1.5 font-medium text-sm text-secondary-100 pl-4 gap-x-2.5 anim hover:bg-orange md:text-base lg:text-lg lg:p-2.5 lg:pl-4.5 hover:text-primary group lg:my-0 lg:order-1">
                    আমার কোর্স
                    <span class="w-[30px] h-[30px] rounded-full bg-[#fff]/40 flex items-center justify-center anim group-hover:bg-primary">
                      <i class="fas fa-arrow-right text-white text-sm"></i>
                    </span>
                  </a>
                @else
                  <a href="{{ url('/instructor/dashboard') }}" class="inline-flex justify-center items-center bg-primary rounded-full p-1.5 font-medium text-sm text-secondary-100 pl-4 gap-x-2.5 anim hover:bg-orange md:text-base lg:text-lg lg:p-2.5 lg:pl-4.5 hover:text-primary group lg:my-0 lg:order-1">
                    ড্যাশবোর্ড
                    <span class="w-[30px] h-[30px] rounded-full bg-[#fff]/40 flex items-center justify-center anim group-hover:bg-primary">
                      <i class="fas fa-arrow-right text-white text-sm"></i>
                    </span>
                  </a>
                @endif
              @endguest
            </div>
          </div>
        </div>
        
        <div class="text-center relative z-40 mt-7 lg:max-w-[90%] xl:max-w-[80%]">
          <div class="gradient-border">
            <div class="gradient-border-content p-0 relative">
              <img src="{{ asset('assets/images/login-3-image.png') }}" alt="learning platform"
                class="rounded-[calc(0.75rem-2px)] w-full shadow-1">
              <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                <button type="button" class="w-[90px] h-[90px] rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                  <i class="fas fa-play text-white text-2xl ml-1"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="w-full pt-20">
    <div class="container-x">
      <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
        <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
          <i class="fas fa-star text-[#5AEAF4]"></i>
        </div>
        <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">কেন আমাদের <span class="text-gradient">প্ল্যাটফর্ম বেছে নেবেন?</span></h2>
        <p class="common-para text-secondary-200">আমাদের রয়েছে আধুনিক শিক্ষা ব্যবস্থা এবং অভিজ্ঞ প্রশিক্ষক দল</p>
      </div>

      <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 lg:gap-y-0 xl:gap-x-[45px]">
        <div class="rounded-[10px] p-[30px] bg-card text-center">
          <i class="fas fa-play-circle text-[#5AEAF4] text-[60px] mb-10"></i>
          <h4 class="text-blue font-semibold text-lg mb-2.5 lg:text-xl">ভিডিও লেকচার</h4>
          <p class="common-para text-secondary-200 lg:!text-[15px]">HD মানের ভিডিও লেকচার যা আপনি যেকোনো সময় যেকোনো জায়গা থেকে দেখতে পারবেন। ইন্টারেক্টিভ কনটেন্ট ও প্রয়োজনীয় রিসোর্স সহ।</p>
        </div>

        <div class="rounded-[10px] p-[30px] bg-card text-center">
          <i class="fas fa-certificate text-[#5AEAF4] text-[60px] mb-10"></i>
          <h4 class="text-blue font-semibold text-lg mb-2.5 lg:text-xl">সার্টিফিকেট</h4>
          <p class="common-para text-secondary-200 lg:!text-[15px]">কোর্স সম্পূর্ণ করার পর পাবেন ভেরিফাইড সার্টিফিকেট যা আপনার ক্যারিয়ারে কাজে লাগবে এবং আপনার দক্ষতা প্রমাণ করবে।</p>
        </div>

        <div class="rounded-[10px] p-[30px] bg-card text-center">
          <i class="fas fa-users text-[#5AEAF4] text-[60px] mb-10"></i>
          <h4 class="text-blue font-semibold text-lg mb-2.5 lg:text-xl">কমিউনিটি সাপোর্ট</h4>
          <p class="common-para text-secondary-200 lg:!text-[15px]">অন্যান্য শিক্ষার্থী ও প্রশিক্ষকদের সাথে যোগাযোগ করে জ্ঞান বিনিময় করুন। প্রশ্ন করুন ও সাহায্য পান।</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="w-full py-20 bg-[#011330] border-y border-[#fff]/20">
    <div class="container-x">
      <div class="w-full grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="text-center bg-card rounded-[10px] p-6">
          <span class="font-bold text-[3rem] text-gradient block">১০০+</span>
          <p class="text-secondary-200 font-medium text-base mt-2">কোর্স</p>
        </div>
        <div class="text-center bg-card rounded-[10px] p-6">
          <span class="font-bold text-[3rem] text-gradient block">৫০০+</span>
          <p class="text-secondary-200 font-medium text-base mt-2">শিক্ষার্থী</p>
        </div>
        <div class="text-center bg-card rounded-[10px] p-6">
          <span class="font-bold text-[3rem] text-gradient block">২৫+</span>
          <p class="text-secondary-200 font-medium text-base mt-2">প্রশিক্ষক</p>
        </div>
        <div class="text-center bg-card rounded-[10px] p-6">
          <span class="font-bold text-[3rem] text-gradient block">৯৮%</span>
          <p class="text-secondary-200 font-medium text-base mt-2">সন্তুষ্টি</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Latest Courses Section -->
  @if(isset($latestCourses) && $latestCourses->count() > 0)
  <section class="w-full pt-20 lg:pt-[90px]">
    <div class="container-x">
      <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
        <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
          <i class="fas fa-book text-[#5AEAF4]"></i>
        </div>
        <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">সর্বশেষ <span class="text-gradient">কোর্সগুলি</span></h2>
        <p class="common-para text-secondary-200">আমাদের নতুন এবং জনপ্রিয় কোর্সগুলি দেখুন</p>
      </div>

      <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($latestCourses->take(3) as $course)
        <div class="bg-card rounded-[10px] overflow-hidden shadow-2 anim hover:shadow-1">
          <div class="relative">
            <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/images/courses/default-thumbnail.svg') }}" 
                 alt="{{ $course->title }}" 
                 class="w-full h-48 object-cover">
            @if($course->offer_price)
            <span class="absolute top-4 right-4 bg-orange text-primary px-3 py-1 rounded-full text-sm font-semibold">অফার</span>
            @endif
          </div>
          
          <div class="p-6">
            <div class="mb-3">
              <span class="bg-[#3C5D62] text-blue px-3 py-1 rounded-full text-xs font-medium">
                {{ explode(',', $course->categories)[0] ?? 'সাধারণ' }}
              </span>
            </div>
            
            <h3 class="text-[#E2E8F0] font-semibold text-lg mb-3 leading-tight">
              <a href="{{ route('courses.overview', $course->slug) }}" class="hover:text-blue anim">
                {{ Str::limit($course->title, 60) }}
              </a>
            </h3>
            
            <p class="text-secondary-200 text-sm mb-4 leading-relaxed">
              {{ Str::limit(strip_tags($course->description), 100) }}
            </p>
            
            <div class="flex justify-between items-center">
              <div>
                @if($course->offer_price)
                  <span class="text-orange font-bold text-lg">৳{{ number_format($course->offer_price) }}</span>
                  <span class="text-secondary-200 line-through text-sm ml-2">৳{{ number_format($course->price) }}</span>
                @else
                  <span class="text-orange font-bold text-lg">৳{{ number_format($course->price) }}</span>
                @endif
              </div>
              
              <div class="flex items-center gap-1">
                @for($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star text-xs" style="color: {{ $i <= 4 ? '#FFBB32' : '#3C5D62' }}"></i>
                @endfor
                <span class="text-secondary-200 text-xs ml-1">(4.0)</span>
              </div>
            </div>
            
            <a href="{{ route('courses.overview', $course->slug) }}" 
               class="inline-flex justify-center items-center bg-blue rounded-full px-4 py-2 font-medium text-sm text-primary mt-4 w-full anim hover:bg-orange hover:text-primary group">
              বিস্তারিত দেখুন
              <i class="fas fa-arrow-right text-xs ml-2 anim group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
        @endforeach
      </div>

      <div class="text-center mt-12">
        <a href="{{ route('courses') }}" 
           class="inline-flex justify-center items-center bg-primary rounded-full px-8 py-3 font-medium text-lg text-secondary-100 anim hover:bg-orange hover:text-primary">
          সব কোর্স দেখুন
          <i class="fas fa-arrow-right text-sm ml-2"></i>
        </a>
      </div>
    </div>
  </section>
  @endif

  <!-- Testimonials Section -->
  <section class="w-full py-10 lg:py-20">
    <div class="container-x">
      <div class="text-center flex justify-center items-center flex-col mb-8 lg:mb-16 xl:mb-20">
        <div class="text-center w-12 h-12 rounded-full bg-[#3C5D62] flex items-center justify-center lg:w-[50px] lg:h-[50px]">
          <i class="fas fa-quote-left text-[#5AEAF4]"></i>
        </div>
        <h2 class="font-bold text-2xl text-[#fff] mt-3 mb-3 lg:text-[32px]">শিক্ষার্থীদের <span class="text-gradient">অভিজ্ঞতা</span></h2>
        <p class="common-para text-secondary-200">যারা শিখেছেন, তাদের মুখে শেখার গল্প</p>
      </div>

      <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="w-full bg-card rounded-[10px] p-5 shadow-2">
          <span class="flex items-center justify-center w-10 h-10 rounded-full bg-body p-1">
            <i class="fas fa-quote-right text-blue text-lg"></i>
          </span>
          <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">
            এই প্ল্যাটফর্মে শেখার পর আমার প্রোগ্রামিং স্কিল অনেক উন্নত হয়েছে। 
            প্রশিক্ষকদের শেখানোর পদ্ধতি খুবই কার্যকর এবং বাস্তবসম্মত।
          </p>
          <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10">
            <span class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>সাদিয়া রহমান
          </h5>
          <h6 class="common-para text-secondary-200 ml-5">ওয়েব ডেভেলপার</h6>
        </div>

        <div class="w-full bg-card rounded-[10px] p-5 shadow-2">
          <span class="flex items-center justify-center w-10 h-10 rounded-full bg-body p-1">
            <i class="fas fa-quote-right text-blue text-lg"></i>
          </span>
          <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">
            ডিজিটাল মার্কেটিং কোর্স করে আমার ক্যারিয়ারে নতুন দিক উন্মোচিত হয়েছে। 
            এখন আমি একটি ভালো কোম্পানিতে মার্কেটিং এক্সিকিউটিভ হিসেবে কাজ করছি।
          </p>
          <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10">
            <span class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>তানভীর আহমেদ
          </h5>
          <h6 class="common-para text-secondary-200 ml-5">মার্কেটিং এক্সিকিউটিভ</h6>
        </div>

        <div class="w-full bg-card rounded-[10px] p-5 shadow-2">
          <span class="flex items-center justify-center w-10 h-10 rounded-full bg-body p-1">
            <i class="fas fa-quote-right text-blue text-lg"></i>
          </span>
          <p class="font-normal text-base text-[#A8A8A8] leading-[140%] mt-7">
            গ্রাফিক ডিজাইনে আগে অনেক সময় লাগত। এখানে শেখার পর কাজের গতি বেড়েছে। 
            ক্লায়েন্টদের সাথে কাজ করতে আর কোন সমস্যা হয় না।
          </p>
          <h5 class="font-medium text-lg text-[#E2E8F0] flex items-center gap-x-2 mt-10">
            <span class="inline-block w-4 h-[2px] bg-[#D9D9D9]"></span>নওশীন হোসেন
          </h5>
          <h6 class="common-para text-secondary-200 ml-5">গ্রাফিক ডিজাইনার</h6>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="w-full py-10 lg:py-20 bg-[#011330] border-y border-[#fff]/20">
    <div class="container-x">
      <div class="text-center">
        <h2 class="font-bold text-2xl text-[#fff] lg:text-[32px] mb-4">আজই শুরু করুন আপনার <span class="text-gradient">শিক্ষা যাত্রা</span></h2>
        <p class="text-secondary-200 text-base lg:text-lg mb-8 lg:max-w-2xl mx-auto">
          হাজারো শিক্ষার্থীর সাথে যুক্ত হয়ে নিজেকে দক্ষ করে তুলুন। আমাদের প্ল্যাটফর্মে রয়েছে সব ধরনের কোর্স।
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          @guest
            <a href="{{ route('register') }}" 
               class="inline-flex justify-center items-center bg-primary rounded-full px-8 py-3 font-medium text-lg text-secondary-100 anim hover:bg-orange hover:text-primary">
              <i class="fas fa-user-plus mr-2"></i>
              নতুন একাউন্ট তৈরি করুন
            </a>
            <a href="{{ route('login') }}" 
               class="inline-flex justify-center items-center bg-transparent border-2 border-blue rounded-full px-8 py-3 font-medium text-lg text-blue anim hover:bg-blue hover:text-primary">
              <i class="fas fa-sign-in-alt mr-2"></i>
              লগইন করুন
            </a>
          @else
            @if(auth()->user()->user_role === 'student')
              <a href="{{ url('/student/dashboard') }}" 
                 class="inline-flex justify-center items-center bg-primary rounded-full px-8 py-3 font-medium text-lg text-secondary-100 anim hover:bg-orange hover:text-primary">
                <i class="fas fa-book-open mr-2"></i>
                আমার কোর্স দেখুন
              </a>
            @else
              <a href="{{ url('/instructor/dashboard') }}" 
                 class="inline-flex justify-center items-center bg-primary rounded-full px-8 py-3 font-medium text-lg text-secondary-100 anim hover:bg-orange hover:text-primary">
                <i class="fas fa-tachometer-alt mr-2"></i>
                ড্যাশবোর্ড
              </a>
            @endif
          @endguest
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="w-full">
    <div class="container-x">
      <div class="w-full text-center lg:flex items-center justify-between border-t border-[#fff]/20 py-5 xl:py-10">
        <h6 class="font-medium text-sm text-[#ABABAB] lg:text-base">
          কপিরাইট &copy;2025 শিখুন প্ল্যাটফর্ম। সর্বস্বত্ব সংরক্ষিত।
        </h6>
        <p class="font-semibold text-base text-[#ABABAB] lg:text-base mt-2 lg:mt-0">
          আধুনিক প্রযুক্তি সহায়তায় ডিজাইন ও ডেভেলপমেন্ট
        </p>
      </div>
    </div>
  </footer>

</body>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simple animations on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.bg-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Smooth scroll animations for gradient elements
    document.querySelectorAll('.text-gradient').forEach(element => {
        element.style.backgroundSize = '200% 200%';
        element.style.animation = 'gradientMove 3s ease infinite';
    });
});

// CSS Animation for gradient text
const style = document.createElement('style');
style.textContent = `
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
`;
document.head.appendChild(style);
</script>
@endsection