    @php
        $productTypes = \Modules\CMS\Service\Homepage::productTypes();
        $component = isset($component) ? $component : null;
        $selectedTypes = $component ? $component->disp_categories : null;
    @endphp
    <div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
        <div class="card-body">
            <form action="{{ route('builder.update', ['id' => '__id']) }}" novalidate data-type="component" method="post"
                class="component_form form-parent silent-form">
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
                        <dt>{{ __('Categories') }}</dt>
                    </label>
                    <div class="col-sm-8">
                        <select name="disp_categories[]" multiple="multiple" class="form-control select2 dcat">
                            @if ($selectedTypes)
                                @foreach ($selectedTypes as $category)
                                    <option selected value="{{ $category }}">{{ $productTypes[$category] }}
                                    </option>
                                    @php
                                        unset($productTypes[$category]);
                                    @endphp
                                @endforeach
                            @endif
                            @foreach ($productTypes as $key => $category)
                                @if ($key != 'queryProducts')
                                    <option value="{{ $key }}">{{ $category }}</option>
                                @endif
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
                                    <label class="col-md-8 control-label">{{ __('Product Grid (Row x Col)') }}</label>
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
                                    <span class="badge badge-info mt-1">{{ __('Note') }}</span>
                                    <small class="mt-1 ltr:ms-1 rtl:me-1">{{ __('Total products will be rows x columns') }}</small>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                @include('cms::edit.sub.appearance', ['fields' => ['margin', 'card_height']])
                @include('cms::pieces.submit-btn')
            </form>
        </div>
    </div>
