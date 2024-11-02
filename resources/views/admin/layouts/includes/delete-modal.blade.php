<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteLabel"></h5>
          <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
          <button type="button" id="confirmDeleteSubmitBtn" data-task="" class="btn custom-btn-submit">{{ __('Yes, Confirm') }}</button>
          <span class="ajax-loading"></span>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('public/dist/js/custom/delete-modal.min.js') }}"></script>

@include('admin.layouts.includes.batch-delete-modal')
