<li class="clearfix cursor-pointer inbox-receiver" id="shop_{{ $chat->receiver->id }}"
    data-url="{{ route('chat.getConversations', ['thread_id' => base64_encode($chat->id)]) }}">
    <img class="user-msg-img" src="{{ $chat->receiver->fileUrl() }}" />
    <div class="about">
        <a class="user-name name chat-with-user text-left" data-value="{{ optional($chat->receiver)->id }}"
            data-url="{{ route('chat.getConversations', ['thread_id' => base64_encode($chat->id)]) }}">{{ optional($chat->receiver)->name }}</a>
        <div class="status">
        </div>
        <div>
        </div>
    </div>
</li>
