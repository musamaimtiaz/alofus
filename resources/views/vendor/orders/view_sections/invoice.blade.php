<div class="card">
    <div class="order-sections-header accordion cursor_pointer">
        <span>{{ __('Create PDF') }}</span>
        <span class="order-icon drop-down-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                <path d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z" fill="#2C2C2C"/>
            </svg>
        </span>
    </div>
    <div class="order-pdf-btn">
        <a href="{{ route('vendorInvoice.print', ['id' => $order->id, 'type' => 'print']) }}" {{ json_decode(preference('invoice'))?->general->pdf_view == 'new_tap' ? 'target="_blank"' : '' }}><button class="pdf-inv-btn">{{ __('PDF Invoice') }}</button></a>
    </div>
</div>
