    @php
        $component = isset($component) ? $component : null;
        $rand = uniqid();
    @endphp
    <div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
        <div class="card-body">
            <form action="{{ route('builder.update', ['id' => '__id']) }}" novalidate data-type="component" method="post"
                class="component_form silent-form" class="form-horizontal">
                @csrf
                @include('cms::hidden_fields')
                <div class="form-group row">
                    <label class="col-md-3 control-label">
                        <dt>{{ __('Content') }}</dt>
                    </label>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Main Title') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control crequired inputFieldDesign"
                                            value="{{ $component ? $component->title : '' }}" name="title">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            value="{{ $component ? $component->upper_st : '' }}" name="upper_st">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            value="{{ $component ? $component->lower_st : '' }}" name="lower_st">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            value="{{ $component ? $component->btn_text : '' }}" name="btn_text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Link') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            value="{{ $component ? $component->btn_link : '' }}" name="btn_link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row form-parent parent-class">
                                    <label class="col-sm-12 control-label">{{ __('Image') }}</label>
                                    <div class="col-sm-12">
                                        <div class="custom-file media-manager" data-name="image" data-val="single"
                                            id="image-status">
                                            <input class="custom-file-input form-control d-none inputFieldDesign" name="image"
                                                id="validatedCustomFile{{ $rand }}" maxlength="50" accept="image/*">
                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                        </div>
                                        <div class="preview-image">
                                            @if ($component && $component->image)
                                                <div class="d-flex flex-wrap mt-2">
                                                    <div
                                                        class="position-relative border boder-1 media-box p-1 mr-2 rounded mt-2">
                                                        <div
                                                            class="position-absolute rounded-circle text-center img-remove-icon">
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                        <img class="upl-img neg-transition-scale" class="p-1"
                                                            src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $component->image }}"
                                                            alt="{{ __('Image') }}">
                                                        <input type="hidden" name="image"
                                                            value="{{ $component->image }}">
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

                @include('cms::edit.sub.appearance', [
                    'fields' => ['margin', 'rounded', 'width', 'full_link', 'height'],
                ])
                @include('cms::pieces.submit-btn')
            </form>
        </div>
    </div>
