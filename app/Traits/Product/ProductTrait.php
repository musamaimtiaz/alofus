<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 07-01-2022
 */

namespace App\Traits\Product;

use App\Enums\ProductStatus;
use App\Http\Resources\VariationResource;
use App\Models\{
    AttributeValue,
    Category,
    File,
    Product,
    ProductCrossSale,
    ProductRelate,
    ProductMeta,
    ProductUpsale,
    Tag
};
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;

trait ProductTrait
{
    /**
     * Stores product variations
     */
    private $productAttributes = [];

    /**
     * Product thumbnail
     */
    private $productThumbnail = null;

    /**
     * Get product variation
     *
     * @return mixed
     */
    public function getVariations()
    {
        if (! $this->relationLoaded('variations')) {
            $this->relations['variations'] = static::where('parent_id', $this->id)->get();
        }

        return $this->relations['variations'];
    }

    /**
     * Refetch variations from database
     *
     * @return mixed
     */
    public function refreshVariation()
    {
        $this->relations['variations'] = static::where('parent_id', $this->id)->get();

        return $this->relations['variations'];
    }

    public function getPurchaseableVariation()
    {
        return static::where('parent_id', $this->id)->isAvailable()->published()->get();
    }

    public function getDiscountableVariation()
    {
        return static::where('parent_id', $this->id)->where('sale_price', '!=', null)->isAvailable()->published()->get();
    }

    /**
     * Get parent attribute lists
     *
     * @return array
     */
    public function getProductAttributes()
    {
        if (count($this->productAttributes) < 1) {
            if (! $this->metaFetched) {
                $this->getMeta();
            }
            if (isset($this->metaArray['attributes'])) {
                $this->productAttributes = $this->metaArray['attributes'];
            }
        }

        return $this->productAttributes;
    }

    public function getVariationAttributes()
    {
        $attributes = $this->getProductAttributes();
        if (! is_array($attributes)) {
            return [];
        }
        $newArray = [];
        foreach ($attributes as $attr) {
            if ($attr['variation'] == 1) {
                $newArray[$attr['key']] = $attr;
            }
        }

        return $newArray;
    }

    public function getAttributeValues()
    {
        $attributeValues = [];
        $allAttributeValues = $this->getAllAttributeValues();
        foreach ($this->getProductAttributes() as $atr) {
            if ($atr['attribute_id']) {
                $attributeValues[$atr['key']] = $allAttributeValues->whereIn('id', $atr['value'])->values();
            }
        }

        return $attributeValues;
    }

    public function getAllAttributeValues()
    {
        $attributeIds = [];
        foreach ($this->getProductAttributes() as $atr) {
            if ($atr['attribute_id']) {
                $attributeIds = array_merge($attributeIds, is_array($atr['value']) ? $atr['value'] : []);
            }
        }

        return AttributeValue::whereIn('id', $attributeIds)->get() ?? null;
    }

    public function getDefaultVariationAttributes()
    {
        if ($this->default_attributes) {
            return $this->default_attributes;
        }

        return [];
    }

    /**
     * Get default value of an attribute for variation
     *
     * @param  string  $attribute
     * @param mixed
     */
    public function getDefaultVariationValue($attribute)
    {
        $defaults = $this->getDefaultVariationAttributes();
        if (isset($defaults[$attribute])) {
            return $defaults[$attribute];
        }

        return null;
    }

    /**
     * set parent attributes
     *
     * @param  array  $attributes
     * @return void
     */
    public function updateProductAttributes($attributes)
    {
        $update = ProductMeta::updateOrCreate([
            'product_id' => $this->id,
            'key' => 'attributes',
        ], ['value' => $attributes]);

        if ($update) {
            return $this->productAttributes = $attributes;
        }

        return false;
    }

    /**
     * Get seo information with seo image ids
     *
     * @return array
     */
    public function getSeoMeta()
    {
        return [
            'title' => $this->getSeoTitle(),
            'description' => $this->getSeoDescription(),
            'image' => $this->getSeoImageUrl(true),
        ];
    }

