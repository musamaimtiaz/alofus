    @php
        $component = isset($component) ? $component : null;
        $allBrands = \Modules\CMS\Service\Homepage::getBrandsList();
    @endphp
    <div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
        <div class="card-body">
            <form action="{{ route('builder.update', ['id' => '__id']) }}" data-type="component" method="post"
                class="component_form form-parent silent-form" novalidate>
                @csrf
                @include('cms::hidden_fields')
                <div class="form-group row">
                    <label class="col-sm-3 control-label">
                        <dt>{{ __('Title') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control section_name inputFieldDesign" name="title" id="title"
                            value="{{ $component ? $component->title : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">
                        <dt>{{ __('Brands Type') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <select type="text" class="form-control select3" required name="brand_type" id="brand_type">
                            @foreach (\Modules\CMS\Service\Homepage::brandsOptions() as $key => $value)
                                <Option {{ $component && $component->brand_type == $key ? 'selected' : '' }}
                                    value="{{ $key }}">{{ $value }}</Option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div
                    class="form-group row cats {{ !$component || $component->brand_type != 'selectedBrands' ? 'd-none' : '' }}">
                    <label class="col-sm-3 control-label">
                        <dt>{{ __('Brands') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <select type="text" class="form-control select2" name="brands[]" multiple>
                            @if ($component && is_array($component->brands))
                                @foreach ($component->brands as $selected)
                                    @if (isset($allBrands[$selected]))
                                        <Option selected value="{{ $selected }}">{{ $allBrands[$selected] }}
                                        </Option>
                                        @php
                                            unset($allBrands[$selected]);
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($allBrands as $key => $value)
                                <Option value="{{ $key }}">{{ $value }}</Option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">
                        <dt>{{ __('No. of brands to show') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <input type="number" min="3" max="20" class="form-control inputFieldDesign" name="brand_limit"
                            required value="{{ $component ? $component->brand_limit : 9 }}">
                        <div class="d-flex mt-2">
                            <span class="badge badge-danger h-100 mt-1">{{ __('Note') }}!</span>
                            <small
                                class="mt-1 ltr:ms-2 rtl:me-2">{{ __('Total brands to display should be between 3 to 20. Default is 9') }}</small>
                        </div>
                    </div>
                </div>
                @include('cms::edit.sub.appearance', ['fields' => ['margin']])
                @include('cms::pieces.submit-btn')
            </form>
        </div>
    </div>
