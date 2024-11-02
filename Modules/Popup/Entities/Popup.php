<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 08-03-2022
 */

namespace Modules\Popup\Entities;

use App\Models\Model;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Support\Facades\Validator;
use Modules\MediaManager\Http\Models\ObjectFile;
use App\Rules\{
    DateCompare,
    CheckValidDate
};

class Popup extends Model
{
    use hasFiles;
    use ModelTrait;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $data['start_date'] = isset($data['start_date']) ? $data['start_date'] : null;
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:120|unique:popups,name',
            'type' => 'required|in:Information,Another page link,Send mail,Subscribed',
            'position' => 'required|in:Center,Top Left,Top Right,Bottom Left,Bottom Right',
            'background' => 'required|in:Image,Color',
            'show_time' => 'required|numeric',
            'width' => 'required|numeric|min:100|max:800',
            'height' => 'required|numeric|min:50|max:600',
            'page_link' => 'required|in:Home,Product Details,Cart,Checkout,Confirm Order',
            'start_date' => ['required', new CheckValidDate()],
            'end_date' => ['required', new CheckValidDate(), new DateCompare($data['start_date'])],
            'login_enabled' => 'required|in:0,1',
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $data['start_date'] = isset($data['start_date']) ? $data['start_date'] : null;
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:120|unique:popups,name,' . $id,
            'position' => 'required|in:Center,Top Left,Top Right,Bottom Left,Bottom Right',
            'background' => 'required|in:Image,Color',
            'show_time' => 'required|numeric',
            'width' => 'required|numeric|min:100|max:800',
            'height' => 'required|numeric|min:50|max:600',
            'page_link' => 'required|in:Home,Product Details,Cart,Checkout,Confirm Order',
            'start_date' => ['required', new CheckValidDate()],
            'end_date' => ['required', new CheckValidDate(), new DateCompare($data['start_date'])],
            'login_enabled' => 'required|in:0,1',
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Store Popup
     *
     * @param  array  $data
     * @return array $response
     */
    public function store($data = [])
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        if (parent::insert($data)) {
            $fileIds = [];
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
            }
            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
            self::forgetCache();
            $response = ['status' => 'success', 'message' => __('The :? has been successfully saved.', ['?' => __('Popup')])];
        }

        return $response;
    }

    /**
     * Update Popup
     *
     * @param  array  $request
     * @param  int  $id
     * @return array
     */
    public function updateData($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Popup does not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($request);
            $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
            self::forgetCache();
            $data = ['status' => 'success', 'message' => __('The :? has been successfully saved.', ['?' => __('Popup')])];
        }

        return $data;
    }

    /**
     * Delete Popup
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        if (Popup::getAll()->where('id', $id)->count() == 0) {
            return ['status' => 'fail', 'message' => __('Popup does not found.')];
        }
        if (Popup::where('id', $id)->delete()) {
            self::forgetCache();

            return ['status' => 'success', 'message' => __('The :? has been successfully deleted.', ['?' => __('Popup')])];
        }

        return ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
    }
}
