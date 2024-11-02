<div id="confirmDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Delete page') }}</h5>
                <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure to delete this page?') }}</p>
                <form action="#" id="internal_form" method="post">
                    @csrf
                    <input type="hidden" name="data" id="data">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="py-2 custom-btn-cancel"
                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" id="confirmDeleteSubmitBtn" data-task="1"
                    class="btn py-2 custom-btn-submit delete-section-btn">{{ __('Yes, Confirm') }}
                </button>
                <span class="ajax-loading"></span>
            </div>
        </div>
    </div>
</div>
