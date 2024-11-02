<?php

namespace App\Services\Mail;

class UserSetPasswordMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'new-password-set');

        if (! $email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{user_name}' => $request->user_name,
            '{user_id}' => $request->email,
            '{user_pass}' => $request->raw_password,
            '{company_url}' => route('site.login'),
            '{company_name}' =>  preference('company_name'),
            '{support_mail}' =>  preference('company_email'),
            '{logo}' =>  $this->logo,
        ];

        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
