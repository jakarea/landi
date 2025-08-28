@extends('layouts.latest.admin')
@section('title') Instructor Profile Details @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css">
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="user-profile-view-page">
    <div class="container-fluid"> 
        {{-- profile information @S --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="user-profile-picture">
                   {{-- user cover photo --}}
                   <div class="cover-img" id="coverImgContainer">
                    @if ($instructor->cover_photo)
                    <img src="{{ asset($instructor->cover_photo) }}" alt="Cover Photo" class="img-fluid cover-img"
                        id="item-img-output">
                    @else
                    <img src="{{ asset('assets/images/cover.svg') }}" class="img-fluid cover-img"
                        id="item-img-output" />
                    @endif

                    <input type="file" class="d-none item-img file center-block" id="coverImage"
                        accept="image/png, image/jpeg, image/svg+xml" name="cover_photo">
                    <input type="hidden" name="coverImgBase64" id="coverImgBase64">

                    <div class="ol-upload">
                        <label class="cabinet center-block icons" for="coverImage">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </label>
                    </div>
                    <div class="upload-form">
                        <button id="cancelBtn" class="d-none btn common-bttn" type="button">Cancel</button>
                        <button id="uploadBtn" class="d-none btn common-bttn" type="button">Save</button>
                    </div>
                </div>
                {{-- user cover photo --}}
                    <div class="media">
                        @if($instructor->avatar)
                        <img src="{{ asset($instructor->avatar) }}" alt="{{$instructor->name}}"
                            class="img-fluid">
                        @else
                        <span class="avatar-box">{!! strtoupper($instructor->name[0]) !!}</span>
                        @endif
                        <div class="media-body">
                            <h3>{{$instructor->name}}</h3>
                            <p>{{$instructor->user_role}}</p>
                        </div> 
                        @php 
                            $domain = env('APP_DOMAIN', 'learncosy.com');
                            $url = '//'.$instructor->subdomain.'.'.$domain.'/login-as-instructor/'.$userSessionId.'/'.$userId.'/'.$insId;
                        @endphp
                        @if ($instructor->subdomain)
                            <a href="{{$url}}" class="edit-profile">Login as {{ Str::limit($instructor->name, $limit = 12, $end = '..') }}</a>
                        @else 
                            <a href="{{ url('admin/instructor/'.$instructor->id.'/edit') }}" class="edit-profile">Edit Profile</a>
                        @endif
                        
                    </div>
                </div>
                <div class="user-details-box">
                    <h5>About Me</h5> 
                    {!! $instructor->description !!}
                </div>

                <div class="user-expperience-box">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Experiences</h4> 
                    </div>
                    @if (count($experiences) > 0)
                        @foreach ($experiences as $experience)
                            <div class="media brdr-bttm">
                                <img src="{{ asset('assets/images/experience-img.svg') }}" alt="experience-img"
                                    class="img-fluid">
                                <div class="media-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5>{{ $experience->profession }}</h5>
                                        <div>
                                            <a href="{{ url('instructor/profile/edit?id=' . $experience->id) }}"><img
                                                    src=" {{ asset('assets/images/icons/pen.svg') }}"
                                                    alt="img" class="img-fluid"></a>
                                        </div>
                                    </div>

                                    <h6>{{ $experience->company_name }} <i class="fas fa-circle"></i>
                                        {{ $experience->job_type }} <i class="fas fa-circle"></i>
                                        {{ $experience->experience }}</h6>
                                    <p>{{ $experience->short_description }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            @include('partials/no-data')
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <h4>Contact</h4>
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/email.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Email</h6>
                            <a href="mailto:{{$instructor->email}}">{{$instructor->email}}</a>
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/phone.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Phone</h6>
                            <a href="#">{{$instructor->phone ? $instructor->phone : '--'}}</a>
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/globe.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Website</h6>
                            <a href="#">{{$instructor->short_bio ? $instructor->short_bio : '--'}}</a>
                        </div>
                    </div>
                </div>
                <div class="contact-info-box mt-4">
                    <h4>Payment Log</h4> 

                    @if (count($subscription) > 0)
                        @foreach($subscription->slice(0,3) as $key => $payment)
                            <div class="media flex-column"> 
                                <div class="media-body mb-2">
                                    <h6>Payment ID:</h6>
                                    <a href="#" class="color-para">{{$payment->stripe_plan}}</a>
                                </div>
                                <div class="media-body mb-2">
                                    <h6>Instructor  Email:</h6>
                                    <a href="mailto:{{$payment->instructor->email}}" class="color-para">{{$payment->instructor->email}}</a>
                                </div>
                                <div class="media-body mb-2">
                                    <h6>Start At:</h6>
                                    <a href="#" class="color-para">{{ date('D M d Y H:i:s', strtotime($payment->start_at)) }}</a>
                                </div>
                                <div class="media-body mb-2">
                                    <h6>End At:</h6>
                                    <a href="#" class="color-para">{{$payment->end_at ? date('D M d Y H:i:s', strtotime($payment->end_at)) : 'N/A'}}</a>
                                </div>
                                <div class="media-body">
                                    <h6>Duration:</h6>
                                    <a href="#" class="color-para">
                                        @if($payment->end_at)
                                            {{\Carbon\Carbon::parse($payment->start_at)->diffInDays(\Carbon\Carbon::parse($payment->end_at))}} Days
                                        @else
                                            N/A
                                        @endif    
                                    </a>
                                </div>
                            </div> 
                        @endforeach
                    @else
                    <div class="media"> 
                        <div class="media-body"> 
                            <a href="#" class="text-danger">No Log Found!</a>
                        </div>
                    </div> 
                    @endif
                </div>
                <div class="contact-info-box mt-4">
                    <h4>Social Link</h4>
                    @php
                    $social_links = explode(",", $instructor->social_links);
                    use Illuminate\Support\Str;
                    @endphp

                    @foreach ($social_links as $social_link)
                    @php
                    $url = $social_link;
                    $host = parse_url($url, PHP_URL_HOST);
                    $domain = Str::after($host, 'www.');
                    $domain = Str::before($domain, '.');
                    @endphp

                    <div class="media">
                        @if ($domain == 'linkedin')
                        <img src="{{ asset('assets/images/icons/linkedin.svg') }}" alt="linkedin" class="img-fluid">
                        @elseif ($domain == 'instagram')
                        <img src="{{ asset('assets/images/icons/insta.svg') }}" alt="insta" class="img-fluid">
                        @elseif ($domain == 'twitter')
                        <img src="{{ asset('assets/images/icons/x.svg') }}" alt="twitter" class="img-fluid" style="width: 1.1rem;">
                        @else
                        <img src="{{ asset('assets/images/icons/globe.svg') }}" alt="linkedin" class="img-fluid">
                        @endif
                        
                        <div class="media-body">
                            <h6>{{ $domain ? $domain : 'No Social Account Found!' }}</h6>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- profile information @E --}}
    </div>
</main>

{{-- upload banner modal start --}}
@include('modals/banner-resize')
{{-- upload banner modal end --}}

@endsection
{{-- page content @E --}} 

{{-- script --}}
@section('script')
<script src='https://foliotek.github.io/Croppie/croppie.js'></script>
{{-- crop banenr image js --}}
<script src="{{ asset('assets/js/banner-crop.js') }}"></script>
{{-- set user cover photo js --}}
<script>
    document.addEventListener('DOMContentLoaded', function () { 
    const coverImgOutput = document.getElementById('item-img-output'); 
    const uploadBtn = document.getElementById('uploadBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    // Handle upload button click
    const coverImgBase64 = document.getElementById('coverImgBase64');
    uploadBtn.addEventListener('click', function () { 
        let fileBase64 = coverImgBase64.value;
        uploadFile(fileBase64);  
    });

    // Handle cancel button click
    cancelBtn.addEventListener('click', function () {
        cancelUpload();
    }); 

    // Function to handle file upload
    function uploadFile(fileBase64) {

        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');

        if (fileBase64) {
            const userId = "{{ $instructor->id }}"; 
            const requestData = {
                cover_photo: fileBase64,
                userId: userId,
            };
            cancelBtn.classList.add('d-none');
            uploadBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin-pulse"></i> Uploading`;
 
            fetch(`${baseUrl}/admin/instructor/cover/upload`, {
                    method: 'POST', 
                    body: JSON.stringify(requestData),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    },
                })
                .then(response => response.json())
                .then(data => { 
                    if (data.message === 'UPLOADED') {
                        uploadBtn.innerHTML = `Save`;
                        uploadBtn.classList.add('d-none');
                        cancelBtn.classList.add('d-none');
                    }
                })
                .catch(error => { 
                    uploadBtn.innerHTML = `Failed`;
                });
        }
    }

    // Function to handle cancel button click
        function cancelUpload() { 
            const userCoverPhoto = "{{ $instructor->cover_photo ?? null }}"; 
            coverImgOutput.src = userCoverPhoto
                ? "{{ asset('') }}" + userCoverPhoto
                : "{{ asset('assets/images/cover.svg') }}";
            coverImgBase64.value = '';
            uploadBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
        } 
    });
</script>
@endsection
{{-- script --}}