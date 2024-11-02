<?php

namespace Modules\BulkPayment\Database\Seeders\versions\v2_2_0;

use App\Models\{Permission, PermissionRole};
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        $permission = Permission::where('controller_name', 'BulkPaymentController')->first();

        if (empty($permission)) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\BulkPayment\\Http\\Controllers\\Vendor\\BulkPaymentController@order',
                'controller_path' => 'Modules\\BulkPayment\\Http\\Controllers\\Vendor\\BulkPaymentController',
                'controller_name' => 'BulkPaymentController',
                'method_name' => 'order',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
    }
}
