
<!-- Profile Image -->
<div class="card card-info display_block" id="nav">
    <div class="card-header p-t-20">
        <h5><a href="{{ route('currency.index') }}" id="general-settings">{{ __('Manage Product') }}</a></h5>
    </div>
    <ul class="nav nav-pills nav-stacked" id="mcap-tab" role="tablist">
        @if (in_array('App\Http\Controllers\ProductSettingController@general', $prms))
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'general' ? 'active' : ''}}" href="{{ route('product.setting.general') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('General') }}</a>
            </li>
        @endif

        @if (in_array('App\Http\Controllers\ProductSettingController@inventory', $prms))
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'inventory' ? 'active' : ''}}" href="{{ route('product.setting.inventory') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Inventory') }}</a>
            </li>
        @endif

        @if (in_array('App\Http\Controllers\ProductSettingController@vendor', $prms))
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'vendor' ? 'active' : ''}}" href="{{ route('product.setting.vendor') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Vendor') }}</a>
            </li>
        @endif
    </ul>
</div>
<!-- /.box-body -->
