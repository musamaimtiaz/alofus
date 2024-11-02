<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-05-2021
 */

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use DB;

class LanguageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['list_menu']         = 'language';
        $data['languageList']      = Language::getAll();
        $data['languagesImgPath']  = 'public/uploads/flags';
        $data['languageShortName'] = getShortLanguageName(false, $data['languageList']);

        return view('admin.language.index', $data);
    }

    /**
     * @return array
     */
    public function translation(Request $request, $id)
    {
        $data['list_menu']  = 'language';
        $data['language']   = $language = Language::getAll()->where('id', $id)->first();
        $type               = isset($request->type) ? $request->type : null;

        if (empty($language)) {
            $response = $this->messageArray(__('The data you are trying to access is not found.'), 'fail');
            if ($type != 'company_setting') {
                $this->setSessionValue($response);

                return redirect()->back();
            }
        }

        try {
            updateLanguageFile($language->short_name);
            $data['jsonData'] = openJSONFile($language->short_name);
            $response         = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Language')]), 'success');
        } catch (\Exception $e) {
            $response = $this->messageArray(__('Something went wrong. Need writable permission of language directory.'), 'fail');
            if ($type != 'company_setting') {
                $this->setSessionValue($response);

                return redirect()->back();
            }
        }

        if ($type == 'company_setting') {
            return $response;
        } else {
            return view('admin.language.translation', $data);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $response             = [];
        $validator = Language::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (! is_writable(base_path('resources/lang/')) || ! is_writable(base_path('public/js/lang/'))) {
            $response = $this->messageArray(__('Need writable permission of language directory'), 'fail');
            $this->setSessionValue($response);

            return back();
        }
        $languages  = getShortLanguageName(true);
        if (! in_array(strtolower($request->language_name), array_keys($languages))) {
            $response = $this->messageArray(__('Invalid Language'), 'fail');
        } elseif (Language::where('short_name', $request->language_name)->exists()) {
            $response = $this->messageArray(__('That language is already taken.'), 'fail');
        } else {
            DB::beginTransaction();

            try {
                $request['name'] = $languages[strtolower($request->language_name)];
                $request['short_name'] = strtolower($request->language_name);
                $languageInsert = (new Language())->store($request->only('name', 'short_name', 'direction', 'default'));
                DB::commit();
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Language')]), 'success');
                $this->setSessionValue($response);

                return redirect()->route('language.translation', $languageInsert);

            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Edit Language
     */
    public function edit(Request $request)
    {
        if (! empty($request->id)) {
            $language = Language::getAll()->where('id', $request->id)->first();

            $return_lang['id'] = $language->id;
            $return_lang['language_name'] = $language->name;
            $return_lang['short_name'] = $language->short_name;
            $return_lang['flag'] = url('public/datta-able/fonts/flag/flags/4x3/' . getSVGFlag($language->short_name) . '.svg');
            $return_lang['status'] = $language->status;
            $return_lang['is_default'] = $language->is_default;
            $return_lang['direction'] = $language->direction;

            echo json_encode($return_lang);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        if ($request->edit_default == 'on' && $request->edit_status == 'Inactive') {
            return back()->withFail(__("Default language can't be inactive."));
        }
        $response  = [];
        $response  = $this->messageArray(__('Update Failed'), 'fail');
        $validator = Language::updateValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();

        try {
            $languageInfo = Language::getAll()->where('id', $request->language_id)->first();
            if (! empty($languageInfo)) {
                if (is_null($request->edit_default) && $languageInfo->is_default) {
                    return back()->withFail(__("Can't un-default default language, you can set default other languages."));
                }

                $request['direction'] = $request->edit_direction;
                $request['default']   = $request->edit_default;
                $request['status']    = $request->edit_status;

                if (isset($request['default']) && $request['default'] === 'on') {
                    $request['is_default'] = 1;
                    $request['status']     = 'Active';
                } else {
                    $request['is_default'] = 0;
                }
                if ((new Language())->updateLanguage($request->only('direction', 'status', 'is_default'), $request->language_id)) {
                    $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Language')]), 'success');
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $response = $this->messageArray($e->getMessage(), 'fail');
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $language = (new Language())->remove($id);
        $response = $this->messageArray($language['message'], $language['type']);
        $this->setSessionValue($response);

        return redirect()->back();
    }

    public function translationStore(Request $request)
    {
        if (! $request->key) {
            return back();
        }
        $response = [];
        if (! is_writable(base_path('resources/lang/')) || ! is_writable(base_path('public/js/lang/'))) {
            $response = $this->messageArray(__('Need writable permission of language directory'), 'fail');
            $this->setSessionValue($response);

            return back();
        }
        $language = Language::getAll()->where('id', $request->id)->first();
        $data = openJSONFile($language->short_name);
        foreach ($request->key as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $secondKey => $secondValue) {
                    $data[$key][$secondKey] = $request->key[$key][$secondKey];
                }
            } else {
                $data[$key] = $request->key[$key];
            }
        }
        saveJSONFile($language->short_name, $data);
        saveJSFile($language->short_name, $data);
        $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Language')]), 'success');
        $this->setSessionValue($response);

        return back();
    }
}
