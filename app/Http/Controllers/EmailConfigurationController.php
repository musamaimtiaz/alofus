<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    EmailConfiguration
};
use Config;
use Session;

class EmailConfigurationController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $data['list_menu'] = 'email_setup';
        if ($request->isMethod('get')) {
            $data['emailConfigData'] = EmailConfiguration::getAll()->first();

            return view('admin.email_configuration.index', $data);
        } elseif ($request->isMethod('post')) {
            $data = ['status' => 'fail', 'message' => __('Invalid Request')];
            if (isset($request->protocol) && in_array(strtolower($request->protocol), ['smtp', 'send mail'])) {
                $request['protocol'] = strtolower($request->protocol);
            }

            $validator = EmailConfiguration::validation($request->all());

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $request['status'] = $request->type == 'smtp' ? 'Active' : 'Inactive';

            if ($request->type == 'smtp') {
                /* Start Checking SMTP */
                Config::set([
                    'mail.driver'     => isset($request->protocol) ? $request->protocol : '',
                    'mail.host'       => isset($request->smtp_host) ? $request->smtp_host : '',
                    'mail.port'       => isset($request->smtp_port) ? $request->smtp_port : '',
                    'mail.from'       => ['address' => isset($request->from_address) ? $request->from_address : '',
                        'name'            => isset($request->from_name) ? $request->from_name : ''],
                    'mail.encryption' => isset($request->encryption) ? $request->encryption : '',
                    'mail.username'   => isset($request->smtp_username) ? $request->smtp_username : '',
                    'mail.password'   => isset($request->smtp_password) ? $request->smtp_password : '',
                ]);
            }

            try {
                if ($request->type == 'smtp') {
                    (new EmailConfiguration())->store($request->except('_token', 'type'));
                } else {
                    (new EmailConfiguration())->store($request->only('protocol'));
                }

                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully saved.', ['x' => __('Email Configuration')]);
            } catch (\Exception $e) {
                $data['message'] = $e->getMessage();
            }

            Session::flash($data['status'], $data['message']);

            return redirect()->route('emailConfigurations.index');
        }
    }
}
