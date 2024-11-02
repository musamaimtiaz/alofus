@if ($change == '&#8734;')
    <small class="ml-2 f-20 text-success">{!! $change !!}</small>
@elseif ($change != null)
    <small class="ml-2 f-14 {{ $change >= 0 ? 'text-success' : 'text-red' }}">(
        @if ($change > 0)
            <i class="feather icon-trending-up"></i>
        @else
            <i class="feather icon-trending-down"></i>
        @endif
        {{ $change . '%' }})
    </small>
@endif
