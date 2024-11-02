<?php

namespace Modules\GeoLocale\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_menus')->upsert([
            [
                'name' => 'Geo Locale',
                'slug' => 'geo-locale',
                'url' => 'geolocale',
                'permission' => '{"permission":"Modules\\\\GeoLocale\\\\Http\\\\Controllers\\\\GeoLocaleController@index", "route_name":["geolocale.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
