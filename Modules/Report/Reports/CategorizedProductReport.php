<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class CategorizedProductReport
{
    /**
     * Categorized Product Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getCategorizedProductReport(request()->categoryName);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => $value->name,
                    'total' => formatCurrencyAmount($value->product_counts),
                ];
            }

        }

        return $report;
    }
}
