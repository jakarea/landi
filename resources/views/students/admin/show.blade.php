@extends('layouts.latest.admin')
@section('title') Student Profile Details Page @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content') 
@php
    $social_links = explode(",", $student->social_links);
    use Illuminate\Support\Str;
@endphp

<main class="user-profile-view-page">
    <div class="container-fluid"> 
        {{-- profile information @S --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="user-profile-picture">
                    {{-- user cover photo --}}
                    <div class="cover-img" id="coverImgContainer">
                        @if ($student->cover_photo)
                        <img src="{{ asset($student->cover_photo) }}" alt="Cover Photo" class="img-fluid cover-img"
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
                        @if($student->avatar)
                        <img src="{{ asset($student->avatar) }}" alt="{{$student->name}}"
                            class="img-fluid">
                        @else
                        <span class="avatar-box">{!! strtoupper($student->name[0]) !!}</span>
                        @endif
                        <div class="media-body">
                            <h3>{{ Str::limit($student->name, $limit1 = 18, $end1 = '...') }}</h3>
                            <p class="text-capitalize">{{$student->user_role}}</p>
                        </div>
                        @php 
                            $domain = env('APP_DOMAIN', 'learncosy.com');
                            $url = '//'.$student->subdomain.'.'.$domain.'/login-as-student/'.$userSessionId.'/'.$userId.'/'.$stuId;
                        @endphp  
                        <a href="{{ $url }}" class="edit-profile">Login as {{ Str::limit($student->name, $limit1 = 13, $end1 = '...') }}</a>

                    </div>
                </div> 
            </div>
            <div class="col-lg-4">
                <div class="contact-info-box">
                    <h4>Contact</h4>
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/email.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Email</h6>
                            <a href="mailto:{{$student->email}}">{{$student->email}}</a>
                        </div>
                    </div>
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/phone.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Phone</h6>
                            <a href="#">{{$student->phone ? $student->phone : '--'}}</a>
                        </div>
                    </div> 
                    <div class="media">
                        <img src="{{ asset('assets/images/icons/globe.svg') }}" alt="email" class="img-fluid">
                        <div class="media-body">
                            <h6>Website</h6>
                            <a href="#">{{$student->short_bio ? $student->short_bio : '--'}}</a>
                        </div>
                    </div> 
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
                        <img src="{{ asset('assets/images/icons/x.svg') }}" width="22" alt="x" class="img-fluid">
                        @elseif ($domain == 'facebook')
                        <i class="fa-brands fa-facebook-square" style="color: rgba(28, 28, 28, 0.626); font-size: 1.3rem; margin-right: 1rem; width: 24px;
                        height: 24px;
                        margin-top: 0.5rem;"></i>
                        @else
                        <img src="{{ asset('assets/images/icons/globe.svg') }}" alt="linkedin" class="img-fluid">
                        @endif 
                        <div class="media-body">
                            <h6>{{ $domain ? $domain : '--' }}</h6>
                            <a target="_blank" href="{{ $social_link ? $social_link : '#' }}">{{ $social_link ? $social_link : '--' }}</a>
                        </div>
                    </div>
                    @endforeach
                </div> 
            </div>
            <div class="col-lg-12">
                <div class="user-details-box">
                    <h5>About Me</h5>
                    {!! $student->description !!}
                </div>
            </div>
            <div class="col-lg-12">
                <div class="enroll-course-list">
                    <h4>Enrolled Course List :</h4>
                    <div class="list-wrap">
                        <table>
                            <tr>
                                <th width="2%">No</th>
                                <th>Payment ID</th> 
                                <th>Course Name</th>
                                <th>Course Instructor</th>
                                <th>Payment Date</th>
                                <th>Payment Amount</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr> 
                            {{-- item @S --}} 
                            @foreach($checkout as $key => $value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ Str::limit($value->payment_id, $limit1 = 18, $end1 = '...') }}</td>
                                <td>{{ Str::limit( optional($value->course)->title, $limit2 = 18, $end2 = '...') }}</td>
                                <td>{{ $value->course ? optional($value->course->user)->name : '' }}</td>
                                <td>{{ strftime('%a %b %Y', strtotime($value->created_at)) }}</td>
                                <td>৳ {{$value->amount}}</td>
                                <td>
                                    @if($value->payment_status == 'completed' || $value->payment_status == 'Paid')
                                        <span>Success</span>
                                    @else
                                        <span class="bg-danger">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/courses/overview/'. optional($value->course)->slug)}}" class="view-course-bttn">View Course</a>
                                </td>
                            </tr> 
                            @endforeach 
                            {{-- item @E --}} 
                        </table>
                    </div>
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
            const userId = "{{ $student->id }}"; 
            const requestData = {
                cover_photo: fileBase64,
                userId: userId,
            };
            cancelBtn.classList.add('d-none');
            uploadBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin-pulse"></i> Uploading`;
 
            fetch(`${baseUrl}/admin/students/cover/upload`, {
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
            const userCoverPhoto = "{{ $student->cover_photo ?? null }}"; 
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