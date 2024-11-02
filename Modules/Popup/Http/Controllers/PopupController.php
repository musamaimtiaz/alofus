<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 08-03-2022
 */

namespace Modules\Popup\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PopupNotification;
use Modules\Popup\DataTables\PopupDataTable;
use Modules\Popup\Entities\Popup;
use Modules\Popup\Exports\PopupListExport;
use Excel;
use Illuminate\Support\Facades\Notification;

class PopupController extends Controller
{
    /**
     * Popup List
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(PopupDataTable $dataTable)
    {
        return $dataTable->render('popup::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('popup::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Popup::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $param = $request->except(['_token', 'name', 'type', 'show_time', 'page_link', 'start_date', 'end_date', 'login_enabled', 'status']);
        $request['param'] = json_encode($param);

        $request['start_date'] = DbDateFormat($request->start_date);
        $request['end_date'] = DbDateFormat($request->end_date);

        $this->setSessionValue((new Popup())->store($request->only('name', 'type', 'show_time', 'page_link', 'start_date', 'end_date', 'login_enabled', 'status', 'param')));

        return redirect()->route('popup.index');
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contract\View\View
     */
    public function show($id)
    {
        $data['popup'] = Popup::where('id', $id)->first();
        $data['content'] = json_decode($data['popup']->param);

        return view('popup::show', $data);
    }

    /**
     * Edit Popup
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Routing\Redirector
     */
    public function edit($id = null)
    {
        $result = $this->checkExistence($id, 'popups', ['getData' => true]);
        $data['popup'] = Popup::find($id);
        if (! empty($data['popup'])) {
            $data['param'] = json_decode($data['popup']->param);

            return view('popup::edit', $data);
        }

        $this->setSessionValue(['status' => 'fail', 'message' => $result['message']]);

        return back();
    }

    /**
     * Update Popup
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $result = $this->checkExistence($id, 'popups');
        if ($result['status'] === true) {
            $validator = Popup::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $param = $request->except(['_token', 'name', 'type', 'show_time', 'page_link', 'start_date', 'end_date', 'login_enabled', 'status']);
            $request['param'] = json_encode($param);

            $request['start_date'] = DbDateFormat($request->start_date);
            $request['end_date'] = DbDateFormat($request->end_date);

            $response = (new Popup())->updateData($request->only('name', 'type', 'show_time', 'page_link', 'start_date', 'end_date', 'login_enabled', 'status', 'param'), $id);
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('popup.index');
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id = null)
    {
        $this->setSessionValue((new Popup())->remove($id));

        return redirect()->route('popup.index');
    }

    /**
     * Popup list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['popups'] = Popup::getAll();

        return printPDF($data, 'popup_list' . time() . '.pdf', 'popup::pdf', view('popup::pdf', $data), 'pdf', 'domPdf');
    }

    /**
     * Popup list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new PopupListExport(), 'popup_list' . time() . '.csv');
    }

    /**
     * Send mail to user
     *
     * @return void|\Illuminate\Routing\Redirector
     */
    public function mail(Request $request)
    {
        if (! empty($request->email) && validateEmail($request->email)) {
            $request['mail_content'] = json_decode(Popup::find($request->id)->param)->email_content;
            Notification::route('mail', $request->email)
                ->notify(new PopupNotification($request));
        }

        return redirect()->back();
    }
}
