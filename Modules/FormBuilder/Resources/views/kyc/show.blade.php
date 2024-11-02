@extends('formbuilder::vendor-layout')

@section('page_title', __('KYC Form'))

@section('content')
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('KYC Form') }}</h5>
            </div>
            <form class="kycForm" action="{{ route('kyc.user.submit', $form->identifier) }}" method="POST" id="submitForm"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div id="fb-render"></div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn custom-btn-submit confirm-form" data-form="submitForm"
                        data-message="{{ __('Submit your entry for :x ?', ['x' => $form->name]) }}">
                         {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/render-form.min.js') }}" defer></script>
@endpush
