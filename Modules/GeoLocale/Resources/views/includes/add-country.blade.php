{{-- Add Country --}}
<div id="add-country" class="modal fade display_none" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add :x', ['x' => __('Country')]) }}</h4>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <form action="{{ route('country.store') }}" method="post" id="add_country"
                class="form-horizontal">
                @csrf
                <div class="ajax-content">
                    <input type="hidden" name="continent_id" value="1">
                    <input type="hidden" name="has_division" value="1">
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label require" for="name">{{ __('Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="name" placeholder="{{ __('Name') }}" id="name"
                                required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                minlength="3" data-min-length="{{ __(':x should be at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="full_name">{{ __('Full Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="full_name" placeholder="{{ __('Full Name') }}"
                                id="full_name"
                                minlength="3" data-min-length="{{ __(':x should be at least :y characters.', ['x' => __('Full Name'), 'y' => 3]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="capital">{{ __('Capital') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="capital" placeholder="{{ __('Capital') }}" id="capital"
                            pattern="[a-zA-Z-.' ]*$" data-pattern="{{ __("Only alphabet, [- ' .] and white space are allowed.") }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label require" for="code">{{ __('Code') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="code" placeholder="{{ __('Code') }}" id="code" maxlength="2"
                                required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                minlength="2" data-min-length="{{ __(':x should be at least :y characters.', ['x' => __('Code'), 'y' => 2]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="code_alpha3">{{ __('3 character code') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="code_alpha3" placeholder="{{ __('3 character code') }}" id="code_alpha3" maxlength="3"
                                minlength="3" data-min-length="{{ __(':x should be at least :y characters.', ['x' => __('3 character code'), 'y' => 3]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="code_numeric">{{ __('Numeric code') }}</label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control inputFieldDesign" name="code_numeric" placeholder="{{ __('Numeric code') }}" id="code_numeric"
                                max="999999"
                                data-max="{{ __(':x should be at most :y digits.', ['x' => __('Numeric code'), 'y' => 6]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="emoji">{{ __('Emoji') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="emoji" placeholder="{{ __('Emoji') }}" id="emoji">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="currency_code">{{ __('Currency Code') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign"
                                name="currency_code"
                                placeholder="{{ __('Currency Code') }}"
                                id="currency_code"
                                maxlength="3"
                                minlength="3"
                                data-min-length="{{ __(':x must be :y characters.', ['x' => __('Currency Code'), 'y' => 3]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="currency_name">{{ __('Currency Name') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign"
                                name="currency_name"
                                placeholder="{{ __('Currency Name') }}"
                                id="currency_name"
                                minlength="3"
                                data-min-length="{{ __(':x should be at least :y characters.', ['x' => __('Currency Name'), 'y' => 3]) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="currency_symbol">{{ __('Currency Symbol') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign"
                                name="currency_symbol"
                                placeholder="{{ __('Example') }}: ৳, $, €"
                                id="currency_symbol">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="tld">{{ __('Top Level Domain') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control inputFieldDesign" name="tld" placeholder="{{ __('Top Level Domain') }}" id="tld">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="callingcode">{{ __('Calling code') }}</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control positive-int-number inputFieldDesign" name="callingcode" placeholder="{{ __('Calling code') }}" id="callingcode"
                                maxlength="4"
                                data-max-length="{{ __(':x should be at most :y characters.', ['x' => __('Calling code'), 'y' => 4]) }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <div class="form-group row">
                        <label for="btn_save" class="col-sm-3 control-label"></label>
                        <div class="col-sm-12">
                            <button type="submit"
                                class="btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                            <button type="button" class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

