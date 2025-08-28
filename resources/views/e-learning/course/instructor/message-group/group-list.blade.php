
@if( count( $groups ) > 0)
    @foreach ($groups as $group)
        <div class="single-person group" id="group_{{ $group->id }}">
            <div class="media">
                @isset($group)
                    <div class="avatar">
                        @isset( $group->avatar )
                            <img src="{{ asset($group->avatar) }}" alt="{{ $group->name }}" class="img-fluid">
                        @else
                            <span class="user-name-avatar">{!! strtoupper($group->name[0]) !!}</span>
                        @endisset

                        {{-- @if(Cache::has('user-is-online-' . Auth::user()->id))
                            <i class="fas fa-circle"></i>
                        @else
                            <i class="fa-solid fa-circle" style="color: #a1a1a5;"></i>
                        @endif --}}
                    </div>
                @endisset

                <div class="media-body">
                    <div class="name">
                        <a href="javascript:;" class="name">{{ $group->name }}</a>
                    </div>
                    @if (!empty($group->last_message))
                        {{-- <p>{{ Str::limit($group->last_message, 20, '...') }} <span>{{ $group->last_message_timestamp->diffForHumans() }}</span></p> --}}
                        <p>{{ Str::limit($group->last_message, 20, '...') }} </p>
                    @else
                        {{-- @if ($group->received_file)
                            {{ __("You have received a file")}}
                        @elseif($group->sent_file)
                        {{ __("You have sent a file ") }}
                        @endif --}}
                    @endif

                </div>
                {{-- action --}}
                <div class="dropdown">
                    <a class="btn" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a data-group-id="{{ $group->id }}" class="dropdown-item deleteGroupChatMsg" href="javascript:;">
                                <img src="{{ asset('assets/images/icons/messages/trash.svg') }}"
                                    alt="ic" class="img-fluid"> Delete chat
                            </a>
                        </li>
                        {{-- <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#exampleModal4">
                                <img src="{{ asset('assets/images/icons/messages/users.svg') }}"
                                    alt="ic" class="img-fluid"> Create group with
                                {{ Auth::user()->name }}
                            </a>
                        </li> --}}
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
    @endforeach
@endif
