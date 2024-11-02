<div class="card">
    <div class="order-sections-header accordion cursor_pointer">
        <span>{{ __('Note history') }}</span>
        <span class="order-icon drop-down-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                <path d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z" fill="#2C2C2C"/>
            </svg>
        </span>
    </div>
    <div class="order-sections-body order-notes-container">
        <div class="notes max-h-350 overflow-auto">
            @if(count($orderNotes) > 0)
                @foreach ($orderNotes as $history)
                    <div class="order-notes">
                        <span>{{ $history->note }}</span>
                    </div>
                    <div class="date-delete-container">
                        <span class="date">{{ $history->format_created_at }}</span>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="add-note-container">
            <div class="add-note">
                <span class="add-note-text">{{ __('Note') }}</span>
                <span title="{{ __('Add your personal note.') }}" class="add-note-icon neg-transition-scale">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z" fill="#898989"/>
                    </svg>
                </span>
            </div>
            <div class="add-note-text-field">
                <textarea class="form-control" name="order_note" id="order_note" rows="3"></textarea>
                <div class="trash-update">
                    <button class="w-100" id="updateNote">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
