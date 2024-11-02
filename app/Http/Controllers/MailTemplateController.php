<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use App\Models\{
    Language,
    EmailTemplate,
    Preference
};
use Session;
use Illuminate\Http\Request;
use App\DataTables\EmailTemplateListDataTable;

class MailTemplateController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(EmailTemplateListDataTable $dataTable)
    {
        $data['list_menu'] = 'email_template';

        return $dataTable->render('admin.email_templates.index', $data);
    }

    /**
     * Create
     *
     * @return Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['list_menu'] = 'email_template';

        return view('admin.email_templates.create', $data);
    }

    /**
     * Store
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            if (isset($request->status) && in_array($request->status, ['Active', 'Inactive'])) {
                $request['status'] = $request->status;
            }

            $validator = EmailTemplate::storeValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $request['language_id'] = 1;

            try {
                if ((new EmailTemplate())->store($request->all())) {
                    $data['status'] = 'success';
                    $data['message'] = __('The :x has been successfully saved.', ['x' => __('Email Template')]);
                }
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('emailTemplates.index');
    }

    /**
     * Edit
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $data['list_menu'] = 'email_template';
        $template = EmailTemplate::getAll()->where('id', $id)->whereNull('parent_id')->first();
        if (empty($template)) {
            $this->setSessionValue(['status' => 'fail', 'message' => __(':x does not exist.', ['x' => __('Id')])]);

            return redirect()->route('dashboard');
        }

        $childTemplates = EmailTemplate::getAll()->where('parent_id', $id);
        $childs = [];
        foreach ($childTemplates as $key => $value) {
            $childs[$value->language_id] = ['subject' => $value->subject, 'body' => $value->body];
        }

        $data['template'] = $template;
        $data['childs'] = $childs;

        return view('admin.email_templates.edit', $data);
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'email_templates');
            if ($result['status'] === true) {
                $response = (new EmailTemplate())->remove($id);
            } else {
                $response['status'] = 'fail';
                $response['message'] = $result['message'];
            }
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->route('emailTemplates.index');
    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id = null)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            if (isset($request->status) && in_array($request->status, ['Active', 'Inactive'])) {
                $request['status'] = $request->status;
            }

            $result = $this->checkExistence($id, 'email_templates', ['getData' => true]);
            if ($result['status'] === true) {
                $validator = EmailTemplate::updateValidation($request->all(), $id, $result['data']);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $request['language_id'] = 1;
                $response = (new EmailTemplate())->updateTemplate($request->all(), $id, $result['data']);
            } else {
                $response['message'] = $result['message'];
            }
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->route('emailTemplates.index');
    }
}
