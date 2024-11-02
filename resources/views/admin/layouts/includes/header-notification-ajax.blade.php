@foreach ($notifications as $notification)
    <li class="notification cursor_default pt-0 pb-0">
        <a href="{{ !empty($notification->data['url']) ? route('notifications.view', ['id' => $notification->id, 'url' => $notification->data['url']]) : '' }}" class="py-0 {{ empty($notification->data['url']) ? 'cursor_default' : '' }}">
            <div class="media">
                <img src="{{ asset($notification->type::$image) }}" alt="Generic placeholder image">
                <div class="media-body">
                    <p><strong>{{ $notification->data['label'] ?? '' }}</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>{{ timeToGo($notification->created_at, false, 'ago') }}</span></p>
                    <p class="text-muted aero">{{ $notification->data['message'] }}</p>
                </div>
            </div>
        </a>        
    </li>
    <hr class="m-0">
@endforeach
