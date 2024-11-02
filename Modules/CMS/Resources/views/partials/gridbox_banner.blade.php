@php
    $banner = miniCollection($component->slide ?? []);
@endphp
<div class="md:w-[335px] lg:w-322p w-full pb-2">
    <div class="relative h-600p w-full ">
        @isset($banner->image)
            <img class="w-full h-full object-cover neg-transition-scale rounded-md"
                src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $banner->image }}" alt="{{ __('Image') }}">
        @endisset
        <div class="absolute top-0 p-6">
            @if ($banner->u_subtitle)
                <p class="text-xs text-gray-1">{!! $banner->u_subtitle !!}</p>
            @endif
            @if ($banner->l_subtitle)
                <p class="text-gray-12 font-medium text-lg uppercase">{!! $banner->l_subtitle !!}</p>
            @endif
            @if ($banner->title)
                <p class="text-gray-12 font-bold text-2.5xl -mt-1.5 uppercase">{!! $banner->title !!}</p>
            @endif
            @if ($banner->button)
                <a href="{{ $banner->link ?? '#' }}"
                    class="process-goto hover:bg-gray-12 hover:text-white cursor-pointer relative flex justify-center text-gray-12 rounded-sm text-xs mt-13p items-center py-2 w-29 dm-sans border border-gray-800">
                    <span>{!! $banner->button !!}</span>
                    <svg class="relative ltr:ml-5p rtl:mr-2.5 neg-transition-scale" width="10" height="7" viewBox="0 0 10 7" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                            fill="currentColor"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>
