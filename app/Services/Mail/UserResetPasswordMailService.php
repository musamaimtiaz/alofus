<?php

namespace App\Services\Mail;

use App\Models\User;

class UserResetPasswordMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'reset-password');

        if (! $email['status']) {
            return $email;
        }

        $user = User::select('id', 'name')->where('email', $request->email)->first();

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{logo}' => $this->logo,
            '{verification_url}' => route('site.password.reset', ['token' => $request->token]),
            '{company_name}' => preference('company_name'),
            '{verification_otp}' => $request->otp,
            '{support_mail}' => preference('company_email'),
            '{user_name}' => $user->name,
            '{otp_active}' => ! User::userVerification('otp') ? 'display: none;' : '',
            '{token_active}' => ! User::userVerification('token') ? 'display: none;' : '',
            '{token_otp_active}' => User::userVerification('token') && User::userVerification('otp') ? '' : 'display: none;',
        ];

        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
