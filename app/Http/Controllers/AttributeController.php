<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-09-2021
 */

namespace App\Http\Controllers;

use App\DataTables\AttributeDataTable;
use App\Exports\AttributeListExport;
use App\Models\{
    Attribute,
    AttributeGroup,
    AttributeValue,
    Category,
    CategoryAttribute
};
use Illuminate\Http\Request;
use Excel;
use DB;

class AttributeController extends Controller
{
    /**
     * list
     *
     * @return mixed
     */
    public function index(AttributeDataTable $dataTable)
    {
        $data['attributeGroups'] = Attribute::select('attribute_group_id')->distinct()->with('attributeGroup:id,name')->get();

        return $dataTable->render('admin.attribute.index', $data);
    }

    /**
     * create
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View1
     */
    public function create()
    {
        $data['attributeGroups'] = AttributeGroup::getAll()->where('status', 'Active');
        $data['categories'] = (new Category())->parents();

        return view('admin.attribute.create', $data);
    }

    /**
     * store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $data = [];
        $validator = Attribute::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request['attribute_group_id'] = $request->attribute_group;

        try {
            DB::beginTransaction();
            $attributeId = (new Attribute())->store($request->only('name', 'is_filterable', 'is_required', 'status', 'description'));
            if (! empty($attributeId)) {
                $attributeValue = $request->values;
                $attributeValue = is_array($attributeValue) ? array_unique($attributeValue) : [];
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
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Attribute')]), 'success');
            }

        } catch (Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage();
        }
        $this->setSessionValue($response);

        return redirect()->route('attribute.index');
    }

    /**
     * Attribute edit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $attributes = Attribute::getAll()->where('id', $id)->first();
        if (empty($attributes)) {
            $response = $this->messageArray(__(':x does not exist.', ['x' => __('Attribute')]), 'fail');
            $this->setSessionValue($response);

            return redirect()->route('attribute.index');
        }

        $data['attributes'] = $attributes;
        $data['attributeValues'] = AttributeValue::getAll()->where('attribute_id', $id)->where('status', 'Active')->sortBy('order_by');
        $data['attributeGroups'] = AttributeGroup::getAll()->where('status', 'Active');

        return view('admin.attribute.edit', $data);
    }

    /**
     * Return Attribute & Attribute value
     *
     * @return false|string
     */
    public function getAttribute(Request $request)
    {
        $categoryAttribute = CategoryAttribute::select('attribute_id')->distinct()->where('category_id', $request->category_id)->WhereHas('attribute', function ($query) {
            $query->where('status', 'Active');
        })->with('attribute')->get();
        $data = [];
        if (! empty($categoryAttribute)) {
            foreach ($categoryAttribute as $attribute) {
                $attributeValue = AttributeValue::getAll()->where('attribute_id', optional($attribute->attribute)->id)->sortBy('order_by');
                $data[] = [
                    'id' =>  optional($attribute->attribute)->id,
                    'name' => optional($attribute->attribute)->name,
                    'is_required' => optional($attribute->attribute)->is_required,
                    'explain' => optional($attribute->attribute)->description,
                    'values' => $attributeValue,
                ];
            }
        }

        return json_encode($data);
    }

    /**
     * attribute update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'attributes');
        if ($result['status'] === true) {
            $validator = Attribute::updateValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();
                if ((new Attribute())->updateAttribute($request->only('name', 'type', 'attribute_group_id', 'category_id', 'is_filterable', 'is_required', 'status', 'description'), $id)) {
                    $attributeValueOld = AttributeValue::getAll()->where('attribute_id', $id)->where('status', 'Active')->pluck('id')->toArray();
                    $attributeValue = array_unique($request->values);
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
                    $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Attribute')]), 'success');
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response['message'] = $e->getMessage();
            }
        } else {
            $response['message'] = $result['message'];
        }
        $this->setSessionValue($response);

        return redirect()->route('attribute.index');
    }

    /**
     * Remove Attribute
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'attributes');
        if ($result['status'] === true) {
            $response = (new Attribute())->remove($id);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('attribute.index');
    }

    /**
     * Attribute Group list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['attributes'] = Attribute::getAll();

        return printPDF(
            $data,
            'attributes' . time() . '.pdf',
            'admin.attribute.list_pdf',
            view('admin.attribute.list_pdf', $data),
            'pdf'
        );
    }

    /**
     * Attribute Group list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new AttributeListExport(), 'attribute_lists' . time() . '.csv');
    }
}
