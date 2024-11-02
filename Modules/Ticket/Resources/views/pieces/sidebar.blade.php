<div class="chat-view-sidebar chat-header-sidebar-mobile">
    <div class="chat-inbox-loader-overlay">
        <span class="loader-container">
            <span class="icon-spinner"></span>
        </span>
    </div>
    @auth
        <div class="chat-sidebar-topbar">
            <input type="text" class="chat-sidebar-topbar-input" placeholder="{{ __('Type name') }}" />
        </div>
        @include('ticket::pieces.chat-userlist', ['contacts' => $contacts])
    @endauth
</div>
