<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use Config;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\{
    Preference,
    EmailConfiguration,
    File,
    User
};
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * The array of success message if email sent.
     *
     * @var array
     */
    protected $successResponse = [];

    /**
     * The array of fail message if email not sent.
     *
     * @var array
     */
    protected $failResponse = [];

    /**
     * The array of message of email, either send email or not.
     *
     * @var array
     */
    protected $response = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->successResponse = [
            'status'  => true,
            'message' => __(':x sent successfully.', ['x' => __('Email')]),
        ];

        $this->failResponse = [
            'status'  => false,
            'message' => __(':x can not be sent, please check email configuration or try again.', ['x' => __('Email')]),
        ];

        $this->response = $this->successResponse;
    }

    /**
     * send mail
     *
     * @return array
     */
    public function sendEmail($to, $subject, $messageBody, $attachments = [], $companyName = null)
    {
        if (! validateEmail($to)) {
            return $this->failResponse;
        }

        $mail     = new \App\libraries\MailService();
        $dataMail = [];
        if (! empty($attachments)) {
            $dataMail = [
                'to'      => [$to],
                'subject' => $subject,
                'content' => $messageBody,
                'attach'  => $attachments,
            ];
        } else {
            $dataMail = [
                'to'      => [$to],
                'subject' => $subject,
                'content' => $messageBody,
            ];
        }
        $emailInfo = EmailConfiguration::getAll()->first();
        if ($emailInfo && $emailInfo->protocol == 'smtp') {

            try {
                $this->setupEmailConfig($companyName);
                $mail->send($dataMail, 'admin.emails.content');
            } catch (\Exception $e) {
                $this->response = $this->failResponse;
            }
        } else {
            $return = $this->sendPhpEmail($to, $subject, $messageBody, $emailInfo, '');
            if (empty($return)) {
                $this->response = $this->failResponse;
            }
        }

        return $this->response;
    }

    /**
     * send mail with attachment
     *
     * @return array
     */
    public function sendEmailWithAttachment($to, $subject, $messageBody, $invoiceName, $companyName = null)
    {
        $mail     = new \App\libraries\MailService();
        $dataMail = [];
        $dataMail = [
            'to'      => [$to],
            'subject' => $subject,
            'content' => $messageBody,
            'attach'  => url("public/uploads/invoices/$invoiceName"),
        ];

        $emailInfo = EmailConfiguration::getAll()->first();
        if (! empty($emailInfo) && $emailInfo->protocol == 'smtp') {
            try {
                $this->setupEmailConfig($companyName);
                $mail->send($dataMail, 'admin.emails.content');
            } catch (\Exception $e) {
                $this->response = $this->failResponse;
            }
        } else {
            $return = $this->sendPhpEmail($to, $subject, $messageBody, $emailInfo, $invoiceName);
            if (empty($return)) {
                $this->response = $this->failResponse;
            }
        }

        @unlink(public_path('/uploads/invoices/' . $invoiceName));

        return $this->response;
    }

    /**
     * email config
     *
     * @return void
     */
    public function setupEmailConfig($companyName = null)
    {
        $result = EmailConfiguration::getAll()->first();
        $value = ['address' => isset($result->from_address) ? $result->from_address : '', 'name' => isset($result->from_name) ? $result->from_name : ''];

        if (! empty($companyName)) {
            $value = ['address' => isset($result->from_address) ? $result->from_address : '', 'name' => $companyName];
        }

        Config::set([
            'mail.driver'     => isset($result->protocol) ? $result->protocol : '',
            'mail.host'       => isset($result->smtp_host) ? $result->smtp_host : '',
            'mail.port'       => isset($result->smtp_port) ? $result->smtp_port : '',
            'mail.from'       => $value,
            'mail.encryption' => isset($result->encryption) ? $result->encryption : '',
            'mail.username'   => isset($result->smtp_username) ? $result->smtp_username : '',
            'mail.password'   => isset($result->smtp_password) ? $result->smtp_password : '',

        ]);
    }

    /**
     * @return bool
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendPhpEmail($to, $subject, $message, $emailInfo, $invoiceName)
    {
        require 'vendor/autoload.php';

        $mail           = new PHPMailer();
        $cus_name       = User::where('email', $to)->first();
        $mail->From     = preference('company_email');
        $mail->FromName = preference('company_name');
        $mail->AddAddress($to);
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = strip_tags('Message');
        if (! empty($invoiceName)) {
            return $mail->AddAttachment(public_path() . ('/uploads/invoices' . '/' . $invoiceName), 'Invoice', 'base64', 'application/pdf');
        }

        return $mail->Send();
    }

    /**
     * Email Verify Setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function emailVerifySetting(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data['list_menu'] = 'email_verify_setting';

            return view('admin.emails.user-verification', $data);
        }

        if (empty($request->verification)) {
            return redirect()->back()->withErrors(__('Something went wrong, please try again.'));
        }

        $updatedPreference = (new Preference())->storeOrUpdate(
            ['category' => 'verification', 'field' => 'email', 'value' => $request->verification]
        );

        if ($updatedPreference) {
            return redirect()->back()->withSuccess(__('User verification updated successfully.'));
        }
    }
}
