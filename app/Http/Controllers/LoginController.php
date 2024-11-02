<?php
/**
 * @package LoginController
 * @author TechVillage <support@techvill.org>
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 * @created 20-05-2021
 * @modified 30-05-2022
 */

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AuthUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\{
    User,
    PasswordReset,
};
use Auth, Session, DB, Cookie;
use App\Services\ActivityLogService;
use App\Services\Mail\{
    UserResetPasswordMailService,
    UserSetPasswordMailService
};

class LoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ckname = explode("_", Auth::getRecallerName())[2];
        $this->middleware('guest:user')->except('logout', 'impersonate', 'cancelImpersonate');
    }

    // use AuthenticatesUsers;
    /**
     * @return login page view
     */
    public function showLoginForm()
    {
        $value = Cookie::get($this->ckname);
        if (!is_null($value)) {
            $rememberedUser = explode(".", explode($this->ckname, decrypt($value))[1]);
            if ($rememberedUser[1] == 'user' && Auth::guard('user')->loginUsingId($rememberedUser[0]))
            {
                $ckkey = encrypt($this->ckname.Auth::user()->id.".user");
                Cookie::queue($this->ckname, $ckkey, 2592000);
                return redirect()->intended(route('dashboard'));
            }
        }
        return view('admin.auth.login');
    }

    /**
     * Login authenticate operation.
     *
     * @return redirect dashboard page
     */
    public function authenticate(AuthUserRequest $request)
    {
        $data = $request->only('email', 'password');
        $data['status'] = 'Active';
        $userData = User::where('email', $data['email'])->first();

        if (\Hash::check($data['password'], $userData->password)) {
            if ($userData->status != 'Active') {
                (new ActivityLogService())->userLogin('failed', 'Inactive');
                return back()->withInput()->withErrors(['error' => __("Inactive User")]);
            }

            if ($userData->role() <> null && $userData->role()->type == "global" &&  $userData->role()->slug == "super-admin"|| $userData->role() <> null && $userData->role()->type == "vendor" && $userData->role()->slug == "vendor-admin") {
                if (Auth::guard('user')->attempt($data)) {
                    session()->put('vendorId', optional(auth()->user()->vendor())->vendor_id);
                    if (!is_null($request->remember)) {
                        $ckkey = encrypt($this->ckname.Auth::user()->id.".user");
                        Cookie::queue($this->ckname, $ckkey, 2592000);
                    }
                    if (auth()->user()->role()->type == 'global') {
                        if ($this->ncpc()) {
                            Session::flush();
                            return view('errors.installer-error', ['message' => __('This product is facing license validation issue.') . "<br>" . __('Please verify your purchase code from :x.', ['x' => '<a style="color:#fcca19" href="' . route('purchase-code-check', ['bypass' => 'purchase_code']) .'">' . __('here') . '</a>'])]);
                        }
                        (new ActivityLogService())->userLogin('success', 'Login successful');
                        return redirect()->intended(route('dashboard'));
                    }
                    if ($this->ncpc()) {
                        Session::flush();
                        return view('errors.installer-error', ['message' => __("This product is facing license validation issue.<br>Please contact admin to fix the issue.")]);
                    }
                    if ( auth()->user()->vendors()->first()->status != 'Active') {
                        (new ActivityLogService())->userLogin('failed', 'Inactive');
                        return redirect()->route('site.index');
                    }
                    (new ActivityLogService())->userLogin('success', 'Login successful');
                    return redirect()->intended(route('vendor-dashboard'));
                }
            }

            return back()->withInput()->withErrors(['error' => __("Invalid User")]);
        } else {
            (new ActivityLogService())->userLogin('failed', 'Incorrect');
            return back()->withInput()->withErrors(['email' => __("Invalid email or password")]);
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

        Session::flush();
        return redirect()->route('login')->withCookie($cookie);
    }

    /**
     * forget password
     *
     * @return forget password form
     */
    public function reset()
    {
        $this->data = ['page_title' => __('Reset Password')];
        return view('admin.auth.passwords.email', $this->data);
    }

    /**
     * Opt form
     *
     * @return forget password form
     */
    public function resetOtp()
    {
        return view('admin.auth.passwords.otp');
    }

    /**
     * Send reset password link
     *
     * @return Null
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
            (new PasswordReset)->storeOrUpdate($request->only('email', 'token', 'otp', 'created_at'));

            $emailResponse = (new UserResetPasswordMailService)->send($request);

            if ($emailResponse['status'] == false) {
                \DB::rollBack();
                return redirect()->back()->withInput()->withErrors(['fail' => $emailResponse['message']]);
            }
            $data['status'] = 'success';
            $data['message'] = __('Password reset link sent to your email address.');
            \DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $data['status'] = 'fail';
            $data['message'] = $e->getMessage();
        }
        $this->setSessionValue($data);

        if (User::userVerification('otp')) {
            return redirect()->route('reset.otp')->withInput();
        }
        return redirect()->back();
    }

    /**
     * showResetForm method
     * @param string $tokens
     * @return show reset password page view
     */
    public function showResetForm(Request $request, $tokens = null)
    {
        if (!empty($tokens)) {
            $tokens = $request->token;
        }
        $token = (new PasswordReset)->tokenExist($tokens);

        if (empty($token) || empty($request->token)) {
            return redirect()->route('reset.otp')->withErrors(['email' => __("Invalid password token")]);
        }

        $data = ['token' => $tokens];
        $data['user'] = (new User)->getData($tokens);

        if (!$data['user']) {
            return redirect()->back()->withErrors(['email' => __("Invalid password token")]);
        }

        return view('admin.auth.passwords.reset', $data);
    }

    /**
     *
     * @return redirect login page view
     */
    public function setPassword(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($request->id, 'users', ['getData' => true]);
            if ($response['status'] === true) {
                $validator = PasswordReset::passwordValidation($request->all());
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                $request['user_name'] =  $response['data']->name;
                $request['email'] =  $response['data']->email;
                $request['raw_password'] = $request->password;
                $request['updated_at'] = date('Y-m-d H:i:s');
                $request['password'] = \Hash::make(trim($request->password));

                if ((new PasswordReset)->updatePassword($request->only('password', 'token', 'updated_at'), $request->id)) {
                    $emailResponse = (new UserSetPasswordMailService)->send($request);
                    if ($emailResponse['status'] == false) {
                        return redirect()->back()->withInput()->withErrors(['fail' => $emailResponse['message']]);
                    }

                    $data['status'] = 'success';
                    $data['message'] = __('Password updated successfully.');
                } else {
                    $data['message'] = __('Nothing is updated.');
                }
            } else {
                $data['message'] = $response['message'];
            }
        }

        $this->setSessionValue($data);
        return redirect()->route('login');
    }

    /**
     * Impersonate as another user
     * @param Request $request
     * @return redirect
     */
    public function impersonate(Request $request)
    {
        $password = techDecrypt($request->impersonate);

        $user = User::where('password', $password)->first();

        if (!session()->has('impersonator')) {
            session(['impersonator' => auth()->id()]);
        }
        Auth::loginUsingId($user->id);
        session()->put('vendorId', optional(auth()->user()->vendor())->vendor_id);
        return redirect(route('site.index'));
    }

    /**
     * Cancel Impersonate
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function cancelImpersonate()
    {
        Auth::loginUsingId(session('impersonator'));
        session()->forget('impersonator');
        session()->forget('vendorId');
        return redirect(route('dashboard'));
    }

    public function ncpc()
    {
		p_c_v();
		return false;
    }
}
