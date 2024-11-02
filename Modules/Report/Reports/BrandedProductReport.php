<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class BrandedProductReport
{
    /**
     * Product By Brand
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getBrandReport(request()->brandName);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => $value->name,
                    'total' => formatCurrencyAmount($value->product_count),
                ];
            }

            return $report;
        }
    }
}
