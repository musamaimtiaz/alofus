@extends('formbuilder::layout')

@section('page_title', __('Form Submissions'))

@section('content')
    <div class="col-md-12 list-container">
        <div class="card">
            <div class="card-header bb-none pb-3">
                <h5>{{ __('Submissions') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-9">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="form">
                        <option value="">{{ __('All Forms') }}</option>
                        @foreach ($forms as $form)
                            <option value="{{ $form->id }}">{{ $form->name }}</option>
                        @endforeach
                    </select>
                </div>
            </x-backend.datatable.filter-panel>
            
            <x-backend.datatable.table-wrapper class="need-batch-operation"
            data-namespace="\Modules\FormBuilder\Entities\Submission" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
    </div>
    @include('admin.layouts.includes.delete-modal')
@endsection
