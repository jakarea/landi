<div class="suggest-user" id="{{ $user->id }}">
    @isset($user->avatar)
        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="img-fluid">
    @else
        <span class="user-name-avatar">{!! strtoupper($user->name[0]) !!}</span>
    @endisset

    <span>{{ $user->name ?? "Jon Doe" }}</span>
    <a href="javascript:;" class="remove-suggested-people">
        <i class="fas fa-close"></i>
    </a>
</div>
