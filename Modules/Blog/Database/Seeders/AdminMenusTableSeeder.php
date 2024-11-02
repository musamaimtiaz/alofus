<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menus')->upsert([
            ['name' => 'Blog Category', 'slug' => 'blog-category', 'url' => 'blog/category/list', 'permission' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogCategoryController@index", "route_name":["blog.category.index"], "menu_level":"1"}', 'is_default' => 1],
            ['name' => 'Blog', 'slug' => 'blog', 'url' => 'blogs', 'permission' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogController@index", "route_name":["blog.index", "blog.create", "blog.edit"], "menu_level":"1"}', 'is_default' => 1],
        ], 'slug');

    }
}
