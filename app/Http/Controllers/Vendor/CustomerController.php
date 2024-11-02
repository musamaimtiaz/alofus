<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 26-10-2023
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\VendorCustomerDataTable;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * vendor customer list
     *
     * @return mixed
     */
    public function index(VendorCustomerDataTable $dataTable)
    {
        if (! preference('is_vendor_customer_list_active')) {
            abort(403);
        }

        return $dataTable->render('vendor.customer.index');
    }
}
