<?php

namespace Modules\Report\Reports;

use Modules\Report\Http\Models\Report;

class CustomerOrderReport
{
    /**
     * Customer Order Report
     *
     * @param  object  $request
     * @return array $response
     */
    public static function getReports()
    {
        $res = (new Report())->getCustomerOrderReport(request()->from, request()->to, request()->customerName, request()->customerEmail, request()->orderStatus);
        $report = [];
        if ($res) {
            foreach ($res as $key => $value) {
                $report[] = [
                    'name' => optional($value->user)->name,
                    'email' => optional($value->user)->email,
                    'order' => formatCurrencyAmount($value->totalOrder),
                    'product' => formatCurrencyAmount($value->totalQty),
                    'total' => formatNumber($value->totalAmount),
                ];
            }

        }

        return $report;
    }
}
