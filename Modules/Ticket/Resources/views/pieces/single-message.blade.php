<li class="chat-inbox-single-item {{ $message->sendByMe() ? 'chat-inbox-sent ' : 'chat-inbox-received' }}">
    <div class="chat-inbox-single-avatar">
        <img src="{{ $message->senderImage($chat) }}" />
    </div>
    <div>
        <div class="chat-inbox-single-content">
            @php
                $attachment = $message->has_attachment == 1 ? $message->fileUrl() : null;
            @endphp
            @if ($attachment)
                @php
                    $file = $message->fileNew($message->objectFile()->first()->file_id)->first();
                @endphp
                @if (in_array(strtolower($file->params['type']), ['jpg', 'jpeg', 'png']))
                    <a target="_blank" href="{{ $attachment }}">
                        <img src="{{ $attachment }}" />
                    </a>
                    <span>{{ $message->message }}</span>
                @else
                    <a class="chat-attachment" href="{{ $attachment }}">
                        <svg class="chat-message-icon" id="Layer_1" enable-background="new 0 0 512 512" height="512"
                            viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="m256 0c-141.158 0-256 114.841-256 256s114.841 256 256 256 256-114.841 256-256-114.841-256-256-256zm158.486 257.929-126.971 126.971c-22.111 22.11-51.165 33.167-80.208 33.169-29.051.003-58.091-11.054-80.207-33.169-44.226-44.227-44.226-116.188 0-160.415l107.246-107.246c31.044-31.043 81.557-31.043 112.601 0 14.985 14.985 23.238 34.979 23.238 56.3s-8.253 41.315-23.239 56.301l-104.935 104.934c-8.93 8.93-20.664 13.395-32.393 13.396-11.732.002-23.461-4.464-32.392-13.396-17.861-17.861-17.861-46.924 0-64.785l104.384-104.385c4.687-4.686 12.284-4.686 16.971 0 4.686 4.687 4.687 12.284 0 16.971l-104.384 104.384c-8.503 8.504-8.503 22.34 0 30.844 8.504 8.503 22.34 8.503 30.844 0l104.935-104.935c10.453-10.453 16.209-24.42 16.209-39.33 0-14.909-5.756-28.877-16.209-39.329-21.687-21.686-56.973-21.686-78.659 0l-107.246 107.247c-34.869 34.869-34.869 91.604 0 126.474 34.868 34.866 91.604 34.868 126.474 0l126.97-126.971c4.687-4.686 12.284-4.686 16.971 0 4.686 4.686 4.686 12.284 0 16.97z">
                            </path>
                        </svg>
                        <span class="attachment">{{ $message->message }}</span>
                    </a>
                @endif
            @else
                {!! $message->message !!}
            @endif

        </div>
        <small
            class="chat-chat-inbox-time">{{ strtotime($message->date) < strtotime('-3 days') ? $message->date : \Carbon\Carbon::parse($message->date)->diffForhumans() }}</small>
    </div>
</li>
