<?php

namespace Modules\Shipping\Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('shipping_methods')->delete();

        \DB::table('shipping_methods')->insert([
            0 => [
                'id' => 1,
                'name' => 'Free shipping',
                'description' => null,
                'status' => 'Active',
            ],
            1 => [
                'id' => 2,
                'name' => 'Local Pickup',
                'description' => null,
                'status' => 'Active',
            ],
            2 => [
                'id' => 3,
                'name' => 'Fixed',
                'description' => null,
                'status' => 'Active',
            ],
        ]);

    }
}
