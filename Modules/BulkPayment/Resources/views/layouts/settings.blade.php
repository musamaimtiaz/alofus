<div class="form-group row">
    <label class="col-sm-3 pt-3 pt-md-2 control-label text-left require" for="bulk_pay_count">{{ __('Bulk Pay Count') }}</label>
    <div class="col-sm-6">
        <div class="mr-3">
                <input class="form-control inputFieldDesign" id="bulk_pay_count" type="text" name="bulk_pay_count" value="{{ !is_null(preference('bulk_pay_count')) ? preference('bulk_pay_count') : '' }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
        </div>
        
        <span class="help-block">{{ __('It will be measured how many order will payable at a time.') }}</span>
    </div>
</div>
@php
$paymentMethod = (new Modules\Gateway\Entities\GatewayModule)->payableGateways();
$preferenceBulkPayment = json_decode(preference('disable_bulk_payment'), true) ?? [];
$accessUserRole = json_decode(preference('bulk_payment_user_role'), true) ?? [];
$roles = \App\Models\Role::getAll();
@endphp
<div class="form-group row">
    <label class="col-sm-3 control-label text-left" for="disable_bulk_payment">{{ __('Disable bulk order payment method') }}</label>
    <div class="col-sm-6 form-group flex-wrap">
        <input type="hidden" name="disable_bulk_payment" value="{{ null }}">
        <select class="form-control js-example-basic-single form-height sl_common_bx select2" name="disable_bulk_payment[]" id="disable_bulk_payment" multiple>
            @foreach($paymentMethod as $method) 
                <option value="{{ $method->alias }}" {{ in_array($method->alias, $preferenceBulkPayment) ? 'selected' : '' }}>{{ $method->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 control-label text-left" for="bulk_payment_user">{{ __('Access user role for bulk order payment') }}</label>
    <div class="col-sm-6 form-group flex-wrap">
        <input type="hidden" name="bulk_payment_user_role" value="{{ null }}">
        <select class="form-control js-example-basic-single form-height sl_common_bx select2" name="bulk_payment_user_role[]" id="bulk_payment_user_role" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected(in_array($role->id, $accessUserRole))>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</div>
