@extends('layouts.latest.instructor')
@section('title') Messsages Page @endsection

{{-- page style @S --}}
@section('style')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{ asset('assets/admin-css/message.css') }}" rel="stylesheet" type="text/css" />
<style>
    .message-list-page-wrap {
        font-family: 'Poppins', sans-serif !important;
    }
</style>
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- ==== message list page @S ==== --}}
<main class="message-list-page-wrap student-messages-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="messages-box">
                    {{-- leftbar side start --}}
                    <div class="chat-person-list-box">
                        {{-- title --}}
                        <div class="title">
                            <h1>Messages <span>40</span></h1>

                            {{-- create group box start --}}
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <img src="{{asset('assets/images/icons/m-user.svg')}}" alt="ic"
                                    class="img-fluid"> Create Group
                            </a>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="create-group-form">
                                <h4>Create Group</h4>

                                <div class="media">
                                    <img src="{{ asset('assets/images/m-avatar.png') }}" alt="a"
                                        class="img-fluid">
                                    <div class="media-body">
                                        <h6>Phoenix Baker</h6>
                                        <p>Admin</p>
                                    </div>
                                </div>
                                <form action="post" id="create_group">
                                    <div class="form-group">
                                        <label for="">Group Name</label>
                                        <input autocomplete="off" type="text" name="name" placeholder="Group Name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Add People</label>
                                        <input autocomplete="off" type="text" placeholder="Name" class="form-control">
                                        <img src="{{asset('assets/images/icons/search.svg')}}" alt="a"
                                            class="img-fluid">
                                    </div>
                                    {{-- suggested name box --}}
                                    <div class="suggested-name-box">
                                        {{-- suggested person --}}
                                        <div>
                                            <img src="{{asset('assets/images/m-avatar.png')}}" alt=""
                                                class="img-fluid">
                                            <span>Mollie Hall</span>
                                            <a href="#">
                                                <i class="fas fa-close"></i>
                                            </a>
                                        </div>
                                        {{-- suggested person --}}
                                        {{-- suggested person --}}
                                        <div>
                                            <img src="{{asset('assets/images/avatar.png')}}" alt=""
                                                class="img-fluid">
                                            <span>Mollie Hall</span>
                                            <a href="#">
                                                <i class="fas fa-close"></i>
                                            </a>
                                        </div>
                                        {{-- suggested person --}}
                                        {{-- suggested person --}}
                                        <div>
                                            <img src="{{asset('assets/images/update-5.png')}}" alt=""
                                                class="img-fluid">
                                            <span>Mollie Hall</span>
                                            <a href="#">
                                                <i class="fas fa-close"></i>
                                            </a>
                                        </div>
                                        {{-- suggested person --}}
                                    </div>
                                    {{-- suggested name box --}}

                                    {{-- person list box start --}}
                                    <div class="person-box-list person-tab-body">

                                        {{-- person --}}
                                        <div class="single-person border-0">
                                            <div class="media p-0 border-0">
                                                <div class="avatar">
                                                    <img src="{{ asset('assets/images/update-5.png') }}"
                                                        alt="Avatar" class="img-fluid me-0">
                                                    <i class="fas fa-circle"></i>
                                                </div>

                                                <div class="media-body">
                                                    <div class="name">
                                                        <a href="#" class="name">Katherine Moss</a>
                                                    </div>
                                                    <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- person --}}
                                        {{-- person --}}
                                        <div class="single-person border-0">
                                            <div class="media p-0 border-0">
                                                <div class="avatar">
                                                    <img src="{{ asset('assets/images/update-4.png') }}"
                                                        alt="Avatar" class="img-fluid me-0">
                                                    <i class="fas fa-circle"></i>
                                                </div>

                                                <div class="media-body">
                                                    <div class="name">
                                                        <a href="#" class="name">Katherine Moss</a>
                                                    </div>
                                                    <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- person --}}
                                        {{-- person --}}
                                        <div class="single-person border-0">
                                            <div class="media p-0 border-0">
                                                <div class="avatar">
                                                    <img src="{{ asset('assets/images/update-3.png') }}"
                                                        alt="Avatar" class="img-fluid me-0">
                                                    <i class="fas fa-circle"></i>
                                                </div>

                                                <div class="media-body">
                                                    <div class="name">
                                                        <a href="#" class="name">Katherine Moss</a>
                                                    </div>
                                                    <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- person --}}

                                    </div>
                                    {{-- person list box end --}}

                                    {{-- form submit --}}
                                    <div class="form-submit">
                                        <button class="btn btn-cancel">Cancel</button>
                                        <button class="btn btn-create">Create</button>
                                    </div>
                                    {{-- form submit --}}
                                </form>
                            </div>
                        </div>
                        {{-- create group box end --}}

                        {{-- title --}}
                        {{-- chat filter --}}
                        <div class="header-filter">
                            <div class="search">
                                <img src="{{asset('assets/images/icons/search-m.svg')}}" alt="ic"
                                    class="img-fluid">
                                <input autocomplete="off" type="text" placeholder="Search" class="form-control">
                            </div>
                            <div class="chat-filter">
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{asset('assets/images/icons/filter-2.svg')}}" alt="ic"
                                            class="img-fluid"> All Chat
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item active" href="#">All Chat</a></li>
                                        <li><a class="dropdown-item" href="#">Groups</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- chat filter --}}

                        {{-- leftbar person list start --}}
                        <div class="person-tab-body">
                            {{-- single person start --}}
                            @forelse ($users as $user)
                                <div class="single-person user" id="{{ $user->id }}">
                                    <div class="media">
                                        @isset( $user )
                                            <div class="avatar">
                                                <img src="{{ asset($user->avatar) }}" alt="Avatar"
                                                    class="img-fluid">
                                                <i class="fas fa-circle"></i>
                                            </div>
                                        @else
                                            <div class="avatar">
                                                <img src="{{ asset('assets/images/update-5.png') }}" alt="Avatar"
                                                    class="img-fluid">
                                                <i class="fas fa-circle"></i>
                                            </div>
                                        @endisset



                                        <div class="media-body">
                                            <div class="name">
                                                <a href="#" class="name">{{ $user->name }}</a>
                                            </div>
                                            <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                        </div>
                                        {{-- action --}}
                                        <div class="dropdown">
                                            <a class="btn" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <img src="{{ asset('assets/images/icons/messages/trash.svg') }}"
                                                            alt="ic" class="img-fluid"> Delete chat
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal4">
                                                        <img src="{{ asset('assets/images/icons/messages/users.svg') }}"
                                                            alt="ic" class="img-fluid"> Create group with Katherine
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <img src="{{ asset('assets/images/icons/messages/mail-open.svg') }}"
                                                            alt="ic" class="img-fluid"> Mark as unread
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        {{-- action --}}
                                    </div>
                                </div>
                            @empty
                                <div class="single-persion">
                                    <h5>User not found</h5>
                                </div>
                            @endforelse
                            {{-- single person end --}}

                        </div>
                        {{-- leftbar person list end --}}
                    </div>
                    {{-- leftbar side end --}}

                    {{-- chat body right side start --}}
                    <div class="chat-main-body-box">
                        {{-- room header start --}}
                        <div class="chat-room-head">
                            <div class="media">
                                <img src="{{ asset('assets/images/icons/messages/avatar.png') }}" alt="Avatar"
                                    class="img-fluid">

                                <div class="media-body">
                                    <h5 class="name">Katherine Moss <span><i class="fas fa-circle"></i> Online</span>
                                    </h5>
                                    <p>@kathy</p>
                                </div>
                                <a href="#" class="view-bttn open-profile">View Profile</a>
                            </div>
                        </div>
                        {{-- room header end --}}

                        {{-- group room header start --}}
                        <div class="chat-room-head group-room-header">
                            <div class="media">
                                <img src="{{ asset('assets/images/group-img.png') }}" alt="Avatar"
                                    class="img-fluid">

                                <div class="media-body">
                                    <h5 class="name">Math Education </h5>

                                    <ul class="peoples">
                                        <li><img src="{{ asset('assets/images/update-2.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-3.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-4.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-5.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-3.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-4.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><img src="{{ asset('assets/images/update-5.png') }}" alt="a"
                                                class="img-fluid"></li>
                                        <li><span>+5</span></li>
                                    </ul>

                                </div>
                                {{-- action --}}
                                <div class="dropdown">
                                    <a class="btn" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item active" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <img src="{{ asset('assets/images/icons/messages/add.svg') }}"
                                                    alt="ic" class="img-fluid"> Add People
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                                <img src="{{ asset('assets/images/icons/messages/pencil.svg') }}"
                                                    alt="ic" class="img-fluid"> Rename Group
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                                <img src="{{ asset('assets/images/icons/messages/delete.svg') }}"
                                                    alt="ic" class="img-fluid"> Delete Group
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                {{-- action --}}
                            </div>
                        </div>
                        {{-- group room header end --}}

                        {{-- view profile box start --}}
                        <div class="view-profile-box custom-scrl" id="profileBox">
                            <div class="profile-box">
                                <a href="#" id="closeProfile">
                                    <i class="fas fa-close"></i>
                                </a>
                                <div class="avatar">
                                    <img src="{{ asset('assets/images/icons/messages/big-avatar.png') }}" alt="a"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <h5>Katherine Moss</h5>
                                <p>Student</p>

                                <button type="button" class="btn btn-remove">Remove from group</button>
                            </div>

                            <hr>

                            <h5>Contact</h5>

                            <div class="media">
                                <i class="fa-regular fa-envelope"></i>
                                <div class="media-body">
                                    <h6>Email</h6>
                                    <a href="#">kellyleannon@gemail.com</a>
                                </div>
                            </div>
                            <div class="media">
                                <i class="fa-solid fa-mobile-screen"></i>
                                <div class="media-body">
                                    <h6>Phone</h6>
                                    <a href="#">+11 1234 567 890</a>
                                </div>
                            </div>
                            <div class="media">
                                <i class="fa-brands fa-instagram"></i>
                                <div class="media-body">
                                    <h6>Instagram</h6>
                                    <a href="#">instagram.com/kellyleannon</a>
                                </div>
                            </div>
                            <hr class="my-3">

                            <div class="media">
                                <div class="media-body">
                                    <h6>Date of birth</h6>
                                    <a href="#">21 Jan, 2002</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <h6>Gender</h6>
                                    <a href="#">Female</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <h6>Country</h6>
                                    <a href="#">United State</a>
                                </div>
                            </div>

                        </div>
                        {{-- view profile box end --}}

                        {{-- chat body list start --}}
                        <div class="main-chat-room">
                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6 class="open-profile">Katherine Moss</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="text">
                                            <p>Thanks Olivia! Almost there. I’ll work on making those changes
                                                you suggested and will shoot it over.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}
                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6 class="open-profile">Katherine Moss</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="text">
                                            <p>Hey Olivia, I’ve finished with the requirements doc! I made some notes in
                                                the gdoc as well for Phoenix to look over.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}
                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6 class="open-profile">Katherine Moss</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="file">
                                            <div class="media">
                                                <img src="{{ asset('assets/images/icons/messages/pdf.svg') }}"
                                                    alt="Avatar" class="img-fluid">
                                                <div class="media-body">
                                                    <h5><a href="#">Tech requirements.pdf</a></h5>
                                                    <span>1.2 MB</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}

                            {{-- message item start --}}
                            <div class="message-item sender-item">
                                <div class="media main-media">
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>You</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="file">
                                            <div class="media">
                                                <img src="{{ asset('assets/images/icons/messages/pdf.svg') }}"
                                                    alt="Avatar" class="img-fluid">
                                                <div class="media-body">
                                                    <h5><a href="#">Tech requirements.pdf</a></h5>
                                                    <span>1.2 MB</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}

                            {{-- message item sender start --}}
                            <div class="message-item sender-item">
                                <div class="media main-media">
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>You</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="text">
                                            <p>Awesome! Thanks. I’ll look at this <br> today.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item sender end --}}

                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>Katherine Moss</h6>
                                            <span>Thursday 10:16am</span>
                                        </div>
                                        <div class="text">
                                            <p>No rush though — we still have to wait for Lana’s designs.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}

                            {{-- time block --}}
                            <div class="date-status">
                                <hr>
                                <span>Today</span>
                            </div>
                            {{-- time block --}}

                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>Katherine Moss</h6>
                                            <span>Today 2:20pm</span>
                                        </div>
                                        <div class="text">
                                            <p>Hey Olivia, can you please review the latest design when you can?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}

                            {{-- message item sender start --}}
                            <div class="message-item sender-item">
                                <div class="media main-media">
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>You</h6>
                                            <span>Just now</span>
                                        </div>
                                        <div class="text">
                                            <p>Sure thing, I’ll have a look today. They’re looking great!</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- message react --}}
                                <div class="react-box">
                                    <ul>
                                        <li><span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-title="Katherine Moss">&#x2764;</span></li>
                                    </ul>
                                </div>
                                {{-- message react --}}
                            </div>
                            {{-- message item sender end --}}

                            {{-- message item start --}}
                            <div class="message-item">
                                <div class="media main-media">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/icons/messages/avatar.png') }}"
                                            alt="Avatar" class="img-fluid">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-flex">
                                            <h6>Katherine Moss</h6>
                                        </div>
                                        <div class="typing">
                                            <i class="fa-solid fa-ellipsis fa-fade"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- message item end --}}

                        </div>
                        {{-- chat body list end --}}

                        {{-- message send actions start --}}
                        <form method="POST" action="" class="send-actions">
                            <div class="message-send-box">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Send a message" name="message">
                                </div>
                                <div class="file-attach-bttns">
                                    <button type="button" class="btn btn-emoji">
                                        <img src="{{ asset('assets/images/icons/messages/wmoji.svg') }}"
                                            alt="Avatar" class="img-fluid">
                                    </button>
                                    <button type="button" class="btn btn-emoji">
                                        <img src="{{ asset('assets/images/icons/messages/line.svg') }}"
                                            alt="Avatar" class="img-fluid">
                                    </button>
                                    <button class="btn btn-submit" type="submit">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- message send actions end --}}

                    </div>
                    {{-- chat body right side end --}}
                </div>
            </div>
        </div>
    </div>
