@php
    $slides = \Modules\CMS\Service\Homepage::getSlider($component->slider);
@endphp
<section class="{{ $component->full == 1 ? '' : 'mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' }} md:my-12 my-10"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    @if (isset($slides) && $slides->count())
        <div class="{{ $component->full == 1 ? 'custom-swiper-full' : 'custom-swiper' }} swiper mySwiper">
            <div class="swiper-wrapper">
                @php
                    $buttonDirection = ['left' => 'justify-start', 'right' => 'justify-end', 'center' => 'justify-center'];
                @endphp
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div class="relative z-0 flex align-items-center">
                            <div class="costume-title w-full">
                                <div
                                    class="{{ $component->full == 1 ? 'mx-4 xl:mx-32 2xl:mx-64 3xl:mx-92' : 'px-5 sm:px-11' }}">
                                    <div class="text-{{ $slide->title_direction }}">
                                        <div class="sliders-animation inline-block anim text-x-title template-title-x dm-regular animated small-title"
                                            data-animation="{{ $slide->title_animation }}"
                                            style="animation-delay: {{ $slide->title_delay }}s; color: {{ $slide->title_font_color }}; font-size: {{ $slide->title_font_size . 'px' }}; --sliderTitle-fontSize:{{$slide->title_font_size . 'px'}}">
                                            {!! $slide->title_text !!}
                                        </div>
                                    </div>

                                    <div class="text-{{ $slide->sub_title_direction }}">
                                        <div class="sliders-animation inline-block anim text-y-title template-title-y dm-bold animated bold-title"
                                            data-animation="{{ $slide->sub_title_animation }}"
                                            style="animation-delay: {{ $slide->sub_title_delay }}s; color: {{ $slide->sub_title_font_color }}; font-size: {{ $slide->sub_title_font_size . 'px' }}; --sliderSubTitle-fontSize:{{$slide->sub_title_font_size . 'px'}}">
                                            {!! $slide->sub_title_text !!}
                                        </div>
                                    </div>

                                    <div class="text-{{ $slide->description_title_direction }}">
                                        <div class="sliders-animation inline-block anim text-z-title template-title-z dm-regular mt-3 animated bottom-title"
                                            data-animation="{{ $slide->description_title_animation }}"
                                            style="animation-delay: {{ $slide->description_title_delay }}s; color: {{ $slide->description_title_font_color }}; font-size: {{ $slide->description_title_font_size . 'px' }}; --sliderDes-fontSize:{{$slide->description_title_font_size . 'px'}}">
                                            {!! $slide->description_title_text !!}
                                        </div>
                                    </div>

                                    @if (!empty($slide->button_title))
                                        <div class="flex {{ $buttonDirection[strtolower($slide->button_position)] }}">
                                            <a style="animation-delay: {{ $slide->button_delay }}s;" href="{{ $slide->button_link }}"
                                                {{ $slide->is_open_in_new_window == 'Yes' ? 'target=_blank' : '' }}
                                                class="inline-block sliders-animation anim animated"
                                                data-animation="{{ $slide->button_animation }}">
                                                <p class="process-goto shop-btn cursor-pointer relative flex justify-center text-gray-12 rounded-sm md:text-base text-xss items-center md:py-2 py-1.5 w-max md:px-8 px-5 dm-sans mt-2 border md:border-none border-gray-12"
                                                    style="color: {{ $slide->button_font_color }}; background: {{ $slide->button_bg_color . 'dd' }}; --hover-bg-color:{{ $slide->button_bg_color }}; --hover-color:{{ $slide->button_font_color }}">
                                                    {!! $slide->button_title !!}
                                                    <svg class="relative md:w-2.5 md:h-2 w-2 h-6p ltr:ml-5p rtl:mr-2.5 neg-transition-scale" width="10" height="7" viewBox="0 0 10 7"
                                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.7344 0L5.75327 1.05155L7.34399 2.75644H0.69376C0.310607 2.75644 0 3.08934 0 3.5C0 3.91066 0.310607 4.24356 0.69376 4.24356H7.34399L5.75327 5.94845L6.7344 7L10 3.5L6.7344 0Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                </p>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <img class="other-slider-images {{ $component->rounded == 1 ? 'rounded-lg' : '' }} object-cover w-full"
                                style="height: {{$component->height . 'px'}} ; --slider-height:{{$component->height . 'px'}}" src="{{ $slide->fileUrl() }}">
                        </div>
                    </div>
                @endforeach

                <div>
                    <a class="md:flex hidden">
                        <span class="swiper-button-prev prev items-center justify-center">
                            <svg width="9" height="11" viewBox="0 0 9 13" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.32668 0.337159L8.66402 1.65614L3.65882 6.59262L8.66402 11.5291L7.32667 12.8481L0.98413 6.59262L7.32668 0.337159Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                    </a>
                    <a class="md:flex hidden">
                        <span class="swiper-button-next next items-center justify-center">
                            <svg width="9" height="11" viewBox="0 0 9 13" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M2.3231 0.337159L0.985761 1.65614L5.99096 6.59262L0.985762 11.5291L2.32311 12.8481L8.66565 6.59262L2.3231 0.337159Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                    </a>
                </div>

                @foreach ($slides as $slide)
                    <div class="swiper-pagination"></div>
                @endforeach
            </div>
        </div>
    @endif
</section>
