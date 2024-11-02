<?php

namespace Modules\Popup\Services\Mail;

use App\Http\Controllers\EmailController;
use App\Services\Mail\TechVillageMail;

class PopupMailService extends TechVillageMail
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
        $email = $this->getTemplate($prefer['dflt_lang'], 'popup-mail');

        // Replacing template variable
        // Need to change assigned by whom value with auth user
        $subject = str_replace('{company_name}', $prefer['company_name'], $email->subject);

        $pattern = ['{logo}', '{company_name}', '{mail_content}', '{support_mail}'];
        $replace = [$this->logo, $prefer['company_name'], $request['mail_content'], preference('company_email')];

        $message = str_replace($pattern, $replace, $email->body);

        return (new EmailController())->sendEmail($request->email, $subject, $message, null, $prefer['company_name']);
    }
}
