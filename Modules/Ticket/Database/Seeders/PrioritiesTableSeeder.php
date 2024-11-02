<?php

namespace Modules\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('priorities')->delete();

        \DB::table('priorities')->insert([
            0 => [
                'id' => 3,
                'name' => 'High',
            ],
            1 => [
                'id' => 1,
                'name' => 'Low',
            ],
            2 => [
                'id' => 2,
                'name' => 'Medium',
            ],
        ]);

    }
}
