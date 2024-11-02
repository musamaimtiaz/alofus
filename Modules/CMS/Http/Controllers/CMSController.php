<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\CMS\DataTables\PageDataTable;
use Modules\CMS\Entities\Page as EntitiesPage;
use Modules\CMS\Http\Models\Page;
use Modules\CMS\Http\Models\ThemeOption;
use Modules\CMS\Http\Requests\PageRequest;
use Modules\CMS\Http\Requests\PageUpdateRequest;
use Modules\CMS\Service\HomepageExportService;
use Modules\CMS\Service\HomepageImportService;
use Session;
use Validator;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(PageDataTable $dataTable)
    {
        $pages = Page::where('type', '!=', 'home')->get();

        return view('cms::index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $data['layouts'] = ThemeOption::layouts();

        return view('cms::create', $data);
    }

    /**
     * Create Homepage Form
     *
     * @return Renderable
     */
    public function createHomepage()
    {
        $data['layouts'] = ThemeOption::layouts();
        $data['isHome'] = true;

        return view('cms::create', $data);
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
        $id = (new Page())->store($request->only('name', 'slug', 'status', 'type', 'default', 'layout', 'meta_title', 'meta_description'));

        if ($id) {
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Page')]);
        }

        Session::flash($data['status'], $data['message']);
        if ($request->type == 'home') {
            return redirect()->route('page.home');
        }

        return redirect()->route('page.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($slug)
    {
        $data['page'] = Page::whereSlug($slug)->first();
        $data['layouts'] = ThemeOption::layouts();

        return view('cms::edit', $data);
    }

    public function editHome($slug)
    {
        $data['page'] = Page::whereSlug($slug)->first();
        $data['layouts'] = ThemeOption::layouts();
        $data['isHome'] = true;

        return view('cms::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PageUpdateRequest $request, $id)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];

        if ($request->default) {
            $request->status = 'Active';
        }
        if ((new Page())->updatePage($request->only('name', 'slug', 'status', 'default', 'layout', 'meta_title', 'meta_description'), $id)) {
            if ($request->default == 1) {
                (new Page())->updateDefault($id);
            }
            $data['status'] = 'success';
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Page')]);
        }
        $page = Page::find($id);

        Session::flash($data['status'], $data['message']);

        if ($page->type == 'home') {
            return redirect()->route('page.home');
        }

        return redirect()->route('page.index');
    }

    public function quickUpdate(Request $request, $id)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];

        $page = EntitiesPage::find($id);

        if (! $page) {
            $data['status'] = 'fail';
            $data['message'] = __('Page not found.');

            return redirect()->back();
        }

        $updateFieldArray = ['name', 'slug', 'status'];

        if ($page->default != 1 && $request->default == 1) {
            array_push($updateFieldArray, 'default');
            EntitiesPage::home()->update(['default' => 0]);
        }

        if ($page->default == 1) {
            $request->request->add(['status' => 'Active']);
        }

        $page->update($request->only($updateFieldArray));

        $data['status'] = 'success';

        $data['message'] = __('The :x has been successfully saved.', ['x' => __('Page')]);

        Session::flash($data['status'], $data['message']);

        return redirect()->back();
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

    public function theme()
    {
        return view('cms::theme');
    }

    /**
     * Home pages list
     *
     * @return Renderable
     */
    public function home()
    {
        $data['pages'] = Page::whereNull('vendor_id')->where('type', 'home')->get();

        return view('cms::home', $data);
    }

    /**
     * Export homepage
     *
     * @param  string  $slug
     */
    public function exportHome($slug, HomepageExportService $service)
    {
        $response = $service->export($slug)->getArrayResponse();

        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Import homepage
     */
    public function importHome(Request $request, HomepageImportService $service)
    {
        $validator = Validator::make($request->all(), [
            'attachment' => 'required|mimes:zip,rar,7zip',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(__('Please Upload valid file.'));
        }

        $response = $service->Import()->getArrayResponse();

        $this->setSessionValue($response);

        return redirect()->back();
    }
}
