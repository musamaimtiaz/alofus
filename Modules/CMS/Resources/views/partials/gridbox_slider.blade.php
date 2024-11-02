@php
    $slider = $component->slider ?? [];
@endphp
@if (count($slider) > 0)
    <div class="md:w-[335px] lg:w-322p w-full pb-2 sidebar_slider">
        @foreach ($slider as $slide)
            @php
                $slide = miniCollection($slide);
            @endphp
            <div class="relative h-600p w-full builder_slider fade">
                @isset($slide->image)
                    <img class="w-full h-full object-cover neg-transition-scale rounded-md"
                        src="{{ asset('public/uploads') . DIRECTORY_SEPARATOR . $slide->image }}">
                @endisset
                <div class="absolute bottom-0 p-6">
                    @if ($slide->u_subtitle)
                        <p class="text-11 text-white dm-regular font-normal">
                            {{ $slide->u_subtitle }}</p>
                    @endif
                    @if ($slide->l_subtitle)
                        <p class="text-white text-lg uppercase font-bold dm-bold">
                            {!! $slide->l_subtitle !!}
                        </p>
                    @endif
                    <p class="text-white text-2.5xl -mt-1.5 uppercase font-bold dm-bold">
                        {{ $slide->title }}</p>
                    @if ($slide->button_text)
                        <a href="{{ $slide->button_link ?? '#' }}"
                            class="process-goto hover:bg-gray-12 hover:text-white text-white border-white cursor-pointer relative flex justify-center rounded-sm text-xs mt-13p items-center py-2 w-29 dm-sans border">
                            <span>{!! $slide->button_text ?? __('Shop Now') !!}</span>
                            <svg class="ltr:ml-5p rtl:mr-5p neg-transition-scale relative" width="10" height="7" viewBox="0 0 10 7"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
@endif
