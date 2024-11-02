@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Template')]))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="sms-template-edit-container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.sms-settings-menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5><a href="{{ route('sms.template.index') }}">{{ __('SMS Templates') }}</a>
                                >>{{ $template->name }}</h5>
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
                                    <form action='{{ route('sms.template.update', ['id' => $template->id]) }}'
                                        method="post" class="form-horizontal">
                                        @csrf
                                        @method('PUT')
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
                                                                    class="form-control inputFieldDesign" id="name" readonly
                                                                    value="{{ !empty(old('name')) ? old('name') : $template->name }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="body"
                                                                class="col-sm-2 col-form-label require pr-0">{{ __('Body') }}</label>
                                                            
                                                            <div class="col-sm-10" id="code-mirror-body">
                                                                <textarea rows="10" id="body" name="sms_body"
                                                                    class="form-control">{{ !empty(old('sms_body')) ? old('sms_body') : $template->sms_body }}</textarea>
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
                                                                @continue ($language->short_name == 'en')
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
                                                                                class="col-sm-2 col-form-label pr-0">{{ __('Body') }}</label>
                                                                            <div class="col-sm-10"
                                                                                id="code-mirror-parent-{{ $i }}">
                                                                                <textarea rows="10" cols="50" id="translateBody-{{ $i }}" name="data[{{ $language->short_name }}][sms_body]"
                                                                                    class="form-control">{{ isset($childs[$language->id]['sms_body']) ? $childs[$language->id]['sms_body'] : '' }}</textarea>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
