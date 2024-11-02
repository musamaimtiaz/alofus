<?php

namespace App\Traits;

use App\Models\EmailConfiguration;
use App\Models\EmailTemplate;
use App\Models\Language;
use App\Models\Preference;
use Illuminate\Support\Facades\Config;

trait NotificationTrait
{
    /**
     * Company Logo
     */
    protected string $companyLogo = '';

    /**
     * Email fail response;
     */
    protected array $emailFailResponse = ['status' => false];

    /**
     * Initialize the email configuration and default values.
     */
    public function initializeEmail()
    {
        $this->companyLogo = Preference::where('field', 'company_logo')->first()->fileUrl();
        $this->emailFailResponse = ['status' => false, 'message' => __('Email can not be sent, please contact with admin.')];
    }

    /**
     * Set the email configuration based on stored settings.
     */
    public function setEmailConfig()
    {
        $companyName = preference('company_name');
        $result = EmailConfiguration::getAll()->first();
        $value = ['address' => isset($result->from_address) ? $result->from_address : '', 'name' => isset($result->from_name) ? $result->from_name : ''];

        if (! empty($companyName)) {
            $value = ['address' => isset($result->from_address) ? $result->from_address : '', 'name' => $companyName];
        }

        Config::set([
            'mail.driver'     => isset($result->protocol) ? $result->protocol : '',
            'mail.host'       => isset($result->smtp_host) ? $result->smtp_host : '',
            'mail.port'       => isset($result->smtp_port) ? $result->smtp_port : '',
            'mail.from'       => $value,
            'mail.encryption' => isset($result->encryption) ? $result->encryption : '',
            'mail.username'   => isset($result->smtp_username) ? $result->smtp_username : '',
            'mail.password'   => isset($result->smtp_password) ? $result->smtp_password : '',
        ]);
    }

    /**
     * Mail setting
     *
     * @param  string  $slug
     * @return object
     */
    private function getNotificationTemplate($slug)
    {
        $language = Language::where('short_name', preference('dflt_lang'))->first();

        if (! $language) {
            return $this->emailFailResponse;
        }

        $template = EmailTemplate::where('status', 'Active')
            ->where('slug', $slug)
            ->whereIn('language_id', [$language->id, 1])
            ->orderByDesc('language_id')
            ->first();

        return $template ?: $this->emailFailResponse;
    }

    /**
     * Get data for an email based on the template slug.
     *
     * @param  string  $slug
     * @return array|false
     */
    public function getEmailData($slug)
    {
        $email = $this->getNotificationTemplate($slug);

        if (! $email || ! $email->status) {
            return false;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);
        $content = $this->replaceEmailVariables($email->body);

        return compact('subject', 'content');
    }

    /**
     * Get data for an SMS based on the template slug.
     *
     * @param  string  $slug
     * @return array|string
     */
    public function getSmsData($slug)
    {
        $notification = $this->getNotificationTemplate($slug);

        if (! $notification || ! $notification->status) {
            return '';
        }

        // Replacing template variable
        return $this->replaceSmsVariables($notification->sms_body);
    }
}
