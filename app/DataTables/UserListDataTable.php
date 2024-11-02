<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 30-05-2022
 */

namespace App\DataTables;

use App\Models\{
    User
};
use Illuminate\Http\JsonResponse;

class UserListDataTable extends DataTable
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
        $users = $this->query();

        return datatables()
            ->of($users)

            ->addColumn('picture', function ($users) {
                return '<img class="rounded" src="' . $users->fileUrl() . '" alt="' . __('image') . '" width="40" height="40">';
            })
            ->editColumn('name', function ($users) {
                $html = '<a href="' . route('users.edit', ['id' => $users->id]) . '">' . wrapIt($users->name, 10) . '</a>';
                $html .= '<span class="d-block text-muted info-meta"><span>' . $users->email . '</span>';

                return $html;
            })
            ->editColumn('status', function ($users) {
                return statusBadges(lcfirst($users->status));
            })
            ->addColumn('role', function ($users) {
                $roles = $users->roles->map(function ($role) {
                    return '<span class="f-w-600 f-12 text-muted text-uppercase">' . $role->name . '</span>';
                })->toArray();

                return implode(', ', $roles);
            })
            ->editColumn('created_at', function ($users) {
                return $users->format_created_at_only_date . '<br><span class="text-muted">' . $users->format_created_at_only_time . '</span>';
            })
            ->addColumn('action', function ($users) {
                $loginAs = '<a data-bs-toggle="tooltip" title="' . __('Login as') . '" class="action-icon pr-5" href="' . route('impersonator', ['impersonate' => techEncrypt($users->password)]) . '" target="_blank"><i class="feather icon-log-in"></i></a>';

                $edit = '<a data-bs-toggle="tooltip" title="' . __('Edit') . '" href="' . route('users.edit', ['id' => $users->id]) . '" class="action-icon"><i class="feather icon-edit-1"></i></a>';

                $delete = '<form method="post" action="' . route('users.destroy', ['id' => $users->id]) . '" id="delete-user-' . $users->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete') . '" class="action-icon confirm-delete" type="button" data-id=' . $users->id . ' data-delete="user" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('User')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';

                $str = '';
                if ($this->hasPermission(['App\Http\Controllers\UserController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['App\Http\Controllers\UserController@destroy']) && optional($users->role())->slug != 'super-admin') {
                    $str .= $delete;
                }

                return $loginAs . $str;
            })
            ->rawColumns(['picture', 'name', 'email', 'role', 'status', 'created_at', 'action'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $users = User::query()->filter();

        return $this->applyScopes($users);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false])
            ->addColumn(['data' => 'picture', 'name' => 'picture', 'title' => __('Picture'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle text-left', 'width' => '5%'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'visible' => false])
            ->addColumn(['data' => 'role', 'name' => 'role', 'title' => __('Role'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Registered'), 'className' => 'align-middle', 'width' => '11%'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'visible' => $this->hasPermission(['App\Http\Controllers\UserController@edit', 'App\Http\Controllers\UserController@destroy']),
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
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
