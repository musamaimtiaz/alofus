<?php

namespace App\Services\Mail;

class sellerStatusMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        // Retrieve preference value and field name and language id
        $prefer = preference();

        $userStatus = ['Active' => 'admin-accepted-seller-request', 'Pending' => 'admin-change-seller-status', 'Inactive' => 'admin-change-seller-status'];
        $email = $this->getTemplate(preference('dflt_lang'), $userStatus[$request->status]);

        if (! $email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $pattern = ['{user_name}', '{company_url}', '{company_name}', '{logo}', '{support_mail}'];
        $replace = [$request->name, url('/admin'), preference('company_name'), $this->logo, preference('company_email')];

        $message = str_replace($pattern, $replace, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
