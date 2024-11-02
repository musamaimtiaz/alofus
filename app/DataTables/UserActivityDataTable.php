<?php

namespace App\DataTables;

use App\Traits\ModelTraits\Filterable;
use App\Traits\ModelTraits\FormatDateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UserActivityDataTable extends DataTable
{
    use Filterable;
    use FormatDateTime;

    protected $propertiesArray = [];

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
        $activities = $this->query();

        return datatables()
            ->of($activities)
            ->addColumn('log_name', function ($activity) {
                return str_replace('USER ', '', $activity->log_name);
            })
            ->addColumn('description', function ($activity) {
                return $activity->description;
            })
            ->addColumn('browser', function ($activity) {
                $this->propertiesArray = json_decode($activity->properties, true);

                return $this->propertiesArray['browser'] . ' ' . $this->propertiesArray['browser_version'];
            })
            ->addColumn('platform', function ($activity) {
                return $this->propertiesArray['platform'];
            })
            ->addColumn('ip', function ($activity) {
                return $this->propertiesArray['ip_address'];
            })
            ->addColumn('created_at', function ($activity) {
                return $this->formatDateTime($activity->created_at);
            })
            ->rawColumns(['log_name', 'description', 'browser', 'platform', 'ip', 'created_at'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $activities = Activity::query()
            ->where('log_name', 'LIKE', '%user%')
            ->where('causer_id', '=', Auth::id());

        if (count(request()->query()) > 0) {
            $activities = $this->scopeFilter($activities, 'App\\Filters\\UserActivityLogFilter');
        }

        return $this->applyScopes($activities);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'log_name', 'name' => 'log_name', 'title' => __('Type'), 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => __('Description'), 'orderable' => false])
            ->addColumn(['data' => 'browser', 'name' => 'browser', 'title' => __('Browser'), 'orderable' => false])
            ->addColumn(['data' => 'platform', 'name' => 'platform', 'title' => __('Platform'), 'orderable' => false, 'width' => '5%'])
            ->addColumn(['data' => 'ip', 'name' => 'ip', 'title' => __('IP'), 'orderable' => false])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created at'), 'orderable' => false])
            ->parameters(dataTableOptions());
    }
}
