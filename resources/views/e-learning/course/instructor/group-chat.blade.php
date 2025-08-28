@isset($currentGroup)
    <div class="chat-room-head group-room-header">
        <div class="media">
            @isset( $currentGroup->avatar )
                <img src="{{ asset($currentGroup->avatar) }}" alt="{{ $currentGroup->name }}" class="img-fluid">
            @else
                <span class="user-name-avatar me-1">{!! strtoupper($currentGroup->name[0]) !!}</span>
            @endisset


            <div class="media-body">
                <h5 class="name">{{ $currentGroup->name }}</h5>
                <ul class="peoples">
                    @if( $currentGroup->participants )
                        @foreach ($currentGroup->participants as $participant)
                            @if($participant->user->recivingMessage == 1)
                                <li>
                                    @isset( $participant->user->avatar )
                                        <img src="{{ asset( $participant->user->avatar ) }}" alt="{{ $participant->user->name }}" class="img-fluid">
                                    @else
                                        <span class="user-name-avatar">{!! strtoupper($participant->user->name[0]) !!}</span>
                                    @endisset

                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            {{-- action --}}
            @if ( $currentGroup->admin_id == Auth::id())
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
                            <a class="dropdown-item updateGroup" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                <img src="{{ asset('assets/images/icons/messages/pencil.svg') }}"
                                    alt="ic" class="img-fluid"> Edit Group
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item groupDelete" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                <img src="{{ asset('assets/images/icons/messages/delete.svg') }}"
                                    alt="ic" class="img-fluid"> Delete Group
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            {{-- action --}}
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
                @elseif ($messageDate == now()->subDay()->toDateString())
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

                @isset( $message->groupUserName->avatar )
                    <img src="{{ asset($message->groupUserName->avatar) }}" alt="{{ $message->groupUserName->name }}" class="img-fluid">
                @else
                    <span class="user-name-avatar">{!! strtoupper($message->groupUserName->name[0]) !!}</span>
                @endisset

                <i class="fas fa-circle"></i>
            </div>
            <div class="media-body">
                <div class="d-flex">
                    <h6 class="open-profile">{{ $message->groupUserName->name ?? "" }} &nbsp; </h6>
                    <span> {{ $message->created_at->format('F j, Y') }}
                    </span>
                </div>

                <div class="text">
                    @if ($message->file)
                        @php
                            $allowedImageExtensions = ['jpg', 'png', 'jpeg', 'gif'];
                            $allowedVideoExtensions = ['webm','mkv','avi','wmv','amv','mp4','mpg','mpeg','m4v','3gp','flv'];
                            $allowedDocumentExtensions = ['pdf', 'zip', 'doc','docx'];
                            $extension = pathinfo($message->file, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), $allowedImageExtensions))
                            <div class="single-chat-image">
                                <a href="{{ asset('uploads/chat/'.$message->file) }}" data-lightbox="image-1" data-title="{{ $message->message }}">
                                    <img src="{{ asset('uploads/chat/'.$message->file) }}" alt="Image" class="img-fluid">
                                </a>
                            </div>
                        @elseif( in_array(strtolower($extension), $allowedVideoExtensions) )
                            <video src="{{ asset('uploads/chat/'.$message->file) }}"></video>
                        @elseif (in_array(strtolower($extension), $allowedDocumentExtensions))
                            @if (strtolower($extension) === 'zip')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/zip.png') }}" alt="Avatar" class="img-fluid">
                                </a>
                            @elseif (strtolower($extension) === 'pdf')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/pdf.svg') }}" alt="Avatar" class="img-fluid">
                                </a>
                            @elseif (strtolower($extension) === 'docx')
                                <a href="{{ route('course.messages.file.download', ['filename' => $message->file]) }}">
                                    <img src="{{ asset('assets/images/icons/messages/docx.png') }}" alt="Avatar" class="img-fluid">
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


{{-- <form method="POST" class="send-actions w-100" id="groupChatMessage" autocomplete="off">
    <div class="dock-bottom">
        <div id="file-preview" class="file-preview">
            <img src="" alt="" class="preview-image img-fluid" id="preview-image">
            <div class="preview-actions">
                <span id="file-type-icon"></span>
                <span class="close-icon" id="close-icon" onclick="removeFile()">✖</span>
            </div>
        </div>

        <div class="message-send-box">
            <div class="form-group">
                <input autocomplete="off" type="text" class="form-control" id="chat-message-input" placeholder="Send a message"
                    name="message">
            </div>
            <div class="file-attach-bttns">
                <label for="attached" class="message-attached">
                    <i class="fa-solid fa-paperclip"></i>
                </label>
                <input type="file" name="file" class="d-none" id="attached" onchange="displayFileName()">
                <button class="btn btn-submit" type="submit">
                    Send
                </button>
            </div>
        </div>
    </div>
</form> --}}

