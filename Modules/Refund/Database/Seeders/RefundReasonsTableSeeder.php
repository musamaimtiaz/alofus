<?php

namespace Modules\Refund\Database\Seeders;

use Illuminate\Database\Seeder;

class RefundReasonsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('refund_reasons')->delete();

        \DB::table('refund_reasons')->insert([
            0 => [
                'id' => 4,
                'name' => 'Accidental order',
                'status' => 'Active',
            ],
            1 => [
                'id' => 5,
                'name' => 'Arrived too late',
                'status' => 'Active',
            ],
            2 => [
                'id' => 6,
                'name' => 'Missing parts or accessories',
                'status' => 'Active',
            ],
            3 => [
                'id' => 7,
                'name' => 'Damaged during shipping',
                'status' => 'Active',
            ],
            4 => [
                'id' => 8,
                'name' => 'Wrong item sent',
                'status' => 'Active',
            ],
            5 => [
                'id' => 9,
                'name' => 'Product is the wrong color',
                'status' => 'Active',
            ],
            6 => [
                'id' => 10,
                'name' => 'Better price available',
                'status' => 'Active',
            ],
            7 => [
                'id' => 11,
                'name' => 'Different from what was ordered',
                'status' => 'Active',
            ],
            8 => [
                'id' => 12,
                'name' => 'I haven\'t received this item yet',
                'status' => 'Pending',
            ],
            9 => [
                'id' => 13,
                'name' => 'Product description was inaccurate',
                'status' => 'Active',
            ],
            10 => [
                'id' => 14,
                'name' => 'Not satisfied with the quality',
                'status' => 'Active',
            ],
            11 => [
                'id' => 15,
                'name' => 'Did not like the color',
                'status' => 'Active',
            ],
            12 => [
                'id' => 16,
                'name' => 'Other reason',
                'status' => 'Active',
            ],
        ]);

    }
}
