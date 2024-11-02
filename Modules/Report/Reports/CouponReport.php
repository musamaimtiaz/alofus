<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class CouponReport
{
    /**
     * Coupon Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getCouponReport();
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'date' => $value->start_date . '-' . $value->end_date,
                    'name' => $value->name,
                    'code' => $value->code,
                    'order' => formatCurrencyAmount($value->coupon_redeems_count),
                    'total' => formatNumber($value->coupon_redeems_sum_discount_amount),
                ];
            }

            return $report;
        }
    }
}
