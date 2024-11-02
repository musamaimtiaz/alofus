@if ($paginator->hasPages())
    <div class="border mb-5 border-line"></div>
    <div class="flex items-center mb-6 justify-center gap-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="flex disabled items-center px-2 transition ease-in-out delay-120 text-gray-10 text-center opacity-50 roboto-medium font-medium text-sm" href="javaScript:void(0);">
                <svg class="hover:text-gray-10 ltr:mr-3 rtl:ml-3 neg-transition-scale" width="11" height="7" viewBox="0 0 11 7" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.59216 0L4.6714 1.05155L2.92161 2.75644H10.2369C10.6583 2.75644 11 3.08934 11 3.5C11 3.91066 10.6583 4.24356 10.2369 4.24356H2.92161L4.6714 5.94845L3.59216 7L0 3.5L3.59216 0Z"
                        fill="currentColor" />
                </svg>{{ __('Prev') }}
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="flex text-sm relative arrow-hover font-medium dm-sans text-gray-10 text-center ltr:pl-4 rtl:pr-4 rounded-sm">
                <svg class="mt-1.5 ltr:mr-3 rtl:ml-3 neg-transition-scale absolute" width="11" height="7" viewBox="0 0 15 10" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z"
                        fill="currentColor" />
                </svg>
                <span class="ltr:ml-4 rtl:mr-4 dm-sans font-medium">{{ __('Prev') }}</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span
                    class="px-2 h-8 w-8 text-center py-1 rounded-sm text-gray-10 text-15 roboto-medium font-medium">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javaScript:void(0);"
                            class="px-2 primary-bg-color h-8 w-8 text-center py-1 rounded-sm text-gray-10 text-15 roboto-medium font-medium  hover:text-gray-12 transition ease-in-out delay-120 primary-bg-hover">
                            {{ $page }}
                        </a>
                    @else
                        <a href="{{ $url }}"
                            class="px-2 h-8 w-8 text-center py-1 rounded-sm text-gray-10 text-15 roboto-medium font-medium hover:text-gray-12 transition ease-in-out delay-120 primary-bg-hover">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="dm-sans font-medium text-sm w-16 text-gray-10 flex items-center hover:text-gray-12 process-goto relative text-left"><span class="">{{ __('Next') }}</span>
                <svg class="hover:text-gray-10 ltr:ml-2 rtl:mr-2 neg-transition-scale relative" width="11" height="7" viewBox="0 0 11 7" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.40784 0L6.3286 1.05155L8.07839 2.75644H0.763135C0.341667 2.75644 -2.56343e-07 3.08935 -2.56343e-07 3.5C-2.56343e-07 3.91065 0.341667 4.24356 0.763135 4.24356H8.07839L6.3286 5.94845L7.40784 7L11 3.5L7.40784 0Z"
                    fill="currentColor" />
            </svg>
            </a>
        @else
            <a class="text-sm disabled dm-sans font-medium flex items-center text-gray-10" href="javaScript:void(0);">
                <span class="ltr:ml-5 rtl:mr-5">{{ __('Next') }} </span> <svg class="ltr:ml-2 rtl:mr-2 neg-transition-scale relative"
                    width="11" height="7" viewBox="0 0 15 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.70696 0L8.29274 1.41421L10.5856 3.70711H0.999849C0.447564 3.70711 -0.000150681 4.15482 -0.000150681 4.70711C-0.000150681 5.25939 0.447564 5.70711 0.999849 5.70711H10.5856L8.29274 8L9.70696 9.41421L14.4141 4.70711L9.70696 0Z"
                        fill="currentColor" />
                </svg>
            </a>
        @endif
    </div>
@endif
