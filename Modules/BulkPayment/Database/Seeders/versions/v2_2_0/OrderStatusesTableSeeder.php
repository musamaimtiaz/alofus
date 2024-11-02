<?php

namespace Modules\BulkPayment\Database\Seeders\versions\v2_2_0;

use App\Models\{OrderStatus, OrderStatusRole};
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    public function run()
    {

        $orderStatus = OrderStatus::where('slug', 'partial-payment')->first();

        if (empty($orderStatus)) {
            $orderStatusId = OrderStatus::insertGetId([
                'name' => 'Partial Payment',
                'slug' => 'partial-payment',
                'color' => '#9FA9A2',
                'payment_scenario' => 'unpaid',
                'is_default' => 0,
                'order_by' => 8,
            ]);

            OrderStatusRole::insert([
                'order_status_id' => $orderStatusId,
                'role_id' => 1,
            ]);

            OrderStatusRole::insert([
                'order_status_id' => $orderStatusId,
                'role_id' => 2,
            ]);
        }
    }
}
