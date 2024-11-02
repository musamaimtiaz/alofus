@extends('admin.layouts.app')
@section('page_title', __('Preferences'))
@section('css')
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
 {{-- Bootstrap Tags Input --}}
 <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/bootstrap-tagsinput-latest/css/bootstrap-tagsinput.min.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/custom.min.css') }}">
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Main content -->
<div class="col-sm-12" id="preference-settings-container">
    <div class="card">
        <div class="card-body row">
            <div class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                @include('admin.layouts.includes.general_settings_menu')
            </div>
            <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                <div class="card card-info shadow-none mb-0">
                    <div class="card-header p-t-20 border-bottom">
                        <h5>{{ __('Preferences') }}</h5>
                    </div>
                    <div class="card-block table-border-style">
                        <form action="{{ route('preferences.index') }}" method="post" class="form-horizontal" id="preference_form">
                            @csrf
                            <div class="card-body p-0">
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left" for="inputEmail3">{{ __('Rows per page') }}</label>
                                    <div class="col-sm-6">
                                        <select name="row_per_page" class="form-control select2-hide-search" >
                                            <option value="10" {{ preference('row_per_page') == 10 ? 'selected' : "" }}>10</option>
                                            <option value="25" {{ preference('row_per_page') == 25 ? 'selected' : "" }}>25</option>
                                            <option value="50" {{ preference('row_per_page') == 50 ? 'selected' : "" }}>50</option>
                                            <option value="100"{{ preference('row_per_page') == 100 ? 'selected' : ""}}>100</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="inputEmail3">{{ __('Date format') }}</label>
                                    <div class="col-sm-6">
                                        <select name="date_format" class="form-control select2-hide-search">
                                            <option value="0"
                                                {{ preference('date_format') == 0 ? 'selected' : '' }}>yyyymmdd {2020 12
                                                31}</option>
                                            <option value="1"
                                                {{ preference('date_format') == 1 ? 'selected' : '' }}>ddmmyyyy {31 12
                                                2020}</option>
                                            <option value="2"
                                                {{ preference('date_format') == 2 ? 'selected' : '' }}>mmddyyyy {12 31
                                                2020}</option>
                                            <option value="3"
                                                {{ preference('date_format') == 3 ? 'selected' : '' }}>ddMyyyy {31 Dec
                                                2020}</option>
                                            <option value="4"
                                                {{ preference('date_format') == 4 ? 'selected' : '' }}>yyyyMdd {2020 Dec
                                                31}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="inputEmail3">{{ __('Date Separator') }}</label>
                                    <div class="col-sm-6">
                                        <select name="date_sepa" class="form-control select2-hide-search">
                                            <option value="-"
                                                {{ preference('date_sepa') == '-' ? 'selected' : '' }}>-</option>
                                            <option value="/"
                                                {{ preference('date_sepa') == '/' ? 'selected' : '' }}>/</option>
                                            <option value="."
                                                {{ preference('date_sepa') == '.' ? 'selected' : '' }}>.</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="decimal_digits">{{ __('Decimal Format') }}(.)</label>
                                    <div class="col-sm-6">
                                        <select name="decimal_digits" class="form-control select2-hide-search">
                                            <option value="0"
                                                {{ preference('dicimal_digits') == 0 ? 'selected' : '' }}>
                                                {{ __('No Decimal') }}</option>
                                            @for ($i = 1; $i <= 8; $i++)
                                                <option value={{ $i }}
                                                    {{ preference('decimal_digits') == $i ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="hide_decimal"
                                        class="col-sm-3 control-label">{{ __('Omit Zeros') }}</label>
                                    <div class="col-9 d-flex">
                                        <div class="mr-3">
                                            <div class="switch switch-bg d-inline m-r-10">
                                                <input type="checkbox" name="hide_decimal" class="checkActivity"
                                                    id="hide_decimal" value="1"
                                                    {{ preference('hide_decimal') == 1 ? 'checked' : '' }}>
                                                <label for="hide_decimal" class="cr"></label>
                                            </div>
                                        </div>
                                        <div class="mt-12">
                                            <span>{{ __('If decimal value is zero.') }} Ex: 10.000 => 10</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="thousand_separator">{{ __('Thousand Separator') }}</label>
                                    <div class="col-sm-6">
                                        <select name="thousand_separator" class="form-control select2-hide-search">
                                            <option value=","
                                                {{ preference('thousand_separator') == ',' ? 'selected' : '' }}> ,
                                            </option>
                                            <option value="."
                                                {{ preference('thousand_separator') == '.' ? 'selected' : '' }}> .
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="symbol_position">{{ __('Currency Symbol Position') }}</label>
                                    <div class="col-sm-6">
                                        <select name="symbol_position" class="form-control select2-hide-search">
                                            <option value="before"
                                                {{ preference('symbol_position') == 'before' ? 'selected' : '' }}>
                                                {{ __('Before') }}</option>
                                            <option value="after"
                                                {{ preference('symbol_position') == 'after' ? 'selected' : '' }}>
                                                {{ __('After') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left require"
                                        for="file_size">{{ __('Max FileSize') }}</label>
                                    <div class="col-sm-6 flex-wrap">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('MB') }}</span>
                                            </div>
                                            <input class="form-control" type="number" name="file_size" id="file_size"
                                                min="0" max="20"
                                                value="{{ preference('file_size', '') }}"
                                                required
                                                oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                data-min="{{ __('The value must be :x than or equal to :y', ['x' => __('greater'), 'y' => 0]) }}"
                                                data-max="{{ __('The value must be :x than or equal to :y', ['x' => __('less'), 'y' => 20]) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left"
                                        for="inputEmail3">{{ __('Timezone') }}</label>
                                    <?php
                                    $timezones = timeZoneList();
                                    ?>
                                    <div class="col-sm-6">
                                        <select class="form-control select" name="default_timezone">
                                            @foreach ($timezones as $timezone)
                                                <option value="{{ $timezone['zone'] }}"
                                                    {{ preference('default_timezone') == $timezone['zone'] ? 'selected' : '' }}>
                                                    {{ $timezone['diff_from_GMT'] . ' - ' . $timezone['zone'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 control-label text-left" for="inputEmail3">{{ __('Allowed File Extensions') }}</label>
                                    <div class="col-sm-6">
                                        <div id="extension_notification">
                                        </div>
                                        <div class="col" id="extension_loading">
                                            <div class="placeholder wave h-18p">
                                                <input type="text" value="" data-role="tagsinput" class="square">
                                            </div>
                                        </div>
                                        <div class="tagsinput">
                                            <input type="text" name="file_ext" value="" data-role="tagsinput" id="tags-input">
                                            <div id="extension_action_div">
                                                <div class="py-1" id="note_txt_1">
                                                    <div class="d-flex mt-1 mb-3">
                                                        <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                                                        <ul class="list-unstyled ml-3">
                                                           <li>{{ __('Please avoid :x on the extension name.', ['x' => 'dot(.)']) }} </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left" id="footer-btn">
                                            {{ __('Save') }}
                                        </button>
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
    <script src="{{ asset('public/dist/js/custom/preference.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-tagsinput-latest/js/bootstrap-tagsinput.min.js') }}"></script>
@endsection
