@php
    $path = "instructor";
    $path = auth()->user()->user_role;
    if (auth()->user()->user_role == 'student') {
        $path = "students";
    }
@endphp

@extends('layouts.latest.' . $path)

@section('title')
Message Page
@endsection

{{-- page style @S --}}
@section('style')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{ asset('assets/admin-css/message.css') }}" rel="stylesheet" type="text/css">
<style>
    .message-list-page-wrap {
        font-family: 'Poppins', sans-serif !important;
    }

    .emojionearea.form-control.chat-message-input-single.emojionearea-inline {
        height: 3.5rem !important;
        border-radius: 0.5rem !important;
        border: 1px solid var(--neutral-30, #E5ECF6) !important;
        background: var(--neutral-white, #FFF) !important;
        padding: 0.625rem 0.875rem !important;
        box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05) !important;
        color: var(--neutral-60, #66768E) !important;
        font-size: 1rem !important;
        font-style: normal !important;
        font-weight: 400 !important;
        line-height: 1.5rem !important;
        position: relative !important;
    }

    .emojionearea-button {
        position: absolute !important;
        right: 128px !important;
        top: 15px !important;
    }

    .emojionearea.emojionearea-inline>.emojionearea-editor {
        height: 3rem!important;
        min-height: 3rem!important;
        top: 11px!important;
        left: 12px!important;
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
                            <h1>Messages <span>{{ count($users) + count($groups) }}</span></h1>

                            {{-- create group box start --}}
                            @if( $adminInfo->user_role !== 'student')
                                <a class="btn btn-primary create-toggle" data-bs-toggle="collapse" href="#collapseExample"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('assets/images/icons/m-user.svg') }}" alt="ic"
                                        class="img-fluid"> Create Group
                                </a>
                            @else
                            <div class="create-toggle"></div>
                            @endif
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="create-group-form pt-0">
                                <h4>Create Group</h4>

                                @include('e-learning.course.instructor.group-admin.admin-info')

                                <form method="post" class="createGroup" action="{{ route('messages.group') }}">
                                    <div class="form-group mt-2">
                                        <label for="">Group Name</label>
                                        <input autocomplete="off" type="text" placeholder="Group Name" class="form-control" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Add People</label>
                                        <input autocomplete="off" type="text" placeholder="Name"
                                            class="form-control search-group-chat-user">
                                        <input class="addUserId" type="hidden" name="user_id">
                                        <img src="{{ asset('assets/images/icons/search.svg') }}" alt="a"
                                            class="img-fluid">
                                    </div>
                                    {{-- suggested name box --}}
                                    <div class="suggested-name-box load-suggested-people"></div>
                                    {{-- suggested name box --}}

                                    {{-- person list box start --}}
                                    <div class="person-box-list person-tab-body load-chat-user-for-group"
                                        id="load-chat-user-for-group"></div>
                                    {{-- person list box end --}}

                                    {{-- form submit --}}
                                    <div class="form-submit form-group-submit">
                                        <button type="reset" class="btn btn-cancel"
                                            id="btn-cancel-group">Cancel</button>
                                        <button type="submit" class="btn btn-create"
                                            id="btn-create-group">Create</button>
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
                                <img src="{{ asset('assets/images/icons/search-m.svg') }}" alt="ic"
                                    class="img-fluid">
                                <input autocomplete="off" type="text" placeholder="Search" class="form-control search-chat-user">
                            </div>
                            <div class="chat-filter">
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('assets/images/icons/filter-2.svg') }}" alt="ic"
                                            class="img-fluid"> All Chat
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item active chats" href="javascript:;">All Chat</a></li>
                                        <li><a class="dropdown-item groups" href="javascript:;">Groups</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- chat filter --}}

                        {{-- leftbar person list start --}}
                        <div class="person-tab-body position-box-body">
                            {{-- single person start --}}
                            <div class="chat-user-load user-list-boxxs" id="chat-user-load">
                                @include('e-learning.course.instructor.message-group.group-list')
                                @include('e-learning.course.instructor.chat-user.search-users')
                            </div>
                            {{-- single person end --}}
                        </div>
                        {{-- leftbar person list end --}}
                    </div>
                    {{-- leftbar side end --}}

                    {{-- chat body right side start --}}
                    <div class="chat-main-body-box">
                        {{-- chat body list start --}}
                        <div class="main-chat-room">
                            <div id="chat-message" class="main-chat-inner-room">
                                <div class="blank-chat-page">
                                    <i class="fa-regular fa-circle-user"></i>
                                    <h3>Select a person or group to start a chat</h3>
                                </div>
                            </div>

                            {{-- typing status --}}
                            <div class="typing-status-area" id="indicator-append"></div>
                            <div class="typing-status-area" id="group-indicator-append"></div>

                        </div>

                        <form method="POST" class="send-actions w-100 d-none" id="chatMessage" autocomplete="off">
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
                                        <input autocomplete="off" type="text"
                                            class="form-control chat-message-input-single chat-emoji-input"
                                            id="chat-message-input" placeholder="Send a message" name="message">
                                    </div>
                                    <div class="file-attach-bttns">
                                        <label for="attached" class="message-attached">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </label>
                                        <input type="file" name="file" class="d-none" id="attached"
                                            onchange="displayFileName()">
                                        {{-- <button class="btn btn-submit" onclick="removeFile()" type="submit"> --}}
                                            <button class="btn btn-submit" type="submit">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" class="send-actions w-100 d-none" id="groupChatMessage" autocomplete="off">
                            <div class="dock-bottom">
                                <div id="group-file-preview" class="file-preview">
                                    <img src="" alt="" class="preview-image img-fluid" id="group-preview-image">
                                    <div class="preview-actions">
                                        <span id="group-file-type-icon"></span>
                                        <span class="close-icon" id="group-close-icon" onclick="removeGroupFile()">✖</span>
                                    </div>
                                </div>

                                <div class="message-send-box">
                                    <div class="form-group">
                                        <input autocomplete="off" type="text"
                                            class="form-control chat-message-input-group chat-gruop-emoji"
                                            id="chat-group-message-input" placeholder="Send a message" name="message"/>
                                    </div>
                                    <div class="file-attach-bttns">
                                        <label for="group-attached" class="message-attached me-2">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </label>
                                        <input type="file" name="file" class="d-none" id="group-attached"
                                            onchange="displayGroupFileName()">
                                        <button class="btn btn-submit" type="submit">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    {{-- chat body right side end --}}
                </div>
            </div>
        </div>
    </div>
