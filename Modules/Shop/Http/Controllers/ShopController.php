<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Shop\DataTables\ShopDataTable;
use Modules\Shop\Exports\ShopListExport;
use App\Models\Vendor;
use Modules\Shop\Http\Models\Shop;
use Excel;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * List All Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(ShopDataTable $dataTable)
    {
        return $dataTable->render('shop::index');
    }

    /**
     * Create Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $data['vendors'] = Vendor::getAll()->where('status', 'Active');
        $data['vendor'] = $request->vendor;

        return view('shop::create', $data);
    }

    /**
     * Store Shop
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];

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
        if ($request->vendor) {
            return redirect()->route('vendors.edit', ['id' => $request->vendor_id]);
        }

        return redirect()->route('shop.index');
    }

    /**
     *  Edit Shop
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Request $request, $id = null)
    {

        $result = Shop::find($id);
        if ($result) {
            $data['shop'] = $result;
            $data['vendors'] = Vendor::getAll();
            $data['checkVendor'] = $request->vendor;

            return view('shop::edit', $data);
        }
        $this->setSessionValue(['status' => 'fail', 'message' => __('Shop does not exist.')]);

        return back();
    }

    /**
     * Update Shop
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];

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
        if ($request->vendor) {
            return redirect()->route('vendors.edit', ['id' => $request->vendor_id]);
        }

        return redirect()->route('shop.index');
    }

    /**
     * Delete Shop
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];

        $result = $this->checkExistance($id, 'shops', ['getData' => true]);
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
        if ($request->vendor_id) {
            return redirect()->route('vendors.edit', ['id' => $request->vendor_id]);
        }

        return redirect()->route('shop.index');
    }

    /**
     * Shop list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['shops'] = Shop::getAll();

        return printPDF($data, 'shop_list' . time() . '.pdf', 'shop::list_pdf', view('shop::list_pdf', $data), 'pdf', 'domPdf');
    }

    /**
     * Vendor shop list pdf
     *
     * @param  string  $id
     * @return html static page
     */
    public function shopPdf($id)
    {
        $data['shops'] = Shop::getAll()->where('vendor_id', $id);

        return printPDF($data, 'shop_list' . time() . '.pdf', 'shop::list_pdf', view('shop::list_pdf', $data), 'pdf', 'domPdf');
    }

    /**
     * Shop list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new ShopListExport(), 'shop_list' . time() . '.csv');
    }

    /**
     * Vendor shop list CSV
     *
     * @param  string  $id
     * @return html static page
     */
    public function shopCsv($id)
    {
        return Excel::download(new ShopListExport($id), 'shop_list' . time() . '.csv');
    }
}
