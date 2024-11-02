<?php

namespace App\Services\Mail;

use App\Models\User;
use Auth;

class VendorMailService extends TechVillageMail
{
    /**
     * Send mail to Vendor
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'ticket-vendor');

        if (! $email['status']) {
            return $email;
        }

        $assignData = User::where('id', $request['receiverId'])->first();
        $ticket_reply = url('vendor/ticket/reply/' . base64_encode($request['emailInfo']->id));
        $subject      = str_replace(['{ticket_subject}', '{ticket_no}'], [$request['emailInfo']->subject, $request['emailInfo']->id], $email->subject);
        $message = str_replace(
            ['{assignee_name}', '{ticket_message}', '{ticket_no}', '{customer_id}', '{ticket_subject}', '{ticket_status}',
                '{details}', '{assigned_by_whom}', '{company_name}'],
            [$assignData->name, optional($request['emailInfo']->threadReplies[0])['message'], $request['emailInfo']->id, $request['assignId'], $request['emailInfo']->subject,
                optional($request['emailInfo']->threadStatus)->name, $ticket_reply, Auth::user()->name, preference('company_name')],
            $email->body
        );

        return $this->email->sendEmail($assignData->email, $subject, $message, $request['files'], 'assignee');

    }
}