</main>
{{-- ==== message list page @E ==== --}}

{{-- add specific person to group modal start --}}
<div class="custom-modal-box">
    <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModal4Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="create-group-form no-padding">
                    <h4>Create Group</h4>
                    @include('e-learning.course.instructor.group-admin.admin-info')
                    <form method="post" class="createGroupModal" action="{{ route('messages.group') }}">
                        <div class="form-group">
                            <label for="">Group Name</label>
                            <input autocomplete="off" type="text" placeholder="Group Name" class="form-control" name="name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Add People</label>
                            <input autocomplete="off" type="text" placeholder="Name" class="form-control search-group-chat-user">
                            <input class="addUserId" type="hidden" name="user_id">
                            <img src="{{ asset('assets/images/icons/search.svg') }}" alt="a" class="img-fluid">
                        </div>
                        {{-- suggested name box --}}
                        <div class="suggested-name-box load-suggested-people"></div>
                        {{-- suggested name box --}}
                        {{-- person list box start --}}
                        <div class="person-box-list person-tab-body load-chat-user-for-group"
                            id="load-chat-user-for-group"></div>
                        {{-- person list box end --}}
                        {{-- form submit --}}
                        <div class="form-submit">
                            <button type="reset" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-create">Create</button>
                        </div>
                        {{-- form submit --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- add specific person to group modal end --}}
