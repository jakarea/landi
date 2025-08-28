@isset($friend)
    <div class="chat-room-head w-100">
        <div class="media">
            @isset($friend->avatar)
                <img src="{{ asset($friend->avatar) }}" alt="{{ $friend->name }}" class="img-fluid">
            @else
                <span class="user-name-avatar">{!! strtoupper($friend->name[0]) !!}</span>
            @endisset

            <div class="media-body">
                <h5 class="name">{{ $friend->name }}
                    @if (Cache::has('user-is-online-' . $friend->id))
                        <span class="online">
                            <i class="fas fa-circle"></i>
                            Online
                        </span>
                    @else
                        <span class="offline">
                            <i class="fas fa-circle"></i>
                            Offline
                        </span>
                    @endif
                </h5>
                @php
                    $emailParts = explode('@', $friend->email);
                    $username = $emailParts[0];
                @endphp
                <p>{{ $username }}</p>
            </div>
            <a href="javascript:;" class="view-bttn own-profile">View Profile</a>
        </div>
    </div>
@endisset


@php
    $lastDate = null;
@endphp

@forelse ($messages as $message)
    @php
        $messageDate = \Carbon\Carbon::parse($message->created_at)->toDateString();
    @endphp

    @if ($lastDate != $messageDate)
        <div class="date-status">
            <hr>
            <span>
                @if ($messageDate == now()->toDateString())
                    Today
                @elseif (
                    $messageDate ==
                        now()->subDay()->toDateString())
                    Yesterday
                @else
                    {{ \Carbon\Carbon::parse($messageDate)->format('F j, Y') }}
                @endif
            </span>
        </div>
        @php
            $lastDate = $messageDate;
        @endphp
    @endif


    <div class="message-item {{ $message->sender_id == Auth::id() ? 'sender-item' : '' }}">
        <div class="media main-media">
            <div class="avatar">
                
                @isset($message->groupUserName->avatar)
                    <img src="{{ asset($message->groupUserName->avatar) }}" alt="A"
                        class="img-fluid">
                @else
                    <span class="user-name-avatar">{!! strtoupper($message->groupUserName->name[0]) !!}</span>
                @endisset

                <i class="fas fa-circle"></i>

            </div>
            <div class="media-body">
                <div class="d-flex">
                    <h6 class="open-profile">{{ $message->groupUserName->name ?? '' }} &nbsp; </h6>
                    <span> {{ $message->created_at->format('D H:s a') }}
                    </span>
                </div>

                <div class="text">
                    @if ($message->file)
                        @php
                            $allowedImageExtensions = ['jpg', 'png', 'jpeg', 'gif'];
                            $allowedVideoExtensions = ['webm', 'mkv', 'avi', 'wmv', 'amv', 'mp4', 'mpg', 'mpeg', 'm4v', '3gp', 'flv'];
                            $allowedDocumentExtensions = ['pdf', 'zip', 'doc', 'docx'];
                            $extension = pathinfo($message->file, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), $allowedImageExtensions))
                            <div class="single-chat-image">
                                <a href="{{ asset('uploads/chat/' . $message->file) }}" data-lightbox="image-1"
                                    data-title="{{ $message->message }}">
                                    <img src="{{ asset('uploads/chat/' . $message->file) }}" alt="Image"
                                        class="img-fluid">
                                </a>
                            </div>
                        @elseif(in_array(strtolower($extension), $allowedVideoExtensions))
                            <video src="{{ asset('uploads/chat/' . $message->file) }}"></video>
                        @elseif (in_array(strtolower($extension), $allowedDocumentExtensions))
                            @if (strtolower($extension) === 'zip')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/zip.png') }}"
                                        alt="Avatar" class="img-fluid">
                                </a>
                            @elseif (strtolower($extension) === 'pdf')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/pdf.svg') }}"
                                        alt="Avatar" class="img-fluid">
                                </a>
                            @elseif (strtolower($extension) === 'docx')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/docx.png') }}"
                                        alt="Avatar" class="img-fluid">
                                </a>
                            @else
                            @endif
                        @endif
                    @endif

                    @if ($message->message)
                        <p>{{ $message->message }}</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@empty
