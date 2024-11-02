@extends('formbuilder::layouts.master')

@section('page_title', $form->name)

@section('content')
    <div class="col-md-8">
        <div class="card rounded-0">
            <div class="card-header">
                <h5 class="card-title">{{ $form->name }}</h5>
            </div>
            <form action="{{ route('formbuilder::form.submit', $form->identifier) }}" method="POST" id="submitForm"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div id="fb-render"></div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary confirm-form" data-form="submitForm"
                        data-message="{{ __('Submit your entry for :x', ['x' => $form->name]) }}">
                        <i class="fa fa-submit"></i> {{ __('Submit Form') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($submission?->form?->form_builder_json) !!}
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/render-form.min.js') }}" defer></script>
@endsection
