@foreach ($notifications as $notification)
<li>
    <a href="{{ !empty($notification->data['url']) ? route('site.notifications.view', ['id' => $notification->id, 'url' => $notification->data['url']]) : '' }}" class="block pt-[15px] pb-[14px] mx-[13px] border-b border-b-[#DFDFDF] {{ empty($notification->data['url']) ? 'cursor-default' : '' }}">
        <span class="flex gap-[13px]">
             <span class="block">
                <img class="w-[30px] h-[30px] rounded-full" src="{{ asset($notification->type::$image) }}" alt="{{ __('Image') }}" />
             </span>
             <span class="block flex-1">
                <p class="font-medium">
                    {{ $notification->data['label'] ?? '' }}
                </p>
                <span class="text-[12px] text-[#2C2C2C] leading-[16px] font-medium block">                                    
                    {{ $notification->data['message'] }}
                </span>
                <span class="text-[10px] text-[#898989] leading-[16px] font-medium mt-[7px] block">{{ timeToGo($notification->created_at, false, 'ago') }}</span>
             </span>
        </span>
    </a>
</li>
@endforeach