    /**
     * Get seo information with seo image urls
     *
     * @return array
     */
    public function getSeoMetaWithUrl()
    {
        return [
            'title' => $this->getSeoTitle(),
            'description' => $this->getSeoDescription(),
            'image' => $this->getSeoImageUrl(),
        ];
    }

    /**
     * Get seo title
     *
     * @return null|string
     */
    public function getSeoTitle()
    {
        if (is_array($this->seo) && array_key_exists('title', $this->seo)) {
            return $this->seo['title'];
        }

        return null;
    }

    /**
     * Get seo description
     *
     * @return null|string
     */
    public function getSeoDescription()
    {
        if (is_array($this->seo) && array_key_exists('description', $this->seo)) {
            return $this->seo['description'];
        }

        return null;
    }

    /**
     * Get seo image id
     *
     * @return mixed
     */
    public function getSeoImageId()
    {
        if (is_array($this->seo) && array_key_exists('image', $this->seo)) {
            return $this->seo['image'];
        }

        return null;
    }

    /**
     * Get seo image url
     *
     * @param  bool  $urlOnly  Default false
     * @return array
     */
    public function getSeoImageUrl($urlOnly = false)
    {
        $ids = $this->getSeoImageId();

        if (! $ids) {
            return $urlOnly ? null : [];
        }

        if (is_array($ids)) {
            return $this->getFileUrlsByIds($ids, $urlOnly);
        }

        return $this->getFileUrlById($ids, $urlOnly);
    }

    /**
     * Checks whether the product is scheduled for sale or not
     *
     * @return bool
     */
    public function isScheduledSale()
    {
        if ($this->meta_scheduled_sale && $this->sale_from && $this->sale_to) {
            return true;
        }

        return false;
    }

    /**
     * Get product video file ids
     *
     * @return array
     */
    public function getVideoFileIds()
    {
        if ($this->meta_video_files) {
            return $this->meta_video_files;
        }

        return [];
    }

    /**
     * Get video urls which were added by uses via urls
     *
     * @return array
     */
    public function getVideoUrls()
    {
        if (! $urls = $this->meta_video_url) {
            return [];
        }
        if (is_array($urls)) {
            return array_filter($urls);
        }

        return [$urls];
    }

    /**
     * Get featured image detail
     *
     * @return string|array
     */
    public function getFeaturedImageDetail()
    {
        if ($this->meta_image && is_array($this->meta_image) && count($this->meta_image) > 0) {
            return $this->getFileUrlById($this->meta_image[0]);
        }

        return [];
    }

    /**
     * Get default image
     *
     * @param  bool  $urlOnly
     * @return array
     */
    private function getDefaultImage($urlOnly = false)
    {
        if ($urlOnly) {
            return [url(defaultImage('products'))];
        }

        return [
            'id' => null,
            'name' => 'default.jpg',
            'url' => url(defaultImage('products')),
        ];
    }

    /**
     * Get featured image
     *
     * @param  string  $size
     * @return string
     */
    public function getFeaturedImage($size = null)
    {
        $this->productThumbnail = $size;

        if ($this->meta_image && is_array($this->meta_image) && count($this->meta_image) > 0) {
            return $this->getFileUrlById($this->meta_image[0], true);
        }

        return $this->getDefaultImage()['url'];
    }

    /**
     * Get product all videos urls only
     *
     * @return array
     */
    public function getAllVideoUrls()
    {
        $urls = $this->getVideoUrls();

        $files = $this->getVideoFiles(true);

        return array_merge($files, $urls);
    }

    public function getVideoFiles($urlOnly = false)
    {
        $ids = $this->getVideoFileIds();

        if (! $ids) {
            return [];
        }
        if (is_array($ids)) {
            return $this->getFileUrlsByIds($ids, $urlOnly);
        }

        return $this->getFileUrlById($ids, $urlOnly);
    }

