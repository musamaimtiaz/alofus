@extends('formbuilder::layout')

@section('page_title', __('Edit KYC Submission'))

@section('content')
    <div class="col-sm-8 list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5><a href="{{ route('formbuilder::kyc.index') }}">{{ __('Edit KYC Data') }}</a></h5>
                <div class="mt-2 mt-md-0">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group" role="group">
                            <form action="{{ route('formbuilder::kyc.delete', ['id' => $submission->id]) }}" method="POST"
                                id="delete-submission-{{ $submission->id }}" class="d-inline-block" accept-charset="UTF-8">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm rounded-0" data-delete="submission"
                                    data-label="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#confirmDelete"
                                    data-title="{{ __('Delete Form') }}"
                                    data-form="delete-submission-{{ $submission->id }}" data-id="{{ $submission->id }}"
                                    data-message="{{ __('Are you sure to delete this?') }}" title="{{ __('Delete') }}">
                                    <i class="feather icon-trash-2 m-0"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-4">
                <div class="card-block p-0">
                    <div class="col-sm-12">
                        <form class="kycFormAdmin" action="{{ route('formbuilder::kyc.sub-update', $submission->id) }}" method="POST"
                            id="submitForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body px-0">
                                <div id="fb-render"></div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn custom-btn-submit confirm-form" data-form="submitForm"
                                    data-message="{{ __('Submit update to your entry for :x ?', ['x' => optional($submission->form)->name]) }}">
                                     {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Details') }}</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item rounded-0 py-3">
                        <strong>{{ __('Form') }}: </strong>
                        <span class="ltr:float-right rtl:float-left">{{ $submission?->form?->name }}</span>
                    </li>
                    <li class="list-group-item rounded-0 py-3">
                        <strong>{{ __('Submitted By') }}: </strong>
                        <span class="ltr:float-right rtl:float-left">{{ $submission?->user?->name ?? 'Guest' }}</span>
                    </li>
                    <li class="list-group-item rounded-0 py-3">
                        <strong>{{ __('Updated On') }}: </strong>
                        <span class="ltr:float-right rtl:float-left">{{ $submission->format_updated_at}}</span>
                    </li>
                    <li class="list-group-item rounded-0 py-3">
                        <strong>{{ __('Submitted On') }}: </strong>
                        <span class="ltr:float-right rtl:float-left">{{ $submission->format_created_at }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('admin.layouts.includes.delete-modal')
@endsection
@push(moduleConfig('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($submission?->form?->form_builder_json) !!}
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/render-form.min.js') }}" defer></script>
@endpush
