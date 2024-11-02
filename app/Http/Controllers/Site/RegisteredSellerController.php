<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Mostafijur Rahman <[mostafijur.techvill@gmail.com]>
 *
 * @created 06-06-2022
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Requests\Site\SellerRequest;
use App\Http\Requests\Site\StoreSellerRequest;
use Illuminate\Http\Request;
use App\Models\{
    Role,
    User,
    Vendor,
    RoleUser,
    VendorUser,
};
use App\Notifications\SellerRequestToAdminNotification;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Http\Models\Shop;
use App\Services\Mail\BeASellerMailService;
use Illuminate\Support\Facades\Session;
use Str;

class RegisteredSellerController extends Controller
{
    /**
     * RegisteredSellerController Constructor
     *
     * @return void
     */
    public function __construct(EmailController $email)
    {
        $this->email = $email;
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showSignUpForm()
    {
        if (preference('vendor_signup') != '1') {
            abort(404);
        }
        if (Auth::user()) {
            return redirect()->route('site.seller.request-form');
        }

        return view('site.vendor.register');
    }

    public function signUp(StoreSellerRequest $request)
    {
        if (preference('vendor_signup') != '1') {
            abort(404);
        }

        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $request['password'] = \Hash::make($request->password);
        $request['status'] = preference('vendor_default_signup_status') ?? 'Pending';
        $user = User::whereEmail($request->email)->first();
        $has_vendor = User::whereHas('vendorUser')->whereEmail($request->email)->first();
        $vendor = Vendor::withTrashed()->whereEmail($request->email)->first();

        if ($vendor) {
            $response['status'] = 'info';
            $response['message'] = __('The email address has already been taken.');
            $this->setSessionValue($response);

            return redirect()->back();
        }
        if ($has_vendor) {
            $response['status'] = 'info';
            $response['message'] = __('You are already registered.');
            $this->setSessionValue($response);

            return redirect()->route('login');
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
            \DB::commit();
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Vendor')]), 'success');
        } catch (\Exception $e) {
            \DB::rollBack();
            $response['status'] = 'fail';
            $response['message'] = __('Failed! Something has gone wrong. Please contact with admin.');
            $this->setSessionValue($response);

            return redirect()->back();
        }

        $prefer = preference();
        if ($prefer['email'] == 'token') {
            $response['message'] = __('Success! Registration has been done and account activation key has been sent your account.');
            $this->setSessionValue($response);

            return redirect()->route('login');
        }
        Session::put('martvill-seller', User::find($user_id));

        return redirect()->route('site.seller.otp');
    }

    /**
     * Display the seller Request form view.
     *
     * @return \View\Site
     */
    public function showRequestForm()
    {
        // checking if seller sign up is enabled and if not, notifies in the user panel
        if (preference('vendor_signup') != '1') {
            $response = ['status' => 'fail', 'message' => __('Seller sign up is temporarily unavailable. Please try again later.')];
            $this->setSessionValue($response);

            return redirect()->back();
        }

        if (auth()->user()->role()->slug == 'super-admin' || auth()->user()->role()->slug == 'vendor-admin') {
            return redirect()->route('site.index');
        }

        return view('site.vendor.sellerRequestForm');
    }

    public function sellerRequestStore(SellerRequest $request)
    {
        if (preference('vendor_signup') != '1') {
            abort(404);
        }

        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $request['password'] = \Hash::make($request->password);

        try {
            \DB::beginTransaction();

            $data['vendorData'] = $request->only('name', 'email', 'phone', 'formal_name', 'website', 'status');
            $vendorId = (new Vendor())->store($data);
            $request['vendor_id'] = $vendorId;
            $data = $request->only('vendor_id', 'email', 'website', 'alias', 'phone', 'address', 'country', 'state', 'city', 'description');
            $data['name'] = $request->shop_name;
            (new Shop())->store($data);

            // Store user information
            $id = Auth::user()->id;

            if (! empty($id)) {
                $roleId = Role::where('slug', 'vendor-admin')->first()->id;
                $roles = ['user_id' => $id, 'role_id' =>  $roleId];

                if (! empty($roles)) {
                    (new RoleUser())->update($roles);
                }

                $request['user_id'] = $id;
                (new VendorUser())->store($request->only('vendor_id', 'user_id', 'status'));
                User::first()->notify(new SellerRequestToAdminNotification($request));
            }
            \DB::commit();
            $response = $this->messageArray(__('The :x has been successfully submitted.', ['x' => __('Vendor request')]), 'success');
        } catch (\Exception $e) {
            \DB::rollBack();
            $response['status'] = 'fail';
            $response['message'] = __('Something went wrong, please try again.');
            $this->setSessionValue($response);

            return redirect()->back();
        }
        $this->setSessionValue($response);

        return redirect()->route('site.dashboard');
    }

    /**
     * Opt form
     *
     * @return vendor otp form
     */
    public function otpForm()
    {
        $user = Session::get('martvill-seller');
        if ($user) {
            $data['user'] = User::find($user->id);
        }
        if (isset($data['user']) && ! empty($data['user']) && empty($data['user']->email_verified_at)) {
            return view('site.vendor.otp', $data);
        }

        return redirect()->route('site.login');
    }

    /**
     * showResetForm method
     *
     * @param  string  $tokens
     * @return show reset password page view
     */
    public function otpVerification(Request $request)
    {
        if (empty($request->token)) {
            return redirect()->back()->withErrors(['otp' => __('The OTP field is required.')]);
        }

        $user = User::where('activation_otp', $request->token)->whereEmail($request->email)->first();
        if (empty($user)) {
            $response['message'] = __('Your OTP is invalid.');

            return redirect()->back()->withErrors(['otp' => __('Your OTP is invalid.')]);
        }

        $user->update(['activation_otp' => null, 'activation_code' => null, 'status' => 'Active', 'email_verified_at' => now()]);
        User::first()->notify(new SellerRequestToAdminNotification($user));
        Session::forget('martvill-seller');

        return redirect()->route('login');
    }

    /**
     * seller Verification
     *
     * @return $msg
     */
    public function verification($code)
    {
        $user = User::where('activation_code', $code)->first();
        if (empty($user)) {
            $msg = __('Invalid Request');

            return $this->login($msg);
        } elseif ($user->status == 'Active') {
            $msg = __('This account is already activated.');

            return $this->login($msg);
        }

        (new User())->updateUser(['status' => 'Active', 'activation_code' => null, 'activation_otp' => null, 'email_verified_at' => now()], $user->id);
        $msg = __('Your account is activated, please login.');
        User::first()->notify(new SellerRequestToAdminNotification($user));
        Session::forget('martvill-seller');

        return $this->login($msg);
    }

    /**
     * @return login page view
     */
    public function login($verifyMsg = null)
    {
        if (session()->get('prev1') == session()->get('prev3')) {
            return redirect('/admin')->with('loginRequired', true);
        }
        if (isset(Auth::user()->id)) {
            return back();
        }
        if (! is_null($verifyMsg)) {
            return redirect('/admin')->with('loginRequired', true)->with('verifyMsg', $verifyMsg);
        }

        return back()->with('loginRequired', true);
    }

    /**
     * Re-send vendor verification code
     *
     * @param  Request  $request
     *                            return $response;
     */
    public function resendVerificationCode(Request $request)
    {
        $data['activation_code'] = Str::random(10);
        $data['activation_otp'] = random_int(1111, 9999);

        $user = User::where('email', $request->email)->first();

        $result = (new User())->updateUser($data, $user->id);
        $result = User::find($user->id);
        (new BeASellerMailService())->send($result);

        return true;
    }
}
