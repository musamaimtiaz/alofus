<?php

namespace App\Services\Mail;

class UserMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $userStatus = ['Active' => 'user', 'Pending' => 'email-verification'];
        $email = $this->getTemplate(preference('dflt_lang'), $userStatus[$request['status']]);

        if (! $email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{logo}' => $this->logo,
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
        ];

        if ($request['status'] == 'Active') {
            $data['{user_name}'] = $request['name'];
            $data['{company_url}'] = route('site.index');
        } else {
            $data['{verification_url}'] = route('site.verify', ['token' => $request['activation_code']]);
            $data['{otp_active}'] = 'display: none;';
            $data['{token_otp_active}'] = 'display: none;';
        }

        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request['email'], $subject, $message, null, preference('company_name'));
    }
}