    /**
     * Get downloadable files
     *
     * @return array|null
     */
    public function getDownloadables()
    {
        if (! $this->meta_downloadable_files) {
            return [];
        }

        if (is_array($this->meta_downloadable_files) && count($this->meta_downloadable_files) > 0) {
            foreach ($this->meta_downloadable_files as $file) {
                if (is_array($file) && count($file) > 0) {
                    return $this->meta_downloadable_files;
                }
                if (! is_array($file)) {
                    return $this->meta_downloadable_files;
                }
            }
        }

        return [];
    }

    public function isDownloadable()
    {
        if (! $this->meta_downloadable) {
            return 0;
        }

        return $this->meta_downloadable;
    }

    public function isVirtual()
    {
        if (! $this->meta_virtual) {
            return 0;
        }

        return $this->meta_virtual;
    }

    public function isReviewEnabled()
    {
        if (! preference('reviews_enable_product_review') || ! $this->enable_reviews) {
            return 0;
        }

        return 1;
    }

    /**
     * Get download limit
     *
     * @return int
     */
    public function getDownloadLimit()
    {
        if (! $this->meta_download_limit) {
            return 0;
        }

        return $this->meta_download_limit;
    }

    public function getDownloadExpiry()
    {
        if (! $this->meta_download_expiry) {
            return 0;
        }

        return $this->meta_download_expiry;
    }

    /**
     * Get UpSale products ids
     *
     * @return array|null
     */
    public function getUpSaleIds()
    {
        return ProductUpsale::where('product_id', $this->id)->get()->pluck('upsale_product_id')->toArray() ?? [];
    }

    /**
     * Get Related products ids
     *
     * @return array|null
     */
    public function getRelatedProductIds()
    {
        return ProductRelate::where('product_id', $this->id)->pluck('related_product_id')->toArray() ?? [];
    }

    /**
     * Get CrossSale products ids
     *
     * @return array|null
     */
    public function getCrossSaleIds()
    {
        return ProductCrossSale::where('product_id', $this->id)->pluck('cross_sale_product_id')->toArray() ?? [];
    }

    /**
     * Get grouped products
     *
     * @return array
     */
    public function getGroupedProductIds($onlyId = true)
    {
        if ($this->meta_grouped_products && is_array($this->meta_grouped_products)) {
            if ($onlyId) {
                return $this->meta_grouped_products;
            }
            $product = [];
            foreach ($this->meta_grouped_products as $id) {
                $data = Product::where('id', $id)->published()->isAvailable()->first();
                if (! empty($data)) {
                    $product[] = $data;
                }
            }

            return $product;
        }

        return [];
    }

    /**
     * Get image gallery
     *
     * @param  bool  $urlOnly  If only urls are needed
     * @return array
     */
    public function getImages($urlOnly = false, $size = null)
    {
        $this->productThumbnail = $size;

        if ($this->meta_image) {
            if (is_array($this->meta_image)) {
                return $this->getFileUrlsByIds($this->meta_image, $urlOnly);
            } else {
                return $this->getFileUrlById($this->meta_image, $urlOnly);
            }
        }

        return $this->getDefaultImage($urlOnly);
    }

    public function getImagesWithoutDefault($urlOnly = false)
    {
        if ($this->meta_image) {
            if (is_array($this->meta_image)) {
                return $this->getFileUrlsByIds($this->meta_image, $urlOnly);
            } else {
                return $this->getFileUrlById($this->meta_image, $urlOnly);
            }
        }

        return [];
    }

    /**
     * Get gallery images urls only
     *
     * @return array
     */
    public function getAllImagesUrls()
    {
        return $this->getImages(true);
    }

    /**
     * Get image url by id
     *
     * @param  int  $id
     * @param  bool  $urlOnly  Default false
     * @return mixed
     */
    public function getFileUrlById($id, $urlOnly = false)
    {
        return $urlOnly ? $this->buildFileOnlyUrl($id) : $this->buildFile($id);
    }

    /**
     * Get image urls by ids
     *
     * @param  array  $ids
     * @param  bool  $urlOnly  Default false
     * @return array
     */
    public function getFileUrlsByIds($ids, $urlOnly = false)
    {
        $files = [];
        if ($urlOnly) {
            foreach ($ids as $fileName) {
                $files[] = $this->buildFileOnlyUrl($fileName);
            }
        } else {
            foreach ($ids as $fileName) {
                $files[] = $this->buildFile($fileName);
            }
        }

        return $files;
    }

