<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 25-07-2021
 *
 * @updated 15-06-2022
 */

namespace App\Models;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Services\Shipping\ShippingCalculation;
use App\Services\Tax\TaxCalculation;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use App\Services\Product\BuilderQueryService;
use App\Services\Product\ProductCategorizingService;
use App\Traits\Product\ProductTrait;
use Modules\Shipping\Entities\ShippingZoneShippingClass;
use Modules\Tax\Entities\TaxClass;
use Validator;
use Cart;
use Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use hasFiles;
    use ModelTrait;
    use ProductTrait;
    use SoftDeletes;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'code', 'name', 'description', 'summary', 'review_count', 'review_average', 'available_from', 'available_to', 'vendor_id',
        'brand_id', 'status', 'total_sales', 'total_wish', 'regular_price', 'sale_price', 'sku', 'shop_id', 'parent_id', 'slug',
        'sale_from', 'sale_to', 'featured', 'type', 'manage_stocks', 'total_stocks', 'menu_order',
    ];

    /**
     * Stores meta information in array
     *
     * @var array
     */
    protected $metaArray = [];

    /**
     * Checks if the meta is already fetched or not
     *
     * @var bool
     */
    protected $metaFetched = false;

    /**
     * Default number of post to fetch from database
     */
    private static $limit = 10;

    protected static function booted()
    {
        /**
         * Add unique code when creating new product
         */
        static::creating(function ($product) {
            if (! $product->code) {
                $product->code = Str::random(15);
            }
        });
    }

    /**
     * parent data from childs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentDetail()
    {
        return $this->belongsTo('App\Models\Product', 'parent_id', 'id');
    }

    public function metadata()
    {
        return $this->hasMany(ProductMeta::class, 'product_id', 'id');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany('App\Models\Product', 'product_relates', 'product_id', 'related_product_id');
    }

    public function upSales()
    {
        return $this->belongsToMany('App\Models\Product', 'product_upsales', 'product_id', 'upsale_product_id');
    }

    public function crossSales()
    {
        return $this->belongsToMany('App\Models\Product', 'product_cross_sales', 'product_id', 'cross_sale_product_id');
    }

    public function variations()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    /**
     * Relation with FlashSale model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flashSale()
    {
        return $this->hasMany('App\Models\FlashSale', 'product_id', 'id');
    }

    /**
     * Relation with ProductCategory model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function productCategory()
    {
        return $this->hasOne('App\Models\ProductCategory', 'product_id', 'id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }

    /**
     * Relation with ProductTag model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productTag()
    {
        return $this->hasMany('App\Models\ProductTag', 'product_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'product_tags', 'product_id', 'tag_id');
    }

    /**
     * Relation with productsMeta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxMeta()
    {
        return $this->hasOne('App\Models\ProductMeta', 'product_id', 'id')->where('key', 'meta_tax_classes')->first();
    }

    /**
     * Relation with Review model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function review()
    {
        return $this->hasMany('App\Models\Review', 'product_id', 'id');
    }

    /**
     * Relation with Favorite model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany('App\Models\Favorite', 'product_id', 'id');
    }

    /**
     * Relation with Wishlist model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'product_id', 'id');
    }

    /**
     * Foreign key with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Foreign key with Brand model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    /**
     * Foreign key with Brand model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'product_id');
    }

    /**
     * Foreign key with Shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('Modules\Shop\Http\Models\Shop', 'shop_id');
    }

    /**
     * Scopes
     */
    public function scopeNotVariation($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopePublished($query)
    {
        return $query->where('status', ProductStatus::$Published);
    }

    public function scopeIsAvailable($query)
    {
        return $query->where(
            function ($q) {
                $q->where('available_from', '<=', now())->orWhere('available_from', null);
            }
        )->where(
            function ($q) {
                $q->where('available_to', null)->orWhere('available_to', '>=', now());
            }
        );
    }

    public function scopeIsActiveVendor($query)
    {
        $query->whereHas('vendor', function ($q) {
            $q->where('status', 'Active');
        })->orWhere('vendor_id', null);
    }

    public function incrementTotalStocks($quantity = 0)
    {
        $this->increment('total_stocks', $quantity);
    }

    public function decrementTotalStocks($quantity = 0)
    {
        $this->decrement('total_stocks', $quantity);
    }

    public function isVariation()
    {
        return $this->attributes['parent_id'] != null;
    }

    /**
     * Updates Product View Count
     *
     * @return void
     */
    public function updateViewCount()
    {
        $this->updateProductViewCount();
        $this->updateCategoryViewCount();
    }

    public function updateProductViewCount()
    {
        DB::statement('
            INSERT INTO product_stats (`product_id`,`count_views`,`date`) VALUES (' . $this->attributes['id'] . ', 1, CURDATE()) ON DUPLICATE KEY UPDATE count_views = count_views + 1;
        ');
    }

    public function updateCategoryViewCount()
    {
        $category_id = $this->productCategory->category_id;

        if ($category_id) {
            DB::statement('
                INSERT INTO category_stats (`category_id`,`count_views`,`date`) VALUES (' . $category_id . ', 1, CURDATE()) ON DUPLICATE KEY UPDATE count_views = count_views + 1;
            ');
        }
    }

    public function updateCategorySalesCount()
    {
        $category_id = $this->productCategory->category_id;

        if ($category_id) {
            DB::statement('
                INSERT INTO category_stats (`category_id`,`count_sales`,`date`) VALUES (' . $category_id . ', 1, CURDATE()) ON DUPLICATE KEY UPDATE count_sales = count_sales + 1;
            ');
        }
    }

    /**
     * Find product wishlist
     *
     * @param int productId
     * @return bool
     */
    public function isWishlist($productId, $userId)
    {
        return Wishlist::where('product_id', $productId)->where('user_id', $userId)->count() > 0 ? 1 : 0;
    }

    /**
     * Find product average rating
     *
     * @param int productId
     * @return float
     */
    public function rating($productId)
    {
        return round(Review::where('product_id', $productId)->where('status', 'Active')->where('is_public', 1)->avg('rating'), 1);
    }

    /**
     * Find product review count
     *
     * @param int productId
     * @return int
     */
    public function reviewCount($productId)
    {
        return Review::where('product_id', $productId)->where('status', 'Active')->where('is_public', 1)->count();
    }

    /**
     * Best seller product
     *
     * @param  int limit
     * @return collection
     */
    public static function bestSeller($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->bestSeller()->get();
    }

    /**
     * Popular products
     *
     * @param  int limit
     * @return collection
     */
    public static function popularProducts($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->popularProducts()->get();
    }

    /**
     * Feature products
     *
     * @param  int limit
     * @return collection
     */
    public static function featureProducts($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->featureProducts()->get();
    }

    /**
     * New arrival products
     *
     * @param  int limit
     * @return collection
     */
    public static function newArrivals($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->newArrivals()->get();
    }

    /**
     * Best deals of the week
     *
     * @param  int limit
     * @return collection
     */
    public static function bestDeals($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->bestDeals()->get();
    }

    /**
     * Flash sale product
     *
     * @param  int limit
     * @return collection
     */
    public static function flashSales($limit = null)
    {
        return self::getProductCategorizer()
            ->setLimit(self::getLimit($limit))
            ->flashSales()->get();
    }

    /**
     * Flash sale product
     *
     * @param  null
     * @return collection
     */
    public static function recentView()
    {
        $recentId = auth()->user() ? auth()->user()->id : request()->server('HTTP_USER_AGENT');
        $productIds = cache()->get($recentId);
        $data = [];
        if (! empty($productIds)) {
            arsort($productIds);
            $productIds = ! empty($productIds) ? array_flip($productIds) : [];
            $ids = implode(',', $productIds);
            $data = Product::select('id', 'name', 'code', 'slug')->whereIn('id', $productIds)
                ->orderBy(\DB::raw("FIELD(id, $ids)"))->get();
        }

        return $data;
    }

    public static function queryProducts($limit = null, $data = [])
    {
        // custom query products
        return (new BuilderQueryService(self::getLimit($limit), $data))->get();
    }

    /**
     * @return mixed
     */
    public static function cartStoreValidation($data = [])
    {
        $validator = Validator::make($data, [
            'code' => 'required|exists:products,code',
            'variation_id' => 'nullable|exists:products,id',
        ]);

        return $validator;
    }

    /**
     * @return mixed
     */
    public static function cartIndexValidation($data = [])
    {
        $validator = Validator::make($data, [
            'cartIndex' => 'required',
        ]);

        return $validator;
    }

    /**
     * @return mixed
     */
    public static function cartShippingIndexValidation($data = [])
    {
        $validator = Validator::make($data, [
            'shipping_index' => 'required',
        ]);

        return $validator;
    }

    /**
     * @return mixed
     */
    public static function couponIndexValidation($data = [])
    {
        $validator = Validator::make($data, [
            'index' => 'required',
        ]);

        return $validator;
    }

    /**
     * @return mixed
     */
    public static function cartSelectedValidation($data = [])
    {
        $validator = Validator::make($data, [
            'id' => 'array',
        ]);

        return $validator;
    }

    /**
     * @return mixed
     */
    public static function cartCouponValidation($data = [])
    {
        $validator = Validator::make($data, [
            'discount_code' => 'required',
        ]);

        return $validator;
    }

    /**
     * @return float|int
     */
    public static function positiveRating($vendorId = null, $id = null)
    {
        $result = 0;
        $reviews = Review::where('status', 'Active');
        if ($vendorId != null) {
            $reviews->whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product');
        } else {
            $reviews->where('product_id', $id);
        }

        $totalReview = $reviews->count();
        if ($totalReview > 0) {
            $sumRating = $reviews->sum('rating');
            $result = ($sumRating / ($totalReview * 5)) * 100;
        }

        return $result > 0 ? round($result) : 100;
    }

    /**
     * Return the maximum limit
     *
     * @param  int|null  $limit
     * @return int
     */
    public static function getLimit($limit = null)
    {
        return $limit && $limit > 0 ? $limit : self::$limit;
    }

    /**
     * Returns Product categorizing service
     *
     * @return ProductCategorizingService
     */
    public static function getProductCategorizer()
    {
        return new ProductCategorizingService();
    }

    /**
     * Fill in the variations attribute data
     *
     * @return array
     */
    public function getAttributeMeta($keys = null)
    {
        if (! $keys) {
            $parentAttributes = ProductMeta::where('product_id', $this->parent_id)->where('key', 'attributes')->first()->value;
            if ($parentAttributes) {
                $keys = array_keys($parentAttributes);
            }
        }

        if (! $this->metaFetched) {
            $this->getMeta();
        }

        $attributes = [];

        foreach ($keys as $key) {

            if (isset($this->metaArray['attribute_' . $key])) {
                $attributes['attribute_' . $key] = $this->metaArray['attribute_' . $key];
            }
        }

        $this->attributes['attributes'] = $attributes;

        return $attributes;
    }

    /**
     * check shop selectable or not
     *
     * @param  $shopId
     * @return bool
     */
    public static function isVendorSelected($vendorId = null)
    {
        $cartData = Cart::cartCollection()->where('vendor_id', $vendorId);
        $cartKey = [];
        foreach ($cartData as $key => $data) {
            $product = Product::where('id', $data['id'])->published()->isAvailable()->first();
            if (! empty($product)) {
                continue;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the product is eligible for deletion action
     *
     * @return bool
     */
    public function isEligibleForDelete()
    {
        return true;
    }

    /**
     * Check if the product is a variable product of not
     *
     * @return bool
     */
    public function isVariableProduct()
    {
        return $this->attributes['type'] == ProductType::$Variable;
    }

    /**
     * Check if the product is a variable product of not
     *
     * @return bool
     */
    public function isSimpleProduct()
    {
        return $this->attributes['type'] == ProductType::$Simple;
    }

    /**
     * Check if the product is a variable product of not
     *
     * @return bool
     */
    public function isExternalProduct()
    {
        return $this->attributes['type'] == ProductType::$External;
    }

    /**
     * Check if the product is a variable product of not
     *
     * @return bool
     */
    public function isGroupedProduct()
    {
        return $this->attributes['type'] == ProductType::$Grouped;
    }

    /**
     * check inventory & reduce from total stock after order
     *
     * @return bool
     */
    public function checkInventory($orderQty = 0, $backOrder = 0, $statusSlug = null)
    {
        $stockReduceData = ['processing', 'completed', 'on-hold'];

        if ($this->isStockManageable() == 1) {
            if ($this->getStockQuantity() >= $orderQty || $backOrder == 1) {
                if (in_array($statusSlug, $stockReduceData) || preference('hold_stock') > 0) {
                    $this->decrementTotalStocks($orderQty);
                }
            } else {
                return false;
            }
        } elseif ($this->type == 'Variation') {
            if (optional($this->parentDetail)->isStockManageable() == 1) {
                if (optional($this->parentDetail)->getStockQuantity() >= $orderQty || $backOrder == 1) {
                    if (in_array($statusSlug, $stockReduceData) || preference('hold_stock') > 0) {
                        optional($this->parentDetail)->decrementTotalStocks($orderQty);
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * get is stock reduceable or not
     *
     * @return int
     */
    public function isStockReduce($statusSlug = null)
    {
        $stockReduceData = ['processing', 'completed', 'on-hold'];

        if ($this->isStockManageable() == 1) {
            if (in_array($statusSlug, $stockReduceData) || preference('hold_stock') > 0) {
                return 1;
            }
        } elseif ($this->type == 'Variation' && optional($this->parentDetail)->isStockManageable() == 1) {
            if (in_array($statusSlug, $stockReduceData) || preference('hold_stock') > 0) {
                return 1;
            }
        }

        return 0;
    }

    /**
     * variant min max price
     *
     * @return array|void
     */
    public function variantMaxMinPrice()
    {
        $price = 0;
        $min = 0;
        $max = 0;
        if ($this->isVariableProduct()) {
            foreach ($this->getVariations() as $variation) {
                if ($variation->status == ProductStatus::$Published) {
                    $offerFlag = $variation->offerCheck();
                    $price = $offerFlag ? $variation->priceWithTax(preference('display_price_in_shop'), 'sale', false) : $variation->priceWithTax(preference('display_price_in_shop'), 'regular', false);
                    $min = $price < $min || $min == 0 ? $price : $min;
                    $max = $price > $max || $max == 0 ? $price : $max;
                }
            }

            return [
                'min' => $min,
                'max' => $max,
            ];
        }
    }

    /**
     * calculate price with tax
     *
     * @return array|float|int|mixed|string
     */
    public function priceWithTax($displayPrice, $type, $isFormated = true, $tempPriceReturnOnly = false, $isProductized = false, $addressId = null, $shipping = 0, $params = [])
    {
        if (isset($params['totalPrice'])) {
            $price = $params['totalPrice'];
        } elseif (isActive('B2B') && isset($params['cart_price'])) {
            $price = $params['cart_price'];
        } else {
            $price = $type == 'sale' ? $this->sale_price : $this->regular_price;
        }

        $tempPrice = 0;
        if ($displayPrice == 'including tax' && preference('taxes') == 1) {
            $shippingTaxClass = preference('shipping_tax_class');
            $address = $this->getAddress($addressId);

            if (! empty($this->taxMeta()) && ! is_null($address)) {
                $taxes = $this->taxMeta();
                $tax = TaxClass::where('slug', $taxes->value)->first();
                if (! empty($tax)) {
                    $taxCalculate = new TaxCalculation($tax->taxRates()->orderBy('priority', 'ASC')->get(), $price, $address, $isProductized, $shipping, $params['qty'] ?? 1, $shippingTaxClass);
                    $tempPrice = $taxCalculate->calculateTax();

                    if ($shippingTaxClass != 'shipping tax class base on cart items') {
                        $taxShipping = TaxClass::where('slug', $shippingTaxClass)->first();

                        if (! empty($taxShipping)) {
                            $taxCalculate->setTaxes($taxShipping->taxRates()->orderBy('priority', 'ASC')->get());
                            $tempPriceShipping = $taxCalculate->calculateShippingTax();

                            if (is_array($tempPriceShipping) && is_array($tempPrice)) {
                                $tempPrices = [];

                                foreach ($tempPrice as $key => $temp) {
                                    if (isset($tempPriceShipping[$key])) {
                                        $tempPrices[$key] = $temp + $tempPriceShipping[$key];
                                        unset($tempPriceShipping[$key]);
                                    } else {
                                        $tempPrices[$key] = $temp;
                                    }
                                }

                                $tempPrice = array_merge($tempPrices, $tempPriceShipping);
                            } else {
                                $tempPrice = $tempPrice + $tempPriceShipping;
                            }
                        }
                    }
                }
            }
        }

        if ($isProductized) {
            return $tempPrice;
        }
        if ($tempPriceReturnOnly) {
            return $tempPrice;
        }

        return $isFormated ? formatNumber($price + $tempPrice) : $price + $tempPrice;
    }

    /**
     * get address data
     *
     * @return mixed|null
     */
    public function getAddress($addressId = null)
    {
        $calculateTaxSetting = preference('calculate_tax');
        $address = null;

        if ($calculateTaxSetting == 'customer billing address' && ! isset(request()->ship_different) || $calculateTaxSetting == 'customer billing address' && is_numeric($addressId) || $calculateTaxSetting == 'customer billing address' && is_object($addressId)) {
            $defaultAddress = null;
            if (! is_object($addressId)) {
                $userId = Cart::userId();
                if (is_null($addressId) && isset($userId)) {
                    $defaultAddress = Address::getAll()->where('user_id', $userId)->where('is_default', 1)->first();
                } elseif (! is_null($addressId)) {
                    $defaultAddress = Address::getAll()->where('id', $addressId)->first();
                }
            } elseif (is_object($addressId)) {

                if (isset(request()->city)) {
                    $shipDiffAddress = ['country' => request()->country, 'state' => request()->state, 'city' => request()->city, 'post_code' => request()->zip];
                    $addressId = (object) $shipDiffAddress;
                } elseif (isset(request()->address['billing_city'])) {
                    $shipDiffAddress = ['country' => request()->address['billing_country'], 'state' => request()->address['billing_state'], 'city' => request()->address['billing_city'], 'post_code' => request()->address['billing_zip']];
                    $addressId = (object) $shipDiffAddress;
                }

                $defaultAddress = $addressId;
            }
            $address = ! empty($defaultAddress) ? $defaultAddress : null;
        } elseif ($calculateTaxSetting == 'customer shipping address' && is_object($addressId) && isset(request()->ship_different) && request()->ship_different == 'on'
            || $calculateTaxSetting == 'customer shipping address' && is_object($addressId) && isset(request()->address['ship_different']) && request()->address['ship_different'] == 'on') {
            $address = $addressId;
        } elseif ($calculateTaxSetting == 'base address') {
            $companyAddress = [
                'country' => preference('company_country'),
                'state' => preference('company_state'),
                'city' => preference('company_city'),
                'post_code' => preference('company_zip_code'),
            ];

            $address = (object) $companyAddress;
        }

        return $address;
    }

    /**
     * get shipping
     *
     * @return array|void|null
     */
    public function shipping($params = [])
    {
        $calculateShippingSetting = preference('shipping_destination');
        if (! $this->isVirtual() && ! $this->isExternalProduct() && ! $this->isGroupedProduct()) {

            if (in_array($calculateShippingSetting, ['billing_address', 'force_billing_address']) ||
                $calculateShippingSetting == 'shipping_address' && isset(request()->address['ship_different']) && request()->address['ship_different'] == 'on' ||
                $calculateShippingSetting == 'shipping_address' && isset(request()->ship_different) && request()->ship_different == 'on') {
                $defaultAddress = $params['address'] ?? null;
                $userId = Cart::userId();

                if (isset($userId) && is_null($defaultAddress)) {
                    $defaultAddress = Address::getAll()->where('user_id', $userId)->where('is_default', 1)->first();
                } elseif (! is_object($defaultAddress)) {
                    $defaultAddress = Address::getAll()->where('id', $defaultAddress)->first();
                }

                $shippingZones = ShippingZoneShippingClass::where('shipping_class_slug', $this->meta_shipping_id)->get();
                $shippingData = [];

                foreach ($shippingZones as $zone) {

                    if (! empty($zone)) {
                        $shipping  = new ShippingCalculation($zone, $defaultAddress, $params['qty'], $params['from'] ?? null, $params['price'] ?? 0);
                        $shippingData = $shipping->calculateShipping();

                        if (is_array($shippingData) && count($shippingData) > 0) {
                            return $shippingData;
                        }
                    }
                }

                return $shippingData;
            }
        }

        return [];
    }

    /**
     * @return float|int
     */
    public function getDiscountAmount()
    {
        if ($this->regular_price > 0) {
            return (($this->regular_price - $this->sale_price) * 100) / $this->regular_price;
        }

        return 0;
    }

    /**
     * get max shipping
     *
     * @return array|int[]
     */
    public static function getMaxShipping($id = null, $address = null)
    {
        $product = Product::where('id', $id)->first();

        if ($address == null) {
            $shipping = $product->shipping(['price' => $product->offerCheck() ? $product->sale_price : $product->regular_price, 'qty' => 1, 'from' => 'order']);
        } else {
            $shipping = $product->shipping(['price' => $product->offerCheck() ? $product->sale_price : $product->regular_price, 'qty' => 1, 'address' => (object) $address, 'from' => 'order']);
        }

        if (is_array($shipping) && count($shipping) > 0) {

            return [
                'status' => 1,
                'name' => array_search(max($shipping), $shipping),
                'amount' => max($shipping),
            ];
        }

        return [
            'status' => 0,
        ];
    }

    /**
     * vendor review
     *
     * @return array
     */
    public function vendorReview()
    {
        $vendorId = $this->vendor_id;
        if ($vendorId != null) {
            $reviews = Review::where('status', 'Active');
            $reviews->whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('product');

            return [
                'total_review' => $reviews->count(),
                'avg_rating' => $reviews->avg('rating'),
            ];
        }

        return [];
    }

    /**
     * Types of product categorizations available
     *
     * @return array
     */
    public static function productCategoryOptions()
    {
        return [
            'popularProducts' => __('Most Popular'),
            'featureProducts' => __('Featured Products'),
            'newArrivals' => __('New Arrivals'),
            'bestSeller' => __('Best Seller'),
            'flashSales' => __('Flash Sales'),
            'queryProducts' => __('Custom Filter'),
        ];
    }

    public static function getFillableData()
    {
        return (new static())->getFillable();
    }

    /**
     * get wishlist id
     *
     * @param  $productId
     * @return bool|null
     */
    public function wishListId($userId = null)
    {
        if (! is_null($userId)) {
            $wishlist = Wishlist::where('product_id', $this->id)->where('user_id', $userId)->first();
            if (! empty($wishlist)) {
                return $wishlist->id;
            }
        }

        return null;
    }
}
