@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Template')]))
@section('css')
  <link rel="stylesheet" href="{{ asset('public/dist/plugins/codemirror/lib/codemirror.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="email-template-add-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.email_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5> <a href="{{ route('emailTemplates.index') }}">{{ __('Email Templates') }}</a>
                                >>{{ __('Create :x', ['x' => __('Template')]) }}</h5>
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
                            <form action='{{ route('emailTemplates.store') }}' method="post" class="form-horizontal"
                                id="userEdit" enctype="multipart/form-data">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="col-sm-12 tab-content shadow-none" id="myTabContent">
                                    <div class="tab-pane fade show active" id="information" role="tabpanel"
                                        aria-labelledby="information-tab">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group row">
                                                    <label for="first_name"
                                                        class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Name') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" placeholder="{{ __('Name') }}"
                                                            class="form-control inputFieldDesign" id="name"
                                                            name="name" required pattern="^[a-zA-Z ]*$"
                                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                            data-pattern="{{ __('Only alphabet and white space are allowed.') }}"
                                                            data-related="slug" value="{{ old('name') }}">
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
                                                            value="{{ old('slug') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="subject"
                                                        class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Subject') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" placeholder="{{ __('Subject') }}"
                                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                            class="form-control inputFieldDesign" id="subject"
                                                            name="subject" required value="{{ old('subject') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="body"
                                                        class="col-sm-2 col-form-label require ltr:pe-0 rtl:ps-0">{{ __('Body') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="body" name="body" class="form-control" required
                                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ old('body') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="Status"
                                                        class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control select2-hide-search" name="status"
                                                            id="status">
                                                            <option value="Active"
                                                                {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                                {{ __('Active') }}</option>
                                                            <option value="Inactive"
                                                                {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                                {{ __('Inactive') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="variables"
                                                        class="col-sm-2 col-form-label ltr:pe-0 rtl:ps-0">{{ __('Variables') }}</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="variables" name="variables" class="form-control">{{ old('variables') }}</textarea>
                                                        <span class="badge badge-info">{{ __('Note') }}</span> <small
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
                                                            <div class="col-sm-8">
                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-2 col-form-label ltr:pe-0 rtl:ps-0">{{ __('Subject') }}
                                                                    </label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text"
                                                                            placeholder="{{ __('Subject') }}"
                                                                            class="form-control inputFieldDesign"
                                                                            name="data[{{ $language->short_name }}][subject]"
                                                                            value="{{ old('data.' . $language->short_name . '.subject') }}">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label
                                                                        class="col-sm-2 col-form-label ltr:pe-0 rtl:ps-0">{{ __('Body') }}
                                                                    </label>
                                                                    <div class="col-sm-10">
                                                                        <textarea id="translateBody-{{ $i }}" name="data[{{ $language->short_name }}][body]"
                                                                            class="form-control">{{ old('data.' . $language->short_name . '.body') }}</textarea>
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
                                                <input type="hidden" name="nthLoop" data-rel="{{ $i }}"
                                                    id="nthLoop">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-10 px-0 m-l-5">
                                        <a href="{{ route('emailTemplates.index') }}"
                                            class="py-2 custom-btn-cancel">{{ __('Cancel') }}</a>
                                        <button
                                            class="btn py-2 custom-btn-submit  ltr:me-2 rtl:ms-2"
                                            type="submit" id="btnSubmit">{{ __('Create') }}</button>
                                    </div>
                                </div>
                            </form>
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
