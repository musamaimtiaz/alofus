<?php

namespace Database\Seeders\versions\v1_6_0;

use App\Models\Permission;
use App\Models\PermissionRole;
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
        $permissionAdmin = Permission::where('name', 'App\Http\Controllers\ProductController@duplicate');

        if ($permissionAdmin->exists()) {
            $permissionAdmin->delete();
        }

        $permissionVendor = Permission::where('name', 'App\Http\Controllers\Vendor\ProductController@duplicate');

        if ($permissionVendor->exists()) {
            $permissionVendor->delete();
        }

        $permissionId = Permission::insertGetId([
            'name' => 'App\\Http\\Controllers\\ProductController@duplicate',
            'controller_path' => 'App\\Http\\Controllers\\ProductController',
            'controller_name' => 'ProductController',
            'method_name' => 'duplicate',
        ]);

        $permissionId = Permission::insertGetId([
            'name' => 'App\\Http\\Controllers\\Vendor\\ProductController@duplicate',
            'controller_path' => 'App\\Http\\Controllers\\Vendor\\ProductController',
            'controller_name' => 'ProductController',
            'method_name' => 'duplicate',
        ]);

        PermissionRole::insert([
            'permission_id' => $permissionId,
            'role_id' => 2,
        ]);
    }
}
