@extends('layouts.latest.instructor')
@section('title')
Course Create - Final Step
@endsection
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<style>
    .share-on-social-wrap .d-flex a {
        display: flex;
        align-items: center;
        text-decoration: none;
        margin-right: 1.5rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .share-on-social-wrap .d-flex a:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        background: #ffffff;
    }

    .share-on-social-wrap .d-flex a i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
        width: 24px;
        text-align: center;
    }

    .share-on-social-wrap .d-flex a span {
        font-weight: 500;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .share-on-social-wrap .d-flex {
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .share-on-social-wrap h6 {
        margin-bottom: 1rem;
        color: #2d3748;
        font-weight: 600;
    }

</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="course-create-step-page-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                {{-- course step --}}
               <div class="course-create-step-wrap">
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/facts' }}">Facts</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/objects' }}">Objects</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/price' }}">Price</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/design' }}">Design</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/certificate' }}">Certificate</a></p>
                </div>
                <div class="step-box active">
                    <span class="circle">
                        <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                            class="img-fluid">
                    </span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/visibility' }}">Visibility</a></p>
                </div>
                <div class="step-box current">
                    <span class="circle"></span>
                    <p><a href="{{ url('instructor/courses/create',optional(request())->route('id')).'/share' }}">Share</a></p>
                </div>
            </div>
            step 11
            {{-- course step --}}
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                <div class="share-on-social-wrap">
                    <h4>Share</h4>

                    <h6>As a post</h6>

                    <div class="d-flex">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('courses', $course->slug)}}"
                            target="_blank">
                            <i class="fab fa-facebook-f" style="color: #1877f2;"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ url('courses', $course->slug)}}" target="_blank">
                            <i class="fab fa-linkedin-in" style="color: #0077b5;"></i>
                            <span>LinkedIn</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url('courses', $course->slug)}}&text={{ $course->title }}"
                            target="_blank">
                            <i class="fab fa-twitter" style="color: #1da1f2;"></i>
                            <span>Twitter</span>
                        </a>
                    </div>

                    <h6>As a message</h6>

                    <div class="d-flex">
                        <a target="_blank" href="https://www.messenger.com/share.php?text={{ url('courses', $course->slug)}}">
                            <i class="fab fa-facebook-messenger" style="color: #0084ff;"></i>
                            <span>Messenger</span>
                        </a>
                        <a target="_blank" href="https://api.whatsapp.com/send?text={{ url('courses', $course->slug)}}">
                            <i class="fab fa-whatsapp" style="color: #25d366;"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a target="_blank" href="https://telegram.me/share/url?url={{ url('courses', $course->slug)}}">
                            <i class="fab fa-telegram-plane" style="color: #0088cc;"></i>
                            <span>Telegram</span>
                        </a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-0">
                        <h6>Or copy link</h6>
                        <span id="notify" style="color: green; font-size: 14px;"></span>
                    </div>


                    <div class="copy-link">
                        <input autocomplete="off" type="text" placeholder="Link" value="{{ url('courses', $course->slug)}}"
                            class="form-control" id="linkToCopy">
                        <a href="#" id="copyButton">Copy</a>
                    </div>

                </div>

                {{-- step next bttns --}}
                <div class="back-next-bttns">
                    <a href="{{ url('instructor/courses/create/'.$course->id.'/visibility')}}">Back</a>
                    <a href="{{ url('instructor/courses/create/'.$course->id.'/finish')}}">Finish</a>
                </div>
                {{-- step next bttns --}}
            </div>
        </div>
</main>
@endsection
{{-- page content @E --}}

@section('script')
<script>
    const copyButton = document.getElementById("copyButton");
    const linkToCopy = document.getElementById("linkToCopy");
    const notify = document.getElementById("notify");

    copyButton.addEventListener("click", (e) => {
        e.preventDefault();
        linkToCopy.select();
        document.execCommand("copy");
        notify.innerText = 'Copied!';

        setTimeout(() => {
            notify.innerText = '';
        }, 1000);

    });

</script>
@endsection
