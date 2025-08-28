<div class="media">
    @isset( $adminInfo->avatar )
        <img src="{{ asset($adminInfo->avatar) }}" alt="{{ $adminInfo->name }}" class="img-fluid">
    @else
        <span class="user-name-avatar me-1">{!! strtoupper($adminInfo->name[0]) !!}</span>
    @endisset

    <div class="media-body">
        <h6 class="adminName">{{ $adminInfo->name }}</h6>
        <p>Admin</p>
    </div>
</div>
