<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorUsersTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('vendor_users')->delete();

        \DB::table('vendor_users')->insert([
            0 => [
                'id' => 1,
                'vendor_id' => 1,
                'user_id' => 1,
                'status' => 'Active',
            ],
        ]);

    }
}
