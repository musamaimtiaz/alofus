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
use Modules\FormBuilder\Entities\Form;

class FormDataTable extends DataTable
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
        $form = $this->query();

        return datatables()
            ->of($form)
            ->editColumn('name', function ($form) {
                return '<a href="' . route('formbuilder::forms.edit', $form->id) . '">' . $form->name . '</a>';
            })->editColumn('visibility', function ($form) {
                return statusBadges($form->visibility);
            })->editColumn('type', function ($form) {
                return \Str::title(str_replace('_', ' ', $form->type));
            })->editColumn('allows_edit', function ($form) {
                return statusBadges($form->allowsEdit() ? __('Yes') : __('No'));
            })->addColumn('submissions_count', function ($form) {
                return $form->submissions_count;
            })->addColumn('action', function ($form) {

                $edit = '<a title="' . __('Edit :x', ['x' => __('Form')]) . '" href="' . route('formbuilder::forms.edit', ['form' => $form->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post"
                            action="' . route('formbuilder::forms.destroy', ['form' => $form->id]) . '"
                            id="delete-form-' . $form->id . '" accept-charset="UTF-8"
                            class="display_inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <a title="' . __('Delete :x', ['x' => __('Form')]) . '" class="action-icon"
                                type="button"
                                data-form="delete-form-' . $form->id . '"
                                data-id=' . $form->id . '
                                data-title="' . __('Delete :x', ['x' => __('Form')]) . '"
                                data-delete="form" data-label="' . __('Delete') . '"
                                data-bs-toggle="modal" data-bs-target="#confirmDelete"
                                data-message="' . __('Are you sure to delete this?') . '">
                                <i class="feather icon-trash"></i>
                            </a>
                        </form>';

                $data = '<a href="' . route('formbuilder::submissions.index', ['fid' => $form->id]) . '"
                            class="action-icon me-2"
                            title="' . __('View submissions for :x', ['x' => $form->name]) . '">
                                <i class="fa fa-th-list neg-transition-scale"></i></a>';

                $copy = '<a class="action-icon me-2 clipboard" type="button"
                                                        data-clipboard-text="' . route('formbuilder::form.render', $form->identifier) . '"
                                                        data-message="" data-original="" title="' . __('Copy form URL to clipboard') . '">
                                                        <i class="fa fa-clipboard"></i>
                                                    </a>';

                $show = '<a href="' . route('formbuilder::forms.show', $form) . '"
                                                        class="action-icon me-2"
                                                        title="' . __('Preview form :x', ['x' => $form->name]) . '">
                                                        <i class="fa fa-eye"></i></a>';

                return $data . $show . $copy . $edit . $delete;
            })
            ->rawColumns(['name', 'visibility', 'action', 'allows_edit'])
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $forms = Form::notKyc()->notAffiliate()->withCount('submissions');

        if (isset(request('search')['value'])) {
            $keyword = xss_clean(request('search')['value']);
            if (! empty($keyword)) {
                $forms->where('name', 'like', '%' . $keyword . '%');
            }
        }

        return $this->applyScopes($forms->filter());
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()

            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => __('Name'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'visibility', 'name' => 'visibility', 'title' => __('Visibility'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'type', 'name' => 'type', 'title' => __('Type'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'allows_edit', 'name' => 'allows_edit', 'title' => __('Allow Edit'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'submissions_count', 'name' => 'submissions_count', 'title' => __('Submissions'), 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '20%',
                'orderable' => false, 'searchable' => false, 'className' => 'text-right align-middle',
            ])
            ->parameters(dataTableOptions(['dom' => 'Bfrtip']));
    }
}
