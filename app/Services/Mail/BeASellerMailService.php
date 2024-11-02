<?php

namespace App\Services\Mail;

use App\Models\User;

class BeASellerMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'email-verification');

        if (! $email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{logo}' => $this->logo,
            '{verification_url}' => url('/seller-verify', $request->activation_code),
            '{company_name}' => preference('company_name'),
            '{verification_otp}' => $request->activation_otp,
            '{support_mail}' => preference('company_email'),
            '{otp_active}' => ! User::userVerification('otp') ? 'display: none;' : '',
            '{token_active}' => ! User::userVerification('token') ? 'display: none;' : '',
            '{token_otp_active}' => User::userVerification('token') && User::userVerification('otp') ? '' : 'display: none;',
        ];
        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
