@extends('layouts.latest.instructor')
@section('title', 'Manage Access Page')
{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<main class="dashboard-page-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-10 col-xl-9">
                <form action="{{ route('instructor.manage.pages', config('app.subdomain') ) }}" method="POST" id="access-form">
                    @csrf
                    <div class="access-page-box">
                        <div class="title">
                            <h1>Access Pages</h1>
                        </div>
                        {{-- dashboard page --}}
                        <div class="page-box">
                            <div class="media">
                                <img src="{{ asset('assets/images/dashboard-01.png') }}" alt="dashboard"
                                    class="img-fluid">
                                <div class="media-body">
                                    <h5>Dashboard Page</h5>
                                    <p>Raouls Choice is een simple en elegant thema zonder extra opties, mokkeljk te
                                        gebruken en geoptimaliseerd voor conversie.</p>
                                </div>
                            </div>
                            <div class="action">
                                <h6>Access Permission</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="dashboard" id="dashboardPage" {{ $permission->dashboard == 1 ? 'checked' : ''}}>
                                    @error('dashboard')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- dashboard page --}}
                        {{-- Home page --}}
                        <div class="page-box">
                            <div class="media">
                                <img src="{{ asset('assets/images/home-01.png') }}" alt="dashboard"
                                    class="img-fluid">
                                <div class="media-body">
                                    <h5>Home Page</h5>
                                    <p>Raouls Choice is een simple en elegant thema zonder extra opties, mokkeljk te
                                        gebruken en geoptimaliseerd voor conversie.</p>
                                </div>
                            </div>
                            <div class="action">
                                <h6>Access Permission</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="homePage" id="homePage" {{ $permission->homePage == 1 ? 'checked' : ''}}>
                                    @error('homePage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Home page --}}
                        {{-- message page --}}
                        <div class="page-box">
                            <div class="media">
                                <img src="{{ asset('assets/images/message-01.png') }}" alt="dashboard"
                                    class="img-fluid">
                                <div class="media-body">
                                    <h5>Message Page</h5>
                                    <p>Raouls Choice is een simple en elegant thema zonder extra opties, mokkeljk te
                                        gebruken en geoptimaliseerd voor conversie.</p>
                                </div>
                            </div>
                            <div class="action">
                                <h6>Access Permission</h6>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="messagePage" id="messagePage"
                                    {{ $permission->messagePage == 1 ? 'checked' : ''}}>
                                    @error('messagePage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Message page --}}
                        {{-- Certificate page --}}
                        <div class="page-box">
                            <div class="media">
                                <img src="{{ asset('assets/images/certificate.png') }}" alt="dashboard"
                                    class="img-fluid">
                                <div class="media-body">
                                    <h5>Certificate Page</h5>
                                    <p>Raouls Choice is een simple en elegant thema zonder extra opties, mokkeljk te
                                        gebruken en geoptimaliseerd voor conversie.</p>
                                </div>
                            </div>
                            <div class="action">
                                <h6>Access Permission</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="certificatePage" id="certificatePage"
                                    {{ $permission->certificatePage == 1 ? 'checked' : ''}}>
                                    @error('certificatePage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Certificate page --}}

                        <div class="save-bttns">
                            <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                            <button type="submit" class="btn btn-submit">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')

<script>
    // Find the form element by its ID
    var form = document.getElementById("access-form");

    // Add a submit event listener to the form
    form.addEventListener("submit", function(event) {
        // Iterate through all checkboxes in the form
        var checkboxes = form.querySelectorAll("input[type=checkbox]");
        checkboxes.forEach(function(checkbox) {
            // If the checkbox is checked, set its value to 1
            if (checkbox.checked) {
                checkbox.value = 1;
            } else {
                // If the checkbox is not checked, set its value to 0
                checkbox.value = 0;
            }
        });
    });
</script>
@endsection
