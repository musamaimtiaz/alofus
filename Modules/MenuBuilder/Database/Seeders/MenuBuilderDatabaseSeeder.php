<?php

namespace Modules\MenuBuilder\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Database\Seeders\versions\{
    v1_1_0\DatabaseSeeder as V11DatabaseSeeder,
    v1_7_0\DatabaseSeeder as V17DatabaseSeeder,
    v2_0_0\DatabaseSeeder as V20DatabaseSeeder,
    v2_1_0\DatabaseSeeder as V21DatabaseSeeder,
};

class MenuBuilderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(MenusTableSeeder::class);
        $this->call(MenuItemsTableWithoutDummyDataSeeder::class);
        $this->call(AdminMenusTableSeeder::class);
        $this->call(V11DatabaseSeeder::class);
        $this->call(V17DatabaseSeeder::class);
        $this->call(V20DatabaseSeeder::class);
        $this->call(V21DatabaseSeeder::class);
    }
}
