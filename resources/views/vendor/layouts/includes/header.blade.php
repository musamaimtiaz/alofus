<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header header-background-color">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="{{ url('vendor/dashboard') }}" class="b-brand">
            <span class="b-title">{{ trimWords(preference('company_name'), 17) }}</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav d-flex flex-row flex-wrap nav-menu ltr:float-left ltr:me-auto ltr:ms-2 rtl:float-right rtl:ms-auto rtl:me-2">
            @foreach (\App\Lib\Menus\Vendor\TopHeaderLeftMenu::get() as $liItem)
                @if (isset($liItem['visibility']) && $liItem['visibility'] === false)
                    @continue
                @endif

                <li class="ltr:ms-3 rtl:me-3 nav-parent">
                    {!! $liItem['item'] !!}
                </li>
            @endforeach
            
        </ul>
        <?php
            $flag = config('app.locale');
        ?>
        <ul class="navbar-nav nav-icon ltr:ms-lg-auto ltr:ms-2 ltr:me-lg-2 rtl:me-lg-auto rtl:me-2 rtl:ms-lg-2">
            <li>
                <div class="dropdown">
                    <span class="text-dark ms-1">{{ auth()->user()->vendors()->first()?->notifications->whereNull('read_at')->count() }}</span>
                    <a class="dropdown-toggle header-notification-icon" href="#" data-bs-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                    <div class="dropdown-menu dropdown-menu-right notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">{{ __('Notifications') }}</h6>
                            <div class="float-right">
                                <a href="{{ route('vendor.notifications.mark_read_all') }}" class="m-r-10">{{ __('mark all as read') }}</a>
                            </div>
                        </div>
                        <ul class="noti-body scroll-noti header-notification-body">
                            
                        </ul>
                        <div class="noti-footer">
                            <a href="{{ route('vendor.notifications.index') }}">{{ __('show all') }}</a>
                        </div>
                    </div>
                </div>
            </li>
            @php
                $languages  = \App\Models\Language::getAll()->where('status', 'Active');
            @endphp
            @if ($languages->isNotEmpty())
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle flag flag-icon-background flag-icon-{{ getSVGFlag($flag) }}" id="dropdown-flag" href="javascript:" data-bs-toggle="dropdown"></a>
                    <div class="dropdown-menu dropdown-menu-right notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">{{ __('Select Language') }}</h6>
                        </div>
                        <ul class="noti-body scroll-noti">
                            @foreach($languages as $language)
                            <li class="notification">
                                <div class="media lang d-flex" id="{{ $language->short_name }}" data-shortname="{{ $language->short_name }}" >
                                    <img class="img-radius" src='{{ url("public/datta-able/fonts/flag/flags/4x3/". getSVGFlag($language->short_name) .".svg") }}' alt="{{ $language->flag }}">
                                    <div class="media-body">
                                        <p><span>{{ $language->name }}</span></p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
            @endif
            <li class="ltr:me-2 rtl:ms-2">
                <div class="dropdown drp-user">
                    <a href="javascript:" class="dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                        <i class="icon feather icon-settings f-20 ltr:ms-0 rtl:me-0"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            <img src="{{ Auth::user()->fileUrl() }}" class="img-radius" alt="User-Profile-Image">
                            <span>{{ wrapIt(Auth::user()->name, 20) }}</span>
                            <a href="{{ url('/vendor/logout') }}" class="dud-logout" title="Logout">
                                <i class="feather icon-log-out"></i>
                            </a>
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{ url('vendor/profile') }}" class="dropdown-item"><i class="feather icon-user"></i> {{ __('Profile') }}</a></li>
                            <li><a href="{{ route('vendor.loginActivity') }}" class="dropdown-item"><i class="feather icon-activity"></i> {{ __('Login Activities') }}</a></li>
                            <li><a href="{{ url('/vendor/logout') }}" class="dropdown-item"><i class="feather icon-lock"></i> {{ __('Sign Out') }}</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="notification-loader d-none">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-grow w-40p h-40" role="status"></div>
        </div>
    </div>
</header>
