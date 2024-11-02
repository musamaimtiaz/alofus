<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-12-2021
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\AjaxSelectSearchResource;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMeta;
use App\Models\Tag;
use App\Models\Vendor;
use App\Services\Actions\Facades\VendorProductActionFacade as VendorProductAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Shipping\Entities\ShippingClass;
use Modules\Tax\Entities\TaxClass;

class ProductController extends Controller
{
    /**
     * Product List
     *
     * @param  ProductListDataTable  $dataTable
     * @return mixed
     */
    public function index(VendorProductDataTable $dataTable)
    {
        $vendorId = optional(auth()->user()->vendor())->vendor_id;
        if (is_null($vendorId)) {
            abort(403);
        }
        $data['productBrands'] = Product::join('brands', 'products.brand_id', 'brands.id')
            ->where('products.vendor_id', $vendorId)
            ->selectRaw('brands.name, brands.id')
            ->distinct()
            ->get();
        $data['productCategories'] = ProductCategory::join('categories', 'product_categories.category_id', 'categories.id')
            ->join('products', 'products.id', 'product_categories.product_id')
            ->where('products.vendor_id', $vendorId)
            ->selectRaw('categories.name, categories.id')
            ->distinct()
            ->get();
        $data['productTypes'] = Product::where('vendor_id', $vendorId)
            ->where('type', '<>', 'Variation') // Exclude 'variation' type
            ->pluck('type')
            ->unique()
            ->toArray();

        return $dataTable->render('vendor.product.index', $data);
    }

    /**
     * Create Product
     */
    public function createProduct(Request $request)
    {
        if ($this->ncpc()) {
            Session::flush();

            return view('errors.installer-error', ['message' => __('This product is facing license validation issue.<br>Please contact admin to fix the issue.')]);
        }

        do_action('before_vendor_create_product');

        if ($request->isMethod('get')) {

            $data['brands'] = Brand::getAll()->where('status', 'Active');
            $data['vendors'] = Vendor::getAll()->where('status', 'Active');

            $data['categories'] = $this->getCategories();

            $data['attributeList'] = Attribute::getAll()->unique('name');
            if (isActive('Shipping')) {
                $data['shippings'] = ShippingClass::getAll();
            }
            $data['taxes'] = TaxClass::getAll();
            $data['tags'] = [];

            return view('vendor.product.product', $data);
        }

        $vendor = auth()->user()->vendor();

        if (! $vendor || ! $vendor->vendor_id) {
            if ($request->wantsJson()) {
                return $this->notFoundResponse([], __('Vendor not found.'));
            } else {
                Session::flash('fail', __('Vendor not found.'));

                return redirect()->route('vendor.products');
            }
        }

        $product = Product::create([
            'name' => $request->name ?? 'Untitled product',
            'status' => 'Draft',
            'vendor_id' => $vendor->vendor_id,
        ]);

        (new ProductCategory())->store([
            'product_id' => $product->id,
            'category_id' => 1,
        ]);

        $request->request->add([
            'permalink' => $product->name,
            'code' => $product->code,
        ]);

        $response = VendorProductAction::execute('updatePermalink', $request);

        if ($request->action) {
            $response = VendorProductAction::execute($request->action, $request);
            if (! $response instanceof JsonResponse) {
                return $response;
            }
        }

        $data = json_decode($response->getContent(), true);

        $product = Product::where('id', $product->id)->first();

        $data['response']['url'] = route('vendor.product.edit-action', ['code' => $product->code]);

        $data['response']['permalink'] = $product->slug;

        $data['response']['previewUrl'] = route('site.productDetails', ['slug' => $product->slug]);

        $data['response']['name'] = $product->name;

        $response->setContent(json_encode($data));

        do_action('after_vendor_create_product', $product);

        return $response;
    }

    /**
     * Get Categories
     */
    private function getCategories()
    {
        if (! preference('access_system_category') && ! preference('vendor_category')) {
            return [];
        }

        $vendorId = auth()->user()->vendor()->vendor_id;

        return Category::when(preference('access_system_category'), function ($query) {
            return $query->whereNull('parent_id')->where('is_global', 1);
        })->orWhere(function ($query) use ($vendorId) {
            $query->when(preference('vendor_category'), function ($q) use ($vendorId) {
                $q->whereHas('vendorCategory', function ($innerQuery) use ($vendorId) {
                    $innerQuery->where('vendor_id', $vendorId)->whereHas('category', fn ($r) => $r->whereNull('parent_id'));
                });
            });
        })->when(preference('access_system_category') || preference('vendor_category'), function ($query) {
            return $query->where('status', 'Active');
        })->get();
    }

    /**
     * Edit Product Action
     */
    public function editProductAction(Request $request)
    {
        /**
         * Action names
         * 1. update_product_basic_info
         * 2. add_new_attribute
         * 3. get_attributes
         * 4. add_product_variation
         * 5. save-_product_variation
         * 6. get_attribute_form
         * 7. load_product_variations
         * 8. update_tags
         */
        if (! $request->action) {
            return $this->unprocessableResponse([], __('Action name required.'));
        }

        if ($request->action == 'update_basic_info_web') {
            if ($this->ncpc()) {
                Session::flush();

                return view('errors.installer-error', ['message' => __('This product is facing license validation issue.<br>Please contact admin to fix the issue.')]);
            }
        }

        return VendorProductAction::execute($request->action, $request);
    }

