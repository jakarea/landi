@extends('layouts.latest.admin')
@section('title')
    Admin List Page
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
                        <h1>Total: <span>{{ count($users) }} Admin</span></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <form action="">
                        <div class="user-search-box-wrap">
                            <div class="form-group">
                                <i class="fas fa-search"></i>
                                <input autocomplete="off" type="text" placeholder="Search Admin" class="form-control" name="name"
                                    value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2">
                    <div class="user-add-box text-end">
                        <a href="{{ url('admin/alladmin/create') }}"><img
                                src="{{ asset('assets/images/user-plus.svg') }}" alt="User" class="img-fluid">
                            Add Admin</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
                            <div class="user-grid-box">
                                <div class="header-action">
                                    <div class="dropdown">
                                        <button class="btn btn-ellipse" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ url('admin/alladmin/' . $user->id . '/edit') }}">Edit</a></li>
                                            <li>
                                                <form method="post" class="d-inline"
                                                    action="{{ url('admin/alladmin/' . $user->id . '/destroy') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item btn text-danger">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
                                    <a href="{{ url('admin/alladmin/profile/' . $user->id) }}">View Details</a>
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
                {{-- pagginate --}}
                <div class="paggination-wrap">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                {{-- pagginate --}}
            </div>
        </div>
    </main>
    {{-- ==== user list page @E ==== --}}
@endsection
{{-- page content @E --}}
