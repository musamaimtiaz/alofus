<?php

namespace Modules\GeoLocale\Database\Seeders;

use Illuminate\Database\Seeder;

class GeoLocaleContinentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('geolocale_continents')->delete();

        \DB::table('geolocale_continents')->insert([
            0 => [
                'id' => 1,
                'name' => 'Asia',
                'code' => 'as',
            ],
            1 => [
                'id' => 2,
                'name' => 'Europe',
                'code' => 'eu',
            ],
            2 => [
                'id' => 3,
                'name' => 'Africa',
                'code' => 'af',
            ],
            3 => [
                'id' => 4,
                'name' => 'Oceania',
                'code' => 'oc',
            ],
            4 => [
                'id' => 5,
                'name' => 'Antarctica',
                'code' => 'an',
            ],
            5 => [
                'id' => 6,
                'name' => 'North America',
                'code' => 'na',
            ],
            6 => [
                'id' => 7,
                'name' => 'South America',
                'code' => 'sa',
            ],
        ]);

    }
}
