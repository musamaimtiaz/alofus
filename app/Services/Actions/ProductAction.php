<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-06-2022
 */

namespace App\Services\Actions;

use App\Enums\ProductType;
use App\Models\{Attribute, AttributeValue, Product, ProductCategory, ProductCrossSale, ProductRelate, ProductTag, ProductMeta, ProductUpsale, Tag};
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Shipping\Entities\ShippingClass;
use Modules\Tax\Entities\TaxClass;

class ProductAction
{
    use ApiResponse;

    protected $request;

    protected $method;

    protected $product;

    protected $view;

    protected $onlyPurchasableVariation = true;

    protected $editMode = false;

    protected $routeAndViews = [
        'site.productDetails' => 'site.productDetails',
        'product.edit' => 'product.edit',
        'admin.products.pieces.custom-single-attribute' => 'admin.products.pieces.custom-single-attribute',
        'admin.products.pieces.single-attribute' => 'admin.products.pieces.single-attribute',
        'admin.products.pieces.variations' => 'admin.products.pieces.variations',
        'admin.products.pieces.all-variation-attribute' => 'admin.products.pieces.all-variation-attribute',
        'admin.products.pieces.custom-single-variation' => 'admin.products.pieces.custom-single-variation',
    ];

    protected $shouldSkipFields = [];

    /**
     * Executes the defined action
     *
     * @return mixed
     */
    public function execute($action, $request)
    {
        $method = lcfirst(str_replace('_', '', ucwords($action, '_')));

        $this->method = $method;

        if (! method_exists($this, $method)) {
            return $this->unprocessableResponse([], __('Action not found.'));
        }
        if (isset($request->code)) {
            $this->product = Product::where('code', $request->code)->first();
        } elseif (isset($request->slug)) {
            $this->product = Product::where('slug', $request->slug)->first();
        } elseif (isset($request->id)) {
            $this->product = Product::where('id', $request->id)->first();
        } else {
            if ($method == 'getProductWithAttributeAndVariations') {
                return null;
            }

            return $this->unprocessableResponse([], __('Product identifier not found.'));
        }

        if (! $this->product) {
            if ($method == 'getProductWithAttributeAndVariations') {
                return null;
            }

            return $this->unprocessableResponse([], __('Product not found.'));
        }

        $this->request = $request;

        $this->updateRouteAndViews();

        return $this->{$method}();
    }

    /**
     * ==============================================
     * =============== Action Methods ===============
     * ==============================================
     */

    /**
     * Update product permalink
     */
    protected function updatePermalink()
    {
        if (! $this->request->permalink) {
            return $this->unprocessableResponse([], 'Permalink is missing');
        }

        $pl = $this->generateSlug($this->request->permalink, $this->product);

        $this->product->slug = $pl;

        $this->product->save();

        return $this->successResponse(['permalink' => $pl, 'previewUrl' => route($this->getRouteOrView('site.productDetails'), ['slug' => $pl])], 200, __('Permalink Updated.'));
    }

    protected function updateBasicInfo()
    {
        if ($this->request->data) {
            parse_str($this->request->data, $data);
            $this->saveBasicInfo($data, $this->product);
        } else {
            $this->saveBasicInfo($this->request->all(), $this->product);
        }

        return $this->successResponse([], 200, __('Product updated successfully.'));
    }

    protected function updateBasicInfoWeb()
    {
        if ($this->request->data) {
            parse_str($this->request->data, $data);
            $this->saveBasicInfo($data, $this->product);
        } else {
            $this->saveBasicInfo($this->request->all(), $this->product);
        }
        Session::flash('success', __('Product Updated.'));

        return redirect()->route($this->getRouteOrView('product.edit'), ['code' => $this->product->code]);
    }

