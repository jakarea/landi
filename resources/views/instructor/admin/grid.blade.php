@extends('layouts.latest.admin')
@section('title')
Instructor List Page
@endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- ==== user list page @S ==== --}}
<main class="user-list-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="user-title-box">
                    <h1>Total: <span>{{ count($users) }} Instructor</span></h1>
                </div>
            </div>
        </div>
        <form action="" method="GET" id="myForm">
            <div class="row">
                <div class="col-lg-7 col-xl-9">
                    <div class="user-search-box-wrap">
                        <div class="form-group">
                            <i class="fas fa-search"></i>
                            <input autocomplete="off" type="text" placeholder="Search Instructor" class="form-control"
                                name="name" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                        </div>
                    </div>
                    <input type="hidden" name="status" id="inputField">
                </div>
                <div class="col-lg-5 col-xl-3">
                    <div class="filter-dropdown-box">
                        <div class="dropdown">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                id="dropdownBttn">
                                All Instructor
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item filterItem" href="#">All Instructor</a></li>
                                <li><a class="dropdown-item filterItem" href="#" data-value="active">Active
                                        Instructor</a></li>
                                <li><a class="dropdown-item filterItem" href="#" data-value="inactive">Inactive
                                        Instructor</a></li>
                            </ul>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-xl-2">
                    <div class="user-add-box">
                        <a href="{{ url('admin/instructor/create') }}"><img
                                src="{{ asset('assets/images/user-plus.svg') }}" alt="User" class="img-fluid">
                            Add
                            Instructor</a>
                    </div>
                </div> --}}
            </div>
        </form>
        <div class="row">
            @if (count($users) > 0)
            @foreach ($users as $user)
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                <div class="user-grid-box" style="padding-top: 2.5rem">
                    {{-- <div class="header-action">
                        <div class="dropdown">
                            <button class="btn btn-ellipse" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ url('admin/instructor/' . $user->id . '/edit') }}">Edit</a>
                                </li>
                                <li>
                                    <form method="post" class="d-inline"
                                        action="{{ url('admin/instructor/' . $user->id . '/destroy') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item btn text-danger">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    <div class="avatar">
                        @if ($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-fluid">
                        @else
                        <span>{!! strtoupper($user->name[0]) !!}</span>
                        @endif

                    </div>
                    <div class="txt">
                        <h4>{{ Str::limit($user->name, $limit = 22, $end = '..') }}</h4>
                        <h5>{{ Str::limit($user->email, $limit = 25, $end = '..') }}</h5>
                    </div>
                    <div class="ftr">
                        <a href="{{ url('admin/instructor/profile/' . $user->id) }}">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                @include('partials/no-data')
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                {{-- pagginate --}}
                <div class="paggination-wrap">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                {{-- pagginate --}}
            </div>
        </div>
    </div>
</main>
{{-- ==== user list page @E ==== --}}
@endsection
{{-- page content @E --}}

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
            let inputField = document.getElementById("inputField");
            let dropbtn = document.getElementById("dropdownBttn");
            let form = document.getElementById("myForm");
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let name = urlParams.get('name');
            let status = urlParams.get('status');
            let dropdownItems = document.querySelectorAll(".filterItem");

            if (status == "active") {
                dropbtn.innerText = 'Active Instructor';
            }
            if (status == "inactive") {
                dropbtn.innerText = 'Inactive Instructor';
            }
            inputField.value = status;

            dropdownItems.forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    inputField.value = this.getAttribute("data-value");
                    dropbtn.innerText = item.innerText;
                    form.submit();
                });
            });
        });
</script>
@endsection