</main>
{{-- ==== message list page @E ==== --}}

{{-- add people to group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form">

                    <form action="">
                        <div class="form-group mt-0">
                            <label for="" style="font-size: 1.25rem">Add People</label>
                            <input autocomplete="off" type="text" placeholder="Name" class="form-control">
                            <img src="{{asset('assets/images/icons/search.svg')}}" alt="a"
                                class="img-fluid">
                        </div>
                        {{-- suggested name box --}}
                        <div class="suggested-name-box">
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/m-avatar.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/avatar.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/update-5.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                        </div>
                        {{-- suggested name box --}}

                        {{-- person list box start --}}
                        <div class="person-box-list person-tab-body">

                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-5.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>I’ve just published the site again. Looks like...</p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-4.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>I’ve just published the site again. Looks like...</p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-3.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>I’ve just published the site again. Looks like...</p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-2.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>I’ve just published the site again. Looks like...</p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-5.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>I’ve just published the site again. Looks like...</p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}

                        </div>
                        {{-- person list box end --}}

                        {{-- form submit --}}
                        <div class="form-submit">
                            <button class="btn btn-cancel" data-bs-dismiss="modal" type="button">Cancel</button>
                            <button class="btn btn-create" type="submit">Add</button>
                        </div>
                        {{-- form submit --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- add people to group modal end --}}

{{-- add specific person to group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModal4Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form">
                    <h4>Create Group</h4>

                    <div class="media">
                        <img src="{{ asset('assets/images/m-avatar.png') }}" alt="a"
                            class="img-fluid">
                        <div class="media-body">
                            <h6>Phoenix Baker</h6>
                            <p>Admin</p>
                        </div>
                    </div>
                    <form action="">
                        <div class="form-group">
                            <label for="">Group Name</label>
                            <input autocomplete="off" type="text" placeholder="Group Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Add People</label>
                            <input autocomplete="off" type="text" placeholder="Name" class="form-control">
                            <img src="{{asset('assets/images/icons/search.svg')}}" alt="a"
                                class="img-fluid">
                        </div>
                        {{-- suggested name box --}}
                        <div class="suggested-name-box">
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/m-avatar.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/avatar.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                            {{-- suggested person --}}
                            <div>
                                <img src="{{asset('assets/images/update-5.png')}}" alt=""
                                    class="img-fluid">
                                <span>Mollie Hall</span>
                                <a href="#">
                                    <i class="fas fa-close"></i>
                                </a>
                            </div>
                            {{-- suggested person --}}
                        </div>
                        {{-- suggested name box --}}

                        {{-- person list box start --}}
                        <div class="person-box-list person-tab-body">

                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-5.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-4.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}
                            {{-- person --}}
                            <div class="single-person border-0">
                                <div class="media p-0 border-0">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/images/update-3.png') }}"
                                            alt="Avatar" class="img-fluid me-0">
                                        <i class="fas fa-circle"></i>
                                    </div>

                                    <div class="media-body">
                                        <div class="name">
                                            <a href="#" class="name">Katherine Moss</a>
                                        </div>
                                        <p>You: Sure thing, I’ll have a l.. <span>12m</span></p>
                                    </div>
                                </div>
                            </div>
                            {{-- person --}}

                        </div>
                        {{-- person list box end --}}

                        {{-- form submit --}}
                        <div class="form-submit">
                            <button class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-create">Create</button>
                        </div>
                        {{-- form submit --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- add specific person to group modal end --}}

{{-- rename group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form">
                    <h4>Rename Group</h4>

                    <div class="chat-room-head group-room-header pt-0 ps-0" style="box-shadow: none">
                        <div class="media">
                            <img src="{{ asset('assets/images/group-img.png') }}" alt="Avatar"
                                class="img-fluid">

                            <div class="media-body">
                                <h5 class="name">Math Education </h5>

                                <ul class="peoples">
                                    <li><img src="{{ asset('assets/images/update-2.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-3.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-4.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-5.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-3.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-4.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><img src="{{ asset('assets/images/update-5.png') }}" alt="a"
                                            class="img-fluid"></li>
                                    <li><span>+5</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form action="">
                        <div class="form-group mt-0">
                            <label for="">Group Name</label>
                            <input autocomplete="off" type="text" placeholder="Group Name" class="form-control">
                        </div>

                        {{-- form submit --}}
                        <div class="form-submit">
                            <button class="btn btn-cancel" data-bs-dismiss="modal" type="button">Cancel</button>
                            <button class="btn btn-create" type="submit">Save</button>
                        </div>
                        {{-- form submit --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- rename group modal end --}}

{{-- delete group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form text-center">
                    <img src="{{asset('assets/images/icons/messages/err.svg')}}" alt="a" class="img-fluid">
                     <h4 class="border-0 pb-0 mt-4">Delete This Group</h4>
                     <p>Are you sure you want to delete this group?</p>

                    <form action="">
                        {{-- form submit --}}
                        <div class="form-submit mt-5 error-bttn">
                            <button class="btn btn-cancel" data-bs-dismiss="modal" type="button">Cancel</button>
                            <button class="btn btn-create" type="submit">Delete</button>
                        </div>
                        {{-- form submit --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- delete group modal end --}}

@endsection
{{-- page content @E --}}

@section('script')



{{-- tooltip active js --}}
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

{{-- close profile box --}}
<script>
    const openPorifles = document.querySelectorAll('.open-profile');
    const closeIcon = document.getElementById('closeProfile');
    const profileBox = document.getElementById('profileBox');

    openPorifles.forEach(openPorifle => {
        openPorifle.addEventListener('click',function(){
            profileBox.classList.add('active');
        });
    });

    function closeProfileBox(e){
        e.preventDefault();
        this.parentNode.parentNode.classList.remove('active');
    }
    closeIcon.addEventListener('click',closeProfileBox);

</script>
@endsection
