@extends('layouts.latest.instructor')
@section('title') Account Management @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />
<style>
    .select-style-div-2,
    .select-style-div {
        cursor: pointer;
    }
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- student update page @S --}}
<main class="student-profile-update-page instructor-profile-update-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="own-profile-box account-settings-box">
                    <div class="header">
                        <ul class="nav nav-pills main-navigator" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true" data-param="profile">My Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link" id="pills-experience-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-experience" type="button" role="tab"
                                    aria-controls="pills-experience" aria-selected="false"
                                    data-param="experience">Experience</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link" id="pills-certificate-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-certificate" type="button" role="tab"
                                    aria-controls="pills-certificate" aria-selected="false"
                                    data-param="certificate">Certificate</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link" id="pills-app-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-app" type="button" role="tab" aria-controls="pills-app"
                                    aria-selected="false" data-param="app">Connect account</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link" id="pills-password-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-password" type="button" role="tab"
                                    aria-controls="pills-password" aria-selected="false"
                                    data-param="password">Password</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        {{-- profile tab start --}}
                        <div class="tab-pane tab-con active-bg fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('instructor.profile.update') }}"
                                method="POST" class="profile-form create-form-box profile-frm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row custom-padding">
                                    <div class="col-xl-3 col-lg-4">
                                        <div class="profile-picture-box">
                                            <div class=" userEditeBtn position-relative">
                                                <a href="javascript:;" id="image-container" class="drop-container">
                                                    <input type="file" name="avatar" value="" accept="image/*"
                                                        id="avatar"
                                                        class="item-img file center-block filepreviewprofile ">

                                                    <label for="avatar" class="img-upload">
                                                        <img src="{{asset('assets/images/icons/camera-plus-w.svg')}}"
                                                            alt="Upload" class="img-fluid">
                                                        <p>Update photo</p>

                                                        <div class="ol">
                                                            @if ($user->avatar)
                                                            <img src="{{asset($user->avatar)}}" alt="Avatar" id="item-img-output" class="imgpreviewPrf img-fluid">
                                                            @else
                                                            <img src="" alt=" " id="item-img-output" class="imgpreviewPrf img-fluid position-absolute" style="left: 0; z-index: 9;">
                                                            <span class="avatar-box position-absolute" style="color: #3D5CFF;left: 0;">{!!
                                                                strtoupper($user->name[0]) !!}</span>
                                                            @endif

                                                        </div>

                                                    </label>
                                                </a>
                                                <input type="hidden" name="base64_avatar" id="base64_avatar" value="">

                                                <span class="invalid-feedback">@error('avatar'){{ $message
                                                    }}@enderror</span>

                                                <h6>Allowed *.jpeg, *.jpg, *.png, *.gif <br>
                                                    Max size of 3.1 MB</h6>
                                            </div>
                                            <div class="form-check form-switch ps-0">
                                                <label class="form-check-label" for="recivingMessage">Receiving Messages</label>

                                                <input class="form-check-input" id="recivingMessage" type="checkbox"
                                                    name="recivingMessage" value="1" {{ old('recivingMessage',
                                                    $user->recivingMessage) == 1 ?
                                                'checked' : '' }}>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-8">
                                        <div class="content-settings-form-wrap profile-text-box-2 pt-0">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mt-0">
                                                        <input autocomplete="off" type="text" class="form-control" id="name" name="name"
                                                            value="{{ $user->name }}" required>
                                                        <label for="name">Name</label>
                                                        <span class="invalid-feedback">@error('name'){{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input autocomplete="off" type="text" class="form-control" id="email" name="email"
                                                            value="{{ $user->email }}" required>
                                                        <label for="email">Email</label>
                                                        <span class="invalid-feedback">@error('email'){{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input autocomplete="off" type="text" class="form-control" id="phone" name="phone"
                                                            value="{{ $user->phone }}" required>
                                                        <label for="phone">Phone Number</label>
                                                        <span class="invalid-feedback">@error('phone'){{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input autocomplete="off" type="text" class="form-control" id="company_name2"
                                                            name="company_name" value="{{ $user->company_name }}"
                                                            required>
                                                        <label for="company_name2">Company Name</label>
                                                        <span class="invalid-feedback">@error('company_name'){{ $message
                                                            }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input autocomplete="off" type="text" class="form-control" id="website"
                                                            name="website" value="{{ $user->short_bio }}" required>
                                                        <label for="website">Website</label>
                                                        <span class="invalid-feedback">@error('website'){{ $message }}
                                                            @enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    @php $socialLinks = explode(',',$user->social_links) @endphp
                                                    <div class="form-group">
                                                        <label for="social_links" class="social-label">Social
                                                            Media</label>
                                                    </div>
                                                    @foreach ($socialLinks as $key => $socialLink)
                                                    <div class="social-extra-field">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="url" class="form-control"
                                                                id="social_links_{{ $key }}" name="social_links[]"
                                                                value="{{ $socialLink }}">

                                                            <span class="invalid-feedback">@error('social_links'){{
                                                                $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="text-end mt-3">
                                                        <a href="javascript:void(0)" id="social_increment"><i
                                                                class="fas fa-plus"></i> Add</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea name="description" id="description"
                                                            class="form-control @error('description') is-invalid @enderror">{!! $user->description !!}</textarea>

                                                        <label for="description"
                                                            style="top: -1rem!important;">About</label>
                                                        <span class="invalid-feedback">@error('description'){{ $message
                                                            }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-submit-bttns mt-5">
                                            <button type="button" onclick="history.go(-1)"
                                                class="btn btn-cancel">Cancel</button>
                                            <button type="submit" class="btn btn-submit">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- profile edit form end --}}
                            </form>
                        </div>
                        {{-- profile tab end --}}

                        {{-- experience tab start --}}
                        <div class="tab-pane tab-con fade" id="pills-experience" role="tabpanel"
                            aria-labelledby="pills-experience-tab" tabindex="0">
                            <div class="row">

                                <div class="col-12">
                                    <div class="add-experience-form" id="experience-form">
                                        <form
                                            action="{{ route('instructor.profile.experience.store') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $editExp ? $editExp->id:''}}" />
                                            <div class="content-settings-form-wrap profile-text-box-2">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="text" class="form-control" id="profession"
                                                                value="{{ $editExp ? $editExp->profession: old('profession') }}"
                                                                placeholder="Add skill (e.g ui/ux design)"
                                                                name="profession">
                                                            <label for="profession">Profession</label>
                                                            <span class="invalid-feedback">@error('profession'){{
                                                                $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="text" class="form-control" id="company_name"
                                                                name="company_name"
                                                                value="{{ $editExp ? $editExp->company_name: old('company_name') }}"
                                                                placeholder="Add company (e.g learn cosy)">
                                                            <label for="company_name">Company Name</label>
                                                            <span class="invalid-feedback">@error('company_name'){{
                                                                $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="text" class="form-control" id="job_type"
                                                                value="{{ $editExp ? $editExp->job_type: old('job_type') }}"
                                                                name="job_type"
                                                                placeholder="Add job type (e.g full time/ part time)">
                                                            <label for="job_type">Job Type</label>
                                                            <span class="invalid-feedback">@error('job_type'){{ $message
                                                                }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="text" class="form-control" id="experience"
                                                                value="{{ $editExp ? $editExp->experience: old('experience') }}"
                                                                name="experience"
                                                                placeholder="Add service time (e.g 5 years)">
                                                            <label for="experience">Experience Time </label>
                                                            <span class="invalid-feedback">@error('experience'){{
                                                                $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" id="join_date"
                                                                value="{{ $editExp ? $editExp->join_date: old('join_date') }}"
                                                                name="join_date"
                                                                placeholder="Add join date (e.g 02 jan 2020)">
                                                            <label for="join_date">Join Date</label>
                                                            <span class="invalid-feedback">@error('join_date'){{
                                                                $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" id="retire_date"
                                                                value="{{ $editExp ? $editExp->retire_date: old('retire_date') }}"
                                                                name="retire_date"
                                                                placeholder="Add Retired date (e.g 02 jan 2022/ Present)">
                                                            <label for="retire_date">Retired Date</label>
                                                            <span class="invalid-feedback"
                                                                id="invalid_retire_date">@error('retire_date'){{
                                                                $message }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <textarea name="short_description" id="short_description"
                                                                placeholder="Add short description about this job..."
                                                                class="form-control @error('short_description') is-invalid @enderror">{{ $editExp ? $editExp->short_description: old('short_description') }}</textarea>
                                                            <label for="short_description">Short Description</label>
                                                            <span class="invalid-feedback">@error('description'){{
                                                                $message
                                                                }}
                                                                @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-submit-bttns mt-5">
                                                            <button type="button" onclick="history.go(-1)"
                                                                class="btn btn-cancel">Cancel</button>
                                                            <button type="submit" class="btn btn-submit"
                                                                id="submitFrm">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    @if (count($experiences) > 0)
                                    <div class="user-expperience-box user-expperience-box-2">
                                        @foreach ($experiences as $experience)
                                        <div class="media brdr-bttm">
                                            <img src="{{ asset('assets/images/experience-img.svg') }}"
                                                alt="experience-img" class="img-fluid">
                                            <div class="media-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h5>{!! $experience->profession !!}</h5>
                                                    <div>
                                                        <a
                                                            href="{{ route('instructor.profile.experience.edit', ['experienceId' => $experience->id ]) }}?tab=experience">
                                                            <img src=" {{ asset('assets/images/icons/pen.svg') }}"
                                                                alt="img" class="img-fluid">
                                                        </a>

                                                        <form method="POST" action="{{ route('instructor.profile.experience.delete', ['experienceId' => $experience->id]) }}" 
                                                              class="d-inline" onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn p-0 border-0 bg-transparent">
                                                                <img src=" {{ asset('assets/images/icons/minus.svg') }}" 
                                                                     alt="img" class="img-fluid">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <h6>{{ $experience->company_name }} <i class="fas fa-circle"></i> {{
                                                    $experience->job_type }} <i class="fas fa-circle"></i> {{
                                                    $experience->experience }}</h6>
                                                <p>{{ $experience->short_description }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    @include('partials/no-data')
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- experience tab end --}}

                        {{-- certificate tab start --}}
                        <div class="tab-pane tab-con fade" id="pills-certificate" role="tabpanel"
                            aria-labelledby="pills-certificate-tab" tabindex="0">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="certificate-header-tab">
                                        <ul class="nav nav-pills inner-tab" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-add_cert-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-add_cert" type="button"
                                                    role="tab" aria-controls="pills-add_cert" aria-selected="true"
                                                    data-params="add_cert"><i class="fas fa-plus"></i> Add
                                                    Certificate</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-custom_cert-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-custom_cert"
                                                    type="button" role="tab" aria-controls="pills-custom_cert"
                                                    aria-selected="false" data-params="custom_cert"><i
                                                        class="fas fa-plus"></i> Custom
                                                    Certificate</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cert-body-tab">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-add_cert" role="tabpanel"
                                                aria-labelledby="pills-add_cert-tab" tabindex="0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="create-certificate-form">
                                                            <form
                                                                action="{{ route('instructor.certificates.settings') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @if(isset($editCertificate))
                                                                    <input type="hidden" name="certificate_id" value="{{ $editCertificate->id }}">
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <div class="certificate-name">
                                                                            <h6>Course/ Certificate Name </h6>

                                                                            <div class="form-group form-error">
                                                                                <select name="course_id"
                                                                                    class="form-control  @error('course_id') is-invalid @enderror">
                                                                                    <option value="">Select Below
                                                                                    </option>
                                                                                    @foreach ($courses as $course)
                                                                                    <option value="{{ $course->id }}" {{ (isset($editCertificate) && $editCertificate->course_id == $course->id) ? 'selected' : '' }}>{{
                                                                                        $course->title }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span
                                                                                    class="invalid-feedback">@error('course_id'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>
                                                                            <div class="media">
                                                                                <img src="{{asset('assets/images/icons/color.svg')}}"
                                                                                    alt="Color" class="img-fluid">
                                                                                <div class="media-body">
                                                                                    <h5>Certificate Color</h5>
                                                                                    <p>This is the color of your menu
                                                                                        bar. Your logo should look good
                                                                                        on this.</p>
                                                                                </div>
                                                                                <div class="color-position">
                                                                                    <input type="color"
                                                                                        class="form-control p-0"
                                                                                        name="certificate_clr"
                                                                                        id="certificate_clr"
                                                                                        value="{{ isset($editCertificate) && $editCertificate->certificate_clr ? $editCertificate->certificate_clr : '#ffffff' }}">

                                                                                    <label for="certificate_clr">
                                                                                        <img src="{{ asset('assets/images/icons/pen-ic.svg') }}"
                                                                                            alt="Color"
                                                                                            class="img-fluid me-0">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media">
                                                                                <img src="{{asset('assets/images/icons/color-2.svg')}}"
                                                                                    alt="Color" class="img-fluid">
                                                                                <div class="media-body">
                                                                                    <h5>Accent Color</h5>
                                                                                    <p>The accent color is used to
                                                                                        accentuate visual elements.</p>
                                                                                </div>
                                                                                <div class="color-position">
                                                                                    <input type="color"
                                                                                        class="form-control p-0"
                                                                                        name="accent_clr"
                                                                                        id="accent_clr" value="{{ isset($editCertificate) && $editCertificate->accent_clr ? $editCertificate->accent_clr : '#ffffff' }}">

                                                                                    <label for="accent_clr">
                                                                                        <img src="{{ asset('assets/images/icons/pen-ic.svg') }}"
                                                                                            alt="Color"
                                                                                            class="img-fluid me-0">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="certificate-style-box">
                                                                            <h6>Select Certificate Style</h6>

                                                                            <div class="media">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{ asset('assets/images/big-c-01.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}

                                                                                <a href="#" class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-01.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div active"
                                                                                    data-value="1">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style One</h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{asset('assets/images/big-c-02.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}


                                                                                <a href="#" class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-02.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div"
                                                                                    data-value="2">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style Two</h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="media">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{asset('assets/images/big-c-03.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}

                                                                                <a href="#" class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-03.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div"
                                                                                    data-value="3">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style Three</h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden"
                                                                                name="certificate_style"
                                                                                id="certificateStyle" value="{{ isset($editCertificate) && $editCertificate->style ? $editCertificate->style : '1' }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="certificate-asset-upload">
                                                                            <h5>Logo </h5>
                                                                            <input type="file" name="logo"
                                                                                id="logoInput" accept="image/*"
                                                                                onchange="previewLogo()"
                                                                                class="form-control d-none @error('logo') is-invalid @enderror">

                                                                            <label for="logoInput"
                                                                                class="upload-media-box"
                                                                                id="file-upload-area1">
                                                                                <img src="{{ asset('assets/images/icons/upload-icon.svg')}}"
                                                                                    alt="Color"
                                                                                    class="img-fluid light-ele"
                                                                                    id="logoPreview">

                                                                                <img src="{{asset('assets/images/icons/upload-5.svg')}}"
                                                                                    alt="Color"
                                                                                    class="img-fluid dark-ele"
                                                                                    id="logoPreview">
                                                                                <span>Click to upload</span> or drag and
                                                                                drop SVG, PNG or JPG (max. 300x300px)
                                                                            </label>
                                                                        </div>
                                                                        <div class="certificate-asset-upload">
                                                                            <h5>Instructor Signature </h5>
                                                                            <input type="file" name="signature"
                                                                                id="signatureInput" accept="image/*"
                                                                                onchange="previewSignature()"
                                                                                class="form-control d-none @error('signature') is-invalid @enderror">

                                                                            <label for="signatureInput"
                                                                                class="upload-media-box"
                                                                                id="signature-upload-area">

                                                                                <img src="{{  asset('assets/images/icons/upload-icon.svg') }}"
                                                                                    alt="Color"
                                                                                    class="img-fluid light-ele"
                                                                                    id="signaturePreview">

                                                                                <img src="{{ asset('assets/images/icons/upload-5.svg') }}"
                                                                                    alt="Color"
                                                                                    class="img-fluid dark-ele"
                                                                                    id="signaturePreview">
                                                                                <span>Click to upload Instructor
                                                                                    Signature</span>
                                                                                <span>or drag and drop SVG, PNG or JPG
                                                                                    (max. 300x300px)</span>
                                                                            </label>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="text-end mt-4">
                                                                            <button type="submit"
                                                                                class="common-bttn border-0 btn-submit">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="user-expperience-box user-expperience-box-2">
                                                            <div class="title">
                                                                <h4>All Certificates</h4>
                                                            </div>
                                                            @if (count($certificates) > 0)
                                                            @foreach ($certificates as $certificate)
                                                            <div class="media brdr-bttm">
                                                                @if ($certificate->style == 1)
                                                                <img src="{{ asset('assets/images/certificate-01.png') }}"
                                                                    alt="experience-img" class="img-fluid rounded">
                                                                @elseif($certificate->style == 2)
                                                                <img src="{{ asset('assets/images/certificate-02.png') }}"
                                                                    alt="experience-img" class="img-fluid rounded">
                                                                @elseif($certificate->style == 3)
                                                                <img src="{{ asset('assets/images/certificate-03.png') }}"
                                                                    alt="experience-img" class="img-fluid rounded">
                                                                @endif
                                                                <div class="media-body">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <h5>{!! optional($certificate->course)->title !!}
                                                                        </h5>
                                                                        <div>
                                                                            <a href="{{ route('instructor.certificates.edit', $certificate->id) }}"><img
                                                                                    src="{{ asset('assets/images/icons/pen.svg') }}"
                                                                                    alt="img" class="img-fluid"></a>

                                                                            <form class="d-inline"
                                                                                action="{{route('instructor.certificates.delete', ['id' => $certificate->id])}}"
                                                                                method="post">
                                                                                @csrf

                                                                                <button type="submit"
                                                                                    class="btn p-0"><img
                                                                                        src="{{ asset('assets/images/icons/minus.svg') }}"
                                                                                        alt="img"
                                                                                        class="img-fluid"></button>
                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                                    <h6>
                                                                        @if ($certificate->style == 1)
                                                                        Certificate Style One
                                                                        @elseif($certificate->style == 2)
                                                                        Certificate Style Two
                                                                        @elseif($certificate->style == 3)
                                                                        Certificate Style Three
                                                                        @endif

                                                                        <i class="fas fa-circle"></i> {{
                                                                        $certificate->updated_at->format('d F Y') }}
                                                                    </h6>
                                                                    <p>{!!
                                                                        optional($certificate->course)->short_description
                                                                        !!} </p>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @else
                                                            @include('partials/no-data')
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade " id="pills-custom_cert" role="tabpanel"
                                                aria-labelledby="pills-custom_cert-tab" tabindex="0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="create-certificate-form create-certificate-form-2">
                                                            <form
                                                                action="{{ route('instructor.certificates.generate') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="certificate-name border-0 pe-0">
                                                                            <h6>Student Name </h6>
                                                                            <div class="form-group form-error">
                                                                                <input autocomplete="off" type="text" name="c_first_name"
                                                                                    class="form-control @error('c_first_name') is-invalid @enderror">
                                                                                <label for="">First Name</label>

                                                                                <span
                                                                                    class="invalid-feedback">@error('c_first_name'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="certificate-name border-0 pe-0">
                                                                            <h6>&nbsp;</h6>
                                                                            <div class="form-group form-error">
                                                                                <input autocomplete="off" type="text" name="c_last_name"
                                                                                    class="form-control @error('c_last_name') is-invalid @enderror">
                                                                                <label for="">Last Name</label>

                                                                                <span
                                                                                    class="invalid-feedback">@error('c_last_name'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 my-3">
                                                                        <div class="certificate-name border-0 pe-0">
                                                                            <h6>Certificate/ Course Name</h6>

                                                                            <div class="form-group form-error">
                                                                                <select name="c_course_id"
                                                                                    class="form-control">
                                                                                    @foreach ($courses as $course)
                                                                                    <option value="{{ $course->id }}">{{
                                                                                        $course->title }}</option>
                                                                                    @endforeach
                                                                                    <label for="">Professional UI/UX
                                                                                        Design
                                                                                        Course</label>
                                                                                </select>

                                                                                <span
                                                                                    class="invalid-feedback">@error('c_course_id'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="certificate-name border-0 pe-0">
                                                                            <h6>Course Complete Date </h6>

                                                                            <div class="form-group form-error">
                                                                                <input type="date"
                                                                                    name="c_completion_date"
                                                                                    class="form-control @error('c_completion_date') is-invalid @enderror">
                                                                                <label for="">Date</label>

                                                                                <span
                                                                                    class="invalid-feedback">@error('c_completion_date'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="certificate-name border-0 pe-0">
                                                                            <h6>Certificate Issue Date *</h6>
                                                                            <div class="form-group form-error">
                                                                                <input type="date" name="c_issue_date"
                                                                                    class="form-control @error('c_issue_date') is-invalid @enderror">
                                                                                <label for="">Date</label>

                                                                                <span
                                                                                    class="invalid-feedback">@error('c_issue_date'){{
                                                                                    $message }}
                                                                                    @enderror</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-9 mt-3">
                                                                        <div class="certificate-name">
                                                                            <div class="media">
                                                                                <img src="{{asset('assets/images/icons/color.svg')}}"
                                                                                    alt="Color" class="img-fluid">
                                                                                <div class="media-body">
                                                                                    <h5>Certificate Color</h5>
                                                                                    <p>This is the color of your menu
                                                                                        bar. Your logo should look good
                                                                                        on this.</p>
                                                                                </div>
                                                                                <div class="color-position">
                                                                                    <input type="color"
                                                                                        class="form-control p-0"
                                                                                        name="c_certificate_clr"
                                                                                        id="c_certificate_clr"
                                                                                        value="#ffffff">

                                                                                    <label for="c_certificate_clr">
                                                                                        <img src="{{ asset('assets/images/icons/pen-ic.svg') }}"
                                                                                            alt="Color"
                                                                                            class="img-fluid me-0">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media">
                                                                                <img src="{{asset('assets/images/icons/color-2.svg')}}"
                                                                                    alt="Color" class="img-fluid">
                                                                                <div class="media-body">
                                                                                    <h5>Accent Color</h5>
                                                                                    <p>The accent color is used to
                                                                                        accentuate visual elements.</p>
                                                                                </div>
                                                                                <div class="color-position">
                                                                                    <input type="color"
                                                                                        class="form-control p-0"
                                                                                        name="c_accent_clr"
                                                                                        id="c_accent_clr"
                                                                                        value="#ffffff">

                                                                                    <label for="c_accent_clr">
                                                                                        <img src="{{ asset('assets/images/icons/pen-ic.svg') }}"
                                                                                            alt="Color"
                                                                                            class="img-fluid me-0">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="certificate-style-box">
                                                                            <h6>Select Certificate Style</h6>

                                                                            <div class="media" id="certificate-1">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{asset('assets/images/big-c-01.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}

                                                                                <a class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-01.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div-2 active"
                                                                                    data-value="1">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style One </h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{asset('assets/images/big-c-02.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}

                                                                                <a class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-02.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div-2"
                                                                                    data-value="2">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style Two</h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media" id="certificate-3">
                                                                                {{-- full page preview --}}
                                                                                <div class="full-page-preview">
                                                                                    <a href="#" class="close-bttn">
                                                                                        <i class="fas fa-close"></i>
                                                                                    </a>
                                                                                    <img src="{{asset('assets/images/big-c-03.svg')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </div>
                                                                                {{-- full page preview --}}

                                                                                <a class="cert-bttn">
                                                                                    <img src="{{asset('assets/images/certificate-03.png')}}"
                                                                                        alt="Cert" class="img-fluid">
                                                                                </a>
                                                                                <div class="media-body select-style-div-2"
                                                                                    data-value="3">
                                                                                    <div class="d-flex">
                                                                                        <h6>Certificate Style Three</h6>
                                                                                        <span>Selected
                                                                                            Certificate</span>
                                                                                    </div>
                                                                                    <p>Raouls Choice is een simple en
                                                                                        elegant thema zonder extra
                                                                                        opties, mokkeljk te gebruken en
                                                                                        geoptimaliseerd voor conversie.
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <input type="hidden"
                                                                                name="c_certificate_style"
                                                                                id="cCertificateStyle" value="1">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3 mt-3">

                                                                        <div class="certificate-asset-upload">
                                                                            <h5>Logo </h5>
                                                                            <input type="file" name="c_logo"
                                                                                id="logoInput2" accept="image/*"
                                                                                onchange="previewLogo2()"
                                                                                class="form-control d-none @error('c_logo') is-invalid @enderror">

                                                                            <label for="logoInput2"
                                                                                class="upload-media-box"
                                                                                id="file-upload-area11">
                                                                                <img src="{{ asset('assets/images/icons/upload-icon.svg')}}"
                                                                                    alt="Color"
                                                                                    class="img-fluid light-ele"
                                                                                    id="logoPreview2">

                                                                                <img src="{{asset('assets/images/icons/upload-5.svg')}}"
                                                                                    alt="Color"
                                                                                    class="img-fluid dark-ele"
                                                                                    id="logoPreview2">
                                                                                <span>Click to upload</span> or drag and
                                                                                drop SVG, PNG or JPG (max. 300x300px)
                                                                            </label>
                                                                        </div>

                                                                        <div class="certificate-asset-upload">
                                                                            <h5>Instructor Signature </h5>
                                                                            <input type="file" name="c_signature"
                                                                                id="signatureInput2" accept="image/*"
                                                                                onchange="previewSignature2()"
                                                                                class="form-control d-none @error('c_signature') is-invalid @enderror">

                                                                            <label for="signatureInput2"
                                                                                class="upload-media-box"
                                                                                id="signature-upload-area2">

                                                                                <img src="{{  asset('assets/images/icons/upload-icon.svg') }}"
                                                                                    alt="Color"
                                                                                    class="img-fluid light-ele"
                                                                                    id="signaturePreview2">

                                                                                <img src="{{ asset('assets/images/icons/upload-5.svg') }}"
                                                                                    alt="Color"
                                                                                    class="img-fluid dark-ele"
                                                                                    id="signaturePreview2">
                                                                                <span>Click to upload Instructor
                                                                                    Signature</span> or drag and drop
                                                                                SVG, PNG or JPG (max. 300x300px)
                                                                            </label>

                                                                        </div>

                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="text-end mt-4">

                                                                            <button type="submit"
                                                                                class="btn btn-submit common-bttn border-0"><img
                                                                                    src="{{asset('assets/images/icons/download4.svg')}}"
                                                                                    alt="Color" class="img-fluid me-2">
                                                                                Download</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- certificate tab end --}}

                        {{-- connect app tab start --}}
                        <div class="tab-pane tab-con fade active-bg" id="pills-app" role="tabpanel"
                            aria-labelledby="pills-app-tab" tabindex="0">
                            {{-- app tab start --}}
                            <div class="row connect-app-box mt-4">
                                <div class="col-md-6">
                                    <div class="app-title">
                                        <h3>Connects to your account</h3>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="app-bttn">
                                        <a href="#"><img src="{{ asset('assets/images/icons/pluss.svg') }}"
                                                alt="a" class="img-fluid"> Add new account</a>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="app-box">
                                        {{-- app box --}}
                                        <div class="media">
                                            <img src="{{ asset('assets/images/vimeo.svg') }}" alt="a"
                                                class="img-fluid">
                                            <div class="media-body">
                                                <h5>Vimeo</h5>
                                                <p>Join the web's most supportive community of creators and get
                                                    high-quality tools for hosting, sharing, and streaming videos in
                                                    gorgeous HD with no ads.</p>
                                            </div>
                                            <a href="#"
                                                class="{{ isVimeoConnected(auth()->user()->id)[1] == 'Connected' ? 'connected' : 'disconnected' }}"
                                                data-bs-toggle="modal" data-bs-target="#connectModal">
                                                @if (isVimeoConnected(auth()->user()->id)[1] == 'Connected')
                                                Connected
                                                @else
                                                Connect
                                                @endif
                                            </a>
                                        </div>
                                        {{-- app box --}}

                                        {{-- app box --}}
                                        <div class="media">
                                            <img src="{{ asset('assets/images/stripe.svg') }}" alt="a"
                                                class="img-fluid">
                                            <div class="media-body">
                                                <h5>Stripe</h5>
                                                <p>Stripe is a suite of APIs powering online payment processing and
                                                    commerce solutions for internet businesses of all sizes. Accept
                                                    payments and scale faster.</p>
                                            </div>
                                            <a href="#"
                                                class="{{ isConnectedWithStripe()[1] == 'Connected' ? 'connected' : 'disconnected' }}"
                                                data-bs-toggle="modal" data-bs-target="#StripeconnectModal">
                                                @if (isConnectedWithStripe()[1] == 'Connected')
                                                Connected
                                                @else
                                                Connect
                                                @endif
                                            </a>
                                        </div>
                                        {{-- app box --}}

                                        {{-- bKash payment box --}}
                                        <div class="media">
                                            <img src="{{ asset('assets/images/bkash.svg') }}" alt="bKash"
                                                class="img-fluid" style="width: 50px;">
                                            <div class="media-body">
                                                <h5>বিকাশ (bKash)</h5>
                                                <p>বাংলাদেশের সবচেয়ে জনপ্রিয় মোবাইল ব্যাংকিং সেবা। শিক্ষার্থীরা বিকাশের মাধ্যমে সহজেই পেমেন্ট করতে পারবে।</p>
                                            </div>
                                            <a href="#"
                                                class="{{ Auth::user()->bkash_number ? 'connected' : 'disconnected' }}"
                                                data-bs-toggle="modal" data-bs-target="#BkashConnectModal">
                                                @if (Auth::user()->bkash_number)
                                                Connected
                                                @else
                                                Connect
                                                @endif
                                            </a>
                                        </div>
                                        {{-- bKash payment box --}}

                                        {{-- Nogod payment box --}}
                                        <div class="media">
                                            <img src="{{ asset('assets/images/nogod.svg') }}" alt="Nogod"
                                                class="img-fluid" style="width: 50px;">
                                            <div class="media-body">
                                                <h5>নগদ (Nogod)</h5>
                                                <p>বাংলাদেশের দ্রুততম ডিজিটাল ফিন্যান্সিয়াল সেবা। নগদের মাধ্যমে তাৎক্ষণিক পেমেন্ট গ্রহণ করুন।</p>
                                            </div>
                                            <a href="#"
                                                class="{{ Auth::user()->nogod_number ? 'connected' : 'disconnected' }}"
                                                data-bs-toggle="modal" data-bs-target="#NogodConnectModal">
                                                @if (Auth::user()->nogod_number)
                                                Connected
                                                @else
                                                Connect
                                                @endif
                                            </a>
                                        </div>
                                        {{-- Nogod payment box --}}

                                        {{-- Rocket payment box --}}
                                        <div class="media">
                                            <img src="{{ asset('assets/images/rocket.svg') }}" alt="Rocket"
                                                class="img-fluid" style="width: 50px;">
                                            <div class="media-body">
                                                <h5>রকেট (Rocket)</h5>
                                                <p>ডাচ্চ-বাংলা ব্যাংকের নির্ভরযোগ্য মোবাইল ব্যাংকিং সেবা। রকেটের মাধ্যমে নিরাপদ পেমেন্ট গ্রহণ করুন।</p>
                                            </div>
                                            <a href="#"
                                                class="{{ Auth::user()->rocket_number ? 'connected' : 'disconnected' }}"
                                                data-bs-toggle="modal" data-bs-target="#RocketConnectModal">
                                                @if (Auth::user()->rocket_number)
                                                Connected
                                                @else
                                                Connect
                                                @endif
                                            </a>
                                        </div>
                                        {{-- Rocket payment box --}}
                                    </div>
                                </div>
                            </div>
                            {{-- password tab end --}}
                        </div>
                        {{-- connect app tab start --}}

                        {{-- password tab start --}}
                        <div class="tab-pane tab-con fade active-bg" id="pills-password" role="tabpanel"
                            aria-labelledby="pills-password-tab" tabindex="0">
                            {{-- password tab start --}}
                            <div class="row user-add-form-wrap user-add-form-wrap-2 mt-0">
                                <div class="col-12">
                                    <form
                                        action="{{ route('instructor.profile.password.update') }}"
                                        method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input autocomplete="off" type="text" placeholder="Email" class="form-control"
                                                        value="{{ $user->email}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">New Password<sup class="text-danger">*</sup></label>
                                                    <input autocomplete="off"  type="password" name="password" placeholder="Enter Password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password">
                                                    <span class="invalid-feedback">@error('password'){{ $message }}
                                                        @enderror</span>
                                                    <i class="fa-regular fa-eye" onclick="changeType()"
                                                        id="eye-click"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Confirm New Password<sup
                                                            class="text-danger">*</sup></label>
                                                    <input autocomplete="off"  type="password" name="password_confirmation"
                                                        placeholder="Enter Password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        id="password_confirmation">
                                                    <span class="invalid-feedback">@error('password_confirmation'){{
                                                        $message }}
                                                        @enderror</span>
                                                    <i class="fa-regular fa-eye" onclick="changeType2()"
                                                        id="eye-click2"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-submit-bttns">
                                                    <button type="button" onclick="history.go(-1)"
                                                        class="btn btn-cancel">Cancel</button>
                                                    <button type="submit" class="btn btn-submit">Save Changes</button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- password tab end --}}
                        </div>
                        {{-- password tab start --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- student update page @e --}}

{{-- stripe viemo app modal --}}
<div class="app-modals">
    <div class="connect-modal-box">
        <div class="modal fade" id="connectModal" tabindex="-1" role="dialog" aria-labelledby="connectModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header">
                        <h5 id="connectModalLabel">Connect Vimeo</h5>
                        <button class="btn" type="button" data-bs-dismiss="modal"><i class="fas fa-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="connect-modal-wrap">
                            <form action="{{ route('instructor.settings.vimeo') }}"
                                method="POST">
                                @csrf
                                <div class="stripe-settings-form-wrap">
                                    <div class="form-group">
                                        <label for="client_id">CLIENT ID
                                        </label>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Enter Client ID"
                                            name="client_id"
                                            value="{{ isVimeoConnected(auth()->user()->id)[0]->client_id ?? '' }}">
                                        <span class="text-danger">@error('client_id') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="client_secret">CLIENT SECRET</label>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Enter Client Secret"
                                            name="client_secret"
                                            value="{{ isVimeoConnected(auth()->user()->id)[0]->client_secret ?? '' }}">
                                        <span class="text-danger">@error('client_secret') {{ $message }}
                                            @enderror</span>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="access_key">CLIENT ACCESS KEY</label>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="Enter Access Key"
                                            name="access_key"
                                            value="{{ isVimeoConnected(auth()->user()->id)[0]->access_key ?? '' }}">
                                        <span class="text-danger">@error('access_key') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="form-submit  mt-3">
                                        <button class="btn btn-submit" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="connect-modal-box">
        <div class="modal fade" id="StripeconnectModal" tabindex="-1" role="dialog" aria-labelledby="StripeconnectModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="connectModalLabel">Connect Stripe</h5>
                        <button class="btn" type="button" data-bs-dismiss="modal"><i class="fas fa-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="connect-modal-wrap">
                            <form action=""
                                method="post">
                                @csrf
                                <div class="stripe-settings-form-wrap">
                                    <div class="form-group mb-3">
                                        <label for="stripe_public_key">STRIPE KEY

                                        </label>
                                        <input autocomplete="off" type="text" class="form-control" name="stripe_public_key"
                                            placeholder="Enter Secret Key"
                                            value="{{ Auth::user()->stripe_public_key }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="stripe_secret_key">STRIPE SECRET KEY</label>
                                        <input autocomplete="off" type="text" class="form-control" name="stripe_secret_key"
                                            placeholder="Enter Secret Key"
                                            value="{{ Auth::user()->stripe_secret_key }}">
                                    </div>
                                    <div class="form-submit">
                                        <div class="go-to-stripe">
                                            <a href="https://stripe.com" target="_blank"><i
                                                    class="fa-brands fa-cc-stripe me-2"></i>Go to stripe account <i
                                                    class="fas fa-arrow-right"></i></a>
                                        </div>
                                        <div class="submit-form mt-3">
                                            <button class="btn btn-submit" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- bKash Connect Modal --}}
    <div class="modal fade" id="BkashConnectModal" tabindex="-1" role="dialog" aria-labelledby="BkashConnectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content custom-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connectModalLabel">Connect বিকাশ (bKash)</h5>
                    <button class="btn" type="button" data-bs-dismiss="modal"><i class="fas fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="connect-modal-wrap">
                        <form action="{{ route('instructor.profile.payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="payment_type" value="bkash">
                            <div class="stripe-settings-form-wrap">
                                <div class="form-group mb-3">
                                    <label for="bkash_number">বিকাশ নম্বর</label>
                                    <input autocomplete="off" type="text" class="form-control" name="bkash_number"
                                        placeholder="০১xxxxxxxxx" value="{{ Auth::user()->bkash_number }}">
                                </div>
                                <div class="go-to-stripe">
                                    <p class="text-muted">আপনার বিকাশ একাউন্টের নম্বর দিন যেটিতে শিক্ষার্থীরা পেমেন্ট পাঠাবে।</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="modal-btn" type="submit">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Nogod Connect Modal --}}
    <div class="modal fade" id="NogodConnectModal" tabindex="-1" role="dialog" aria-labelledby="NogodConnectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content custom-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connectModalLabel">Connect নগদ (Nogod)</h5>
                    <button class="btn" type="button" data-bs-dismiss="modal"><i class="fas fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="connect-modal-wrap">
                        <form action="{{ route('instructor.profile.payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="payment_type" value="nogod">
                            <div class="stripe-settings-form-wrap">
                                <div class="form-group mb-3">
                                    <label for="nogod_number">নগদ নম্বর</label>
                                    <input autocomplete="off" type="text" class="form-control" name="nogod_number"
                                        placeholder="০১xxxxxxxxx" value="{{ Auth::user()->nogod_number }}">
                                </div>
                                <div class="go-to-stripe">
                                    <p class="text-muted">আপনার নগদ একাউন্টের নম্বর দিন যেটিতে শিক্ষার্থীরা পেমেন্ট পাঠাবে।</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="modal-btn" type="submit">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rocket Connect Modal --}}
    <div class="modal fade" id="RocketConnectModal" tabindex="-1" role="dialog" aria-labelledby="RocketConnectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content custom-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connectModalLabel">Connect রকেট (Rocket)</h5>
                    <button class="btn" type="button" data-bs-dismiss="modal"><i class="fas fa-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="connect-modal-wrap">
                        <form action="{{ route('instructor.profile.payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="payment_type" value="rocket">
                            <div class="stripe-settings-form-wrap">
                                <div class="form-group mb-3">
                                    <label for="rocket_number">রকেট নম্বর</label>
                                    <input autocomplete="off" type="text" class="form-control" name="rocket_number"
                                        placeholder="০১xxxxxxxxx" value="{{ Auth::user()->rocket_number }}">
                                </div>
                                <div class="go-to-stripe">
                                    <p class="text-muted">আপনার রকেট একাউন্টের নম্বর দিন যেটিতে শিক্ষার্থীরা পেমেন্ট পাঠাবে।</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="modal-btn" type="submit">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- stripe viemo app modal --}}

{{-- image crop modal start --}}
@include('modals/image-resize')
{{-- image crop modal end --}}

@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="{{ asset('assets/js/crop-image.js') }}"></script>
<script src="{{ asset('assets/js/password-toggle.js') }}"></script>

{{-- form change js --}}
<script src="{{ asset('assets/js/form-change.js') }}"></script>

{{-- add extra filed js --}}
<script>
    const urlBttn = document.querySelector('#social_increment');
    let extraFields = document.querySelector('.social-extra-field');

    const createField = () => {
        let div = document.createElement("div");
        let node = document.createElement("input");
        node.setAttribute("class",
            "form-control @error('social_links') is-invalid @enderror"
            );
        node.setAttribute("multiple", "");
        node.setAttribute("type", "url");
        node.setAttribute("placeholder", "Enter URL");
        node.setAttribute("name", "social_links[]");

        let link = document.createElement("a");
        link.innerHTML = "<i class='fas fa-minus'></i>";
        link.addEventListener("click", () => removeField(div));

        div.appendChild(node);
        div.appendChild(link);

        extraFields.appendChild(div);
    }

    const removeField = (element) => {
        extraFields.removeChild(element);
    }

    urlBttn.addEventListener('click', createField, true);

    // Show the minus icon for the existing input fields in the loop
    const existingInputs = document.querySelectorAll('.social-extra-field input');
    for (const input of existingInputs) {
        let div = document.createElement("div");
        div.appendChild(input);

        let link = document.createElement("a");
        link.innerHTML = "<i class='fas fa-minus'></i>";
        link.addEventListener("click", () => removeField(div));

        div.appendChild(link);

        extraFields.appendChild(div);
    }
</script>

{{-- upload image preview --}}
<script>
    function previewImage() {
        var preview = document.getElementById('preview');
        var fileInput = document.getElementById('imageInput');
        var file = fileInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

</script>

{{-- logo certificate preview --}}
<script>
    function previewLogo() {
        var logoPreview = document.getElementById('logoPreview');
        var logoInput = document.getElementById('logoInput');
        var file = logoInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            logoPreview.style.display = 'none';
        }
    }
</script>

<script>
    function previewSignature() {
        var signaturePreview = document.getElementById('signaturePreview');
        var signatureInput = document.getElementById('signatureInput');
        var file = signatureInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                signaturePreview.src = e.target.result;
                signaturePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            signaturePreview.style.display = 'none';
        }
    }
</script>

<script>
    function previewLogo2() {
        var logoPreview = document.getElementById('logoPreview2');
        var logoInput = document.getElementById('logoInput2');
        var file = logoInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            logoPreview.style.display = 'none';
        }
    }
</script>

<script>
    function previewSignature2() {
        var signaturePreview = document.getElementById('signaturePreview2');
        var signatureInput = document.getElementById('signatureInput2');
        var file = signatureInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                signaturePreview.src = e.target.result;
                signaturePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            signaturePreview.style.display = 'none';
        }
    }
</script>

{{-- certificate logo preview end --}}

{{-- experience form --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('experience-form');

        form.addEventListener('submit', function (event) {
            var joinDate = new Date(document.getElementById('join_date').value);
            var retireDate = new Date(document.getElementById('retire_date').value);

            if (retireDate <= joinDate) {
                event.preventDefault();
                document.getElementById('invalid_retire_date').innerHTML ="Retire date must be after or equal to join date.";
            }
        });
    });
</script>

{{-- certificate preview --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".cert-bttn");
    const closeButtons = document.querySelectorAll(".close-bttn");
    const mainBody = document.querySelector(".full-page-preview");

    buttons.forEach(function(button) {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const certBox = this.parentElement.querySelector(".full-page-preview");

            if (certBox) {
                certBox.classList.toggle('show');
            }
        });
    });

    closeButtons.forEach(function(bttn) {
        bttn.addEventListener("click", function(e) {
            e.preventDefault();
            const certBox = this.parentElement;

            if (certBox) {
                certBox.classList.remove('show');
            }
        });
    });

});
</script>

<script>
    const clickDivs = document.querySelectorAll(".select-style-div");
    const certificateStyle = document.querySelector("#certificateStyle");

    clickDivs.forEach(function(div) {
        div.addEventListener("click", function(e) {
            e.preventDefault();
            certificateStyle.value = div.getAttribute('data-value');

            clickDivs.forEach(c => c.classList.remove("active"));
            this.classList.add("active")

        });
    });

</script>

<script>
    const clickDivs2 = document.querySelectorAll(".select-style-div-2");
    const cCertificateStyle = document.querySelector("#cCertificateStyle");

    clickDivs2.forEach(function(div2) {
        div2.addEventListener("click", function(e) {
            e.preventDefault();
            cCertificateStyle.value = div2.getAttribute('data-value');

            clickDivs2.forEach(c => c.classList.remove("active"));
            this.classList.add("active")

        });
    });

</script>

{{-- tab open js --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tabToOpen = urlParams.get('tab');
        const tabPanes = document.querySelectorAll('.tab-con');
        const tabLinks = document.querySelectorAll('.tab-link');

        const homesTabLink = document.getElementById('pills-home-tab');
        const homesTabContent = document.getElementById('pills-home');

        const experienceTabLink = document.getElementById('pills-experience-tab');
        const experienceTabContent = document.getElementById('pills-experience');

        const certificateTabLink = document.getElementById('pills-certificate-tab');
        const certificateTabContent = document.getElementById('pills-certificate');

        const appTabLink = document.getElementById('pills-app-tab');
        const appTabContent = document.getElementById('pills-app');

        const passwordTabLink = document.getElementById('pills-password-tab');
        const passwordTabContent = document.getElementById('pills-password');

        // Open the tab if the 'tab' parameter is specified
        if (tabToOpen == 'experience') {
            tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
            tabLinks.forEach(tab => tab.classList.remove('active'));
            experienceTabLink.classList.add('active');
            experienceTabContent.classList.add('show', 'active');
        }
        else if (tabToOpen == 'certificate' || tabToOpen == 'add_cert' || tabToOpen == 'custom_cert') {
            tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
            tabLinks.forEach(tab => tab.classList.remove('active'));
            certificateTabLink.classList.add('active');
            certificateTabContent.classList.add('show', 'active');

            if (tabToOpen == 'add_cert') {
                document.getElementById('pills-add_cert-tab').classList.add('active');
                document.getElementById('pills-add_cert').classList.add('show', 'active');

                document.getElementById('pills-custom_cert-tab').classList.remove('active');
                document.getElementById('pills-custom_cert').classList.remove('show', 'active');

            }else if(tabToOpen == 'custom_cert'){
                document.getElementById('pills-add_cert-tab').classList.remove('active');
                document.getElementById('pills-add_cert').classList.remove('show', 'active');

                document.getElementById('pills-custom_cert-tab').classList.add('active');
                document.getElementById('pills-custom_cert').classList.add('show', 'active');
            }

        }
        else if (tabToOpen == 'app') {
            tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
            tabLinks.forEach(tab => tab.classList.remove('active'));
            appTabLink.classList.add('active');
            appTabContent.classList.add('show', 'active');
        }
        else if (tabToOpen == 'password') {
            tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
            tabLinks.forEach(tab => tab.classList.remove('active'));
            passwordTabLink.classList.add('active');
            passwordTabContent.classList.add('show', 'active');
        }
        else if (tabToOpen == 'profile') {
            tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
            tabLinks.forEach(tab => tab.classList.remove('active'));

            homesTabLink.classList.add('active');
            homesTabContent.classList.add('show', 'active');
        }

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
          var tabLinks = document.querySelectorAll('.main-navigator .nav-link');
          var currentParam = '';

          tabLinks.forEach(function(tabLink) {
            tabLink.addEventListener('click', function(event) {
              event.preventDefault();
              var param = tabLink.getAttribute('data-param');
              if (param !== currentParam) {
                var currentURL = window.location.href;
                var newURL = currentURL.replace(/(\?|&)tab=[^&]*/, '') + (currentURL.includes('?') ? '?' : '?') + 'tab=' + param;
                window.history.pushState(null, '', newURL);
                currentParam = param;
              }
            });
          });
        });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
          var tabLinks = document.querySelectorAll('.inner-tab .nav-link');
          var currentParam = '';

          tabLinks.forEach(function(tabLink) {
            tabLink.addEventListener('click', function(event) {
              event.preventDefault();
              var param = tabLink.getAttribute('data-params');
              if (param !== currentParam) {
                var currentURL = window.location.href;
                var newURL = currentURL.replace(/(\?|&)tab=[^&]*/, '') + (currentURL.includes('?') ? '?' : '?') + 'tab=' + param;
                window.history.pushState(null, '', newURL);
                currentParam = param;
              }
            });
          });
        });
</script>
@endsection

{{-- page script @E --}}
