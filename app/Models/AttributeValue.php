<?php

namespace App\Models;

class AttributeValue extends Model
{
    protected $guarded = [];

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
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Update Attribute Value
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateAttributeValue($data = [], $id = null)
    {
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::where('id', $id);
        if (($record->exists())) {
            try {
                $record->delete();
                self::forgetCache(['attributes', 'attribute_values']);
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Attribute')]) . __('Value');
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
