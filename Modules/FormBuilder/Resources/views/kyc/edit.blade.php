@extends('formbuilder::layout')

@section('page_title', __('Edit KYC Form'))

@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ __('Edit KYC Submitted Data') }}</h5>
                <div>
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group d-block" role="group">
                            <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-sm btn-primary mt-2 mt-md-0">
                                <i class="fa fa-arrow-left neg-transition-scale"></i> {{ __('Back To My Forms') }}
                            </a>
                            <button class="btn btn-primary btn-sm clipboard ltr:ms-0 ltr:ms-md-2 rtl:me-0 rtl:me-md-2 mt-2 mt-md-0"
                                data-clipboard-text="{{ route('formbuilder::form.render', $form->identifier) }}"
                                data-message="{{ __('Link Copied') }}" data-original="{{ __('Copy Form Link') }}"
                                title="{{ __('Copy form URL to clipboard') }}">
                                <i class="fa fa-clipboard"></i> {{ __('Copy Form Link') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="kycFormAdmin" action="{{ route('formbuilder::kyc.update', $form) }}" method="POST" id="createFormForm"
                data-form-method="PUT">
                @csrf
                @method('PUT')
                <input id="visibility" type="hidden" name="visibility" value="PRIVATE">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="col-form-label">{{ __('Form Name') }}</label>
                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} form-height inputFieldDesign" name="name"
                                    value="{{ old('name') ?? $form->name }}" required autofocus
                                    placeholder="{{ __('Enter Form Name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4" class="form-group">
                            <label for="allows_edit" class="col-form-label">
                                {{ __('Allow Submission Edit') }}
                            </label>

                            <select name="allows_edit" id="allows_edit" class="form-control select2-hide-search form-height" required="required">
                                <option value="0" @if ($form->allows_edit == 0) selected @endif>
                                    {{ __('NO (submissions are final)') }}
                                </option>
                                <option value="1" @if ($form->allows_edit == 1) selected @endif>
                                    {{ __('YES (allow users to edit their submissions)') }}
                                </option>
                            </select>

                            @if ($errors->has('allows_edit'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('allows_edit') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info mx-4" role="alert">
                            <i class="fa fa-info-circle"></i>
                            {{ __('Click on or Drag and drop components onto the main panel to build your form content.') }}
                        </div>

                        <div id="fb-editor" class="fb-editor mx-4 pb-3"></div>
                    </div>
                </div>
        </div>
        </form>

        <div class="card-footer" id="fb-editor-footer d-none">
            <button type="button" class="btn all-cancel-btn custom-btn-cancel fb-clear-btn">
                {{ __('Clear') }}
            </button>
            <button type="button" class="btn custom-btn-submit fb-save-btn">
                 {{ __('Save') }}
            </button>
        </div>
    </div>
    </div>
@endsection

@push(moduleConfig('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/create-form.min.js') }}" defer></script>
@endpush
