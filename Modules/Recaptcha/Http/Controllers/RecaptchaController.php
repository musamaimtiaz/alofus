<?php

namespace Modules\Recaptcha\Http\Controllers;

use App\Lib\Env;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recaptcha\Http\Requests\RecaptchaRequest;

class RecaptchaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(RecaptchaRequest $request)
    {
        Env::set('NOCAPTCHA_SITEKEY', $request->siteKey);
        Env::set('NOCAPTCHA_SECRET', $request->secretKey);

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Recaptcha settings updated.')]);
    }

    /**
     * Returns form for the edit modal
     *
     * @param \Illuminate\Http\Request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        return response()->json(
            [
                'html' => view('recaptcha::index')->render(),
                'status' => true,
            ],
            200
        );
    }
}
