@if (!empty($contacts))
    <div class="chat-sidebar-users">
        @foreach ($contacts as $contact)
            @php
                $vendor = $contacts->vendors->where('user_id', $contact->receiver_id)->first();
                $chatUserId = auth()->id() == $contact->receiver_id ? 'user_' . $contact->sender_id : 'shop_' . $contact->receiver_id;
            @endphp
            <div class="chat-sidebar-user {{ (isset($chat) && $contact->id == $chat->id) || ((isset($active) && $active == $chatUserId)) ? 'chat-user-active' : '' }} {{ $contact->lastMessage->receiver_id == auth()->id() && $contact->lastMessage->is_read == 0 ? 'chat-inbox-unread' : '' }}"
                id="{{ $chatUserId }}"
                data-url="{{ route('chat.getConversations', ['thread_id' => base64_encode($contact->id)]) }}">
                <div class="chat-sidebar-user-img">
                    <img class="chat-sidebar-img"
                        src="{{ $contact->sendByMe() ? optional(optional($vendor)->logo)->fileUrl() : optional($contact->sender)->fileUrl() }}" />
                </div>
                <div class="chat-sidebar-user-details">
                    <div class="chat-sidebar-user-name">
                        {{ $contact->sendByMe() ? optional($vendor)->name : optional($contact->sender)->name }}</div>
                    @php
                        $stripped_message = strip_tags($contact->lastMessage->message);
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
        @endforeach
    </div>
@endif