@endforelse


{{-- view profile box start --}}
<div class="view-profile-box custom-scrl" id="profileBox">
    <div class="profile-box">
        <a href="javascript:;" id="closeProfile">
            <i class="fas fa-close"></i>
        </a>
        <div class="avatar">
            @isset($friend->avatar)
                <img src="{{ asset($friend->avatar) }}" alt="A" class="img-fluid rounded-circle">
            @else
                <span class="user-name-avatar" style="width: 6rem; height: 6rem; font-size: 2rem;">{!! strtoupper($friend->name[0]) !!}</span>
            @endisset

            @if (Cache::has('user-is-online-' . $friend->id))
                <i class="fas fa-circle"></i>
            @else
                <i class="fas fa-circle"></i>
            @endif
        </div>
        <h5>{{ $friend->name }}</h5>
        <p>{{ $friend->user_role }}</p>

        {{-- <button type="button" class="btn btn-remove">Remove from group</button> --}}
    </div>

    <hr>

    <h5>Contact</h5>

    <div class="media">
        <i class="fa-regular fa-envelope"></i>
        <div class="media-body">
            <h6>Email</h6>
            <a href="mailto: {{ $friend->email ?? "" }}">{{ $friend->email ?? "" }}</a>
        </div>
    </div>
    <div class="media">
        <i class="fa-solid fa-mobile-screen"></i>
        <div class="media-body">
            <h6>Phone</h6>
            <a href="tel: {{ $friend->phone ?? "" }}">{{ $friend->phone ?? "" }}</a>
        </div>
    </div>

    @php
        $socialLinks = explode(',', $friend->social_links);
    @endphp

    @foreach(explode(',', $friend->social_links) as $link)
        @php
            $trimmedLink = trim($link);
            $isInstagram = strpos($trimmedLink, 'instagram.com') !== false;
            $isFacebook = strpos($trimmedLink, 'facebook.com') !== false;
            $isLinkedIn = strpos($trimmedLink, 'linkedin.com') !== false;
            $isTwitter = strpos($trimmedLink, 'twitter.com') !== false;
        @endphp

        <div class="media">
            @if($isInstagram)
                <i class="fa-brands fa-instagram"></i>
            @elseif($isFacebook)
                <i class="fa-brands fa-square-facebook"></i>
            @elseif($isLinkedIn)
                <i class="fa-brands fa-linkedin"></i>
            @elseif($isTwitter)
                <i class="fa-brands fa-twitter"></i>
            @else
                <!-- You can add an icon for an unknown social media platform here -->
            @endif

            <div class="media-body">
                <h6>
                    @if($isInstagram)
                        Instagram
                    @elseif($isFacebook)
                        Facebook
                    @elseif($isLinkedIn)
                        LinkedIn
                    @elseif($isTwitter)
                        Twitter
                    @else
                        Unknown social media
                    @endif
                </h6>
                <a href="{{ $trimmedLink }}">{{ $trimmedLink }}</a>
            </div>
        </div>
    @endforeach


    <hr class="my-3">

    <div class="media">
        <div class="media-body">
            <h6>Email</h6>
            <a href="javascript:;">{{ $friend->email ?? "" }}</a>
        </div>
    </div>

    @isset( $friend->company_name )
        <div class="media">
            <div class="media-body">
                <h6>Company Name</h6>
                <a href="javascript:;">{{ $friend->company_name }}</a>
            </div>
        </div>
    @endisset

    @isset( $friend->short_bio )
        <div class="media">
            <div class="media-body">
                <h6>Website</h6>
                <a href="{{ $friend->short_bio }}">{{ $friend->short_bio }}</a>
            </div>
        </div>
        @endisset

</div>
{{-- view profile box end --}}
