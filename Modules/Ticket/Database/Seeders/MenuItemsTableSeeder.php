<?php

namespace Modules\Ticket\Database\Seeders;

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
            ['id' => 130, 'label' => 'Tickets', 'link' => 'ticket/list', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\Vendor\\\\TicketController@index", "route_name":["vendor.threads", "vendor.threadAdd", "vendor.threadReply", "vendor.threadPdf", "vendor.threadCsv"]}', 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 11, 'class' => null, 'menu' => 3, 'depth' => 0],

            ['id' => 103, 'label' => 'Add Ticket', 'link' => 'ticket/add', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@add", "route_name":["admin.threadAdd"]}', 'is_default' => 1, 'icon' => null, 'parent' => 90, 'sort' => 45, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 104, 'label' => 'All Tickets', 'link' => 'ticket/list', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@index", "route_name":["admin.tickets", "admin.threadReply", "admin.threadEdit", "admin.threadPdf", "admin.changePriority"]}', 'is_default' => 1, 'icon' => null, 'parent' => 90, 'sort' => 46, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 90, 'label' => 'Support Tickets', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 44, 'class' => null, 'menu' => 1, 'depth' => 0],

        ], 'id');
    }
}
