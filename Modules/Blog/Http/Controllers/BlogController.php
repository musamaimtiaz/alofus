<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 01-01-2022
 */

namespace Modules\Blog\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Blog\Http\Models\BlogCategory;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Http\Requests\BlogUpdateRequest;
use Modules\Blog\Http\Models\Blog;
use Modules\Blog\DataTables\BlogDataTable;
use Illuminate\Support\Str;
use Session;
use DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(BlogDataTable $dataTable)
    {
        $data['from'] = ! empty(request()->input('from')) ? request()->input('from') : '';
        $data['to'] = ! empty(request()->input('to')) ? request()->input('to') : '';
        $data['category_id'] = ! empty(request()->input('category_id')) ? request()->input('category_id') : '';
        $data['author_id'] = ! empty(request()->input('author_id')) ? request()->input('author_id') : '';
        $data['blog'] = (new Blog())->getAllBlogDT($data['from'], $data['to'], $data['category_id'], $data['author_id']);
        $data['categorize'] = BlogCategory::where('status', 'Active')->get();
        $data['authors'] = User::whereHas('blogs')->get();

        return $dataTable->with(['blogData' => $data['blog']])->render('blog::blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['categories'] = BlogCategory::where('status', 'Active')->get();

        return view('blog::blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(BlogRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Failed to save blog, please try again.')];
        $slugReplace = strtolower(str_replace(' ', '-', stripBeforeSave($request->slug)));
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slugReplace);
        $request['slug']  = Blog::where('slug', $slug)->count() > 0 ? $slug . strtolower(Str::random(4)) : $slug;
        $request['user_id']  = \Auth::id();
        if ((new Blog())->store($request->only('category_id', 'user_id', 'title', 'slug', 'description', 'summary', 'status'))) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Blog')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('blog.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = ['status' => 'fail', 'message' => __('The blog is not found.')];
        $data['blog'] = Blog::find($id);
        if (empty($data['blog'])) {
            Session::flash($data['status'], $data['message']);

            return redirect()->route('blog.index');
        }
        $data['categories'] = BlogCategory::get();

        return view('blog::blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(BlogUpdateRequest $request, $id)
    {
        $data = ['status' => 'fail', 'message' => __('Failed to save blog, please try again.')];
        $slugReplace = strtolower(str_replace(' ', '-', stripBeforeSave($request->slug)));
        $request['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '', $slugReplace);
        if ((new Blog())->updateBlog($request->only('category_id', 'title', 'slug', 'description', 'summary', 'status'), $id)) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully updated.', ['x' => __('Blog')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function delete($id)
    {
        if ($blog = Blog::find($id)) {
            try {
                $blog->delete();
                $blog->deleteFileObjects(['thumbnail' => true]);

                DB::commit();

                return redirect()->route('blog.index')->withSuccess(__('Blog has been successfully deleted.'));
            } catch (Exception $e) {
                DB::rollBack();

                return redirect()->route('blog.index')->withFail($e->getMessage());
            }
        } else {
            return redirect()->route('blog.index')->withFail(__('The blog is not found.'));
        }
    }
}
