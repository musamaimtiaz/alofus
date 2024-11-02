    @php
        $component = isset($component) ? $component : null;
    @endphp
    <div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
        <div class="card-body">
            <form action="{{ route('vendor.builder.update', ['id' => '__id']) }}" data-type="component" method="post"
                class="component_form form-parent silent-form" novalidate>
                @csrf
                @include('cms::hidden_fields')
                <div class="form-group row">
                    <label class="col-md-3 control-label">
                        <dt>{{ __('CTA Options') }}</dt>
                    </label>
                    <div class="col-md-8">
                        <div class="accordion cta-accordion {{ $accordId = uniqid('accord_') }}" id="accordionExample">
                            @php
                                $ctas = $component && is_array($component->cta) ? $component->cta : [];
                                $totalCta = count($ctas);
                            @endphp
                            @forelse ($ctas as $cta)
                                @php
                                    $cta = miniCollection($cta);
                                @endphp
                                <div class="card cta-card mb-3">
                                    <div class="card-header p-2" id="headingOne">
                                        <div class="mb-0 ac-switch collapsed d-flex closed justify-content-between align-items-center w-full curson-pointer"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $ac = 'ac' . randomString() }}"
                                            aria-expanded="true" aria-controls="{{ $ac }}">
                                            <div>{{ __('Call To Action') }}</div>
                                            <span class="b-icon">
                                                <i class="feather icon-chevron-down collapse-status"></i>
                                                <span class="accordion-action-group">
                                                    @if ($loop->last)
                                                        @if ($totalCta > 1)
                                                            <span class="accordion-row-action remove-row-btn"
                                                                data-parent="{{ $accordId }}"
                                                                data-index="{{ $loop->index + 1 }}"><i
                                                                    class="feather icon-minus"></i></span>
                                                        @endif
                                                        <span class="accordion-row-action add-row-btn"
                                                            data-parent="{{ $accordId }}"
                                                            data-index="{{ $loop->index + 1 }}"><i
                                                                class="feather icon-plus"></i></span>
                                                    @else
                                                        <span class="accordion-row-action remove-row-btn"
                                                            data-index="{{ $loop->index + 1 }}"
                                                            data-parent="{{ $accordId }}"><i
                                                                class="feather icon-minus"></i></span>
                                                    @endif
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="{{ $ac }}" class="card-body collapse parent-class"
                                        aria-labelledby="headingOne" data-parent=".{{ $accordId }}">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            value="{{ $cta['upper_st'] }}"
                                                            name="cta[{{ $loop->index }}][upper_st]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            value="{{ $cta['lower_st'] }}"
                                                            name="cta[{{ $loop->index }}][lower_st]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            value="{{ $cta['title'] }}"
                                                            name="cta[{{ $loop->index }}][title]">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 control-label">{{ __('Image') }}</label>
                                                    <div class="col-md-12">
                                                        <div class="custom-file media-manager"
                                                            data-name="cta[{{ $loop->index }}][image]"
                                                            data-val="single" id="image-status">
                                                            @php 
                                                            $unId = uniqid();
                                                            @endphp
                                                            <input class="custom-file-input form-control d-none"
                                                                id="validatedCustomFile{{ $unId }}" maxlength="50" accept="image/*">
                                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                                for="validatedCustomFile{{ $unId }}">{{ __('Upload image') }}</label>
                                                        </div>
                                                        <div class="preview-image">
                                                            @if ($cta['image'])
                                                                <div class="d-flex flex-wrap mt-2">
                                                                    <div
                                                                        class="position-relative border boder-1 media-box p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                                        <div
                                                                            class="position-absolute rounded-circle text-center img-remove-icon">
                                                                            <i class="fa fa-times"></i>
                                                                        </div>
                                                                        <img class="upl-img neg-transition-scale" class="p-1"
                                                                            src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $cta['image'] }}"
                                                                            alt="{{ __('Image') }}">
                                                                        <input type="hidden"
                                                                            name="cta[{{ $loop->index }}][image]"
                                                                            id="validatedCustomFile"
                                                                            value="{{ $cta['image'] }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            value="{{ $cta['btn_text'] }}"
                                                            name="cta[{{ $loop->index }}][btn_text]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Button Link') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            value="{{ $cta['btn_link'] }}"
                                                            name="cta[{{ $loop->index }}][btn_link]">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card cta-card mb-3">
                                    <div class="card-header p-2" id="headingOne">
                                        <div class="mb-0 ac-switch collapsed d-flex closed justify-content-between align-items-center w-full curson-pointer"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $ac = 'ac' . randomString() }}"
                                            aria-expanded="true" aria-controls="{{ $ac }}">
                                            <div>{{ __('Call To Action') }}</div>
                                            <span class="b-icon">
                                                <i class="feather icon-chevron-down collapse-status"></i>
                                                <span class="accordion-action-group">
                                                    <span class="accordion-row-action add-row-btn"
                                                        data-parent="{{ $accordId }}" data-index="1"><i
                                                            class="feather icon-plus"></i></span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="{{ $ac }}" class="card-body collapse parent-class"
                                        aria-labelledby="headingOne" data-parent=".{{ $accordId }}">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Upper Subtitle') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            name="cta[0][upper_st]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Lower Subtitle') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            name="cta[0][lower_st]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            name="cta[0][title]">

                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $rand = uniqid();
                                            @endphp

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 control-label">{{ __('Image') }}</label>
                                                    <div class="col-md-12">
                                                        <div class="custom-file media-manager"
                                                            data-name="cta[0][image]" data-val="single"
                                                            id="image-status">
                                                            <input class="custom-file-input form-control d-none"
                                                                id="validatedCustomFile{{ $rand }}" maxlength="50"
                                                                accept="image/*">
                                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                                for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                                        </div>
                                                        <div class="preview-image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Button Text') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            name="cta[0][btn_text]">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-12 control-label">{{ __('Button Link') }}</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control inputFieldDesign"
                                                            name="cta[0][btn_link]">
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
                @include('cms::edit.sub.appearance', ['fields' => ['margin', 'rounded', 'full_link', 'height', 'width']])
                @include('cms::pieces.submit-btn')
            </form>
        </div>
    </div>
