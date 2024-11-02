<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 21-03-2022
 */

namespace Modules\FormBuilder\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\FormBuilder\Entities\Submission;

class KycFormTable extends DataTable
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
        $sub = $this->query();

        return datatables()
            ->of($sub)

            ->editColumn('username', function ($sub) {
                return $sub?->user?->name;
            })->addColumn('form_submissions.updated_at', function ($sub) {
                return $sub->format_updated_at;
            })->addColumn('form_submissions.created_at', function ($sub) {
                return $sub->format_created_at;
            })->addColumn('action', function ($sub) {
                $edit = '<a title="' . __('Edit :x', ['x' => __('Submission')]) . '" href="' . route('formbuilder::kyc.sub-edit', [$sub->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg " aria-hidden="true"></i></a>&nbsp';

                $delete = '<form method="post"
                            action="' . route('formbuilder::kyc.delete', ['id' => $sub->id]) . '"
                            id="delete-submission-' . $sub->id . '" accept-charset="UTF-8"
                            class="display_inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <a title="' . __('Delete :x', ['x' => __('Submission')]) . '" class="action-icon"
                                type="button"
                                data-form="delete-submission-' . $sub->id . '"
                                data-id=' . $sub->id . '
                                data-title="' . __('Delete :x', ['x' => __('Submission')]) . '"
                                data-delete="submission" data-label="' . __('Delete') . '"
                                data-bs-toggle="modal" data-bs-target="#confirmDelete"
                                data-message="' . __('Are you sure to delete this?') . '">
                                <i class="feather icon-trash"></i>
                            </a>
                        </form>';

                $view = '<a href="' . route('formbuilder::kyc.sub-view', [$sub->id]) . '"
                            class="action-icon me-2" title="View submission">
                            <i class="fa fa-eye"></i>
                         </a>';

                return $view . $edit . $delete;
            })

            ->rawColumns(['username', 'visibility', 'action', 'edit_allow'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $subs = Submission::select('form_submissions.id', 'form_submissions.updated_at', 'form_submissions.created_at', 'users.id as user_id', 'users.name')->whereHas('form', function ($q) {
            $q->where('type', 'kyc');
        })->with('user:id,name');

        if (isset(request('search')['value'])) {
            $keyword = xss_clean(request('search')['value']);
            if (! empty($keyword)) {
                $subs->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            }
        }

        return $this->applyScopes($subs);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'username', 'name' => 'user.name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'form_submissions.updated_at', 'name' => 'form_submissions.updated_at', 'title' => __('Updated On'), 'orderable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'form_submissions.created_at', 'name' => 'form_submissions.created_at', 'title' => __('Created On'), 'orderable' => false, 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => __('Action'), 'width' => '15%',
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
