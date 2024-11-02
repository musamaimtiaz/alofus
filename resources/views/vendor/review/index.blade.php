@extends('vendor.layouts.app')
@section('page_title', __('Reviews'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/vendor-responsiveness.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="list-container" id="vendor-review-list-container">
        <div class="card">

            <div class="card-header bb-none pb-0">
                <h5>{{ __('Reviews') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel class="mx-1">
                <div class="col-md-9">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="rating">
                        <option value="">{{ __('All Rating') }}</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="need-batch-operation" data-namespace="\App\Models\Review" data-column="id">
                @include('vendor.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('vendor.layouts.includes.delete-modal')

            <div id="edit-review" class="modal fade display_none" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Edit :x',['x' => __('Review')]) }}</h4>
                            <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('vendor.reviewUpdate') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label require" for="edit_status">{{ __('Status') }}</label>
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control select2-hide-search js-example-basic-single-1 sl_common_bx" id="edit_status" name="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                    <option value="Active">{{ __('Active') }}</option>
                                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="review_id" id="review_id">
                            </div>
                            <div class="modal-footer py-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn custom-btn-submit float-right">{{ __('Update') }}</button>
                                        <button type="button" class="btn custom-btn-cancel float-right all-cancel-btn" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    </div>
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
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ (in_array('App\Http\Controllers\Vendor\ReviewController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\Vendor\ReviewController@csv', $prms)) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/review.min.js') }}"></script>
@endsection
