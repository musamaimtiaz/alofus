@extends('formbuilder::layout')

@section('page_title', __('KYC Submissions'))

@section('content')
    <div class="col-md-12 list-container">
        <div class="card">
            <div class="card-header bb-none pb-3">
                <h5>{{ __('KYC Submissions') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.add-new label="Edit KYC Form" href="{{ route('formbuilder::kyc.edit', ['form' => $form->id]) }}" icon-class="feather icon-edit-1 neg-transition-scale-svg " />
                </div>
            </div>

            <x-backend.datatable.table-wrapper>
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
        @include('admin.layouts.includes.delete-modal')
    </div>
@endsection
