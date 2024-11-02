<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 07-09-2021
 */

namespace App\Models;

use Cache;
use Validator;
use Auth;

class Language extends Model
{
    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *store validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'language_name'    => 'required',
            'status'        => 'required|in:Active,Inactive',
            'direction'     => 'required|in:ltr,rtl',
        ]);

        return $validator;
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'edit_direction'    => 'required|in:ltr,rtl',
            'edit_status'       => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $request
     * @return bool
     */
    public function store($data = [])
    {
        if (isset($data['default']) && $data['default'] === 'on') {
            $languageUpdate   = parent::where('is_default', 1)->first();
            $languageUpdate->is_default = 0;
            $languageUpdate->save();
            parent::where('is_default', 1)->update(['is_default' => 0]);
            Preference::where('category', 'company')
                ->where('field', 'dflt_lang')
                ->update(['value' => $data['short_name']]);
            self::forgetCache('preferences');
            $data['is_default'] = 1;
            $data['status']     = 'Active';
        } else {
            $data['is_default'] = 0;
        }
        unset($data['default']);
        $data['direction']  = $data['direction'] == 'rtl' ? 'rtl' : 'ltr';
        $language = parent::insertGetId($data);
        if (! empty($language)) {
            self::forgetCache();

            return $language;
        }

        return false;
    }

    /**
     * @param  array  $data
     * @return bool
     */
    public function updateLanguage($data, $id)
    {
        $updateLanguage = parent::where('id', $id);
        if ($updateLanguage->exists()) {
            $language = parent::where('is_default', 1)->first();
            $language->is_default = 0;
            $language->save();
            $updateLanguage->update($data);
            $updateLanguageInfo = Language::where('id', $id)->first();
            if (empty($updateLanguageInfo->is_default) && empty(Language::where('is_default', 1)->count())) {
                Language::where('short_name', 'en')->update(['is_default' => 1]);
                $updateLanguageInfo->short_name = 'en';
            }
            Preference::where('category', 'company')
                ->where('field', 'dflt_lang')
                ->update(['value' => $updateLanguageInfo->short_name]);
            self::forgetCache(['languages', 'preferences']);
            Cache::forget(config('cache.prefix') . '-admin-language-' . Auth::user()->id);

            return true;
        }

        return false;
    }

    public function remove($id)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $language = Language::getAll()->where('id', $id)->first();
        if (! empty($language)) {
            $isDefaultLanguage = Preference::where([
                'category' => 'company',
                'field' => 'dflt_lang',
                'value' => $language->short_name,
            ])->first();
            if ($language->short_name == 'en') {
                $data = ['type' => 'fail', 'message' => __(':x language can not be deleted.', ['x' => __('English')])];
            } elseif ($isDefaultLanguage) {
                $data = ['type' => 'fail', 'message' => __(':x language can not be deleted.', ['x' => __('Default')])];
            } else {
                parent::where(['id' => $id])->delete();
                $language->delete();
                self::forgetCache();
                $data = ['type'    => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Language')])];
            }
        }

        return $data;
    }
}
