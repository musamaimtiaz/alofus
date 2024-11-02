<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-02-2022
 */

namespace Modules\Refund\Http\Controllers\Vendor;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Services\Mail\RefundMailService;
use Modules\Refund\DataTables\VendorRefundDataTable;
use Modules\Refund\Exports\VendorRefundListExport;
use Modules\Refund\Entities\{
    Refund,
    RefundProcess,
};
use App\Http\Controllers\{
    Controller,
    EmailController
};
use Excel;

class RefundController extends Controller
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Vendor Refund List
     *
     * @return Renderable
     */
    public function index(VendorRefundDataTable $dataTable)
    {
        return $dataTable->render('refund::vendor.index');
    }

    /**
     * Edit Vendor Refund
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $result = $this->checkExistence($id, 'refunds');
        if ($result['status'] == true) {
            $data['refund'] = Refund::where('id', $id)->with(['user', 'orderDetail', 'refundReason'])->first();
            $data['refundProcesses'] = RefundProcess::where(['refund_id' => $id])->with(['user'])->get();

            return view('refund::vendor.edit', $data);
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
                (new RefundMailService())->send($request);
            }
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('vendor.refund.index');
    }

    /**
     * Shop list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['refunds'] = Refund::whereHas('orderDetail', function ($q) {
            $q->where('vendor_id', auth()->user()->vendor()->vendor->id);
        })->with('refundReason', 'orderDetail')->get();

        return printPDF($data, 'refund_list' . time() . '.pdf', 'refund::vendor.pdf', view('refund::vendor.pdf', $data), 'pdf');
    }

    /**
     * Shop list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorRefundListExport(), 'refund_list' . time() . '.csv');
    }
}
