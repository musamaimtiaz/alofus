<?php

namespace Modules\Report\Http\Controllers\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Report\Http\Models\Report;
use App\Models\OrderStatus;
use Modules\Shipping\Entities\ShippingClass;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['reportTypes'] = (new Report())->reportTypeForVendor();
        $data['orderStatus'] = (new OrderStatus())->get();
        $data['shippingMethod'] = (new ShippingClass())->get();
        $data['report'] = [];
        if (request()->type) {
            $header = (new Report())->tableRow();
            $class = 'Modules\Report\Reports' . '\\' . request()->type;

            if (class_exists($class, true)) {
                $report = $class::getReports();
                $list = view('report::coupon.list', compact('report', 'header'))->render();

                return response(['list' => $list]);
            } else {
                $error = view('report::coupon.error')->render();

                return response(['list' => $error]);
            }

        } else {
            return view('report::vendor.index', $data);
        }
    }
}
