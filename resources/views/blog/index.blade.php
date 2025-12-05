@extends('layouts.guest-modern')

@section('title', 'AI আপডেট - আব্দুর রউফ')
@section('description', 'AI এবং ক্রিয়েটিভ টেকনোলজি সম্পর্কিত সর্বশেষ আপডেট এবং টিউটোরিয়াল')

@section('content')

<!-- Hero Section -->
<section class="w-full relative overflow-hidden bg-gradient-to-b from-[#000] to-[#0a0a0a] pt-20 lg:pt-32 pb-10 lg:pb-20">
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
        @include('partials.guest.header-modern')
    </div>
    
    <div class="container-x relative z-10 mt-20 lg:mt-24">
        <div class="text-center">
            <h6 class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                ব্লগ
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mt-5 lg:mt-[30px]">
                <span class="text-gradient">AI আপডেট</span>
            </h1>
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                AI এবং ক্রিয়েটিভ টেকনোলজি সম্পর্কিত সর্বশেষ আপডেট, টিউটোরিয়াল এবং টিপস
            </p>
        </div>
    </div>
</section>

<!-- Blog List Section -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <!-- Search and Filter -->
        <div class="mb-10 lg:mb-16">
            <form action="{{ route('blog.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="ব্লগ খুঁজুন..." 
                        class="w-full bg-[#131620] border border-[#232323] rounded-lg py-3 px-4 text-[#fff] placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                    >
                </div>
                @if($categories->count() > 0)
                <div class="w-full md:w-64">
                    <select 
                        name="category" 
                        class="w-full bg-[#131620] border border-[#232323] rounded-lg py-3 px-4 text-[#fff] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                    >
                        <option value="">সব ক্যাটাগরি</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <button 
                    type="submit" 
                    class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-lg p-3 px-6 font-medium text-base text-[#fff] anim hover:text-primary"
                >
                    খুঁজুন
                </button>
            </form>
        </div>

        @if($blogs->count() > 0)
            <!-- Blog Grid -->
            <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 md:gap-6 lg:gap-8">
                @foreach($blogs as $blog)
                    <!-- Blog Card -->
                    <div class="w-full p-5 lg:p-6 border-[2px] !border-primary rounded-lg lg:rounded-[20px] bg-[#131620] anim effect-card relative flex flex-col">
                        <!-- Thumbnail -->
                        <div class="w-full h-[220px] relative overflow-hidden rounded-lg">
                            <img 
                                src="{{ $blog->thumbnail ? asset($blog->thumbnail) : asset('images/default-blog.jpg') }}" 
                                alt="{{ $blog->title }}" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                            >
                            @if($blog->category)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="bg-[#E850FF] text-[#fff] text-xs font-medium px-3 py-1 rounded-full">
                                        {{ $blog->category }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="mt-5 flex-1 flex flex-col">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="font-semibold text-base lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 hover:text-[#E850FF] transition-colors duration-300">
                                {{ $blog->title }}
                            </a>

                            @if($blog->excerpt)
                                <p class="font-normal text-sm text-[#ABABAB] leading-[160%] mb-4">
                                    {{ Str::limit($blog->excerpt, 120) }}
                                </p>
                            @endif

                            <!-- Author and Date -->
                            <div class="mt-auto pt-4 border-t border-[#232323]">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if($blog->author->avatar)
                                            <img src="{{ asset($blog->author->avatar) }}" alt="{{ $blog->author->name }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#E850FF] to-[#4941C8] flex items-center justify-center">
                                                <span class="text-[#fff] text-xs font-semibold">{{ substr($blog->author->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <span class="text-[#ABABAB] text-xs">{{ $blog->author->name }}</span>
                                    </div>
                                    <span class="text-[#ABABAB] text-xs">
                                        {{ $blog->published_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Read More Button -->
                        <a href="{{ route('blog.show', $blog->slug) }}" class="mt-4 w-full cursor-pointer z-30 inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-2 lg:p-3 font-medium text-sm lg:text-base text-[#fff] anim hover:text-primary group">
                            বিস্তারিত পড়ুন
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10 lg:mt-16">
                {{ $blogs->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="flex justify-center items-center flex-col py-20">
                <div class="w-20 h-20 rounded-full bg-[#fff]/10 flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-[#ABABAB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="text-[#E2E8F0] font-semibold text-2xl mb-2">কোনো ব্লগ পাওয়া যায়নি!</h3>
                <p class="text-[#ABABAB] text-center max-w-md">
                    @if(request('search') || request('category'))
                        আপনার অনুসন্ধানের সাথে মিল রয়েছে এমন কোনো ব্লগ খুঁজে পাওয়া যায়নি।
                        <a href="{{ route('blog.index') }}" class="text-[#E850FF] hover:underline block mt-2">সব ব্লগ দেখুন</a>
                    @else
                        শীঘ্রই নতুন ব্লগ পোস্ট যোগ করা হবে।
                    @endif
                </p>
            </div>
        @endif
    </div>
</section>

@endsection
