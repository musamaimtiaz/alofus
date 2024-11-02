<div class="form-group row">
    <label for="is_default"
        class="col-sm-3 control-label">{{ __('Is Default?') }}</label>
    <div class="col-9 d-flex">
        <div class="ltr:me-3 rtl:ms-3">
            <input type="hidden" name="is_default" value="0">
            <div class="switch switch-bg d-inline m-r-10">
                <input type="checkbox" name="is_default"
                    class="checkActivity" id="is_default"
                    value="1"
                    {{ config('notification.default_sms_gateway') == $provider ? 'checked' : '' }}>
                <label for="is_default" class="cr"></label>
            </div>
        </div>
    </div>
</div>
