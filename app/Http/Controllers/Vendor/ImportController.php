<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 20-12-2022
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Import\VendorProductImportService as ProductImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function productImport(Request $request)
    {
        do_action('before_vendor_import_product');

        if ($request->isMethod('get')) {
            return view('vendor.epz.import.product');
        }

        $importer = new ProductImportService($request);

        if (! $importer->process()) {
            $response = $this->messageArray($importer->getError(), 'fail');
            $this->setSessionValue($response);

            return redirect()->back();
        }

        do_action('after_vendor_import_product');

        return $importer->getResponse();
    }
}
