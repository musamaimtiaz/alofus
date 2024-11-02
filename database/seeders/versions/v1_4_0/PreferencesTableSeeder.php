<?php

namespace Database\Seeders\versions\v1_4_0;

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
        $dbPreference = Preference::where(['field' => 'guest_order'])->first();

        if (! $dbPreference) {
            Preference::insert([
                'category' => 'preference',
                'field' => 'guest_order',
                'value' => 'disable',
            ]);
        }

        Preference::updateOrInsert([
            'category' => 'preference',
            'field' => 'db_version',
        ], [
            'value' => '1.4.0',
        ]);

    }
}
