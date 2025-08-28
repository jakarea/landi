@extends('layouts.latest.students')
@section('title') My Profile Settings @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- student update page @S --}}
<main class="student-profile-update-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="own-profile-box">
                    <div class="header">
                        <ul class="nav nav-pills main-navigator" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active tab-link" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true" data-param="home">My Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false" data-param="profile">Password</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active tab-link" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            {{-- profile edit form start --}}
                            <form action="{{ route('students.profile.update',['subdomain' => config('app.subdomain')] ) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row custom-padding">
                                    <div class="col-xl-3 col-lg-4">
                                        <div class="profile-picture-box ">

                                            <div class="userEditeBtn position-relative">
                                                <a href="javascript:;" id="image-container" class="drop-container">
                                                    <input type="file" name="avatar" value="" accept="image/*" id="avatar" class="item-img file center-block filepreviewprofile "> 
    
                                                    <label for="avatar" class="img-upload">
                                                        <img src="{{asset('assets/images/icons/camera-plus-w.svg')}}" alt="Upload" class="img-fluid">
                                                        <p>Update photo</p>
                                                        <div class="ol">
                                                            @if ($user->avatar)
                                                            <img src="{{asset($user->avatar)}}" alt="Avatar" id="item-img-output" class="imgpreviewPrf img-fluid">
                                                            @else
                                                            <img src="" alt="" id="item-img-output" class="imgpreviewPrf img-fluid position-absolute" style="left: 0; z-index: 9;">
                                                            <span class="avatar-box position-absolute" style="color: #3D5CFF;left: 0;">{!!
                                                                strtoupper($user->name[0]) !!}</span>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </a>
                                                <input type="hidden" name="base64_avatar" id="base64_avatar" value="">
    
                                                 <span class="invalid-feedback">@error('avatar'){{ $message }}@enderror</span>
    
                                                <h6>Allowed *.jpeg, *.jpg, *.png, *.gif <br>
                                                    Max size of 3.1 MB</h6>
                                            </div>

                                            <div class="form-check form-switch ps-0">
                                                <label class="form-check-label" for="recivingMessage">Receiving
                                                    Messages</label>

                                                <input class="form-check-input" id="recivingMessage" type="checkbox" name="recivingMessage"
                                                    value="1" {{ old('recivingMessage', $user->recivingMessage) == 1 ?
                                                'checked' : '' }}>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-lg-8">
                                        <div class="content-settings-form-wrap profile-text-box-2 mt-0" style="box-shadow: none">
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
                                                        <input autocomplete="off" type="text" class="form-control" id="company_name"
                                                            name="company_name" value="{{ $user->company_name }}" required>
                                                        <label for="company_name">Company Name</label>
                                                        <span class="invalid-feedback">@error('company_name'){{ $message }}
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
                                                    @php  $socialLinks = explode(',',$user->social_links) @endphp
                                                   <div class="form-group">
                                                    <label for="social_links" class="social-label">Social Media</label>
                                                   </div>
                                                    @foreach ($socialLinks as $socialLink)
                                                    <div class="social-extra-field">
                                                        <div class="form-group">
                                                            <input autocomplete="off" type="url" class="form-control" id="social_links"
                                                                name="social_links[]" value="{{ $socialLink }}" >

                                                            <span class="invalid-feedback">@error('social_links'){{ $message }}  @enderror</span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="text-end mt-3">
                                                        <a href="javascript:void(0)" id="social_increment"><i class="fas fa-plus"></i>
                                                            Add</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea name="description" id="description"
                                                            class="form-control @error('description') is-invalid @enderror"
                                                            required>{!! $user->description !!}</textarea>

                                                        <label for="description" style="top: -1rem!important;">About</label>
                                                        <span class="invalid-feedback">@error('description'){{ $message }} @enderror</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-submit-bttns mt-5">
                                            <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                            <button type="submit" class="btn btn-submit">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- profile edit form end --}}
                            </form>
                        </div>
                        <div class="tab-pane fade tab-link" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            {{-- password tab start --}}
                            <div class="row  user-add-form-wrap user-add-form-wrap-2">
                                <div class="col-12">
                                    <form action="{{ route('students.password.update',['subdomain' => config('app.subdomain')]) }}" method="POST">
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
                                                    <i class="fa-regular fa-eye" onclick="changeType()" id="eye-click"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Confirm New Password<sup class="text-danger">*</sup></label>
                                                    <input autocomplete="off"  type="password" name="password_confirmation" placeholder="Enter Password"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        id="password_confirmation">
                                                    <span class="invalid-feedback">@error('password_confirmation'){{ $message }}
                                                        @enderror</span>
                                                    <i class="fa-regular fa-eye" onclick="changeType2()" id="eye-click2"></i>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-submit-bttns text-start">
                                                    <button type="submit" class="btn btn-submit me-3 ms-0">Save Changes</button>
                                                    <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- password tab end --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- image crop modal start --}}
@include('modals/image-resize')
{{-- image crop modal end --}}

{{-- student update page @e --}}
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="{{ asset('assets/js/crop-image.js') }}"></script>

{{-- form save js --}}
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

{{-- password toggle view js --}}
<script>

  function changeType() {
    let field = document.getElementById("password");
    let clickk = document.getElementById("eye-click");

    if (field.type === "password") {
      field.type = "text";
      clickk.classList.add('fa-eye-slash');
      clickk.classList.remove('fa-eye');
    } else {
      field.type = "password";
      clickk.classList.remove('fa-eye-slash');
      clickk.classList.add('fa-eye');
    }

  }

  function changeType2() {
    let field = document.getElementById("password_confirmation");
    let clickk = document.getElementById("eye-click2");

    if (field.type === "password") {
      field.type = "text";
      clickk.classList.add('fa-eye-slash');
      clickk.classList.remove('fa-eye');
    } else {
      field.type = "password";
      clickk.classList.remove('fa-eye-slash');
      clickk.classList.add('fa-eye');
    }

  }

  document.addEventListener("DOMContentLoaded", function() {
    const avatarInput = document.getElementById("avatar");
    const avatarPreview = document.querySelector(".avatar-preview");

    avatarInput.addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    });
});
</script>

{{-- tab open js --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabToOpen = urlParams.get('tab');
            const tabPanes = document.querySelectorAll('.tab-con');
            const tabLinks = document.querySelectorAll('.tab-link');

            const homeTabLink = document.getElementById('pills-home-tab');
            const homeTabContent = document.getElementById('pills-home');

            const profileTabLink = document.getElementById('pills-profile-tab');
            const profileTabContent = document.getElementById('pills-profile');

            if (tabToOpen == 'profile') {
                tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
                tabLinks.forEach(tab => tab.classList.remove('active'));

                profileTabLink.classList.add('active');
                profileTabContent.classList.add('show', 'active');

            } else if(tabToOpen == 'home') {
               tabPanes.forEach(tab => tab.classList.remove('show', 'active'));
                tabLinks.forEach(tab => tab.classList.remove('active'));

                homeTabLink.classList.add('active');
                homeTabContent.classList.add('show', 'active');
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
@endsection
{{-- page script @E --}}
