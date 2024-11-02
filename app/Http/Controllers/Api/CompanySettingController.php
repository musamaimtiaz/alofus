<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Currency,
    File,
    Language,
    Preference,
};
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    /**
     * Company Setting
     *
     * @return array|array $response
     */
    public function index(Request $request)
    {
        $response           = [];
        $companySettings    = preference();
        if ($request->isMethod('get')) {
            $logo = url('public/uploads/companyPic/' . $companySettings['company_logo']);
            $icon = url('public/uploads/companyIcon/' . $companySettings['company_icon']);
            unset($companySettings['company_logo']);
            unset($companySettings['company_icon']);
            $companySettings['company_logo'] = $logo;
            $companySettings['company_icon'] = $icon;

            return $this->response(['data' => $companySettings]);
        } elseif ($request->isMethod('post')) {
            $validator = Preference::companySettingValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $post = $request->only('company_name', 'site_short_name', 'company_email', 'company_phone', 'company_street', 'company_city', 'company_state', 'company_zip_code', 'company_country', 'dflt_lang', 'dflt_currency_id');
            $post['company_gstin'] = $request->company_tax_id;
            $updatedLogo           = false;
            $updatedIcon           = false;
            $path                  = createDirectory('public/uploads/companyPic');

            if (! empty($request->file('company_logo'))) {
                $data['companyLogo'] = Preference::where('field', 'company_logo')->where('category', 'company')->first();
                $updatedLogo         = (new File())->store([$request->file('company_logo')], $path, 'Company', $data['companyLogo']->id, ['isUploaded' => false, 'isOriginalNameRequired' => true, 'size' => [80, 80]]);
            }

            if (! empty($updatedLogo)) {
                $lastUploadedLogo = File::find($updatedLogo[0]);
                if (! empty($lastUploadedLogo)) {
                    $updatedPreference = Preference::updateOrCreate(
                        ['category' => 'company', 'field' => 'company_logo'],
                        ['category' => 'company', 'field' => 'company_logo', 'value' => $lastUploadedLogo->file_name]
                    );
                    $changes           = $updatedPreference->getChanges();
                    if (! empty($changes) && $changes['value'] == $lastUploadedLogo->file_name) {
                        $result = (new File())->deleteFiles('Company', $updatedPreference->id, ['ids' => [$lastUploadedLogo->id], 'isExcept' => true], $path);
                    }
                }
            }

            if (! empty($request->file('company_icon'))) {
                $pathOfIcon          = createDirectory('public/uploads/companyIcon');
                $data['companyIcon'] = Preference::where('field', 'company_icon')->where('category', 'company')->first();
                $updatedIcon         = (new File())->store([$request->file('company_icon')], $pathOfIcon, 'Company', $data['companyIcon']->id, ['isUploaded' => false, 'isOriginalNameRequired' => true]);
            }
            if (! empty($updatedIcon)) {
                $lastUploadedIcon = File::find($updatedIcon[0]);
                if (! empty($lastUploadedIcon)) {
                    $updatedPreference = Preference::updateOrCreate(
                        ['category' => 'company', 'field' => 'company_icon'],
                        ['category' => 'company', 'field' => 'company_icon', 'value' => $lastUploadedIcon->file_name]
                    );
                    $changes           = $updatedPreference->getChanges();
                    if (! empty($changes) && $changes['value'] == $lastUploadedIcon->file_name) {
                        $result = (new File())->deleteFiles('Company', $updatedPreference->id, ['ids' => [$lastUploadedIcon->id], 'isExcept' => true], $path);
                    }
                }
            }
            unset($data);
            $i = 0;
            foreach ($post as $key => $value) {
                $data[$i]['category'] = 'company';
                $data[$i]['field']    = $key;
                $data[$i]['value']    = $value;
                $i++;
            }
            foreach ($data as $key => $value) {
                if ((new Preference())->storeOrUpdate($value)) {
                    $response = $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Preference')]));
                }
            }
            $prefer = preference();
            if (! empty($prefer)) {
                $curr = Currency::getDefault();
            }
            $language     = Language::getAll()->where('is_default', 1)->first();
            $languageData = [];
            if ($request->dflt_lang != $language->short_name) {
                // update language
                if (! is_writable(base_path('resources/lang/'))) {
                    $response = $this->response([], 204, __('Need writable permission of language directory'));
                }
                $updateLanguage = Language::getAll()->where('short_name', $request->dflt_lang)->first();
                if (empty($updateLanguage)) {
                    $response = $this->response([], 204, __('The data you are trying to access is not found.'));
                }
                updateLanguageFile($updateLanguage->short_name);

                $languageData['is_default'] = 1;
                (new Language())->updateLanguage($languageData, $updateLanguage->id);
            }
            unset($data);
        }

        return $response;
    }
}
