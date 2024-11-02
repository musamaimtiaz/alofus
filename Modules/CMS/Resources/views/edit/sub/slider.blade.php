@php
    $slider = $component->slider ?? [];
@endphp
<div class="form-group row form-parent sliderOptions {{ $component && $component->sidebar == 'slider' ? 'd-flex' : 'd-none' }}">
    <div class="col-12">
        <hr>
    </div>
    <label class="col-md-3 control-label">
        <dt>{{ __('Slider') }}</dt>
    </label>
    <div class="col-md-8">
        <div class="accordion slider-accordion {{ $accordId = uniqid('accord_') }}" id="accordionExample">
            @forelse ($slider as $slide)
                @php
                    $slide = miniCollection($slide);
                @endphp
                <div class="card cta-card mb-3">
                    <div class="card-header p-2" id="headingOne">
                        <div class="mb-0 ac-switch collapsed d-flex closed justify-content-between align-items-center w-full curson-pointer"
                            data-bs-toggle="collapse" data-bs-target="#{{ $ac = 'ac' . randomString() }}" aria-expanded="true"
                            aria-controls="{{ $ac }}">
                            <div>{{ __('Slider') }}</div>
                            <span class="b-icon">
                                <i class="feather icon-chevron-down collapse-status"></i>
                                <span class="accordion-action-group">
                                    @if ($loop->last)
                                        @if (count($slider) > 1)
                                            <span class="accordion-row-action remove-row-btn"
                                                data-parent="{{ $accordId }}" data-index="{{ $loop->index + 1 }}"><i
                                                    class="feather icon-minus"></i></span>
                                        @endif
                                        <span class="accordion-row-action add-row-btn" data-parent="{{ $accordId }}"
                                            data-index="{{ $loop->index + 1 }}"><i class="feather icon-plus"></i></span>
                                    @else
                                        <span class="accordion-row-action remove-row-btn"
                                            data-index="{{ $loop->index + 1 }}" data-parent="{{ $accordId }}"><i
                                                class="feather icon-minus"></i></span>
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                    <div id="{{ $ac }}" class="card-body collapse" aria-labelledby="headingOne"
                        data-parent=".{{ $accordId }}">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->u_subtitle }}"
                                            name="slider[{{ $loop->index }}][u_subtitle]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->l_subtitle }}"
                                            name="slider[{{ $loop->index }}][l_subtitle]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row parent-class m-0 p-0">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control inputFieldDesign" value="{{ $slide->title }}"
                                                name="slider[{{ $loop->index }}][title]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 control-label">{{ __('Image') }}</label>

                                        @php
                                            $rand = uniqid();
                                        @endphp
                                        <div class="col-sm-12">
                                            <div class="custom-file media-manager"
                                                data-name="slider[{{ $loop->index }}][image]" data-val="single"
                                                id="image-status">
                                                <input class="custom-file-input form-control d-none" id="validatedCustomFile{{ $rand }}"
                                                    maxlength="50" accept="image/*"
                                                    oninvalid="this.setCustomValidity({{ __('Please select an image.') }})">
                                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                    for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                            </div>
                                            <div class="preview-image">
                                                @if ($slide->image)
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div
                                                            class="position-relative border boder-1 media-box p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                            <div
                                                                class="position-absolute rounded-circle text-center img-remove-icon">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                            <img class="upl-img object-cover neg-transition-scale" class="p-1"
                                                                src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $slide->image }}"
                                                                alt="{{ __('Image') }}">
                                                            <input type="hidden"
                                                                name="slider[{{ $loop->index }}][image]"
                                                                value="{{ $slide->image }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->button_text }}"
                                            name="slider[{{ $loop->index }}][button_text]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Link') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $slide->button_link }}"
                                            name="slider[{{ $loop->index }}][button_link]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card mb-3">
                    <div class="card-header p-2" id="headingOne">
                        <div class="mb-0 ac-switch collapsed d-flex closed justify-content-between align-items-center w-full curson-pointer"
                            data-bs-toggle="collapse" data-bs-target="#{{ $ac = 'ac' . randomString() }}"
                            aria-expanded="true" aria-controls="{{ $ac }}">
                            <div>{{ __('Slider') }}</div>
                            <span class="b-icon">
                                <i class="feather icon-chevron-down collapse-status"></i>
                                <span class="accordion-action-group">
                                    <span class="accordion-row-action add-row-btn" data-parent="{{ $accordId }}"
                                        data-index="1"><i class="feather icon-plus"></i></span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div id="{{ $ac }}" class="card-body collapse" aria-labelledby="headingOne"
                        data-parent=".{{ $accordId }}">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" name="slider[0][u_subtitle]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" name="slider[0][l_subtitle]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row parent-class m-0 p-0">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control inputFieldDesign" name="slider[0][title]">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 control-label">{{ __('Image') }}</label>

                                        @php
                                            $rand = uniqid();
                                        @endphp
                                        <div class="col-sm-12">
                                            <div class="custom-file media-manager" data-name="slider[0][image]"
                                                data-val="single" id="image-status">
                                                <input class="custom-file-input form-control d-none" id="validatedCustomFile{{ $rand }}"
                                                    maxlength="50" accept="image/*">
                                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                    for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                            </div>
                                            <div class="preview-image">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            name="slider[0][button_text]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Link') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign"
                                            name="slider[0][button_link]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@php
    unset($slider);
    unset($slide);
@endphp
