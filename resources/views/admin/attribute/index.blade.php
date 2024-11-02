@extends('admin.layouts.app')
@section('page_title', __('Attributes'))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="attribute-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Attributes') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    @if (in_array('App\Http\Controllers\AttributeController@create', $prms))
                        <x-backend.button.add-new href="{{ route('attribute.create') }}" />
                    @endif
                    <x-backend.button.export />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-12">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper>
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        'use strict';
        var pdf = "{{ in_array('App\Http\Controllers\AttributeController@pdf', $prms) ? '1' : '0' }}";
        var csv = "{{ in_array('App\Http\Controllers\AttributeController@csv', $prms) ? '1' : '0' }}";
    </script>
    <script src="{{ asset('public/dist/js/custom/attribute.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/permission.min.js') }}"></script>
@endsection
