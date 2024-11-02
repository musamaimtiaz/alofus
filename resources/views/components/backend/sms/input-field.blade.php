<div class="form-group row">
    <label class="col-sm-3 control-label require">{{ $title }}</label>

    <div class="col-sm-8">
        <input type="text"
            value="{{ isset($gateway->data[$key]) ? $gateway->data[$key] : '' }}"
            class="form-control inputFieldDesign" name="{{ $key }}" required
            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
    </div>
</div>
