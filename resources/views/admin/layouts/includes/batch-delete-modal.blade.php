<div class="modal fade" id="batchDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title confirmDeleteLabel">{{ __('Batch Delete') }}</h5>
                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
            </div>
            <div class="modal-body">
                {{ __('Are you sure to delete this?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn custom-btn-submit confirmDeleteSubmitBtn batch-delete-operation">{{ __('Yes, Confirm') }}</button>
            </div>
        </div>
    </div>
</div>
