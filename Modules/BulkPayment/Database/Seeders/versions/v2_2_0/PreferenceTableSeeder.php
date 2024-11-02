<?php

namespace Modules\BulkPayment\Database\Seeders\versions\v2_2_0;

use App\Models\Preference;
use Illuminate\Database\Seeder;

class PreferenceTableSeeder extends Seeder
{
    public function run()
    {

        $preference = Preference::where('field', 'bulk_pay_count')->first();

        if (empty($preference)) {

            $data = [
                0 =>   [
                    'category' => 'preference',
                    'field' => 'bulk_pay_count',
                    'value' => '20',
                ],
                1 => [
                    'category' => 'preference',
                    'field' => 'bulk_payment_user_role',
                    'value' => '["2"]',
                ],
            ];

            Preference::insert($data);
        }
    }
}
