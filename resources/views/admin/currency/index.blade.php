@extends('admin.layouts.app')
@section('page_title', __('Currency'))
@section('css')
    {{-- Data table --}}
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
    {{-- Select2  --}}
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="currency-settings-container">
        <div class="row">
            <div class="col-md-3">
                @include('admin.layouts.includes.finance_menu')
            </div>
            <div class="col-md-9">
                <div class="card card-info">
                    @if (session('errorMgs'))
                        <div class="alert alert-warning fade in alert-dismissable">
                            <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close"
                                href="#" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                    @endif
                    <span id="smtp_head">
                        <div class="card-header">
                            <h5><a href="{{ route('currency.index') }}">{{ __('Finance') }} </a> >> {{ __('Currencies') }}
                            </h5>
                            @if (in_array('App\Http\Controllers\CurrencyController@store', $prms))
                                <div class="card-header-right">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-currency"
                                        class="btn btn-outline-primary custom-btn-small"><span class="fa fa-plus">
                                            &nbsp;</span>{{ __('New Currency') }}</a>
                                </div>
                            @endif
                        </div>
                    </span>
                    <div class="card-body">
                        <div class="row p-l-15">
                            <div class="table-responsive">
                                <table id="dataTableBuilder"
                                    class="table table-bordered table-hover table-striped dt-responsive">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Symbol') }}</th>
                                            <th>{{ __('Rate') }}</th>
                                            @if (array_intersect(
                                                    [
                                                        'App\Http\Controllers\CurrencyController@edit',
                                                        'App\Http\Controllers\CurrencyController@update',
                                                        'App\Http\Controllers\CurrencyController@destroy',
                                                    ],
                                                    $prms))
                                                <th width="5%">{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencyData as $currency)
                                            <tr>
                                                <td>{{ $currency->name }}</td>
                                                <td>{{ $currency->symbol }}</td>
                                                <td>{{ formatCurrencyAmount($currency->exchange_rate) }}</td>
                                                @if (array_intersect(
                                                        ['App\Http\Controllers\CurrencyController@edit', 'App\Http\Controllers\CurrencyController@destroy'],
                                                        $prms))
                                                    <td>
                                                        @if (in_array('App\Http\Controllers\CurrencyController@edit', $prms))
                                                            <a title="{{ __('Edit Currency') }}" href="javascript:void(0)"
                                                                class="btn btn-xs btn-primary edit_currency"
                                                                data-toggle="modal" data-target="#edit-currency"
                                                                id="{{ $currency->id }}"><span
                                                                    class="feather icon-edit neg-transition-scale-svg "></span></a>
                                                            &nbsp;
                                                        @endif

                                                        @if (in_array('App\Http\Controllers\CurrencyController@destroy', $prms))
                                                            <form method="POST"
                                                                action="{{ route('currency.delete', $currency->id) }}"
                                                                accept-charset="UTF-8"
                                                                id="delete-currency-{{ $currency->id }}"
                                                                class="display_inline">
                                                                {!! csrf_field() !!}
                                                                <input type="hidden" name="id"
                                                                    value="{{ $currency->id }}">
                                                                <button title="{{ __('Delete') }}"
                                                                    class="btn btn-xs btn-danger"
                                                                    data-id="{{ $currency->id }}" type="button"
                                                                    data-bs-toggle="modal" data-bs-target="#confirmDelete"
                                                                    data-label="Delete"
                                                                    data-title="{{ __('Delete Currency') }}"
                                                                    data-message="{{ __('Are you sure to delete this Currency?') }}">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary custom-btn-small"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" id="confirmDeleteSubmitBtn" data-task=""
                            class="btn btn-danger custom-btn-small">{{ __('Submit') }}</button>
                        <span class="ajax-loading"></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="add-currency" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Add New') }} &nbsp; </h4>
                        <p class="ltr:float-right rtl:float-left p-t-5"><span
                                class="badge badge-success">{{ __('Home Currency') }} &nbsp;{{ currency()->name }}</span>
                        </p>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <form action="{{ route('currency.store') }}" method="post" id="addCurrency" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label require" for="inputEmail3">{{ __('Name') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="{{ __('Name') }}" class="form-control name"
                                        name="name" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label require"
                                    for="inputEmail3">{{ __('Symbol') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="{{ __('Symbol') }}" class="form-control"
                                        name="symbol" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0 "
                                    for="inputEmail3">{{ __('Exchange Rate') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="{{ __('Exchange Rate') }}"
                                        class="form-control positive-float-number" name="exchange_rate" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="exchange_from">{{ __('Exchange From') }}</label>
                                <div class="col-sm-6">
                                    <select class="form-control js-example-basic-single-1" name="exchange_from"
                                        id="add_exchange_from">
                                        <option value='local'>{{ __('local') }}</option>
                                        <option value="api">{{ __('api') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-0">
                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="btn btn-primary custom-btn-small ltr:float-right rtl:float-left">{{ __('Submit') }}</button>
                                    <button type="button"
                                        class="btn btn-secondary custom-btn-small ltr:float-right rtl:float-left"
                                        data-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div id="edit-currency" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Edit Currency') }} &nbsp;</h4>
                        <p class="ltr:float-right rtl:float-left p-t-5"><span
                                class="badge badge-success">{{ __('Home Currency') }} &nbsp;{{ currency()->name }}</span>
                        </p>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <form action="{{ route('currency.update') }}" method="post" id="editCurrency"
                        class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <input type="hidden" name="curr_id" id="curr_id">

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require" for="curr_name">{{ __('Name') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="{{ __('Name') }}"
                                        id="curr_name" name="name" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label require"
                                    for="curr_symbol">{{ __('Symbol') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="{{ __('Symbol') }}"
                                        id="curr_symbol" name="symbol" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="exchange_rate">{{ __('Exchange Rate') }}</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control positive-float-number"
                                        placeholder="{{ __('Exchange Rate') }}" id="exchange_rate" name="exchange_rate"
                                        required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="exchange_from">{{ __('Exchange From') }}</label>
                                <div class="col-sm-6">
                                    <select class="js-example-basic-single-2 form-control" name="exchange_from"
                                        id="exchange_from">
                                        <option value='local'>{{ __('local') }}</option>
                                        <option value="api">{{ __('api') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-0">
                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="btn btn-primary custom-btn-small ltr:float-right rtl:float-left">{{ __('Submit') }}</button>
                                    <button type="button"
                                        class="btn btn-secondary custom-btn-small ltr:float-right rtl:float-left"
                                        data-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/finance.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
