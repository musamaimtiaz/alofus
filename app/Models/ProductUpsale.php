<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 16-10-2021
 */

namespace App\Models;

use App\Rules\CheckDuplicateProduct;
use Validator;

class ProductUpsale extends Model
{
    public $timestamps = false;

    protected $table = 'product_upsales';

    protected $fillable = ['product_id', 'upsale_product_id'];

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function upProduct()
    {
        return $this->belongsTo('App\Models\Product', 'upsale_product_id');
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [], $id = null)
    {
        $validator = Validator::make($data, [
            'related_product_id' => ['required', new CheckDuplicateProduct('up', $id)],
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
        if (parent::insert($data)) {
            self::forgetCache();
        }

        return false;
    }

    /**
     * Update Product Category
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateProductCross($data = [], $id = null)
    {
        $result = parent::where('product_id', $id);

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
     * @return array
     */
    public function remove($id = null, $upId = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::where('product_id', $id)->where('upsale_product_id', $upId);

        if ($record->exists()) {
            try {
                $record->delete();
                self::forgetCache();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Up Sale')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
