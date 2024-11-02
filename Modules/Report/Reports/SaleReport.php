<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class SaleReport
{
    /**
     * Sale Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getSaleReport(request()->from, request()->to, request()->orderStatus);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'date' => $value->order_date,
                    'orders' => $value->totalOrder,
                    'products' => $value->totalProduct,
                    'total' => formatNumber($value->total),
                    'shipping' => formatNumber($value->total_shipping_charge),
                    'discount' => formatNumber($value->total_discount_amount),
                    'tax' => formatNumber($value->total_tax_charge),
                    'summary' => formatNumber(($value->total + $value->total_shipping_charge + $value->total_tax_charge) - $value->total_discount_amount),
                ];
            }

            return $report;
        }
    }
}
