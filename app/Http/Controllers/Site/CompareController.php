<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use Illuminate\Http\Request;
use Compare;

class CompareController extends Controller
{
    /**
     * compare list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $compare = Compare::compareCollection();
        $productAttributeKey = [];
        $productAttributeValues = [];
        $ProductName = [];
        $productId = [];
        $summary = [];
        $rating = [];
        $availability = [];
        $price = [];
        $categoryName = [];
        $sku = [];
        $brand = [];
        $ratingCount = [];
        $product = null;
        foreach ($compare as $comp) {
            $productId['id'] = $comp;
            $request = (object) $productId;
            $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);
            if (! empty($product) && $product->status == 'Published') {
                $resourceData = (new ProductDetailResource($product))->toArray(null);
                $productId[] = $product->id;
                $sku[$comp] = $product->sku;
                $brand[$comp] = optional($product->brand)->name;
                $categoryName[$comp] = optional(optional($product->productCategory)->category)->name;
                $ProductName[$comp] = ['name' => $product->name, 'image' => $product->getFeaturedImage('medium'), 'code' => $product->code, 'slug' => $product->slug, 'type' => $resourceData['type'], 'stockStatus' => $product->isOutOfStock()];
                $summary[$comp] = $product->summary;
                $rating[$comp] = $product->review_average;
                $ratingCount[$comp] = $product->review_count;
                if (! empty($product->available_from) && availableFrom($product->available_from) || empty($product->available_from)) {
                    if (! empty($product->available_to) && availableTo($product->available_to) || empty($product->available_to)) {
                        $availability[$comp] = true;
                    } else {
                        $availability[$comp] = false;
                    }
                } else {
                    $availability[$comp] = false;
                }

                $offerFlag = $product->offerCheck();
                if ($product->isVariableProduct()) {
                    $filterVariation = $product->filterVariation();
                    $price[$comp] = formatNumber($filterVariation['min']) . ' - ' . formatNumber($filterVariation['max']);
                } elseif ($product->isGroupedProduct()) {
                    $groupProducts = $product->groupProducts();
                    $price[$comp] = formatNumber($groupProducts['min']) . ' - ' . formatNumber($groupProducts['max']);
                } else {
                    $price[$comp] = $offerFlag ? $product->priceWithTax(preference('display_price_in_shop'), 'sale') : $product->priceWithTax(preference('display_price_in_shop'), 'regular');
                }
                foreach ($resourceData['attributes'] as $key => $attribute) {
                    if ($attribute['visibility'] == 1) {
                        $productAttributeKey[$attribute['name']] = $attribute['value'];
                        $len = count($attribute['value']);
                        $i = 1;
                        $attData = '';
                        foreach ($attribute['value'] as $attValue) {
                            $attData .= isset($resourceData['attribute_values'][$attribute['key']]) ? $resourceData['attribute_values'][$attribute['key']]->where('id', $attValue)->first()->value : $attValue;
                            $attData .= $len > $i ? ',' : null;
                            $i++;
                        }
                        $productAttributeValues[$attribute['name']][$comp] = $attData;
                    }
                }
            } else {
                Compare::destroy($comp);
            }
        }
        $productAttributeValuesCheck = [];
        foreach ($productId as $id) {
            foreach (array_keys($productAttributeKey) as $key) {
                if (isset($productAttributeValues[$key][$id])) {
                    $productAttributeValuesCheck[$key][$id] = $productAttributeValues[$key][$id];
                } else {
                    $productAttributeValuesCheck[$key][$id] = null;
                }
            }
        }
        $data['compareProducts'] = [
            'productId' => $productId,
            'category' => $categoryName,
            'sku' => $sku,
            'brand' => $brand,
            'productName' => $ProductName,
            'summary' => $summary,
            'rating' => $rating,
            'ratingCount' => $ratingCount,
            'price' => $price,
            'availability' => $availability,
            'productAttributeValuesCheck' => $productAttributeValuesCheck,
        ];
        $data['compare'] = $compare;
        $data['product'] = $product;

        return view('site.compare.index', $data);
    }

    /**
     * compare store
     *
     * @return array
     */
    public function store(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = __('Failed to added in compare list! try again.');
        $product = Product::where('id', $request->product_id)->first();
        if (! empty($product)) {
            $add = Compare::add($request->product_id);
            if ($add) {
                $response = [
                    'status' => 1,
                    'message' => __('Product successfully added in compare list.'),
                    'totalProduct' => Compare::totalProduct(),
                ];
            } else {
                $response = [
                    'status' => 0,
                    'message' => __('Already added. Try another one.'),
                    'totalProduct' => Compare::totalProduct(),
                ];
            }
        }

        return $response;
    }

    /**
     * Compare Destroy
     *
     * @return array
     */
    public function destroy(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');
        if (Compare::destroy($request->product_id)) {
            $response = [
                'status' => 1,
                'message' => __('Deleted Successfully'),
                'totalProduct' => Compare::totalProduct(),
            ];
        }

        return $response;
    }
}
