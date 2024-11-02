<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Modules\CMS\Entities\Page;
use Session;

class PageBuilderController extends Controller
{
    public function __construct(Request $request)
    {
        //this middleware should be for POST request only
        if ($request->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('store');
        }
    }

    public function index(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->slug) {
            $page = Page::firstWhere('slug', $request->slug);
            if ($page) {
                $images = File::orderBy('id', 'desc')->get()->map(function ($file) {
                    return [
                        'src' => str_replace('\\', '/', $file->fileUrlNew(['id' => $file->id, 'type' => $file->params['type'] ?? 'items'])),
                        'name' => $file->original_file_name,
                    ];
                });

                return view('pagebuilder::index', compact('page', 'images'));
            }
        }

        Session::flash($data['status'], $data['message']);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        if (! $request->slug) {
            abort(403);
        }

        $page = Page::firstWhere('slug', $request->slug);

        if (! $page) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $page->description = $request->html;
            $page->css = $request->css;
            $page->save();

            return response()->json([
                'data' => $page,
                'status' => 'success',
                'message' => __('Page Updated'),
            ]);
        } else {
            return response()->json([
                'gjs-html' => $page->description,
                'gjs-css' => $page->css,
                'gjs-components' => null,
                'gjs-style' => null,
            ]);
        }
    }

    public function storeImage(Request $request)
    {
        $page = new Page();
        $ids = $page->storeFiles();
        $files = File::orderBy('id', 'desc')->whereIn('id', $ids)->get()->map(function ($file) {
            return [
                'src' => str_replace('\\', '/', $file->fileUrlNew(['id' => $file->id, 'type' => $file->params['type'] ?? 'items'])),
                'name' => $file->original_file_name,
            ];
        });

        return response()->json($files);
    }
}
