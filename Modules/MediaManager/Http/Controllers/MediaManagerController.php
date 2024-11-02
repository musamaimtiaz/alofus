<?php

namespace Modules\MediaManager\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\MediaManager\Http\Requests\MediaManagerRequest;
use Modules\MediaManager\Http\Models\MediaManager;
use App\Models\File;
use App\Models\Preference;
use DB;
use Response;
use Session;
use Modules\MediaManager\Http\Models\ObjectFile;

class MediaManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('mediamanager::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $acceptedFiles = getFileExtensions();
        $acceptedFiles = checkNullExtension($acceptedFiles);
        $data['Files'] = implode(',', $acceptedFiles);
        $array = explode(',', ('.' . implode(',.', $acceptedFiles)));
        $data['acceptedFiles'] = implode(',', $array);

        return view('mediamanager::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response|JSON string
     */
    public function store(MediaManagerRequest $request)
    {
        if ((new MediaManager())->store($request->all())) {
            return Response::json('success', 200);
        }

        return Response::json('failed', 417);
    }

    /**
     * Adds or uploads file from media manager to view form. Provide file ids to get data.
     *
     * @return \Illuminate\Http\Response|JSON string
     */
    public function upload(Request $request)
    {
        $fileIds = implode(',', $request->file_id);
        $data['files'] = File::whereIn('id', $request->file_id)->orderByRaw("FIELD(id, $fileIds)")->get();
        $html = view('mediamanager::image.uploaded_image', $data)->render();

        return response()->json([
            'data' => $data['files']->map(function ($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->original_file_name,
                    'path' => $file->file_name,
                    'url' => asset('public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $file->file_name),
                ];
            }),
            'html' => $html,
        ]);
    }

    /**
     * Upload files
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function uploadedFiles()
    {
        $data['files'] = File::getAllFiles();

        return view('mediamanager::uploaded_files', $data);
    }

    /**
     * Sort files
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function sortFiles()
    {
        $data['files'] = File::getAllFiles();

        return view('mediamanager::image.sorted_image', $data);
    }

    /**
     * Paginate files
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function paginateFiles()
    {
        $data['files'] = File::getAllFiles();

        return view('mediamanager::image.sorted_image', $data);
    }

    /**
     * Paginate data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function paginateData(Request $request)
    {
        if ($request->ajax()) {
            $sortValue = request()->sort_value ?? null;
            $searchValue = isset(request()->search_value) ? request()->search_value : '';
            $files = File::query()->sortByDefinedValue($sortValue)->whereLike('original_file_name', $searchValue);

            if (! empty($request->imageType)) {
                $type = explode(',', $request->imageType);
                $files = $files->whereIn('object_type', $type);
            }

            $data['files'] = $files->simplePaginate(preference('row_per_page', 10));

            return view('mediamanager::image.child_paginate', $data)->render();
        }
    }

    /**
     * Download Files
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function download($id)
    {
        $file = File::where('id', $id)->first();
        if ($file) {
            $imageName = str_replace(DIRECTORY_SEPARATOR, '', $file->file_name);
            $image = public_path('uploads' . DIRECTORY_SEPARATOR . $file->file_name);
            if (file_exists($image)) {
                switch (strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION))) {
                    case 'pdf':
                        $mime = 'application/pdf';

                        break;
                    case 'zip':
                        $mime = 'application/zip';

                        break;
                    case 'jpeg':
                    case 'jpg':
                        $mime = 'image/jpg';

                        break;
                    default:
                        $mime = 'application/force-download';
                }

                $headers = [
                    'Content-Type' => $mime,
                ];

                return Response::download($image, $file->original_file_name, $headers);
            } else {
                if (file_exists(public_path('dist\img' . DIRECTORY_SEPARATOR . 'default_product.jpg'))) {
                    return Response::download(public_path('dist\img' . DIRECTORY_SEPARATOR . 'default_product.jpg'), 'default_product.jpg', ['image/jpg']);
                }
                $data = ['status' => 'fail', 'message' => __('The file you are looking for is not found.')];
                Session::flash($data['status'], $data['message']);

                return redirect()->back();
            }
        } else {
            $data = ['status' => 'fail', 'message' => __('This file does not exist.')];
            Session::flash($data['status'], $data['message']);

            return redirect()->back();
        }
    }

    /**
     * Delete Image
     *
     * @return string:false
     */
    public function deleteImage(Request $request)
    {
        $image = File::where('id', $request->id)->first();
        if ($image) {
            if (file_exists(public_path(DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $image->file_name))) {
                unlink(public_path(DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $image->file_name));
                DB::beginTransaction();
                ObjectFile::where('file_id', $image->id)->delete();
                $image->delete();
                $this->removeThumbnail($image);
                DB::commit();

                return json_encode(['resp' => __('success')]);
            }
        }

        return json_encode(['resp' => __('error')]);
    }

    /**
     * Get thumbnail path
     *
     * @param  string  $size
     * @param  object  $image
     * @return string
     */
    private function getThumbnailPath($size, $image)
    {
        return public_path(implode(DIRECTORY_SEPARATOR, ['uploads', config('martvill.thumbnail_dir'), $size, $image->file_name]));
    }

    /**
     * Remove thumbnail if exist
     *
     * @param  object  $image
     * @return void
     */
    private function removeThumbnail($image)
    {
        $sizes = array_keys((new File())->sizeRatio());

        foreach ($sizes as $value) {
            if (file_exists($this->getThumbnailPath($value, $image))) {
                unlink($this->getThumbnailPath($value, $image));
            }
        }
    }

    /**
     * Store Extension
     *
     * @return json
     */
    public function storeExtension(Request $request)
    {
        $data = json_encode($request->data);
        (new Preference())->storeOrUpdate(['category' => 'preference', 'field' => 'file_extension', 'value' => $data]);

        return response()->json([
            'status' => 200,
            'message' => __('The :x has been saved successfully.', ['x' => strtolower(__('Extension'))]),
        ]);
    }

    /**
     * Get Extension
     *
     * @return json
     */
    public function getExtensionAjaxQuery()
    {
        $extensions = preference('file_extension');

        if (empty($extensions)) {
            return response()->json([
                'extensions' => __('No Extension Available'),
            ]);
        }

        $data = json_decode($extensions, true);

        return response()->json([
            'status' => 200,
            'extensions' => $data,
        ]);
    }
}
