<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 16-10-2022
 */

namespace App\Http\Controllers;

use App\Services\Import\ProductImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.epz.import.index');
    }

    public function productImport(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.epz.import.product');
        }

        $importer = new ProductImportService($request);

        if (! $importer->process()) {
            $response = $this->messageArray($importer->getError(), 'fail');
            $this->setSessionValue($response);

            return redirect()->back();
        }

        return $importer->getResponse();
    }
}
