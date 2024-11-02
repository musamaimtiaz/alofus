<?php

namespace Modules\Tax\Database\Seeders;

use Illuminate\Database\Seeder;

class TaxClassesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('tax_classes')->delete();

        \DB::table('tax_classes')->insert([
            0 => [
                'id' => 1,
                'name' => 'Standard',
                'slug' => 'standard',
            ],
        ]);

    }
}
