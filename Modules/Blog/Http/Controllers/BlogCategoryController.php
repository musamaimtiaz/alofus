<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 01-01-2022
 */

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Modules\Blog\DataTables\BlogCategoryDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\BlogCategoryRequest;
use Modules\Blog\Http\Requests\BlogCategoryUpdateRequest;
use Modules\Blog\Http\Models\BlogCategory;
use Session;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('blog::category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(BlogCategoryRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ((new BlogCategory())->store($request->only('name', 'status'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Category')]);
        }
        Session::flash($data['status'], $data['message']);

        return redirect()->route('blog.category.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(BlogCategoryUpdateRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Failed to save blog category, please try again.')];
        if ((new BlogCategory())->updateCategory($request->only('name', 'status', 'id'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Category')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('blog.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function delete($id)
    {
        if ($id == 1) {
            return redirect()->route('blog.category.index')->withFail(__('This category can not be deleted!'));
        }

        if ($category = BlogCategory::find($id)) {
            $category->delete();

            return redirect()->route('blog.category.index')->withSuccess(__('Category has been successfully deleted.'));
        }

        return redirect()->route('blog.category.index')->withFail(__('Category does not found.'));
    }
}
