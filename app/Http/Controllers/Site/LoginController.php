<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Requests\Admin\AuthUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\{
    Controller
};
use App\Models\{
    PasswordReset,
    Role,
    RoleUser,
    User,
    Wishlist
};
use App\Notifications\ResetPasswordNotification;
use App\Notifications\UserPasswordSetNotification;
use App\Notifications\UserVerificationNotification;
use App\Notifications\WelcomeUserNotification;
use App\Services\ActivityLogService;
use Str;
use DB;
use Auth;
use Cart;
use Compare;
use Cookie;

class LoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ckname = explode('_', Auth::getRecallerName())[2];
        $this->middleware('guest:user')->except('logout');
    }

    /**
     * @return login page view
     */
    public function login(Request $request, $verifyMsg = null)
    {
        $value = Cookie::get($this->ckname);
        if (! is_null($value)) {
            $rememberedUser = explode('.', explode($this->ckname, decrypt($value))[1]);
            if ($rememberedUser[1] == 'user' && Auth::guard('user')->loginUsingId($rememberedUser[0])) {
                $ckkey = encrypt($this->ckname . Auth::user()->id . '.user');
                Cookie::queue($this->ckname, $ckkey, 2592000);

                return redirect()->intended(session()->get('nextUrl'));
            }
        }

        if (session()->get('prev1') == session()->get('prev3')) {
            if (! isset($request['page'])) {
                return redirect()->route('site.index')->with('loginRequired', true);
            }
            if ($request['page'] == 'reset-password') {
                return redirect()->route('site.index', ['page' => $request['page']])->with('loginRequired', true);
            }
            if ($request['page'] == 'confirm-password') {
                return redirect()->route('site.index', ['page' => $request['page'], 'id' => $request['id'], 'token' => $request['token']])->with('loginRequired', true);
            }
        }
        if (isset(Auth::user()->id)) {
            return back();
        }
        if (! is_null($verifyMsg)) {
            return redirect('/')->with('loginRequired', true)->with('verifyMsg', $verifyMsg);
        }

        return back()->with('loginRequired', true);
    }

    public function signUp(Request $request)
    {
        if (preference('customer_signup') != '1') {
            return ['status' => 0, 'error' => __('Customer sign up temporarily unavailable.')];
        }

        $response = ['status' => 0];
        $role = Role::getAll()->where('slug', 'customer')->first();
        $request['status'] = preference('user_default_signup_status') ?? 'Pending';
        $request['phone'] = $request['dial_code'] . $request['phone'];
        $validator = User::siteStoreValidation($request->all());

        if ($validator->fails()) {
            $response['status'] = 0;
            $response['error'] = $validator->errors();

            return $response;
        }

        $request['raw_password'] = $request->password;
        $request['password'] = \Hash::make($request->password);
        $request['email'] = validateEmail($request->email) ? strtolower($request->email) : null;
        $request['activation_code'] = Str::random(10);
        $request['activation_otp'] = random_int(1111, 9999);
        $request['from'] = 'web';

        try {
            DB::beginTransaction();
            $id = (new User())->store($request->only('name', 'email', 'phone', 'activation_code', 'activation_otp', 'password', 'status'));
            if (! empty($id)) {
                if (! empty($role)) {
                    (new RoleUser())->store(['user_id' => $id, 'role_id' => $role->id]);
                }

                $notification = $request->status == 'Active' ? new WelcomeUserNotification($request) : new UserVerificationNotification($request);

                User::firstWhere('email', $request->email)->notify($notification);

                if (isActive('Affiliate') && isset($request->reference)) {
                    \Modules\Affiliate\Entities\ReferralUser::referralUserStore($request->reference, $id);
                }

                DB::commit();
                $response['status'] = 1;

                return $response;
            }
        } catch (Exception $e) {
            DB::rollBack();

            return ['status' => 0, 'error' => $e->getMessage()];
        }
    }

    /**
     * Login authenticate operation.
     *
     * @return array response
     */
    public function authenticate(AuthUserRequest $request)
    {
        $supportEmail = preference('company_email');
        $message = [
            'Deleted' => __('Invalid email or password'),
            'Pending' => __('Please verify your email address.') . ' <a class="underline cursor-pointer text-gray-12 user-verification">' . __('Click here to verify.') . '</a>',
            'Inactive' => __('Sorry, your account is not activated. Please contact with :x', ['x' =>  "<a href='mailto:" . $supportEmail . "'>" . $supportEmail . '</a>']),
        ];

        $loginType = $request->email ? 'email' : 'phone';
        $loginValue = $request->email ?? $request->phone;

        $user = User::where($loginType, $loginValue)->first();

        if (empty($user) || ! \Hash::check($request->password, $user->password)) {
            (new ActivityLogService())->userLogin('failed', 'Incorrect');

            $message = $loginType == 'email'
                ? __('Email or Password is incorrect!')
                : __('Phone or Password is incorrect!');

            return ['status' => 0, 'message' => $message];
        }

        if (array_key_exists($user->status, $message)) {
            (new ActivityLogService())->userLogin('failed', $user->status);

            return ['status' => 0, 'message' => $message[$user->status]];
        }

        if (! Auth::guard('user')->attempt($request->only($loginType, 'password'))) {
            (new ActivityLogService())->userLogin('failed', 'Invalid');

            return ['status' => 0, 'message' => __('Invalid User')];
        }

        (new ActivityLogService())->userLogin('success', 'Login successful');

        // Cart and compare data transfer
        Cart::cartDataTransfer();
        Compare::compareDataTransfer();

        // Show welcome message when enter user dashboard first time after login.
        session()->put('welcomeUser', true);
        session()->put('vendorId', optional(auth()->user()->vendor())->vendor_id);

        if (! is_null($request->remember_me)) {
            $ckkey = encrypt($this->ckname . Auth::user()->id . '.user');
            Cookie::queue($this->ckname, $ckkey, 2592000);
        }
        // Wishlist store if user try without login
        if (! empty($_COOKIE['product_id'])) {
            if (! (new Wishlist())->checkExistence(auth()->user()->id, $_COOKIE['product_id'])) {
                (new Wishlist())->store(['product_id' => $_COOKIE['product_id'], 'user_id' => auth()->user()->id]);
            }
            setcookie('product_id', '', time() - 3600);
        }

        return ['status' => 1, 'message' => __('You are now logged in!')];
    }

    /**
     * User Verification
     *
     * @return $msg
     */
    public function verification(Request $request, $code, $from = 'web')
    {
        $user = User::where('activation_code', $code)->first();
        if (empty($user)) {
            $msg = __('Invalid Request');

            return $this->login($request, $msg);
        } elseif ($user->status == 'Active' && $from == 'web') {
            $msg = __('This account is already activated.');

            return $this->login($request, $msg);
        } elseif ($user->status == 'Active' && $from == 'api') {
            return Redirect::to(preference('app_open_url'));
        }

        if ((new User())->updateUser(['status' => 'Active', 'activation_code' => null, 'activation_otp' => null, 'email_verified_at' => now()], $user->id)) {
            $msg = __('Your account is activated, please login.');

            if ($from == 'api') {
                return Redirect::to(preference('app_open_url'));
            }

            return $this->login($request, $msg);
        }
    }

    /**
     * User Verification by otp
     *
     * @return array $response
     */
    public function verifyByOtp($code)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid OTP provided')];
        $user = User::where('activation_otp', $code)->first();
        if (empty($user)) {
            return $response;
        }

        if ((new User())->updateUser(['status' => 'Active', 'activation_code' => null, 'activation_otp' => null, 'email_verified_at' => now()], $user->id)) {
            return ['status' => 'success', 'message' =>  __('Your account is activated, please login.')];
        }
    }

    /**
     * use Google driver
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * take data from Google and save in db & redirect in main page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handelGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user, 'Google');

        return redirect()->route('site.index');
    }

    /**
     * use Facebook driver
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * take data from Facebook and save in db & redirect in main page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handelFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $response = $this->_registerOrLoginUser($user, 'Facebook');
        if ($response == true) {
            return redirect()->route('site.index');
        } else {
            return redirect()->route('site.emailSignup');
        }
    }

    /**
     * save user data
     */
    protected function _registerOrLoginUser($data, $service = null)
    {
        if (isset($data->email) && ! empty($data->email) && $data->email != '') {

            $user = User::where('email', '=', $data->email)->first();

            if (! $user) {
                try {
                    DB::beginTransaction();
                    $id = (new User())->store(['name' => $data->name, 'email' => $data->email, 'password' => \Hash::make(Str::random(5)), 'status' => 'Active',  'sso_account_id' => $data->id, 'sso_service' => $service], 'url', $data->avatar);
                    if (! empty($id)) {
                        $role = Role::getAll()->where('slug', 'customer')->first();
                        if (! empty($role)) {
                            (new RoleUser())->store(['user_id' => $id, 'role_id' => $role->id]);
                        }

                        if (isActive('Affiliate') && session()->has('aff_reference')) {
                            \Modules\Affiliate\Entities\ReferralUser::referralUserStore(session()->get('aff_reference'), $id);
                            session()->forget('aff_reference');
                        }

                        DB::commit();
                    }
                } catch (Exception $e) {
                    DB::rollBack();
                }
                $user = User::where('id', '=', $id)->first();
            }

            if (! empty($user) && $user->status != 'Active') {
                User::where('email', $data->email)->update(['status' => 'Active']);
            }

            Auth::guard('user')->login($user);
            Cart::cartDataTransfer();
            Compare::compareDataTransfer();

            return true;
        } else {
            $userData = [
                'name' => $data->name,
                'password' => Str::random(5),
                'status' => 'Pending',
                'sso_account_id' => $data->id,
                'sso_service' => $service,
                'url' => $data->avatar,
            ];
            request()->session()->put('userData', $userData);

            return false;
        }
    }

    /**
     * logout operation.
     *
     * @return redirect login page view
     */
    public function logout()
    {
        $cookie = Cookie::forget($this->ckname);
        $user = Auth::user();
        Auth::guard('user')->logout();

        if (isset($user)) {
            (new ActivityLogService())->userLogout('success', 'Logout successful', $user);
        }

        if (isActive('Affiliate')) {
            $helper = \Modules\Affiliate\Services\AffiliateHelper::getInstance();
            $helper->destroy();
        }

        return redirect()->route('site.index')->withCookie($cookie);
    }

    /**
     * Opt form
     *
     * @param string token
     * @return array $response
     */
    public function resetOtp($token)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid password token')];

        if (empty((new PasswordReset())->tokenExist($token))) {
            return $response;
        }

        $user = (new User())->getData($token);
        if (empty($user)) {
            return $response;
        }

        return ['status' => 'success', 'id' => $user->id, 'token' => $token];
    }

    /**
     * Send reset password link
     *
     * @return JSON $data
     */
    public function sendResetLinkEmail(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $validator = PasswordReset::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request['token'] = Password::getRepository()->createNewToken();
        $request['otp'] = random_int(1111, 9999);
        $request['created_at'] = date('Y-m-d H:i:s');

        try {
            \DB::beginTransaction();
            (new PasswordReset())->storeOrUpdate($request->only('email', 'token', 'otp', 'created_at'));

            User::firstWhere('email', $request->email)->notify(new ResetPasswordNotification($request));

            $data['status'] = 'success';
            $data['message'] = __('Password reset link sent to your email address.');

            \DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $data['status'] = 'fail';
            $data['message'] = $e->getMessage();
        }
        $this->setSessionValue($data);

        return $data;
    }

    /**
     * showResetForm method
     *
     * @param  string  $tokens
     * @return show reset password page view
     */
    public function showResetForm(Request $request, $tokens)
    {
        if ($tokens == 'otp') {
            $tokens = $request->token;
        }

        $token = (new PasswordReset())->tokenExist($tokens);

        if (empty($token)) {
            return redirect()->route('site.login', ['page' => 'reset-password'])->withErrors(['email' => __('Invalid password token')]);
        }

        $data = ['token' => $tokens];
        $data['user'] = (new User())->getData($tokens);
        if (! $data['user']) {
            return redirect()->route('site.login', ['page' => 'reset-password'])->withErrors(['email' => __('Invalid password token')]);
        }

        return redirect()->route('site.login', ['page' => 'confirm-password', 'id' => $data['user']['id'], 'token' => $data['token']]);
    }

    /**
     * User verification with OTP
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function userVerification(Request $request)
    {
        if (empty($request->token)) {
            return redirect()->back()->withErrors(['otp' => __('The OTP field is required.')]);
        }
        $user = User::where('activation_otp', $request->token)->orWhere('activation_code', $request->token);
        if ($user->count() == 0) {
            $response['message'] = __('Your OTP is invalid.');

            return redirect()->back()->withErrors(['otp' => __('Your OTP is invalid.')]);
        }
        $user->update(['activation_otp' => null, 'activation_code' => null, 'status' => 'Active']);

        return redirect()->route('site.login');
    }

    /**
     * @return redirect login page view
     */
    public function setPassword(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->wantsJson()) {
            $request = (object) $request;
        }

        $response = $this->checkExistence($request->id, 'users', ['getData' => true]);
        if ($response['status'] === true) {
            $validator = PasswordReset::passwordValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $request['raw_password'] = $request->password;
            $request['updated_at'] = date('Y-m-d H:i:s');
            $request['password'] = \Hash::make(trim($request->password));
            if ((new PasswordReset())->updatePassword($request->only('password', 'token', 'updated_at'), $request->id)) {
                $request['user_name'] = $response['data']->name;
                $request['email'] = $response['data']->email;

                User::firstWhere('email', $request->email)->notify(new UserPasswordSetNotification($request));

                $data['status'] = 'success';
                $data['message'] = __('Password update successfully.');
            } else {
                $data['message'] = __('Nothing is updated.');
            }
        } else {
            $data['message'] = $response['message'];
        }

        if ($request->wantsJson()) {
            return $data;
        }
        $this->setSessionValue($data);

        return $this->login($request, __('Password reset successfully.'));
    }

    /**
     * Check Email Existence
     *
     * @param  string  $email
     * @return json $response
     */
    public function checkEmailExistence($email)
    {
        $response['status'] = 1;

        if (! empty($email) && User::where('email', $email)->count() > 0) {
            $response['message'] = __('Email already has been taken.');

            return $response;
        }
        $response['message'] = '';

        return $response;
    }

    /**
     * signup from for email
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function emailSignup()
    {
        return view('site.auth.emailSignup');
    }

    /**
     * user store if sso service email not provided
     *
     * @return \Illuminate\Http\RedirectResponse|void
     *
     * @throws \Exception
     */
    public function emailStore(Request $request)
    {
        if ($request->session()->has('userData')) {
            $response = $this->messageArray(__('Invalid Request'), 'fail');
            $role = Role::getAll()->where('slug', 'customer')->first();
            $validator = User::userEmailValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();
                $userData = $request->session()->get('userData');
                $request['activation_code'] = Str::random(10);
                $request['activation_otp'] = random_int(1111, 9999);
                $id = (new User())->store(['name' => $userData['name'], 'email' => $request->email, 'password' => \Hash::make($userData['password']), 'status' => 'Pending',  'sso_account_id' => $userData['sso_account_id'], 'sso_service' => $userData['sso_service'], 'activation_code' => $request->activation_code, 'activation_otp' => $request->activation_otp], 'url', $userData['url']);
                if (! empty($id)) {
                    if (! empty($role)) {
                        (new RoleUser())->store(['user_id' => $id, 'role_id' => $role->id]);
                    }

                    $request['name'] = $userData['name'];
                    $request['raw_password'] = $userData['password'];

                    User::firstWhere('email', $request->email)->notify(new WelcomeUserNotification($request));

                    DB::commit();
                    $request->session()->forget('userData');

                    return redirect()->route('site.verification.otp');
                }
            } catch (Exception $e) {
                DB::rollBack();
                $response['message'] = $e->getMessage();
            }
            $this->setSessionValue($response);
        } else {
            return redirect()->route('site.index');
        }
    }

    /**
     * @param  string  $mail
     *                        return $response
     */
    public function validMail(Request $request, $contactInfo)
    {
        $response = ['status' => 'fail', 'message' => __('Email address or phone does not exist in the system.')];

        if (strpos($contactInfo, '@') !== false && ! validateEmail($contactInfo)) {
            return ['status' => 'fail', 'message' => __('Please enter a valid :x.', ['x' => __('Email address')])];
        } elseif (strpos($contactInfo, '@') === false && ! validatePhoneNumber($contactInfo)) {
            return ['status' => 'fail', 'message' => __('Please enter a valid :x.', ['x' => __('Phone')])];
        }

        $contactType = (strpos($contactInfo, '@') === false) ? 'phone' : 'email';

        $user = User::firstWhere($contactType, $contactInfo);

        if (empty($user) || $user->status == 'Deleted') {
            return $response;
        }

        $statusMessage = $this->getUserStatusMessage($user->status);

        if ($statusMessage) {
            $response['message'] = $statusMessage;

            return $response;
        }

        $request[$contactType] = $contactInfo;

        $resetType = ($contactType === 'phone') ? 'phone' : 'email';

        $response = ($resetType === 'phone') ? $this->sendResetOTP($request) : $this->sendResetLinkEmail($request);
        $message = __('Password reset link sent to your :x.', ['x' => $resetType]);

        if ($response['status'] == 'fail') {
            return $response;
        }

        return ['status' => 'success', 'message' => $message];
    }

    /**
     * Get User status Message;
     */
    private function getUserStatusMessage($status)
    {
        switch ($status) {
            case 'Pending':
                return __('Please verify your email address or phone.');
            case 'Inactive':
                return __('Sorry, your account is not activated. Please contact with the site administrator.');
            default:
                return '';
        }
    }

    /**
     * Send reset password otp
     *
     * @return JSON $data
     */
    public function sendResetOTP(Request $request)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];

        $request['token'] = Password::getRepository()->createNewToken();
        $request['otp'] = random_int(1111, 9999);
        $request['created_at'] = now();

        \DB::beginTransaction();

        try {
            $user = User::firstWhere('phone', $request->phone);

            if ($user) {
                (new PasswordReset())->updateOrInsert(['email' => $user->email], $request->only('token', 'otp', 'created_at'));

                $request['email'] = $user->email;
                $user->notify(new ResetPasswordNotification($request));

                $response['status'] = 'success';
                $response['message'] = __('Password reset link sent to your phone');
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            $response['message'] = $e;
        }

        return $response;
    }

    /**
     * Re-send user verification code
     *
     * @return array $response;
     */
    public function resendUserVerificationCode(Request $request)
    {
        $response = ['status' => 'fail'];
        $request['raw_password'] = $request['password'];
        $request['password'] = \Hash::make($request['password']);
        $request['email'] = validateEmail($request['email']) ? strtolower($request['email']) : null;
        $request['activation_code'] = Str::random(10);
        $request['activation_otp'] = random_int(1111, 9999);

        $user = User::where('email', $request->email)->first();
        $request['name'] = $user->name;
        $request['from'] = 'web';
        $request = (object) $request;
        $result = (new User())->updateUser($request->only('activation_code', 'activation_otp'), $user->id);
        if (! empty($result)) {
            try {
                DB::beginTransaction();
                $user->notify(new UserVerificationNotification($request));
                $response['status'] = 'success';
                DB::commit();

                return $response;
            } catch (\Exception $e) {
                DB::rollback();
                $response['message'] = $e->getMessage();

                return $response;
            }
        }
    }
}
