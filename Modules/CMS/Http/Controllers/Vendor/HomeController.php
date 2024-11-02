<?php

namespace Modules\CMS\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;
use Modules\CMS\Http\Controllers\CMSController as ControllersCMSController;
use Modules\CMS\Http\Models\Page;
use Modules\CMS\Http\Models\ThemeOption;
use Modules\CMS\Http\Requests\PageRequest;
use Modules\CMS\Http\Requests\PageUpdateRequest;

class HomeController extends Controller
{
    /**
     * HomeController callAction
     */
    public function callAction($method, $parameters)
    {
        if (auth()->user()?->role()?->slug != 'super-admin' && preference('is_vendor_shop_decoration_active', '') != 1) {
            abort(403);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * Home pages list
     *
     * @return Renderable
     */
    public function index()
    {
        $data['pages'] = Page::where(['type' => 'home', 'vendor_id' => auth()->user()?->vendor()?->vendor_id])->get();

        return view('cms::vendor.home', $data);
    }

    /**
     * Create homepage
     */
    public function create()
    {
        $data['layouts'] = ThemeOption::layouts();
        $data['vendorId'] = auth()->user()?->vendor()?->vendor_id;

        return view('cms::vendor.create-home', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(PageRequest $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $id = (new Page())->store($request->only('name', 'slug', 'status', 'vendor_id', 'type', 'default', 'layout', 'meta_title', 'meta_description'));

        if ($id) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Home Page')]);
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->route('vendor.home');
    }

    /**
     * Edit homepage
     *
     * @param  string  $slug
     */
    public function edit($slug)
    {
        $data['page'] = Page::where('vendor_id', auth()->user()->vendor()->vendor_id)->whereSlug($slug)->first();
        $data['layouts'] = ThemeOption::layouts();
        $data['isHome'] = true;

        return view('cms::vendor.edit-home', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(PageUpdateRequest $request, ControllersCMSController $cms, $id)
    {
        $cms->update($request, $id);

        return redirect()->route('vendor.home')->withSuccess(__('The :x successfully saved.', ['x' => __('Page')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function delete($id)
    {
        $page = Page::find($id);
        if ($page->default == 1) {
            $data['status'] = 'fail';
            $data['message'] = __('Cannot delete default page.');

            return redirect()->back();
        }
        $response = (new Page())->remove($id);
        Session::flash($response['status'], $response['message']);

        return redirect()->back();
    }
}
