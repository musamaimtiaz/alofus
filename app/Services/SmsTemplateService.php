<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Language;

class SmsTemplateService
{
    /**
     * Update parent template
     */
    public function updateParentTemplate($body, int $id): bool
    {
        return EmailTemplate::where('id', $id)->update(['sms_body' => $body]);
    }

    /**
     * Update child template
     */
    public function updateChildTemplate(array $data, int $id): array
    {
        $languages = Language::getAll()->pluck('short_name', 'id')->toArray();

        $filteredData = array_filter($data, function ($value, $key) use ($languages) {
            return in_array($key, $languages) && ! empty($value['sms_body']);
        }, ARRAY_FILTER_USE_BOTH);

        if (empty($filteredData)) {
            return [];
        }

        $parent = EmailTemplate::find($id);

        $formatData = array_map(fn ($data) => [
            'parent_id' => $id,
            'slug' => $parent->slug,
            'sms_body' => $data['sms_body'],
            'language_id' => $data['language_id'],
            'status' => 'Active',
        ], $filteredData);

        EmailTemplate::upsert($formatData, ['parent_id', 'language_id']);

        return $formatData;
    }

    /**
     * Destructor method for the class.
     * Clears the cache for the SmsTemplate model when the object is destroyed.
     */
    public function __destruct()
    {
        EmailTemplate::forgetCache();
    }
}
