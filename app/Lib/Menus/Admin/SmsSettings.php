<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Al Mamun <[mailto:almamun.techvill@gmail.com]>
 *
 * @created 14-01-2024
 */

namespace App\Lib\Menus\Admin;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class SmsSettings
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $prms = Permission::getAuthUserPermission(optional(Auth::user())->id);
        $items = [
            'config' => [
                'label' => __('Config'),
                'route' => [
                    'sms.config.index',
                    'sms.config.twilio.index',
                    'sms.config.nexmo.index',
                    'sms.config.fast2sms.index',
                    'sms.config.sslwireless.index',
                    'sms.config.mim_sms.index',
                    'sms.config.msegat.index',
                    'sms.config.sparrow.index',
                    'sms.config.zender.index',
                ],
                'position' => '10',
                'visibility' => in_array('App\Http\Controllers\SmsConfigurationController@index', $prms),
            ],
            'templates' => [
                'label' => __('Templates'),
                'route' => ['sms.template.index', 'sms.template.edit'],
                'position' => '20',
                'visibility' => in_array('App\Http\Controllers\SmsTemplateController@index', $prms),
            ],
        ];

        $items = apply_filters('admin_sidebar_configuration_sms_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }

    /**
     * SMS Configs
     */
    public static function getConfigs()
    {
        $items = [
            'twilio' => [
                'title' => __('Twilio'),
                'description' => __('Twilio is a leading cloud communications platform, offering SMS and voice integration for developers globally.'),
                'image' => 'public/frontend/img/twilio.png',
                'link' => route('sms.config.twilio.index'),
                'position' => '10',
            ],
            'nexmo' => [
                'title' => 'Nexmo',
                'description' => __('Nexmo, part of Vonage, provides SMS APIs, allowing developers to easily integrate communication features into applications worldwide.'),
                'image' => 'public/frontend/img/nexmo.png',
                'link' => route('sms.config.nexmo.index'),
                'position' => 20,
            ],
            'fast2sms' => [
                'title' => 'Fast2Sms',
                'description' => __('Fast2SMS is a bulk SMS service enabling users to send large volumes of messages for marketing and communication purposes.'),
                'image' => 'public/frontend/img/fast2sms.png',
                'link' => route('sms.config.fast2sms.index'),
                'position' => 30,
            ],
            'sslwireless' => [
                'title' => 'SslWireless',
                'description' => __('SSL Wireless is an SMS gateway service that facilitates seamless and secure SMS communication, enabling businesses to efficiently send messages.'),
                'image' => 'public/frontend/img/sslwireless.png',
                'link' => route('sms.config.sslwireless.index'),
                'position' => 40,
            ],
            'mimsms' => [
                'title' => 'MIM Sms',
                'description' => __('Simplifying messaging with a reliable SMS gateway for effective business communication.'),
                'image' => 'public/frontend/img/mim-sms.png',
                'link' => route('sms.config.mim_sms.index'),
                'position' => 50,
            ],
            'msegat' => [
                'title' => 'Msegat',
                'description' => __('Empowering businesses with a robust and efficient platform for seamless SMS communication and engagement.'),
                'image' => 'public/frontend/img/msegat.png',
                'link' => route('sms.config.msegat.index'),
                'position' => 60,
            ],
            'sparrow' => [
                'title' => 'Sparrow',
                'description' => __('Accelerating communication for businesses through a reliable platform, ensuring efficient and streamlined SMS delivery.'),
                'image' => 'public/frontend/img/sparrow.png',
                'link' => route('sms.config.sparrow.index'),
                'position' => 70,
            ],
            'zender' => [
                'title' => 'Zender',
                'description' => __('A versatile platform empowering businesses with seamless and reliable SMS communication for effective engagement and outreach.'),
                'image' => 'public/frontend/img/zender.png',
                'link' => route('sms.config.zender.index'),
                'position' => 80,
            ],
        ];

        $items = apply_filters('admin_sms_provider', $items);

        // Sort items based on position, placing items without a position at the beginning
        uasort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
