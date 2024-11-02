@extends('admin.layouts.app')
@section('page_title', __('Commission'))
@section('css')
    {{-- Select2  --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">

@endsection
@section('content')
    <div class="col-sm-12" id="commission-container">
        <div class="row">
            <div class="col-md-3">
                @include('admin.layouts.includes.finance_menu')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5><a href="{{ route('commission.index') }}">{{ __('Commission') }}</a></h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="form-tabs">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase">{{ __(':x Information', ['x' => __('Commission')]) }}</a>
                                </li>
                            </ul>
                            <div class="tab-content box-shadow-unset" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <form action="{{ route('commission.store') }}" method="post" class="form-horizontal">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="is_commission_active" class="col-sm-4 control-label">{{ __('Activation') }}</label>
                                            <div class="col-sm-4 margin-neg-top-05">
                                                <div class="switch d-inline m-r-10">
                                                    <input type="checkbox" name="is_commission_active" id="is_commission_active" {{ isset($commission->is_active) && $commission->is_active == 1 ? 'checked' : '' }}>
                                                    <label for="is_commission_active" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="is_category_based" class="col-sm-4 control-label">{{ __('Category Based') }}</label>
                                            <div class="col-sm-4 margin-neg-top-05">
                                                <div class="switch d-inline m-r-10">
                                                    <input type="checkbox" name="is_category_based" id="is_category_based" {{ isset($commission->is_category_based) && $commission->is_category_based == 1 ? 'checked' : '' }}>
                                                    <label for="is_category_based" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label require" for="amount">{{ __('Commission') }} (%)</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control positive-float-number" name="amount" id="amount" required max="100" data-max="{{ __('The value not more than be :x', ['x' => 100]) }}" oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" value="{{ isset($commission->amount) ? formatCurrencyAmount($commission->amount) : null }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <span class="badge badge-danger">{{ __('Note') }}!</span>
                                    </div>
                                    <div class="col-sm-8">
                                            <li>{{ __(':x of seller product price will be deducted from seller earnings.', ['x' => ($commission->amount ?? 0) . '%']) }}</li>
                                    </div>
                                </div>
                                <div class="col-sm-8 px-0">
                                    <button class="btn btn-primary custom-btn-small" type="submit" id="submitBtn"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Submit') }}</span></button>
                                </div>
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
    <script src="{{ asset('public/dist/js/custom/commission.min.js') }}"></script>
@endsection
