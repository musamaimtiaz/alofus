<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{ route('dashboard') }}" class="b-brand">
                @php
                    $logo = App\Models\Preference::getLogo('company_logo');
                @endphp
                <img class="admin-panel-header-logo neg-transition-scale" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}">
            </a>
            <a class="mobile-menu neg-transition-scale" id="mobile-collapse" href="javascript:void(0)"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <?php
                    $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(1);
                ?>
                @foreach ($menus as $menu)
                    <li data-username="form elements advance componant validation masking wizard picker select" class="{{ $menu->class }} nav-item @if($menu->isParent()) pcoded-hasmenu @endif {{ $menu->isLinkActive() ? 'pcoded-trigger active' : '' }}">
                        <a href='{{ $menu->isParent() ?  "javascript:" : $menu->url("admin") }}' class="nav-link"><span class="pcoded-micon"><i class="{{ $menu->icon }} neg-transition-scale"></i></span><span class="pcoded-mtext">{{ $menu->label_name }}</span></a>
                        @if($menu->isParent())
                            <ul class="pcoded-submenu sub-menu-custom">
                                @foreach ($menu->child as $submenu)
                                    <li class="{{ $submenu->isLinkActive() ? 'active' : '' }}">
                                        <a href="{{ $submenu->url('admin') }}" class="d-flex align-items-center"> <span class="pcoded-micon"> <i class="{{ $submenu->icon }} neg-transition-scale"></i></span>{{ $submenu->label_name }} {{ $submenu->class }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
