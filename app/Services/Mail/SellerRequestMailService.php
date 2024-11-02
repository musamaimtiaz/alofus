<?php

namespace App\Services\Mail;

use App\Models\User;

class SellerRequestMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'seller-request-for-admin');

        if (! $email['status']) {
            return $email;
        }

        $admin = User::first();
        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $pattern = ['{user_name}', '{company_name}', '{logo}', '{support_mail}'];
        $replace = ['Admin', preference('company_name'), $this->logo, preference('company_email')];

        $message = str_replace($pattern, $replace, $email->body);

        return $this->email->sendEmail($admin->email, $subject, $message, null, preference('company_name'));
    }
}
