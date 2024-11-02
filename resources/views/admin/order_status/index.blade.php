@extends('admin.layouts.app')
@section('page_title', __('Order Statuses'))
@section('css')
    {{-- Data table --}}
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="order-status-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-3 ltr:ps-1 ltr:ps-lg-3 ltr:pe-0 rtl:pe-1 rtl:pe-lg-3 rtl:ps-0">
                    @include('admin.layouts.includes.order_settings_menu')
                </div>
                <div class="col-lg-9 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('errorMgs'))
                            <div class="alert alert-warning fade in alert-dismissable">
                                <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close"
                                    href="#" data-bs-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        <div class="card-header p-t-20 border-bottom order-header" id="smtp_head">
                            <h5>{{ __('Status') }}</h5>
                            @if (in_array('App\Http\Controllers\OrderStatusController@store', $prms))
                                <div class="card-header-right">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-status"
                                        class="btn btn-outline-primary custom-btn-small"><span class="fa fa-plus">
                                            &nbsp;</span>{{ __('Add :x', ['x' => __('Status')]) }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-2 p-md-4 product-table">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="dataTableBuilder" class="table table-hover table-striped dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Color') }}</th>
                                                <th>{{ __('Payment Scenario') }}</th>
                                                <th>{{ __('Order By') }}</th>
                                                <th>{{ __('Default') }}</th>
                                                @if (array_intersect(
                                                        ['App\Http\Controllers\OrderStatusController@edit', 'App\Http\Controllers\OrderStatusController@destroy'],
                                                        $prms))
                                                    <th>{{ __('Action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderStatuses as $status)
                                                <tr>
                                                    <td>{{ $status->name }}</td>
                                                    <td>{!! $status->roleName($status->role) !!}</td>
                                                    <td>
                                                        <div class="h-40" style="background: {{ $status->color }}"></div>
                                                    </td>
                                                    <td>{{ $status->payment_scenario }}</td>
                                                    <td>{{ $status->order_by }}</td>
                                                    <td>{{ $status->is_default == 1 ? __('Yes') : __('No') }}</td>
                                                    @if (array_intersect(
                                                            ['App\Http\Controllers\OrderStatusController@edit', 'App\Http\Controllers\OrderStatusController@destroy'],
                                                            $prms))
                                                        <td>
                                                            @if (in_array('App\Http\Controllers\OrderStatusController@edit', $prms))
                                                                <a title="{{ __('Edit') }}" href="javascript:void(0)"
                                                                    class="btn btn-xs btn-primary edit_status"
                                                                    data-bs-toggle="modal" data-bs-target="#edit-status"
                                                                    id="{{ $status->id }}"><span
                                                                        class="feather icon-edit neg-transition-scale-svg "></span></a>
                                                                &nbsp;
                                                            @endif

                                                            @if (in_array('App\Http\Controllers\OrderStatusController@destroy', $prms) &&
                                                                    $status->is_default != 1 &&
                                                                    !in_array($status->slug, coreStatusSlug()))
                                                                <form method="POST"
                                                                    action="{{ route('orderStatues.delete', $status->id) }}"
                                                                    accept-charset="UTF-8"
                                                                    id="delete-language-{{ $status->id }}"
                                                                    class="display_inline">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $status->id }}">
                                                                    <button title="{{ __('Delete') }}"
                                                                        class="btn btn-xs btn-danger"
                                                                        data-id="{{ $status->id }}" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#confirmDelete" data-label="Delete"
                                                                        data-title="{{ __('Delete :x', ['x' => __('Status')]) }}"
                                                                        data-message="{{ __('Are you sure to delete this?') }}">
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
        </div>
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel"></h5>
                        <a type="button" class="close h5" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </a>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="py-2 custom-btn-cancel"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" id="confirmDeleteSubmitBtn" data-task=""
                            class="btn py-2 ltr:ms-2 rtl:me-2 custom-btn-submit">{{ __('Yes, Confirm') }}</button>
                        <span class="ajax-loading"></span>
                    </div>
                </div>
            </div>
        </div>

        <div id="add-status" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Add New') }} &nbsp; </h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orderStatues.store') }}" method="post" id="addStatus"
                            class="form-horizontal">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require" for="inputEmail3">{{ __('Name') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}"
                                        class="form-control name inputFieldDesign" name="name" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0 "
                                    for="inputEmail3">{{ __('Role') }}</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2-hide-search sl_common_bx" name="role_ids[]"
                                        id="role_id" multiple required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require">{{ __('Color') }}</label>

                                <div class="col-sm-6">
                                    <input type="color" value="{{ old('color') }}" class="form-control"
                                        name="color">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require"
                                    for="inputEmail3">{{ __('Order By') }}</label>

                                <div class="col-sm-6">
                                    <input type="number" placeholder="{{ __('Order By') }}"
                                        value="{{ old('order_by') }}" class="form-control inputFieldDesign"
                                        name="order_by" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="payment_scenario">{{ __('Pay. Scenario') }}</label>
                                <div class="col-sm-6">
                                    <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx"
                                        name="payment_scenario" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="unpaid"
                                            {{ old('payment_scenario') == 'unpaid' ? 'selected' : '' }}>
                                            {{ __('Unpaid') }}</option>
                                        <option value="paid" {{ old('payment_scenario') == 'paid' ? 'selected' : '' }}>
                                            {{ __('Paid') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="is_default">{{ __('Default') }}</label>
                                <div class="col-sm-6">
                                    <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx"
                                        name="is_default" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="0" {{ old('is_default') == '0' ? 'selected' : '' }}>
                                            {{ __('No') }}</option>
                                        <option value="1" {{ old('is_default') == '1' ? 'selected' : '' }}>
                                            {{ __('Yes') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                                    <button type="button"
                                        class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit-status" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Edit :x', ['x' => __('Status')]) }} &nbsp;</h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('orderStatues.update') }}" method="post" id="editTax"
                            class="form-horizontal">
                            @csrf
                            <input type="hidden" name="status_id" id="status_id">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label require"
                                    for="status_name">{{ __('Name') }}</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control inputFieldDesign"
                                        placeholder="{{ __('Name') }}" id="status_name" name="name" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require"
                                    for="inputEmail3">{{ __('Order By') }}</label>

                                <div class="col-sm-6">
                                    <input type="number" placeholder="{{ __('Order By') }}"
                                        value="{{ old('order_by') }}" class="form-control inputFieldDesign"
                                        name="order_by" id="status_orderBy" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="role_id">{{ __('Role') }}</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2-hide-search sl_common_bx" name="role_ids[]"
                                        id="status_role_id" multiple required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require">{{ __('Color') }}</label>

                                <div class="col-sm-6">
                                    <input type="color" value="{{ old('color') }}" class="form-control"
                                        name="color" id="status_color">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="payment_scenario">{{ __('Pay. Scenario') }}</label>
                                <div class="col-sm-6">
                                    <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx"
                                        name="payment_scenario" id="payment_scenario" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="unpaid">{{ __('Unpaid') }}</option>
                                        <option value="paid">{{ __('Paid') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label require pr-0"
                                    for="status_is_default">{{ __('Default') }}</label>
                                <div class="col-sm-6">
                                    <select class="js-example-basic-single-2 form-control select2-hide-search"
                                        name="is_default" id="status_is_default">
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Yes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left">{{ __('Update') }}</button>
                                    <button type="button"
                                        class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/order_status.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
