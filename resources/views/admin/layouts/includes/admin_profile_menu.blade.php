    <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
            <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'users.profile' ? 'active' : '' }}" href="{{ route('users.profile') }}" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Profile') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'notifications.index' ? 'active' : '' }}" href="{{ route('notifications.index') }}" role="tab" aria-controls="mcap-default" aria-selected="false">{{ __('Notification') }}</a>
        </li>
    </ul>
