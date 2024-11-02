@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Attribute')]))
@section('css')
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="attribute-add-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('attribute.index') }}">{{ __('Attributes') }} </a> >>{{ __('Create :x', ['x' => __('Attribute')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('attribute.store') }}" method="post" id="attributeForm" class="form-horizontal col-sm-12" enctype="multipart/form-data" onsubmit="#">
                        @csrf
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase font-bold" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __(':x Information',['x' => __('Attribute')]) }}</a>
                            </li>
                        </ul>
                        <div class="col-sm-12 form-edit-con" id="myTabContent">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <li><a class="nav-link text-left active" id="v-pills-home-tab" data-bs-toggle="pill" href="#attribute" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ __('Attribute') }}</a></li>
                                        <li id="secondli"><a class="nav-link text-left" id="v-pills-profile-tab" data-bs-toggle="pill" href="#attributeValue" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('Attribute :x', ['x' => __('Values')]) }}</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="attribute" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="form-group row">
                                                <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                                </label>
                                                <div class="col-sm-12">
                                                    <input type="text" placeholder="{{ __('Name') }}" class="form-control form-width h-40" id="name" name="name" value="{{ old('name') }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="Status" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control select2-hide-search" name="status" id="status">
                                                        <option value="Active" {{ old('status') == "Active" ? 'selected' : ''}}>{{ __('Active') }}</option>
                                                        <option value="Inactive" {{ old('status') == "Inactive" ? 'selected' : ''}}>{{ __('Inactive') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="is_required" value="0">
                                            <input type="hidden" name="is_filterable" value="0">
                                            <input type="hidden" name="type" value="dropdown">
                                            <div class="form-group row">
                                                <label for="description" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}
                                                </label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control form-width" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="attributeValue" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="table-responsive">
                                                <table class="options table table-bordered" id="attribute-value">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>{{ __('Value') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="values">
                                                    <tr draggable="false" id="rowid-1">
                                                        <td class="text-center">
                                                            <i class="fa fa-bars"></i>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" name="values[]" class="form-control inputFieldDesign" required>
                                                                <span id="value-text-1" class="validationMsg"></span>
                                                                <input type="hidden" name="row_identify[]" value="1">
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" id="delete-value" class="btn btn-xs btn-danger delete-row" data-row-id=1 data-bs-toggle="tooltip" data-bs-title="Delete Value" data-bs-original-title="">
                                                                <i class="feather icon-trash-2"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="button" class="btn btn-default" id="add-new-value">{{ __('New') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 ltr:ps-1 rtl:pe-1 m-l-35">
                            <a href="{{ route('attribute.index') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                            <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Create') }}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/attribute.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
