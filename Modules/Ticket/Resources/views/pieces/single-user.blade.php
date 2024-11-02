<div class="chat-sidebar-user {{ $contact->lastMessage->is_read ? '' : 'chat-inbox-unread' }}"
    id="shop_{{ optional($vendor)->id }}"
    data-url="{{ route('chat.getConversations', ['thread_id' => base64_encode($contact->id)]) }}">
    <div class="chat-sidebar-user-img">
        <img
            src="{{ $contact->sendByMe() ? optional(optional($vendor)->logo)->fileUrl() : optional($contact->sender)->fileUrl() }}" />
    </div>
    <div class="chat-sidebar-user-details">
        <div class="chat-sidebar-user-name">
            {{ $contact->sendByMe() ? optional($vendor)->name : optional($contact->sender)->name }}</div>
        @php
            $stripped_message = trimWords(strip_tags($contact->lastMessage->message), 20);
        @endphp
        @if ($contact->lastMessage)
            <div class="chat-sidebar-user-text">
                @if ($contact->lastMessage->sender_id == auth()->id())
                    {{ __('You') }}:
                @endif
                {{ $stripped_message }}
            </div>
        @endif
    </div>
</div>
