<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\Blog\DataTables;

use App\DataTables\DataTable;
use Illuminate\Http\JsonResponse;
use Modules\Blog\Http\Models\Blog;

class BlogDataTable extends DataTable
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
        $blog = $this->query();

        return datatables()
            ->of($blog)

            ->addColumn('image', function ($blog) {
                return '<img class="rounded" src="' . $blog->fileUrl() . '" alt="' . __('image') . '" width="40" height="40">';
            })->editColumn('title', function ($blog) {
                return '<a href="' . route('blog.details', ['slug' => $blog->slug]) . '" title="' . $blog->title . '">' . trimWords($blog->title, 50) . '</a>';
            })->addColumn('category', function ($blog) {
                return wrapIt(optional($blog->blogCategory)->name, 10, ['columns' => 3, 'trim' => true]);
            })->editColumn('author', function ($blog) {
                return wrapIt(optional($blog->user)->name, 10, ['columns' => 3, 'trim' => true]);
            })->editColumn('status', function ($blog) {
                return statusBadges(lcfirst($blog->status));
            })->editColumn('created_at', function ($blog) {
                return $blog->format_created_at;
            })->addColumn('action', function ($blog) {
                $show = '<a title="' . __('Show') . '" href="' . route('blog.details', ['slug' => $blog->slug]) . '" class="action-icon pr-5"><i class="feather icon-eye"></i></a>&nbsp';
                $edit = '<a title="' . __('Edit :x', ['x' => __('Blog')]) . '" href="' . route('blog.edit', ['id' => $blog->id]) . '" class="action-icon"><i class="feather icon-edit-1 neg-transition-scale-svg "></i></a>&nbsp';

                $delete = '<form method="post" action="' . route('blog.delete', ['id' => $blog->id]) . '" id="delete-Blog-' . $blog->id . '" accept-charset="UTF-8" class="display_inline">
                        ' . csrf_field() . '
                        <a title="' . __('Delete :x', ['x' => __('Blog')]) . '" class="action-icon confirm-delete" type="button" data-id=' . $blog->id . ' data-label="Delete" data-delete="Blog" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="' . __('Delete :x', ['x' => __('Blog')]) . '" data-message="' . __('Are you sure to delete this?') . '">
                        <i class="feather icon-trash"></i>
                        </a>
                        </form>';
                $str = '';
                if ($blog->status == 'Active') {
                    $str .= $show;
                }
                if ($this->hasPermission(['Modules\Blog\Http\Controllers\BlogController@edit'])) {
                    $str .= $edit;
                }
                if ($this->hasPermission(['Modules\Blog\Http\Controllers\BlogController@delete'])) {
                    $str .= $delete;
                }

                return $str;
            })

            ->rawColumns(['image', 'title', 'category', 'author', 'status', 'created_at', 'action'])
            ->filter(function ($instance) {
                if (request('status') && (request('status') == 'Active' || request('status') == 'Inactive')) {
                    $instance->where('status', request('status'));
                }

                if (request('author_id')) {
                    $instance->whereHas('user', function ($query) {
                        $query->where('id', request('author_id'));
                    });
                }
                if (request('category_id')) {
                    $instance->whereHas('blogCategory', function ($query) {
                        $query->where('id', request('category_id'));
                    });
                }
                if (isset(request('search')['value'])) {
                    $keyword = xss_clean(request('search')['value']);
                    if (! empty($keyword)) {
                        $instance->where(function ($query) use ($keyword) {
                            $query->whereLike('title', $keyword)
                                ->orWhereLike('blogs.status', $keyword)
                                ->orWhereHas('blogCategory', function ($query) use ($keyword) {
                                    $query->whereLike('name', $keyword);
                                })
                                ->orWhereHas('user', function ($query) use ($keyword) {
                                    $query->whereLike('name', $keyword);
                                });
                        });
                    }
                }
            })
            ->make(true);
    }

    /*
    * DataTable Query
    *
    * @return mixed
    */
    public function query()
    {
        $blogs = Blog::select('blogs.*')->with('user', 'blogCategory');

        return $this->applyScopes($blogs);
    }

    /*
    * DataTable HTML
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => __('Id'), 'visible' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'image', 'name' => 'image', 'title' => __('Image'), 'orderable' => false, 'searchable' => false, 'className' => 'align-middle'])
            ->addColumn(['data' => 'title', 'name' => 'title', 'title' => __('Title'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'category', 'name' => 'blogCategory.name', 'title' => __('Category'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'author', 'name' => 'user.name', 'title' => __('Author'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'status', 'name' => 'blogs.status', 'title' => __('Status'), 'className' => 'align-middle'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created At'), 'className' => 'align-middle'])
            ->addColumn([
                'data' => 'action', 'name' => 'action', 'title' => '', 'width' => '12%',
                'visible' => $this->hasPermission(['Modules\Blog\Http\Controllers\BlogController@edit', 'Modules\Blog\Http\Controllers\BlogController@delete']),
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
