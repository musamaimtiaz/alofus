<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public static function store($response = [])
    {
        $data['category_id'] = $response['category_id'];
        $data['vendor_id'] = auth()->user()->vendor()->vendor_id;
        $data['shop_id'] = isset(auth()->user()->vendor()->vendor->shop) ? auth()->user()->vendor()->vendor->shop->id : null;

        return parent::insertGetId($data);
    }

    public static function destroy($categoryId)
    {
        $vendorId = auth()->user()->vendor()->vendor_id;
        $vendorCategory = parent::where('category_id', $categoryId)->where('vendor_id', $vendorId)->first();

        if (! empty($vendorCategory)) {
            $vendorCategory->delete();

            return true;
        }

        return false;
    }
}
