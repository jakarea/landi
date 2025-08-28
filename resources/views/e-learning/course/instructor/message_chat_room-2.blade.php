@extends('layouts/instructor')
@section('title')
    Message Page
@endsection

{{-- page style @S --}}
@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/message.css') }}">
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <!-- messages page wrapper @s -->
    <main class="common-page-wrap messages-page-wrap">
        <!-- message box @s -->
        <div class="messages-box">
            <!-- person list @s -->
            <div class="chat-person-list-box">
                <div class="title">
                    <h1>Inbox <span>(2,456)</span></h1>
                    <a href="#"><i class="fas fa-plus"></i></a>
                </div>

                <!-- person tab head @s -->
                <div class="person-tab-head">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Social</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false">Updates</button>
                        </li>
                    </ul>
                </div>
                <!-- person tab head @e -->

                <!-- person tab body @s -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                        tabindex="0">
                        <!-- all chat person @s -->
                        <div class="person-tab-body">
                            <div class="d-flex">
                                <h6>RECENT MESSAGE</h6>
                                <a href="#">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </a>
                            </div>
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Rayna Carder </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I remember that project due is tomorrow.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Skylar Dorwart </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Hei, dont forget to clear server cache!</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Kierra Curtis</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I dont't know where that files saved dude.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Bella Siregar</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Ok sir. I will fix it as soon as possible</p>
                                </div>
                            </div>
                            <!-- person @e -->
                        </div>
                        <!-- all chat person @e -->
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <!-- social chat person @s -->
                        <div class="person-tab-body">
                            <div class="d-flex">
                                <h6>SOCIAL</h6>
                            </div>
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/c-logo.svg') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Codebytes Sutudios </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Guys, remember for weekly meeting at 8PM tonight!</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/grid-icon.svg') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>World Designer </h5>
                                        <span>12m ago</span>
                                    </div>
                                    <p>I think you should put that component more lower th..</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <div class="d-flex">
                                <h6>RECENT MESSAGE</h6>
                                <a href="#">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </a>
                            </div>
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Rayna Carder </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I remember that project due is tomorrow.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Skylar Dorwart </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Hei, dont forget to clear server cache!</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Kierra Curtis</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I dont't know where that files saved dude.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Bella Siregar</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Ok sir. I will fix it as soon as possible</p>
                                </div>
                            </div>
                            <!-- person @e -->
                        </div>
                        <!-- social chat person @e -->
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <!-- updates chat person @s -->
                        <div class="person-tab-body">
                            <div class="d-flex">
                                <h6>UPDATE</h6>
                            </div>
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/c-logo.svg') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Codebytes Sutudios </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Guys, remember for weekly meeting at 8PM tonight!</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/grid-icon.svg') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>World Designer </h5>
                                        <span>12m ago</span>
                                    </div>
                                    <p>I think you should put that component more lower th..</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <div class="d-flex">
                                <h6>RECENT MESSAGE</h6>
                                <a href="#">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </a>
                            </div>
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Rayna Carder </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I remember that project due is tomorrow.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Skylar Dorwart </h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Hei, dont forget to clear server cache!</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Kierra Curtis</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>I dont't know where that files saved dude.</p>
                                </div>
                            </div>
                            <!-- person @e -->
                            <!-- person @s -->
                            <div class="media">
                                <div class="avatar">
                                    <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar"
                                        class="img-fluid">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="media-body">
                                    <div class="name">
                                        <h5>Bella Siregar</h5>
                                        <span>2m ago</span>
                                    </div>
                                    <p>Ok sir. I will fix it as soon as possible</p>
                                </div>
                            </div>
                            <!-- person @e -->
                        </div>
                        <!-- updates chat person @e -->
                    </div>
                </div>
                <!-- person tab body @e -->
            </div>
            <!-- person list @e -->
            <!-- chat-main-body box @s -->
            <div class="chat-main-body-box">
                <div class="chat-room-head">
                    <!-- chat person -->
                    <div class="media">
                        <img src="{{ asset('dashboard-assets/images/avatar.png') }}" alt="Avatar" class="img-fluid">
                        <div class="media-body">
                            <h5> {{ $reciver_info->name }}</h5>
                            <p>@ {{ $reciver_info->subdomain }}</p>
                        </div>
                    </div>
                    <!-- chat person -->

                    <!-- chat room head icons @s -->
                    <div class="chat-room-head-icons">
                        <ul>
                            <li><a href="#"><i class="fas fa-video"></i></a></li>
                            <li><a href="#"><i class="fas fa-search"></i></a></li>
                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                            <li><a href="#"><i class="fas fa-ellipsis-vertical"></i></a></li>
                        </ul>
                    </div>
                    <!-- chat room head icons @e -->
                </div>
                <!-- main chart room @s -->
                <div class="main-chat-room">
                    <!-- chat date @s -->
                    <div class="chat-top-date">
                        <span>Yesterday</span>
                    </div>
                    <!-- chat date @s -->
                    <!-- messages @s -->
                    <div class="chat-messages-box">
                        @foreach ($messages as $message)
                            <!-- item @s -->
                            <div class="message-item {{ $message->user_id == Auth::user()->id ? 'sender' : 'reciver' }}">
                                <p>{{ $message->message }}</p>
                                <span>{{ $message->created_at->diffForHumans() }} <i
                                        class="fa-regular fa-clock ms-2"></i></span>
                            </div>
                            <!-- item @e -->
                        @endforeach
                    </div>
                    <!-- messages @e -->
                </div>
                <!-- main chart room @e -->

                <!-- message send box @s -->
                <form action="{{ route('post.chat_room.message', $chat_room) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="message-send-box">
                        <div class="form-group form-error">
                            <textarea name="message" rows="3" placeholder="type here..." class="form-control"></textarea>
                            <span class="invalid-feedback">
                                @error('message')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="file-attach-bttns">
                            <button type="submit" class="btn bttn"><i class="fas fa-paper-plane"></i> SEND</button>
                            <a href="#"><i class="fa-solid fa-face-smile"></i></a>
                            <a href="#"><i class="fa-solid fa-paperclip"></i></a>
                        </div>
                    </div>

                </form>

                <!-- message send box @e -->
            </div>
            <!-- chat-main-body box @e -->
        </div>
        <!-- message box @e -->
    </main>
    <!-- messages page wrapper @e -->
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
    <script src="{{ asset('dashboard-assets/js/config.js') }}"></script>
@endsection
{{-- page script @E --}}
