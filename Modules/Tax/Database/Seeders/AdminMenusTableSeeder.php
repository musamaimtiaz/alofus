<?php

namespace Modules\Tax\Database\Seeders;

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
                'name' => 'Tax',
                'slug' => 'tax',
                'url' => 'taxes',
                'permission' => '{"permission":"Modules\\\\Tax\\\\Http\\\\Controllers\\\\TaxClassController@index", "route_name":["tax.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
