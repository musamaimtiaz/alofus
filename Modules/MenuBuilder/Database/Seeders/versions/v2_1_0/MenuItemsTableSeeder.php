<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_1_0;

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        addMenuItem('admin', 'Sms', [
            'parent' => 'Configurations',
            'link' => 'sms/configs',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\SmsConfigurationController@index", "route_name":["sms.config.index", "sms.template.index", "sms.template.edit", "sms.config.twilio.index", "sms.config.nexmo.index", "sms.config.fast2sms.index", "sms.config.sslwireless.index", "sms.config.mim_sms.index", "sms.config.msegat.index", "sms.config.sparrow.index", "ms.config.zender.index"], "menu_level":"1"}',
            'sort' => 56,
        ]);

        addMenuItem('admin', 'Notification Log', [
            'parent' => 'Tools',
            'link' => 'notifications/log',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\NotificationController@log", "route_name":["notifications.log"], "menu_level":"1"}',
            'sort' => 134,
        ]);
    }
}
