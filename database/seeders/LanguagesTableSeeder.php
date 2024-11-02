<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('languages')->delete();

        \DB::table('languages')->insert([
            0 => [
                'id' => 1,
                'name' => 'English',
                'short_name' => 'en',
                'flag' => 'en.jpg',
                'status' => 'Active',
                'is_default' => 1,
                'direction' => 'ltr',
            ],
            1 => [
                'id' => 2,
                'name' => 'Bengali',
                'short_name' => 'bn',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            2 => [
                'id' => 3,
                'name' => 'French',
                'short_name' => 'fr',
                'flag' => '',
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            3 => [
                'id' => 4,
                'name' => 'Chinese',
                'short_name' => 'zh',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            4 => [
                'id' => 5,
                'name' => 'Arabic',
                'short_name' => 'ar',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'rtl',
            ],
            5 => [
                'id' => 6,
                'name' => 'Byelorussian',
                'short_name' => 'be',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            6 => [
                'id' => 7,
                'name' => 'Bulgarian',
                'short_name' => 'bg',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            7 => [
                'id' => 8,
                'name' => 'Catalan',
                'short_name' => 'ca',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            8 => [
                'id' => 9,
                'name' => 'Estonian',
                'short_name' => 'et',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
            9 => [
                'id' => 10,
                'name' => 'Dutch',
                'short_name' => 'nl',
                'flag' => null,
                'status' => 'Active',
                'is_default' => 0,
                'direction' => 'ltr',
            ],
        ]);

    }
}
