<?php

namespace Database\Seeders\versions\v2_1_0;

use App\Models\NotificationSetting;
use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use Illuminate\Database\Seeder;

class NotificationSettingsTableSeeder extends Seeder
{
    /**
     * Update notification setting for given notification type and channels.
     *
     * @param  string  $notificationType  Fully qualified class name of the notification
     */
    private function update($notificationType)
    {
        foreach (['mail', 'database', SmsChannel::class, AdminDatabaseChannel::class] as $channel) {
            NotificationSetting::updateOrInsert(['notification_type' => $notificationType, 'channel' => $channel], ['is_active' => 1]);
        }
    }

    /**
     * Run the function to update various notifications.
     */
    public function run()
    {
        $this->update(\App\Notifications\AcceptRefundRequestNotification::class);
        $this->update(\App\Notifications\AcceptSellerRequestNotification::class);
        $this->update(\App\Notifications\ChangeSellerRequestNotification::class);
        $this->update(\App\Notifications\DeclineRefundRequestNotification::class);
        $this->update(\App\Notifications\InProgressRefundRequestNotification::class);
        $this->update(\App\Notifications\LowStockThresholdNotification::class);
        $this->update(\App\Notifications\NewsletterSubscriptionNotification::class);
        $this->update(\App\Notifications\OrderInvoiceNotification::class);
        $this->update(\App\Notifications\PopupNotification::class);
        $this->update(\App\Notifications\ResetPasswordNotification::class);
        $this->update(\App\Notifications\SellerRequestToAdminNotification::class);
        $this->update(\App\Notifications\TicketAssigneeNotification::class);
        $this->update(\App\Notifications\TicketReplyNotification::class);
        $this->update(\App\Notifications\UserPasswordSetNotification::class);
        $this->update(\App\Notifications\UserVerificationNotification::class);
        $this->update(\App\Notifications\VendorOrderInvoiceNotification::class);
        $this->update(\App\Notifications\VendorTicketNotification::class);
        $this->update(\App\Notifications\WelcomeUserNotification::class);
    }
}
