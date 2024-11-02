<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 25-07-2021
 */

namespace App\Models;

use App\Traits\ModelTrait;
use Validator;

class Attribute extends Model
{
    use ModelTrait;

    protected $guarded = null;

    /**
     * Foreign key with AttributeGroup model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeGroup()
    {
        return $this->belongsTo("App\Models\AttributeGroup", 'attribute_group_id');
    }

    /**
     * Relation with AttributeValue model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeValue()
    {
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id', 'id')->orderBy('order_by', 'ASC');
    }

    /**
     * Relation with CategoryAttribute model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryAttribute()
    {
        return $this->hasMany('App\Models\CategoryAttribute', 'attribute_id', 'id');
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $rules = [
            'name' => 'required|min:3|max:100',
            'status' => 'required|in:Active,Inactive',
            'is_filterable' => 'required|in:1,0',
            'is_required' => 'required|in:1,0',
            'values' => 'required|array',
        ];

        $message = [
            'values' => __('At least 1 attribute value is required.'),
        ];

        return Validator::make($data, $rules, $message);
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data = [])
    {
        $rules = [
            'name' => 'required|min:3|max:100',
            'status' => 'required|in:Active,Inactive',
            'is_filterable' => 'required|in:1,0',
            'is_required' => 'required|in:1,0',
            'values' => 'required|array',
        ];

        $message = [
            'values' => __('At least 1 attribute value is required.'),
        ];

        return Validator::make($data, $rules, $message);
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
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
     * Update Attribute
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateAttribute($data = [], $id = null)
    {
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            if ($data['type'] == 'field') {
                AttributeValue::where('attribute_id', $id)->delete();
                self::forgetCache('attribute_values');
            }
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
        $record = parent::find($id);
        if (! empty($record)) {
            try {
                $record->delete();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Attribute')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
