<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 12-05-2022
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\VendorTransactionDataTable;
use App\Exports\VendorTransactionListExport;
use App\Http\Controllers\Controller;
use App\Models\{Product, ProductCategory, Transaction};
use Excel;

class VendorTransactionController extends Controller
{
    /**
     * Transaction List
     *
     * @param  ProductListDataTable  $dataTable
     * @return mixed
     */
    public function index(VendorTransactionDataTable $dataTable)
    {
        $vendorId = session()->get('vendorId');
        $data['transactionType'] = Transaction::select('transaction_type')->distinct()->get();
        $data['statuses'] = Transaction::select('status')->distinct()->get();

        $users = Transaction::where('vendor_id', $vendorId)->where('user_id', '!=', null)->whereHas('user', function ($query) {
            $query->where('status', 'Active');
        });

        if ($users->exists()) {
            $data['users'] = $users->select('user_id')->distinct()->with('user:id,name')->get();
        }

        return $dataTable->render('vendor.transaction.index', $data);
    }

    /**
     * Withdrawal list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['transactions'] = Transaction::select('transactions.id', 'user_id', 'currency_id', 'transactions.status', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount', 'transaction_type', 'order_id', 'transaction_date')->where('vendor_id', session()->get('vendorId'))->with(['user:id,name', 'currency:id,name', 'withdrawalMethod:id,method_name', 'order'])->get();

        return printPDF(
            $data,
            'transactions' . time() . '.pdf',
            'vendor.transaction.pdf',
            view('vendor.transaction.pdf', $data),
            'pdf'
        );
    }

    /**
     * order list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorTransactionListExport(), 'transactions' . time() . '.csv');
    }
}
