<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 16-01-2024
 */

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\Product;
use App\Services\Product\BarcodeGenerator;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    /**
     * product barcode page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function product(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.barcode.product');
        }

        try {
            $products = Product::whereIn('id', $request->product_id)->get();

            $productPreference = Preference::where('category', 'product_barcode')->pluck('value', 'field')->toArray();

            $barcodeData = new BarcodeGenerator($products, $productPreference, 'product');

            $data['data'] = $barcodeData->getCollection();

            return view('admin.barcode.product', $data);

        } catch (\Throwable $th) {
            return back()->withInput($request->input())->withErrors($th->getMessage());
        }

    }

    /**
     * barocde settings page
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function settings(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.barcode.settings');
        }

        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $i = 0;
        $request = $request->except('_token');
        $type = $request['type'];

        foreach ($request as $key => $value) {

            if ($key != 'type') {
                $data[$i]['category'] = $type;
                $data[$i]['field']    = $key;
                $data[$i]['value'] = $value;
                $i++;
            }
        }

        foreach ($data as $key => $value) {
            if ((new Preference())->storeOrUpdate($value)) {
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Barcode setting')]), 'success');
            }
        }

        return $response;

    }

    /**
     * product search
     *
     * @return \Illuminate\Http\JsonResponse\
     */
    public function search(Request $request)
    {
        $data['status']  = 0;
        $data['message']    = __('No Item Found');
        $search = $request->search;

        $products = Product::select('id', 'name', 'status', 'type', 'vendor_id', 'manage_stocks', 'sku', 'slug')
            ->whereLike('name', $search)
            ->where('type', '!=', 'Grouped Product')
            ->orWhereHas('parentDetail', function ($q) use ($search) {
                $q->whereLike('name', $search)->published();
            })
            ->published()
            ->limit(10)
            ->get();

        if (! $products->isEmpty()) {
            $data['status'] = 1;
            $data['message'] = __('Product Found');
            $data['products'] = $products;
        }

        return response()->json($data);
    }
}
