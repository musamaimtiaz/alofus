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
    AttributeDetailResource,
    AttributeResource
};
use App\Models\{
    Attribute,
    AttributeValue,
};
use Illuminate\Http\Request;
use DB;

class AttributeController extends Controller
{
    /**
     * Attribute List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $attribute = Attribute::select('attributes.*');
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $attribute->where('name', strtolower($name));
        }

        $group = isset($request->attribute_group) ? $request->attribute_group : null;
        if (! empty($group)) {
            $attribute->whereHas('attributeGroup', function ($q) use ($group) {
                $q->where('name', strtolower($group));
            })->with('attributeGroup');
        }

        $category = isset($request->category) ? $request->category : null;
        if (! empty($category)) {
            $attribute->whereHas('category', function ($q) use ($category) {
                $q->where('name', strtolower($category));
            })->with('category');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $attribute->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $attribute->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $attribute->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orwhereHas('attributeGroup', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('attributeGroup')
                            ->orwhereHas('category', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('category')
                            ->orwhere('status', $keyword);
                    });
                }
            }
        }

        return $this->response([
            'data' => AttributeResource::collection($attribute->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($attribute->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Attribute
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $request['values'] = json_decode($request->values);
        $validator = Attribute::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        $request['attribute_group_id'] = $request->attribute_group;

        try {
            DB::beginTransaction();
            $attributeId = (new Attribute())->store(($request->only('name', 'attribute_group_id', 'category_id', 'explain', 'type', 'is_filterable', 'is_required', 'status', 'description')));
            if (! empty($attributeId)) {
                $attributeValue = $request->values;
                if (isset($attributeValue) && count($attributeValue) > 0 && $request->type != 'field') {
                    foreach ($attributeValue as $key => $value) {
                        $data[] = [
                            'attribute_id' => $attributeId,
                            'value' => $value,
                            'order_by' => ++$key,
                        ];
                    }
                    (new AttributeValue())->store($data);
                }
                DB::commit();

                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Attribute')]));
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->unprocessableResponse($e->getMessage());
        }

        return $this->errorResponse();
    }

    /**
     * Detail Attribute
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'attributes');
        if ($response['status']) {
            return $this->response([
                'data' => new AttributeDetailResource(Attribute::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Return Attribute & Attribute value
     *
     * @return false|string
     */
    public function getAttribute(Request $request)
    {
        $response = $this->checkExistence($request->category_id, 'categories');
        if ($response['status']) {
            $attributes = Attribute::getAll()->where('category_id', $request->category_id)->sortBy([
                ['is_required', 'desc'],
            ]);
            $data = [];
            if (! empty($attributes)) {
                foreach ($attributes as $attribute) {
                    $attributeValue = AttributeValue::getAll()->where('attribute_id', $attribute->id)->sortBy('order_by');
                    $data[] = [
                        'id' =>  $attribute->id,
                        'name' => $attribute->name,
                        'type' => $attribute->type,
                        'is_required' => $attribute->is_required,
                        'description' => $attribute->description,
                        'values' => $attributeValue,
                    ];
                }

                return $this->response([
                    'data' => $data,
                ]);
            }
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Attribute Information
     *
     * @return json $data
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'attributes');
        if ($response['status']) {
            $request['values'] = json_decode($request->values);
            $request['value_id'] = AttributeValue::getAll()->where('attribute_id', $id)->pluck('id')->toArray();
            $validator = Attribute::updateValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            $request['attribute_group_id'] = $request->attribute_group;

            try {
                DB::beginTransaction();
                if ((new Attribute())->updateAttribute($request->only('name', 'attribute_group_id', 'category_id', 'explain', 'type', 'is_filterable', 'is_required', 'status', 'description'), $id)) {
                    $attributeValueOld = AttributeValue::getAll()->where('attribute_id', $id)->where('status', 'Active')->pluck('id')->toArray();
                    $attributeValue = $request->values;
                    $attributeId = $request->value_id;
                    $editedValue = [];
                    $orderBy = 1;
                    if (isset($attributeValue) && count($attributeValue) > 0 && $request->type != 'field') {
                        foreach ($attributeValue as $key => $value) {
                            if (isset($attributeId[$key]) && in_array($attributeId[$key], $attributeValueOld)) {
                                (new AttributeValue())->updateAttributeValue([
                                    'value' => $value,
                                    'order_by' => $orderBy++,
                                ], $attributeId[$key]);
                                $editedValue[] = $attributeId[$key];
                            } else {
                                (new AttributeValue())->store([
                                    'attribute_id' => $id,
                                    'value' => $value,
                                    'order_by' => $orderBy++,
                                ]);
                            }
                        }
                        foreach ($attributeValueOld as $old) {
                            if (! in_array($old, $editedValue)) {
                                (new AttributeValue())->remove($old);
                            }
                        }
                    }
                    DB::commit();

                    return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Attribute')]));
                }
            } catch (Exception $e) {
                DB::rollBack();
                $this->unprocessableResponse($e->getMessage());
            }

            return $this->okResponse([], __('No changes found.'));
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Attribute from db.
     *
     * @return json $data
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'attributes');
        if ($response['status']) {
            $result = (new Attribute())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
