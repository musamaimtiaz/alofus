@extends('formbuilder::vendor-layout')

@section('page_title', __('Edit KYC Submission'))

@section('content')
    <div class="list-container">
        <div class="card">
            <div class="card-header">
                <h5><a href="#">{{ __('Edit My KYC Data') }}</a></h5>
            </div>
            <div class="card-body px-4">
                <div class="card-block pt-2 px-0">
                    <div class="col-sm-12">
                        <form class="kycFormAdmin" action="{{ route('kyc.user.update', $submission->id) }}" method="POST" id="submitForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body px-0">
                                <div id="fb-render"></div>
                            </div>

                            <div class="card-footer px-0">
                                <button type="submit" class="btn custom-btn-submit confirm-form" data-form="submitForm"
                                    data-message="{{ __('Submit update to your entry for :x ?', ['x' => $submission?->form?->name]) }}">
                                     {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
