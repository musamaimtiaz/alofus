<?php

namespace Modules\Newsletter\Http\Controllers;

use Modules\Newsletter\DataTables\SubscriberDataTable;
use Modules\Newsletter\Entities\Subscriber;
use Modules\Newsletter\Exports\SubscriberListExport;
use Modules\Newsletter\Http\Requests\{
    StoreSubscriberRequest,
    UpdateSubscriberRequest
};
use App\Http\Controllers\{
    Controller,
    EmailController
};
use Modules\Newsletter\Services\Mail\NewsletterMailService;

class SubscriberController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Subscribe List
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(SubscriberDataTable $dataTable)
    {
        return $dataTable->render('newsletter::subscriber.index');
    }

    /**
     * Store Subscriber
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StoreSubscriberRequest $request)
    {
        $response = (new Subscriber())->store($request->validated());
        $request['subscription_id'] = $response['id'];
        if ($response['status'] == 'success') {
            (new NewsletterMailService())->send($request);
        }

        if ($request->wantsJson()) {
            return $response;
        }

        return redirect()->back();
    }

    /**
     * Edit Subscriber
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $result = $this->checkExistence($id, 'subscribers', ['getData' => true]);
        if ($result['status'] == true) {
            $data['subscriber'] = $result['data'];

            return view('newsletter::subscriber.edit', $data);
        }

        $this->setSessionValue(['status' => 'fail', 'message' => $result['message']]);

        return back();
    }

    /**
     * Update Subscriber
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateSubscriberRequest $request, $id)
    {
        $result = $this->checkExistence($id, 'subscribers');
        if ($result['status'] === true) {
            $response = (new Subscriber())->updateData($request->validated(), $id);
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('subscriber.index');
    }

    /**
     * Delete Subscriber
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id = null)
    {
        $result = $this->checkExistence($id, 'subscribers');
        if ($result['status'] === true) {
            $response = (new Subscriber())->remove($id);
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('subscriber.index');
    }

    /**
     * Subscriber list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['subscribers'] = Subscriber::getAll();

        return printPDF($data, 'subscriber_list' . time() . '.pdf', 'newsletter::subscriber.pdf', view('newsletter::subscriber.pdf', $data), 'pdf');
    }

    /**
     * Subscriber list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return \Excel::download(new SubscriberListExport(), 'subscriber_list' . time() . '.csv');
    }

    /**
     * Delete Subscriber
     *
     * @param  techEncrypt  $string
     * @return \Illuminate\Routing\Redirector
     */
    public function unsubscribe($string = null)
    {
        $id = techDecrypt($string);
        $result = $this->checkExistence($id, 'subscribers');

        if ($result['status'] === true) {
            $response = (new Subscriber())->remove($id);
        } else {
            $response = ['status' => 'fail', 'message' => $result['message']];
        }

        $this->setSessionValue($response);

        return redirect()->route('site.index');
    }
}
