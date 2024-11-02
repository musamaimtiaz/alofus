@php
    $iconBoxes = $component->iconbox ?? [];
    $totalBoxes = is_array($iconBoxes) ? count($iconBoxes) : 0;
@endphp
<div class="hidden lg:grid {{ $component->sidebox_show == 1 ? 'grid-cols-3' : '' }} gap-5 mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92 md:my-12 my-10 h-33"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    <div class="col-span-2 border border-dashed border-gray-400"
        style="border-radius: {{ $component->rounded == 1 ? '6px' : '0' }};">
        <div class="grid grid-cols-{{ $totalBoxes }}">
            @foreach ($iconBoxes as $box)
                @php
                    $box = miniCollection($box);
                @endphp
                <div>
                    <div class="my-6 px-6 border-r lead">
                        <div class="flex">
                            @if ($box->image)
                                <div>
                                    <img src="{{ pathToUrl($box->image) }}"
                                        class="iconbox-image-icons neg-transition-scale" alt="{{ $box->title }}">
                                </div>
                            @endif
                            <p class="text-base font-bold pl-3 text-gray-12 dm-bold">{!! $box->title !!}
                            </p>
                        </div>
                        <p class="roboto-regular text-13 mt-3.5 text-gray-10">{!! $box->subtitle !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if ($component->sidebox_show == 1)
        @php
            $sidebox = is_array($component->sidebox) ? miniCollection($component->sidebox) : miniCollection([]);
        @endphp
        <div class="col-span-1 flex justify-between items-center bg-gray-12 {{ $component->rounded == 1 ? 'rounded-md' : '' }} p-15p">
            <div class="w-2/3 ml-5p">
                <p class="text-2xl primary-text-color font-bold dm-bold">{!! $sidebox->title !!}</p>
                <p class="text-white text-sm mt-1 leading-normal roboto-medium ltr:pr-8 rtl:pl-8">{!! $sidebox->description !!}</p>
            </div>
            @if ($sidebox->sidetext || $sidebox->image)
                <div class="w-1/3 px-1 h-full border primary-text-color flex justify-center items-center text-base font-medium border-dashed border-white rounded">
                    @if ($sidebox->image)
                        <img src="{{ pathToUrl($sidebox->image) }}" alt="{{ $sidebox->title }}">
                    @else
                        <p class="text-center dm-bold capitalize">{!! $sidebox->sidetext !!}</p>
                    @endif
                </div>
            @endif
        </div>
        @php
            unset($sidebox);
        @endphp
    @endif
</div>
@php
    unset($box);
    unset($component);
    unset($iconBoxes);
@endphp
