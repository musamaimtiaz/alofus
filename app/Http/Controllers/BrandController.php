<?php

namespace App\Http\Controllers;

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-08-2021
 */
use App\DataTables\BrandListDataTable;
use App\Exports\BrandListExport;
use App\Models\{
    Brand,
};
use Illuminate\Http\Request;
use Excel;

class BrandController extends Controller
{
    /**
     * Brand List
     *
     * @return mixed
     */
    public function index(BrandListDataTable $dataTable)
    {
        return $dataTable->render('admin.brands.index');
    }

    /**
     * Brand create
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store Brand
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        if ($request->isMethod('post')) {
            $validator = Brand::storeValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $brandId = (new Brand())->store($request->only('name', 'description', 'status'));

            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Brand')]), 'success');
        }
        $this->setSessionValue($response);

        return redirect()->route('brands.index');
    }

    /**
     * Edit Brand
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $brand = Brand::getAll()->where('id', $id)->first();
        if (empty($brand)) {
            $response = $this->messageArray(__(':x does not exist.', ['x' => __('Brand')]), 'fail');
            $this->setSessionValue($response);

            return redirect()->route('brands.index');
        }
        $data['brands'] = $brand;

        return view('admin.brands.edit', $data);
    }

    /**
     * Update Brand
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'brands');
            if ($result['status'] === true) {
                $validator = Brand::updateValidation($request->all(), $id);
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                if ((new Brand())->updateBrand($request->only('name', 'description', 'status'), $id)) {
                    $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Brand')]), 'success');
                }
            } else {
                $response['message'] = $result['message'];
            }
        }
        $this->setSessionValue($response);

        return redirect()->route('brands.index');
    }

    /**
     * Remove Brand
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'brands');
            if ($result['status'] === true) {
                $response = (new Brand())->remove($id);
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->route('brands.index');
    }

    /**
     * Brand list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['brands'] = Brand::getAll();

        return printPDF(
            $data,
            'brands_lists' . time() . '.pdf',
            'admin.brands.list_pdf',
            view('admin.brands.list_pdf', $data),
            'pdf'
        );
    }

    /**
     * Brand list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new BrandListExport(), 'brands_lists' . time() . '.csv');
    }
}
