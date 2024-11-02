<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 29-10-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use App\Http\Resources\{
    ProductDetailResource,
    ProductResource
};
use App\Models\{
    Product
};
use Illuminate\Http\Request;
use Throwable;
use DB;

class ProductController extends Controller
{
    /**
     * Product List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $products = Product::select('products.*');
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $products->where('name', strtolower($name));
        }

        $productCode = isset($request->code) ? $request->code : null;
        if (! empty($productCode)) {
            $products->where('code', strtolower($productCode));
        }

        $sku = isset($request->sku) ? $request->sku : null;
        if (! empty($sku)) {
            $products->where('sku', strtolower($sku));
        }

        $vendor = isset($request->vendor) ? $request->vendor : null;
        if (! empty($vendor)) {
            $products->whereHas('vendor', function ($q) use ($vendor) {
                $q->where('name', strtolower($vendor));
            })->with('vendor');
        }

        $brand = isset($request->brand) ? $request->brand : null;
        if (! empty($brand)) {
            $products->whereHas('brand', function ($q) use ($brand) {
                $q->where('name', strtolower($brand));
            })->with('brand');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $products->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $products->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $products->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->where('code', 'LIKE', '%' . $keyword . '%')
                            ->where('sku', 'LIKE', '%' . $keyword . '%')
                            ->orwhereHas('vendor', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('vendor')
                            ->orwhereHas('brand', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('brand')
                            ->orwhere('status', $keyword);
                    });
                }
            }
        }

        return $this->response([
            'data' => ProductResource::collection($products->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($products->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Product Search
     *
     * @return array
     */
    public function search(Request $request, $type)
    {
        $id = $request->product_id;
        $response = $this->checkExistence($id, 'products');
        if ($response['status']) {
            if ($type == 'relate') {
                return $this->response([
                    'data' => (new Product())->search($request->search, $request->product_id, $type, 'api'),
                ]);
            }
            if ($type == 'cross') {
                return $this->response([
                    'data' => (new Product())->search($request->search, $request->product_id, $type, 'api'),
                ]);
            }
            if ($type == 'up') {
                return $this->response([
                    'data' => (new Product())->search($request->search, $request->product_id, $type, 'api'),
                ]);
            }
        }

        return $this->unprocessableResponse($response['message']);
    }

    /**
     * Detail Product
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'products');
        if ($response['status']) {
            return $this->response([
                'data' => new ProductDetailResource(Product::where('id', $id)->first()),
            ]);
        }

        return $this->unprocessableResponse($response['message']);
    }

    /**
     * Trash the specified Product from db.
     *
     * @return json $data
     */
    public function deleteProduct(Request $request)
    {
        $product  = Product::whereCode($request->code)->first();
        if (! $product) {
            return $this->notFoundResponse([], __('Something went wrong. Product not found.'));
        }
        $product->delete();

        return $this->successResponse([], 201, __('Product has been trashed.'));
    }

    /**
     * Trashed the specified Product from db.
     *
     * @return json $data
     */
    public function forceDeleteProduct(Request $request)
    {
        $product  = Product::withTrashed()->whereCode($request->code)->first();
        if (! $product) {
            return $this->notFoundResponse([], __('Something went wrong. Product not found.'));
        }
        $productIds = Product::withTrashed()->where('parent_id', $product->id)->get()->pluck('id')->toArray();
        if (count($productIds) > 0) {
            Product::withTrashed()->whereIn('id', $productIds)->delete();
        }
        array_push($productIds, $product->id);
        $product->forceDelete();
        ProductMeta::whereIn('product_id', $productIds)->delete();

        return $this->successResponse([], 201, __('Product deleted permanently.'));
    }

    /**
     * product update
     *
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {

            if (! $request->action) {
                return $this->unprocessableResponse([], __('Action name required.'));
            }

            $product = Product::where('id', $request->id)->first();

            if (! empty($product) && $product->type == 'Variation') {
                $exceptData = ['name', 'slug', 'available_from', 'available_to', 'category_id', 'brand_id', 'vendor_id', 'product_tags', 'description', 'summary', 'isFeatured', 'meta_enable_reviews', 'meta_estimated_delivery'];

                if (count(array_intersect($exceptData, array_keys($request->all()))) != 0) {
                    return $this->unprocessableResponse([], __('Invalid data'));
                }

            }

            $response = ProductAction::execute($request->action, $request);

            DB::commit();

            return $response;
        } catch (Throwable $e) {
            info($e);
            DB::rollback();

            return $this->response([], 500, $e->getMessage());
        }

        return $this->response([], 500, __('Something went wrong, please try again.'));
    }
}
