<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'users.edit' ? 'active' : '' }}" href="{{ route('users.edit', ['id' => $user->id ?? request()->user_id]) }}" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Profile') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link h-lightblue ltr:pe-2 rtl:ps-2 {{ Route::currentRouteName() == 'notifications.index' ? 'active' : '' }}" href="{{ route('notifications.index', ['user_id' => $user->id ?? request()->user_id]) }}" role="tab" aria-controls="mcap-default" aria-selected="false">{{ __('Notification') }}</a>
    </li>
</ul>
