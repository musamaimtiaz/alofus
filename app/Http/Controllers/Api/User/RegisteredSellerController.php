<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\StoreSellerRequest;
use App\Models\{
    Role,
    RoleUser,
    User,
    Vendor,
    VendorUser
};
use App\Notifications\SellerRequestToAdminNotification;
use App\Services\Mail\{
    BeASellerMailService,
};
use Illuminate\Http\Request;
use Modules\Shop\Http\Models\Shop;
use Str;

class RegisteredSellerController extends Controller
{
    /**
     * seller sign up
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function signUp(StoreSellerRequest $request)
    {
        $response = ['status' => false, 'message' => __('Invalid Request')];
        if (preference('vendor_signup') != '1') {
            return $this->errorResponse([], 404, $response['message']);
        }

        $request['password'] = \Hash::make($request->password);
        $request['status'] = preference('vendor_default_signup_status') ?? 'Pending';
        $user = User::whereEmail($request->email)->first();
        $has_vendor = User::whereHas('vendorUser')->whereEmail($request->email)->first();
        $vendor = Vendor::withTrashed()->whereEmail($request->email)->first();

        if ($vendor) {
            $response['message'] = __('The email address has already been taken.');

            return $this->errorResponse([], 500, $response['message']);
        }
        if ($has_vendor) {
            $response['message'] = __('You are already registered.');

            return $this->errorResponse([], 500, $response['message']);
        }

        try {
            \DB::beginTransaction();

            // Store user information
            if (empty($user)) {
                $user_id = (new User())->store($request->only('name', 'email', 'password', 'activation_code', 'activation_otp', 'status'));
            } else {
                $user_id = $user->id;
            }
            // Store vendor information
            $data['vendorData'] = $request->only('name', 'email', 'phone', 'formal_name', 'website', 'status');
            $vendorId = (new Vendor())->store($data);

            // Store shop information
            $request['vendor_id'] = $vendorId;
            $alias = cleanedUrl($request->name);
            $request->merge(['alias' => $alias]);
            (new Shop())->store($request->only('name', 'vendor_id', 'email', 'website', 'alias', 'phone', 'address', 'country', 'state', 'city', 'post_code'));

            if (! empty($user_id)) {
                $roleId = Role::where('slug', 'vendor-admin')->first()->id;
                $roles = ['user_id' => $user_id, 'role_id' =>  $roleId];

                if (! empty($roles)) {
                    (new RoleUser())->update($roles);
                }

                $request['user_id'] = $user_id;
                (new VendorUser())->store($request->only('vendor_id', 'user_id', 'status'));
                (new BeASellerMailService())->send($request);
            }
            $prefer = preference();
            \DB::commit();
            $response['message'] = __('The :x has been successfully saved.', ['x' => __('Vendor')]);
        } catch (\Exception $e) {
            \DB::rollBack();
            $response['message'] = __('Failed! Something has gone wrong. Please contact with admin.');

            return $this->errorResponse([], 500, $response['message']);
        }

        $prefer = preference();
        if ($prefer['email'] == 'token') {
            $response['message'] = __('Success! Registration has been done and account activation key has been sent your account.');
        }

        return $this->response(['data' => $response['message'], 'userData' => User::find($user_id)]);
    }

    /**
     * otp verification
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function otpVerification(Request $request)
    {
        if (empty($request->token)) {
            return $this->errorResponse([], 404, __('The OTP field is required.'));
        } elseif (empty($request->email)) {
            return $this->errorResponse([], 404, __('The Email field is required.'));
        }

        $user = User::where('activation_otp', $request->token)->whereEmail($request->email)->first();
        if (empty($user)) {
            $this->errorResponse([], 404, __('Your OTP is invalid.'));
        }

        $user->update(['activation_otp' => null, 'activation_code' => null, 'status' => 'Active', 'email_verified_at' => now()]);
        User::first()->notify(new SellerRequestToAdminNotification($user));

        return $this->response(['data' => __('Verified Successfully')]);
    }

    /**
     * resend verification
     *
     * @return array|\Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function resendVerificationCode(Request $request)
    {
        $data['activation_code'] = Str::random(10);
        $data['activation_otp'] = random_int(1111, 9999);

        $user = User::where('email', $request->email)->first();

        $result = (new User())->updateUser($data, $user->id);
        $result = User::find($user->id);
        (new BeASellerMailService())->send($result);
        $msg = __('Email sent successfully. Please check your email.');

        return $this->response(['data' => $msg]);
    }
}
