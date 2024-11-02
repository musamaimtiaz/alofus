<?php

namespace Database\Seeders\versions\v1_7_0;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Preference::insertOrIgnore([
            [
                'category' => 'product_vendor',
                'field' => 'is_vendor_customer_list_active',
                'value' =>  1,
            ],
        ]);

        Preference::updateOrInsert([
            'category' => 'preference',
            'field' => 'db_version',
        ], [
            'value' => '1.7.0',
        ]);
    }
}
