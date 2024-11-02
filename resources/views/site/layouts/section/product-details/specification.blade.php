<div class="c-tab mt-6" id="product-specification-panel">
    <div class="c-tab__content -mt-5 md:-mt-0">
        <p class="roboto-medium text-sm md:text-15 font-medium text-gray-10">
            {{ __('Specifications of :x', ['x' => $name]) }}
        </p>
        <div class="rounded my-6">
            <table class="ltr:text-left rtl:text-right w-full border-collapse border text-sm md:text-15">
                <tbody class="text-gray-10 roboto-medium">
                    @if(!empty($weight))
                    <tr id="weightRow">
                        <td class="py-4 px-6 border">{{ __('Weight') }}</td>
                        <td class="py-4 px-6 border">{{ $weight }} {{ preference('measurement_weight') }}</td>
                    </tr>
                    @else
                    <tr id="weightRow" class="display-none">

                    </tr>
                    @endif
                    @if(is_array($dimensions) && count($dimensions) > 0 && isset($dimensions['length']) && $dimensions['length'] != ""
                    || is_array($dimensions) && count($dimensions) > 0 && isset($dimensions['width']) && $dimensions['width'] != ""
                    || is_array($dimensions) && count($dimensions) > 0 && isset($dimensions['height']) && $dimensions['height'] != ""
                    )
                        <tr id="dimensionsRow">
                            <td class="py-4 px-6 border">{{ __('Dimensions') }}</td>
                            <td class="py-4 px-6 border">{{ $dimensions['length'] ?? null }} {{ isset($dimensions['width']) && $dimensions['width'] != "" ? "× " . $dimensions['width']  : '' }}
                            {{ isset($dimensions['height']) && $dimensions['height'] != "" ? "× " . $dimensions['height'] : '' }} {{ preference('measurement_dimension') }}</td>
                        </tr>
                    @else
                        <tr id="dimensionsRow" class="display-none">

                        </tr>
                    @endif
                    @if(!empty($attributes))
                        @foreach ($attributes as $attribute)
                            @if($attribute['visibility'] == 1)
                                <tr>
                                    <td class="py-4 px-6 border">{{ $attribute['name'] }}</td>
                                    <td class="py-4 px-6 border">
                                        @php $len = count($attribute['value']); $i = 1 @endphp
                                        @foreach ($attribute['value'] as $attValue)
                                            @php $result = null;
                                            if (isset($attribute_values[$attribute['key']])) {
                                                $dataQuery = $attribute_values[$attribute['key']]->where('id', $attValue)->first();
                                                    if (!empty($dataQuery)) {
                                                        $result = $dataQuery->value;
                                                    } else {
                                                        $result = $attValue;
                                                    }
                                            } else {
                                            $result = $attValue;
                                            }
                                            @endphp
                                            {{ $result }}
                                            {{ $len > $i ? "," : null }}
                                            @php $i++ @endphp
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
