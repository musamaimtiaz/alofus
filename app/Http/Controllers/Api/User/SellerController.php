<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    ProductResource,
    ReviewResource,
    VendorResource
};
use App\Models\{
    Product,
    Vendor
};

class SellerController extends Controller
{
    /**
     * vendor products
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function index($alias = null)
    {
        $configs = $this->initialize([], null);
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)) {
            return $this->errorResponse([], 404, __('Invalid Request'));
        }

        $allProducts = Product::where('vendor_id', $data['shop']->vendor_id);
        $data['topSellerIds'] = Vendor::topSeller()->pluck('vendor_id')->toArray();
        $vendor = Vendor::with('reviews', 'shops')->where('id', $data['shop']->vendor_id)->first();
        $data['reviewCount'] = $vendor->reviews->where('status', 'Active')->count();
        $data['avg'] = $vendor->reviews->where('status', 'Active')->avg('rating');
        $data['positiveRating'] = Product::positiveRating($data['shop']->vendor_id);

        return $this->response([
            'data' => ProductResource::collection($allProducts->paginate($configs['rows_per_page'])),
            'vendorData' => (new VendorResource($vendor)),
            'otherData' => $data,
            'pagination' => $this->toArray($allProducts->paginate($configs['rows_per_page'])->appends(request()->all())),
        ]);
    }

    /**
     * vendor profile
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function vendorProfile($alias = null)
    {
        $configs = $this->initialize([], null);
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)) {
            return $this->errorResponse([], 404, __('Invalid Request'));
        }

        $vendor = Vendor::with('reviews', 'shops')->where('id', $data['shop']->vendor_id)->first();
        $data['reviewCount'] = $vendor->reviews->where('status', 'Active')->count();
        $data['avg'] = $vendor->reviews->where('status', 'Active')->avg('rating');
        $data['positiveRating'] =  Product::positiveRating($data['shop']->vendor_id);
        $data['shipment_on_time'] = $vendor->onTimeShipment();
        $data['seller_cancellation'] = $vendor->orderCancel();
        $reviews = $vendor->reviews()->where('reviews.status', 'Active')->orderBy('created_at', 'desc')->with('user');
        $data['progessBarRating'] = $vendor->reviews()->where('reviews.status', 'Active')->select(\DB::raw('count("rating") as total_rating, rating'))->groupBy('rating')->orderBy('rating', 'desc')->get()->toArray();
        $data['topSellerIds'] = Vendor::topSeller()->pluck('vendor_id')->toArray();

        return $this->response([
            'data' => ReviewResource::collection($reviews->paginate($configs['rows_per_page'])),
            'vendorData' => (new VendorResource($vendor)),
            'otherData' => $data,
            'pagination' => $this->toArray($reviews->paginate($configs['rows_per_page'])->appends(request()->all())),
        ]);
    }
}
