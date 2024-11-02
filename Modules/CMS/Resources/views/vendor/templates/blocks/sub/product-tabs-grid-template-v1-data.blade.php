@php
    $product_col = $homeService->getColumnCount($component, $component->max);

    $themeOption = \Modules\CMS\Http\Models\ThemeOption::getAll();

    $layout = optional($component->page)->layout;
    if (!$layout) {
        $layout = \Modules\CMS\Entities\Page::firstWhere('default', '1')->layout;
    }
    $isEnableProduct = option($layout . '_template_product', '');
@endphp
@foreach ($component->disp_categories as $type)
    <div class="c-tab {{ $loop->iteration == 1 ? 'is-active' : '' }} mt-5">
        <div class="c-tab__content">
            <div class="grid grid-cols-2 md:grid-cols-{{ $product_col }}  gap-8">
                @php
                    $products = $homeService->getProducts($type, $component->max);
                    $products = $products->where('vendor_id', $component->page()->first()?->vendor_id);
                @endphp
                @foreach ($products as $item)
                    @include('cms::partials.product')
                @endforeach
            </div>
        </div>
    </div>
@endforeach
<script>
    iniTabs();
</script>
