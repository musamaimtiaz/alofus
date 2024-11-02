@extends('admin.layouts.app')
@section('page_title', __('Languages'))
@section('css')
    {{-- Data table --}}
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="language-settings-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('errorMgs'))
                            <div class="alert alert-warning fade in alert-dismissable">
                                <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}. <a class="close"
                                    href="#" data-bs-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif

                        <div class="card-header p-t-20 border-bottom d-inline-block" id="smtp_head">
                            <h5>{{ __('Languages') }}</h5>
                            @if (in_array('App\Http\Controllers\LanguageController@store', $prms))
                                <div class="card-header-right language-header">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-language"
                                        class="btn btn-outline-primary custom-btn-small m-0 ltr:me-2 rtl:ms-2"><span
                                            class="fa fa-plus">
                                            &nbsp;</span>{{ __('Add Language') }}</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body px-2 px-md-4 product-table">
                            <div class="row p-l-15">
                                <div class="table-responsive">
                                    <table id="dataTableBuilder" class="table table-hover table-striped dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Language Name') }}</th>
                                                <th>{{ __('Short Name') }}</th>
                                                <th>{{ __('Flag') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                @if (array_intersect(
                                                        [
                                                            'App\Http\Controllers\LanguageController@translation',
                                                            'App\Http\Controllers\LanguageController@edit',
                                                            'App\Http\Controllers\LanguageController@delete',
                                                        ],
                                                        $prms))
                                                    <th>{{ __('Action') }}</th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($languageList as $language)
                                                <tr>
                                                    <td>{{ $language->name }}</td>
                                                    <td>{{ $language->short_name }}</td>
                                                    <td>
                                                        <img src='{{ url('public/datta-able/fonts/flag/flags/4x3/' . getSVGFlag($language->short_name) . '.svg') }}'
                                                            width="32">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $color = $language->status == 'Active' ? 'active_color' : 'inactive_color';
                                                        @endphp
                                                        <span
                                                            class="badge f-12 active_inactive_checking {{ $color }}">{{ $language->status }}</span>
                                                    </td>
                                                    @if (array_intersect(
                                                            [
                                                                'App\Http\Controllers\LanguageController@translation',
                                                                'App\Http\Controllers\LanguageController@edit',
                                                                'App\Http\Controllers\LanguageController@delete',
                                                            ],
                                                            $prms))
                                                        <td>
                                                            @if (in_array('App\Http\Controllers\LanguageController@translation', $prms))
                                                                <a title="{{ __('Translate language') }}"
                                                                    href="{{ route('language.translation', $language->id) }}"
                                                                    class="btn btn-xs btn-secondary"><span
                                                                        class="fas fa-language"></span></a> &nbsp;
                                                            @endif

                                                            @if (in_array('App\Http\Controllers\LanguageController@edit', $prms))
                                                                <a title="{{ __('Edit language') }}"
                                                                    href="javascript:void(0)"
                                                                    class="btn btn-xs btn-primary edit_language"
                                                                    data-bs-toggle="modal" data-bs-target="#edit_language"
                                                                    id="{{ $language->id }}"><span
                                                                        class="feather icon-edit neg-transition-scale-svg "></span></a>
                                                                &nbsp;
                                                            @endif

                                                            @if (in_array('App\Http\Controllers\LanguageController@delete', $prms) &&
                                                                    $language->is_default != 1 &&
                                                                    $language->short_name != 'en')
                                                                <form method="POST"
                                                                    action="{{ route('language.delete', $language->id) }}"
                                                                    accept-charset="UTF-8"
                                                                    id="delete-language-{{ $language->id }}"
                                                                    class="display_inline">
                                                                    {!! csrf_field() !!}
                                                                    <input type="hidden" name="flag"
                                                                        value="{{ $language->flag }}">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $language->id }}">
                                                                    <button title="{{ __('Delete') }}"
                                                                        class="btn btn-xs btn-danger"
                                                                        data-id="{{ $language->id }}" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#confirmDelete" data-label="Delete"
                                                                        data-title="{{ __('Delete Language') }}"
                                                                        data-message="{{ __('Are you sure to delete this language?') }}">
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
                        <button type="submit" id="confirmDeleteSubmitBtn" data-bs-task=""
                            class="btn py-2 custom-btn-submit">{{ __('Yes, Confirm') }}
                            <span class="ajax-loading"></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="add-language" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Add New') }}</h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                    </div>
                    <form action="{{ route('language.store') }}" method="post" id="addLanguage"
                        class="form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-4 control-label require"
                                    for="language_name">{{ __('Language Name') }}</label>
                                <div class="col-sm-7">
                                    <select class="form-control js-example-basic-single-2 sl_common_bx" id="language_name"
                                        name="language_name" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="">{{ __('Select One') }}</option>
                                        @foreach ($languageShortName as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row sl_status">
                                <label class="col-sm-4 control-label require" for="status">{{ __('Status') }}</label>
                                <div class="col-sm-7">
                                    <select class="form-control js-example-basic-single-2 sl_common_bx" id="status"
                                        name="status" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="">{{ __('Select One') }}</option>
                                        <option value="Active">{{ __('Active') }}</option>
                                        <option value="Inactive">{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label require"
                                    for="direction">{{ __('Website Direction') }}</label>
                                <div class="col-sm-7">
                                    <select class="form-control js-example-basic-single-2 sl_common_bx" id="direction"
                                        name="direction" required
                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <option value="">{{ __('Select One') }}</option>
                                        <option value="ltr">{{ __('Left to Right') }}</option>
                                        <option value="rtl">{{ __('Right to Left') }}</option>
                                    </select>
                                    <small class="text-info">{{ __('Applied only for this panel') }}&nbsp;</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="default">{{ __('Is Default') }}</label>
                                <div class="col-sm-0 switch switch-primary">
                                    <input class="switch switch-primary minimal" type="checkbox" id="default"
                                        name="default">
                                    <label for="default" class="cr ml-3 swicth-pos"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-0">
                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="py-2 btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                                    <button type="button"
                                        class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div id="edit_language" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Edit Language') }}</h4>
                        <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                    </div>
                    <form action="{{ route('language.update') }}" method="post" id="editLanguage"
                        class="form-horizontal" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-4 control-label require"
                                    for="edit_status">{{ __('Status') }}</label>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control js-example-basic-single-1 sl_common_bx"
                                                id="edit_status" name="edit_status" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                <option value="">{{ __('Select One') }}</option>
                                                <option value="Active">{{ __('Active') }}</option>
                                                <option value="Inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label require"
                                    for="edit_direction">{{ __('Website Direction') }}</label>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control js-example-basic-single-1 sl_common_bx"
                                                id="edit_direction" name="edit_direction" required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                <option value="">{{ __('Select One') }}</option>
                                                <option value="ltr">{{ __('Left to Right') }}</option>
                                                <option value="rtl">{{ __('Right to Left') }}</option>
                                            </select>
                                            <small class="text-info">{{ __('Applied only for this panel') }}&nbsp;</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label require" for="edit_flag">{{ __('Flag') }}</label>
                                <div class="col-sm-7">
                                    <img id="editImg" src='#' alt="{{ __('Image') }}"
                                        class="img-responsive img-thumbnail" height="64" width="64" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="edit_default">{{ __('Is Default') }}</label>
                                <div class="col-sm-0 switch switch-primary">
                                    <input class="switch switch-primary minimal" type="checkbox" id="edit_default"
                                        name="edit_default">
                                    <label for="edit_default" class="cr ml-3 swicth-pos"></label>
                                </div>
                            </div>

                            <input type="hidden" name="language_id" id="language_id">
                        </div>
                        <div class="modal-footer py-0">
                            <div class="form-group row">
                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                <div class="col-sm-12">
                                    <button type="submit"
                                        class="py-2 btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Update') }}</button>
                                    <button type="button"
                                        class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
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
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/settings.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
