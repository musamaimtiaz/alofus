<?php

namespace App\Services\Mail;

class LowStockThreshold extends TechVillageMail
{
    /**
     * Send mail to vendor
     *
     * @param  object  $data
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'low-stock-threshold');

        if (! $email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{logo}' => $this->logo,
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{user_name}' => $request['vendor_name'],
            '{company_url}' => route('site.index'),
            '{product_list}' => $request['product_list'],
        ];

        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request['email'], $subject, $message, null, preference('company_name'));
    }
}
