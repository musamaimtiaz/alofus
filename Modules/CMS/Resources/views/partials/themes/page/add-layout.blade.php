{{-- Add Layout --}}
<div id="add-layout" class="modal fade display_none" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add :x', ['x' => __('Layout')]) }}</h4>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <form action="{{ route('theme.layout.store') }}" method="post" class="form-horizontal">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label require" for="name">{{ __('Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="name" placeholder="{{ __('Name') }}" id="name" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <div class="form-group row">
                        <label for="btn_save" class="col-sm-3 control-label"></label>
                        <div class="col-sm-12">
                            <button type="submit"
                                    class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                            <button type="button" class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

