<?php

namespace Modules\FormBuilder\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->upsert([
            [
                'name' => 'All Forms',
                'slug' => 'forms',
                'url' => 'forms',
                'permission' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\FormController@index", "route_name":["formbuilder::forms.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'All Submissions',
                'slug' => 'submissions',
                'url' => 'forms/submissions',
                'permission' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\SubmissionController@index", "route_name":["formbuilder::submissions.all"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Kyc',
                'slug' => 'kyc-form',
                'url' => 'forms/kyc-form',
                'permission' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\KycController@index", "route_name":["formbuilder::kyc.index"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Kyc',
                'slug' => 'vendor-kyc-form',
                'url' => 'vendor/kyc',
                'permission' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\Vendor\\\\KycController@index", "route_name":["formbuilder::kyc.show"], "menu_level":"3"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
