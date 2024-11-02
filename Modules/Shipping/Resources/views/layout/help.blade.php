<table class="table table-bordered tax-help-table">
    <thead>
        <tr>
            <th colspan="2">{{ __('Shipping') }}</th>
        </tr>
    </thead>
    <tr>
        <th>{{ __('Classes') }}</th>
    </tr>
    <tr>
        <th>{{ __('Name') }}</th>
        <td>
            <ul>
                <li>{{ __('Name will show in your product create or edit shipping section') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Slug') }}</th>
        <td>
            <ul>
                <li>{{ __('Slug should not be empty.') }}</li>
                <li>{{ __('Slug help to identify shipping class.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Description') }}</th>
        <td>
            <ul>
                <li>{{ __('You can note down here.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Product Count') }}</th>
        <td>
            <ul>
                <li>{{ __('How many product use the class.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Zone => Location') }}</th>
    </tr>
    <tr>
        <th>{{ __('Country') }}</th>
        <td>
            <ul>
                <li>{{ __('Leave blank to apply to all countries') }}</li>
                <li>{{ __('Country should be country code.') }}</li>
                <li>{!! __('You can get country code to visit the :x', ['x' => '<u><a href=' . route('geolocale.index') . ' target="_blank">' . __("link") . '</a></u>']) !!}</li>
                <li>{{ __('Now you can see country code near of country name.') }}</li>
                <li>{{ __('Example') }}: US</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('State') }}</th>
        <td>
            <ul>
                <li>{{ __('Leave blank to apply to all states') }}</li>
                <li>{{ __('State should be state code.') }}</li>
                <li>{!! __('You can get state code to visit the :x', ['x' => '<u><a href=' . route('geolocale.index') . ' target="_blank">' . __("link") . '</a></u>']) !!}</li>
                <li>{{ __('Now you need to select a country, after that you can see state code near of state name.') }}</li>
                <li>{{ __('Example') }}: 23</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('City') }}</th>
        <td>
            <ul>
                <li>{{ __('Leave blank to apply to all cities') }}</li>
                <li>{{ __('City should be city name or code.') }}</li>
                <li>{!! __('You can get city name to visit the :x', ['x' => '<u><a href=' . route('geolocale.index') . ' target="_blank">' . __("link") . '</a></u>']) !!}</li>
                <li>{{ __('Now you need to select a country, after that select a state, now you can see city name.') }}</li>
                <li>{{ __('Example') }}: Alatna</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('ZIP') }}</th>
        <td>
            <ul>
                <li>{{ __('Leave blank to apply to all areas.') }}</li>
                <li>{{ __('ZIP should be area zip code.') }}</li>
                <li>{{ __('Example') }}: 25786</li>
            </ul>
        </td>
    </tr>

    <tr>
        <th>{{ __('Zone => Free Shipping') }}</th>
    </tr>
    <tr>
        <th>{{ __('Title') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see the title when shpping is apply in cart section.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Free Shipping require') }}</th>
        <td>
            <ul>
                <li>{{ __('Free shipping condition.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Status') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see only active status shipping method in cart section.') }}</li>
            </ul>
        </td>
    </tr>

    <tr>
        <th>{{ __('Zone => Local Pickup') }}</th>
    </tr>
    <tr>
        <th>{{ __('Title') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see the title when shpping is apply in cart section.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Tax Status') }}</th>
        <td>
            <ul>
                <li>{{ __('Define the shipping method is taxable or not.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Cost') }}</th>
        <td>
            <ul>
                <li>{{ __('Optional cost for local pickup.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Status') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see only active status shipping method in cart section.') }}</li>
            </ul>
        </td>
    </tr>

    <tr>
        <th>{{ __('Zone => Flat Rate') }}</th>
    </tr>
    <tr>
        <th>{{ __('Title') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see the title when shpping is apply in cart section.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Tax Status') }}</th>
        <td>
            <ul>
                <li>{{ __('Define the shipping method is taxable or not.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Cost') }}</th>
        <td>
            <ul>
                <li>{{ __('Flat rate cost.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Status') }}</th>
        <td>
            <ul>
                <li>{{ __('User can see only active status shipping method in cart section.') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Shipping Class cost') }}</th>
        <td>
            <ul>
                <li>{{ __('This cost is apply if this shipping class apply in product') }}</li>
            </ul>
        </td>
    </tr>

    <tr>
        <th>{{ __('Calculation type') }}</th>
        <td>
            <ul>
                <li>{{ __('Per Class: All class cost are apply') }}</li>
                <li>{{ __('If multiple product add in cart and they have multiple class,') }}</li>
                <li>{{ __('Per Order: Most expensive shipping cost apply') }}</li>
                <li>{{ __('If multiple product add in cart and they have multiple class,') }}</li>
            </ul>
        </td>
    </tr>

</table>
