<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-04-2022
 */

namespace Modules\Newsletter\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Newsletter\Entities\Subscriber;

class SubscriberDataTable extends DataTable
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
        $subscriber = $this->query();

        return datatables()
            ->of($subscriber)
            ->addColumn('email', function ($subscriber) {
                return wrapIt($subscriber->email, 20, ['columns' => 1]);
            })->addColumn('status', function ($subscriber) {
                return statusBadges($subscriber->status);
            })->addColumn('confirmation_date', function ($subscriber) {
                return timeZoneFormatDate($subscriber->confirmation_date);
            })->addColumn('action', function ($subscriber) {
                $str = '';
                if ($this->hasPermission(['Modules\Newsletter\Http\Controllers\SubscriberController@edit'])) {
                    $str .= '<a title="' . __('Edit :x', ['x' => __('Subscriber')]) . '" href="' . route('subscriber.edit', ['id' => $subscriber->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';
                }
                if ($this->hasPermission(['Modules\Newsletter\Http\Controllers\SubscriberController@destroy'])) {
                    $str .= '<form method="post" action="' . route('subscriber.delete', ['id' => $subscriber->id]) . '" id="delete-subscriber-' . $subscriber->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete :x', ['x' => __('Subscriber')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $subscriber->id . ' data-label="Delete" data-delete="subscriber" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Subscriber')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                }

                return $str;
            })
            ->rawColumns(['email', 'status', 'confirmation_date', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $subscriber = Subscriber::filter();

        return $this->applyScopes($subscriber);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'confirmation_date', 'name' => 'confirmation_date', 'title' => __('Confirmation Date'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '10%',
                'visible' => $this->hasPermission(['Modules\Newsletter\Http\Controllers\SubscriberController@edit', 'Modules\Newsletter\Http\Controllers\SubscriberController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
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
