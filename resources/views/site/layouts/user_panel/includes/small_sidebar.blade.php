<div class="dark:bg-red-1 fixed inset-y-0 left-0 flex flex-col z-40 max-w-xs w-60 bg-gray-15 transform ease-in-out duration-300 -translate-x-full"
    :class="{ 'translate-x-0': sidemenu, '-translate-x-full': !sidemenu }">
    <!-- Brand Logo / Name -->
    @if ($headerMobileLogo->objectFile)
        <div class="ltr:ml-5 rtl:mr-5 cursor-pointer mt-8 mb-5">
            <div class="flex">
                <a href="{{ route('site.dashboard') }}">
                    <img class="w-36 h-11 object-contain neg-transition-scale" src="{{ $headerMobileLogo->fileUrl() }}" alt="{{ __('Image') }}">
                </a>
                <svg class="ltr:ml-10 rtl:mr-10 mt-1" @click="sidemenu = !sidemenu" xmlns="http://www.w3.org/2000/svg" width="13"
                    height="13" viewBox="0 0 13 13" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z"
                        fill="white" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.9897 0.455612C11.3822 -0.151871 10.3973 -0.151871 9.78981 0.455612L0.45648 9.78895C-0.151003 10.3964 -0.151003 11.3814 0.45648 11.9888C1.06396 12.5963 2.04889 12.5963 2.65637 11.9888L11.9897 2.6555C12.5972 2.04802 12.5972 1.06309 11.9897 0.455612Z"
                        fill="white" />
                </svg>
            </div>
        </div>
    @endif
    <?php
    $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(2);
    ?>
    <div class="py-2 flex-1 h-0 overflow-y-scroll">
        <div @click="open = !open" class=" flex items-center mb-10 ltr:-ml-4 rtl:-mr-4 cursor-pointer">
            <span class="ltr:mr-2.5 rtl:ml-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"
                    fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M6.99998 1.60409C5.6711 1.60409 4.59384 2.68136 4.59384 4.01023C4.59384 5.3391 5.6711 6.41637 6.99998 6.41637C8.32885 6.41637 9.40611 5.3391 9.40611 4.01023C9.40611 2.68136 8.32885 1.60409 6.99998 1.60409ZM2.98975 4.01023C2.98975 1.79544 4.78519 0 6.99998 0C9.21477 0 11.0102 1.79544 11.0102 4.01023C11.0102 6.22502 9.21477 8.02046 6.99998 8.02046C4.78519 8.02046 2.98975 6.22502 2.98975 4.01023Z"
                        fill="#ffffff" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2.69391 10.7258C3.94726 10.0045 5.46049 9.62451 7 9.62451C8.53951 9.62451 10.0527 10.0045 11.3061 10.7258C12.559 11.4469 13.5116 12.488 13.953 13.7235C14.1021 14.1406 13.8847 14.5996 13.4676 14.7486C13.0504 14.8976 12.5915 14.6803 12.4424 14.2632C12.1527 13.4521 11.4943 12.6849 10.506 12.1161C9.51818 11.5477 8.28541 11.2286 7 11.2286C5.71459 11.2286 4.48183 11.5477 3.49402 12.1161C2.50575 12.6849 1.84731 13.4521 1.55756 14.2632C1.40853 14.6803 0.94956 14.8976 0.532425 14.7486C0.115289 14.5996 -0.102055 14.1406 0.0469736 13.7235C0.488366 12.488 1.44102 11.4469 2.69391 10.7258Z"
                        fill="#ffffff" />
                </svg>
            </span>
            <img class="h-12 w-12 mt-3 ltr:ml-3 rtl:mr-3 rounded-full bg-white dark:text-gray-2 hover:text-purple-500 cursor-pointer"
                src="{{ Auth::user()->fileUrl() }}" alt="{{ __('User Photo') }}">
            <div class="mt-3">
                <span class="text-white ltr:ml-3 rtl:mr-3 -mb-2 text-sm dm-sans font-medium">{{ auth()->user()->name }} </span><br>
                <span class="text-white ltr:ml-3 rtl:mr-3 text-11 roboto-medium font-medium">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <ul>
            @foreach ($menus as $menu)
                    @if ($menu->label_name == 'Be a seller' &&
                        auth()->user()->role()->slug != 'customer')
                    @continue
                    @endif
                    @if ($loop->last)
                        <li>
                            <a class="py-7 mb-2 flex items-center dm-sans text-sm font-medium {{ $loop->last ? ' mt-7 w-10/12 ml-5 margin-right' : '' }} {{ $loop->first ? ' -mt-1' : '' }} {{ $menu->isLinkActive() ? ' text-gray-2 border-l-4 bg-gray-12 border-yellow-1' : 'border-t border-gray-16 text-gray-2' }}"
                                href="{{ $menu->url('user') }}">
                                <i class="{{ $menu->icon }} text-xl ltr:pl-2 ltr:pr-3.5 rtl:pr-2 rtl:pl-3.5 neg-transition-scale pt-1"></i>
                                {{ $menu->label_name }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="py-2.5 mb-2 flex items-center dm-sans text-sm font-medium {{ $loop->last ? 'mt-16 fixed' : '' }} {{ $loop->first ? '-mt-1' : '' }} {{ $menu->isLinkActive() ? ' text-gray-2 border-l-4 bg-gray-12 border-yellow-1' : 'border-l-4 border-gray-15 text-gray-2' }}"
                                href="{{ $menu->url('user') }}">
                                <i class="{{ $menu->icon }} text-xl ltr:pl-6 ltr:pr-3.5 rtl:pr-6 rtl:pl-3.5"></i> {{ $menu->label_name }}
                            </a>
                        </li>
                    @endif
            @endforeach
        </ul>
    </div>
</div>
