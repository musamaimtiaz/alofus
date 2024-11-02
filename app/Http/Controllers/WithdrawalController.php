<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-02-2022
 */

namespace App\Http\Controllers;

use App\DataTables\WithdrawalListDataTable;
use App\Exports\WithdrawalListExport;
use Illuminate\Http\Request;
use App\Models\{
    Transaction,
    WithdrawalMethod,
};
use Excel;

class WithdrawalController extends Controller
{
    /**
     * Withdrawal List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(WithdrawalListDataTable $dataTable)
    {
        return $dataTable->render('admin.withdrawal.index');
    }

    /**
     * Withdrawal edit
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data['withdrawal'] = Transaction::getAll()->where('id', $id)->first();

        return view('admin.withdrawal.edit', $data);
    }

    /**
     * Withdrawal update
     *
     * @param  int  $id
     * @return redirect view
     */
    public function update(Request $request, $id)
    {
        $validator = Transaction::updateValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $response = (new Transaction())->updateData($request->only('status'), $id);

        $response['message'] = $response['status'] == 'success' ? __('The :x has been successfully saved.', ['x' => __('Withdrawal')]) : $response['message'];

        $this->setSessionValue($response);

        return redirect()->route('withdrawal.index');
    }

    /**
     * Withdrawal list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['transactions'] = Transaction::getAll()->where('transaction_type', 'Withdrawal');

        return printPDF(
            $data,
            'withdrawal_list' . time() . '.pdf',
            'admin.withdrawal.pdf',
            view('admin.withdrawal.pdf', $data),
            'pdf'
        );
    }

    /**
     * Withdrawal list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new WithdrawalListExport(), 'withdrawal' . time() . '.csv');
    }
}
