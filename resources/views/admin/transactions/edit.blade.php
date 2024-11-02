@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Transaction')]))
@section('css')
{{-- Select2 --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12" id="transaction-edit-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="{{ route('transaction.index') }}">{{ __('Transactions') }}</a> >> {{ __('Edit :x', ['x' => __('Transaction')]) }}</h5>
                <div class="card-header-right">
                    <div class="d-flex ltr:me-4 rtl:ms-4 mt-2">
                        <h4 class="text-secondary ltr:me-1 rtl:ms-1 font-18 font-bold">{{ __('Status') }}: </h4>
                        @php
                            $color = ['Pending' => 'text-warning', 'Accepted' => 'text-primary', 'Rejected' => 'text-red'];
                        @endphp
                        <h4 class="{{ $color[$transaction->status] }} ms-1 font-18">{{ __($transaction->status) }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="form-tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link font-bold active text-uppercase">{{ __('Transaction Information') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('transaction.update', ['id' => $transaction->id]) }}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-7 col-12">
                                      <div class="border p-3">
                                        <div class="form-group row mt-25">
                                            <div class="col-sm-4 font-bold text-left">{{ __('User') }}</div>
                                            <div class="col-sm-8">{{ optional($transaction->user)->name }}</div>
                                        </div>
                                        <div class="form-group row mt-25">
                                            <div class="col-sm-4 font-bold text-left">{{ __('Transaction Type') }}</div>
                                            <div class="col-sm-8">{{ $transaction->transaction_type }}</div>
                                        </div>
                                        @if (!is_null(optional($transaction->order)->reference))
                                            <div class="form-group row mt-25">
                                                <div class="col-sm-4 font-bold text-left">{{ __('Reference') }}</div>
                                                <div class="col-sm-8">{{ $transaction->order->reference }}</div>
                                            </div>
                                        @endif
                                        <div class="form-group row mt-25">
                                            <div class="col-sm-4 font-bold text-left">{{ __('Currency') }}</div>
                                            <div class="col-sm-8">{{ optional($transaction->currency)->name }}</div>
                                        </div>
                                        @if ($transaction->transaction_type == 'Withdrawal')
                                            <div class="form-group row mt-25">
                                                <div class="col-sm-4 font-bold text-left">{{ __('Payment Method') }}</div>
                                                <div class="col-sm-8">{{ optional($transaction->withdrawalMethod)->method_name }}</div>
                                            </div>
                                            @php
                                                $params = (array) json_decode($transaction->user()->first()->withdrawalSettings()->where('withdrawal_method_id', $transaction->withdrawal_method_id)->first()->param);
                                            @endphp
                                            @foreach ($params as $key => $value)
                                                <div class="form-group row mt-25">
                                                    <div class="col-sm-4 font-bold text-left">{{ __(str_replace("_", " ", ucfirst($key))) }}</div>
                                                    <div class="col-sm-8">{{ $value }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="form-group row mt-25 order-details-body">
                                            <div class="col-sm-4 font-bold text-left">{{ __('Transaction Date') }}</div>
                                            <div class="col-sm-8 paid-on">
                                                {{ timeZoneFormatDate($transaction->transaction_date) }}
                                                @if ($transaction->transaction_type == 'Order')
                                                    <a href="{{ route('order.view', ['id' => $transaction->order_id]) }}" target="_blank">({{ __('View order details') }})</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row mt-25">
                                            <label class="col-sm-4 font-bold text-left" for="status">{{ __('Status') }}</label>
                                            <div class="col-sm-8">
                                                @if ($transaction->status == 'Rejected')
                                                    <div class="form-group row" id="divNote">
                                                        <div id='note_txt_1'>
                                                            <div>
                                                                <p class="font-12 bg-light-red text-white px-2 py-1 rounded ms-1">{{ __("Rejected status can't be changed") }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="w-50">
                                                        <select class="form-control select2" id="status" name="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                            <option value="">{{ __('Select One') }}</option>
                                                            <option value="Pending" {{ old('status', $transaction->status) == "Pending" ? 'selected' : ''}}>{{ __('Pending') }}</option>
                                                            <option value="Accepted" {{ old('status', $transaction->status) == "Accepted" ? 'selected' : ''}}>{{ __('Accepted') }}</option>
                                                            <option value="Rejected" {{ old('status', $transaction->status) == "Rejected" ? 'selected' : ''}}>{{ __('Rejected') }}</option>
                                                        </select>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-12 mt-3 mt-md-0 px-0">
                                            <a href="{{ route('transaction.index') }}" class="btn all-cancel-btn custom-btn-cancel">{{ __('Cancel') }}</a>
                                            @if ($transaction->status != 'Rejected')
                                                <button class="btn custom-btn-submit" type="submit" id="submitBtn"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Update') }}</span></button>
                                            @endif
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-5 mt-3 mt-md-0 col-12">
                                        <div class="border p-2">
                                            <div class="row mt-2">
                                                <div class="col-5 text-right font-bold">{{ __('Amount') }}</div>
                                                <div class="col-7">{{ formatNumber($transaction->amount, optional($transaction->currency)->symbol) }}</div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-5 text-right font-bold">{{ __('Charge') }}</div>
                                                <div class="col-7">{{ formatNumber($transaction->charge_amount, optional($transaction->currency)->symbol) }}</div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-5 text-right font-bold">{{ __('Commission') }}</div>
                                                <div class="col-7">{{ formatNumber($transaction->commission_amount, optional($transaction->currency)->symbol) }}</div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-5 text-right font-bold">{{ __('Discount') }}</div>
                                                <div class="col-7">{{ formatNumber($transaction->discount_amount, optional($transaction->currency)->symbol) }}</div>
                                            </div>
                                            <hr>
                                            <div class="row mt-2">
                                                <div class="col-5 text-right font-bold">{{ __('Total') }}</div>
                                                <div class="col-7">{{ formatNumber($transaction->total_amount, optional($transaction->currency)->symbol) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
