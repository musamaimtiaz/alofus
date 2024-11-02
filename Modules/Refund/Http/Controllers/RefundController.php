<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-02-2022
 */

namespace Modules\Refund\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Refund\DataTables\RefundDataTable;
use Modules\Refund\Exports\RefundListExport;
use Modules\Refund\Entities\{
    Refund,
    RefundProcess,
};
use App\Http\Controllers\{
    Controller,
    EmailController
};
use App\Models\User;
use App\Notifications\AcceptRefundRequestNotification;
use App\Notifications\DeclineRefundRequestNotification;
use App\Notifications\InProgressRefundRequestNotification;
use Excel;

class RefundController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Refund List
     *
     * @return Renderable
     */
    public function index(RefundDataTable $dataTable)
    {
        return $dataTable->render('refund::index');
    }

    /**
     * Edit Refund
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function edit($id = null)
    {
        $result = $this->checkExistence($id, 'refunds');
        if ($result['status'] == true) {
            $data['refund'] = Refund::where('id', $id)->with(['user', 'orderDetail', 'refundReason'])->first();
            $data['refundProcesses'] = RefundProcess::where(['refund_id' => $id])->with(['user'])->get();

            return view('refund::edit', $data);
        }

        $this->setSessionValue(['status' => 'fail', 'message' => $result['message']]);

        return back();
    }

    /**
     * Update Refund
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $notification = [
            'In progress' => InProgressRefundRequestNotification::class,
            'Declined' => DeclineRefundRequestNotification::class,
            'Accepted' => AcceptRefundRequestNotification::class,
        ];

        $result = $this->checkExistence($request->id, 'refunds');
        if ($result['status'] === true) {
            $validator = Refund::updateValidation($request->all(), $request->id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $response = (new Refund())->updateData($request->all(), $request->id);

            if (isActive('Affiliate')) {
                \Modules\Affiliate\Entities\CommissionLog::refund($request->id, $request->status);
            }

            if ($response['status'] == 'success' && $request->status != 'Opened') {
                if (array_key_exists($request->status, $notification)) {
                    User::find($request->user_id)->notify(new $notification[$request->status]($request));
                }
            }
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('refund.index');
    }

    /**
     * Shop list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['refunds'] = Refund::getAll();

        return printPDF($data, 'refund_list' . time() . '.pdf', 'refund::pdf', view('refund::pdf', $data), 'pdf');
    }

    /**
     * Shop list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new RefundListExport(), 'refund_list' . time() . '.csv');
    }
}
