@extends('admin.layouts.app')

@section('page_title', __('Products Import'))

@push('styles')
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="col-sm-12 list-container" id="item-list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5>{{ __('Products Import') }}</h5>
            </div>

            <div class="card-body p-0 import-table">
                <div class="card-block px-2">
                    <div
                        class="col-sm-8 col-12 mx-auto py-4 d-flex flex-column justify-content-center align-items-center row-striped">
                        @if (!isset($step) || $step == 1)
                            <h4>{{ __('Upload CSV File') }}</h4>
                            <form class="col-12" accept="{{ route('epz.import.products') }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                <input type="hidden" name="step" value="1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{ __('CSV Delimiter') }}</label>
                                    <input type="text" class="form-control inputFieldDesign" aria-describedby="delimiter-help"
                                        placeholder="{{ __('Enter delimiter.') }} Ex: ," name="delimeter">
                                    <small id="delimiter-help" class="form-text text-muted">{{ __('Value seperator in your csv file.') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">{{ __('Import file') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 ltr:rounded-start rtl:rounded-end">{{ __('Upload') }}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="csv" class="custom-file-input"
                                                id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose csv file') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary py-2 ltr:me-0 ltr:float-right rtl:float-left rtl:ms-0">{{ __('Next') }}<i
                                        class="feather icon-arrow-right m-0 ltr:ms-2 rtl:me-2"></i></button>
                            </form>
                        @elseif ($step == 2)
                            <h4>{{ __('Map columns') }}</h4>
                            <p class="text-center">{{ __('Select fields from the csv file to map against products field, or to ignore during import.') }}
                            </p>
                            <form class="col-12 px-3" accept="{{ route('epz.import.products') }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                <input type="hidden" name="step" value="2">
                                @foreach ($headers as $index => $indexValue)
                                    <div class="form-row row stripable align-items-center my-2 p-2">
                                        <div class="form-group col-md-6 col-12 m-0">
                                            <div class="form-group m-0">
                                                <label for="exampleInputEmail1">{{ $indexValue }}</label>
                                                <small class="form-text text-muted">{{ $exampleData[$index] }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-12 m-0">
                                            <input type="hidden" name="from[{{ $index }}]"
                                                value="{{ $indexValue }}">
                                            @php
                                                $strippedIndex = prepareColumnName($indexValue);
                                            @endphp
                                            <select name="to[{{ $index }}]" class="select2">
                                                <option value="">{{ __('Do Not Import') }}</option>
                                                <option value="" disabled>---------------</option>
                                                @foreach ($fieldMap($indexValue) as $key => $option)
                                                    @if (is_array($option))
                                                        <optgroup label="{{ $key }}">
                                                            @foreach ($option as $keyName => $value)
                                                                <option
                                                                    {{ (isset($relations[$indexValue]) && $relations[$indexValue] == $keyName) ||
                                                                    (isset($relations[prepareColumnName($indexValue)]) &&
                                                                        $relations[prepareColumnName($indexValue)] == prepareColumnName($keyName)) ||
                                                                    (isset($relations[$strippedIndex]) && $relations[$strippedIndex] == $keyName)
                                                                        ? 'selected'
                                                                        : '' }}
                                                                    value="{{ $keyName }}">{{ $value }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @else
                                                        <option
                                                            {{ (isset($relations[$indexValue]) && $relations[$indexValue] == $key) ||
                                                            (isset($relations[prepareColumnName($indexValue)]) &&
                                                                $relations[prepareColumnName($indexValue)] == prepareColumnName($key)) ||
                                                            (isset($relations[$strippedIndex]) && $relations[$strippedIndex] == $key)
                                                                ? 'selected'
                                                                : '' }}
                                                            value="{{ $key }}">{{ $option }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary py-2 mt-3 ltr:me-0 ltr:float-right rtl:float-left rtl:ms-0">{{ __('Import') }} <i
                                        class="feather icon-upload-cloud m-0 ltr:ms-0 rtl:me-0"></i></button>
                            </form>
                        @elseif ($step == 3)
                            <div class="d-flex font-bold align-items-center justify-items-center flex-column pt-5 pb-2">
                                <h2 class="text-success"><i class="icon feather icon-check-circle"></i></h2>
                                <p class="d-block mb-2 text-success">{{ __('Products imported: :x', ['x' => $products]) }}
                                </p>
                                @if ($variations > 0)
                                    <p class="d-block mb-2 text-info">
                                        {{ __('Variations imported: :x', ['x' => $variations]) }}
                                    </p>
                                @endif
                                @if ($skipped > 0)
                                    <p class="d-block mb-2 text-warning">{{ __('Product skipped: :x', ['x' => $skipped]) }}
                                    </p>
                                @endif
                            </div>
                            <div class="d-flex font-bold align-items-center justify-items-center flex-column pt-2 pb-4">
                                <a class="btn btn-primary py-2"
                                    href="{{ route('product.index') }}">{{ __('View Products') }} <i
                                        class="fas m-0 ltr:ms-2 rtl:me-2 fa-database"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- select2 JS -->
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
@endsection
