<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleUsersTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('role_users')->delete();

        \DB::table('role_users')->insert([
            0 => [
                'role_id' => 1,
                'user_id' => 1,
            ],
        ]);

    }
}
