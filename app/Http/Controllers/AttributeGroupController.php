<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 06-09-2021
 */

namespace App\Http\Controllers;

use App\DataTables\AttributeGroupDataTable;
use App\Exports\AttributeGroupListExport;
use App\Models\{
    AttributeGroup,
    Vendor
};
use Illuminate\Http\Request;
use Excel;

class AttributeGroupController extends Controller
{
    /**
     * list
     *
     * @return mixed
     */
    public function index(AttributeGroupDataTable $dataTable)
    {
        $data['attributeVendors'] = AttributeGroup::select('vendor_id')->distinct()->with('vendor:id,name')->get();

        return $dataTable->render('admin.attribute_group.index', $data);
    }

    /**
     * create
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View1
     */
    public function create()
    {
        $data['vendors'] = Vendor::getAll()->where('status', 'Active');

        return view('admin.attribute_group.create', $data);
    }

    /**
     * store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $validator = AttributeGroup::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request['vendor_id'] = $request->vendor;
        $brandId = (new AttributeGroup())->store($request->only('name', 'vendor_id', 'summary', 'status'));
        if (! empty($brandId)) {
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Attribute Group')]), 'success');
        }
        $this->setSessionValue($response);

        return redirect()->route('attributeGroup.index');
    }

    /**
     * Attribute group edit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $attributeGroups = AttributeGroup::getAll()->where('id', $id)->first();
        if (empty($attributeGroups)) {
            $response = $this->messageArray(__(':x does not exist.', ['x' => __('Attribute Group')]), 'fail');
            $this->setSessionValue($response);

            return redirect()->route('attributeGroup.index');
        }

        $data['attributeGroups'] = $attributeGroups;
        $data['vendors'] = Vendor::getAll()->where('status', 'Active');

        return view('admin.attribute_group.edit', $data);
    }

    /**
     * attribute group update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'attribute_groups');
        if ($result['status'] === true) {
            $validator = AttributeGroup::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $request['vendor_id'] = $request->vendor;
            if ((new AttributeGroup())->updateAttributeGroup($request->only('name', 'vendor_id', 'summary', 'status'), $id)) {
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Attribute Group')]), 'success');
            }
        } else {
            $response['message'] = $result['message'];
        }
        $this->setSessionValue($response);

        return redirect()->route('attributeGroup.index');
    }

    /**
     * Remove Attribute Group
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'attribute_groups');
        if ($result['status'] === true) {
            $response = (new AttributeGroup())->remove($id);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('attributeGroup.index');
    }

    /**
     * Attribute Group list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['attributeGroup'] = AttributeGroup::getAll();

        return printPDF(
            $data,
            'attribute_groups' . time() . '.pdf',
            'admin.attribute_group.list_pdf',
            view('admin.attribute_group.list_pdf', $data),
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
        return Excel::download(new AttributeGroupListExport(), 'attribute_group_lists' . time() . '.csv');
    }
}
