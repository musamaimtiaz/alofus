<?php

namespace Modules\Coupon\Providers;

use Illuminate\Support\ServiceProvider;

class CouponServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        add_filter('add_plan_feature', function ($data) {
            $data['coupon'] = [
                'type' => 'bool',
                'value' => 1,
                'is_value_fixed' => 1,
                'title' => __('Coupon Service'),
                'title_position' => 'before',
                'is_visible' => 1,
                'usage' => 0,
            ];

            return $data;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
