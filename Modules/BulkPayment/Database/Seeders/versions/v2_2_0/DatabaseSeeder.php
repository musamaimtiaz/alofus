<?php

namespace Modules\BulkPayment\Database\Seeders\versions\v2_2_0;

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        $this->call([
            OrderStatusesTableSeeder::class,
            PreferenceTableSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
