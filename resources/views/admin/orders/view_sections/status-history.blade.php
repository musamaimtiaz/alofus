@if(count($orderStatusHistories) > 0)
    <div class="card">
        <div class="order-sections-header accordion cursor_pointer">
            <span>{{ __('Status history') }}</span>
            <span class="order-icon drop-down-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                    <path d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z" fill="#2C2C2C"/>
                </svg>
            </span>
        </div>
        <div class="order-sections-body">
            @foreach ($orderStatusHistories->groupBy('product_id') as $product_id => $histories)
                <div class="card">
                    <div class="order-sections-header accordion cursor_pointer">
                        <span class="text-dark">{{ trimWords($histories->first()->lineItem->product_name, 25) }}</span>
                        <span class="order-icon drop-down-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                                <path d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z" fill="#2C2C2C"/>
                            </svg>
                        </span>
                    </div>
                    <div class="order-sections-body">
                        @foreach ($histories as $history)
                            <div class="order-notes">
                                <span class="underline cursor_default">{{ __('Order status changed to :x by :y', ['x' => optional($history->orderStatus)->name, 'y' => optional($history->user)->name ?? __('Automatic')]) }} .</span>
                            </div>
                            <div class="date-delete-container mb-3">
                                <span class="date underline cursor_default">{{ $history->format_created_at }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
