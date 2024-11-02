<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-08-2021
 *
 * @modified 29-09-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{
    StoreVendorRequest,
    UpdateVendorRequest
};
use App\Http\Resources\{
    VendorResource
};
use App\Models\{
    File,
    Vendor
};
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Vendor List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs        = $this->initialize([], $request->all());
        $vendors        = Vendor::select('vendors.*');
        $name           = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $vendors->where('name', strtolower($name));
        }

        $email = isset($request->email) ? $request->email : null;
        if (! empty($email)) {
            $vendors->where('email', strtolower($email));
        }

        $phone = isset($request->phone) ? $request->phone : null;
        if (! empty($phone)) {
            $vendors->where('phone', $phone);
        }

        $formalName = isset($request->formal_name) ? $request->formal_name : null;
        if (! empty($formalName)) {
            $vendors->where('formal_name', strtolower($formalName));
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $vendors->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $vendors->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orwhere('phone', 'LIKE', '%' . $keyword . '%');
                });
            } elseif (strlen($keyword) >= 3) {
                $vendors->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('phone', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('formal_name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', $keyword);
                });
            }
        }

        return $this->response([
            'data' => VendorResource::collection($vendors->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($vendors->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store vendor
     *
     * @return json $data
     */
    public function store(StoreVendorRequest $request)
    {
        $vendorId = (new Vendor())->store($request->only('name', 'email', 'phone', 'formal_name', 'website', 'status'));
        if (! empty($vendorId)) {
            // File Upload
            if (isset($request->logo) && ! empty($request->logo) && $request->hasFile('logo')) {
                $path = createDirectory('public/uploads/vendor');
                $fileIdList = (new File())->store(
                    [$request->logo],
                    $path,
                    'VENDOR',
                    $vendorId,
                    ['isUploaded' => false, 'isOriginalNameRequired' => true]
                );
            }

            // File Upload End
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Vendor')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail vendor
     *
     * @param  int  $id
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'vendors');
        if ($response['status']) {
            return $this->response([
                'data' => new VendorResource(Vendor::find($id))]);
        }

        return $this->notFoundResponse([], $response['message']);
    }

    /**
     * Update Vendor Information
     *
     * @return json $data
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'vendors');
        if ($response['status']) {
            if ((new Vendor())->updateVendor($request->only('name', 'email', 'phone', 'formal_name', 'website', 'status'), $id)) {
                if (isset($request->logo) && ! empty($request->logo)) {
                    //delete file region
                    $fileIds = array_column(json_decode(json_encode(File::Where(['object_type' => 'VENDOR', 'object_id' => $id])->get(['id'])), true), 'id');
                    $oldFileName = isset($fileIds) && ! empty($fileIds) ? File::find($fileIds[0])->file_name : null;
                    if (isset($fileIds) && ! empty($fileIds)) {
                        (new File())->deleteFiles('VENDOR', $id, ['ids' => [$fileIds], 'isExceptId' => false], $path = 'public/uploads/vendor');
                    }
                    //end region
                    //region store files
                    if (isset($id) && ! empty($id) && $request->hasFile('logo')) {
                        $path = createDirectory('public/uploads/vendor');
                        $fileIdList = (new File())->store([$request->logo], $path, 'VENDOR', $id, ['isUploaded' => false, 'isOriginalNameRequired' => true, 'resize' => false]);
                        \Cache::forget(config('cache.prefix') . '-vendor-logo-' . $id);
                    }
                    //end region
                }

                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Vendor')]));
            }

            return $this->okResponse([], __('No changes found.'));
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Currency from db.
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'vendors');
        if ($response['status']) {
            $result  = (new Vendor())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
