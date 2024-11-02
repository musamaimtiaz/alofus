<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderStatusRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('order_status_roles')->delete();

        \DB::table('order_status_roles')->insert([
            0 => [
                'order_status_id' => 1,
                'role_id' => 1,
            ],
            1 => [
                'order_status_id' => 1,
                'role_id' => 2,
            ],
            2 => [
                'order_status_id' => 2,
                'role_id' => 1,
            ],
            3 => [
                'order_status_id' => 2,
                'role_id' => 2,
            ],
            4 => [
                'order_status_id' => 3,
                'role_id' => 1,
            ],
            5 => [
                'order_status_id' => 4,
                'role_id' => 1,
            ],
            6 => [
                'order_status_id' => 5,
                'role_id' => 1,
            ],
            7 => [
                'order_status_id' => 3,
                'role_id' => 2,
            ],
            8 => [
                'order_status_id' => 4,
                'role_id' => 2,
            ],
            9 => [
                'order_status_id' => 5,
                'role_id' => 2,
            ],
            10 => [
                'order_status_id' => 6,
                'role_id' => 2,
            ],
            11 => [
                'order_status_id' => 7,
                'role_id' => 2,
            ],
            12 => [
                'order_status_id' => 6,
                'role_id' => 1,
            ],
            13 => [
                'order_status_id' => 7,
                'role_id' => 1,
            ],
        ]);

    }
}
