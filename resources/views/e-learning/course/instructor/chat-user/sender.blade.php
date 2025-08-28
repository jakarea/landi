@if ( $user )
    <div class="message-item sender-item">
        <div class="media main-media">
            <div class="avatar">
                @isset( $user->avatar )
                    <img src="{{ asset($user->avatar) }}" class="img-fluid" alt="{!! strtoupper($user->name[0]) !!}">
                @else
                    <span class="user-name-avatar">{!! strtoupper($user->name[0]) !!}</span>
                @endisset
                <i class="fas fa-circle"></i>
            </div>
            <div class="media-body">
                <div class="d-flex">
                    <h6 class="open-profile">{{ $user->name }} &nbsp; </h6>
                    <span> {{ $user->created_at->format('F j, Y') }}
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
@endif
