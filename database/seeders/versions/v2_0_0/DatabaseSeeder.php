<?php

namespace Database\Seeders\versions\v2_0_0;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PreferencesTableSeeder::class,
            PermissionsTableSeeder::class,
        ]);
    }
}
