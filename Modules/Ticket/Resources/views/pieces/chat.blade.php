<div class="chat-view-inbox">
    <div class="chat-inbox-header">
        <div class="chat-inbox-header-text">{{ $chat->sendByMe() ? $chat->vendorName : optional($chat->sender)->name }}
            <input type="hidden" class="chat-identifier" value="{{ $chat->id }}">
        </div>
        <div class="chat-inbox-header-button">
            <div class="chat-inbox-sidebar-toggle">
                <svg class="chat-message-icon m-0 neg-transition-scale" id="Capa_1" enable-background="new 0 0 461.516 461.516"
                    height="512" viewBox="0 0 461.516 461.516" width="512" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path
                            d="m185.746 371.332c41.251.001 81.322-13.762 113.866-39.11l122.778 122.778c9.172 8.858 23.787 8.604 32.645-.568 8.641-8.947 8.641-23.131 0-32.077l-122.778-122.778c62.899-80.968 48.252-197.595-32.716-260.494s-197.594-48.252-260.493 32.716-48.252 197.595 32.716 260.494c32.597 25.323 72.704 39.06 113.982 39.039zm-98.651-284.273c54.484-54.485 142.82-54.486 197.305-.002s54.486 142.82.002 197.305-142.82 54.486-197.305.002c-.001-.001-.001-.001-.002-.002-54.484-54.087-54.805-142.101-.718-196.585.239-.24.478-.479.718-.718z" />
                    </g>
                </svg>
            </div>
            <div class="chat-inbox-sidebar-reload"
                data-url="{{ route('chat.getConversations', ['thread_id' => base64_encode($chat->id)]) }}">
                <svg class="chat-message-icon m-0 neg-transition-scale" height="512" viewBox="0 0 512 512" width="512"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="Solid">
                        <path
                            d="m464.022 232h-.022a24 24 0 0 0 -23.98 24.021 184.063 184.063 0 0 1 -289.527 150.688c-83.1-58.188-103.369-173.136-45.181-256.237s173.137-103.372 256.237-45.182a184.078 184.078 0 0 1 34.012 30.71h-67.54a24 24 0 0 0 0 48h112a24 24 0 0 0 24-24v-112a24 24 0 0 0 -48 0v39.967a234.175 234.175 0 0 0 -26.94-22 231.982 231.982 0 1 0 -266.119 380.061 230.285 230.285 0 0 0 132.567 42.015 234.971 234.971 0 0 0 40.776-3.585 232.025 232.025 0 0 0 191.716-228.479 24 24 0 0 0 -23.999-23.979z" />
                    </g>
                </svg>
            </div>
        </div>
    </div>
    <div class="chat-inbox-body">
        <div class="chat-inbox-loader-overlay">
            <span class="loader-container">
                <span class="icon-spinner"></span>
            </span>
        </div>
        <ul class="chat-inbox-message-list">
            @php
                $messages = $messages->reverse();
            @endphp
            @foreach ($messages as $message)
                @include('ticket::pieces.single-message')
            @endforeach
        </ul>
    </div>
    <form class="chat-inbox-footer" action="{{ route('chat.store-message') }}" id="message-form" method="post"
        enctype="multipart/form-data">
        <div class="chat-error-message">
            <ul>
            </ul>
        </div>
        <div class="chat-inbox-input-group">
            <div class="chat-inbox-attachment-input">
                <label for="attachment-msg">
                    <svg type="file" class="chat-message-icon m-0 chat-inbox-send-attachment-icon neg-transition-scale" id="Layer_1"
                        enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="m256 0c-141.158 0-256 114.841-256 256s114.841 256 256 256 256-114.841 256-256-114.841-256-256-256zm158.486 257.929-126.971 126.971c-22.111 22.11-51.165 33.167-80.208 33.169-29.051.003-58.091-11.054-80.207-33.169-44.226-44.227-44.226-116.188 0-160.415l107.246-107.246c31.044-31.043 81.557-31.043 112.601 0 14.985 14.985 23.238 34.979 23.238 56.3s-8.253 41.315-23.239 56.301l-104.935 104.934c-8.93 8.93-20.664 13.395-32.393 13.396-11.732.002-23.461-4.464-32.392-13.396-17.861-17.861-17.861-46.924 0-64.785l104.384-104.385c4.687-4.686 12.284-4.686 16.971 0 4.686 4.687 4.687 12.284 0 16.971l-104.384 104.384c-8.503 8.504-8.503 22.34 0 30.844 8.504 8.503 22.34 8.503 30.844 0l104.935-104.935c10.453-10.453 16.209-24.42 16.209-39.33 0-14.909-5.756-28.877-16.209-39.329-21.687-21.686-56.973-21.686-78.659 0l-107.246 107.247c-34.869 34.869-34.869 91.604 0 126.474 34.868 34.866 91.604 34.868 126.474 0l126.97-126.971c4.687-4.686 12.284-4.686 16.971 0 4.686 4.686 4.686 12.284 0 16.97z" />
                    </svg>
                </label>
                <input type="file" name="attach" id="attachment-msg">
            </div>
            <div class="chat-inbox-text-input">
                <textarea name="inbox_message" id="message-to-send" placeholder="{{ __('Type your message') }}.." rows="1"></textarea>
            </div>
        </div>
        <div class="chat-inbox-send-button">
            <svg class="chat-message-icon m-0 chat-inbox-send-attachment-icon has-loader-effect neg-transition-scale" width="18"
                height="19" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 17" fill="none">
                <path
                    d="M2.03224 4.00618L3.91996 7.26679C4.20305 7.75578 4.3446 8.00027 4.3446 8.26886C4.3446 8.53745 4.20305 8.78195 3.91996 9.27094L2.03223 12.5315C0.780122 14.6943 0.154065 15.7757 0.634302 16.3157C1.11454 16.8558 2.26167 16.3605 4.55594 15.3697L4.55596 15.3697L16.748 10.105C18.5678 9.31919 19.4776 8.9263 19.4776 8.26886C19.4776 7.61143 18.5678 7.21853 16.748 6.43274L4.55596 1.16798C2.26168 0.177271 1.11454 -0.318085 0.634302 0.221992C0.154065 0.76207 0.780122 1.84344 2.03224 4.00618Z">
                </path>
            </svg>
            <span class="loader-container">
                <span class="icon-spinner"></span>
            </span>
        </div>
    </form>
</div>
