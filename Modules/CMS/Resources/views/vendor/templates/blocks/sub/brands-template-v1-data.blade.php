@php
    $brands = $homeService->brands($component->brand_type, null, $component->brand_limit, $component->brands);
@endphp
<div class="flex flex-col md:flex-row mt-2 md:mt-5 md:gap-x-29p">
    @if (is_countable($brands) && count($brands) > 0 && ($brand = $brands->shift()))
        <a href="{{ route('site.productSearch', ['brands' => $brand->name]) }}"
            class="relative h-36 md:h-80 md:w-1/4 border rounded-md">
            <div class="inset-center">
                <div class="grow">
                    <img class="w-29 h-29 object-contain" src="{{ $brand->fileUrl() }}" alt="{{ __('Image') }}">
                </div>
            </div>
        </a>
    @endif
    <div class="w-full md:w-3/4 mt-5 md:mt-0">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-7">
            @if (is_countable($brands))
                @foreach ($brands as $brand)
                    <a href="{{ route('site.productSearch', ['brands' => $brand->name]) }}">
                        <div class="border rounded-md">
                            <div class="grow p-6 flex flex-row h-36 justify-center items-center">
                                <img class="w-80p h-20 object-contain neg-transition-scale" src="{{ $brand->fileUrl() }}" alt="{{ __('Image') }}">
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>
