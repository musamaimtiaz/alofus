<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class HoldStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hold:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stockMinutes = preference('hold_stock');

        if (! empty($stockMinutes) && $stockMinutes > 0) {
            $unpaidOrders = Order::where('payment_status', 'Unpaid')->get();

            foreach ($unpaidOrders as $order) {
                $timeFormNow = $order->created_at->diffInMinutes(\Carbon\Carbon::now());

                if ($timeFormNow > $stockMinutes && ! in_array(optional($order->paymentMethod)->gateway, offLinePayments()) && $order->order_status_id != 6) {

                    foreach ($order->orderDetails as $detail) {
                        $detail->updateOrder(['order_status_id' => 6], $detail->id);
                    }

                    $order->updateOrder(['order_status_id' => 6], $order->id);
                }
            }
        }
    }
}
