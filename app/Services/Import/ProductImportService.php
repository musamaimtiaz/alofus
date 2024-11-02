<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 19-11-2022
 */

namespace App\Services\Import;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductMeta;
use App\Services\Import\Dependencies\Category;
use App\Services\Import\Dependencies\CrossSell;
use App\Services\Import\Dependencies\TagDependency;
use App\Services\Import\Dependencies\Upsell;
use Illuminate\Http\Request;

class ProductImportService extends ImportService
{
    protected $fieldMap = [
        'ID' => 'id',
        'Type' => 'type',
        'SKU' => 'sku',
        'Name' => 'name',
        'Title' => 'name',
        'Published' => 'published',
        'Is featured?' => 'featured',
        'Short description' => 'summary',
        'Description' => 'description',
        'Date sale price starts' => 'sale_from',
        'Date sale price ends' => 'sale_to',
        'Tax class' => 'meta_tax_classes',
        'In stock?' => 'meta_stock_status',
        'Low stock amount' => 'meta_stock_threshold',
        'Stock' => 'total_stocks',
        'Backorders allowed?' => 'meta_backorder',
        'weight' => 'meta_weight',
        'length' => 'metadimensionlength',
        'width' => 'metadimensionwidth',
        'height' => 'metadimensionheight',
        'Allow customer reviews?' => 'meta_allow_review',
        'Purchase note' => 'meta_purchase_note',
        'Sale price' => 'sale_price',
        'Regular price' => 'regular_price',
        'Shipping class' => 'meta_shipping_id',
        'Images' => 'meta_image',
        'Parent' => 'parent_id',
        'Upsells' => 'upsells',
        'Cross-sells' => 'cross_sells',
        'Categories' => 'categories',
        'Tags' => 'tags',
        'attributename' => 'attributetitle',
        'attributevalue' => 'attributevalue',
        'attributevisible' => 'attributevisibility',
        'attributeglobal' => 'attributevariation',
        'attributedefault' => 'attributedefault',
        'downloadid' => 'downloadableid',
        'downloadname' => 'downloadablename',
        'downloadurl' => 'downloadableurl',
        'Sold individually?' => 'meta_individual_sale',
        'Download limit' => 'meta_download_limit',
        'Allow customer reviews?' => 'meta_enable_reviews',
        'externalurl' => 'metaexternalproducturl',
        'buttontext' => 'metaexternalproducttext',
        'Grouped products' => 'meta_grouped_products',
    ];

    protected $importableFields = [];

    protected $meta = [];

    protected $categoryService;

    protected $tagService;

    protected $upsellService;

    protected $crossSellService;

    /**
     * Contains insertable product_categories table data
     *
     * @var array
     */
    protected $categories  = [];

    /**
     * Contains insertable product_tags table data
     *
     * @var array
     */
    protected $tags  = [];

    /**
     * Remembers product's group
     *
     * @var array
     */
    protected $groupedProducts = [];

    protected $parentProducts = [];

    protected $variationProducts = [];

    protected $parentIds = [];

    protected $codeBindings = [];

    protected $skus = [];

    protected $slugs = [];

    protected $upsells = [];

    protected $crossSells = [];

    protected $skuBindings = [];

    protected $parentProductIds = [];

    protected $stored = [];

    public $totalUploaded = 0;

    public $totalSkipped = 0;

    public $totalVariations = 0;

    protected $idFootPrints = [];

    protected $arrayableFields = ['attribute' => true, 'downloadable' => true, 'meta_dimension' => true, 'meta_external_product' => true];

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->categoryService = new Category();
        $this->tagService = new TagDependency();

        $this->upsellService = new Upsell();

