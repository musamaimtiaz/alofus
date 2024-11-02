@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Template')]))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/codemirror/lib/codemirror.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="email-template-edit-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.email_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5><a href="{{ route('emailTemplates.index') }}">{{ __('Email Templates') }}</a>
                                >>{{ __('Edit :x', ['x' => __('Template')]) }}</h5>
                        </div>
                        <div class="col-sm-12 m-t-20 form-tabs">
                            <ul class="nav nav-tabs " id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase" id="information-tab" data-bs-toggle="tab"
                                        href="#information" role="tab" aria-controls="information"
                                        aria-selected="true">{{ __('Template Information') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="translate-tab" data-bs-toggle="tab"
                                        href="#translate" role="tab" aria-controls="translate"
                                        aria-selected="false">{{ __('Translate') }}</a>
                                </li>
                            </ul>

                            <div class="row">
                                <div class="col-sm-8">
                                    <form action='{{ route('emailTemplates.update', ['id' => $template->id]) }}'
                                        method="post" class="form-horizontal" id="userEdit" enctype="multipart/form-data">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                        <div class="col-sm-12 tab-content shadow-none" id="myTabContent">
                                            <div class="tab-pane fade show active" id="information" role="tabpanel"
                                                aria-labelledby="information-tab">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row">
                                                            <label for="first_name"
                                                                class="col-sm-2 col-form-label require pr-0">{{ __('Name') }}</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" placeholder="{{ __('Name') }}"
                                                                    class="form-control inputFieldDesign" id="name"
                                                                    name="name" required pattern="^[a-zA-Z ]*$"
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                                    data-pattern="{{ __('Only alphabet and white space are allowed.') }}"
                                                                    data-related="slug"
                                                                    value="{{ !empty(old('name')) ? old('name') : $template->name }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-2 control-label require" for="name">{{ __('Slug') }}</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" placeholder="{{ __('Slug') }}"
                                                                    class="form-control inputFieldDesign" id="slug"
                                                                    name="slug" required pattern="^[a-zA-Z\-]*$"
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                                    data-pattern="{{ __('Only alphabet and white space are allowed.') }}"
                                                                    value="{{ !empty(old('slug')) ? old('slug') : $template->slug }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="subject"
                                                                class="col-sm-2 col-form-label require pr-0">{{ __('Subject') }}</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" placeholder="{{ __('Subject') }}"
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                                    class="form-control inputFieldDesign" id="subject"
                                                                    name="subject" required
                                                                    value="{{ !empty(old('subject')) ? old('subject') : $template->subject }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="text-right w-100 pr-1 mx-0 pt-2">
                                                                <button type="button"
                                                                    class="btn btn-light btn-small previewButton"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#previewModal"><b>{{ __('Preview') }}</b></button>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="body"
                                                                class="col-sm-2 col-form-label require pr-0">{{ __('Body') }}</label>
                                                            <div class="col-sm-10">
                                                                <textarea id="body" name="body" class="form-control" required
                                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ !empty(old('body')) ? old('body') : $template->body }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="Status"
                                                                class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control select2-hide-search"
                                                                    name="status" id="status">
                                                                    <option value="Active"
                                                                        {{ $template->status == 'Active' ? 'selected' : '' }}>
                                                                        {{ __('Active') }}</option>
                                                                    <option value="Inactive"
                                                                        {{ $template->status == 'Inactive' ? 'selected' : '' }}>
                                                                        {{ __('Inactive') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="variables"
                                                                class="col-sm-2 col-form-label pr-0">{{ __('Variables') }}</label>
                                                            <div class="col-sm-10">
                                                                <textarea id="variables" name="variables" class="form-control">{{ !empty(old('variables')) ? old('variables') : $template->variables }}</textarea>
                                                                <span class="badge badge-info">{{ __('Note') }}</span>
                                                                <small
                                                                    class="text-info">{{ __('Please use comma separated values for variables field.') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="translate" role="tabpanel"
                                                aria-labelledby="translate-tab">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        @php
                                                            $languages = \App\Models\Language::getAll()->where('status', 'Active');
                                                            $i = 1;
                                                        @endphp
                                                        @if ($languages->isNotEmpty())
                                                            @foreach ($languages as $language)
                                                                <!-- Escape the english details -->
                                                                @php
                                                                    if ($language->short_name == 'en') {
                                                                        continue;
                                                                    }
                                                                @endphp
                                                                <div class="card-header p-0">
                                                                    <img src='{{ url('public/datta-able/fonts/flag/flags/4x3/' . getSVGFlag($language->short_name) . '.svg') }}'
                                                                        height="20" alt="{{ $language->flag }}"> <span
                                                                        class="text-uppercase f-18 font-weight-bold">{{ $language->name }}</span>
                                                                </div>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-2 col-form-label pr-0">{{ __('Subject') }}</label>
                                                                            <div class="col-sm-10">
                                                                                <input type="text"
                                                                                    placeholder="{{ __('Subject') }}"
                                                                                    class="form-control inputFieldDesign"
                                                                                    name="data[{{ $language->short_name }}][subject]"
                                                                                    value="{{ isset($childs[$language->id]['subject']) ? $childs[$language->id]['subject'] : '' }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-2 col-form-label pr-0">{{ __('Body') }}</label>
                                                                            <div class="col-sm-10"
                                                                                id="code-mirror-parent-{{ $i }}">
                                                                                <textarea id="translateBody-{{ $i }}" name="data[{{ $language->short_name }}][body]"
                                                                                    class="form-control">{{ isset($childs[$language->id]['body']) ? $childs[$language->id]['body'] : '' }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden"
                                                                            name="data[{{ $language->short_name }}][language_id]"
                                                                            value="{{ $language->id }}">
                                                                    </div>
                                                                </div>
                                                                @php $i++ @endphp
                                                            @endforeach
                                                        @endif
                                                        <input type="hidden" name="nthLoop"
                                                            data-rel="{{ $i }}" id="nthLoop">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-10 px-0 m-l-5">
                                                <a href="{{ route('emailTemplates.index') }}"
                                                    class="py-2 custom-btn-cancel ltr:me-2 rtl:ms-2">{{ __('Cancel') }}</a>
                                                <button class="btn py-2 custom-btn-submit" type="submit"
                                                    id="btnSubmit">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-sm-4">
                                    <div class="card-body">
                                        <div>
                                            @if (!empty($template->variables))
                                                <div class="row">
                                                    <div class="col-12">
                                                        @foreach (explode(',', $template->variables) as $key => $value)
                                                            <div>
                                                                <span class="copyButton">
                                                                    {{ '{' . str_replace(' ', '', $value) . '}' }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="previewModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Preview') }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/codemirror/lib/codemirror.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/codemirror/mode/xml.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/templates.min.js') }}"></script>
@endsection
