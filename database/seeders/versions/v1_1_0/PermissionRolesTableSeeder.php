<?php

namespace Database\Seeders\versions\v1_1_0;

use App\Models\{
    Permission, PermissionRole
};
use Illuminate\Database\Seeder;

class PermissionRolesTableSeeder extends Seeder
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
            return null;
        }

        $role = PermissionRole::where(['permission_id' => $permission->id, 'role_id' => 2])->first();

        if (! $role) {
            \DB::table('permission_roles')->insert([
                'permission_id' => $permission->id,
                'role_id' => 2,
            ]);
        }
    }
}