@php
$user = auth()->user();
$userAvatar = $user->avatar ? asset($user->avatar) : "";
$alterAvatar = strtoupper($user->name[0]);
$userName = $user->name;
$createTime = now()->format('D H:i a');
@endphp


@endsection
{{-- page content @E --}}

@section('script')
<script>
    // Search single chat user

$(document).on("input",".search-group-chat-user", function (e) {
    searchUser(this.value, ".load-chat-user-for-group", "layout1");
});

// Search people for specific group on modal
$(document).on("input", ".search-people-specific-group", function (e) {
    searchUser(this.value, ".fetch-people-for-specificgroup", "layout1");
});

// Search group chat user
$(document).on("keyup",".search-chat-user", function (e) {
    var searchTerm = (this.value || "").trim();
    searchUser(searchTerm, ".chat-user-load", "layout2");
});


// Search group
$(document).on("keyup",".search-chat-user", function (e) {
    var searchTerm = (this.value || "").trim();
    searchUser(searchTerm, ".chat-user-load", "layout3");
});


$(document).ready(function () {
    $(".create-group-by-user").on("click", function (e) {
        var userId = $(this).closest('.single-person').attr('id').split('_')[1];
        loadSuggestedPeople(userId, '.load-suggested-people', '.addUserId');
    });
});



// Search User
function searchUser(searchTerm, resultContainer, layout) {

    $.ajax({
        url: "{{ route('messages.search') }}",
        type: 'GET',
        data: {
            term: searchTerm,
            layout: layout
        },
        beforeSend: function () {
            $("#mySpinner").removeClass('d-none');
            $(".load-chat-user-for-group").empty();
        },
        success: function (data) {
            $(resultContainer).html(data);
            $("#mySpinner").addClass('d-none');
        }
    });

}

// Load suggested user
var existsUsers = [];
$(document).on('click', '.suggest-people', function () {
    var userId = $(this).attr('id');
    loadSuggestedPeople(userId, '.load-suggested-people', '.addUserId');
});


function loadSuggestedPeople(userId, container, input) {
    $.ajax({
        type: "get",
        url: "{{ route('messages.suggested.people') }}",
        data: { userId: userId },
        success: function (data) {
            if ($.inArray(userId, existsUsers) === -1) {
                existsUsers.push(userId);
                $(container).append(data);
                $(input).val(function (_, currentValues) {
                    return currentValues ? currentValues + ',' + userId : userId;
                });
            } else {
                toastr.error('User already exists!!', 'Error');
            }
        }
    });
}

// Remove suggested people
$(document).on('click', '.remove-suggested-people', function () {
    var userId = $(this).closest(".suggest-user").attr('id');
    userId = parseInt(userId, 10);
    var indexToRemove = existsUsers.indexOf(userId.toString());
    if (indexToRemove !== -1) {
        existsUsers.splice(indexToRemove, 1);

        $(".addUserId").val(existsUsers.join(','));
    }
    $('#' + userId).remove();
});

// Delete single chat history
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('deleteChatMsg')) {
        event.stopPropagation();
        var userId = event.target.getAttribute('data-chat-user-id');

        $.ajax({
            type: 'get',
            url: "{{ route('messages.delete.singlechat') }}",
            data: {
                userId: userId
            },
            success: function (data) {
                toastr.success(data.success, 'Success');
                $('#single-chat-message-wrap').empty();
                $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
});


// Load groups click by group button
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('groups')) {
        event.stopPropagation();
        $.ajax({
            type: 'get',
            url: "{{ route('messages.groups') }}",
            success: function (data) {
                $("#chat-user-load").empty();
                $("#chat-user-load").html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });

    }
});

// Load click click by chat button
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('chats')) {
        event.stopPropagation();
        $.ajax({
            type: 'get',
            url: "{{ route('messages.chats') }}",
            success: function (data) {
                $("#chat-user-load").empty();
                $("#chat-user-load").html(data);
            },
            error: function (error) {
                console.error(error);
            }
        });

    }
});

