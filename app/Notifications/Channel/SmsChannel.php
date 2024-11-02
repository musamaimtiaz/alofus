<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    /**
     * The data for the SMS notification.
     *
     * @var array
     */
    private $data;

    /**
     * The default SMS gateway to be used.
     *
     * @var string
     */
    private $defaultSmsGateway;

    /**
     * The available SMS gateways configuration.
     *
     * @var array
     */
    private $smsGateways;

    /**
     * Notification Class.
     *
     * @var string
     */
    private $notificationClass;

    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $this->initialize($notifiable, $notification);

        if ($this->isValid()) {
            $this->sendSms();
        }
    }

    /**
     * Initialize the data and configuration.
     */
    private function initialize($notifiable, Notification $notification): void
    {
        $this->data = $notification->toSms($notifiable);
        $this->defaultSmsGateway = config('notification.default_sms_gateway');
        $this->smsGateways = config('notification.sms_gateways');
        $this->notificationClass = $this->smsGateways[$this->defaultSmsGateway] ?? '';
    }

    /**
     * Check if the data and configuration are valid for sending SMS.
     */
    private function isValid(): bool
    {
        return ! empty($this->data['to'])
            && ! empty($this->data['message'])
            && array_key_exists($this->defaultSmsGateway, $this->smsGateways)
            && class_exists($this->notificationClass)
            && is_subclass_of($this->notificationClass, SmsInterface::class);
    }

    /**
     * Send the SMS using the selected gateway.
     */
    private function sendSms(): void
    {
        try {
            app($this->notificationClass)->send($this->data);
        } catch (Exception $e) {
            // Log the error or handle it gracefully
            Log::error('Error sending SMS: ' . $e->getMessage());
        }
    }
}
