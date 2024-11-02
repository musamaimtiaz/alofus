    @php
        $allCategories = \Modules\CMS\Service\Homepage::getCategoryList()->pluck('name', 'id');
        $component = isset($component) ? $component : null;
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
                        <dt>{{ __('Category Type') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <select type="text" class="col-sm-12 form-control category_type select3"
                            name="category_type">
                            @foreach (\Modules\CMS\Service\Homepage::categoryOptions() as $key => $value)
                                <Option {{ $component && $component->category_type == $key ? 'selected' : '' }}
                                    value="{{ $key }}">{{ $value }}</Option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div
                    class="form-group row cats {{ $component && $component->category_type != 'selectedCategories' ? 'd-none' : '' }}">
                    <label class="col-sm-3 control-label">{{ __('Categories') }}</label>
                    <div class="col-sm-8">
                        <select type="text" class="form-control select2" name="categories[]" multiple>
                            @if ($component && is_array($component->categories))
                                @foreach ($component->categories as $selected)
                                    @if (isset($allCategories[$selected]))
                                        <Option selected value="{{ $selected }}">{{ $allCategories[$selected] }}
                                        </Option>
                                        @php
                                            unset($allCategories[$selected]);
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($allCategories as $key => $value)
                                <Option value="{{ $key }}">{{ $value }}</Option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 control-label">
                        <dt>{{ __('Options') }}</dt>
                    </label>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group row product-count">
                                    <label class="col-md-8 control-label">{{ __('Category Grid (Row X Col)') }}</label>
                                    <div class="col-sm-6 pr-1">
                                        <input type="number" class="form-control product-row inputFieldDesign"
                                            placeholder="{{ __('Rows') }}"
                                            value="{{ $component ? $component->row : '' }}" min="1"
                                            max="12" name="row">
                                    </div>
                                    <div class="col-sm-6 pl-1">
                                        <input type="number" class="form-control product-col inputFieldDesign"
                                            placeholder="{{ __('Columns') }}"
                                            value="{{ $component ? $component->column : '' }}" min="1"
                                            max="12" name="column">
                                    </div>
                                    <input type="hidden" name="max"
                                        value="{{ $component ? $component->max : '' }}" class="product-quantity">
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-info mt-1">{{ __('Example') }}</span>
                                    <small
                                        class="mt-1 ltr:ms-1 rtl:me-1">{{ __('Total categories will be rows x columns') }}</small>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                @include('cms::edit.sub.appearance', ['fields' => ['margin','width']])
                @include('cms::pieces.submit-btn')
            </form>
        </div>
    </div>
