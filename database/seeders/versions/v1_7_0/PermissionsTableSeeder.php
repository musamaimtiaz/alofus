<?php

namespace Database\Seeders\versions\v1_7_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CustomerController@index')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CustomerController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CustomerController',
                'controller_name' => 'CustomerController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 1,
                ],
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ],
            ]);
        }
    }
}