// Delete group chat history
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('deleteGroupChatMsg')) {
        event.stopPropagation();
        var groupId = event.target.getAttribute('data-group-id');

        $.ajax({
            type: 'get',
            url: "{{ route('messages.delete.groupchat') }}",
            data: { groupId: groupId },
            success: function (data) {
                $('#group-chat-message-wrap').empty();
                $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
                toastr.success(data.success, 'Success');
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
});


// Add People to Groupe
$(document).on('submit', '#addPeopleToGroup', function () {
    event.preventDefault();
    var formData = new FormData($('#addPeopleToGroup')[0]);
    var groupId = formData.get('groupId');
    $.ajax({
        type: "post",
        url: "{{ route('messages.group.add.people') }}",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            $('#addPeopleToGroup')[0].reset();
            $('#exampleModal').modal('hide');
            $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
            $(".load-suggested-people").empty();
        },
        error: function (jqXHR, status, err) {
            // Handle error if needed
        }
    });
});


// Update group
$(document).on('submit', '#updateGroup', function () {
    event.preventDefault();
    var formData = new FormData($('#updateGroup')[0]);
    var groupId = formData.get('groupId');
    $.ajax({
        type: "post",
        url: "{{ route('messages.update.group') }}",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            $('#updateGroup')[0].reset();
            $('#exampleModal2').modal('hide');
            $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
            fetchGroupData(groupId)
        },
        error: function (jqXHR, status, err) {
            // Handle error if needed
        }
    });
});

// Delete group
$(document).on('submit', '#deleteGroup', function () {
    event.preventDefault();
    var formData = new FormData($('#deleteGroup')[0]);
    var groupId = formData.get('groupId');
    $.ajax({
        type: "post",
        url: "{{ route('messages.delete.group') }}",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            $('#group-chat-message-wrap').empty();
            $('#exampleModal3').modal('hide');
            $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
            $("#chat-message").load(location.href + " #chat-message>*", "");
            $("#groupChatMessage").addClass('d-none')
            toastr.success(data.success, 'Success');
        },
        error: function (jqXHR, status, err) {
            // Handle error if needed
        }
    });
});


$(document).on('click', '.user', function () {

    scrollToBottomFunc();
    $('.user').removeClass('active');
    $('.group').removeClass('active');
    $(this).addClass('active');
    $(this).find('.pending').remove();

    var user_receive_id = $(this).attr('id');
    receiver_id = user_receive_id.split('_')[1];
    $.ajax({
        type: "get",
        url: "{{ route('messages.chat') }}",
        data: {
            receiver_id: receiver_id
        },
        cache: false,
        success: function (data) {
            $('#chat-message').html(data);
            scrollToBottomFunc();
        },
        complete: function () {
            $("#groupChatMessage").addClass("d-none");
            $("#chatMessage").removeClass("d-none").fadeIn("slow");
        }
    });
});

// Show group message
$(document).on('click', '.group', function () {
    $('.group').removeClass('active');
    $('.user').removeClass('active');
    $(this).addClass('active');
    $(this).find('.pending').remove();

    var group_id = $(this).attr('id');
    receiver_id = group_id.split('_')[1];
    fetchGroupData(receiver_id);
    scrollToBottomFunc();
});

function fetchGroupData(receiver_id){
    $.ajax({
        type: "get",
        url: "{{ route('messages.group.chat') }}",
        data: {
            receiver_id: receiver_id
        },
        cache: false,
        success: function (data) {
            $('#chat-message').html(data);

            setTimeout(function() {
                $("#group_" + receiver_id).addClass("active");
            }, 500);

            scrollToBottomFunc();
        },
        complete: function () {
            $("#chatMessage").addClass("d-none");
            $("#groupChatMessage").removeClass("d-none").fadeIn("slow");
        }
    });
}

