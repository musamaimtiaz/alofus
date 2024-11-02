@php
    $products = $homeService->getProducts($component->showcase_type, $component->total_products, $component->query);
    $flashProduct = $component->sidebar == 'flash_sale' ? $products->shift() : null;
    $product_col = $homeService->getColumnCount($component, $component->total_products);

    $themeOption = \Modules\CMS\Http\Models\ThemeOption::getAll();

    $layout = optional($component->page)->layout;
    if (!$layout) {
        $layout = \Modules\CMS\Entities\Page::firstWhere('default', '1')->layout;
    }
    $isEnableProduct = option($layout . '_template_product', '');
@endphp
@if ($component->sidebar && $component->sidebar_position == 'left')
    @include('cms::partials.sidebar')
@endif
@if ($component->showcase_type)
    <div
        class="w-full">
        <div class="grid grid-cols-2 md:grid-cols-{{ $product_col }} gap-5 mt-5 md:mt-0">
            @if ($products)

                @forelse ($products as $item)
                    @include('cms::partials.product')
                @empty
                    <h2>{{ __('No products') }}</h2>
                @endforelse
            @endif
        </div>
    </div>
@endif
@if ($component->sidebar && $component->sidebar_position == 'right')
    @include('cms::partials.sidebar')
@endif
<script>
    sliderInitiate();
</script>
