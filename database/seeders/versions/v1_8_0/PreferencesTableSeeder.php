<?php

namespace Database\Seeders\versions\v1_8_0;

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

        Preference::updateOrInsert([
            'category' => 'preference',
            'field' => 'db_version',
        ], [
            'value' => '1.8.0',
        ]);
    }
}
