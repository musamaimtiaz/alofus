@extends('admin.layouts.app')
@section('page_title', __('Translations'))
@section('css')
    {{-- Data table --}}
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/admin-order.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="translation-settings-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-3 ltr:pe-0 ltr:ps-1 ltr:ps-md-4 rtl:ps-0 rtl:pe-1 rtl:pe-md-4">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-md-9 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('errorMgs'))
                            <div class="alert alert-warning fade in alert-dismissable">
                                <strong>{{ __('Warning') }}!</strong> {{ session('errorMgs') }}.
                                <a class="close" href="#"
                                    data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        <span id="smtp_head">
                            <div class="card-header p-t-20 border-bottom">
                                <h5>
                                    @if (in_array('App\Http\Controllers\LanguageController@index', $prms))
                                        <a href="{{ route('language.index') }}">{{ __('Languages') }} </a>
                                    @endif
                                    >> {{ __('Translation') }}
                                </h5>
                            </div>
                        </span>
                        <div class="card-body p-0 order-list-table">
                            <div class="card-block pt-2 px-1 px-md-4">
                                <div>
                                    <div class="table-responsive pt-2">
                                        <table id="dataTableBuilder"
                                            class="table table-bordered table-hover table-striped dt-responsive translation-table"
                                            width="100%">
                                            <thead class="table table-bordered dt-responsive" width="100%">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Key') }}</th>
                                                    <th>{{ __('Value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($jsonData as $key => $value)
                                                    @if (is_array($value))
                                                        @foreach ($value as $k => $v)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td width="50%">
                                                                    <b>{{ $k }}</b>
                                                                </td>
                                                                <td width="50%">
                                                                    <input type="text" class="form-control w-100"
                                                                        name="key[{{ $key }}][{{ $k }}]" data-name="key[{{ $key }}][{{ $k }}]"
                                                                        value="{{ $v }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td width="50%">
                                                                <b>{{ $key }}</b>
                                                            </td>
                                                            <td width="50%">
                                                                <input type="text" class="form-control w-100"
                                                                    name="key[{{ $key }}]" value="{{ $value }}"
                                                                    data-name="key[{{ $key }}]">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <form class="form-horizontal" id="language_from" action="{{ route('language.translationSave') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $language->id }}">
                                        <div class="row p-l-15">
                                            <button type="submit"
                                                class="btn custom-btn-submit float-left">{{ __('Save') }}</button>
                                        </div>
                                    </form>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn custom-btn-cancel"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" id="confirmDeleteSubmitBtn" data-task=""
                            class="btn custom-btn-submit">{{ __('Yes, Confirm') }}
                            <span class="ajax-loading"></span>
                    </div>
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
    <script src="{{ asset('public/dist/js/custom/yajra-export.min.js') }}"></script>
@endsection
