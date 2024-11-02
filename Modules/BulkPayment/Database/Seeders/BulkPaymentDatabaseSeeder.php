<?php

namespace Modules\BulkPayment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\BulkPayment\Database\Seeders\versions\v2_2_0\DatabaseSeeder;

class BulkPaymentDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $this->call(DatabaseSeeder::class);
    }
}
