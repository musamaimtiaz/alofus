<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-01-2023
 */

namespace App\Services\Export;

use App\Models\{AttributeValue, Product};
use Illuminate\Http\Request;

class ProductExportService extends ExportService
{
    protected array $productType = [
        'Simple Product' => 'simple',
        'Variable Product' => 'variable',
        'Variation' => 'variation',
        'Grouped Product' => 'grouped',
        'External/Affiliate Product' => 'external',
    ];

    protected $variationAttribute = [];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * show export data & selection
     * export file
     *
     * @return $this
     */
    public function exportSteps(): bool|static
    {
        try {
            $this->getColumns();
            $csv = $this->loadCsv('product_list');
            $this->setResponse(response()->stream($csv['callback'], 200, $csv['headers']));
        } catch (Exception $e) {
            $this->setError('Something went wrong, please try again.');

            return false;
        }

        return $this;
    }

    /**
     * get column
     */
    public function getColumns(): void
    {
        $products = Product::published();
        $allProduct = [];

        if (isset($this->request->product_types) && is_array($this->request->product_types)) {
            $products->whereIn('type', $this->request->product_types);
        }

        if (! isset($this->request->product_types) || isset($this->request->product_types) && ! in_array('Variation', $this->request->product_types)) {
            $products->notVariation();
        }

        if (isset($this->request->categories) && is_array($this->request->categories)) {
            $category = $this->request->categories;
            $products->whereHas('ProductCategory', function ($q) use ($category) {
                $q->whereIn('category_id', $category);
            });
        }

        if (isset(auth()->user()->role()->slug) && isset(auth()->user()->vendor()->vendor_id) && auth()->user()->role()->slug == 'vendor-admin') {
            $products->where('vendor_id', auth()->user()->vendor()->vendor_id);
        } elseif (isset($this->request->vendors) && is_array($this->request->vendors)) {
            $products->whereIn('vendor_id', $this->request->vendors);
        }

        foreach ($products->get() as $key => $product) {
            $allProduct = array_merge($allProduct, $this->loadProductData($product));

            if ($product->isVariableProduct() && ! isset($this->request->product_types) || $product->isVariableProduct() && isset($this->request->product_types) && in_array('Variation', $this->request->product_types) || $product->isVariableProduct() && isset($this->request->product_types) && in_array('Variable Product', $this->request->product_types)) {
                foreach ($product->getVariations() as $variation) {
                    $allProduct = array_merge($allProduct, $this->loadProductData($variation));
                }
            }

            $this->variationAttribute = [];
        }

        $this->setResource($allProduct);
    }

