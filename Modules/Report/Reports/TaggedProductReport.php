<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class TaggedProductReport
{
    /**
     * Categorized Product Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getTagReport(request()->tagName);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => $value->name,
                    'total' => formatCurrencyAmount($value->product_tag_count),
                ];
            }

        }

        return $report;
    }
}
