<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Addons\Entities\Addon;
use Modules\Stripe\Entities\Stripe;
use Modules\Stripe\Entities\StripeBody;
use Modules\Stripe\Http\Requests\StripeRequest;

class StripeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     *
     * @return mixed
     */
    public function store(StripeRequest $request)
    {
        $stripeBody = new StripeBody($request);

        Stripe::updateOrCreate(
            ['alias' => 'stripe'],
            [
                'name' => 'Stripe',
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($stripeBody),
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Stripe settings updated.')]);
    }

    /**
     * Returns form for the edit modal
     *
     * @param \Illuminate\Http\Request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        try {
            $module = Stripe::first()->data;
        } catch (\Exception $e) {
            $module = null;
        }
        $addon = Addon::findOrFail('stripe');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true,
            ],
            200
        );
    }
}
