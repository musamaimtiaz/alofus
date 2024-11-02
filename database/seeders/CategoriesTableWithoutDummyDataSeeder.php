<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('categories')->delete();

        \DB::table('categories')->insert([
            0 => [
                'id' => 1,
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'parent_id' => null,
                'order_by' => 1,
                'is_searchable' => 1,
                'is_featured' => 0,
                'product_counts' => 0,
                'sell_commissions' => null,
                'status' => 'Active',
                'is_global' => 1,
            ],
            1 => [
                'id' => 2,
                'name' => 'Category 1',
                'slug' => 'category-1',
                'parent_id' => null,
                'order_by' => 1,
                'is_searchable' => 1,
                'is_featured' => 0,
                'product_counts' => 0,
                'sell_commissions' => null,
                'status' => 'Active',
                'is_global' => 1,
            ],
            2 => [
                'id' => 3,
                'name' => 'Category 2',
                'slug' => 'category-2',
                'parent_id' => null,
                'order_by' => 1,
                'is_searchable' => 1,
                'is_featured' => 0,
                'product_counts' => 0,
                'sell_commissions' => null,
                'status' => 'Active',
                'is_global' => 1,
            ],
        ]);
    }
}
