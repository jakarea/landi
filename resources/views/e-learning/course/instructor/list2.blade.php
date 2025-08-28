@extends('layouts.latest.admin')
@section('title') All Courses @endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- style section @E --}}

@section('content')
<main class="courses-lists-pages">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- session message @S --}}
                @include('partials/session-message')
                {{-- session message @E --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="user-search-box-wrap">
                    <div class="form-group">
                        <i class="fas fa-search"></i>
                        <input autocomplete="off" type="text" placeholder="Search course" class="form-control">
                    </div>
                    <div class="form-filter">
                        <select class="form-control">
                            <option value="">All </option>
                            <option value="">Most Purchased</option>
                            <option value="">Newest</option>
                            <option value="">Oldest</option>
                        </select>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div class="user-title-box">
                        <a href="{{ url('admin/courses/create') }}"><i class="fas fa-plus me-2"></i> Add New Course</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($courses as $course)
            {{-- course single box start --}}
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3">
                <div class="course-single-item"> 
                    <div class="course-thumb-box">
                        <img src="{{asset($course->thumbnail)}}" alt="thumb" class="img-fluid"> 
                    </div> 
                    <div class="course-txt-box">
                        <a href="{{url('admin/courses/'.$course->slug)}}">{{ Str::limit($course->title, $limit = 45, $end = '..') }}</a>
                        <p>{{ Str::limit($course->short_description, $limit = 40, $end = '...') }}</p>

                        <h5>৳ {{ $course->offer_price }} <span>৳ {{ $course->price }}</span></h5>
                        {{-- <div class="d-flex">
                            <span><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($course->created_at)->diffForHumans() }} </span>
                            <a href="{{url('admin/courses/'.$course->slug)}}">View <i class="fas fa-eye text-primary"></i></a>
                            <a href="{{url('admin/courses/'.$course->slug.'/edit')}}">Edit <i class="fas fa-pen text-info"></i></a> 

                            <form method="post" class="d-inline" action="{{ url('admin/courses/'.$course->slug.'/destroy') }}">
                                @csrf 
                                @method("DELETE")
                                <button type="submit" class="btn p-0">Delete <i class="fas fa-trash text-danger"></i></button>
                            </form>
                            
                        </div> --}}
                    </div>
                </div>
            </div>
            {{-- course single box end --}}
            @endforeach 
        </div>
        <div class="row">
            <div class="col-12">
                {{-- pagginate --}}
                <div class="paggination-wrap">
                    {{ $courses->links('pagination::bootstrap-5') }}
                </div>
                {{-- pagginate --}}
            </div>
        </div>
    </div>
</main>
@endsection

{{-- script section @S --}}
@section('script')

@endsection
{{-- script section @E --}}