    /**
     * Wrap file details in array
     *
     * @param  File  $file
     * @return array
     */
    private function buildFile($file)
    {
        return [
            'id' => $file,
            'name' => pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION),
            'url' => $this->buildFileOnlyUrl($file),
        ];
    }

    /**
     * Build file url from filename
     *
     * @param  File  $file
     * @return string
     */
    private function buildFileOnlyUrl($file)
    {
        if (filter_var($file, FILTER_VALIDATE_URL) !== false) {
            return $file;
        }

        if (in_array($this->productThumbnail, array_keys((new File())->sizeRatio()))) {
            return asset(implode(DIRECTORY_SEPARATOR, ['public', 'uploads', config('martvill.thumbnail_dir'), $this->productThumbnail, $file]));
        }

        return asset('public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $file);
    }

    /**
     * Access meta data directly from the model object
     *
     * OVERRIDING 'Model' default '__get()' method
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes['id'])) {
            return parent::__get($name);
        }
        $val = parent::__get($name);

        if ($val != null) {
            return $val;
        }

        if (! $this->metaFetched) {
            $this->getMeta();
        }
        if (isset($this->metaArray[$name])) {
            return $this->metaArray[$name];
        }
        if (isset($this->metaArray['meta_' . $name])) {
            return $this->metaArray['meta_' . $name];
        }

        return null;
    }

    public function getTaxClass()
    {
        if ($this->meta_tax_classes) {
            return $this->meta_tax_classes;
        }

        return null;
    }

    /**
     * Get product price
     *
     * @return mixed
     */
    public function getPrice()
    {
        if ($this->isVariableProduct()) {
            return $this->getVariablePrice();
        } elseif ($this->isGroupedProduct()) {
            $groupProductPrice = $this->groupProducts();

            return [$groupProductPrice['min'], $groupProductPrice['max']];
        }

        return $this->regular_price;
    }

    /**
     * Get variable product price range
     *
     * @return mixed
     */
    protected function getVariablePrice()
    {
        $variations = $this->getVariations();

        $minPrice = $maxPrice = null;

        foreach ($variations as $variation) {
            $this->updateMixMax($minPrice, $maxPrice, $variation->regular_price);
        }

        if ($maxPrice == $minPrice) {
            return $maxPrice;
        }

        return [$minPrice, $maxPrice];
    }

    /**
     * Get variable product sale price range
     *
     * @return mixed
     */
    protected function getVariableSalePrice()
    {
        $variations = $this->getVariations();

        $minPrice = $maxPrice = $hasSale = null;

        foreach ($variations as $variation) {

            $price = ($variation->sale_price != 0 && $variation->sale_price != null) ? $variation->sale_price : $variation->regular_price;

            if ($variation->sale_price) {
                $hasSale = true;
            }

            $this->updateMixMax($minPrice, $maxPrice, $price);
        }

        if (! $hasSale) {
            return null;
        }

        if ($maxPrice == $minPrice) {
            return $maxPrice;
        }

        return [$minPrice, $maxPrice];
    }

    /**
     * Get discounted price
     *
     * @mixed
     */
    public function getSalePrice()
    {
        if ($this->isVariableProduct()) {
            return $this->getVariableSalePrice();
        }

        if ($this->sale_price) {
            return $this->sale_price;
        }

        return null;
    }

    /**
     * Update min and max value
     */
    private function updateMixMax(&$min, &$max, $value)
    {
        if ($max == null ||  $value > $max) {
            $max = $value;
        }
        if ($min == null ||  $value < $min) {
            $min = $value;
        }
    }

    /**
     * Get Formatted sale Price
     *
     * @param  bool  $isArray  (Return type) Default false
     * @return array|string
     */
    public function getFormattedSalePrice($isArray = false)
    {
        $salePrice = $this->getSalePrice();

        if (is_array($salePrice)) {
            if ($isArray) {
                return [formatNumber($salePrice[0]), formatNumber($salePrice[1])];
            }

            return formatNumber($salePrice[0]) . ' - ' . formatNumber($salePrice[1]);
        }

        if ($salePrice) {
            return formatNumber($salePrice);
        }

        return null;
    }

    /**
     * Get Formatted Price
     *
     * @param  bool  $isArray  (Return type) Default false
     * @return array|string
     */
    public function getFormattedPrice($isArray = false)
    {
        $price = $this->getPrice();

        if (is_array($price)) {
            if ($isArray) {
                return [formatNumber($price[0]), formatNumber($price[1])];
            }

            return formatNumber($price[0]) . ' - ' . formatNumber($price[1]);
        }

        if ($price) {
            return formatNumber($price);
        }

        return null;
    }

    public function isDiscountable()
    {
        if ($this->isVariableProduct()) {
            return $this->isVariationDiscountable();
        }

        return $this->isOnSale();
    }

    public function isVariationDiscountable()
    {
        return $this->getDiscountableVariation() ? true : false;
    }

    protected function isOnSale()
    {
        return (! is_null($this->sale_price) || $this->sale_price != '') && $this->sale_from <= now() && (! $this->sale_to || $this->sale_to >= now());
    }

    public function getCategoryName()
    {
        return $this->category->pluck('name')->toArray();
    }

    public function isAllowBackorder()
    {
        return $this->meta_backorder;
    }

    /**
     * Get metadata array
     *
     * @return array
     */
    public function getMeta()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->getMetaCollection();
        }
        $this->metaArray = $this->relations['metadata']->pluck('value', 'key')->toArray();
        $this->metaFetched = true;

        return $this->metaArray;
    }

    /**
     * Return metadata collection of the product
     *
     * @return Collection
     */
    public function getMetaCollection()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->metadata()->get();
        }

        return $this->relations['metadata'];
    }

    /**
     * Get stock managable status
     *
     * @return bool
     */
    public function isStockManageable()
    {
        if (! preference('manage_stock') || ! $this->manage_stocks) {
            return 0;
        }

        return 1;
    }

    /**
     * Get stock quantity
     *
     * @return int
     */
    public function getStockQuantity()
    {
        if (! $this->isStockManageable()) {
            return 0;
        }

        return $this->total_stocks ?? 0;
    }

    /**
     * Get Stock status
     *
     * @return string|null
     */
    public function getStockStatus()
    {
        if (! $this->isStockManageable()) {
            if (strlen($this->meta_stock_status) == 0) {
                return 'In Stock';
            }

            return $this->meta_stock_status;
        }
        if ($this->total_stocks > 0) {
            return 'In Stock';
        }
        if ($this->meta_backorder == 1) {
            return 'On Backorder';
        }

        return 'Out of stock';
    }

    /**
     * related products
     *
     * @param  $relatedIds
     * @return array
     */
    public function getRelatedProducts()
    {
        $relatedProducts = [];
        foreach ($this->getRelatedProductIds() as $relatedId) {
            $request = (object) ['id' => $relatedId];
            $details = ProductAction::execute('getProductWithAttributeAndVariations', $request);

            if (! empty($details)) {
                $relatedProducts[] = $details;
            }
        }

        return $relatedProducts;
    }

    /**
     * same shop from products
     *
     * @param  $vendorId
     * @return mixed
     */
    public function sameShop()
    {
        $vendorsProducts = static::where('vendor_id', $this->vendor_id)->where('id', '!=', $this->id)->isAvailable()->notVariation()->published()->limit(6)->get();
        $sameShop = [];
        foreach ($vendorsProducts as $product) {
            $request = (object) ['id' => $product->id];
            $details = ProductAction::execute('getProductWithAttributeAndVariations', $request);

            if (! empty($details)) {
                $sameShop[] = $details;
            }
        }

        return $sameShop;
    }

    /**
     * put data in cache for recent view
     *
     * @return void
     */
    public function recentView()
    {
        $recentView = [];
        if (auth()->user()) {
            if (Cache::has(auth()->user()->id)) {
                $recentView = Cache::get(auth()->user()->id);
            }
            $recentView[$this->productId] = now()->toDateTimeString();
            \Cache::put([auth()->user()->id => $recentView], config('cache.recentView'));
        } else {
            if (Cache::has(request()->server('HTTP_USER_AGENT'))) {
                $recentView = Cache::get(request()->server('HTTP_USER_AGENT'));
            }
            $recentView[$this->productId] = now()->toDateTimeString();
            \Cache::put([request()->server('HTTP_USER_AGENT') => $recentView], config('cache.recentView'));
        }
    }

    /**
     *get category root to last child
     *
     * @param  $categoryId
     * @return array
     */
    public function categoryPath()
    {
        $category = Category::getAll()->where('id', optional($this->productCategory)->category_id)->where('status', 'Active')->first();
        $parent = [];
        if (! empty($category)) {
            $parent[] = ['name' => $category->name, 'slug' => $category->slug];
            while (1) {
                if (! empty($category->category)) {
                    $category = $category->category;
                    $parent[] = ['name' => $category->name, 'slug' => $category->slug];
                } else {
                    break;
                }
            }
        }

        return $parent != null ? array_reverse($parent) : $parent;
    }

    /**
     * check offer
     *
     * @param  $saleTo
     * @param  $salePrice
     * @return bool
     */
    public function offerCheck()
    {
        date_default_timezone_set(preference('default_timezone'));

        return ! empty($this->sale_to) && $this->sale_to > now() && $this->sale_price > 0 && ! empty($this->sale_from) && now() >= $this->sale_from ||
            empty($this->sale_to) && $this->sale_price > 0 && ! empty($this->sale_from) && now() >= $this->sale_from ||
            empty($this->sale_from) && $this->sale_price > 0 && ! empty($this->sale_to) && $this->sale_to > now() ||
            empty($this->sale_to) && empty($this->sale_from) && $this->sale_price > 0;
    }

    /**
     * filter variaton
     *
     * @param  $variations
     * @param  $attributes
     * @return array
     */
    public function filterVariation()
    {
        $attrbuteIdsWithKey = [];
        $attributePriceWithId = [];
        $possibleVariation = [];
        $attributeAllId = [];
        $price = 0;
        $min = 0;
        $max = 0;
        $attributes = $this->getVariationAttributes();
        $variations = VariationResource::collection($this->variations);
        $variationAttribute = [];
        foreach ($variations as $variation) {

            if ($variation->status == ProductStatus::$Published && isset($variation->attributes)) {
                if (is_array($variation->attributes) && count($variation->attributes) > 0) {
                    foreach ($variation->attributes as $key => $varAttribute) {
                        $oldKey = $key;
                        $key = str_replace('attribute_', '', $key);
                        if (isset($attributes[$key])) {
                            if (! in_array($varAttribute, $attributeAllId)) {
                                $attributeAllId[] = $varAttribute;
                                $possibleVariation[$varAttribute] = self::getPossibleVariation($variations, $varAttribute, $attributes);
                            }
                            $attrbuteIdsWithKey[$key][$varAttribute] = strval($varAttribute);
                            $variationAttribute[strval($oldKey)] = strval($varAttribute);
                        }
                    }
                }
                $offerFlag = $variation->offerCheck();
                $price = $offerFlag ? $variation->priceWithTax(preference('display_price_in_shop'), 'sale', false) : $variation->priceWithTax(preference('display_price_in_shop'), 'regular', false);
                $min = $price < $min || $min == 0 ? $price : $min;
                $max = $price > $max || $max == 0 ? $price : $max;
                $images = urlSlashReplace($variation->getImages()['url'] ?? $variation->getFeaturedImage(), ['\/', '\\']);
                $isEnableB2B = 0;
                $b2bData = [];
                if (isActive('B2B') && ! empty($variation->regular_price)) {
                    $isEnableB2B = $variation->isEnableB2B() ? $variation->isEnableB2B() : optional($variation->parentDetail)->isEnableB2B();
                    $b2bData = $variation->isEnableB2B() ? $variation->getB2BData() : optional($variation->parentDetail)->getB2BData();
                }
                $attributePriceWithId[] = [
                    'variation_id' => $variation->id,
                    'price' => $price,
                    'regular' => $variation->priceWithTax(preference('display_price_in_shop'), 'regular', false),
                    'priceType' => $offerFlag ? 'sale' : 'regular',
                    'saleTo' => ! is_null($variation->sale_to) ? date(getFormatedCountdown(), strtotime(strtr($variation->sale_to, ' ', ''))) : null,
                    'attributeIds' => $variationAttribute,
                    'manage_stocks' => $variation->isStockManageable() == 0 ? optional($variation->parentDetail)->isStockManageable() : $variation->isStockManageable(),
                    'stock_quantity' => $variation->isStockManageable() == 0 ? optional($variation->parentDetail)->getStockQuantity() : $variation->getStockQuantity(),
                    'isOutOfStock' => $variation->isStockManageable() == 0 ? optional($variation->parentDetail)->isOutOfStock() : $variation->isOutOfStock(),
                    'lowStockThreshold' => $variation->isStockManageable() == 0 ? optional($variation->parentDetail)->getStockThreshold() : $variation->getStockThreshold(),
                    'backOrders' => $variation->isStockManageable() == 0 ? optional($variation->parentDetail)->meta_backorder : $variation->meta_backorder,
                    'weight' => $variation->meta_weight,
                    'dimensions' => is_array($variation->meta_dimension) ? $variation->meta_dimension : [],
                    'discountInPercent' => formatCurrencyAmount($variation->getDiscountAmount()),
                    'images' => url(defaultImage('products')) == $images ? urlSlashReplace(optional($variation->parentDetail)->getFeaturedImage(), ['\/', '\\']) : $images,
                    'is_enable_b2b' => $isEnableB2B,
                    'b2b_data' => $b2bData,
                ];
            }
        }

        return [
            'attrbuteIdsWithKey' =>  $attrbuteIdsWithKey,
            'attributePriceWithId' => $attributePriceWithId,
            'possibleVariation' => $possibleVariation,
            'min' => $min,
            'max' => $max,
        ];
    }

    /**
     * possible variation data
     *
     * @return array
     */
    public function getPossibleVariation($variations, $searchId, $existsAttributes)
    {
        $varIds = [];
        $existsAttributes = array_keys($existsAttributes);

        foreach ($variations as $variation) {
            if ($variation->status == ProductStatus::$Published && isset($variation->attributes)) {
                $variationsAttributes = $variation->attributes;
                if (is_array($variationsAttributes) && count($variationsAttributes) > 0 && in_array($searchId, $variationsAttributes)) {
                    unset($variationsAttributes[array_search($searchId, $variationsAttributes)]);

                    foreach ($variationsAttributes as $key => $attr) {
                        $key = str_replace('attribute_', '', $key);
                        if (in_array($key, $existsAttributes)) {
                            $varIds[] = $attr;
                        }
                    }
                }
            }
        }

        return $varIds;
    }

    /**
     * get availability
     *
     * @return bool
     */
    public function availability()
    {
        if (! empty($this->available_from) && availableFrom($this->available_from) || empty($this->available_from)) {
            if (! empty($this->available_to) && availableTo($this->available_to) || empty($this->available_to)) {
                return true;
            }
        }

        return false;
    }

    /**
     * check product out of stock status
     *
     * @return int[]
     */
    public function isOutOfStock()
    {
        $outOfStockVisibility = 0;
        $isApprove = 1;

        if (
            $this->manage_stocks == 0 && $this->meta_stock_status == 'Out Of Stock' ||
            $this->manage_stocks == 1 && $this->total_stocks <= 0 && $this->meta_backorder == 0 ||
            $this->manage_stocks == 1 && $this->total_stocks <= 0 && ! $this->meta_backorder
        ) {
            $outOfStockVisibility = 1;
            $isApprove = preference('out_of_stock_visibility') == 1 ? 0 : 1;
        }

        return [
            'isApprove' => $isApprove,
            'outOfStockVisibility' => $outOfStockVisibility,
        ];
    }

    /**
     * group products details
     *
     * @return array
     */
    public function groupProducts()
    {
        $productIds = $this->meta_grouped_products;
        $productDetails = [];
        $otherData = [];
        $min = 0;
        $max = 0;

        if (is_array($productIds) && count($productIds) > 0) {
            foreach ($productIds as $id) {
                $product = Product::where('id', $id)->published()->isAvailable()->first();

                if (! empty($product)) {
                    if ($product->isVariableProduct()) {
                        foreach ($product->getVariations() as $variation) {
                            $variationPrice = $variation->offerCheck() ? $variation->sale_price : $variation->regular_price;
                            $min = $min == 0 && ! is_null($variationPrice) ? $variationPrice : $min;
                            $min = ! is_null($variationPrice) ? min($variationPrice, $min) : $min;
                            $max = max($variationPrice, $max);
                        }
                    } elseif ($product->isGroupedProduct()) {
                        $groupPrice = $product->groupProducts();
                        $min = $min == 0 && ! is_null($groupPrice['min']) ? $groupPrice['min'] : $min;
                        $min = ! is_null($groupPrice['min']) ? min($groupPrice['min'], $min) : $min;
                        $max = max($groupPrice['max'], $max);
                    } else {
                        $price = $product->offerCheck() ? $product->sale_price : $product->regular_price;
                        $min = $min == 0 && ! is_null($price) ? $price : $min;
                        $min = ! is_null($price) ? min($price, $min) : $min;
                        $max = max($price, $max);
                    }

                    $productDetails[] = $product;
                    $otherData[$product->id] = ['id' => $product->id, 'feature_image' => $product->getFeaturedImage(), 'is_offer-able' => $product->offerCheck(), 'critical_stock_quantity' => $product->meta_stock_threshold, 'stock_hide' => $product->meta_hide_stock, 'backorders' => $product->isAllowBackorder(), 'sale_price_formatted' => $product->getFormattedSalePrice(), 'regular_price_formatted' => $product->getFormattedPrice()];
                }
            }
        }

        return [
            'min' => $min,
            'max' => $max,
            'productDetails' => $productDetails,
            'otherData' => $otherData,
        ];
    }

    /*** get low stock threshold
     *
     * @return mixed|null
     */
    public function getStockThreshold()
    {
        return $this->meta_stock_threshold;
    }

    /**
     * get is active B2B
     *
     * @return mixed|null
     */
    public function isEnableB2B()
    {
        return $this->meta_enable_b2b;
    }

    /**
     * get b2b meta data
     *
     * @return array|mixed|null
     */
    public function getB2BData()
    {
        if (! $this->meta_b2b_data) {
            return [];
        }

        if (is_array($this->meta_b2b_data) && count($this->meta_b2b_data) > 0) {
            foreach ($this->meta_b2b_data as $data) {
                if (is_array($data) && count($data) > 0) {
                    return $this->meta_b2b_data;
                }
                if (! is_array($data)) {
                    return $this->meta_b2b_data;
                }
            }
        }

        return [];
    }

    /**
     * product tag names
     *
     * @return array
     */
    public function tagNames()
    {
        $names = [];

        foreach ($this->tags as $tag) {
            $names[] = $tag->name;
        }

        return $names;
    }

    /**
     * is user can review it or not
     */
    public function canReview(): bool
    {
        return isset(auth()->guard('api')->user()->id) && auth()->guard('api')->user()->review()->where('product_id', $this->id)->count() == 0 && (auth()->guard('api')->user()->isPurchaseProduct($this->id) || preference('review_left') == 0) ||
        isset(auth()->user()->id) && auth()->user()->review()->where('product_id', $this->id)->count() == 0 && (auth()->user()->isPurchaseProduct($this->id) || preference('review_left') == 0);
    }
}
