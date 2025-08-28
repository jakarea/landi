@extends('layouts.latest.students')
@section('title') Message Page @endsection

{{-- page style @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/message.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    {{-- ==== message list page @S ==== --}}
    <main class="message-list-page-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="messages-box">
                        <div class="chat-person-list-box">
                            <div class="title">
                                <h1>Your Information</h1>
                            </div>
                            <div class="person-tab-body">
                                <div class="media">
                                    <div class="avatar">
                                        <img src="{{ asset($sender_info->avatar) }}" alt="Avatar" class="img-fluid">

                                    </div>
                                    <div class="media-body">
                                        <div class="name">
                                            <h5>{{ $sender_info->name }}</h5>
                                            <span>2m ago</span>
                                        </div>
                                        <p>{{ $sender_info->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="chat-main-body-box">
                                <div class="chat-room-head">
                                    <div class="media">
                                        <img src="{{ asset($reciver_info->user->avatar) }}" alt="Avatar" class="img-fluid">
                                        <div class="media-body">
                                            <h5> {{ $reciver_info->user->name }}</h5>
                                            <p> {{ $reciver_info->user->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('post.message', $courseId) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="message-send-box">
                                        <div class="form-group">
                                            <input autocomplete="off" type="text" class="form-control"
                                                placeholder="Send a message to {{ $reciver_info->user->name }}" name="message">
                                            <span class="invalid-feedback">
                                                @error('message')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="file-attach-bttns">
                                            <button class="btn btn-prm"> <i class="bi bi-envelope"></i> Send </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- ==== message list page @E ==== --}}
    @endsection
    {{-- page content @E --}}
