<?php

namespace App\Models;

class ProductCategory extends Model
{
    public $timestamps = false;

    protected $table = 'product_categories';

    protected $fillable = ['product_id', 'category_id'];

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
     * Foreign key with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        $lastProduct = parent::create($data);

        if (! empty($lastProduct)) {
            self::forgetCache();

            return $lastProduct->id;
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
    public function updateProductCategory($data = [], $id = null)
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
     * remove product category
     *
     * @return bool
     */
    public function remove($id = null)
    {
        $result = parent::where('product_id', $id);
        if ($result->exists()) {
            $result->delete();
            self::forgetCache();

            return true;
        }

        return false;
    }
}
