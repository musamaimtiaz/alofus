<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DashboardRequest;
use App\Services\Reports\VendorDashboardReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    private $reportService;

    public function __construct(VendorDashboardReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the Over All Information on Vendor Dashboard.
     *
     * @return Dashboard page view
     */
    public function index()
    {
        if (config('martvill.is_demo')) {
            Session::flash('info', __('Demo resets every 4 hours. Before purchasing, Feel free to test all the features. Some features are disabled in demo.'));
        }

        return view('vendor.dashboard', $this->reportService
            ->thisMonthOrdersCount()
            ->thisMonthSalesCount()
            ->newProductsCount()
            ->newRefundsCount()
            ->orderStatusWithCount()
            ->salesOfTheMonth()
            ->thisMonthOrdersCompare()
            ->thisMonthSalesCompare()
            ->thisMonthReviews()
            ->thisMonthReviewCompare()
            ->newProductsCountCompare()
            ->newRefundsCountCompare()
            ->walletBalances()
            ->topSoldBrands()
            ->dashboardWidgetElement()
            ->dashboardWidgetOption()
            ->widget()
            ->getArray());
    }

    /**
     * Get the most ordered products
     *
     * @return mixed
     */
    public function mostSoldProducts(DashboardRequest $request)
    {
        return $this->response($this->reportService->mostSoldProducts()->get());
    }

    /**
     * Get the most ordered products
     *
     * @return mixed
     */
    public function mostActiveUsers(DashboardRequest $request)
    {
        return $this->reportService->mostActiveUsers()->getResponse();
    }

    /**
     * Get vendor status
     *
     * @return mixed
     */
    public function vendorStats(DashboardRequest $request)
    {
        return $this->reportService->vendorStats()->getResponse();
    }

    /**
     * Get product details
     *
     * @return Response
     */
    public function getProductData(DashboardRequest $request)
    {
        return $this->reportService->productDetails($request->uid)->getResponse();
    }

    /**
     * Get user details
     *
     * @return Response
     */
    public function getUserData(DashboardRequest $request)
    {
        return $this->reportService->userDetails($request->uid)->getResponse();
    }

    /**
     * Get user details
     *
     * @return Response
     */
    public function salesOfTheMonth(DashboardRequest $request)
    {
        return $this->reportService->salesOfTheMonth()->getResponse();
    }

    /**
     * Set Widget Data
     */
    public function setWidgetData(Request $request)
    {
        cache()->put('vendor-dashboard-widget-element.' . auth()->user()->id, $request->data, 86400 * 30);

        return response()->json([
            'status' => 'success',
            'message' => __('Dashboard widget data saved successfully'),
        ]);
    }

    /**
     * Set Widget Option
     */
    public function setWidgetOption(Request $request)
    {
        cache()->put('vendor-dashboard-widget-option.' . auth()->user()->id, $request->data, 86400 * 30);

        return response()->json([
            'status' => 'success',
            'message' => __('Dashboard widget option saved successfully'),
        ]);
    }

    /**
     * Forget Widget
     */
    public function forgetWidget()
    {
        cache()->forget('vendor-dashboard-widget-element.' . auth()->user()->id);
        cache()->forget('vendor-dashboard-widget-option.' . auth()->user()->id);

        return back()->withSuccess('Dashboard successfully reset.');
    }
}
