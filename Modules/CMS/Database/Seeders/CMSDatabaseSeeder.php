<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CMS\Database\Seeders\versions\v1_1_0\DatabaseSeeder as V11DatabaseSeeder;

class CMSDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PageTableWithoutDummyDataSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(SlidesTableSeeder::class);
        $this->call(AdminMenusTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(ThemeOptionsTableSeeder::class);
        $this->call(TemplateAndLayoutSeeder::class);
        $this->call(ComponentsTableSeeder::class);
        $this->call(ComponentPropertiesTableSeeder::class);
        $this->call(V11DatabaseSeeder::class);
    }
}
