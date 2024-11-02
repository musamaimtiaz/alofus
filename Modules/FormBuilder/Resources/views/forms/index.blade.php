@extends('formbuilder::layout')

@section('page_title', __('Forms'))

@section('content')
    <div class="col-md-12 list-container">
        <div class="card">
            <div class="card-header bb-none pb-3">
                <h5>{{ __('Forms') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.add-new href="{{ route('formbuilder::forms.create') }}" />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-6">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="visibility">
                        <option value="">{{ __('All Visibility') }}</option>
                        <option value="PUBLIC">{{ __('Public') }}</option>
                        <option value="PUBLIC">{{ __('Private') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="type">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="Survey">{{ __('Survey') }}</option>
                        <option value="contact_form">{{ __('Contact Form') }}</option>
                        <option value="others">{{ __('Others') }}</option>
                    </select>
                </div>
            </x-backend.datatable.filter-panel>
            <x-backend.datatable.table-wrapper>
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
        @include('admin.layouts.includes.delete-modal')
    </div>
@endsection
