<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class ProductStockReport
{
    /**
     * Product Stock Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getProductStockReport(request()->qtyAbove, request()->qtybellow, request()->stockAvailability);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => $value->name,
                    'total' => formatCurrencyAmount($value->total_stocks),
                    'status' => $value->total_stocks > 0 ? 'In Stock' : 'Out of Stock',
                ];

            }
        }

        return $report;

    }
}
