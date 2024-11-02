<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-01-2023
 */

namespace App\Http\Controllers;

use App\Models\{Product, ProductCategory};
use App\Services\Export\ProductExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.epz.export.index');
    }

    /**
     * product export
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function productExport(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['productCategories'] = ProductCategory::join('categories', 'product_categories.category_id', 'categories.id')
                ->join('products', 'products.id', 'product_categories.product_id')
                ->selectRaw('categories.name, categories.id')
                ->distinct()
                ->get();

            $data['productVendors'] = Product::select('vendor_id')->distinct()->with('vendor:id,name')->get();
            $data['columns'] = getProductExportColumn();

            return view('admin.epz.export.product', $data);
        }

        $export = new ProductExportService($request);

        if (! $export->process()) {
            $response = $this->messageArray($export->getError(), 'fail');
            $this->setSessionValue($response);

            return redirect()->back();
        }

        return $export->getResponse();
    }
}
