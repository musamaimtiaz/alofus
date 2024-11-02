<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->delete();

        \DB::table('users')->insert([
            0 => [
                'id' => 1,
                'name' => 'Agatha Williams',
                'email' => 'admin@techvill.net',
                'email_verified_at' => null,
                'password' => '$2y$10$zXgnp.9rIXbNYr3ZUo7xVOWUhKKHXJZ63nBgT1zLFgi0CG6RUgfxG',
                'phone' => null,
                'birthday' => null,
                'gender' => 'Male',
                'address' => null,
                'sso_account_id' => null,
                'sso_service' => null,
                'remember_token' => null,
                'status' => 'Active',
                'activation_code' => null,
                'activation_otp' => null,
            ],
        ]);

    }
}