    public function edit(Request $request)
    {
        $product = VendorProductAction::editModeOn()->execute('getProductWithAttributeAndVariations', $request);

        if (! $product || $product instanceof JsonResponse) {
            Session::flash('fail', __('Product not found.'));

            return redirect()->route('vendor.products');
        }

        $vendor = auth()->user()->vendor();

        if (! $vendor || ! $vendor->vendor_id || $product->vendor_id != $vendor->vendor_id) {
            abort(403);
        }

        /**
         * Product edit code
         */
        $upsaleId = $product->getUpSaleIds();
        $crossSaleId = $product->getCrossSaleIds();
        $relatedProductIds = $product->getRelatedProductIds();
        $groupedId = $product->getGroupedProductIds();

        $relatedIds = array_unique(array_merge(
            $upsaleId,
            $crossSaleId,
            $relatedProductIds,
            $groupedId
        ));

        $productsCollection = Product::whereIn('id', $relatedIds)->get();

        $data['productUpsells'] = $productsCollection->whereIn('id', $upsaleId)->pluck('name', 'id')->toArray();

        $data['productCrossSells'] = $productsCollection->whereIn('id', $crossSaleId)->pluck('name', 'id')->toArray();

        $data['productRelatedProducts'] = $productsCollection->whereIn('id', $relatedProductIds)->pluck('name', 'id')->toArray();

        $data['groupedProducts'] = $productsCollection->whereIn('id', $groupedId)->pluck('name', 'id')->toArray();

        $data['attributeList'] = Attribute::getAll()->unique('name');

        $data['product'] = $product;

        // Old codes
        $data['vendors'] = Vendor::getAll()->where('status', 'Active');
        $data['taxes'] = TaxClass::getAll();

        $data['brands'] = Brand::getAll()->where('status', 'Active');
        if (isActive('Shipping')) {
            $data['shippings'] = ShippingClass::getAll();
        }

        //product tag
        $data['tags'] = $product->tags()->pluck('name', 'id')->toArray();

        // Category options
        $category = Category::getAll()->where('id', optional($product->productCategory)->category_id)->first();

        $parent[] = ! empty($category) ? $category->name : null;

        $parentId[] = ! empty($category) ? $category->id : null;

        while (1) {
            if (! empty($category->category)) {
                $category = $category->category;
                $parent[] = $category->name;
                $parentId[] = $category->id;
            } else {
                break;
            }
        }

        if (is_array($parent) && count($parent) > 0) {
            $parent = array_reverse($parent);
            $parentId = array_reverse($parentId);
            $parent = implode(' / ', $parent);
        }

        $data['parentCategory'] = $parent;
        $data['parentCategoryId'] = $parentId;
        $data['categories'] = $this->getCategories();

        return view('vendor.product.product', $data);
    }

    public function findProductAjaxQuery(Request $request)
    {
        if (! $vendor = $this->getVendor()) {
            return false;
        }

        $qString = $request->q;

        $productCode = $request->code;

        $result = Product::select('id', 'name')
            ->where('vendor_id', $vendor->vendor_id)
            ->where(
                function ($query) use ($qString) {
                    $query->whereBeginsWith('name', $qString)
                        ->orWhereLike('name', $qString)
                        ->orWhereBeginsWith('slug', $qString)
                        ->orWhereLike('slug', $qString);
                }
            )
            ->published()
            ->isAvailable()
            ->notVariation()
            ->limit(Product::getLimit());

        if ($productCode) {
            $result->where('code', '!=', $productCode);
        }

        $result = $result->get();

        return AjaxSelectSearchResource::collection($result);
    }

    public function findTagsAjaxQuery(Request $request)
    {
        $result = Tag::whereLike('name', $request->q)->limit(Product::getLimit())->get();

        return AjaxSelectSearchResource::collection($result);
    }

    public function productJson(Request $request)
    {
        $product = Product::where('code', $request->code)->first();

        return new ProductResource($product);
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::whereCode($request->code)->first();
        if (! $product) {
            Session::flash('fail', __('Something went wrong. Product not found.'));

            return back();
        }

        do_action('before_vendor_delete_product');

        $product->delete();

        do_action('after_vendor_delete_product');

        Session::flash('success', __('Product has been trashed.'));

        return redirect()->route('vendor.products');
    }

    public function forceDeleteProduct(Request $request)
    {
        $product = Product::withTrashed()->whereCode($request->code)->first();
        if (! $product) {
            Session::flash('fail', __('Something went wrong. Product not found.'));

            return back();
        }
        $productIds = Product::withTrashed()->where('parent_id', $product->id)->get()->pluck('id')->toArray();
        if (count($productIds) > 0) {
            Product::withTrashed()->whereIn('id', $productIds)->delete();
        }
        array_push($productIds, $product->id);
        $product->forceDelete();
        ProductMeta::whereIn('product_id', $productIds)->delete();
        Session::flash('success', __('Product deleted permanently.'));

        return redirect()->route('product.index');
    }

    private function getVendor()
    {
        $vendor = auth()->user()->vendor();

        return $vendor ?? null;
    }

    public function ncpc()
    {
		p_c_v();
		return false;
    }

    /**
     * find downloadable products
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findDownloadProducts(Request $request)
    {
        $products = Product::published()->isAvailable()->whereLike('name', $request->q)->where('vendor_id', auth()->user()->vendor()->vendor_id)->whereHas('metadata', function ($query) {
            $query->where('key', 'meta_downloadable')->where('value', 1);
        })->limit(10)->get();

        return AjaxSelectSearchResource::collection($products);
    }

    /**
     * duplicate product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(Request $request)
    {
        return (new \App\Http\Controllers\ProductController())->duplicate($request);
    }
}
