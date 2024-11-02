<?php

namespace Modules\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('departments')->delete();

        \DB::table('departments')->insert([
            0 => [
                'id' => 1,
                'name' => 'Marketing',
            ],
            1 => [
                'id' => 2,
                'name' => 'Sales',
            ],
            2 => [
                'id' => 3,
                'name' => 'Technical',
            ],
        ]);

    }
}
