<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'vendor.profile' ? 'active' : '' }}" href="{{ route('vendor.profile') }}" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Profile') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'vendor.notifications.index' ? 'active' : '' }}" href="{{ route('vendor.notifications.index') }}" role="tab" aria-controls="mcap-default" aria-selected="false">{{ __('Notification') }}</a>
    </li>
</ul>
