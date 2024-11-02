<?php

namespace Modules\MenuBuilder\Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('menus')->delete();

        \DB::table('menus')->insert([
            0 => [
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2021-12-13 10:08:14',
                'updated_at' => null,
            ],
            1 => [
                'id' => 2,
                'name' => 'user',
                'created_at' => '2021-12-20 04:41:40',
                'updated_at' => null,
            ],
            2 => [
                'id' => 3,
                'name' => 'vendor',
                'created_at' => '2021-12-20 09:43:47',
                'updated_at' => null,
            ],
            3 => [
                'id' => 4,
                'name' => 'public header',
                'created_at' => '2021-12-20 09:43:48',
                'updated_at' => null,
            ],
        ]);

    }
}