        $this->crossSellService = new CrossSell();
    }

    /**
     * Process step 1 of import steps
     *
     * @return self
     */
    public function importerStep1()
    {
        if ($this->loadFile('csv') === false) {
            return false;
        }

        $this->fieldMapUpdate();

        $this->setSession('product-file', $this->getFilePath());

        $headers = $this->getDataHeaders();

        $relations = $this->fieldMap;

        $fieldMap = $this->mappingHeaders();

        $step = 2;

        $exampleData = $this->readFirstColumn();

        if (count($exampleData) <= 1) {
            $this->setError(__('Something went wrong, please try again.'));

            return false;
        }

        $this->setResponse(view($this->getViewAndRoute('admin.epz.import.product'), compact('headers', 'fieldMap', 'relations', 'exampleData', 'step')));

        return $exampleData ? $this : false;
    }

    /**
     * Process second step of product import from wordress
     *
     * @return self
     */
    public function importerStep2()
    {
        // check if the data file has loaded
        if ($this->loadSessionFile('product-file') === false) {
            return false;
        }

        $columns = $this->getColumns();
        // check if the columns mapping failed
        if ($columns === false) {
            return false;
        }
        // Process the import data
        $this->processImportableData($columns, 'processBatchStore');

        // Store upsell and cross-sell data
        $this->storeUpsellCrossSell();

        // Clear cache for attribute
        Attribute::forgetCache();
        Attribute::forgetCache('attribute_values');

        // Set user response for the next step
        $this->setResponse(view($this->getViewAndRoute('admin.epz.import.product'), [
            'step' => 3,
            'products' => $this->totalUploaded,
            'variations' => $this->totalVariations,
            'skipped' => $this->totalSkipped,
        ]));

        return $this;
    }

    /**
     * Process products in batches
     *
     * @return void
     */
    protected function processBatchStore($body)
    {
        $filtered = $this->applyFilters($body, 'attachCode', 'splitProduct');

        // handle dependencies of the products
        $this->dependencyHandler($filtered);

        // store parent products first
        $this->storeParentProducts();

        isActive('Subscription') && subscription('sellerProductCount');

        // store variations
        $this->storeChildProducts();

        // reset the container for next batch of products
        $this->resetForNextBatch();
    }

    /**
     * Reset the class properties for next batch of products
     *
     * @return void
     */
    protected function resetForNextBatch()
    {
        $newSkus = array_values($this->skuBindings);

        $newSkus = array_flip($newSkus);

        $this->skus = array_merge($this->skus, $newSkus);

        $this->parentProducts = [];

        $this->variationProducts = [];

        $this->meta = [];
    }

    /**
     * Stores parent products
     *
     * @return void
     */
    protected function storeParentProducts()
    {
        $allInfo = $this->parentProducts;
        // pick only the data which are fillable for the model
        $parentProducts = $this->sortFillableData($allInfo);

        foreach ($parentProducts as $key => $product) {
            $product = $this->storeSingleProduct($product);

            if ($product == false) {
                $this->totalSkipped++;

                continue;
            }

            $product['upsell'] = $allInfo[$key]['upsells'] ?? '';
            $product['cross_sell'] = $allInfo[$key]['cross_sells'] ?? '';

            $this->totalUploaded++;
            $this->storeRelatedInformation($product);
        }
    }

    /**
     * Store variation/child products
     *
     * @return void
     */
    protected function storeChildProducts()
    {
        $products = $this->sortFillableData($this->variationProducts);

        foreach ($products as $product) {
            $parentId = $this->getParentProductId($product['parent_id']);
            // check if the product id is found
            if ($parentId == false) {
                continue;
            }

            $this->totalVariations++;

            $product['parent_id'] = $parentId;

            $product = $this->storeSingleProduct($product);

            if ($product == false) {
                continue;
            }

            $this->storeRelatedInformation($product);
        }
    }

    /**
     * Store product related data
     *
     * @return void
     */
    protected function storeRelatedInformation($product)
    {
        $this->storeMetadata($product);

        $this->storeCategories($product);

        $this->storeTags($product);

        $this->manageUpsellCrossSell($product);
    }

    /**
     * Stores meta data
     *
     * @param  Product  $product
     * @return bool
     */
    protected function storeMetadata($product)
    {
        $this->attachGroupedProductToMeta($product);

        $meta = isset($this->meta[$product->code]) ? $this->meta[$product->code] : false;

        if ($meta == false) {
            return false;
        }

        $storableMeta = [];

        $productId = $product->id;

        try {
            foreach ($meta as $metaName => $metaValue) {
                $storableMeta[] = [
                    'product_id' => $productId,
                    'key' => $metaName,
                    'value' => is_array($metaValue) ? json_encode($metaValue) : $metaValue,
                    'type' => gettype($metaValue),
                ];
            }

            ProductMeta::upsert($storableMeta, ['product_id', 'key'], ['value', 'type']);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Organize upsale and cross sell data
     *
     * @param  Product  $product
     * @return void
     */
    private function manageUpsellCrossSell($product)
    {
        $this->upsells[] = [$product->id => $product->upsell];

        $this->crossSells[] = [$product->id => $product->cross_sell];
    }

    /**
     * Store upsell and cross sell
     *
     * @param  Product  $product
     * @return void
     */
    private function storeUpsellCrossSell()
    {
        $this->upsellService->process($this->upsells);

        $this->crossSellService->process($this->crossSells);
    }

    /**
     * Attach grouped products to the product meta
     *
     * @param  Product  $product
     * @return void
     */
    public function attachGroupedProductToMeta($product)
    {
        $grouped = $this->groupedProducts[$product->code] ?? [];

        if (count($grouped) == 0) {
            return;
        }

        $foreignProducts = $localProducts = [];

        foreach ($grouped as $sku) {
            if (isset($this->stored[$sku])) {
                array_push($localProducts, $this->stored[$sku]);
            } else {
                array_push($foreignProducts, $sku);
            }
        }

        if (count($foreignProducts) > 0) {
            $foreignProductsIds = optional(Product::select('id')->where(function ($query) use ($foreignProducts) {
                $query->whereIn('sku', $foreignProducts);
            })->orWhere(function ($query) use ($foreignProducts) {
                $query->whereIn('slug', $foreignProducts);
            })->get())->pluck('id')->toArray();
        }

        if (isset($foreignProductsIds) && is_array($foreignProductsIds)) {
            $localProducts = array_merge($localProducts, $foreignProductsIds);
        }

        if (! isset($this->meta[$product->code])) {
            $this->meta[$product->code] = [];
        }

        // push grouped products to meta data
        $this->meta[$product->code]['meta_grouped_products'] = $localProducts;
    }

    /**
     * Stores related categories
     *
     * @return bool
     */
    protected function storeCategories($product)
    {
        $categories = isset($this->categories[$product->code]) ? $this->categories[$product->code] : false;

        if ($categories == false) {
            return false;
        }

        return $product->category()->sync($categories);
    }

    /**
     * Stores related tags
     *
     * @return bool
     */
    protected function storeTags($product)
    {
        $tags = isset($this->tags[$product->code]) ? $this->tags[$product->code] : false;

        if ($tags === false) {
            return false;
        }

        return $product->tags()->sync($tags);
    }

    /**
     * Get parent id from sku
     *
     * @param  string  $parentId  SKU of parent
     * @param bool|int
     */
    protected function getParentProductId($parentId)
    {
        if (str_starts_with($parentId, 'id:')) {
            $parentId = isset($this->idFootPrints[$parentId]) ? $this->idFootPrints[$parentId] : $parentId;
        } else {
            $parentId = $this->getUpdatedSku($parentId);
        }

        return isset($this->stored[$parentId]) ? $this->stored[$parentId] : false;
    }

    /**
     * Get the updated sku of given sku
     *
     * @param  string  $sku
     * @return string
     */
    protected function getUpdatedSku($code)
    {
        return isset($this->skuBindings[$code]) ? $this->skuBindings[$code] : $code;
    }

    /**
     * Detach all the data from product array which are not fillable
     *
     * @param  array  $products
     * @return array
     */
    protected function sortFillableData($products)
    {
        $fillable = Product::getFillableData();

        $fillable = array_flip($fillable);

        for ($i = 0; $i < count($products); $i++) {
            $product = array_intersect_key($products[$i], $fillable);
            foreach ($product as $key => $value) {
                if ($value == '') {
                    $product[$key] = null;
                }
            }
            $products[$i] = $product;
        }

        return $products;
    }

    /**
     * Stores single product
     *
     * @param  array  $product  Product data array
     * @return bool/Model
     */
    protected function storeSingleProduct($product)
    {
        try {
            $product = Product::create($product);
            $this->stored[$product->code] = $product->id;
            if ($product->sku) {
                $this->stored[$product->sku] = $product->id;
            }

            return $product;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Handles product dependencies
     *
     * @return void
     */
    protected function dependencyHandler(&$data)
    {
        foreach ($data as $key => $product) {
            // Handle Categories
            $categories = $this->handleCategory($product);

            $this->categories[$data[$key]['code']] = $categories;
            unset($data[$key]['categories']);

            // Handle tags
            $tags = $this->handleTags($product);
            $this->tags[$data[$key]['code']] = $tags;
            unset($data[$key]['tags']);
        }
    }

    /**
     * Generates array of category id
     *
     * @return array
     */
    protected function handleCategory($data)
    {
        $category = $this->categoryService->process($data['categories'] ?? null);

        unset($data['categories']);

        return $category;
    }

    /**
     * Generates array of tags id
     *
     * @return array
     */
    public function handleTags($data)
    {
        $tags = $this->tagService->process($data['tags'] ?? '');

        unset($data['tags']);

        return $tags;
    }

    protected function filterVendorId($data)
    {
        $data['vendor_id'] = null;

        return $data;
    }

    /**
     * Filters featured column
     *
     * @return array
     */
    protected function filterFeatured($data)
    {
        $data['featured'] = isset($data['featured']) && $data['featured'] == 1 ? now() : null;

        return $data;
    }

    /**
     * Filters status column
     *
     * @return array
     */
    protected function filterStatus($data)
    {
        if ($this->hasParentId($data)) {
            $data['status'] = ProductStatus::$Published;
        } else {
            $data['status'] = isset($data['published']) && $data['published'] == 1 ? ProductStatus::$Published : ProductStatus::$Draft;
        }

        return $data;
    }

    protected function filterIdFootprint($data)
    {
        if (isset($data['id'])) {
            $this->idFootPrints['id:' . $data['id']] =  $data['code'];
            unset($data['id']);
        }

        return $data;
    }

    /**
     * Splits the product list into parent and variation lists
     * Also create a parent child dependency array
     *
     * @param  array  $data
     * @return array
     */
    protected function splitProduct($data)
    {
        if ($this->hasParentId($data)) {
            // dependent
            $this->variationProducts[] = $data;
            $this->parentIds[$data['code']] = $data['parent_id'];
        } else {
            // independent
            $this->parentProducts[] = $data;
            $data['parent_id'] = null;
        }

        return $data;
    }

    /**
     * Attaches Unique data
     *
     * @return array
     */
    protected function attachCode($data)
    {
        $data['code'] = $data['code'] ?? \Str::random(5) . uniqid();

        return $data;
    }

    /**
     * Filters product type
     *
     * @param  array  $data
     * @return array
     */
    protected function filterType($data)
    {
        $typeArray = array_map('trim', explode(',', $data['type'] ?? ''));

        $replacables = [
            'variable' => ProductType::$Variable,
            'variation' => ProductType::$Variation,
            'grouped' => ProductType::$Grouped,
            'external' => ProductType::$External,
        ];

        // Attach meta types
        $typeMeta = [];

        if (in_array('downloadable', $typeArray)) {
            $typeMeta['meta_downloadable'] = true;
        }

        if (in_array('virtual', $typeArray)) {
            $typeMeta['meta_virtual'] = true;
        }

        $this->meta[$data['code']] = $typeMeta;

        $data['type'] = ProductType::$Simple;

        foreach ($replacables as $current => $replacement) {
            if (in_array($current, $typeArray)) {
                $data['type'] = $replacement;

                break;
            }
        }

        return $data;
    }

    public function filterStocks($data)
    {
        if (! isset($data['total_stocks']) || empty($data['total_stocks'])) {
            $data['total_stocks'] = 0;
        }

        return $data;
    }

    /**
     * Filters product name
     *
     * @param  array  $data
     * @return array
     */
    protected function filterName($data)
    {
        if (! isset($data['name']) || trim($data['name']) == '') {
            $data['name'] = 'Untitled Product';
        }

        return $data;
    }

    /**
     * Handles sku and slug
     */
    protected function filterSkuAndSlug($data)
    {
        if (! $this->hasParentId($data)) {
            if (! $this->hasSlug($data)) {
                $data['slug'] = \Str::slug($data['name'], '-', null);
            }

            $slug = $data['slug'];

            $this->prefetchSlugs($slug);

            $slug = $this->generateSlug($slug);

            $data['slug'] = $slug;
        }

        if ($this->hasSku($data)) {

            $sku = $this->generateSku($data['sku']);

            if ($sku != $data['sku']) {
                $this->skuBindings[$data['sku']] = $sku;
            }

            $data['sku'] = $sku;
        }

        return $data;
    }

    /**
     * Checks if the product has parent id
     */
    protected function hasParentId($product)
    {
        return isset($product['parent_id']) && (trim($product['parent_id']) != '' || $product['parent_id'] != null);
    }

    /**
     * Checks if the product has either sku or slug
     */
    private function hasSkuOrSlug($product)
    {
        return $this->hasSku($product) || $this->hasSlug($product);
    }

    /**
     * Checks if the product data has SKU
     *
     * @return bool
     */
    private function hasSku($product)
    {
        return isset($product['sku']) && (trim($product['sku']) == '' || $product['sku'] != null);
    }

    /**
     * Check if the product data has slug
     *
     * @return bool
     */
    private function hasSlug($product)
    {
        return isset($product['slug']) && (trim($product['slug']) == '' || $product['slug'] != null);
    }

    /**
     * Generates unique SKU
     *
     * @param  string  $sku
     * @return string
     */
    protected function generateSku($sku)
    {
        $sku = \Str::slug($sku, '-', null);
        $counter = 1;
        $ext = '';
        do {
            $newSku = $sku . $ext;
            $ext = '-' . $counter;
        } while (isset($this->skus[$newSku]) && $counter++);

        return $newSku;
    }

    /**
     * Generates unique slug
     *
     * @param  string  $slug
     * @return string
     */
    protected function generateSlug($slug)
    {
        $slug = \Str::slug($slug, '-', null);
        $counter = 1;
        $ext = '';
        do {
            $newSlug = $slug . $ext;
            $ext = '-' . $counter;
        } while (isset($this->slugs[$newSlug]) && $counter++);

        return $newSlug;
    }

    /**
     * Prefetch product slugs and skus to compare
     */
    private function prefetchSlugs($slug)
    {
        $products = Product::whereLike('slug', $slug)->orWhereLike('sku', $slug)->get();

        $products->map(function ($product) {
            if ($product->slug && ! isset($this->slugs[$product->slug])) {
                $this->slugs[$product->slug] = 1;
            }
            if ($product->sku && ! isset($this->skus[$product->sku])) {
                $this->skus[$product->sku] = 1;
            }
        });
    }

    /**
     * Check if the product's meta exists
     *
     * @param  string  $code  Products unique code
     * @return bool
     */
    protected function metaExists($code)
    {
        return isset($this->meta[$code]);
    }

    /**
     * Filter Date
     *
     * @param  array  $data
     * @return array $data
     */
    protected function filterDate($data)
    {
        $dates = ['sale_from', 'sale_to', 'available_from', 'available_to'];

        foreach ($dates as $date) {
            if (isset($data[$date]) && ! empty($data[$date])) {
                $data[$date] = DbDateFormat($data[$date]);
            }
        }

        return $data;
    }

    /**
     * Clean meta information from product data
     * Inject meta data into product data
     * Filter meta data
     *
     * This is a long method which can be splitted into separate method
     *
     * @param  array  $data
     * @return array
     */
    protected function filterMeta($data)
    {
        $meta = [];
        $stockStatus = $data['meta_stock_status'] ?? 0;
        $meta['meta_stock_status'] = $stockStatus == 1 ? 'In Stock' : ($stockStatus == 'backorder' ? 'On Backorder' : 'Out Of Stock');
        unset($data['meta_stock_status']);

        $meta['meta_stock_threshold'] = isset($data['meta_stock_threshold']) ? $data['meta_stock_threshold'] : '';
        unset($data['meta_stock_threshold']);

        $meta['meta_image'] = isset($data['meta_image']) ? array_filter(array_map('trim', explode(',', $data['meta_image']))) : '';
        unset($data['meta_image']);

        $meta['meta_enable_reviews'] = isset($data['meta_enable_reviews']) ? $data['meta_enable_reviews'] : '';
        unset($data['meta_enable_reviews']);

        $meta['meta_tax_classes'] = isset($data['meta_tax_classes']) ? $data['meta_tax_classes'] : '';
        unset($data['meta_tax_classes']);

        $meta['meta_shipping_id'] = isset($data['meta_shipping_id']) ? $data['meta_shipping_id'] : '';
        unset($data['meta_shipping_id']);

        $meta['meta_backorder'] = isset($data['meta_backorder']) ? $data['meta_backorder'] : '';
        unset($data['meta_backorder']);

        $meta['meta_cash_on_delivery'] = isset($data['meta_cash_on_delivery']) ? $data['meta_cash_on_delivery'] : '';
        unset($data['meta_cash_on_delivery']);

        $meta['meta_weight'] = isset($data['meta_weight']) ? $data['meta_weight'] : '';
        unset($data['meta_weight']);

        $meta['meta_dimension'] = isset($data['meta_dimension']) ? $data['meta_dimension'] : '';
        unset($data['meta_dimension']);

        $meta['meta_purchase_note'] = isset($data['meta_purchase_note']) ? $data['meta_purchase_note'] : '';
        unset($data['meta_purchase_note']);

        $meta['meta_external_product'] = $data['meta_external_product'] ?? '';

        $meta['meta_individual_sale'] = $data['meta_individual_sale'] ?? 0;
        unset($data['meta_individual_sale']);

        $meta['meta_download_limit'] = $data['meta_download_limit'] ?? 0;
        unset($data['meta_download_limit']);

        if (isActive('B2B')) {
            $meta['meta_enable_b2b'] = $data['meta_enable_b2b'] ?? 0;
            unset($data['meta_enable_b2b']);
        }

        // Inject meta data into product data
        // check if the product already has metadata
        // else create a blank meta data array
        // then insert new array
        if (! isset($this->meta[$data['code']])) {
            $this->meta[$data['code']] = [];
        }
        $this->meta[$data['code']] = array_merge($this->meta[$data['code']], $meta);

        return $data;
    }

    /**
     * Filter attribute
     */
    protected function filterAttribute($data)
    {
        if (! $this->hasParentId($data)) {
            $attributes =  $this->getAttributesFromProduct($data);
            if ($attributes) {
                $this->meta[$data['code']]['attributes'] = $attributes;
            }
        } else {
            $attributes = $this->getAttributeMetaFromProduct($data);
            if ($attributes) {
                $meta = array_merge($this->meta[$data['code']], $attributes);
                $this->meta[$data['code']] = $meta;
            }
        }
        unset($data['attribute']);

        return $data;
    }

    /**
     * filter B2B data
     *
     * @return void
     */
    protected function filterB2B($data)
    {
        if (isActive('B2B')) {
            $b2bData = $this->b2bDataFormat($data['bb'] ?? []);
            unset($data['bb']);
            // check if it has downloadable data
            if (count($b2bData) == 0) {
                return $data;
            }
            // check if product already has meta data
            // else create blank meta data array
            if (! isset($this->meta[$data['code']])) {
                $this->meta[$data['code']] = [];
            }
            // push downloadable data to meta array
            $this->meta[$data['code']]['meta_b2b_data'] = $b2bData;
        }

        return $data;
    }

    /**
     * b2b data format
     *
     * @return array
     */
    protected function b2bDataFormat($data)
    {
        if (! is_array($data)) {
            return [];
        }

        $formatted = [];

        foreach ($data as $index => $item) {
            if (isset($item['min']) && $item['min'] != '' || isset($item['max']) && $item['max'] != '' || isset($item['price']) && $item['price'] != '') {
                $formatted[] = [
                    'min_qty' => $item['min'] ?? '',
                    'max_qty' => $item['max'] ?? '',
                    'price' => $item['price'] ?? '',
                ];
            }
        }

        return $formatted;
    }

    /**
     * Filter downloadable data of the product
     *
     * @param  array  $data
     * @return array
     */
    protected function filterDownloadables($data)
    {
        $downloadables = $this->trimDownloadableData($data['downloadable'] ?? []);
        unset($data['downloadable']);
        // check if it has downloadable data
        if (count($downloadables) == 0) {
            return $data;
        }
        // check if product already has meta data
        // else create blank meta data array
        if (! isset($this->meta[$data['code']])) {
            $this->meta[$data['code']] = [];
        }
        // push downloadable data to meta array
        $this->meta[$data['code']]['meta_downloadable_files'] = array_values($downloadables);

        return $data;
    }

    /**
     * Filter grouped product data
     *
     * @param  array  $data
     * @return array
     */
    public function filterGroupedProducts($product)
    {
        $groupedProducts = $product['meta_grouped_products'] ?? [];
        if (! is_array($groupedProducts)) {
            $groupedProducts = array_filter(array_map('trim', explode(',', $groupedProducts)));
        }
        unset($product['meta_grouped_products']);
        // Return if the products doesn't have any grouped product
        if (count($groupedProducts) == 0) {
            return $product;
        }

        // Get the latest skus references
        $groupedProducts = array_map(function ($sku) {
            return $this->getUpdatedSku($sku);
        }, $groupedProducts);

        // push downloadable data to meta array
        $this->groupedProducts[$product['code']] = $groupedProducts;

        return $product;
    }

    /**
     * Trim downloadable files data
     *
     * @param  array  $data
     * @return array
     */
    private function trimDownloadableData($data)
    {
        if (! is_array($data)) {
            return [];
        }
        $trimmed = [];
        foreach ($data as $index => $item) {
            if (! isset($item['url']) || trim($item['url']) == '') {
                continue;
            }
            if (! isset($item['name']) || trim($item['name']) == '') {
                $item['name'] = 'File-' . $index;
            }
            array_push($trimmed, $item);
        }

        return $trimmed;
    }

    /**
     * Extracts attribute meta from product
     *
     * @param  array  $product
     * @return array;
     */
    private function getAttributeMetaFromProduct($product)
    {
        $attributes = [];

        if (! isset($product['attribute'])) {
            return false;
        }

        foreach ($product['attribute'] as $attribute) {

            $attribute = miniCollection($attribute, true);
            $slug = \Str::slug($attribute->title, '-', null);

            if ($attribute->variation != 1) {
                $attributes['attribute_' . $slug] = $attribute->value;

                continue;
            }
            $aValue = Attribute::where('name', $attribute->title)
                ->leftJoin('attribute_values', 'attributes.id', '=', 'attribute_values.attribute_id')
                ->where('attribute_values.value', $attribute->value)
                ->selectRaw('attributes.id as id, attribute_values.id as vid')
                ->first();

            $attributes['attribute_' . $slug] = $aValue ? $aValue->vid : '';
        }

        return $attributes;
    }

    /**
     * Extracts attribute from product
     *
     * @param  array  $product
     * @return bool|array;
     */
    private function getAttributesFromProduct($product)
    {
        $attributes = [];
        if (! isset($product['attribute'])) {
            return false;
        }

        foreach ($product['attribute'] as $index => $attribute) {
            $attribute = miniCollection($attribute, true);

            if (! $attribute->title) {
                continue;
            }

            $attribute->value = array_map('trim', explode(',', $attribute->value));

            if ($attribute->variation == 1) {
                $fetchAttribute =  Attribute::updateOrCreate(['name' => $attribute->title]);
                $attribute->value = $this->getAttributeValue($fetchAttribute->id, $attribute->value);
                $attribute->attributeId = $fetchAttribute->id;
            }

            $slug = \Str::slug($attribute->title, '-', null);

            $attribute = $this->checkAttributeValidity([
                'name' => $attribute->title,
                'position' => $index,
                'key' => $slug,
                'value' => $attribute->value ?? [],
                'variation' => $attribute->variation,
                'visibility' => $attribute->visibility,
                'attribute_id' => $attribute->attributeId,
            ]);

            if ($attribute) {
                $attributes[$slug] = $attribute;
            }
        }

        return $attributes;
    }

    /**
     * Checks if the attribute data is complete and usable
     *
     * @param  array  $attribute
     * @return bool|array
     */
    protected function checkAttributeValidity($attribute)
    {
        if (! isset($attribute['name']) || ! isset($attribute['value']) || ! isset($attribute['key'])) {
            return false;
        }

        return $attribute;
    }

    private function getAttributeFromSlug($name)
    {
        return Attribute::select('id', 'name')->whereName($name)->first();
    }

    /**
     * Store attribute values and returns their id
     *
     * @param  int  $attribute
     * @param  array  $values
     * @return array
     */
    private function getAttributeValue($attribute, $values)
    {
        $attributeValues = [];
        // Prepare insertable attribute values
        foreach ($values as $value) {
            $attributeValues[] = [
                'attribute_id' => $attribute,
                'value' => $value,
                'order_by' => 0,
            ];
        }
        // Insert or update attribute values
        AttributeValue::upsert($attributeValues, ['attribute_id', 'value'], []);

        $attributeValues = AttributeValue::select('id')
            ->whereIn('value', $values)
            ->where('attribute_id', $attribute)
            ->get();

        return ! is_null($attributeValues) && count($attributeValues) > 0 ? $attributeValues->pluck('id')->toArray() : [];
    }

    /**
     * Headers for the expected field
     *
     * @return Closure
     */
    private function mappingHeaders()
    {
        return function ($field) {
            $index = $field;

            $field = \Str::slug($field, '-', null);

            if (preg_match('/\b\d+\b/', $field, $matches)) {
                $index = $matches[0];
            }

            $data = [
                'id' => __('ID'),
                'name' => __('Name'),
                'type' => __('Type'),
                'sku' => __('SKU'),
                'description' => __('Description'),
                'summary' => __('Summary'),
                'parent_id' => __('Parent'),
                'featured' => __('Featured'),
                'published' => __('Published'),
                __('Price') => [
                    'regular_price' => __('Regular Price'),
                    'sale_price' => __('Sale Price'),
                ],
                __('Date') => [
                    'available_from' => __('Available From'),
                    'available_to' => __('Available To'),
                    'sale_from' => __('Sale From'),
                    'sale_to' => __('Sale To'),
                ],
                __('Dimentions') => [
                    'meta_weight' => __('Weight'),
                    'meta_dimension:height' => __('Height'),
                    'meta_dimension:length' => __('Length'),
                    'meta_dimension:width' => __('Width'),
                ],
                __('External Product') => [
                    'meta_external_product:text' => __('Button Text'),
                    'meta_external_product:url' => __('Product URL'),
                ],
                'meta_grouped_products' => __('Grouped Products'),
                'categories' => __('Categories'),
                'tags' => __('Tags'),
                'meta_backorder' => __('Allow Backorder'),
                'meta_image' => __('Images'),
                'upsells' => __('Upsells'),
                __('Stock') => [
                    'manage_stocks' => __('Manage Stock?'),
                    'total_stocks' => __('Total Stock'),
                    'meta_stock_status' => __('Stock Status'),
                    'meta_stock_threshold' => __('Stock Threshold'),
                ],
                'cross_sells' => __('Cross Sells'),
                'meta_enable_reviews' => __('Enable Review'),
                'meta_purchase_note' => __('Purchase Note'),
                'meta_shipping_id' => __('Shipping Class'),
                'meta_cash_on_delivery' => __('Cash On Delivery'),
                'meta_tax_classes' => __('Tax Class'),
                'meta_individual_sale' => __('Sold Individually'),
                __('Attributes') => [
                    'attribute:title.' . $index => __('Attribute Title'),
                    'attribute:value.' . $index => __('Attribute Value'),
                    'attribute:visibility.' . $index => __('Attribute Visible'),
                    'attribute:variation.' . $index => __('Attribute For Variation'),
                    'attribute:default.' . $index => __('Attribute Default'),
                ],
                __('Downloadable') => [
                    'downloadable:id.' . $index => __('Download ID'),
                    'downloadable:name.' . $index => __('Download Name'),
                    'downloadable:url.' . $index => __('Download Url'),
                ],
                'meta_download_limit' => __('Download Limit'),
                'meta_' . $field => __('Meta Informations'),
            ];

            if (isActive('B2B')) {

                $data = array_merge($data, ['meta_enable_b2b' => __('Is B2B?'), __('B2B') => [
                    'bb:min.' . $index => __('B2B Min(qty)'),
                    'bb:max.' . $index => __('B2B Max(qty)'),
                    'bb:price.' . $index => __('B2B Price'),
                ]]);
            }

            return $data;
        };
    }

    /**
     * Process fetched to into column => data associative array
     *
     * @param  array  $columns  [] Default
     * @param  array  $rowData
     * @return array|bool
     */
    protected function assignDataToColumns($columns, $rowData)
    {
        if (! is_array($rowData)) {
            return false;
        }

        foreach ($columns as $name => $index) {
            // Extract the arrayable column name from the provided name
            $arrayableName = strtok($name, ':');
            // Check if the arrayable column has attribute name attached
            if ($attribute = strtok('.')) {
                // Check if the attribute has Index
                if ($aIndex = strtok('')) {
                    // Attach the arrayable data in a indexed manner
                    $columns[$arrayableName][$aIndex][$attribute] = $rowData[$index] ?? null;
                } else {
                    // If index number not found the use attribute as array keys
                    $columns[$arrayableName][$attribute] = $rowData[$index] ?? null;
                }
                // Unset the actual column
                unset($columns[$name]);
            } else {
                $columns[$name] = $rowData[$index] ?? null;
            }
        }

        return $columns;
    }

    /**
     * Explodes column name and returns the arrayable name;
     *
     * @param  string  $name
     * @return string
     */
    protected function getArrayableName($name)
    {
        $name = explode(':', $name);

        return $name[0];
    }

    public function getViewAndRoute(string $name)
    {
        return $name;
    }

    public function fieldMapUpdate()
    {
        if (isActive('B2B')) {
            $this->fieldMap = array_merge($this->fieldMap, ['Is B2B?' => 'meta_enable_b2b', 'bbmin' => 'bbmin', 'bbmax' => 'bbmax', 'bbprice' => 'bbprice']);
        }
    }
}
