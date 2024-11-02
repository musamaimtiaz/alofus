<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 01-03-2022
 */

namespace App\DataTables;

use App\Models\{
    Transaction
};
use Illuminate\Http\JsonResponse;

class WithdrawalListDataTable extends DataTable
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
            ->editColumn('user.name', function ($transactions) {
                return '<a href="' . route('users.edit', ['id' => optional($transactions->user)->id]) . '">' . wrapIt(optional($transactions->user)->name, 10) . '</a>';

                return optional($transactions->user)->name;
            })->editColumn('currency.name', function ($transactions) {
                return optional($transactions->currency)->name;
            })->editColumn('withdrawal_method.method_name', function ($transactions) {
                return optional($transactions->withdrawalMethod)->method_name;
            })->editColumn('amount', function ($transactions) {
                return formatCurrencyAmount($transactions->amount);
            })->editColumn('total_amount', function ($transactions) {
                return formatCurrencyAmount($transactions->total_amount);
            })->editColumn('charge_amount', function ($transactions) {
                return formatCurrencyAmount($transactions->charge_amount + $transactions->commission_amount + $transactions->discount_amount);
            })->editColumn('status', function ($transactions) {
                return statusBadges($transactions->status);
            })
            ->addColumn('action', function ($transactions) {
                $edit = '<a title="' . __('Show') . '" href="' . route('withdrawal.edit', ['id' => $transactions->id]) . '" class="action-icon"><i class="feather icon-eye"></i></a>&nbsp;';
                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\WithdrawalController@edit'])) {
                    $str .= $edit;
                }

                return $str;
            })
            ->rawColumns(['user.name', 'withdrawal_method.name', 'currency_id', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount', 'status', 'action'])

            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $transactions = Transaction::select('transactions.id', 'user_id', 'currency_id', 'transactions.status', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount')->where('transaction_type', 'Withdrawal')->with(['user:id,name', 'currency:id,name', 'withdrawalMethod:id,method_name'])->filter();

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
            ->addColumn(['data' => 'user.name', 'name' => 'user.name', 'title' => __('Vendor'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'currency.name', 'name' => 'currency.name', 'title' => __('Currency'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'withdrawal_method.method_name', 'name' => 'withdrawalMethod.method_name', 'title' => __('Method'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => __('Amount'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'charge_amount', 'name' => 'charge_amount', 'title' => __('Fees'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'total_amount', 'name' => 'total_amount', 'title' => __('Total'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])

            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '5%',
                'visible' => $this->hasPermission(['App\Http\Controllers\WithdrawalController@edit']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
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
