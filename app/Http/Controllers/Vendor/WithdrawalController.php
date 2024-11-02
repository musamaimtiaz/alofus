<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-02-2022
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\WithdrawalHistoryDataTable;
use App\Exports\VendorWithdrawalHistoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Withdrawal\PaypalRequest;
use Illuminate\Http\Request;
use Modules\Shop\Http\Models\Shop;
use App\Models\{Transaction, UserWithdrawalSetting, Vendor, WithdrawalMethod};
use Excel;

class WithdrawalController extends Controller
{
    /**
     * Withdrawal list
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(WithdrawalHistoryDataTable $dataTable)
    {
        return $dataTable->render('vendor.withdrawal.index');
    }

    /**
     * Withdrawal Setting
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function setting(PaypalRequest $request)
    {
        if ($request->isMethod('get')) {
            $data['methods'] = WithdrawalMethod::getAll()->where('status', 'Active');

            return view('vendor.withdrawal.setting', $data);
        } elseif ($request->isMethod('post')) {
            $response = $this->checkExistence($request->id, 'withdrawal_methods', ['getData' => true]);

            if ($response['status']) {
                if ($response['data']->method_name == 'Paypal') {
                    $request['param'] = json_encode((object) ['email' => $request->email]);
                } elseif ($response['data']->method_name == 'Bank') {
                    $request['param'] = json_encode((object) $request->except(['_token', 'id', 'is_default']));
                }
            }

            $request['user_id'] = auth()->user()->id;
            $request['withdrawal_method_id'] = $request->id;
            $response = (new UserWithdrawalSetting())->updateData($request->only('user_id', 'withdrawal_method_id', 'param', 'is_default'));

            $this->setSessionValue($response);

            return back();
        }
    }

    /**
     * Withdraw money
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function withdraw(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['methods'] = WithdrawalMethod::getAll()->where('status', 'Active');

            return view('vendor.withdrawal.withdraw', $data);
        } elseif ($request->isMethod('post')) {
            $validator = Transaction::withdrawValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (auth()->user()->withdrawalSettings()->where('withdrawal_method_id', $request['withdrawal_method_id'])->count() == 0) {
                return redirect()->route('vendorWithdrawal.setting')->withFail(__('Please update withdrawal setting.'));
            }
            $vendorId = session()->get('vendorId');
            $vendorShop = Shop::where('vendor_id', $vendorId)->first();
            $request['total_amount'] = $request['amount'];
            $request['transaction_type'] = 'Withdrawal';
            $request['status'] = 'Pending';
            $request['vendor_id'] = $vendorId;
            $request['shop_id'] = ! empty($vendorShop) ? $vendorShop->id : null;
            $response = (new Transaction())->storeData($request->only('withdrawal_method_id', 'currency_id', 'amount', 'user_id', 'total_amount', 'transaction_type', 'transaction_date', 'status', 'vendor_id', 'shop_id'));

            $this->setSessionValue($response);

            return $response['status'] == 'fail' ? back() : redirect()->route('vendorWithdrawal.index');
        }
    }

    /**
     * Withdrawal list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['withdrawals'] = Transaction::where(['user_id' => auth()->user()->id, 'transaction_type' => 'Withdrawal'])->get();

        return printPDF(
            $data,
            'withdrawal_history' . time() . '.pdf',
            'vendor.withdrawal.pdf',
            view('vendor.withdrawal.pdf', $data),
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
        return Excel::download(new VendorWithdrawalHistoryExport(), 'withdrawal_history' . time() . '.csv');
    }
}
