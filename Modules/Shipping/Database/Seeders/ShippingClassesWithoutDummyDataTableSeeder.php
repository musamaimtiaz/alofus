<?php

namespace Modules\Shipping\Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingClassesWithoutDummyDataTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('shipping_classes')->delete();

        \DB::table('shipping_classes')->insert([
            0 => [
                'id' => 1,
                'name' => 'No shipping class cost',
                'slug' => 'no-class',
                'description' => null,
                'product_count' => 0,
            ],
        ]);

    }
}
