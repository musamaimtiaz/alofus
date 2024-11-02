<?php

namespace Modules\Ticket\Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_menus')->upsert([
            [
                'name' => 'Tickets',
                'slug' => 'Ticket',
                'url' => 'ticket/list',
                'permission' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@index", "route_name":["admin.tickets", "admin.threadReply", "admin.threadEdit", "admin.threadPdf", "admin.threadCsv", "admin.threadAdd", "admin.changePriority"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Add Ticket',
                'slug' => 'add-ticket',
                'url' => 'ticket/add',
                'permission' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@index", "route_name":["admin.threadAdd"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'All Ticket',
                'slug' => 'all-ticket',
                'url' => 'ticket/list',
                'permission' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@index", "route_name":["admin.tickets"], "menu_level":"1"}',
                'is_default' => 1,
            ],
            [
                'name' => 'Tickets',
                'slug' => 'vendor-ticket',
                'url' => 'ticket/list',
                'permission' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\Vendor\\\\TicketController@index", "route_name":["vendor.threads", "vendor.threadAdd", "vendor.threadReply", "vendor.threadPdf", "vendor.threadCsv"], "menu_level":"3"}',
                'is_default' => 1,
            ],
        ], 'slug');
    }
}
