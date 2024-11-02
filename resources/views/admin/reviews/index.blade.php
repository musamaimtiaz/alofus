@extends('admin.layouts.app')
@section('page_title', __('Reviews'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="review-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Reviews') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
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
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            
            @include('admin.layouts.includes.delete-modal')

            <div id="edit-review" class="modal fade display_none" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Edit :x',['x' => __('Review')]) }}</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('review.update') }}" method="post" id="editLanguage" class="form-horizontal" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label require" for="edit_status">{{ __('Status') }}</label>
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control select2-hide-search h-40 js-example-basic-single-1 sl_common_bx" id="edit_status" name="status" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                    <option value="Active">{{ __('Active') }}</option>
                                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="review_id" id="review_id">
                            </div>
                            <div class="modal-footer py-2 py-md-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit" class="py-2 custom-btn-submit ltr:float-right ltr:ms-2 rtl:float-left rtl:me-2">{{ __('Update') }}</button>
                                        <button type="button" class="py-2 custom-btn-cancel ltr:float-right rtl:float-left" data-bs-dismiss="modal">{{ __('Close') }}</button>
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
        var pdf = "{{ (in_array('App\Http\Controllers\ReviewController@pdf', $prms)) ? '1' : '0' }}";
        var csv = "{{ (in_array('App\Http\Controllers\ReviewController@csv', $prms)) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/review.min.js') }}"></script>
@endsection
