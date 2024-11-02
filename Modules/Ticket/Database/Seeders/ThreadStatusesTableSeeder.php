<?php

namespace Modules\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;

class ThreadStatusesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('thread_statuses')->delete();

        \DB::table('thread_statuses')->insert([
            0 => [
                'id' => 1,
                'name' => 'Not Started',
                'status_order' => 1,
                'color' => '#F22012',
            ],
            1 => [
                'id' => 2,
                'name' => 'In Progress',
                'status_order' => 3,
                'color' => '#04a9f5',
            ],
            2 => [
                'id' => 3,
                'name' => 'Testing',
                'status_order' => 4,
                'color' => '#5a4d4d',
            ],
            3 => [
                'id' => 4,
                'name' => 'Complete',
                'status_order' => 5,
                'color' => '#00b894',
            ],
            4 => [
                'id' => 5,
                'name' => 'On Hold',
                'status_order' => 2,
                'color' => '#fdcb6e',
            ],
            5 => [
                'id' => 6,
                'name' => 'Open',
                'status_order' => 6,
                'color' => '#F22012',
            ],
            6 => [
                'id' => 7,
                'name' => 'Answered',
                'status_order' => 7,
                'color' => '#0000ff',
            ],
        ]);

    }
}
