<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Services\Mail\TicketReplyMailService;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;

class TicketReplyNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Ticket Reply';

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
        return ['mail', SmsChannel::class, AdminDatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new TicketReplyMailService())->send($this->request);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toAdmin(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => route('admin.threadReply', ['id' => base64_encode($this->request['emailInfo']->id)]),
            'message' => "{$this->request['emailInfo']->name} has replied to Ticket No: {$this->request['emailInfo']->id}.",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('ticket-reply'),
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
        $assignData = User::where('id', $this->request['assignId'])->first();
        $ticket_reply = url('admin/ticket/reply/' . base64_encode($this->request['emailInfo']->id));

        $data = [
            '{name}' => $assignData->name,
            '{ticket_message}' => optional($this->request['emailInfo']->threadReplies[0])['message'],
            '{ticket_no}' => $this->request['emailInfo']->id,
            '{customer_id}' => $this->request['assignId'],
            '{ticket_subject}' => $this->request['emailInfo']->subject,
            '{ticket_status}' => optional($this->request['emailInfo']->threadStatus)->name,
            '{details}' => $ticket_reply,
            '{team_member}' => auth()->user()->name,
            '{company_name}' => preference('company_name'),
            '{logo}' => '',
        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
