<?php

namespace Database\Seeders\versions\v1_1_0;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $permission = Permission::where(['name' => 'App\\Http\\Controllers\\Vendor\\ExportController@productExport'])->first();

        if (! $permission) {
            \DB::table('permissions')->insert([
                'name' => 'App\Http\Controllers\Vendor\ExportController@productExport',
                'controller_path' => 'App\Http\Controllers\Vendor\ExportController',
                'controller_name' => 'ExportController',
                'method_name' => 'productExport',
            ]);
        }
    }
}