{{-- add people to group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form no-padding">
                    <form action="{{ route('messages.group.add.people') }}" method="POST" id="addPeopleToGroup">
                        @csrf
                        <div class="form-group mt-0">
                            <label for="" style="font-size: 1.25rem" class="mb-2">Add People</label>
                            <input autocomplete="off" type="text" placeholder="Name" class="form-control search-people-specific-group t"/>
                            <input class="addUserId" type="hidden" name="user_id">
                            <input name="groupId" type="hidden" value="{{ $currentGroup->id }}">
                            <img src="{{ asset('assets/images/icons/search.svg') }}" alt="a" class="img-fluid">
                        </div>
                        {{-- suggested name box --}}
                        <div class="suggested-name-box load-suggested-people"></div>
                        {{-- suggested name box --}}
                        {{-- person list box start --}}
                        <div class="person-box-list person-tab-body fetch-people-for-specificgroup"></div>
                        {{-- person list box end --}}
                        {{-- form submit --}}
                        <div class="form-submit">
                            <button class="btn btn-cancel" data-bs-dismiss="modal" type="reset">Cancel</button>
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


{{-- rename group modal start --}}
    <div class="custom-modal-box">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="create-group-form no-padding">
                        <h4>Rename Group</h4>
                        <div class="chat-room-head group-room-header p-0 bg-transparent" style="position: inherit; box-shadow: none;">
                            <div class="media p-0" style="padding: 0!important">
                                @isset( $currentGroup->avatar )
                                    <span id="groupImageView" class="user-name-avatar me-2 d-none"></span>
                                    <img id="groupImagePreview" src="{{ asset($currentGroup->avatar) }}" alt="{!! strtoupper($currentGroup->name[0]) !!}" class="img-fluid big-avt">
                                @else
                                    <div>
                                        <img id="groupImagePreview" src="" class="img-fluid d-none big-avt">
                                        <span id="groupImageView" class="user-name-avatar me-2 big-avt">{!! strtoupper($currentGroup->name[0]) !!}</span>
                                    </div>
                                @endisset

                                <div class="media-body">
                                    <h5 class="name"> {{ $currentGroup->name }} </h5>
                                    <ul class="peoples">
                                        @if( $currentGroup->participants )
                                            @foreach ($currentGroup->participants as $participant)
                                                <li>
                                                    @isset( $participant->user->avatar )
                                                        <img src="{{ asset( $participant->user->avatar ) }}" alt="{{ $participant->user->name }}" class="img-fluid">
                                                    @else
                                                        <span class="user-name-avatar">{!! strtoupper($participant->user->name[0]) !!}</span>
                                                    @endisset

                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('messages.update.group') }}" method="POST" id="updateGroup" class="mt-2">
                            @csrf
                            <div class="form-group mt-0">
                                <label for="">Group Name</label>
                                <input autocomplete="off" type="text" placeholder="Group Name" class="form-control" name="name" value="{{ $currentGroup->name ? $currentGroup->name : old('name') }}"/>
                                <input type="hidden" class="form-control" name="groupId" value="{{ $currentGroup->id }}"/>
                            </div>

                            <div class="form-group mt-1">
                                <label for="">Group Avater</label>
                                <input id="uploadGroupAvatar" type="file" class="form-control" name="avatar" accept="image/*" />
                            </div>
                            {{-- form submit --}}
                            <div class="form-submit">
                                <button class="btn btn-cancel" data-bs-dismiss="modal" type="reset">Cancel</button>
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
                <div class="create-group-form text-center no-padding">
                    <img src="{{ asset('assets/images/icons/messages/err.svg') }}" alt="a" class="img-fluid">
                    <h4 class="border-0 pb-0 mt-4">Delete This Group</h4>
                    <p>Are you sure you want to delete this group?</p>
                    <form action="{{ route('messages.delete.group') }}" method="POST" id="deleteGroup">
                        @csrf
                        <input type="hidden" class="form-control" name="groupId" value="{{ $currentGroup->id }}"/>
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


<script>
    $(document).ready(function () {
        var fileInput = document.getElementById('uploadGroupAvatar');

        if (fileInput) {
            $(fileInput).on('change', function (event) {
                var file = event.target.files[0];
                if (file) {
                    var objectUrl = URL.createObjectURL(file);
                    if (document.getElementById('groupImagePreview').classList.contains("d-none")) {
                        document.getElementById('groupImagePreview').classList.remove('d-none');
                        document.getElementById('groupImageView').classList.add('d-none');
                    }
                    document.getElementById('groupImagePreview').src = objectUrl;

                }
            });
        }
    });
</script>
