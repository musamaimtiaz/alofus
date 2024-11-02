<?php

namespace Modules\Newsletter\Services\Mail;

use App\Models\Preference;
use App\Services\Mail\TechVillageMail;

class NewsletterMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'subscriber');

        $logo = Preference::where('field', 'company_logo')->first()->fileUrl();

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $data = [
            '{logo}' => $logo,
            '{home_url}' => url('/'),
            '{support_mail}' => preference('company_email'),
            '{company_name}' => preference('company_name'),
            '{unsubscribe}' => route('subscription.destroy', techEncrypt($request->subscription_id)),
        ];

        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
