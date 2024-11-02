<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('roles')->delete();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'name' => 'Admin',
                'slug' => 'super-admin',
                'type' => 'global',
                'description' => 'Super admin description',
                'vendor_id' => null,

                'updated_at' => '2021-10-10 08:41:07',
            ],
            1 => [
                'id' => 2,
                'name' => 'Vendor Admin',
                'slug' => 'vendor-admin',
                'type' => 'vendor',
                'description' => 'Vendor admin description',
                'vendor_id' => null,

                'updated_at' => '2021-10-11 08:41:07',
            ],
            2 => [
                'id' => 3,
                'name' => 'Customer',
                'slug' => 'customer',
                'type' => 'global',
                'description' => 'Customer description',
                'vendor_id' => null,

                'updated_at' => '2021-10-11 09:41:07',
            ],
            3 => [
                'id' => 4,
                'name' => 'Guest',
                'slug' => 'guest',
                'type' => 'global',
                'description' => 'Guest description',
                'vendor_id' => null,

                'updated_at' => '2021-10-11 09:42:07',
            ],
        ]);

    }
}
