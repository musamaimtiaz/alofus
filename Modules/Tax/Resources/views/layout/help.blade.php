<table class="table table-bordered help-table tax-help-table">
    <thead>
        <tr>
            <th colspan="2">{{ __('Tax rate') }}</th>
        </tr>
    </thead>
    <tr>
        <th class="tax-table">{{ __('Name') }}</th>
        <td>
            <ul>
                <li>{{ __('This name will be visible for users, when the tax rate will be apply.') }}</li>
            </ul>
        </td>
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
                <li>{{ __('City should be city name') }}</li>
                <li>{!! __('You can get city name to visit the :x', ['x' => '<u><a href=' . route('geolocale.index') . ' target="_blank">' . __("link") . '</a></u>']) !!}</li>
                <li>{{ __('Now you need to select a country, after that select a state, now you can see city name.') }}</li>
                <li>{{ __('Example') }}: Alatna</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Post code') }}</th>
        <td>
            <ul>
                <li>{{ __('Leave blank to apply to all areas.') }}</li>
                <li>{{ __('Post code should be area zip code.') }}</li>
                <li>{{ __('Example') }}: 25786</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Rate') }}%</th>
        <td>
            <ul>
                <li>{{ __('Tax rate calculation') }}</li>
                <li>{{ __("Your math would be simply: [product price] x [rate] = [tax].") }}</li>
                <li>{{ __('Example: product price = $100, rate = 5') }}</li>
                <li>{{ __("That's $100 x . 05 = $5. Since you've figured out the sales tax is $5, that means the total user will pay is $105.") }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Priority') }}</th>
        <td>
            <ul>
                <li>{{ __('Choose a priority for this tax rate.') }}</li>
                <li>{{ __('Only 1 matching rate per priority will be used.') }}</li>
                <li>{{ __('To define multiple tax rates for a single area you need to specify a defferenct priority per rate') }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Compound') }}</th>
        <td>
            <ul>
                <li>{{ __("A compound tax is calculated on top of the primary tax.") }}</li>
                <li>{{ __("Let's take an example where the price of an product is $100. After calculating the primary tax at 10%, the product is now $110.") }}</li>
                <li>{{ __("A compound tax of 5% will bring the total product price to $110 + 5% = $115.50.") }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <th>{{ __('Shipping') }}</th>
        <td>
            <ul>
                <li>{{ __('Choose whether or not this tax rate also gets applied to shipping.') }}</li>
            </ul>
        </td>
    </tr>
</table>
