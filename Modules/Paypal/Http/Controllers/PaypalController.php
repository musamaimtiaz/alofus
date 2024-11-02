<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Addons\Entities\Addon;
use Modules\Paypal\Entities\Paypal;
use Modules\Paypal\Entities\PaypalBody;
use Modules\Paypal\Http\Requests\PaypalRequest;

class PaypalController extends Controller
{
    public function store(PaypalRequest $request)
    {
        $paypalBody = new PaypalBody($request);

        Paypal::updateOrCreate(
            ['alias' => moduleConfig('paypal.alias')],
            [
                'name' => moduleConfig('paypal.name'),
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($paypalBody),
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Paypal settings updated.')]);
    }

    public function edit(Request $request)
    {
        try {
            $module = Paypal::first()->data;
        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail('paypal');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true,
            ],
            200
        );
    }
}