function getUserList(){
    $.ajax({
        url: "{{ route('messages.users') }}",
        method: 'get',
        success: function(data) {
            $("#chat-user-load").html(data);
        },
        error: function(error) {
            console.error('Error fetching user list:', error);
        }
    });
}

</script>

<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";

$(document).ready(function () {
    // ajax setup form csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Set pusher key
    var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: 'ap2',
        forceTLS: true
    });


    // <<<<<========== User Online Activity ===============>>>>>

    // var channel = pusher.subscribe('my-channel');

    // // Presence channel events
    // channel.bind('pusher:subscription_succeeded', function(members) {
    //     members.each(function(member) {
    //         // Update your UI to show online users
    //     });
    // });

    // channel.bind('pusher:member_added', function(member) {
    //     // Update your UI to show online users
    // });

    // channel.bind('pusher:member_removed', function(member) {
    //     // Update your UI to show offline users
    // });

    // // Your existing code for handling other events
    // channel.bind('my-event', function(data) {
    //     // Handle your existing messaging events
    // });


    // <<<<<========== User Online Activity ===============>>>>>



    // Typing indicator

    $(document).ready(function() {

        const indicatorAppendElement = $('#indicator-append');

        const startTyping = (user) => {

            const newUserMessageItem = $('<div>').addClass('message-item-wrap');
            const assetUrl = "{{ asset('') }}";
            const avatarUrl = user.avatar ? `${assetUrl}/${user.avatar}` : '';
            const avatarContent = user.avatar ? `<img src="${avatarUrl}" alt="${user.name} Avatar" class="img-fluid">` : `<span class="user-name-avatar">${user.name[0].toUpperCase()}</span>`;

            newUserMessageItem.html(`
                <div class="message-item">
                    <div class="media main-media">
                        <div class="avatar">
                            ${avatarContent}
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="media-body">
                            <div class="d-flex">
                                <h6>${user.name}</h6>
                            </div>
                            <div class="typing">
                                <i class="fa-solid fa-ellipsis fa-fade"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Append the new message item to the designated container
            if (indicatorAppendElement.length) {
                if (user.id == receiver_id) {
                    indicatorAppendElement.html(newUserMessageItem);
                }
            }

        };

        const stopTyping = (user) => {
            indicatorAppendElement.find('.message-item').remove();
        };


        $(document).on('click', '.user', function () {

            var user_receive_id = $(this).attr('id');
            receiver_id = user_receive_id.split('_')[1];
            const indicatorChannel = `private-typing-channel-${my_id}-${receiver_id}`;
            // const indicator = pusher.subscribe(indicatorChannel);


            const indicator = pusher.subscribe('typing-channel');

            indicator.bind('typing-started', (data) => {
                startTyping(data.user_info);
            });

            indicator.bind('typing-stopped', (data) => {
                stopTyping(data.user_info);
            });


            // indicator.bind('group-typing-started', (data) => {
            //     const typingUsers = data.typing_users || {};
            //     for (const userId in typingUsers) {
            //         if (typingUsers.hasOwnProperty(userId)) {
            //             startTyping(typingUsers[userId]);
            //         }
            //     }
            // });

            // indicator.bind('group-typing-stopped', (data) => {
            //     const typingUsers = data.typing_users || {};
            //     for (const userId in typingUsers) {
            //         if (typingUsers.hasOwnProperty(userId)) {
            //             stopTyping(typingUsers[userId]);
            //         }
            //     }
            // });


        });



    });

    // One to one Chat typing indicator
    const routeStart = "{{ route('messages.typing.start') }}";
    const routeStop = "{{ route('messages.typing.stop') }}";

    $(document).on("input",".chat-message-input-single", () => sendTypingEvent('start'));
    $(document).on("blur",".chat-message-input-single", () => sendTypingEvent('stop'));

    const sendTypingEvent = (action) => {
        const route = action === 'start' ? routeStart : routeStop;
        $.ajax({
            method: 'POST',
            url: route,
            data: { receiver_id: receiver_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                // Handle success if needed
            },
            error: (error) => {
                // Handle error if needed
            },
        });
    };


    // Send group type event
    const routeGroupStart = "{{ route('messages.group.typing.start') }}";
    const routeGroupStop = "{{ route('messages.group.typing.stop') }}";

    $(document).on("input",".chat-message-input-group", () => sendGroupTypingEvent('start'));
    $(document).on("blur",".chat-message-input-group", () => sendGroupTypingEvent('stop'));

    const sendGroupTypingEvent = (action) => {
        const route = action === 'start' ? routeGroupStart : routeGroupStop;
        $.ajax({
            method: 'POST',
            url: route,
            data: { receiver_id: receiver_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                // Handle success if needed
            },
            error: (error) => {
                // Handle error if needed
            },
        });
    };



    // Close typing indicator
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function (data) {
        if (my_id == data.from) {
            // $('#user_' + data.to).click();
        } else if (my_id == data.to) {
            if (receiver_id == data.from) {
                $('#user_' + data.from).click();
            } else {
                // If the receiver is not selected, add a notification for that user
                var pending = parseInt($('#user_' + data.from).find('.pending').html());

                if (pending) {
                    $('#user_' + data.from).find('.pending').html(pending + 1);
                } else {
                    $('#user_' + data.from).append('<span class="pending">1</span>');
                }
            }
        }

        if (data.signal === 'update-user-list') {
            getUserList();
        }
    });


    $(document).ready(function () {
        var channelGroup = pusher.subscribe(my_id);
        channelGroup.bind('App\\Events\\Notify', function (data) {

            receiver_id = data.from;





            if (my_id == data.from) {

                // $('#group_' + data.from).click();

            } else if (my_id == data.to) {

                if (receiver_id == data.from) {
                    $('#group_' + data.from).click();
                } else {
                    var pending = parseInt($('#group_' + data.from).find('.pending').html());
                    if (pending) {
                        $('#group_' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#group_' + data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });
    });
});


// Send one to one chate

$(document).on('keydown', '#chat-message-input', function (e) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        insertData();
    }
});


$(document).on('submit', '#chatMessage', function (e) {
    e.preventDefault();
    sendMessage();
});

// Send group message
$(document).on('submit', '#groupChatMessage', function (e) {
    e.preventDefault();
    sendGroupMessage();
});




$(document).on('submit', '.createGroup', function (e) {
    e.preventDefault();
    createGroup(".createGroup");
});

$(document).on('submit', '.createGroupModal', function (e) {
    e.preventDefault();
    createGroup(".createGroupModal");
});

// Send one to on chat message
function sendMessage(event) {

    initalImage = $('#preview-image').attr('src');

    var messageText = $("#chat-message-input").data("emojioneArea").getText();

    var messageInnner = $("#chat-message");

    var formData = new FormData($('#chatMessage')[0]);
    formData.append("receiver_id", receiver_id);
    formData.append("message", messageText);
    $('#chat-message-input').data("emojioneArea").setText("");

    var avatarContent = {!! json_encode($userAvatar) !!};
    var alterAvatar = {!! json_encode($alterAvatar) !!}
    var userName = {!! json_encode($userName) !!};
    var createTime = {!! json_encode($createTime) !!};

    var imageElement = '';
    if (initalImage) {
        imageElement = `<a href="${initalImage}" data-lightbox="image-1" data-title="dsfdsf">
                            <img src="${initalImage}" class="img-fluid initailImage">
                        </a>`;
        $('#preview-image').attr('src', '');
    }

    var imageElement = initalImage
    ? `<a href="${initalImage}" data-lightbox="image-1" data-title="dsfdsf">
        <img src="${initalImage}" class="img-fluid initailImage">
      </a>`
    : '';

    var avatarElement = avatarContent
    ? `<img src="${avatarContent}" class="img-fluid">`
    : `<span class="user-name-avatar">${alterAvatar}</span>`;


    var myLastMessage = `<div class="message-item sender-item">
            <div class="media main-media">
                <div class="avatar">
                    ${avatarElement}
                    <i class="fas fa-circle"></i>
                </div>
                <div class="media-body">
                    <div class="d-flex">
                        <h6 class="open-profile">${userName} &nbsp; </h6>
                        <span> ${createTime} </span>
                    </div>
                    <div class="text">
                        ${imageElement}
                        <p>${messageText}</p>
                    </div>
                </div>
            </div>
        </div>`;


    if (messageText.trim() !== '' || imageElement.trim() !== '') {

            var messageAppended = true;
            getSenderUserDetails(my_id).then(function (userDetails) {
                if (userDetails.recivingMessage === "0") {
                    messageAppended = false;
                    toastr.warning(userDetails.message, { positionClass: 'toast-bottom-right' });
                }
            });

            getUserDetails(receiver_id).then(function (userDetails) {
                if (userDetails.recivingMessage === "0") {
                    messageAppended = false;
                    toastr.error(userDetails.message, { positionClass: 'toast-bottom-right' });
                }
            });

            if( messageAppended){
                messageInnner.append(myLastMessage);
            }
    }

    removeFile();

    if (receiver_id !== '') {
        $.ajax({
            type: "post",
            url: "{{ route('messages.chat') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {

            },
            success: function (data) {
                $('#chatMessage')[0].reset();
                scrollToBottomFunc();
            },
            error: function (jqXHR, status, err) {
                // Handle error if needed
            }
        });
    }
}


function getUserDetails(receiver_id) {
    return $.ajax({
        type: "get",
        url: "{{ route('messages.user.details') }}",
        data: { receiver_id: receiver_id },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (data) {
            return data;
        },
        error: function (jqXHR, status, err) {
            console.error("Error fetching user details:", status, err);
        }
    });
}

function getSenderUserDetails(my_id) {
    return $.ajax({
        type: "get",
        url: "{{ route('messages.sender.user.details') }}",
        data: { sender_id: my_id },
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (data) {
            return data;
        },
        error: function (jqXHR, status, err) {
            console.error("Error fetching user details:", status, err);
        }
    });
}

function sendGroupMessage() {
    var messageText = $("#chat-group-message-input").data("emojioneArea").getText();
    var formData = new FormData($('#groupChatMessage')[0]);
    formData.append("receiver_id", receiver_id);
    formData.append("message", messageText);
    $('#chat-group-message-input').data("emojioneArea").setText("");
    removeGroupFile();
    if (receiver_id !== '') {
        $.ajax({
            type: "post",
            url: "{{ route('messages.group.chat') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                $('#groupChatMessage')[0].reset();
                scrollToBottomFunc();
            },
            error: function (jqXHR, status, err) {
                // Handle error if needed
            }
        });
    }
}

// Create Group
function createGroup(formSelector) {
    document.querySelector('.position-box-body').classList.remove('d-none');
    var formData = new FormData($(formSelector)[0]);
    $.ajax({
        type: "post",
        url: "{{ route('messages.group') }}",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if (data.error) {
                toastr.error(data.error, 'Error');
                return;
            }
            if (data.success) {
                toastr.success(data.success, 'Success');
                $(formSelector)[0].reset();
                existsUsers = [];
                $(".addUserId").val('');
            }

            $(".load-suggested-people").empty();
            $(".load-chat-user-for-group").empty();
            $('#exampleModal4').modal('hide');
            $("#chat-user-load").load(location.href + " #chat-user-load>*", "");
            fetchGroupData(data.groupId);

        },
        error: function (jqXHR, status, err) {
            toastr.error('Something went wrong!', 'Error');

        },
        complete: function () {
            scrollToBottomFunc();
        }
    });
}

// make a function to scroll down auto
function scrollToBottomFunc() {
    $('.main-chat-inner-room').animate({
        scrollTop: $('.main-chat-inner-room').get(0).scrollHeight
    }, 50);
}


function setupEmojiArea(inputSelector, formSelector) {
    $(inputSelector).emojioneArea({
        events: {
            keydown: function(editor, event) {
                if (event.which == 13) {
                    $(formSelector).submit();
                }
            }
        }
    });
}

$(document).ready(function() {
    setupEmojiArea("#chat-message-input", "#chatMessage");
    setupEmojiArea("#chat-group-message-input", "#groupChatMessage");
});



</script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

{{-- toggle of group create form shwo hide --}}
<script>

    const toggleBttn = document.querySelector('.create-toggle');
    const headerFilter = document.querySelector('.header-filter');
    const positionBody = document.querySelector('.position-box-body');
    const userList = document.querySelector('.person-tab-body.chat-user-load');

    toggleBttn.addEventListener('click', function (e) {
        headerFilter.classList.toggle('active');
        positionBody.classList.toggle('d-none');
    });


    const collapseExamples = document.querySelector('#collapseExample');
    const groupCancelBttn = document.querySelector('#btn-cancel-group');
    const groupCreateBttn = document.querySelector('#btn-create-group');

    function groupShowHide(){
        // userList.classList.remove('active');
        headerFilter.classList.remove('active');
        collapseExamples.classList.remove('show');
    }

    groupCancelBttn.addEventListener('click', function (e) {
        groupShowHide();
    });

    groupCreateBttn.addEventListener('click', function (e) {
        setTimeout(function () {
            groupShowHide();
        }, 1000);
    });

</script>


{{-- open profile box--}}
<script>
    $(document).on('click','.own-profile', function () {
        $('#profileBox').addClass('active');
    });

    $(document).on('click','#closeProfile', function () {
        $('#profileBox').removeClass('active');
    });

</script>


{{-- show upload image preview --}}
<script>
    function displayGroupFileName() {
        var input = document.getElementById('group-attached');
        var fileName = input.files[0].name;

        var fileNameElement = document.getElementById('chat-group-message-input');
        fileNameElement.placeholder = fileName;

        var filePreview = document.getElementById('group-file-preview');
        filePreview.style.display = 'flex';

        document.getElementById('group-close-icon').style.display = 'inline-block';

        var fileTypeIcon = document.getElementById('group-file-type-icon');
        if (fileName.endsWith('.pdf')) {
            fileTypeIcon.innerHTML = '<img src="pdf-icon.png" alt="PDF">';
        } else {
            var previewImage = document.getElementById('group-preview-image');
            previewImage.src = URL.createObjectURL(input.files[0]);
        }
    }

    function displayFileName() {
        var input = document.getElementById('attached');
        var fileName = input.files[0].name;

        var fileNameElement = document.getElementById('chat-message-input');
        fileNameElement.placeholder = fileName;

        var filePreview = document.getElementById('file-preview');
        filePreview.style.display = 'flex';

        document.getElementById('close-icon').style.display = 'inline-block';

        var fileTypeIcon = document.getElementById('file-type-icon');
        if (fileName.endsWith('.pdf')) {
            fileTypeIcon.innerHTML = '<img src="pdf-icon.png" alt="PDF">';
        } else {
            var previewImage = document.getElementById('preview-image');
            previewImage.src = URL.createObjectURL(input.files[0]);
        }
        removeGroupFile();
    }

    function removeGroupFile() {
        var input = document.getElementById('group-attached');
        input.value = '';
        var filePreview = document.getElementById('group-file-preview');
        filePreview.style.display = 'none';

        var fileNameElement = document.getElementById('chat-group-message-input');
        fileNameElement.placeholder = 'Send a message';

        document.getElementById('group-close-icon').style.display = 'none';
    }

    function removeFile() {
        // alert('stop');
        var input = document.getElementById('attached');
        input.value = '';
        var filePreview = document.getElementById('file-preview');
        filePreview.style.display = 'none';

        var fileNameElement = document.getElementById('chat-message-input');
        fileNameElement.placeholder = 'Send a message';

        document.getElementById('close-icon').style.display = 'none';
    }

</script>

@endsection
