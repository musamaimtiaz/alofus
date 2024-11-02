<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v1_1_0;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuItemTableSeeder::class);
    }
}
