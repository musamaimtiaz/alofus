<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorsTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('vendors')->delete();

        \DB::table('vendors')->insert([
            0 => [
                'id' => 1,
                'name' => 'Gizmo Tizmo',
                'email' => 'admin@techvill.net',
                'phone' => '01854789632',
                'formal_name' => 'Agatha Williams',
                'status' => 'Active',
                'website' => null,
                'sell_commissions' => '0.00000000',
                'deleted_at' => null,
            ],
        ]);

    }
}
