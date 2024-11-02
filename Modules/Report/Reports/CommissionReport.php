<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class CommissionReport
{
    /**
     * Commission Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getCommissionReport(request()->vendorName);
        $report = $totalValue = $order = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $totalValue[$value->vendor_id] = ($value->OrderDetail->price * $value->OrderDetail->quantity) * ($value->amount / 100) + ($totalValue[$value->vendor_id] ?? 0);
                $name[$value->vendor_id] = optional($value->vendor)->name;
                $order[$value->vendor_id] =  $value->OrderDetail->quantity + ($order[$value->vendor_id] ?? 0);
            }
            if (count($totalValue) > 0) {
                foreach ($totalValue as $key => $value) {
                    $report[] = [
                        'name' => isset($name[$key]) && ! empty($name[$key]) ? $name[$key] : '',
                        'order' => isset($order[$key]) && ! empty($order[$key]) ? formatCurrencyAmount($order[$key]) : '',
                        'total' => formatNumber($value),
                    ];
                }
            }

            return $report;
        }
    }
}
