<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $data['wallets'] = auth()->user()->wallets()->get();
        $data['orders'] = Order::where('user_id', auth()->user()->id)->limit(5)->orderByDesc('id')->get();

        return view('site.dashboard.index', $data);
    }

    /**
     * Change Language function
     *
     * @return true or false
     */
    public function switchLanguage(Request $request)
    {

        if ($request->lang) {
            if (! empty(Auth::user()->id) && isset(Auth::guard('user')->user()->id)) {
                Cache::put(config('cache.prefix') . '-user-language-' . Auth::guard('user')->user()->id, $request->lang, 5 * 365 * 86400);
                echo 1;
                exit;
            } else {
                Cache::put(config('cache.prefix') . '-guest-language-' . request()->server('HTTP_USER_AGENT'), $request->lang, 5 * 365 * 86400);
                echo 1;
                exit;
            }
        }
        echo 0;
        exit();
    }

    /**
     * Remove dashboard welcome message.
     *
     * @return response
     */
    public function removeWelcome()
    {
        session()->put('welcomeUser', false);

        return $this->okResponse([], 'ok');
    }
}
