<?php

namespace App\Services\Import;

use App\Enums\ProductStatus;
use Illuminate\Http\Request;

class VendorProductImportService extends ProductImportService
{
    protected $vendorId;

    public function __construct(Request $request)
    {
        $vendor = auth()->user()->vendor();
        if (is_null($vendor)) {
            abort(403);
        }
        $this->vendorId = $vendor->vendor_id;
        parent::__construct($request);
    }

    /**
     * Attach vendor id to the product
     *
     * @param  array  $data
     * @return array
     */
    protected function filterVendorId($data)
    {
        $data['vendor_id'] = $this->vendorId;

        return $data;
    }

    /**
     * Generates array of category id
     *
     * @return array
     */
    protected function handleCategory($data)
    {
        $category = $this->categoryService->disableCreateNew()->process($data['categories'] ?? null);

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
        $tags = $this->tagService->disableCreateNew()->process($data['tags'] ?? '');

        unset($data['tags']);

        return $tags;
    }

    public function getViewAndRoute(string $name)
    {
        $names = [
            'admin.epz.import.product' => 'vendor.epz.import.product',
        ];

        return $names[$name] ?? $name;
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
            $data['status'] = isset($data['published']) && $data['published'] == 1 ? ProductStatus::$PendingReview : 'Draft';
        }

        return $data;
    }
}
