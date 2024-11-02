<div class="modal fade" id="addAttribute" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAttributeLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="attribute-form">
                    <div class="form-row">
                        <label for="attribute_name" class="col-md-12"></label>
                        <input type="text" name="attribute_value" placeholder="{{ __('New value') }}"
                            class="newAttributeValue form-control col-md-12">
                        <input type="hidden" name="attribute_id" class="targetAttrId">
                        <input type="hidden" class="sectionId">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger custom-btn-small" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" id="confirmAttributeSubmit" data-task="" class="btn btn-primary custom-btn-small has-spinner-loader mr-0" data-bs-dismiss="modal">{{ __('Add New') }}</button>
                <span class="ajax-loading"></span>
            </div>
        </div>
    </div>
</div>