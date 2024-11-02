<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;

class BlogCategoriesWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('blog_categories')->delete();

        \DB::table('blog_categories')->insert([
            0 => [
                'id' => 1,
                'name' => 'Uncategorized',
                'status' => 'Active',
            ],
        ]);
    }
}
