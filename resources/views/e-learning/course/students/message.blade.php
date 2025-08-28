@extends('layouts/student')
@section('title') Student Message Page @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/css/student.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
<main class="message-page-wrap">
    <div class="col-12">
        <div class="main-chat-wrapper">
            <div class="d-flex">
                <h5>Messages to:</h5>
                <div class="instructor-avatar">
                    <div class="media">
                        <img src="{{asset('assets/images/avatar.png')}}" alt="a" class="img-fluid">
                        <div class="media-body">
                            <h5>Jhon Doe</h5>
                            <p>Course Name</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- chat area @S --}}
            <div class="chat-box-wrap">
                <div class="message-list-wrap">
                    {{-- item @S --}}
                    <div class="message-item sender">
                        <p>Hi, How are you?</p>
                        <span>10:30 AM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item reciver">
                        <p>I am fine, what about you?</p>
                        <span>09:20 PM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item sender">
                        <p>I am fine too!</p>
                        <span>10:30 AM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item reciver">
                        <p>Have you any update on the course?</p>
                        <span>09:20 PM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item sender">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, vel beatae! Sequi recusandae maiores ipsa eveniet nulla eos quia minus?</p>
                        <span>10:30 AM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item reciver">
                        <p>Have you any update on the course?</p>
                        <span>09:20 PM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item sender">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis.!</p>
                        <span>10:30 AM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                    {{-- item @S --}}
                    <div class="message-item reciver">
                        <p>Have you any update on the course?</p>
                        <span>09:20 PM <i class="fa-regular fa-clock"></i></span>
                    </div>
                    {{-- item @E --}}
                </div>
                <form action="">
                    <div class="form-group">
                        <textarea name="" placeholder="Write a message" id="" cols="30" rows="4" class="form-control"></textarea> 
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                    <small>You will get replay within 24 hours</small>
                </form>
            </div>
            {{-- chat area @E --}}
        </div>
    </div>
</main>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')

@endsection
{{-- page script @E --}}