@extends('vendor.layouts.app')
@section('page_title', __('Withdraw'))

@section('content')
    <!-- Main content -->
    <div class="list-container" id="vendor-wallet-withdraw-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5> <a href="{{ route('vendorWithdrawal.index') }}">{{ __('Withdrawal') }}</a> >> {{ __('Money') }} </h5>
                <div class="mt-md-0 mt-2">
                    <h4 class="f-w-300 mt-2">
                        {{ formatNumber(auth()->user()->wallet()->balance) }}
                    </h4>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="card-block pt-2 p-4">
                    <div class="row">
                        <div class="col-sm-7">
                            @if ($methods->count())
                            <h5 class="text-secondary mb-4">{{ ucwords(__('Send withdrawal request')) }}</h5>
                            <form action="{{ route('vendorWithdrawal.money') }}" method="post" class="form-horizontal ">
                                @csrf
                                <input type="hidden" name="currency_id" value="{{ preference('dflt_currency_id') }}">
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label require" for="payment_method">{{ __('Payment Method') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2-hide-search" id="payment_method" name="withdrawal_method_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"> >
                                            <option value="">{{ __('Select One') }}</option>
                                            @foreach ($methods as $method)
                                                <option {{ optional($method->withdrawalSetting)->is_default ? 'selected' : '' }} value="{{ $method->id }}">{{ $method->method_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 control-label require" for="amount">{{ __('Amount') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control positive-float-number inputFieldDesign" name="amount" id="amount"
                                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>

                                <div class="col-sm-8 px-0">
                                    <a href="{{ route('vendorWithdrawal.index') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                    <button class="btn custom-btn-submit" type="submit" id="submitBtn"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Submit') }}</span></button>
                                </div>
                            </form>
                            @else
                                <h4 class="py-5 text-right">{{ __('No payment method found. Please contact with admin.') }}</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
@endsection
