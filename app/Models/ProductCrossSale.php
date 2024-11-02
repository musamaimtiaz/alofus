<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 16-10-2021
 */

namespace App\Models;

class ProductCrossSale extends Model
{
    public $timestamps = false;

    protected $table = 'product_cross_sales';

    protected $fillable = ['product_id', 'cross_sale_product_id'];

    /**
     * Foreign key with product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Foreign key with product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function crossproduct()
    {
        return $this->belongsTo('App\Models\Product', 'cross_sale_product_id');
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
     * Update product Category
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateproductCross($data = [], $id = null)
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
     * @param  int  $id
     * @return array
     */
    public function remove($id = null, $crossId = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::where('product_id', $id)->where('cross_sale_product_id', $crossId);

        if ($record->exists()) {

            try {
                $record->delete();
                self::forgetCache();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Cross Sale')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }
}
