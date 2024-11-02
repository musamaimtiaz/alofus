@extends('formbuilder::layout')

@section('page_title', __('Create Form'))

@section('content')
    <div class="col-sm-12 list-container" id="coupon-list-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5><a href="#">{{ __('Create New Form') }}</a></h5>
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-sm custom-btn-cancel all-cancel-btn ltr:float-md-end ltr:me-0 rtl:float-md-start rtl:ms-0 mb-0">
                        <i class="fa fa-arrow-left neg-transition-scale"></i> {{ __('Back To My Form') }}
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="card-block pt-2 px-4">
                    <div class="col-sm-12">
                        <form class="kycFormAdmin" action="{{ route('formbuilder::forms.store') }}" method="POST" id="createFormForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label require">{{ __('Form Name') }}</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} form-height" name="name" value="{{ old('name') }}" required autofocus
                                            placeholder="{{ __('Enter Form Name') }}">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="visibility" class="col-form-label require">{{ __('Form Visibility') }}</label>
                                        <select name="visibility" id="visibility" class="form-control select2-hide-search form-height"
                                            required="required">
                                            <option value="">{{ __('Select Form Visibility') }}</option>
                                            @foreach (Modules\FormBuilder\Entities\Form::$visibility_options as $option)
                                                <option value="{{ $option['id'] }}">{{ __($option['name']) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('visibility'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('visibility') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 d-none"  id="allows_edit_DIV">
                                    <div class="form-group">
                                        <label for="allows_edit" class="col-form-label require">
                                            {{ __('Allow Submission Edit') }}
                                        </label>

                                        <select name="allows_edit" id="allows_edit" class="form-control select2-hide-search form-height"
                                            required="required">
                                            <option value="0">{{ __('NO (submissions are final)') }}</option>
                                            <option value="1">{{ __('YES (allow users to edit their submissions)') }}
                                            </option>
                                        </select>

                                        @if ($errors->has('allows_edit'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('allows_edit') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="visibility" class="col-form-label require">{{ __('Form Type') }}</label>

                                        <select name="type" id="type" class="form-control select2-hide-search form-height" required="required">
                                            <option value="">{{ __('Select Form Types') }}</option>
                                            @foreach (Modules\FormBuilder\Entities\Form::formTypes() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info" role="alert">
                                        <i class="fa fa-info-circle"></i>
                                        {{ __('Click on or drag and drop components onto the main panel to build your form content.') }}
                                    </div>
                                    <div id="fb-editor" class="fb-editor"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer d-none" id="fb-editor-footer">
                <button type="button" class="btn fb-clear-btn all-cancel-btn custom-btn-cancel">
                     {{ __('Clear') }}
                </button>
                <button type="button" class="btn fb-save-btn custom-btn-submit">
                     {{ __('Save') }}
                </button>
            </div>
        </div>
    </div>
@endsection

@push(moduleConfig('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window.FormBuilder = window.FormBuilder || {}
        window.FormBuilder.form_roles = @json($form_roles);
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/create-form.min.js') }}" defer></script>
@endpush
