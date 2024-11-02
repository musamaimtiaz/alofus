<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Auth;

class DownloadController extends Controller
{
    /**
     * view downloadable orders
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Auth::user()->orders()->whereHas('metadata', function ($query) {
            $query->where('key', 'download_data');
        })->whereHas('orderStatus', function ($query) {
            $query->where('payment_scenario', 'paid');
        });
        $data['orders'] = $orders->get();

        return view('site.download.index', $data);
    }
}
