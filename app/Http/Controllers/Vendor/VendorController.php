<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 23-10-2021
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateVendorRequest;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use App\DataTables\UserActivityDataTable;
use App\Models\{
    Role,
    User,
    Vendor,
};
use Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Profile
     *
     * @return view
     */
    public function profile()
    {
        $userId = Auth::guard('user')->user()->id;
        $data['user'] = isset($userId) && ! empty($userId) ? User::with('vendors')->get()->where('id', $userId)->first() : null;
        $data['roleIds'] = $data['user']->roles()->pluck('id')->toArray();
        $data['roles'] = Role::getAll();
        $data['vendor'] = $data['user']->vendors->first();

        return view('vendor.profile.index', $data);
    }

    /**
     * Update Vendor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        $result = $this->checkExistence($id, 'users');
        if ($result['status'] === true) {
            $request['phone'] = $request['dial_code'] . $request['phone'];
            $validator = User::updateProfileValidation($request->all(), $id);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;

            $data['userData'] = $request->only('name', 'email', 'phone');
            $data['userMetaData'] = $request->only('designation', 'description', 'facebook', 'twitter', 'instagram');
            (new user())->updateUser($data, $id);

            $response['status'] = 'success';
            $response['message'] = __('The :x has been successfully saved.', ['x' => strtolower(__('Vendor Info'))]);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);
        if (isset($request->user_profile)) {
            return redirect()->back();
        }

        return redirect()->route('vendor-dashboard');
    }

    /**
     * Update password
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function updatePassword(Request $request, $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($id, 'users', ['getData' => true]);
            if ($response['status'] === true) {
                $validator = User::updatePasswordValidation($request->all());
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $request['user_name'] =  $response['data']->name;
                $request['email'] =  $response['data']->email;
                $request['raw_password'] = $request->password;
                $request['updated_at'] = date('Y-m-d H:i:s');
                $request['password'] = \Hash::make(trim($request->password));
                if ((new User())->updateUser($request->only('password', 'updated_at'), $id)) {
                    $data['status'] = 'success';
                    $data['message'] = __('Password update successfully.');
                } else {
                    $data['message'] = __('Nothing is updated.');
                }
            } else {
                $data['message'] = $response['message'];
            }
        }

        $this->setSessionValue($data);

        return redirect()->route('vendor-dashboard');
    }

    /**
     * logout operation.
     *
     * @return redirect login page view
     */
    public function logout()
    {
        $user = Auth::user();
        Auth::guard('user')->logout();

        if (isset($user)) {
            (new ActivityLogService())->userLogout('success', 'Logout successful', $user);
        }

        return redirect()->route('site.index');
    }

    /**
     * Update vendor
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function updateVendor(UpdateVendorRequest $request, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        $result = $this->checkExistence($id, 'vendors');
        if ($result['status'] === true) {
            try {
                DB::beginTransaction();
                $data['vendorData'] = $request->only('name', 'email', 'phone', 'formal_name', 'website');
                $data['vendorMetaData'] = $request->only('description', 'cover_photo', 'vendor_logo');
                (new Vendor())->updateVendor($data, $id);
                $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');
                DB::commit();
            } catch (\App\Exceptions\EmailException $th) {
                DB::rollBack();
                $response['status'] = 'fail';
                $response['message'] = __('Failed! Please configure your mail or template properly.');
            }
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('vendor-dashboard');
    }

    /**
     * Show only vendor activity
     *
     * @return mixed
     */
    public function loginActivity(UserActivityDataTable $dataTable)
    {
        $logTypes = ['USER LOGIN', 'USER LOGOUT'];

        return $dataTable->render('vendor.profile.login_activity', ['logTypes' => $logTypes]);
    }
}
