<?php

namespace Database\Seeders\versions\v1_3_0;

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

        $dbPreference = Preference::where(['field' => 'app_open_url'])->first();

        if (! $dbPreference) {
            Preference::insert([
                'category' => 'preference',
                'field' => 'app_open_url',
                'value' => 'com.medul.martvill://login',
            ]);
        }

        Preference::updateOrInsert([
            'category' => 'preference',
            'field' => 'db_version',
        ], [
            'value' => '1.3.0',
        ]);
    }
}
