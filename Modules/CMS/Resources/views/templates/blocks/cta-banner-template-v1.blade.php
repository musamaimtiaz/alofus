<section
    class="{{ $component->full == 1 ? '' : 'mx-4 lg:mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' }} my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    <{{ $component->full_link == 1 ? 'a' : 'div' }} class="block relative h-full"
        href="{{ $component->full_link == 1 ? $component->btn_link : '' }}">
        <div style="background:linear-gradient(to right, #FDFDFD 21.44%, rgba(223, 223, 223, 0) 70.79%), url('{{ urlSlashReplace(asset('public/uploads') . DIRECTORY_SEPARATOR . $component->image) }}');height: {{ $component->height . 'px !important' }}"
            class="promote-img neg-transition-scale {{ $component->rounded == 1 ? 'rounded-md' : '' }}"> </div>
            <div class="absolute top-0 bottom-0 left-0 right-0 p-6 flex align-items-center">
                <div>
                    @if ($component->upper_st)
                        <p class="text-lg font-medium text-gray-10 dm-sans">{!! $component->upper_st !!}</p>
                    @endif
                    @if ($component->title)
                        <p class="text-gray-12 font-bold text-2.5xl -mt-1.5 uppercase dm-bold">
                            {!! $component->title !!}</p>
                    @endif
                    @if ($component->lower_st)
                        <p class="text-base dm-sans">{!! $component->lower_st !!}</p>
                    @endif
                    @if ($component->full_link != 1 && $component->btn_text)
                        <a class="flex text-gray-12 border-gray-800 process-goto border rounded-sm text-xs items-center justify-center p-2 w-29 mt-3 hover:bg-gray-12 hover:text-white cursor-pointer"
                            href="{{ $component->btn_link ? $component->btn_link : 'javascript:void(0)' }}">{{ $component->btn_text }}
                            <svg class="relative mt-1 ltr:ml-5p rtl:mr-2.5 neg-transition-scale" width="10" height="7" viewBox="0 0 10 7"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            </{{ $component->full_link == 1 ? 'a' : 'div' }}>
</section>
