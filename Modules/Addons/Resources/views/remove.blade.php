<form action="{{ route('addon.remove', $alias) }}" method="post">
    @csrf
    <div class="addon-modal-body">
        <div class="addon-modal-form-row">
            <span>{{ __('Are you sure to delete this?') }}</span>
        </div>
    </div>
    <div class="addon-modal-foot rtl:gap-2">
        <button type="button" class="addon-modal-remove addon-remove-modal-close ">{{ __('Close') }}</button>
        &nbsp;
        <button class="addon-modal-submit">{{ __('Yes, Confirm') }}</button>
    </div>
</form>
