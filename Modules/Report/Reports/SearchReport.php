<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class SearchReport
{
    /**
     * Shipping Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getSearchReport(request()->searchProduct);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => $value->name,
                    'order' => formatCurrencyAmount($value->total),
                ];
            }
        }

        return $report;
    }
}
