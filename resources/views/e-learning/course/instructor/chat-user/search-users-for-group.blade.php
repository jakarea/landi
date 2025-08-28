@if( count( $users ) > 0)
    @foreach ($users as $user)
        <div class="single-person suggest-people border-0" id="{{ $user->id }}" data-suggest-people="suggestpeople{{ $user->id }}">
            <div class="media p-0 border-0">
                @isset($user)
                    <div class="avatar">
                        @isset( $user->avatar )
                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="img-fluid">
                        @else
                            <span class="user-name-avatar">{!! strtoupper($user->name[0]) !!}</span>
                        @endisset
                        @if(Cache::has('user-is-online-' . $user->id))
                            <i class="fas fa-circle"></i>
                        @else
                            <i class="fa-regular fa-circle"></i>
                        @endif
                    </div>
                @else
                    <div class="avatar">
                        <img src="{{ asset('assets/images/update-5.png') }}"
                            alt="Avatar" class="img-fluid me-0">
                        <i class="fas fa-circle"></i>
                    </div>
                @endisset

                <div class="media-body">
                    <div class="name">
                        <a href="javascript:;" class="name">{{ $user->name }}</a>
                    </div>
                    @if (!empty($user->last_message))
                        {{-- <p>{{ Str::limit($user->last_message, 20, '...') }} <span>{{ $user->last_message_timestamp->diffForHumans() }}</span></p> --}}
                        <p>{{ Str::limit($user->last_message, 20, '...') }} </p>
                    @else
                        {{-- @if ($user->received_file)
                            {{ __("You have received a file")}}
                        @elseif($user->sent_file)
                        {{ __("You have sent a file ") }}
                        @endif --}}
                    @endif

                </div>
            </div>
        </div>
    @endforeach
@endif
