{{-- Edit City --}}
<div id="edit-city" class="modal fade display_none" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit :x', ['x' => __('City')]) }}</h4>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <form method="post" id="edit_city"
                class="form-horizontal">
                @csrf
                <div class="ajax-content">
                    <input type="hidden" name="country_id" id="country_id">
                    <input type="hidden" name="division_id" id="division_id">
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label require" for="name">{{ __('Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="name" placeholder="{{ __('Name') }}" id="name" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="full_name">{{ __('Full Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="full_name" placeholder="{{ __('Full Name') }}" id="full_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="code">{{ __('Code') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="code" placeholder="{{ __('Code') }}" id="code">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="iana_timezone">{{ __('Timezone') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="iana_timezone" placeholder="{{ __('Timezone') }}" id="iana_timezone">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <div class="form-group row">
                        <label for="btn_save" class="col-sm-3 control-label"></label>
                        <div class="col-sm-12">
                            <button type="submit"
                                    class="btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Update') }}</button>
                            <button type="button" class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

