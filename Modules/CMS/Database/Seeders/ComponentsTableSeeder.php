<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('components')->delete();

        \DB::table('components')->insert([
            0 => [
                'id' => 2,
                'page_id' => 5,
                'layout_id' => 5,
                'level' => 2,
            ],
            1 => [
                'id' => 3,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 3,
            ],
            2 => [
                'id' => 4,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 6,
            ],
            3 => [
                'id' => 6,
                'page_id' => 5,
                'layout_id' => 1,
                'level' => 7,
            ],
            4 => [
                'id' => 15,
                'page_id' => 5,
                'layout_id' => 4,
                'level' => 8,
            ],
            5 => [
                'id' => 16,
                'page_id' => 5,
                'layout_id' => 3,
                'level' => 9,
            ],
            6 => [
                'id' => 17,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 10,
            ],
            7 => [
                'id' => 18,
                'page_id' => 5,
                'layout_id' => 6,
                'level' => 13,
            ],
            8 => [
                'id' => 19,
                'page_id' => 5,
                'layout_id' => 8,
                'level' => 1,
            ],
            81 => [
                'id' => 95,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 4,
            ],
            82 => [
                'id' => 96,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 5,
            ],
            83 => [
                'id' => 97,
                'page_id' => 5,
                'layout_id' => 4,
                'level' => 11,
            ],
            84 => [
                'id' => 98,
                'page_id' => 5,
                'layout_id' => 2,
                'level' => 12,
            ],
            85 => [
                'id' => 99,
                'page_id' => 5,
                'layout_id' => 7,
                'level' => 14,
            ],
        ]);
    }
}
