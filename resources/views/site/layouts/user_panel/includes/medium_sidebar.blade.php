<div class="hidden md:block shadow lg:w-345p md:w-1/3">
    <!-- Brand Logo / Name -->
        <div class="bg-gray-12 h-74p -mt-3">
            <div class="flex flex-col justify-center items-center h-12 w-40 cursor-pointer mt-3 pt-6 ltr:ml-8 rtl:mr-8">
                @if ($headerMobileLogo->objectFile)
                <a href="{{ route('site.dashboard') }}">
                    <span>
                        <img class="w-36 h-11 object-contain neg-transition-scale" src="{{ $headerMobileLogo->fileUrl() }}" alt=" ">
                    </span>
                </a>
                @endif
            </div>
        </div>
    <?php
    $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(2);
    ?>
    <div class="overflow-y-scroll sm:h-4/5 h-3/4 h-85-percentage middle-sidebar-scroll">
        <div class="md:flex h-full">
            <div class="flex flex-col w-1/4 bg-gray-2">
                @foreach ($menus as $menu)
                    @if ($menu->icon == 'fas fa-universal-access' &&
                        auth()->user()->role()->slug != 'customer')
                        @continue
                    @endif
                    @if (!$loop->last)
                        <a class="bg-gray-2 {{ $loop->first ? 'lg:mt-10 mt-5' : ' ' }} " href='{{ $menu->url('user') }}'>
                            <i class=" {{ $menu->icon }} flex items-center h-14 pl-6 neg-transition-scale border-l-4 md:text-lg xl:text-xl hover:text-gray-12 pt-18p {{ $menu->isLinkActive() ? 'text-gray-12 border-gray-12' : 'border-gray-2 text-gray-7' }} "></i>
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="flex-col w-3/4 lg:mt-10 mt-5 flex">
                @foreach ($menus as $menu)
                    @if ($menu->label_name == 'Be a seller' &&
                        auth()->user()->role()->slug != 'customer')
                        @continue
                    @endif
                    @if (!$loop->last)
                        <a href='{{ $menu->url('user') }}'>
                            <span class="dm-sans font-medium md:text-lg xl:text-xl flex items-center hover:text-gray-12 text-gray-10 h-14 ltr:pl-10 rtl:pr-10 {{ $menu->isLinkActive() ? 'text-gray-12' : null }}">{{ $menu->label_name }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="md:flex">
        <div class="flex flex-col h-screen w-3/12 bg-gray-2">
            @foreach ($menus as $menu)
                @if ($loop->last)
                    <a class="bg-gray-2 bottom-0 fixed w-3/12" href='{{ $menu->url('user') }}'>
                        <i class="{{ $menu->icon }} flex items-center cursor-pointer h-14 pl-6 neg-transition-scale border-l-4 md:text-lg xl:text-xl hover:text-gray-12 pt-18p {{ $menu->isLinkActive() ? 'text-gray-12  border-gray-12' : 'border-gray-2 text-gray-7' }} "></i>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="flex-col flex">
            @foreach ($menus as $menu)
                @if ($loop->last)
                    <a class="dm-sans font-medium md:text-lg xl:text-xl flex cursor-pointer items-center hover:text-gray-12 text-gray-10 ltr:pl-10 rtl:pr-10 h-14 bottom-0 fixed w-full bg-gray-11 {{ $menu->isLinkActive() ? 'text-gray-12' : null }}"
                        href='{{ $menu->url('user') }}'>
                        {{ $menu->label_name }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
