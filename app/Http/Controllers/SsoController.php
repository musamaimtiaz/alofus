<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 11-11-2021
 */

namespace App\Http\Controllers;

use App\Lib\Env;
use Illuminate\Http\Request;
use Validator;
use App\Models\Preference;

use function GuzzleHttp\json_encode;

class SsoController extends Controller
{
    public function __construct(Request $req)
    {
        //this middleware should be for POST request only
        if ($req->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        $data['list_menu'] = 'sso';
        if ($request->isMethod('get')) {
            $data['preference'] = preference('sso_service');

            return view('admin.sso_service.index', $data);
        } elseif ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'data' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            foreach ($request->data as $key => $dt) {

                if ($key == 'facebook') {

                    Env::set('FACEBOOK_CLIENT_ID', $dt['client_id'] ?? '');
                    Env::set('FACEBOOK_CLIENT_SECRET', $dt['client_secret'] ?? '');
                    Env::set('FACEBOOK_REDIRECT_URL', route('facebook'));
                } elseif ($key == 'google') {
                    Env::set('GOOGLE_CLIENT_ID', $dt['client_id'] ?? '');
                    Env::set('GOOGLE_CLIENT_SECRET', $dt['client_secret'] ?? '');
                    Env::set('GOOGLE_REDIRECT_URL', route('google'));
                }
            }

            $sso = ['category' => 'preference', 'field' => 'sso_service'];
            $sso['value'] = empty($request->sso_service) ? '' : json_encode($request->sso_service);
            (new Preference())->storeOrUpdate($sso);
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('SSO Service')]), 'success');
            $this->setSessionValue($response);

            return redirect()->route('sso.index');
        }
    }
}
