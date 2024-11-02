<?php
/**
 * @package VendorController
 * @author TechVillage <support@techvill.org>
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Md. Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 * @created 17-08-2021
 * @modified 29-09-2021
 * @modified 15-03-2023
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\VendorListDataTable;
use App\Exports\VendorListExport;
use App\Http\Controllers\Controller;
use App\Services\Mail\UserMailService;
use Modules\Shop\Http\Models\Shop;
use Modules\Commission\Http\Models\Commission;
use App\Http\Resources\AjaxSelectSearchResource;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\{
    StoreVendorRequest,
    UpdateVendorRequest
};
use App\Models\{
    Role,
    User,
    Vendor,
};
use Excel, Str;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Constructor
     * @param EmailController $email
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Vendor List
     * @param VendorListDataTable $dataTable
     * @return mixed
     */
    public function index(VendorListDataTable $dataTable)
    {

        return $dataTable->render('admin.vendors.index');
    }

    /**
     * Vendor create
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['roles'] = Role::getAll()->where('type', 'vendor');
        $data['commission'] = Commission::getAll()->first();

        return view('admin.vendors.create', $data);
    }

    /**
     * Store vendor
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVendorRequest $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        if ($this->c_p_c()) {
            Session::flush();
            return view('errors.installer-error', ['message' => __(strrev("x: morf edoc esahcrup ruoy yfirev esaelP .eussi noitadilav esnecil gnicaf si tcudorp sihT"), ['x' => '<a style="color:#fcca19" href="' . route('purchase-code-check', ['bypass' => 'purchase_code']) .'">'. __('here') . '</a>']) ]);
        }

        do_action('before_vendor_create');

        try {
            DB::beginTransaction();

            $vendor = Vendor::withTrashed()->where('email', $request->email)->first();
            $vendorId = $vendor?->id;
            if (!$vendor) {
                $vendorId = (new Vendor)->store($request->vendor_data);
                $request['vendor_id'] = $vendorId;
                $alias = cleanedUrl($request->alias);
                $request->merge(['alias' => $alias]);
                (new Shop)->store($request->only('vendor_id', 'name', 'email', 'website', 'alias', 'phone', 'address'));
            } else {
                $vendor->restore();
            }

            $user = User::where('email', $request->email)->first();
            $id = $user?->id;
            if (!$user) {
                 // Store user information
                $id = (new User)->store($request->only('name', 'email', 'password', 'activation_code', 'status'));
            }

            $user = User::find($id);
            $user->roles()->sync($request->role_ids);
            $user->vendors()->sync($vendorId);

            if (isset($request->send_mail) && $request->status != 'Inactive' && !empty($request['email'])) {
                $emailResponse = (new UserMailService)->send($request);

                if ($emailResponse['status'] == false) {
                    throw new \Exception(__('Email is not send.'));
                    
                }
            }

            \DB::commit();

            do_action('after_vendor_create', ['vendor_id' => $vendorId, 'user' => $user]);

            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');

        } catch (\Exception $e) {
            \DB::rollBack();
            $response['status'] = 'fail';
            $response['message'] = $e->getMessage();
        }

        $this->setSessionValue($response);

        return redirect()->route('vendors.index');
    }

    /**
     * Edit vendor
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $vendor = Vendor::getAll()->where('id', $id)->first();

        if (empty($vendor)) {
            $response = $this->messageArray( __(':x does not exist.', ['x' => __('Vendor')]), 'fail');
            $this->setSessionValue($response);
            return redirect()->route('vendors.index');
        }

        $data['commission'] = Commission::getAll()->first();
        $data['vendors'] = $vendor;
        $data['shops'] = Shop::getAll()->where('vendor_id', $id);
        $data['shop_exist'] = isset($request->shop) && !empty($request->shop) ? $request->shop : null;

        return view('admin.vendors.edit', $data);
    }

    /**
     * Update Vendor
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'vendors');

        if ($result['status'] === false) {
            $response['message'] = $result['message'];
            $this->setSessionValue($response);
            return redirect()->route('vendors.index');
        }

        (new Vendor)->updateVendor($request->data, $id);
        $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');
        $this->setSessionValue($response);

        if ($request->shop) {
            return redirect()->route('shop.index');
        }

        return redirect()->route('vendors.index');
    }

    /**
     * Remove Vendor
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'vendors');

            if ($result['status'] === true) {
                $response = (new Vendor)->remove($id);
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->route('vendors.index');
    }

    /**
     * Vendor list pdf
     * @return html static page
     */
    public function pdf()
    {
        $data['vendors'] = Vendor::getAll();

        return printPDF($data, 'vendors_lists' . time() . '.pdf', 'admin.vendors.list_pdf', view('admin.vendors.list_pdf', $data), 'pdf');
    }

    /**
     * Vendor list csv
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorListExport(), 'vendor_lists' . time() . '.csv');
    }

    /**
     * Find vendors
     *
     * @param Request $request
     * @return json
     */
    public function findVendor(Request $request)
    {
        $vendors = Vendor::whereLike('name', $request->q)->limit(10)->get();
        return AjaxSelectSearchResource::collection($vendors);
    }

    public function c_p_c() {
		p_c_v();
		return false;
    }
}
