<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->upsert([
            ['id' => 54, 'label' => 'Categories', 'link' => 'blog/category/list', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogCategoryController@index", "route_name":["blog.category.index"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 25, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 55, 'label' => 'Add Post', 'link' => 'blog/create', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogController@create", "route_name":["blog.create"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 23, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 59, 'label' => 'All Posts', 'link' => 'blogs', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogController@index", "route_name":["blog.index", "blog.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 24, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 56, 'label' => 'Blogs', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fab fa-blogger-b', 'parent' => 0, 'sort' => 22, 'class' => null, 'menu' => 1, 'depth' => 0],
        ], 'id');

    }
}
