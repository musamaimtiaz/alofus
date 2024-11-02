<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-11-2021
 */

namespace Modules\Coupon\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Coupon\DataTables\CouponRedeemDataTable;
use Modules\Coupon\Http\Models\CouponRedeem;
use Modules\Coupon\Exports\CouponRedeemListExport;
use Excel;

class CouponRedeemController extends Controller
{
    /**
     * Coupon Redeem List
     *
     * @param  CouponDataTable  $dataTable
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CouponRedeemDataTable $dataTable)
    {
        return $dataTable->render('coupon::redeem.index');
    }

    /**
     * Coupon list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['redeems'] = CouponRedeem::getAll();

        return printPDF($data, 'coupon_redeem_list' . time() . '.pdf', 'coupon::redeem.pdf', view('coupon::redeem.pdf', $data), 'pdf');
    }

    /**
     * Coupon list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new CouponRedeemListExport(), 'coupon_redeem_list' . time() . '.csv');
    }
}
