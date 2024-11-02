<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 20-01-2024
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\{Product, Preference};
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
            return view('vendor.barcode.product');
        }

        try {
            $products = Product::whereIn('id', $request->product_id)->get();

            $productPreference = Preference::where('category', 'product_barcode')->pluck('value', 'field')->toArray();

            $barcodeData = new BarcodeGenerator($products, $productPreference, 'product');

            $data['data'] = $barcodeData->getCollection();

            return view('vendor.barcode.product', $data);

        } catch (\Throwable $th) {
            return back()->withInput($request->input())->withErrors($th->getMessage());
        }

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
        $vendorId = auth()->user()->vendor()->vendor_id;

        $products = Product::select('id', 'name', 'status', 'type', 'vendor_id', 'manage_stocks', 'sku', 'slug')
            ->whereLike('name', $search)
            ->where('type', '!=', 'Grouped Product')
            ->where('vendor_id', $vendorId)
            ->orWhereHas('parentDetail', function ($q) use ($vendorId, $search) {
                $q->whereLike('name', $search)->where('vendor_id', $vendorId)->published();
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
