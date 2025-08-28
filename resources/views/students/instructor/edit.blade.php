@extends('layouts.latest.instructor')
@section('title') Student Profile Edit @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<!-- === user update page @S === -->
<main class="profile-update-page">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <div class="user-header">
                    <h2>Update {{ $student->name }} Profile</h2>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="user-header-bttn">
                    <a href="{{url('instructor/students')}}"><img src="{{asset('assets/images/icons/user.svg')}}"
                            alt="user" class="img-fluid"> All Students </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="user-add-form-wrap">
                    {{-- user update form @s --}}
                    <form action="{{route('updateStudentProfile',['id' => $student->id, config('app.subdomain') ])}}" method="POST" class="profile-form create-form-box" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group form-error">
                                    <label for="name">Name <sup class="text-danger">*</sup>
                                    </label>
                                        <input autocomplete="off" type="text" placeholder="Enter your Name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $student->name }}" id="name">

                                    <span class="invalid-feedback">@error('name'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-error">
                                    <label for="phone">Phone <sup class="text-danger">*</sup>
                                    </label>
                                        <input autocomplete="off" type="text" placeholder="Enter Phone Number" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ $student->phone }}" id="phone">

                                    <span class="invalid-feedback">@error('phone'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-error">
                                    <label for="email">Email <sup class="text-danger">*</sup>
                                    </label>
                                        <input autocomplete="off"  type="email" placeholder="Enter email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $student->email }}" id="email">

                                    <span class="invalid-feedback">@error('email'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="custom-hr">
                                    <hr>
                                    <h5>Other Information </h5>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-error">
                                    <label for="company_name">Company Name
                                    </label>
                                        <input autocomplete="off" type="text" name="company_name" id="company_name"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            placeholder="Enter company name" value="{{ $student->company_name }}">

                                    <span class="invalid-feedback">@error('company_name'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-error">
                                    <label for="website">Website
                                    </label>
                                        <input autocomplete="off" type="url" name="website" id="website"
                                            class="form-control @error('website') is-invalid @enderror"
                                            placeholder="Enter web address" value="{{ $student->short_bio }}">

                                    <span class="invalid-feedback">@error('website'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="features" class="mb-1">Social Media </label>
                                    @php $socialLinks = explode(",",$student->social_links); @endphp

                                    <div class="url-extra-field">
                                        @foreach ($socialLinks as $social)
                                        <div>
                                            <input class="form-control" multiple="" type="url" placeholder="Enter Social Link" name="social_links[]" value="{{ $social }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <span class="invalid-feedback">@error('social_links'){{ $message }}
                                        @enderror</span>
                                    <a href="javascript:void(0)" id="url_increment" style="top: 0;"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="mb-2">About </label>
                                        <textarea name="description" id="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Type here..">{{ $student->description }}</textarea>

                                    <span class="invalid-feedback">@error('description'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 userEditeBtn position-relative">
                                <div class="form-group mb-0">
                                    <label for="avatar">Avatar</label>
                                </div>
                                <a href="javascript:;" id="image-container" class="drop-container">
                                    <input type="file" name="avatar" value="" accept="image/*" id="avatar" class="item-img file center-block filepreviewprofile ">
                                    <label for="avatar" class="upload-box">
                                        <span>
                                            <img src="{{ asset('assets/images/icons/camera-plus.svg') }}" alt="Upload" class="img-fluid">
                                            <p>Upload photo</p>
                                        </span>
                                    </label>
                                    <span class="invalid-feedback">@error('avatar'){{ $message }}@enderror</span>
                                </a>
                                <input type="hidden" name="base64_avatar" id="base64_avatar" value="">
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="form-group mb-2">
                                    <label for="avatar">Uploaded Image</label>
                                </div>
                                <div id="imageContainer" class="drop-container"> 
                                    @if ($student->avatar)
                                    <img src="{{asset($student->avatar)}}" alt="No Image" class="img-fluid d-block imgpreviewPrf "
                                        id="item-img-output">
                                    @else
                                    <img src="https://image.flaticon.com/icons/svg/145/145867.svg" id="item-img-output"
                                        class="imgpreviewPrf img-fluid" alt="">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="recivingMessage">Receiving Messages: </label>
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recivingMessage"
                                                    id="enblee" value="1" {{ $student->recivingMessage == 1
                                                ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enblee">
                                                    Enable
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recivingMessage"
                                                    id="disblee" value="0" {{ $student->recivingMessage == 0
                                                ? 'checked' : '' }}>
                                                <label class="form-check-label" for="disblee">
                                                    Disable
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback">@error('recivingMessage'){{ $message }}
                                        @enderror</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="recivingMessage">Status: </label>
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="enale" value="active" {{ $student->status == 'active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enale">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="dale" value="inactive" {{ $student->status == 'inactive' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="dale">
                                                    Inactive
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback">@error('recivingMessage'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-error">
                                    <label for="password">Password </label>
                                    <input autocomplete="off"  type="password" name="password" placeholder="Enter Password"
                                        class="form-control @error('password') is-invalid @enderror" id="password">
                                    <span class="invalid-feedback">@error('password'){{ $message }} @enderror</span>
                                    <div class="pass-icon">
                                        <i class="fa-regular fa-eye" onclick="changeType()" id="eye-click"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-submit-bttns">
                                    <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                    <button type="submit" class="btn btn-submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- user update form @e --}}
                </div>
            </div>
        </div>
    </div>
</main>

{{-- image crop modal start --}}
@include('modals/image-resize')
{{-- image crop modal end --}}
<!-- === user update page @E === -->

@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="{{ asset('assets/js/crop-image.js') }}"></script>

{{-- form save js --}}
<script src="{{ asset('assets/js/form-change.js') }}"></script>
<script src="{{ asset('assets/js/password-toggle.js') }}"></script>

 
<script>
    const urlBttn = document.querySelector('#url_increment');
    let extraFields = document.querySelector('.url-extra-field');

    // A function to create a new input field
    const createField = () => {
    let div = document.createElement("div");
    let node = document.createElement("input");
    node.setAttribute("class", "form-control w-100 @error('social_links') is-invalid @enderror");
    node.setAttribute("multiple", "");
    node.setAttribute("type", "url");
    node.setAttribute("placeholder", "Enter Social Link");
    node.setAttribute("name", "social_links[]");

    let link = document.createElement("a");
    link.innerHTML = "<i class='fas fa-minus'></i>";
    link.setAttribute("onclick", "removeField(this)");
    div.appendChild(node);
    div.appendChild(link);

    extraFields.appendChild(div);
    }

    // A function to remove a field
    const removeField = (element) => {
    let fieldDiv = element.parentElement;
    fieldDiv.remove();
    }

    // Add an event listener to create a new field
    urlBttn.addEventListener('click', createField, true);

    // Show the minus icon for the existing input fields in the loop
    const existingInputs = document.querySelectorAll('.url-extra-field input');
    for (const input of existingInputs) {
    let link = document.createElement("a");
    link.innerHTML = "<i class='fas fa-minus'></i>";
    link.setAttribute("onclick", "removeField(this)");

    let div = document.createElement("div");
    div.appendChild(input);
    div.appendChild(link);

    extraFields.appendChild(div);
    }
</script>

@endsection
{{-- page script @E --}}
