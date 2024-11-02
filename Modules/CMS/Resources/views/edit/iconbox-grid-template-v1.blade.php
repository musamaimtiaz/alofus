@php
    $component = isset($component) ? $component : null;
@endphp
<div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
    <div class="card-body">
        <form action="{{ route('builder.update', ['id' => '__id']) }}" data-type="component" method="post"
            class="component_form form-parent silent-form" novalidate>
            @csrf
            @include('cms::hidden_fields')
            <div class="form-group row">
                <label class="col-md-3 control-label">{{ __('Iconbox Grids') }}</label>
                <div class="col-md-8">
                    <div class="accordion iconbox-accordion {{ $accordId = uniqid('accord_') }}" id="accordionExample">
                        @php
                            $iconboxes = $component && is_array($component->iconbox) ? $component->iconbox : [];
                            $totalIconBoxes = count($iconboxes);
                        @endphp
                        @forelse ($iconboxes as $iconbox)
                            @php
                                $iconbox = miniCollection($iconbox);
                            @endphp
                            <div class="card cta-card mb-3">
                                <div class="card-header p-2" id="headingOne">
                                    <div class="mb-0 ac-switch collapsed d-flex closed justify-content-between align-items-center w-full curson-pointer"
                                        data-bs-toggle="collapse" data-bs-target="#{{ $ac = 'ac' . randomString() }}"
                                        aria-expanded="true" aria-controls="{{ $ac }}">
                                        <div>{{ __('Icon Box') }}</div>
                                        <span class="b-icon">
                                            <i class="feather icon-chevron-down collapse-status"></i>
                                            <span class="accordion-action-group">
                                                @if ($loop->last)
                                                    @if ($totalIconBoxes > 1)
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
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="preview-image">
                                                        @if ($iconbox['image'])
                                                            <div class="d-flex flex-wrap mt-2">
                                                                <div
                                                                    class="position-relative border boder-1 media-box p-1 mr-2 rounded mt-2">
                                                                    <div
                                                                        class="position-absolute rounded-circle text-center img-remove-icon">
                                                                        <i class="fa fa-times"></i>
                                                                    </div>
                                                                    <img class="upl-img neg-transition-scale" class="p-1"
                                                                        src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $iconbox['image'] }}"
                                                                        alt="{{ __('Image') }}">
                                                                    <input type="hidden"
                                                                        name="iconbox[{{ $loop->index }}][image]"
                                                                        id="validatedCustomFile"
                                                                        value="{{ $iconbox['image'] }}">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <label class="col-sm-12 control-label">{{ __('Icon') }}</label>

                                                @php
                                                    $rand = uniqid();
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="custom-file media-manager"
                                                        data-name="iconbox[{{ $loop->index }}][image]"
                                                        data-val="single" id="image-status">
                                                        <input class="custom-file-input form-control d-none"
                                                            id="validatedCustomFile{{ $rand }}" maxlength="50" accept="image/*">
                                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                            for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control inputFieldDesign"
                                                        value="{!! $iconbox['title'] !!}"
                                                        name="iconbox[{{ $loop->index }}][title]">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 control-label">{{ __('Subtitle') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control inputFieldDesign"
                                                        value="{!! $iconbox['subtitle'] !!}"
                                                        name="iconbox[{{ $loop->index }}][subtitle]">
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
                                        <div>{{ __('Icon Box') }}</div>
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
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <div class="preview-image">
                                                    </div>
                                                </div>
                                                <label class="col-sm-12 control-label">{{ __('Icon') }}</label>

                                                @php
                                                    $rand = uniqid();
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="custom-file media-manager"
                                                        data-name="iconbox[0][image]" data-val="single"
                                                        id="image-status">
                                                        <input class="custom-file-input form-control d-none"
                                                            id="validatedCustomFile{{ $rand }}" maxlength="50" accept="image/*">
                                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                            for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control inputFieldDesign" required
                                                        name="iconbox[0][title]">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 control-label">{{ __('Subtitle') }}</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control inputFieldDesign"
                                                        name="iconbox[0][subtitle]">
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
            <hr>
            <div class="form-group row">
                <label class="col-md-3 control-label">{{ __('Sidebox') }}</label>
                <div class="col-md-8">
                    <div class="accordion iconbox-accordion {{ $accordId = uniqid('accord_') }}"
                        id="accordionExample">
                        @php
                            $sidebox = $component && is_array($component->sidebox) ? miniCollection($component->sidebox) : miniCollection([]);
                        @endphp
                        <div class="form-group row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label
                                        class="col-md-12 control-label text-left">{{ __('Display Sidebox') }}</label>
                                    <input type="hidden" name="sidebox_show" value="0">
                                    <div class="col-md-12">
                                        <div class="switch switch-warning d-inline m-r-10">
                                            <input type="checkbox" name="sidebox_show"
                                                id="{{ $sw = uniqid('sw_') }}" value="1"
                                                {{ $component && $component->sidebox_show == 1 ? 'checked' : '' }}>
                                            <label for="{{ $sw }}" class="cr"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="preview-image">
                                            @if ($sidebox['image'])
                                                <div class="d-flex flex-wrap mt-2">
                                                    <div
                                                        class="position-relative border boder-1 media-box p-1 mr-2 rounded mt-2">
                                                        <div
                                                            class="position-absolute rounded-circle text-center img-remove-icon">
                                                            <i class="fa fa-times"></i>
                                                        </div>
                                                        <img class="upl-img neg-transition-scale" class="p-1"
                                                            src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $sidebox['image'] }}"
                                                            alt="{{ __('Image') }}">
                                                        <input type="hidden"
                                                            name="sidebox[image]"
                                                            id="validatedCustomFile"
                                                            value="{{ $sidebox['image'] }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <label class="col-sm-12 control-label">{{ __('Icon') }}</label>

                                    @php
                                        $rand = uniqid();
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="custom-file media-manager" data-name="sidebox[image]"
                                            data-val="single" id="image-status">
                                            <input class="custom-file-input form-control d-none" id="validatedCustomFile{{ $rand }}"
                                                maxlength="50" accept="image/*">
                                            <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile{{ $rand }}">{{ __('Upload image') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Title') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $sidebox->title }}"
                                            name="sidebox[title]">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Sidetext') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control inputFieldDesign" value="{{ $sidebox->sidetext }}"
                                            name="sidebox[sidetext]">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 control-label">{{ __('Description') }}</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="sidebox[description]">{{ $sidebox->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('cms::edit.sub.appearance', ['fields' => ['margin', 'rounded']])
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
@php
    unset($iconBoxes);
    unset($componpent);
    unset($sidebox);
@endphp
