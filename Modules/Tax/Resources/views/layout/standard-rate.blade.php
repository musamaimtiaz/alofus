
    <div class="noti-alert pad no-print warningMessage mt-2 px-2">
        <div class="alert warning-message abc">
            <strong id="warning-msg" class="msg"></strong>
        </div>
    </div>
    <div class="row px-4">
        <div class="col-sm-12 p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-main">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Country') }}</th>
                            <th scope="col">{{ __('State') }}</th>
                            <th scope="col">{{ __('City') }}</th>
                            <th scope="col">{{ __('Post code') }}</th>
                            <th width="100" scope="col">{{ __('Rate') }} %</th>
                            <th width="100" scope="col">{{ __('Priority') }}</th>
                            <th width="5" scope="col">{{ __('Compound') }}</th>
                            <th width="5" scope="col">{{ __('Shipping') }}</th>
                            <th width="5" scope="col">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tax_rates as $rate)
                            <tr>
                                <td>
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="tax_class_id" value="{{ $rate->tax_class_id }}">
                                    <input type="text" class="form-control" name="name" value="{{ $rate->name }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control geolocale-country" list="country-list" maxlength="30" name="country" value="{{ empty($rate->country) ? '*' : $rate->country }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control geolocale-state" list="state-list" maxlength="30" name="state" value="{{ empty($rate->state) ? '*' : $rate->state }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" maxlength="30" name="city" value="{{ empty($rate->city) ? '*' : $rate->city }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" maxlength="10" name="postcode" value="{{ empty($rate->postcode) ? '*' : $rate->postcode }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control positive-float-number" maxlength="16" name="tax_rate" value="{{ formatCurrencyAmount($rate->tax_rate) }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control positive-int-number" maxlength="11" name="priority" value="{{ $rate->priority }}">
                                </td>
                                @php
                                    $randCompound = mt_rand();
                                    $randShipping = mt_rand();
                                @endphp
                                <th>
                                    <div>
                                        <div class="switch switch-bg m-r-10">
                                            <input type="checkbox" name="compound" class="checkActivity" id="switch-{{ $randCompound }}" value="{{ $rate->compound }}" {{ $rate->compound == 1 ? 'checked' : '' }}>
                                            <label for="switch-{{ $randCompound }}" class="cr"></label>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div>
                                        <div class="switch switch-bg m-r-10">
                                            <input type="checkbox" name="shipping" class="checkActivity" id="switch-{{ $randShipping }}" value="{{ $rate->shipping }}" {{ $rate->shipping == 1 ? 'checked' : '' }}>
                                            <label for="switch-{{ $randShipping }}" class="cr"></label>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    <span class="text-dark cursor_pointer delete-button action-btn d-flex justify-content-center" title="{{ __('Delete Tax Rate') }}">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="10">{{ __('No tax rate found.') }}</td>
                            </tr>
                        @endforelse

                        <tr>
                            <td colspan="10" class="pt-3">
                                <button type="button" data-id="1" class="btn custom-btn-submit btn-sm add-btn">{{ __('Add New') }}</button>
                                @if ($tax_rates->count())
                                    <button type="submit" data-id="1" class="btn custom-btn-submit btn-sm update-btn">{{ __('Save') }}</button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

