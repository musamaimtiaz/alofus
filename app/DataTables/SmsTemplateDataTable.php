<?php

namespace App\DataTables;

use App\Models\EmailTemplate;
use Illuminate\Http\JsonResponse;

class SmsTemplateDataTable extends DataTable
{
    /*
    * DataTable Ajax
    *
    * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
    */
    public function ajax(): JsonResponse
    {
        $templates = $this->query();

        return datatables()
            ->of($templates)

            ->addColumn('name', function ($templates) {
                return isset($templates->name) ? "<a href='" . route('sms.template.edit', ['slug' => $templates->slug]) . "'>" . $templates->name . '</a>' : '';
            })

            ->addColumn('status', function ($templates) {
                return statusBadges(lcfirst($templates->status));
            })

            ->addColumn('action', function ($templates) {
                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\SmsTemplateController@edit'])) {
                    $str .= '<a title="' . __('Edit') . '" href="' . route('sms.template.edit', ['slug' => $templates->slug]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp;';
                }

                return $str;
            })

            ->rawColumns(['name', 'slug', 'status', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $templates = EmailTemplate::getAll()->whereNull('parent_id');

        return $this->applyScopes($templates);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle', 'width' => '30%'])
            ->addColumn(['data' => 'slug', 'name' => 'slug', 'title' => __('Slug'), 'className' => 'align-middle', 'width' => '30%'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-right', 'width' => '20%'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'width' => '5%',
                'visible' => $this->hasPermission(['App\Http\Controllers\SmsTemplateController@edit']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle'])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
