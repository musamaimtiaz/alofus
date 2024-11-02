<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-10-2021
 */

namespace Modules\Shop\DataTables;

use App\DataTables\DataTable;
use App\Models\{
    VendorUser
};
use Illuminate\Http\JsonResponse;
use Modules\Shop\Http\Models\Shop;

class VendorShopDataTable extends DataTable
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
        $shops = $this->query();

        return datatables()
            ->of($shops)

            ->editColumn('name', function ($shops) {
                return wrapIt(ucfirst($shops->name), 10, ['columns' => 5]);
            })->editColumn('email', function ($shops) {
                return wrapIt($shops->email, 20, ['columns' => 5]);
            })->editColumn('website', function ($shops) {
                return wrapIt($shops->website, 20, ['columns' => 5]);
            })->editColumn('phone', function ($shops) {
                return wrapIt($shops->phone, 15, ['columns' => 5]);
            })->editColumn('fax', function ($shops) {
                return wrapIt($shops->fax, 15, ['columns' => 5]);
            })->editColumn('status', function ($shops) {
                return statusBadges(lcfirst($shops->status));
            })->editColumn('action', function ($shops) {
                $edit = '<a title="' . __('Edit :x', ['x' => __('Shop')]) . '" href="' . route('vendor.shop.edit', ['id' => $shops->id]) . '" class="btn btn-xs btn-primary"><i class="feather icon-edit neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('vendor.shop.destroy', ['id' => $shops->id]) . '" id="delete-shops-' . $shops->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <button title="' . __('Delete :x', ['x' => __('Shop')]) . '" class="btn btn-xs btn-danger" type="button" data-id=' . $shops->id . ' data-label="Delete" data-delete="shops" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Shop')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash-2"></i>
                        </button>
                        </form>';
                $str = '';
                if ($this->hasPermission(['Modules\Shop\Http\Controllers\Vendor\ShopController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Shop\Http\Controllers\Vendor\ShopController@destroy'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['name', 'email', 'website', 'phone', 'fax', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {

        $shops = Shop::select('id', 'name', 'email', 'website', 'phone', 'fax', 'status')->where('vendor_id', session()->get('vendorId'));

        return $this->applyScopes($shops);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Shop Name')])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email')])
            ->addColumn(['data' => 'website', 'name' => 'website', 'title' => __('Website')])
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => __('Phone')])
            ->addColumn(['data' => 'fax', 'name' => 'fax', 'title' => __('Fax')])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '5%',
                'visible' => $this->hasPermission(['Modules\Shop\Http\Controllers\Vendor\ShopController@edit', 'Modules\Shop\Http\Controllers\Vendor\ShopController@destroy']),
                'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
}
