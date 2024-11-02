<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 23-05-2021
 */

namespace App\Http\Controllers;

use App\Http\Requests\Common\DashboardRequest;
use App\Models\EmailConfiguration;
use App\Models\User;
use App\Models\Vendor;
use App\Services\Reports\AdminDashboardReportService;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    private $reportService;

    public function __construct(AdminDashboardReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the Over All Information on Dashboard.
     *
     * @return Dashboard page view
     */
    public function index()
    {
        if (is_null(EmailConfiguration::first())) {
            Session::flash(
                'fail',
                __('Please configure SMTP setting to work all the email sending and related functionality.')
                . ' <a href=' . route('emailConfigurations.index') . " target='_blank'>" . __('Configure Now.') . '</a>'
            );
        }

        if (config('martvill.is_demo')) {
            Session::flash('info', __('Demo resets every 4 hours. Before purchasing, Feel free to test all the features. Some features are disabled in demo.'));
        }

        return view('admin.dashboard', $this->reportService
            ->thisMonthOrdersCount()
            ->thisMonthSalesCount()
            ->newProductsCount()
            ->newRefundsCount()
            ->newVendors()
            ->orderStatusWithCount()
            ->newUsersCount('newUsers')
            ->salesOfTheMonth()
            ->topSoldBrands()
            ->thisMonthOrdersCompare()
            ->thisMonthSalesCompare()
            ->newUsersCompare()
            ->newProductsCountCompare()
            ->newVendorsCompare()
            ->newRefundsCountCompare()
            ->commissionThisMonth()
            ->commissionThisMonthCompare()
            ->openTicketsCount()
            ->pendingWithdrawalRequestsCount()
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
     * @return mixed
     */
    public function vendorStatsType($type)
    {
        return $this->reportService->vendorStats('vendorStats', $type)->getResponse();
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
     * Most sold brands
     *
     * @return Response
     */
    public function topSoldBrands(DashboardRequest $request)
    {
        return $this->reportService->topSoldBrands()->getResponse();
    }

    /**
     * Change Language function
     *
     * @return true or false
     */
    public function switchLanguage(Request $request)
    {
        if ($request->lang) {
            if (! empty(Auth::user()->id) && isset(Auth::user()->id)) {
                Cache::put(config('cache.prefix') . '-user-language-' . Auth::user()->id, $request->lang, 5 * 365 * 86400);
                echo 1;
                exit;
            }
        }
        echo 0;
        exit();
    }

    /**
     * Vendor request list
     *
     * @return mixed
     */
    public function vendorReq(DashboardRequest $request)
    {
        return $this->reportService->vendorRequestList()->getResponse();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($status = null, $id = null)
    {
        $response = ['accept' => 'Active', 'reject' => 'Inactive'];
        Vendor::whereId($id)->update([
            'status' => isset($response[$status]) ? $response[$status] : 'Inactive',
        ]);

        return $this->reportService->vendorRequestList()->getResponse();
    }

    /**
     * Set Widget Data
     */
    public function setWidgetData(Request $request)
    {
        cache()->put('dashboard-widget-element.' . auth()->user()->id, $request->data, 86400 * 30);

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
        cache()->put('dashboard-widget-option.' . auth()->user()->id, $request->data, 86400 * 30);

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
        cache()->forget('dashboard-widget-element.' . auth()->user()->id);
        cache()->forget('dashboard-widget-option.' . auth()->user()->id);

        return back()->withSuccess('Dashboard successfully reset.');
    }
}
