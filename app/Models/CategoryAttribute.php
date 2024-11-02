<?php

namespace App\Models;

use App\Traits\ModelTrait;

class CategoryAttribute extends Model
{
    use ModelTrait;

    /**
     * Foreign key with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * Foreign key with Attribute model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute', 'attribute_id');
    }

    /**
     * store attribute category
     *
     * @return false
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);
        if (! empty($id)) {
            self::forgetCache();

            return $id;
        }

        return false;
    }

    /**
     * Delete
     *
     * @return array
     */
    public function remove($attId = null, $categoryId = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::where('attribute_id', $attId)->where('category_id', $categoryId);

        if ($record->exists()) {

            try {
                $record->delete();
                self::forgetCache();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Attribute')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
