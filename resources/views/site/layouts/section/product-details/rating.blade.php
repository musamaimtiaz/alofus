@if(preference('rating_enable'))
<div id="rating">
    <div class="flex items-center cursor-pointer">
        <ul class="flex flex-wrap sm:justify-center ltr:-space-x-1">
            @for($i = 1; $i <= 5; $i++)
                @if ($avg >= $i)
                    {{-- Full star --}}
                    <li class="mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 primary-text-color"
                                viewBox="0 0 20 20" fill="var(--primary-color)">
                            <path
                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                fill="var(--primary-color)"/>
                        </svg>
                    </li>
                @elseif ($avg < $i && $avg > $i-1)
                    {{-- Half star --}}
                    <li class="mt-5p pr-2">
                        <svg class="h-3 w-3" viewBox="0 0 142 142" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                fill="#C4C4C4"/>
                            <mask id="mask0_2170_1814" class="mask-type-alpha"
                                    maskUnits="userSpaceOnUse" x="3" y="0" width="136" height="129">
                                <path
                                    d="M71 0L86.9405 49.0598H138.525L96.7923 79.3804L112.733 128.44L71 98.1196L29.2672 128.44L45.2077 79.3804L3.47499 49.0598H55.0595L71 0Z"
                                    fill="#C4C4C4"/>
                            </mask>
                            <g mask="url(#mask0_2170_1814)">
                                <rect x="-39" y="-36" width="110" height="201" fill="var(--primary-color)"/>
                            </g>
                        </svg>
                    </li>
                @else
                    {{-- Empty star --}}
                    <li class="mt-5p">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300"
                                viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M6.23333 0L7.6328 4.30712H12.1616L8.49772 6.96907L9.89719 11.2762L6.23333 8.61425L2.56947 11.2762L3.96894 6.96907L0.305081 4.30712H4.83386L6.23333 0Z"
                                fill="currentColor"/>
                        </svg>
                    </li>

                @endif
            @endfor
        </ul>
        <ul class="roboto-medium font-medium text-sm text-gray-10"><span class="ltr:pl-2 rtl:pr-2">{{ round($avg, 1) }}</span><span class="px-0.5">/</span> </ul>
        <span class="roboto-medium font-medium text-sm text-gray-10">{{ $reviewCount }}</span>
        <span class="roboto-medium font-medium text-sm text-gray-10 ltr:ml-2 rtl:mr-2">{{ ($reviewCount && $reviewCount > 1) ? __("Reviews") : __("Review") }}</span>

    </div>
</div>
@endif

