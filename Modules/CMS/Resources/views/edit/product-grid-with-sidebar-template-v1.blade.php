@php
    $switch_id = uniqid('sw_');
    $component = isset($component) ? $component : null;
@endphp
<div class="card dd-content {{ $editorClosed ?? 'card-hide' }}">
    <div class="card-body">
        <form class="form-parent component_form silent-form" action="{{ route('builder.update', ['id' => '__id']) }}"
            novalidate data-type="component" method="post">
            @csrf
            @include('cms::hidden_fields')
            <div class="form-group row">
                <label class="col-sm-3 control-label">
                    <dt>{{ __('Title') }}</dt>
                </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control section_name inputFieldDesign"
                        value="{{ $component ? $component->title : '' }}" name="title">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-md-3 control-label">
                    <dt>{{ __('Options') }}</dt>
                </label>
                <div class="col-md-8">
                    <div class="row parent-class m-0 p-0">
                        <div class="col-md-3">
                            <input type="hidden" name="see_more" value="0">
                            <div class="form-group">
                                <div class="switch d-inline m-r-10">
                                    <label class="control-label">{{ __('See More') }}</label>
                                    <input class="seeMore" type="checkbox" value="1" id="{{ $switch_id }}"
                                        name="see_more"
                                        {{ $component && $component->see_more == 1 ? 'checked' : '' }}>
                                    <label for="{{ $switch_id }}" class="cr"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 moreLink {{ $component && $component->see_more ? '' : 'd-none' }}">
                            <div class="form-group row ">
                                <label class="col-sm-12 control-label">{{ __('More Link') }}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control more-link inputFieldDesign"
                                        value="{{ $component ? $component->more_link : '' }}" name="more_link">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="col-md-12 control-label">{{ __('Sidebar') }}</label>
                                <div class="col-sm-12">
                                    <select name="sidebar" class="form-control sidebar_options select3">
                                        <option value="0">{{ __('No Sidebar') }}</option>
                                        <option
                                            {{ $component && $component->sidebar == 'slider' ? 'selected' : '' }}
                                            value="slider">{{ __('Slider') }}</option>
                                        <option
                                            {{ $component && $component->sidebar == 'slide' ? 'selected' : '' }}
                                            value="slide">{{ __('Slide') }}</option>
                                        <option
                                            {{ $component && $component->sidebar == 'flash_sale' ? 'selected' : '' }}
                                            value="flash_sale">{{ __('Flash Sale Product') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-md-3 sidebarOption {{ $component && $component->sidebar ? '' : 'd-none' }}">
                            <div class="form-group row">
                                <label class="col-md-12 control-label">{{ __('Position') }}</label>
                                <div class="col-sm-12">
                                    <select name="sidebar_position" class="form-control select3 sidebar-position">
                                        <option
                                            {{ $component && $component->sidebar_position == 'left' ? 'selected' : '' }}
                                            value="left">{{ __('Left') }}</option>
                                        <option
                                            {{ $component && $component->sidebar_position == 'right' ? 'selected' : '' }}
                                            value="right">{{ __('Right') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <dt class="col-sm-3 control-label">{{ __('Showcase Data') }}</dt>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label class="col-sm-12 control-label">{{ __('Product Type') }}</label>
                                <div class="col-sm-12">
                                    <select name="showcase_type" class="form-control product-type select3">
                                        @foreach (\Modules\CMS\Service\Homepage::productTypes() as $key => $value)
                                            <Option
                                                {{ $component && $component->showcase_type == $key ? 'selected' : '' }}
                                                value="{{ $key }}">{{ $value }}</Option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label
                                    class="col-sm-12 control-label text-left">{{ __('Product Grid (Row X Col)') }}</small>
                                </label>
                                <div class="col-sm-12">
                                    <div class="form-group row product-count">
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
                                        <input type="hidden" name="total_products"
                                            value="{{ $component ? $component->total_products : '' }}"
                                            class="product-quantity">
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge badge-info mt-1">{{ __('Example') }}</span>
                                        <small
                                            class="mt-1 ltr:ms-1 rtl:me-1">{{ __('Total products will be rows x columns') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('cms::edit.sub.appearance', ['fields' => ['margin', 'card_height']])
            <!-- Banner edit section -->
            @include('cms::edit.sub.slide')

            <!-- Slider edit section -->
            @include('cms::edit.sub.slider')

            <!-- Flash banner edit section -->
            @include('cms::edit.sub.flashbanner')

            <!-- Query builder -->
            @include('cms::edit.sub.query')

            <!-- Submit button -->
            @include('cms::pieces.submit-btn')
        </form>
    </div>
</div>
