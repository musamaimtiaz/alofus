<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 18-11-2021
 */

namespace Modules\Coupon\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Coupon\DataTables\VendorCouponDataTable;
use Modules\Coupon\Exports\VendorCouponListExport;
use App\Models\{
    Product,
    VendorUser
};
use Modules\Coupon\Http\Models\{
    ProductCoupon,
    Coupon,
    CouponMeta
};
use Excel;

class CouponController extends Controller
{
    /**
     * Vendor Coupon List
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(VendorCouponDataTable $dataTable)
    {
        return $dataTable->render('coupon::vendor.index');
    }

    /**
     * Create Vendor Coupon
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        if (isActive('Shop')) {
            $data['shops'] = \Modules\Shop\Http\Models\Shop::getAll()->where('vendor_id', session()->get('vendorId'))->where('status', 'Active');
        }

        return view('coupon::vendor.create', $data);
    }

    /**
     * Store Vendor Coupon
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
        $request['vendor_id'] = session()->get('vendorId');
        $validator = Coupon::storeValidation($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request['start_date'] = DbDateFormat($request->start_date);
        $request['end_date'] = DbDateFormat($request->end_date);

        $couponId = (new Coupon())->store($request->only('name', 'vendor_id', 'shop_id', 'usage_limit', 'code', 'minimum_spend', 'discount_type', 'discount_amount', 'maximum_discount_amount', 'start_date', 'end_date', 'status'));
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

        $this->setSessionValue($data);

        return redirect()->route('vendor.coupons');
    }

    /**
     * Edit Vendor Coupon
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $result = $this->checkExistence($id, 'coupons', ['getData' => true]);
        if ($result['status'] == true) {
            $data['coupon'] = Coupon::with('products:id')->find($id);
            $data['products'] = [];
            foreach ($data['coupon']->products as $key => $product) {
                $data['products'][] = $product->id;
            }

            if (isActive('Shop')) {
                $data['shops'] = \Modules\Shop\Http\Models\Shop::getAll()->where('vendor_id', session()->get('vendorId'))->where('status', 'Active');
                if (! empty($data['coupon']->shop_id)) {
                    $data['products'] = Product::select('id', 'name')->where('shop_id', $data['coupon']->shop_id)->get();
                }
            }

            return view('coupon::vendor.edit', $data);
        }

        $this->setSessionValue(['status' => 'fail', 'message' => $result['message']]);

        return back();
    }

    /**
     * Update Vendor Coupon
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $result = $this->checkExistence($id, 'coupons');
        if ($result['status'] === true) {
            $request['maximum_discount_amount'] = validateNumbers($request->maximum_discount_amount);
            if ($request->discount_type != 'Percentage' || empty($request['maximum_discount_amount'])) {
                $request['maximum_discount_amount'] = null;
            }

            $request['shop_id'] = isActive('Shop') ? $request['shop_id'] : null;
            $request['vendor_id'] = VendorUser::where('user_id', \Auth::user()->id)->first()->vendor_id ?? null;
            $request['minimum_spend'] = validateNumbers($request->minimum_spend);
            $validator = Coupon::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
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
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

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

        $this->setSessionValue($response);

        return redirect()->route('vendor.coupons');
    }

    /**
     * Delete Vendor Coupon
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

        return redirect()->route('vendor.coupons');
    }

    /**
     * Coupon list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['coupons'] = Coupon::getAll()->where('vendor_id', session()->get('vendorId'));

        return printPDF($data, 'coupon_list' . time() . '.pdf', 'coupon::vendor.pdf', view('coupon::vendor.pdf', $data), 'pdf');
    }

    /**
     * Coupon list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorCouponListExport(), 'coupon_list' . time() . '.csv');
    }

    /**
     * Get Shop Product
     *
     * @param  int  $id
     * @return json $data
     */
    public function product($id = null)
    {
        $data['products'] = Product::select('id', 'name')->where('shop_id', $id)->get();
        if ($id == 0) {
            $data['products'] = Product::select('id', 'name')->where('vendor_id', session()->get('vendorId'))->get();
        }

        return json_encode($data);
    }
}
