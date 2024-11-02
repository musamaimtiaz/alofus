<div class="item-card">
    <div class="item-image">
        <img src="{{$item->getFeaturedImage('medium')}}" alt="{{ __('Image') }}">
    </div>
    <div class="item-content">
        <div class="item-title">{{ $item->name }}</div>
        <div class="item-details">
            {{ $item->summary }}
        </div>
    </div>
    <div class="item-footer">
        <a
            href="{{ route('site.productDetails', ['slug' => $item->slug]) }}">{{ __('View Item') }}</a>
    </div>
</div>
