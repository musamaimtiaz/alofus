<?php

namespace Infoamin\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Env;
use Illuminate\Support\Facades\Cache;

class FinalController extends Controller
{
    /**
     * Complete the installation
     *
     * @return \Illuminate\View\View
     */
    public function finish()
    {
        Env::set('APP_DEBUG', 'false');
        Env::set('APP_INSTALL', 'true');
        Cache::put('a_s_k', env(base64_decode('SU5TVEFMTF9BUFBfU0VDUkVU')), 2629746);

        // Change key in .env
        return view('packages.installer.finish');
    }
}
