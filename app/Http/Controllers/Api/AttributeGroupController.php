<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-10-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    AttributeGroupDetailResource,
    AttributeGroupResource
};
use App\Models\AttributeGroup;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    /**
     * Group List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $groups = AttributeGroup::select('attribute_groups.*');
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $groups->where('name', strtolower($name));
        }

        $vendor = isset($request->vendor) ? $request->vendor : null;
        if (! empty($vendor)) {
            $groups->whereHas('vendor', function ($q) use ($vendor) {
                $q->where('name', strtolower($vendor));
            })->with('vendor');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $groups->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $groups->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $groups->where(function ($query) use ($keyword) {
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
            'data' => AttributeGroupResource::collection($groups->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($groups->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Group
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $validator = AttributeGroup::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        $request['vendor_id'] = $request->vendor;
        $groupId = (new AttributeGroup())->store(($request->only('name', 'vendor_id', 'summary', 'status')));
        if (! empty($groupId)) {
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Attribute Group')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail Group
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'attribute_groups');
        if ($response['status']) {
            return $this->response([
                'data' => new AttributeGroupDetailResource(AttributeGroup::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Group Information
     *
     * @return json $data
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'attribute_groups');
        if ($response['status']) {
            $validator = AttributeGroup::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $request['vendor_id'] = $request->vendor;
            if ((new AttributeGroup())->updateAttributeGroup($request->only('name', 'vendor_id', 'summary', 'status'), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Attribute Group')]));
            }

            return $this->okResponse([], __('No changes found.'));
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Group from db.
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'attribute_groups');
        if ($response['status']) {
            $result = (new AttributeGroup())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
