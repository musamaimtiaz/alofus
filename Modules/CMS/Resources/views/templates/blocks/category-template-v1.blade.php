@php
    $cType = $component->category_type;
    $categories = $homeService->categories($cType, [], $component->max, $component->categories);
    $totalCols = $homeService->getColumnCount($component, $component->max);
@endphp
<section class="{{ $component->full == 1 ? 'px-4' : 'mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' }} my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    @if ($component->title)
        <p class="text-center font-bold text-sm md:text-[22px] text-gray-12 mb-2.5 md:mb-5 uppercase dm-bold">
            {!! $component->title !!}</p>
    @endif
    <div
        class="grid lg:grid-cols-{{ $totalCols }} lg:gap-7 grid-flow-col lg:grid-flow-row gap-4 auto-cols-max overflow-auto">
        @foreach ($categories ?? [] as $category)
            <a href="{{ route('site.productSearch', ['categories' => $category->slug]) }}">
                <div
                    class="border primary-bg-hover mb-4 md:mb-0 rounded-md relative t-img trans-effect w-130p lg:w-auto">
                    <div class="flex justify-center items-center h-130p">
                        <img class="md:h-16 md:w-16 w-66p h-66p object-contain trans-effect neg-transition-scale"
                            src="{{ $category->fileUrl() }}" alt="{{ __('Image') }}">
                    </div>
                    <div
                        class="opacity-0 hover:opacity-100 duration-300 absolute inset-0 z-10 flex justify-center items-center text-xs md:text-base mx-3 text-white font-semibold">
                        <p class="text-gray-12 dm-bold absolute inset-x-0 bottom-1 md:bottom-3 text-center leading-5 line-clamp-single">
                            {{ trimWords($category->name, 15) }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
