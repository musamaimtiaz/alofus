<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 26-09-2021
 *
 * @updated 27-08-2022
 */

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class VendorProductDataTable extends DataTable
{
    /**
     * Handle the AJAX request for attribute groups.
     *
     * This function queries attribute groups and returns the data in a format suitable
     * for DataTables to consume via AJAX.
     *
      @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        $products = $this->query();

        return datatables()
            ->of($products)
            ->addColumn('image', function ($products) {
                return '<img class="rounded" src="' . $products->getFeaturedImage('small') . '" alt="' . __('image') . '" width="40" height="40">';
            })
            ->editColumn('name', function ($products) {
                $editPermission = $this->hasPermission(['App\Http\Controllers\Vendor\ProductController@edit']);
                $duplicatePermission = $this->hasPermission(['App\Http\Controllers\Vendor\ProductController@duplicate']);
                $deletePermission = $this->hasPermission(['App\Http\Controllers\Vendor\ProductController@deleteProduct']);

                $html = '<div class="meta-info-parent">
                            <a href="' . route('vendor.product.edit', ['code' => $products->code]) . '" title="' . $products->name . '">' . trimWords($products->name, 50) . '</a>' .
                    '<span class="d-block">' .
                    '<span>SKU:' . $products->sku . '</span>' .
                    '<span class="info-meta">';

                if ($editPermission) {
                    $html .= '<span class="hasbar"><a class="btn-link" href="' . route('vendor.product.edit', ['code' => $products->code]) . '">' . __('Edit') . '</a></span>';
                }

                if ($duplicatePermission) {
                    $html .= '<span class="hasbar"><a class="btn-link" href="' . route('vendor.product.duplicate', ['code' => $products->code]) . '">' . __('Duplicate') . '</a></span>';
                }

                $html .= '<span class="hasbar"><a class="btn-link" target="_blank" href="' . route('site.productDetails', ['slug' => $products->slug]) . '">' . __('Preview') . '</a></span>';

                if ($deletePermission) {
                    $html .= '<span class="hasbar">
                                <form method="post" action="' . route('vendor.product.destroy', ['code' => $products->code]) . '" id="delete-product-' . $products->code . '" accept-charset="UTF-8" class="display_inline">
                                    ' . method_field('DELETE') . '
                                    ' . csrf_field() . '
                                    <span title="' . __('Delete') . '" class="btn-link text-danger cursor-pointer confirm-delete" type="button" data-id=' . $products->code . ' data-delete="product" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Product')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                                        ' . __('Trash') . '
                                    </span>
                                </form>
                            </span>';
                }

                $html .= '</span></div></span>';

                return $html;
            })
            ->editColumn('regular_price', function ($products) {
                return $products->getFormattedPrice() ?? '-';
            })

            ->editColumn('sku', function ($products) {
                return $products->sku ? wrapIt($products->sku, 10, ['columns' => 6]) : '-';
            })
            ->addColumn('category', function ($products) {
                $cat = optional($products->category->first())->name;
                $cat = wrapIt($cat, 10, ['columns' => 6, 'trim' => true, 'trimLength' => 25]) ?? '-';

                $brand = $products->brand ? wrapIt(optional($products->brand)->name, 10, ['columns' => 6]) : '-';

                $metaInfo = <<<HTML
                    <div class="meta-info-parent">
                        <span class="d-block text-muted">$cat</span>
                        <span class="d-block"><i>$brand</i></span>
                    </div>
                HTML;

                return $metaInfo;
            })
            ->editColumn('stock', function ($products) {
                $status = $products->getStockStatus();

                $statusLabels = [
                    'on backorder' => 'badge-mv-warning',
                    'out of stock' => 'badge-mv-danger',
                ];

                $defaultLabel = 'badge-mv-success';
                $class = $statusLabels[strtolower($status)] ?? $defaultLabel;

                return "<span class='badge $class f-12 f-w-600'>" . __($status) . '</span>';
            })
            ->addColumn('brand', function ($products) {
                return $products->brand ? wrapIt(optional($products->brand)->name, 10, ['columns' => 6]) : '-';
            })
            ->editColumn('status', function ($products) {
                return statusBadges($products->status);
            })
            ->rawColumns(['image', 'name', 'status', 'vendor', 'stock', 'category'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $vendorId = auth()->user()->vendor()->vendor_id;

        if (is_null($vendorId)) {
            return false;
        }

        $products = Product::select(['id', 'type', 'code', 'name',  'vendor_id', 'brand_id', 'status', 'regular_price', 'sku', 'parent_id', 'slug', 'manage_stocks', 'total_stocks'])
            ->with(['category', 'metadata', 'brand'])->where('vendor_id', $vendorId)->where('slug', '!=', null);

        return $this->applyScopes($products->filter());
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'image', 'name' => 'image', 'title' => __(''), 'width' => '5%', 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'width' => '45%', 'className' => 'align-middle'])
            ->addColumn(['data' => 'regular_price', 'name' => 'regular_price', 'title' => __('Price'), 'width' => '10%', 'className' => 'align-middle'])
            ->addColumn(['data' => 'sku', 'name' => 'sku', 'title' => __('SKU'), 'visible' => false])
            ->addColumn(['data' => 'category', 'name' => 'category', 'title' => __('Category|Brand'), 'width' => '20%', 'orderable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'stock', 'name' => 'total_stocks', 'title' => __('Stock'), 'width' => '8%', 'orderable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'brand', 'name' => 'brand', 'title' => __('Brand'), 'visible' => false])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'width' => '10%', 'orderable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions([
                'dom' => 'Bfrtip',
            ]));
    }

    public function setViewData()
    {
        $statusCounts = $this->query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $this->data['groups'] = ['All' => $statusCounts->sum()] + $statusCounts->toArray();
    }
}
