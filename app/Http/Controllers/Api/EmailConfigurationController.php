<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use Illuminate\Http\Request;
use Config;

class EmailConfigurationController extends Controller
{
    /**
     * Index
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            $emailConfig     = EmailConfiguration::getAll()->first();

            return $this->response($emailConfig);
        } elseif ($request->isMethod('post')) {
            if (isset($request->protocol) && in_array(strtolower($request->protocol), ['smtp', 'send mail'])) {
                $request['protocol'] = strtolower($request->protocol);
            }
            $validator = EmailConfiguration::validation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            $request['status'] = $request->type == 'smtp' ? 'active' : 'inactive';
            if ($request->type == 'smtp') {
                /* Start Checking SMTP */
                Config::set([
                    'mail.driver' => isset($request->protocol) ? $request->protocol : '',
                    'mail.host' => isset($request->smtp_host) ? $request->smtp_host : '',
                    'mail.port' => isset($request->smtp_port) ? $request->smtp_port : '',
                    'mail.from' => ['address' => isset($request->from_address) ? $request->from_address : '',
                        'name' => isset($request->from_name) ? $request->from_name : ''],
                    'mail.encryption' => isset($request->encryption) ? $request->encryption : '',
                    'mail.username' => isset($request->smtp_username) ? $request->smtp_username : '',
                    'mail.password' => isset($request->smtp_password) ? $request->smtp_password : '',
                ]);
            }
            if ((new EmailConfiguration())->store($request->except('type'))) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Email Configuration')]));
            } else {
                return $this->okResponse([], __('No changes found.'));
            }
        }
    }
}