    /**
     * loadCSV data
     */
    public function loadProductData($product): array
    {
        $allProduct = [];
        $categoryPath = collect($product->categoryPath())->pluck('name')->toArray();
        $tagName = $product->tagNames();
        $images = $product->getAllImagesUrls();
        $product->getProductAttributes();
        $groupProducts = collect($product->getGroupedProductIds(false))->pluck('slug')->toArray();
        $attributeData = [];
        $attributeRetriveValue = [];
        $downloadData = [];
        $productType = [$this->productType[$product->type]];
        $exportedColumn = isset($this->request->exported_column) ? $this->replaceExportIndex() : [];
        $crossSales = $product->crossSales()->pluck('slug')->toArray();
        $upSales = $product->upSales()->pluck('slug')->toArray();

        if ((int) $product->meta_downloadable == 1) {
            $productType = array_merge($productType, ['downloadable']);
        }

        if ((int) $product->meta_virtual == 1) {
            $productType = array_merge($productType, ['virtual']);
        }

        $index = 1;
        $downloadIndex = 1;
        $b2bIndex = 1;
        $b2bData = [];
        $allData = [];
        if (count($exportedColumn) == 0 || in_array('Attributes', $exportedColumn)) {
            foreach ($product->getProductAttributes() as $attribute) {

                foreach ($attribute['value'] as $val) {

                    if (! empty($attribute['attribute_id'])) {
                        $attributeValue = AttributeValue::getAll()->where('id', $val)->first();
                        if (! empty($attributeValue)) {
                            $attributeRetriveValue[] = $attributeValue->value;
                        } else {
                            $attributeRetriveValue[] = $val;
                        }
                    } else {
                        $attributeRetriveValue[] = $val;
                    }
                }

                $attributeData['Attribute' . ' ' . $index . ' ' . 'name'] = $attribute['name'];
                $attributeData['Attribute' . ' ' . $index . ' ' . 'value(s)'] = count($attributeRetriveValue) > 0 ? implode(',', $attributeRetriveValue) : null;
                $attributeData['Attribute' . ' ' . $index . ' ' . 'visible'] = $attribute['visibility'];
                $attributeData['Attribute' . ' ' . $index . ' ' . 'global'] = $attribute['variation'];
                $this->variationAttribute['attribute_' . strtolower($attribute['name'])] = ['name' => $attribute['name'], 'meta_global' => $attribute['variation']];
                $attributeRetriveValue = [];
                $index++;
            }
        }

        if (count($this->variationAttribute) > 0) {
            $index = 1;
            foreach ($this->variationAttribute as $key => $varAttribute) {
                $metaData = $product->metadata()->where('key', $key)->first();
                if (! empty($metaData)) {
                    $attributeValue = AttributeValue::getAll()->where('id', $metaData->value)->first();
                    $attributeData['Attribute' . ' ' . $index . ' ' . 'name'] = $varAttribute['name'];
                    $attributeData['Attribute' . ' ' . $index . ' ' . 'value(s)'] = ! empty($attributeValue) ? $attributeValue->value : $metaData->value;
                    $attributeData['Attribute' . ' ' . $index . ' ' . 'visible'] = null;
                    $attributeData['Attribute' . ' ' . $index . ' ' . 'global'] = $varAttribute['meta_global'];
                    $index++;
                }
            }
        }

        if (count($exportedColumn) == 0 || in_array('Downloads', $exportedColumn)) {
            foreach ($product->getDownloadables() as $download) {
                $downloadData['Download' . ' ' . $downloadIndex . ' ' . 'name'] = $download['name'];
                $downloadData['Download' . ' ' . $downloadIndex . ' ' . 'URL'] = $download['url'];
                $downloadIndex++;
            }
        }

        if (isActive('B2B') && count($exportedColumn) == 0 || isActive('B2B') && in_array('B2B', $exportedColumn)) {
            foreach ($product->getB2BData() as $b2b) {
                $b2bData['B2B' . ' ' . $b2bIndex . ' ' . 'min'] = $b2b['min_qty'];
                $b2bData['B2B' . ' ' . $b2bIndex . ' ' . 'max'] = $b2b['max_qty'];
                $b2bData['B2B' . ' ' . $b2bIndex . ' ' . 'price'] = $b2b['price'];
                $b2bIndex++;
            }
        }

        $data = [
            'ID' => $product->id,
            'Type' => implode(',', $productType),
            'SKU' => $product->sku,
            'Name' => $product->name,
            'Published' => $product->status == 'Published' ? 1 : 0,
            'Is featured?' => ! empty($product->featured) ? 1 : 0,
            'Visibility in catalog' => 'visible',
            'Short description' => $product->summary,
            'Description' => $product->description,
            'Date sale price starts' => $product->sale_from,
            'Date sale price ends' => $product->sale_to,
            'Available from' => $product->available_from,
            'Available to' => $product->available_to,
            'Tax status' => null,
            'Tax class' => $product->meta_tax_classes,
            'In stock?' => $product->getStockStatus() != 'Out of stock' ? 1 : 0,
            'Stock' => $product->total_stocks,
            'Manage Stock' => $product->manage_stocks,
            'Stock threshold' => $product->meta_stock_threshold,
            'Backorders allowed?' => $product->meta_backorder,
            'Sold individually?' => $product->meta_individual_sale,
            'Weight (lbs)' => $product->meta_weight,
            'Length (in)' => $product->meta_dimension['length'],
            'Width (in)' => $product->meta_dimension['width'],
            'Height (in)' => $product->meta_dimension['height'],
            'Allow customer reviews?' => $product->meta_enable_reviews,
            'Purchase note' => $product->meta_purchase_note,
            'Sale price' => $product->sale_price,
            'Regular price' => $product->regular_price,
            'Categories' => is_array($categoryPath) && count($categoryPath) > 0 ? implode('>', $categoryPath) : null,
            'Tags' => is_array($tagName) && count($tagName) > 0 ? implode(',', $tagName) : null,
            'Shipping class' => $product->meta_shipping_id,
            'Images' => is_array($images) && count($images) > 0 ? implode(',', $images) : null,
            'Download limit' => $product->meta_download_limit,
            'Download expiry days' => $product->meta_download_expiry,
            'Parent' => optional($product->parentDetail)->sku,
            'Grouped products' => count($groupProducts) > 0 ? implode(',', $groupProducts) : null,
            'Upsells' => count($upSales) > 0 ? implode(',', $upSales) : null,
            'Cross-sells' => count($crossSales) > 0 ? implode(',', $crossSales) : null,
            'External URL' => $product->meta_external_product['url'] ?? null,
            'Button text' => $product->meta_external_product['text'] ?? null,
            'Position' => null,
        ];

        $data = array_merge($data, $attributeData);
        $data = array_merge($data, $downloadData);
        if (isActive('B2B')) {
            $data = count($b2bData) > 0 ? array_merge($data, ['Is B2B?' => $product->meta_enable_b2b]) : $data;
            $data = array_merge($data, $b2bData);
        }
        $data = count($exportedColumn) == 0 ? $data : $this->filterData($data, $attributeData, $downloadData, $b2bData);

        $allProduct[] = $data;
        $this->csvColumn = array_merge($this->csvColumn, array_keys($data));
        $this->csvColumn = array_unique($this->csvColumn);

        return $allProduct;
    }

    /**
     * replace export index
     */
    public function replaceExportIndex(): array
    {
        $data = [];
        foreach ($this->request->exported_column as $column) {
            $data[$column] = $column;
        }

        return $data;
    }

    /**
     * filter data
     */
    public function filterData($allData, $attributeData, $downloadData, $b2bData): array
    {
        $finalData = [];
        foreach ($this->request->exported_column as $column) {
            switch ($column) {
                case 'Downloads':
                    foreach ($downloadData as $key => $download) {
                        $finalData[$key] = $download;
                    }

                    break;
                case 'Attributes':
                    foreach ($attributeData as $key => $attribute) {
                        $finalData[$key] = $attribute;
                    }

                    break;
                case 'B2B':
                    foreach ($b2bData as $key => $b2b) {
                        $finalData[$key] = $b2b;
                    }

                    break;
                default:
                    $finalData[$column] = $allData[$column] ?? null;
            }
        }

        return $finalData;
    }
}