    protected function addNewAttribute()
    {
        $attributes = [];

        parse_str($this->request->data, $data);

        $totalAttributes = max(array_keys($data['attribute_names']));

        $productAttributes = [];

        for ($i = 0; $i <= $totalAttributes; $i++) {
            if (isset($data['attribute_names'][$i]) && isset($data['attribute_values'][$i])) {
                $name = trim($data['attribute_names'][$i]);
                $position = isset($data['attribute_position'][$i]) ? trim($data['attribute_position'][$i]) : $i;
                $key = strtolower(str_replace(' ', '', $name));

                if (isset($attributes[$key])) {
                    continue;
                }

                if (! is_array($data['attribute_values'][$i])) {
                    $value = array_values(array_filter(array_map('trim', explode('|', $data['attribute_values'][$i]))));
                } else {
                    $value = $data['attribute_values'][$i];
                    $productAttributes[$key] = AttributeValue::getAll()->whereIn('id', $value);
                }

                $visibility = isset($data['attribute_visibilities'][$i]) ? trim($data['attribute_visibilities'][$i]) : 0;

                $variation = isset($data['attribute_variations'][$i]) ? trim($data['attribute_variations'][$i]) : 0;

                $attributeId = isset($data['attribute_attr_id'][$i]) ? trim($data['attribute_attr_id'][$i]) : '';

                $attributes[$key] = [
                    'name' => $name,
                    'position' => $position,
                    'key' => $key,
                    'value' => $value,
                    'visibility' => $visibility,
                    'variation' => $variation,
                    'attribute_id' => $attributeId,
                ];
            }
        }

        $newAttributesArray = [];

        usort($attributes, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        foreach ($attributes as $value) {
            $newAttributesArray[$value['key']] = $value;
        }

        ProductMeta::updateOrCreate([
            'product_id' => $this->product->id,
            'key' => 'attributes',
        ], ['value' => $newAttributesArray]);

        foreach ($attributes as $key => $attri) {
            if ($attri['attribute_id']) {
                $valueOptions = AttributeValue::getAll()->whereIn('id', $attri['value']);
                $options = [];
                foreach ($valueOptions as $value) {
                    $options[$value->id] = $value->value;
                }
                $attributes[$key]['value'] = $options;
            }
        }

        $productVariations = $this->product->getVariations();

        foreach ($productVariations as $productVariation) {
            $varAttr = ProductMeta::where('product_id', $productVariation->id)->get();
            $productVariation['attributes'] = $varAttr;
        }

        return $this->successResponse([], 200, __('Attribute updated.'));
    }

    protected function getAttributes()
    {
        $attributes = ProductMeta::where('product_id', $this->product->id)->where('key', 'attributes')->first();

        if ($attributes) {
            return $attributes->value;
        }

        return [];
    }

    /**
     * Create new product variation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function addProductVariation()
    {

        if (! isset($this->request->type)) {
            return $this->unprocessableResponse([], __('Please select variation type.'));
        }

        if (! isset($this->request->index)) {
            $this->request->request->add(['index', $this->product->getVariations()->count()]);
        }

        // Get the parent attribute list
        $parentAttributes = $this->product->getVariationAttributes();

        $variations = $this->product->getVariations();

        $this->processNonCustomAttributes($parentAttributes);

        // Generate variations
        if ($this->request->type == 'all') {
            $data = $this->createAllVariation($parentAttributes, $variations);
        } else {
            $data = $this->createSingleVariation($parentAttributes, $variations);
        }

        if ($data instanceof JsonResponse) {
            return $data;
        }

        return $this->successResponse([
            'html' => view($this->view, $data)->render(),
        ]);
    }

    /**
     * Update product variation data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveProductVariation()
    {
        $variationData = [];
        if ($this->request->data) {
            parse_str($this->request->data, $variationData);
        }
        if (! isset($variationData['variable_post_id'])) {
            return $this->unprocessableResponse([], __('Variation not found.'));
        }

        $variations = $this->product->getVariations();

        if (! count($variations)) {
            return $this->unprocessableResponse([], __('Variation not found.'));
        }

        $parentAttributes = $this->product->getVariationAttributes();

        $attributeValues = [];

        $attributeIds = [];

        foreach ($parentAttributes as $attribute) {
            if ($attribute['attribute_id'] > 0) {
                $attributeIds = array_merge($attributeIds, $attribute['value']);
            }
        }

        $attributeValues = AttributeValue::whereIn('id', $attributeIds)->get()->pluck('value', 'id')->toArray();

        unset($attributeIds);

        usort($parentAttributes, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $arrayKeys = array_keys($variationData['variable_post_id']);

        $storableData = [];

        $order = 0;

        $title =  $this->product->name;

        foreach ($arrayKeys as $i) {

            if (isset($variationData['variable_order'][$i]) && $variationData['variable_order'][$i] > $order) {
                $order = $variationData['variable_order'][$i] + 1;
            }
            $product = $variations->where('id', $variationData['variable_post_id'][$i])->first();

            $product->regular_price = $variationData['variable_regular_price'][$i] == '' ? null : $variationData['variable_regular_price'][$i];
            $product->sale_price = $variationData['variable_sale_price'][$i] == '' ? null : $variationData['variable_sale_price'][$i];
            $product->sku = $variationData['variable_sku'][$i];
            $product->manage_stocks = $variationData['variable_manage_stocks'][$i] != '' ? $variationData['variable_manage_stocks'][$i] : 0;
            $product->total_stocks = $variationData['variable_total_stocks'][$i] != '' ? $variationData['variable_total_stocks'][$i] : 0;
            $product->description = isset($variationData['variable_description'][$i]) ? $variationData['variable_description'][$i] : '';
            $product->status = $variationData['variable_status'][$i];
            $product->sale_from = $this->processDate($variationData['variable_sale_from'][$i]);
            $product->sale_to = $this->processDate($variationData['variable_sale_to'][$i]);
            $variationName = $title;

            foreach ($parentAttributes as $attr) {
                if ($attr['attribute_id'] > 0 && $variationData['attribute_' . $attr['key']][$i] != '0') {
                    $attributeValue = $attributeValues[$variationData['attribute_' . $attr['key']][$i]];
                } elseif ($variationData['attribute_' . $attr['key']][$i] != '0') {
                    $attributeValue = $variationData['attribute_' . $attr['key']][$i];
                }
                $variationName = $variationName . ', ' . $attributeValue;
                $storableData[] = [
                    'product_id' => $product->id,
                    'key' => 'attribute_' . $attr['key'],
                    'value' => $variationData['attribute_' . $attr['key']][$i] != '0' ? $variationData['attribute_' . $attr['key']][$i] : '',
                    'type' => gettype($variationData['attribute_' . $attr['key']][$i] != '0' ? $variationData['attribute_' . $attr['key']][$i] : ''),
                ];
            }

            if (! isset($variationData['meta_image'][$i])) {
                $variationData['meta_image'][$i] = '';
            }

            if (isset($variationData['has_downloadables']) && isset($variationData['has_downloadables'][$i]) && $variationData['has_downloadables'][$i] == '1') {
                if (! isset($variationData['meta_downloadable_files']) || ! isset($variationData['meta_downloadable_files'][$i])) {
                    $variationData['meta_downloadable_files'][$i] = [];
                } else {
                    $files = [];
                    foreach ($variationData['meta_downloadable_files'][$i] as $val) {
                        if (is_array($val) && $this->checkDownloadableInputs($val)) {
                            $files[] = $val;
                        }
                    }
                    $variationData['meta_downloadable_files'][$i] = $files;
                }
            }

            foreach ($variationData as $key => $value) {
                if (str_starts_with($key, 'meta_') && isset($value[$i])) {
                    $storableData[] = [
                        'product_id' => $product->id,
                        'key' => $key,
                        'value' => $this->formatVal($value[$i]),
                        'type' => gettype($value[$i]),
                    ];
                }
            }

            $storableData[] = [
                'product_id' => $product->id,
                'key' => 'variable_order',
                'value' => isset($variationData['variable_order'][$i]) ? $variationData['variable_order'][$i] : $order++,
                'type' => null,
            ];

            $product->name = $variationName;

            $product->save();
        }

        unset($attributeValues);

        if (isset($variationData['default_attributes'])) {
            $storableData[] = [
                'product_id' => $this->product->id,
                'key' => 'default_attributes',
                'value' => $this->formatVal($variationData['default_attributes']),
                'type' => gettype($variationData['default_attributes']),
            ];
        }

        $meta = ProductMeta::upsert($storableData, ['product_id', 'key'], ['value', 'key']);

        $this->product->type = ProductType::$Variable;

        $this->product->save();

        return $this->successResponse([], 200, __('Variation updated successfully.'));
    }

    protected function saveProductB2B()
    {
        $b2bData = [];
        if ($this->request->data) {
            parse_str($this->request->data, $b2bData);
        }

        foreach ($b2bData as $key => $b2b) {
            $storableData[] = [
                'product_id' => $this->product->id,
                'type' => gettype($b2bData[$key]),
                'key' => $key,
                'value' => $this->formatVal($b2b),
            ];
        }

        ProductMeta::upsert($storableData, ['product_id', 'key'], ['value', 'key']);

        return $this->successResponse([], 200, __('B2B updated successfully.'));
    }

    /**
     * Get attribute form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getAttributeForm()
    {
        $index = $this->request->index;
        if (! $this->request->attr_id && $this->request->attr_id === '0') {
            return $this->okResponse([
                'form' => view(
                    $this->getRouteOrView('admin.products.pieces.custom-single-attribute'),
                    ['idx' => $index, 'product' => $this->product]
                )->render(),
            ], __('Please save to store the attribute.'));
        }

        if (! $this->request->attr_id) {
            return $this->unprocessableResponse([], __('Invalid attribute provided.'));
        }

        $attr = Attribute::with('attributeValue')->firstWhere('id', $this->request->attr_id);

        if (! $attr) {
            return $this->ok([
                'form' => view(
                    $this->getRouteOrView('admin.products.pieces.custom-single-attribute'),
                    [
                        'idx' => $index,
                        'product' => $this->product,
                    ]
                )->render(),
            ], __('Please save to store the attribute.'));
        }

        return $this->okResponse([
            'form' => view(
                $this->getRouteOrView('admin.products.pieces.single-attribute'),
                [
                    'attribute' => $attr,
                    'idx' => $index,
                    'product' => $this->product,
                ]
            )->render(),
        ], __('Please save to store the attribute.'));
    }

    /**
     * Get variation information form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loadProductVariations()
    {
        $this->onlyPurchasableVariation = false;

        $product = $this->getProductWithAttributeAndVariations(true);

        if (isActive('Shipping')) {
            $shippings = ShippingClass::getAll();
        }

        if (isActive('Tax')) {
            $taxes = TaxClass::getAll();
        }

        return $this->okResponse([
            'html' => view($this->getRouteOrView('admin.products.pieces.variations'), ['product' => $product, 'shippings' => $shippings, 'taxes' => $taxes])->render(),
        ], __('Variations loaded.'));
    }

    /**
     * Get Product details with variations and attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getProductWithAttributeAndVariations()
    {
        $this->product = Product::with(['metadata', 'variations' => function ($q) {
            $q->with('metadata');
        }])->whereId($this->product->id)->first();

        $variations = $this->onlyPurchasableVariation ? $this->product->getPurchaseableVariation() : $this->product->getVariations();

        $parentAttributeOptions = $this->product->attributes;

        if (is_array($parentAttributeOptions) && count($parentAttributeOptions) > 0) {
            $this->product->attributes = $parentAttributeOptions;
            $this->product->attributeValues = $this->getAttributeValues($parentAttributeOptions);
            $attributes = array_keys($parentAttributeOptions);

            foreach ($variations as $variation) {
                $variation->getAttributeMeta($attributes);
            }
        }

        $this->product['variations'] = $variations;

        return $this->product;
    }

    /**
     * Delete product attribute
     *
     * @return JsonResponse
     */
    protected function deleteAttribute()
    {
        if (! $this->request->attr_name) {
            return $this->unprocessableResponse([], __('Missing Attribute'));
        }

        $attributes = ProductMeta::where('product_id', $this->product->id)->where('key', 'attributes')->first();

        if ($attributes) {
            $attributes = $attributes->value;
        }

        $name = false;

        foreach ($attributes as $key => $attribute) {
            if ($this->request->attr_name == $attribute['name']) {
                $name = $key;

                break;
            }
        }

        unset($attributes[$name]);

        ProductMeta::where('product_id', $this->product->id)->where('key', 'attributes')->update(['value' => json_encode($attributes)]);

        ProductMeta::where('key', 'attribute_' . $name)->delete();

        if (count($attributes) < 1) {
            $ids = $this->product->getVariations()->pluck('id');
            ProductMeta::whereIn('product_id', $ids)->delete();
            Product::whereIn('id', $ids)->delete();
        }

        ProductMeta::forgetCache();

        return $this->successResponse([], 200, __('Attribute deleted.'));
    }

    /**
     * Delete Product Variation
     *
     * @return JsonResponse
     */
    protected function deleteVariation()
    {
        if (! $this->request->vi) {
            return $this->unprocessableResponse([], __('Invalid variation information.'));
        }

        $product = $this->product->getVariations()->where('id', $this->request->vi)->first();

        if (! $product) {
            return $this->unprocessableResponse([], __('Invalid variation information.'));
        }

        if (! $product->isEligibleForDelete()) {
            return $this->forbiddenResponse([], __('This variation cannot be deleted.'));
        }

        DB::beginTransaction();

        try {
            ProductMeta::where('product_id', $this->request->vi)->delete();
            ProductMeta::forgetCache();
            $product->delete();
            DB::commit();

            return $this->okResponse([], __('Variation deleted.'));
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->errorResponse([], 501, __('Failed to delete the variation.'));
    }

    protected function updateTags()
    {
        $request = $this->request->toArray();
        $tags = $request['product_tags'];
        if (! $tags || ! is_array($tags)) {
            return $this->errorResponse([], 422, __('Invalid tags input'));
        }
        $this->saveTags($request);

        return $this->successResponse([], 200, __('Tags updated.'));
    }

    protected function addNewAttributeValue()
    {
        $request = $this->request->toArray();

        if (! isset($request['attribute_id'])) {
            return $this->unprocessableResponse([], __('Invalid attribute.'));
        }

        if (! isset($request['value'])) {
            return $this->unprocessableResponse([], __('Empty value is not acceptable.'));
        }

        $attribute = AttributeValue::create([
            'value' => $request['value'],
            'attribute_id' => $request['attribute_id'],
            'order_by' => 1,
        ]);

        return $this->createdResponse(['attribute' => $attribute], __('Attribute value added'));
    }

    /**
     * ================================================================
     * ==================== Non Action Methods ========================
     * ================================================================
     */

    /**
     * Process non custom attributes from only ID to ID => Name pair
     *
     * @param  array  $parentAttributes
     * @return array
     */
    protected function processNonCustomAttributes($parentAttributes)
    {
        $attributeArray = [];
        // Fill the attributes value with predefined attributes value if the attribute is not custom attribute
        foreach ($parentAttributes as $key => $attribute) {
            $attributeArray[$key] = $attribute;
            if ($attribute['attribute_id']) {
                $valueOptions = AttributeValue::getAll()->whereIn('id', $attribute['value']);
                $options = [];
                foreach ($valueOptions as $value) {
                    $options[$value->id] = $value->value;
                }
                $attributeArray[$key]['value'] = $options;
            }
        }

        $this->product['attributes'] = $attributeArray;

        return $attributeArray;
    }

    /**
     * Create empty variation
     *
     * @return Product
     */
    protected function createEmptyVariationProduct()
    {
        return Product::create([
            'name' => $this->product->name,
            'parent_id' => $this->product->id,
            'type' => ProductType::$Variation,
        ]);
    }

    /**
     * Generates all possible unique variations of given attributes
     *
     * @param  int  $totalAttributes
     * @param  array  $parentAttributes
     * @return array
     */
    protected function getPossibleVariationAttributes($totalAttributes, $parentAttributes)
    {
        $attributeArray = [];
        if ($totalAttributes >= 1) {
            array_map(function ($att) use (&$attributeArray) {
                $attributeArray[] = $att['value'];
            }, $parentAttributes);
            $result = $attributeArray[0];
            for ($i = 1; $i < $totalAttributes; $i++) {
                $result = $this->mergeArray($result, array_values($attributeArray[$i]));
            }
            if ($totalAttributes == 1) {
                $result = [];
                array_map(function ($item) use (&$result) {
                    $result[] = [$item];
                }, $attributeArray[0]);
            }
            $attributeArray = $result;
        }

        return $attributeArray;
    }

    /**
     * Create all possible variations from product attributes
     *
     * @param  array  $parentAttributes
     * @param  Product  $variations
     * @return array
     */
    protected function createAllVariation($parentAttributes, $variations)
    {

        $totalAttributes = count($parentAttributes);

        // Get all possible of variation options
        $attributeArray = $this->getPossibleVariationAttributes($totalAttributes, $parentAttributes);

        $rejections = [];

        $parentAttributeNames = array_keys($parentAttributes);

        foreach ($variations as $var) {
            $rejections[] = array_values($var->getAttributeMeta($parentAttributeNames));
        }

        $existingVariations = count($rejections);

        for ($i = 0; $i < $existingVariations; $i++) {
            $key = array_search($rejections[$i], $attributeArray);
            if ($key || $key === 0) {
                unset($attributeArray[$key]);
            }
        }

        $attributeArray = array_values($attributeArray);

        unset($rejections);

        $totalVars = count($attributeArray);

        $createdProducts = [];

        try {
            DB::beginTransaction();

            $attrIndex = 0;

            while ($totalVars > 0) {

                $product = $this->createEmptyVariationProduct();

                $productAttributes = [];

                $metaAttr = [];

                for ($i = 0; $i < $totalAttributes; $i++) {
                    $metaAttr[] = [
                        'product_id' => $product->id,
                        'key' => 'attribute_' . $parentAttributeNames[$i],
                        'value' => is_array($attributeArray[$attrIndex]) ? $attributeArray[$attrIndex][$i] : $attributeArray[$attrIndex],
                    ];
                    $productAttributes['attribute_' . $parentAttributeNames[$i]] = is_array($attributeArray[$attrIndex]) ?
                        $attributeArray[$attrIndex][$i]
                        : $attributeArray[$attrIndex];
                }
                ProductMeta::insert($metaAttr);
                $product->attributes = $productAttributes;
                $createdProducts[] = $product;
                $totalVars--;
                $attrIndex++;
            }
            DB::commit();
            ProductMeta::forgetCache();
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse(['error' => __('Failed to add variation.')]);
        }

        $this->product->attributeValues = $this->getAttributeValues($this->product->getVariationAttributes());

        $this->view = $this->getRouteOrView('admin.products.pieces.all-variation-attribute');

        return [
            'product' => $this->product,
            'variations' => $createdProducts,
            'idx' => $this->request->index,
            'taxes' => TaxClass::getAll(),
            'shippings' => ShippingClass::getAll(),
        ];
    }

    /**
     * Create Single custom variation
     *
     * @param  array  $parentAttributes
     * @return array
     */
    protected function createSingleVariation($parentAttributes)
    {
        $product = $this->createEmptyVariationProduct();

        $productMeta = [];

        foreach ($parentAttributes as $key => $value) {
            $productMeta[] = [
                'product_id' => $product->id,
                'key' => 'attribute_' . $key,
                'value' => '',
            ];
        }

        ProductMeta::insert($productMeta);

        $this->view = $this->getRouteOrView('admin.products.pieces.custom-single-variation');

        return [
            'variation' => $product,
            'attributes' => $this->product->getVariationAttributes(),
            'attributeValues' => $this->product->getAllAttributeValues(),
            'shippings' => ShippingClass::getAll(),
            'idx' => $this->request->index,
            'taxes' => TaxClass::getAll(),
        ];
    }

    /**
     * Make subarray by crossing both arrays
     *
     * @param  array  $arr1
     * @param  array  $arr2
     * @return array
     */
    protected function mergeArray($arr1, $arr2)
    {
        $arr = [];
        $len1 = count($arr1) - 1;
        $len2 = count($arr2) - 1;
        for ($i = 0; $i <= $len1; $i++) {
            for ($j = 0; $j <= $len2; $j++) {
                if (is_array($arr1[$i])) {
                    $arr[] = array_merge($arr1[$i], [$arr2[$j]]);
                } else {
                    $arr[] = [$arr1[$i], $arr2[$j]];
                }
            }
        }

        return $arr;
    }

    /**
     * Get all the values of attribute from AttributeValue table
     *
     * @param  array|string  $options
     * @return array
     */
    protected function getAttributeValues($options)
    {
        if (is_string($options)) {
            $options = json_decode($options, true);
        }
        $attributeValues = [];
        foreach ($options as $key => $atr) {
            if ($atr['attribute_id']) {
                if ($this->editMode) {
                    $attributeValues[$key] = AttributeValue::getAll()
                        ->where('attribute_id', $atr['attribute_id']);
                } else {
                    $attributeValues[$key] = AttributeValue::getAll()
                        ->where('attribute_id', $atr['attribute_id'])->whereIn('id', $atr['value']);
                }
            }
        }

        return $attributeValues;
    }

    /**
     * Update product information
     *
     * @param  array  $request
     * @param  Product  $product
     * @return mixed
     */
    public function saveBasicInfo($request, $product)
    {
        $request = $this->preProcessRequestArray($request);

        $product = $this->updateExtraProductData($request, $product);

        $this->storeMetaData($request, $product);

        // Get fillable fields of the model
        $fillables = $product->getFillable();

        // Remove skipable fields from fillables
        $fillables = $this->filterFillables($fillables);

        // Convert the fillable field array into a hashmap where the keys are the field names
        $fillables = array_flip($fillables);

        // Filter empty request data
        if ($this->method != 'updateBasicInfoWeb') {
            $newRequest = array_filter($request, function ($x) {
                return (is_string($x) && strlen($x)) || is_array($x) || is_numeric($x);
            });
        } else {
            $newRequest = $request;
        }

        // get only fillable field named value from request
        $fillables = array_intersect_key($fillables, $newRequest);

        $data = $this->mergeArrayByKey($fillables, $newRequest);

        $data = $this->postProcessRequestArray($data, $request);

        $product->update($data);

        return $product;
    }

    /**
     * Store product tags
     *
     * @param  array  $request
     * @return void
     */
    protected function saveTags($request)
    {
        if (! isset($request['product_tags']) || ! is_array($request['product_tags']) || count($request['product_tags']) < 1) {
            $this->product->tags()->detach();

            return;
        }
        $tags = $request['product_tags'];

        $tags = array_unique($tags);

        $allTags = Tag::select('id')->whereIn('id', $tags)->get()->pluck('id', 'id');

        if (count($tags) == count($allTags)) {
            $this->product->tags()->sync($tags);

            return;
        }

        $newTags = [];
        foreach ($tags as $tag) {
            if (isset($allTags[$tag])) {
                $newTags[] = $tag;

                continue;
            }

            try {
                $nTag = Tag::insertGetId([
                    'name' => $tag,
                ]);
                if ($nTag) {
                    $newTags[] = $nTag;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        $this->product->tags()->sync($newTags);
    }

    /**
     * Generate slug/permalink
     *
     * @param  string  $url
     * @param  App\Models\Product  $product
     * @return string
     */
    protected function generateSlug($url, $product)
    {
        $pl = cleanedUrl($url);

        $slugs = Product::select('slug')
            ->where('id', '!=', $product->id)
            ->whereLike('slug', $pl)->get()
            ->pluck('slug')->toArray();

        if (count($slugs) == 0) {
            return $pl;
        }

        if (! in_array($pl, $slugs)) {
            return $pl;
        }

        $counter = 1;

        do {
            $tpl = $pl . '-' . $counter++;

            if (! in_array($tpl, $slugs)) {
                break;
            }
        } while ($counter > 0);

        return $tpl;
    }

    /**
     * Format value to insert in database
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function formatVal($value)
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return $value;
    }

    /**
     * Update extra information which needs manipulation before saving
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return Product
     */
    protected function updateExtraProductData($request, $product)
    {
        if (isset($request['upsells']) && is_array($request['upsells'])) {
            $this->product->upSales()->sync($request['upsells']);
            ProductTag::forgetCache();
        } elseif ($this->method == 'updateBasicInfoWeb') {
            $this->product->upSales()->detach();
        }

        if (isset($request['cross_sells']) && is_array($request['cross_sells'])) {
            $this->product->crossSales()->sync($request['cross_sells']);
            ProductCrossSale::forgetCache();
        } elseif ($this->method == 'updateBasicInfoWeb') {
            $this->product->crossSales()->detach();
        }

        if (isset($request['related_products']) && is_array($request['related_products'])) {
            $this->product->relatedProducts()->sync($request['related_products']);
            ProductRelate::forgetCache();
        } elseif ($this->method == 'updateBasicInfoWeb') {
            $this->product->relatedProducts()->detach();
        }

        if (isset($request['isFeatured'])) {
            if ($request['isFeatured'] == '1') {
                if (! $product->featured) {
                    $product->featured = now();
                }
            } else {
                $product->featured = null;
            }
            $this->skipField('featured');
        }

        if (isset($request['category']) && $request['category'] != '') {
            (new ProductCategory())->where('product_id', $product->id)->delete();
            (new ProductCategory())->store([
                'product_id' => $product->id,
                'category_id' => $request['category'],
            ]);
            ProductCategory::forgetCache();
        }

        if (isset($request['has-tags'])) {
            $this->saveTags($request);
        }

        // If any product attribute has been changed then save the changes
        if ($product->isDirty()) {
            $product->save();
        }

        return $product;
    }

    /**
     * Store product metadata
     *
     * @param  Request  $request
     * @param  Product  $product
     * @return void
     */
    protected function storeMetaData($request, $product)
    {
        $request = $this->manipulatedMetaData($request);

        $storableData = [];

        foreach ($request as $key => $value) {
            if (str_starts_with($key, 'meta_')) {
                $storableData[] = [
                    'product_id' => $product->id,
                    'key' => $key,
                    'value' => $this->formatVal($value),
                    'type' => gettype($value),
                ];
            }
        }

        ProductMeta::upsert($storableData, ['product_id', 'key'], ['value', 'type']);
    }

    /**
     * Manipulate meta data in request array
     *
     * @param  array  $request
     * @return array
     */
    protected function manipulatedMetaData($request)
    {
        if (isset($request['saving-product-media']) == '1') {

            if (! isset($request['meta_video_files'])) {
                $request['meta_video_files'] = [];
            }

            if (! isset($request['meta_image'])) {
                $request['meta_image'] = [];
            }

            if (! isset($request['meta_video_url'])) {
                $request['meta_video_url'] = [];
            }
        }

        $request = $this->processDownloadableMeta($request);

        return $request;
    }

    /**
     * Process downloadable meta
     *
     * @param  array  $request
     * @param array
     */
    protected function processDownloadableMeta($request)
    {
        if (! isset($request['has_downloadables'])) {
            return $request;
        }

        if (! isset($request['meta_downloadable_files'])) {
            $request['meta_downloadable_files'] = [];

            return $request;
        }

        $downloadables = $request['meta_downloadable_files'];

        $newDownloadables = [];

        if (is_array($downloadables)) {
            foreach ($downloadables as $value) {
                if (is_array($value) && $f = $this->checkDownloadableInputs($value)) {
                    $newDownloadables[] = $f;
                }
            }
        }

        $request['meta_downloadable_files'] = $newDownloadables;

        return $request;
    }

    protected function checkDownloadableInputs($file)
    {
        foreach ($file as $key => $value) {
            if (! ($key == 'name' || $key == 'url')) {
                return false;
            } elseif (empty($value)) {
                return false;
            }
        }

        return $file;
    }

    /**
     * Turn on product edit mode
     *
     * @return this
     */
    public function editModeOn()
    {
        return $this->setEditMode(true);
    }

    /**
     * Turn of product edit mode
     *
     * @return this
     */
    protected function editModeOff()
    {
        return $this->setEditMode(false);
    }

    /**
     * Update product edit mode
     *
     * @return this
     */
    protected function setEditMode($mode)
    {
        $this->editMode = $mode;
        $this->onlyPurchasableVariation = ! $mode;

        return $this;
    }

    /**
     * Process request data array
     *
     * @param array
     * @return array
     */
    protected function preProcessRequestArray($array)
    {
        if (array_key_exists('available_from', $array)) {
            $array['available_from'] = $this->processDate($array['available_from']);
        }
        if (array_key_exists('available_to', $array)) {
            $array['available_to'] = $this->processDate($array['available_to']);
        }

        if (array_key_exists('sale_from', $array)) {
            $array['sale_from'] = $this->processDate($array['sale_from']);
        }
        if (array_key_exists('sale_to', $array)) {
            $array['sale_to'] = $this->processDate($array['sale_to']);
        }

        if (array_key_exists('brand_id', $array) && $array['brand_id'] == '') {
            $array['brand_id'] = null;
        }

        if (array_key_exists('vendor_id', $array) && $array['vendor_id'] == '') {
            $array['vendor_id'] = null;
        }

        return $array;
    }

    protected function postProcessRequestArray($array, $oldArray = [])
    {
        if (isset($oldArray['sale_price'])) {
            if ($oldArray['sale_price'] == '') {
                $array['sale_price'] = null;
            }
        }

        if (isset($oldArray['regular_price'])) {
            if ($oldArray['regular_price'] == '') {
                $array['regular_price'] = null;
            }
        }

        return $array;
    }

    /**
     * Get required route or view names
     *
     * @param  string  $name  Key of the route-view associative array
     * @return string
     */
    protected function getRouteOrView($name = '')
    {
        return isset($this->routeAndViews[$name]) ? $this->routeAndViews[$name] : '';
    }

    /**
     * Update assigned routes and view file names
     *
     * @return void
     */
    protected function updateRouteAndViews()
    {
    }

    /**
     * Process invalid dates
     *
     * @param  string  $date
     * @return string|null
     */
    protected function processDate($date = '')
    {
        return $date == '0000-00-00' || $date == '' ? null : $date;
    }

    /**
     * Add new field to skip while storing the product
     *
     * @param  string  $name
     * @return void
     */
    public function skipField($name)
    {
        $this->shouldSkipFields[] = $name;
    }

    /**
     * Returns skippable fields
     *
     * @return array
     */
    protected function getSkipableFields()
    {
        return $this->shouldSkipFields;
    }

    protected function filterFillables($array)
    {
        return array_diff($array, $this->getSkipableFields());
    }

    protected function mergeArrayByKey($relativeArray = [], $dataArray = [])
    {
        $mergedArray = [];
        foreach ($relativeArray as $key => $value) {
            $mergedArray[$key] = $dataArray[$key] ?? null;
        }

        return $mergedArray;
    }

    /**
     * duplicate product
     *
     * @return void
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function duplicateProduct()
    {
        $rootProduct = session()->get('root_product');

        $this->duplicateData($rootProduct, null);

        $this->relatedProductStore($rootProduct);
        $this->upsaleProductStore($rootProduct);
        $this->crossSaleProductStore($rootProduct);
        $this->productTagsStore($rootProduct);

        if ($rootProduct->isVariableProduct() && $rootProduct->variations) {

            foreach ($rootProduct->variations as $variation) {
                $product = Product::create([
                    'name' => $variation->name,
                    'status' => $variation->status,
                    'description' => $variation->description,
                    'summary' => $variation->summary,
                    'vendor_id' => $variation->vendor_id,
                    'parent_id' => $this->product->id,
                    'shop_id' => $variation->shop_id,
                    'brand_id' => $variation->brand_id,
                    'regular_price' => $variation->regular_price,
                    'sale_price' => $variation->sale_price,
                    'sale_from' => $variation->sale_from,
                    'sale_to' => $variation->sale_to,
                    'available_from' => $variation->available_from,
                    'available_to' => $variation->available_to,
                    'featured' => $variation->featured,
                    'manage_stocks' => $variation->manage_stocks,
                    'total_stocks' => $variation->total_stocks,
                    'type' => $variation->type,
                    'menu_order' => $variation->menu_order,
                ]);

                if ($product) {
                    $this->duplicateData($variation, $product->id);
                }
            }
        }

        session()->forget('root_product');
    }

    /**
     * relatedProduct
     */
    protected function relatedProductStore($rootProduct): void
    {
        $relatedProductData = [];

        $rootRelated = ProductRelate::where('product_id', $rootProduct->id)->get()->pluck('related_product_id')->toArray();

        foreach ($rootRelated as $value) {
            $relatedProductData[] = ['product_id' => $this->product->id, 'related_product_id' => $value];
        }

        (new ProductRelate())->store($relatedProductData);
    }

    /**
     * upsaleProduct
     */
    protected function upsaleProductStore($rootProduct): void
    {
        $upsaleData = [];

        $rootRelated = ProductUpsale::where('product_id', $rootProduct->id)->get()->pluck('upsale_product_id')->toArray();

        foreach ($rootRelated as $value) {
            $upsaleData[] = ['product_id' => $this->product->id, 'upsale_product_id' => $value];
        }

        (new ProductUpsale())->store($upsaleData);
    }

    /**
     * crossSaleProduct
     */
    protected function crossSaleProductStore($rootProduct): void
    {
        $crossSale = [];
        $productTags = [];

        $rootRelated = ProductCrossSale::where('product_id', $rootProduct->id)->get()->pluck('cross_sale_product_id')->toArray();

        foreach ($rootRelated as $value) {
            $crossSale[] = ['product_id' => $this->product->id, 'cross_sale_product_id' => $value];
        }

        (new ProductCrossSale())->store($crossSale);
    }

    /**
     * product tag store
     */
    protected function productTagsStore($rootProduct): void
    {
        $productTags = [];

        $rootRelated = ProductTag::where('product_id', $rootProduct->id)->get()->pluck('tag_id')->toArray();

        foreach ($rootRelated as $value) {
            $productTags[] = ['product_id' => $this->product->id, 'tag_id' => $value];
        }

        (new ProductTag())->store($productTags);
    }

    /**
     * duplicate product
     */
    protected function duplicateData($rootProduct, $productId = null): void
    {
        $metaData = ProductMeta::where('product_id', $rootProduct->id)->get();
        $duplicateMeta = [];

        foreach ($metaData as $meta) {
            $duplicateMeta[] = [
                'product_id' => ! is_null($productId) ? $productId : $this->product->id,
                'type' => $meta->type,
                'key' => $meta->key,
                'value' => is_array($meta->value) ? json_encode($meta->value) : $meta->value,
            ];
        }

        ProductMeta::insert($duplicateMeta);
    }
}
