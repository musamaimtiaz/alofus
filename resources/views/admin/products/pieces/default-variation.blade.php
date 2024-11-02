@if (isset($product) && count($product->getVariationAttributes()) > 0)
    <div class="row">
        <div class="col-md-2">
            <p class="sp-title control-label ml-16n-res">{{ __('Default Form Values') }}</p>
        </div>
        <div class="col-md-8">
            <div class="row">
                @php
                    $variationAttributes = $product->getVariationAttributes();
                    $optionValues = $product->getAttributeValues();
                @endphp
                @foreach ($variationAttributes as $attr)
                    <div class="col-md-4 pl-0 pr-10p pb-9p">
                        <select class="form-control select2clearable" name="default_attributes[{{ $attr['key'] }}]">
                            <option value="">{{ __('Any') }} {{ $attr['name'] }}</option>
                            @if ($attr['attribute_id'])
                                @foreach ($attr['value'] as $atr)
                                    <option
                                        {{ $product->getDefaultVariationValue($attr['key']) == $atr ? 'selected' : '' }}
                                        value="{{ $atr }}">
                                        {{ optional($optionValues[$attr['key']]->where('id', $atr)->first())->value }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($attr['value'] as $atr)
                                    <option
                                        {{ $product->getDefaultVariationValue($attr['key']) == $atr ? 'selected' : '' }}
                                        value="{{ $atr }}">{{ $atr }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
