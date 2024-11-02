<?php

namespace Modules\Shop\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Shop\Http\Models\Shop;
use Modules\Shop\DataTables\VendorShopDataTable;
use Modules\Shop\Exports\ShopListExport;
use App\Models\{
    Vendor,
    VendorUser
};
use Auth;
use Excel;

class ShopController extends Controller
{
    /**
     * List Vendor Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(VendorShopDataTable $dataTable)
    {
        $data['vendorId'] = isset(VendorUser::getAll()->where('user_id', Auth::user()->id)->first()->vendor_id) ? VendorUser::getAll()->where('user_id', Auth::user()->id)->first()->vendor_id : 0;

        return $dataTable->render('shop::vendor.index', $data);
    }

    /**
     * Create Vendor Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $vendorId = session()->get('vendorId');
        $data['vendors'] = Vendor::getAll()->where('id', $vendorId)->first();
        $data['shop'] = collect([]);

        $shopLimit = isset(json_decode($data['shop'])->shop) ? json_decode($data['shop'])->shop : 0;
        $shopCount = Shop::getAll()->where('vendor_id', $vendorId)->count();
        if ($shopCount >= $shopLimit) {
            $this->setSessionValue(['status' => 'fail', 'message' => __('Your shop limit is over, please upgrade your package.')]);

            return back();
        }

        return view('shop::vendor.create', $data);
    }

    /**
     * Store Vendor Shop
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $request['vendor_id'] = VendorUser::getAll()->where('user_id', Auth::user()->id)->first()->vendor_id;
        $validator = Shop::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ((new Shop())->store($request->only('name', 'vendor_id', 'email', 'website', 'alias', 'phone', 'fax', 'address', 'description', 'status'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Shop')]);
        } else {
            $data['message'] = __('Something went wrong, please try again.');
        }

        $this->setSessionValue($data);

        return redirect()->route('vendor.shop.index');
    }

    /**
     * Edit Vendor Shop
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $data['shop'] = isset($id) && ! empty($id) ? Shop::getAll()->where('id', $id)->first() : null;
        $data['vendor'] = Vendor::getAll()->where('id', session()->get('vendorId'))->first();

        return view('shop::vendor.edit', $data);
    }

    /**
     * Update Vendor Shop
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        $request['vendor_id'] = VendorUser::getAll()->where('user_id', Auth::user()->id)->first()->vendor_id;
        $result = $this->checkExistence($id, 'shops');
        if ($result['status'] === true) {
            $validator = Shop::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $response = (new Shop())->updateShop($request->all(), $id);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('vendor.shop.index');
    }

    /**
     * Delete Vendor Shop
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];

        $result = $this->checkExistence($id, 'shops');
        $shopCount = (new Shop())->shopCount($id);
        if ($result['status'] === true) {
            if ($shopCount > 1) {
                $response = (new Shop())->remove($id);
            } else {
                $response['message'] = __('This is your only shop, can not be deleted.');
            }
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('vendor.shop.index');
    }

    /**
     * Vendor shop list pdf
     *
     * @param  int  $id
     * @return html static page
     */
    public function pdf($id)
    {
        $data['shops'] = Shop::getAll()->where('vendor_id', $id);

        return printPDF($data, 'shop_list' . time() . '.pdf', 'shop::vendor.list_pdf', view('shop::vendor.list_pdf', $data), 'pdf', 'domPdf');
    }

    /**
     * Vendor shop list CSV
     *
     * @param  int  $id
     * @return html static page
     */
    public function csv($id)
    {
        return Excel::download(new ShopListExport($id), 'shop_list' . time() . '.csv');
    }
}
