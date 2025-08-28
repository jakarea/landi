@extends('layouts.latest.admin')
@section('title') Update Password @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content') 
<main class="profile-update-page">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-12 col-md-7">
        <div class="user-header">
          <h2>Update Password</h2>
        </div>
      </div>
      <div class="col-12 col-md-5">
        <div class="user-header-bttn">
          <a href="{{url('admin/profile/myprofile')}}"> <i class="fas fa-angle-left me-2"></i> Back </a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="user-add-form-wrap">
          {{-- user update form @s --}}
          <form action="{{ route('admin.password.update',$user->id) }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">Your Email</label>
              <input autocomplete="off" type="text" placeholder="Email" class="form-control" value="{{ $user->email}}" disabled>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">New Password <sup class="text-danger">*</sup></label>
                  <input autocomplete="off"  type="password" name="password" placeholder="Enter Password"
                    class="form-control @error('password') is-invalid @enderror" id="password">
                  <span class="invalid-feedback">@error('password'){{ $message }} @enderror</span>
                  <i class="fa-regular fa-eye" onclick="changeType()" id="eye-click"></i>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">Confirm New Password <sup class="text-danger">*</sup></label>
                  <input autocomplete="off"  type="password" name="password_confirmation" placeholder="Enter Password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation">
                  <span class="invalid-feedback">@error('password_confirmation'){{ $message }} @enderror</span>
                  <i class="fa-regular fa-eye" onclick="changeType2()" id="eye-click2"></i>
                </div>
              </div>
            </div>

            <div class="form-submit-bttns">
              <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
              <button type="submit" class="btn btn-submit">Update</button>
            </div>
          </form>
          {{-- user update form @e --}}
        </div>
      </div>
    </div>
  </div>
</main>

<!-- === Instructor update page @E === -->
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
{{-- form save js --}}
<script src="{{ asset('assets/js/form-change.js') }}"></script>

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
</script>
@endsection
{{-- page script @E --}}