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

class AttributeGroup extends Model
{
    use ModelTrait;

    /**
     * Relation with attribute model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute()
    {
        return $this->hasMany('App\Models\Attribute', 'attribute_group_id', 'id');
    }

    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:50|unique:attribute_groups,name',
            'vendor' => 'nullable|exists:vendors,id',
            'summary' => 'nullable|max:191',
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name'   => ['required', 'min:3', 'max:50', 'unique:attribute_groups,name,' . $id],
            'vendor' => 'nullable|exists:vendors,id',
            'summary' => 'nullable|max:191',
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
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
     * Update
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateAttributeGroup($data = [], $id = null)
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
        $record = parent::find($id);
        if (! empty($record)) {
            try {
                $attributeRecord = Attribute::getAll()->where('attribute_group_id', $id)->first();
                if (! empty($attributeRecord)) {
                    $data['message'] = __('Can not be deleted. This :x has records!', ['x' => __('Attribute Group')]);
                } else {
                    $record->delete();
                    self::forgetCache(['attributes', 'attribute_values']);
                    $data['status'] = 'success';
                    $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Attribute Group')]);
                }
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
