<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('sliders')->delete();

        \DB::table('sliders')->insert([
            0 => [
                'id' => 1,
                'name' => 'Home Page',
                'slug' => 'home-page',
                'status' => 'Active',
            ],
        ]);
    }
}
