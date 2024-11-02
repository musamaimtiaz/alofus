<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-05-2022
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Services\Export\ProductExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * product export
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function productExport(Request $request)
    {
        do_action('before_vendor_export_product');

        if ($request->isMethod('get')) {
            $data['productCategories'] = ProductCategory::join('categories', 'product_categories.category_id', 'categories.id')
                ->join('products', 'products.id', 'product_categories.product_id')
                ->selectRaw('categories.name, categories.id')
                ->distinct()
                ->get();

            $data['columns'] = getProductExportColumn();

            return view('vendor.epz.export.product', $data);
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
