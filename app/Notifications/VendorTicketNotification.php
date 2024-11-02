<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\VendorMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class VendorTicketNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Vendor Ticket';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/ticket.png';

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function setVia($notifiable)
    {
        return ['mail', 'database', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new VendorMailService())->send($this->request);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => route('vendor.threadReply', ['id' => base64_encode($this->request['emailInfo']->id)]),
            'message' => "A new support ticket has been assigned to you. Ticket No: {$this->request['emailInfo']->id}",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => __('Reset Password'),
        ];
    }

    /**
     * Replace SMS variables in the given SMS body.
     *
     * @param  string  $body
     * @return string
     */
    public function replaceSmsVariables($body)
    {
        $assignData = User::where('id', $this->request['receiverId'])->first();
        $ticket_reply = url('vendor/ticket/reply/' . base64_encode($this->request['emailInfo']->id));

        $data = [
            '{assignee_name}' => $assignData->name,
            '{ticket_message}' => $this->request['emailInfo']?->threadReplies[0]['message'],
            '{ticket_no}' => $this->request['emailInfo']->id,
            '{customer_id}' => $this->request['assignId'],
            '{ticket_subject}' => $this->request['emailInfo']->subject,
            '{ticket_status}' => $this->request['emailInfo']?->threadStatus?->name,
            '{details}' => $ticket_reply,
            '{assigned_by_whom}' => auth()->user()->name,
            '{company_name}' => preference('company_name'),
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
