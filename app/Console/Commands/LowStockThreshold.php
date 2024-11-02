<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Notifications\LowStockThresholdNotification;
use Illuminate\Console\Command;

class LowStockThreshold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:threshold';

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
        $products = Product::published()->isAvailable()->where('manage_stocks', 1)->whereNotNull('vendor_id')->whereHas('metadata', function ($query) {
            $query->where('key', 'meta_stock_threshold')->whereNotNull('value')->where('value', '!=', '');
        })->groupBy('vendor_id')->get();

        foreach ($products as $product) {
            $vendorProducts = Product::published()->isAvailable()->where('manage_stocks', 1)->where('vendor_id', $product->vendor_id)->whereHas('metadata', function ($query) {
                $query->where('key', 'meta_stock_threshold')->whereNotNull('value')->where('value', '!=', '');
            })->get();
            $productHtml = '';
            foreach ($vendorProducts as $key => $vendorProduct) {
                if ($vendorProduct->total_stocks <= (int) $vendorProduct->meta_stock_threshold) {
                    $route = route('vendor.product.edit', $vendorProduct->type == 'Variation' ? $vendorProduct->parentDetail->code : $vendorProduct->code);
                    $productHtml .= "<a href='$route' style='text-decoration: underline; cursor: pointer; color: #0060a9;'>" . $product->name . '</a>';
                    $productHtml .= count($vendorProducts) - 1 != $key + 1 ? ', ' : null;
                }
            }

            $data = ['vendor_name' => $product->vendor->name, 'email' => $product->vendor->email, 'product_list' => $productHtml];

            if ($productHtml != '') {
                $product->vendor->notify(new LowStockThresholdNotification($data));
            }
        }

    }
}
