<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_1_0;

use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Http\Models\Menus;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (! Menus::where('slug', 'sms')->first()) {
            Menus::insert([
                'name' => 'Sms',
                'slug' => 'sms',
                'url' => 'sms/configs',
                'permission' => '{"permission":"App\\\\Http\\\\Controllers\\\\SmsConfigurationController@index", "route_name":["sms.config.index"], "menu_level":"1"}',
                'is_default' => 1,
            ]);
        }
    }
}
