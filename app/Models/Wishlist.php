<?php

namespace App\Models;

class Wishlist extends Model
{
    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function store($data)
    {
        $data['browser_agent'] = browserAgent();
        $data['ip_address'] = getIpAddress();
        $response = ['status' => 0, 'message' => __('Something went wrong, please try again.')];
        if ($id = parent::insertGetId(array_intersect_key($data, array_flip((array) ['product_id', 'user_id', 'browser_agent', 'ip_address'])))) {
            $response = ['status' => 1, 'id' => $id, 'message' => __('Product added to your wishlist.')];
        }

        return $response;
    }

    public function checkExistence($userId, $productId)
    {
        $check = parent::where('user_id', $userId)->where('product_id', $productId)->first();
        if (! empty($check)) {
            return true;
        }

        return false;

    }
}
