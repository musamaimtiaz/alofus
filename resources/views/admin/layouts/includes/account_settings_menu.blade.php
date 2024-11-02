  <div class="card card-info shadow-none" id="nav">
    <div class="card-header p-t-20 border-bottom mb-2">
        @if (in_array('App\Http\Controllers\AccountSettingController@index', $prms))
            <h5>{{ __('Account Settings') }}</h5>
        @endif
    </div>
    <ul class="nav flex-column nav-pills" id="mcap-tab" role="tablist">
        @foreach (\App\Lib\Menus\Admin\AccountSettings::get() as $liItem)
            @if (isset($liItem['visibility']) && $liItem['visibility'] === false)
                @continue
            @endif

            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) && $list_menu == ($liItem['name'] ?? '') ? 'active' : '' }}"
                    href="{{ $liItem['href'] ?? '#' }}" id="s" role="tab" aria-controls="mcap-default"
                    aria-selected="true">{{ $liItem['label'] }}</a>
            </li>
        @endforeach
    </ul>
  </div>
