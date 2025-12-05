@extends('layouts.guest-modern')

@section('title', $blog->title . ' - AI আপডেট')
@section('description', $blog->excerpt ?? Str::limit(strip_tags($blog->content), 160))

@section('content')

<!-- Hero Section with Thumbnail -->
<section class="w-full relative overflow-hidden bg-gradient-to-b from-[#000] to-[#0a0a0a] pt-20 lg:pt-32 pb-0">
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
        @include('partials.guest.header-modern')
    </div>
    
    <div class="container-x relative z-10 mt-20 lg:mt-24">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-[#ABABAB] hover:text-[#E850FF] transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="font-medium">সব ব্লগ</span>
            </a>
        </div>

        <!-- Category and Date -->
        <div class="flex items-center gap-4 mb-4">
            @if($blog->category)
                <span class="bg-[#E850FF] text-[#fff] text-sm font-medium px-4 py-1.5 rounded-full">
                    {{ $blog->category }}
                </span>
            @endif
            <span class="text-[#ABABAB] text-sm">
                {{ $blog->published_at->format('F d, Y') }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="font-bold text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-[#E2E8F0] leading-[120%] mb-6">
            {{ $blog->title }}
        </h1>

        <!-- Author Info -->
        <div class="flex items-center gap-3 mb-8">
            @if($blog->author->avatar)
                <img src="{{ asset($blog->author->avatar) }}" alt="{{ $blog->author->name }}" class="w-12 h-12 rounded-full object-cover">
            @else
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-[#E850FF] to-[#4941C8] flex items-center justify-center">
                    <span class="text-[#fff] text-lg font-semibold">{{ substr($blog->author->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <p class="text-[#E2E8F0] font-medium">{{ $blog->author->name }}</p>
                @if($blog->author->short_bio)
                    <p class="text-[#ABABAB] text-sm">{{ $blog->author->short_bio }}</p>
                @endif
            </div>
        </div>

        <!-- Featured Image -->
        @if($blog->thumbnail)
            <div class="w-full h-[300px] md:h-[400px] lg:h-[500px] rounded-lg lg:rounded-[20px] overflow-hidden">
                <img src="{{ asset($blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            </div>
        @endif
    </div>
</section>

<!-- Blog Content -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <div class="max-w-4xl mx-auto">
            <!-- Content -->
            <div class="prose prose-invert prose-lg max-w-none">
                <div class="text-[#E2E8F0] leading-relaxed blog-content">
                    {!! $blog->content !!}
                </div>
            </div>

            <!-- Share Section -->
            <div class="mt-12 pt-8 border-t border-[#232323]">
                <h3 class="text-[#E2E8F0] font-semibold text-lg mb-4">শেয়ার করুন</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-[#1877F2] hover:bg-[#166FE5] text-[#fff] px-4 py-2 rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-[#1DA1F2] hover:bg-[#1A91DA] text-[#fff] px-4 py-2 rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Twitter
                    </a>
                    <button onclick="copyToClipboard('{{ route('blog.show', $blog->slug) }}')"
                            class="inline-flex items-center gap-2 bg-[#fff]/10 hover:bg-[#fff]/20 text-[#fff] px-4 py-2 rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        কপি লিংক
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Blogs -->
@if($relatedBlogs->count() > 0)
<section class="w-full py-10 lg:py-20 bg-[#0a0a0a]">
    <div class="container-x">
        <div class="text-center mb-10 lg:mb-16">
            <h6 class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                আরও পড়ুন
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] mt-5 lg:mt-[30px]">
                সম্পর্কিত <span class="text-gradient">ব্লগ পোস্ট</span>
            </h2>
        </div>

        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 md:gap-6 lg:gap-8">
            @foreach($relatedBlogs as $relatedBlog)
                <!-- Blog Card -->
                <div class="w-full p-5 lg:p-6 border-[2px] !border-primary rounded-lg lg:rounded-[20px] bg-[#131620] anim effect-card relative flex flex-col">
                    <!-- Thumbnail -->
                    <div class="w-full h-[220px] relative overflow-hidden rounded-lg">
                        <img 
                            src="{{ $relatedBlog->thumbnail ? asset($relatedBlog->thumbnail) : asset('images/default-blog.jpg') }}" 
                            alt="{{ $relatedBlog->title }}" 
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                        >
                        @if($relatedBlog->category)
                            <div class="absolute top-3 right-3 z-10">
                                <span class="bg-[#E850FF] text-[#fff] text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $relatedBlog->category }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="mt-5 flex-1 flex flex-col">
                        <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="font-semibold text-base lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 hover:text-[#E850FF] transition-colors duration-300">
                            {{ $relatedBlog->title }}
                        </a>

                        <!-- Author and Date -->
                        <div class="mt-auto pt-4 border-t border-[#232323]">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if($relatedBlog->author->avatar)
                                        <img src="{{ asset($relatedBlog->author->avatar) }}" alt="{{ $relatedBlog->author->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-[#E850FF] to-[#4941C8] flex items-center justify-center">
                                            <span class="text-[#fff] text-xs font-semibold">{{ substr($relatedBlog->author->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="text-[#ABABAB] text-xs">{{ $relatedBlog->author->name }}</span>
                                </div>
                                <span class="text-[#ABABAB] text-xs">
                                    {{ $relatedBlog->published_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Read More Button -->
                    <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="mt-4 w-full inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-2 lg:p-3 font-medium text-sm lg:text-base text-[#fff] anim hover:text-primary group">
                        বিস্তারিত পড়ুন
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
    .blog-content {
        font-size: 1.125rem;
        line-height: 1.8;
    }
    
    .blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4, .blog-content h5, .blog-content h6 {
        color: #E2E8F0;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .blog-content h1 { font-size: 2rem; }
    .blog-content h2 { font-size: 1.75rem; }
    .blog-content h3 { font-size: 1.5rem; }
    
    .blog-content p {
        margin-bottom: 1.5rem;
        color: #E2E8F0;
    }
    
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
        color: #E2E8F0;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    
    .blog-content a {
        color: #E850FF;
        text-decoration: underline;
    }
    
    .blog-content a:hover {
        color: #4941C8;
    }
    
    .blog-content img {
        border-radius: 0.5rem;
        margin: 2rem 0;
    }
    
    .blog-content blockquote {
        border-left: 4px solid #E850FF;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #ABABAB;
    }
    
    .blog-content code {
        background-color: #131620;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #CDFF5C;
    }
    
    .blog-content pre {
        background-color: #131620;
        padding: 1.5rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 2rem 0;
    }
    
    .blog-content pre code {
        background-color: transparent;
        padding: 0;
    }
</style>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('লিংক কপি হয়েছে!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>

@endsection
