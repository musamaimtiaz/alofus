@extends('formbuilder::layout')

@section('page_title', $form->name)

@section('content')
    <div class="col-sm-12">
       <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-md-flex justify-content-between align-items-center">
                    <h5>{{ __('Form Preview for :x', ['x' => $form->name]) }}</h5>
                    <div class="d-md-flex mt-2 mt-md-0">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group d-block" role="group">
                                <a href="{{ route('formbuilder::forms.index') }}"
                                    class="btn btn-primary btn-sm ltr:me-2 rtl:ms-2">
                                    <i class="fa fa-arrow-left neg-transition-scale"></i>
                                </a>
                                <a href="{{ route('formbuilder::submissions.index', $form) }}"
                                    class="btn btn-primary btn-sm ltr:me-2 rtl:ms-2">
                                    <i class="fa fa-th-list neg-transition-scale"></i> {{ __('Submissions') }}
                                </a>
                                <a href="{{ route('formbuilder::forms.edit', $form) }}"
                                    class="btn btn-primary btn-sm ltr:me-2 rtl:ms-2">
                                    <i class="fa fa-edit neg-transition-scale"></i> {{ __('Edit') }}
                                </a>
                                <a href="{{ route('formbuilder::forms.create') }}"
                                    class="btn btn-primary btn-sm mt-2 mt-sm-0">
                                    <i class="fa fa-plus-circle"></i> {{ __('New Form') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="fb-render"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-md-flex justify-content-between align-items-center">
                    <h5>{{ __('Details') }}</h5>
                    <div class="mt-2 mt-md-0">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group" role="group" aria-label="Third group">
                                <button class="btn btn-primary btn-sm clipboard"
                                    data-clipboard-text="{{ route('formbuilder::form.render', $form->identifier) }}"
                                    data-message="{{ __('Copied') }}" data-original="{{ __('Copy Form URL') }}"
                                    title="{{ __('Copy form URL to clipboard') }}">
                                    <i class="fa fa-clipboard"></i> {{ __('Copy Form URL') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>{{ __('Public URL') }} : </strong>
                            <a href="{{ route('formbuilder::form.render', $form->identifier) }}" class="ltr:float-right rtl:float-left  break-all"
                                target="_blank">
                                {{ $form->identifier }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Visibility') }} : </strong> <span
                                class="ltr:float-right rtl:float-left">{{ $form->visibility }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Allows Edit') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $form->allowsEdit() ? 'YES' : 'NO' }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Owner') }} : </strong> <span
                                class="ltr:float-right rtl:float-left">{{ $form?->user?->name }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Current Submissions') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">{{ $form->submissions_count }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Updated On') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">
                                @if ($form->updated_at)
                                    {{ $form->updated_at->toDayDateTimeString() }}
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>{{ __('Created On') }} : </strong>
                            <span class="ltr:float-right rtl:float-left">
                                @if ($form->created_at)
                                    {{ $form->created_at->toDayDateTimeString() }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection

@push(moduleConfig('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('Modules/FormBuilder/Resources/assets/js/render-form.min.js') }}" defer></script>
@endpush
