<?php

namespace App\Http\Controllers\Api;

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-08-2021
 */
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandDetailResource;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Brand List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $brands = Brand::with('vendor');
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $brands->where('name', strtolower($name));
        }

        $vendor = isset($request->vendor) ? $request->vendor : null;
        if (! empty($vendor)) {
            $brands->whereHas('vendor', function ($q) use ($vendor) {
                $q->where('name', strtolower($vendor));
            })->with('vendor');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $brands->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $brands->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $brands->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orwhereHas('vendor', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('vendor')
                            ->orwhere('status', $keyword);
                    });
                }
            }
        }

        return $this->response([
            'data' => BrandResource::collection($brands->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($brands->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Brand
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $validator = Brand::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        $request['vendor_id'] = $request->vendor;
        $brandId = (new Brand())->store(($request->only('name', 'vendor_id', 'description', 'status')));
        if (! empty($brandId)) {
            // File Upload
            if (isset($request->image) && ! empty($request->image) && $request->hasFile('image')) {
                $path = createDirectory('public/uploads/brand');
                $fileIdList = (new File())->store(
                    [$request->image],
                    $path,
                    'Brand',
                    $brandId,
                    ['isUploaded' => false, 'isOriginalNameRequired' => true]
                );
            }

            // File Upload End
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Brand')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail Brand
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'brands');
        if ($response['status']) {
            return $this->response([
                'data' => new BrandDetailResource(Brand::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Brand Information
     *
     * @return json $data
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'brands');
        if ($response['status']) {
            $validator = Brand::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            if ((new Brand())->updateBrand($request->only('name', 'vendor_id', 'description', 'status'), $id)) {
                if (isset($request->image) && ! empty($request->image)) {
                    //delete file region
                    $fileIds = array_column(
                        json_decode(
                            json_encode(File::Where(['object_type' => 'BRAND', 'object_id' => $id])->get(['id'])),
                            true
                        ),
                        'id'
                    );
                    $oldFileName = isset($fileIds) && ! empty($fileIds) ? File::find($fileIds[0])->file_name : null;
                    if (isset($fileIds) && ! empty($fileIds)) {
                        (new File())->deleteFiles(
                            'BRAND',
                            $id,
                            ['ids' => [$fileIds], 'isExceptId' => false],
                            $path = 'public/uploads/brand'
                        );
                    }
                    //end region
                    //region store files
                    if (isset($id) && ! empty($id) && $request->hasFile('image')) {
                        $path = createDirectory('public/uploads/brand');
                        $fileIdList = (new File())->store(
                            [$request->logo],
                            $path,
                            'BRAND',
                            $id,
                            ['isUploaded' => false, 'isOriginalNameRequired' => true, 'resize' => false]
                        );
                        Cache::forget(config('cache.prefix') . '-brand-image-' . $id);
                    }
                    //end region
                }

                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Brand')]));
            }

            return $this->okResponse([], __('No changes found.'));
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Brand from db.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'brands');
        if ($response['status']) {
            $result = (new Brand())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
