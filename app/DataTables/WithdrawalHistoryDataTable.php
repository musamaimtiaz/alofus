<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-02-2022
 */

namespace App\DataTables;

use App\Models\{
    Transaction
};
use Illuminate\Http\JsonResponse;

class WithdrawalHistoryDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     *
      @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        $transactions = $this->query();

        return datatables()
            ->of($transactions)
            ->editColumn('currency.name', function ($transactions) {
                return optional($transactions->currency)->name;
            })->editColumn('withdrawal_method.method_name', function ($transactions) {
                return optional($transactions->withdrawalMethod)->method_name;
            })->editColumn('amount', function ($transactions) {
                return formatCurrencyAmount($transactions->amount);
            })->editColumn('total_amount', function ($transactions) {
                return formatCurrencyAmount($transactions->total_amount);
            })->editColumn('charge_amount', function ($transactions) {
                return formatCurrencyAmount($transactions->charge_amount + $transactions->commission_amount + $transactions->discount_amount);
            })->editColumn('transaction_date', function ($transactions) {
                return timeZoneFormatDate($transactions->transaction_date);
            })->editColumn('updated_at', function ($transactions) {
                return $transactions->updated_at != null ? $transactions->format_updated_at : '';
            })->editColumn('status', function ($transactions) {
                return statusBadges($transactions->status);
            })

            ->rawColumns(['withdrawal_method.name', 'currency_id', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount', 'transaction_type', 'transaction_date', 'updated_at', 'status'])

            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $transactions = Transaction::select('transactions.id', 'currency_id', 'transactions.status', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount', 'transaction_type', 'transaction_date', 'transactions.updated_at')->where('user_id', auth()->user()->id)->where('transaction_type', 'Withdrawal')->with(['currency:id,name', 'withdrawalMethod:id,method_name'])->filter();

        return $this->applyScopes($transactions);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'currency.name', 'name' => 'currency.name', 'title' => __('Currency'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'withdrawal_method.method_name', 'name' => 'withdrawalMethod.method_name', 'title' => __('Method'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => __('Amount'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'charge_amount', 'name' => 'charge_amount', 'title' => __('Fees'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'total_amount', 'name' => 'total_amount', 'title' => __('Total'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'transaction_type', 'name' => 'transaction_type', 'title' => __('Type'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'transaction_date', 'name' => 'transaction_date', 'title' => __('Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => __('Updated At'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'width' => '10%', 'orderable' => false, 'className' => 'text-right align-middle'])

            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }

    public function setViewData()
    {
        $statusCounts = $this->query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
