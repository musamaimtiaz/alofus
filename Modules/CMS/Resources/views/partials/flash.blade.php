@if ($flashProduct)
    @php
        $flash = miniCollection($component->flash ?? []);
    @endphp
    <div class="md:w-322p w-full">
        <div class="relative bg-gray-11 rounded-md pb-0.5">
            @if ($flash->badge_text)
                <div class="p-4">
                    <p class="text-xs rounded-sm font-medium text-gray-12 text-center px-1.5 py-1 primary-bg-color inline">
                        {{ $flash->badge_text }}
                    </p>
                </div>
            @endisset
            <div class="flex justify-center">
                <img width="180px" height="160px" src="{{ $flashProduct->getFeaturedImage('medium') }}" alt="{{ __('Image') }}">
            </div>

            <div class="text-center bg-white mx-4 mb-4 mt-8 py-4 rounded">
                <p class="text-lg text-gray-12 mt-2 px-5 dm-regular font-normal">
                    {{ trimWords($flashProduct->name, 30) }}</p>

                <div class="item-rating">
                    <div class="self-top">
                        <ul class="flex justify-center mt-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($flashProduct->review_average >= $i)
                                    {{-- Full star --}}
                                    <li class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 primary-text-color"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                                fill="currentColor" />
                                        </svg>
                                    </li>
                                @elseif ($flashProduct->review_average < $i && $flashProduct->review_average > $i - 1)
                                    {{-- Half star --}}
                                    <li class="mt-1 ltr:pr-2 rtl:pl-2">
                                        <svg class="h-3 w-3" viewBox="0 0 142 142" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                fill="#C4C4C4" />
                                            <mask id="mask0_2170_1814" class="mask-type-alpha"
                                                maskUnits="userSpaceOnUse" x="3" y="0"
                                                width="136" height="129">
                                                <path
                                                    d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                                    fill="#C4C4C4" />
                                            </mask>
                                            <g mask="url(#mask0_2170_1814)">
                                                <rect x="-39" y="-36" width="110" height="201"
                                                    fill="var(--primary-color)" />
                                            </g>
                                        </svg>
                                    </li>
                                @else
                                    {{-- Empty star --}}
                                    <li class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                                fill="currentColor" />
                                        </svg>
                                    </li>
                                @endif
                            @endfor
                        </ul>

                        <p class="ltr:ml-1.5 rtl:mr-1.5 text-gray-10 text-sm dm-sans mt-1.5">
                            ({{ $flashProduct->review_count }}
                            {{ $flashProduct->review_count > 1 ? __('Reviews') : __('Review') }})
                        </p>
                    </div>
                </div>

                @if ($sp = $flashProduct->getFormattedSalePrice())
                    <p class="text-xl text-gray-12 dm-bold mt-3 pb-4">
                        {{ $sp }}
                    </p>
                @endif
                <p
                    class="{{ $sp ? 'text-12 font-medium line-through text-gray-10 pl-1 mt-0.5' : 'text-xl text-gray-12 dm-bold mt-3 pb-4' }}">
                    {{ $flashProduct->getFormattedPrice() }}
                </p>
            </div>
    </div>
</div>
@endif
