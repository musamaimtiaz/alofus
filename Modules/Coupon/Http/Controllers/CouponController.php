<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-11-2021
 */

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AjaxSelectSearchResource;
use Modules\Affiliate\Entities\AffiliateUser;
use Modules\Coupon\DataTables\CouponDataTable;
use Modules\Coupon\Exports\CouponListExport;
use Modules\Coupon\Http\Models\{
    Coupon, CouponMeta, ProductCoupon
};
use App\Models\{
    Product, Vendor
};
use Excel;

class CouponController extends Controller
{
    /**
     * Coupon List
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('coupon::index');
    }

    /**
     * Create Coupon
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('coupon::create');
    }

    /**
     * Store Coupon
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request['maximum_discount_amount'] = validateNumbers($request->maximum_discount_amount);

        if ($request->discount_type != 'Percentage' || empty($request['maximum_discount_amount'])) {
            $request['maximum_discount_amount'] = null;
        }

        $request['shop_id'] = isActive('Shop') ? $request['shop_id'] : null;
        $validator = Coupon::storeValidation($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request['start_date'] = DbDateFormat($request->start_date);
        $request['end_date'] = DbDateFormat($request->end_date);

        $couponId = (new Coupon())->store($request->only('name', 'vendor_id', 'shop_id', 'usage_limit', 'code', 'discount_type', 'minimum_spend', 'discount_amount', 'maximum_discount_amount', 'start_date', 'end_date', 'status'));

        if ($couponId) {
            $productCoupon = [];
            if (! empty($request->product_ids)) {
                foreach ($request->product_ids as $product_id) {
                    $productCoupon[] = ['coupon_id' => $couponId, 'product_id' => $product_id];
                }
            }
            if (! empty($productCoupon)) {
                (new ProductCoupon())->store($productCoupon);
            }
            $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Coupon')])];
        } else {
            $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        }

        // Coupon Meta
        $couponMeta = [
            'coupon_id' => $couponId,
            'type' => 'string',
            'key' => 'allow_free_shipping',
            'value' => 0,

        ];
        if (isset($request->allow_free_shipping)) {
            $couponMeta['value'] = 1;
        }
        (new CouponMeta())->store($couponMeta);

        if (isActive('Affiliate') && preference('coupon_referral') == 1) {
            AffiliateUser::affiliateCoupon($request->affiliate_id, $couponId);
        }

        $this->setSessionValue($data);

        return redirect()->route('coupon.index');
    }

    /**
     * Edit Coupon
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $result = $this->checkExistence($id, 'coupons');
        if ($result['status'] == true) {
            $data['coupon'] = Coupon::with('products:id')->find($id);
            $data['shops'] = \Modules\Shop\Http\Models\Shop::getAll()->where('status', 'Active');
            $data['products'] = [];
            foreach ($data['coupon']->products as $key => $product) {
                $data['products'][] = $product->id;
            }

            return view('coupon::edit', $data);
        }

        $this->setSessionValue(['status' => 'fail', 'message' => $result['message']]);

        return back();
    }

    /**
     * Update Coupon
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $result = $this->checkExistence($id, 'coupons');
        if ($result['status'] === true) {
            $request['shop_id'] = isActive('Shop') ? $request['shop_id'] : null;
            $request['minimum_spend'] = validateNumbers($request->minimum_spend);
            $request['discount_amount'] = validateNumbers($request->discount_amount);
            $request['vendor_id'] = empty($request->vendor_id) ? null : $request->vendor_id;
            $validator = Coupon::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $request['maximum_discount_amount'] = validateNumbers($request->maximum_discount_amount);
            if ($request->discount_type != 'Percentage' || empty($request['maximum_discount_amount'])) {
                $request['maximum_discount_amount'] = null;
            }
            $request['start_date'] = DbDateFormat($request->start_date);
            $request['end_date'] = DbDateFormat($request->end_date);
            $response = (new Coupon())->updateData($request->all(), $id);
            $productCoupon = [];
            if (! empty($request->product_ids)) {
                foreach ($request->product_ids as $product_id) {
                    $productCoupon[] = ['coupon_id' => $id, 'product_id' => $product_id];
                }
            }
            (new ProductCoupon())->updateData($productCoupon, $id);

            // Coupon Meta
            $couponMeta = [
                'coupon_id' => $id,
                'type' => 'string',
                'key' => 'allow_free_shipping',
                'value' => 0,

            ];
            if (isset($request->allow_free_shipping)) {
                $couponMeta['value'] = 1;
            }
            (new CouponMeta())->store($couponMeta);

            if (isActive('Affiliate') && preference('coupon_referral') == 1) {
                AffiliateUser::affiliateCoupon($request->affiliate_id, $id);
            }

        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('coupon.index');
    }

    /**
     * Delete Coupon
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id = null)
    {
        $result = $this->checkExistence($id, 'coupons');
        if ($result['status'] === true) {
            $response = (new Coupon())->remove($id);
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('coupon.index');
    }

    /**
     * Coupon list pdf
     *
     * @return html static page
     */
    public function downloadPdf()
    {
        $data['coupons'] = Coupon::getAll();

        return printPDF($data, 'coupon_list' . time() . '.pdf', 'coupon::pdf', view('coupon::pdf', $data), 'pdf');
    }

    /**
     * Coupon list csv
     *
     * @return html static page
     */
    public function downloadCsv()
    {
        return Excel::download(new CouponListExport(), 'coupon_list' . time() . '.csv');
    }

    /**
     * Vendor Shop
     *
     * @param  int  $id
     * @return json $shops
     */
    public function getShopByVendor($id = null)
    {
        $shops = [];
        if (! is_null($id)) {
            $shops = \Modules\Shop\Http\Models\Shop::getAll()->where('vendor_id', $id);
        }

        return json_encode($shops);
    }

    /**
     * Shop Product
     *
     * @param  int  $id
     * @return json $data
     */
    public function getCouponProduct(Request $request, $id = null)
    {
        $data['products'] = [];
        if (! is_null($id)) {
            if (isActive('Shop') ? false : false) {
                $data['products'] = Product::select('id', 'name')->where('shop_id', $id)->get();
            } else {
                $data['products'] = Product::select('id', 'name')->where('vendor_id', $id)->get();
            }
        }
        if (isset($request->coupon_id) && ! empty($request->coupon_id)) {
            $data['select'] = [];
            $productIds = ProductCoupon::select('product_id')->where('coupon_id', $request->coupon_id)->get();
            foreach ($productIds as $key => $value) {
                $data['select'][] = $value->product_id;
            }
        }

        return json_encode($data);
    }

    /**
     * Get product by ids
     *
     * @return json
     */
    public function getOldProducts(Request $request)
    {
        $products = Product::select('id', 'name')->whereIn('id', $request->product_ids)->get();

        return AjaxSelectSearchResource::collection($products);
    }

    /**
     * Get vendor by id
     *
     * @return json
     */
    public function getOldVendor(Request $request)
    {
        $vendor = Vendor::select('id', 'name')->where('id', $request->vendor_id)->first();

        return new AjaxSelectSearchResource($vendor);
    }
}
