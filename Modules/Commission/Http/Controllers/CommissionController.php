<?php

namespace Modules\Commission\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Commission\Http\Models\Commission;

class CommissionController extends Controller
{
    /**
     * commission view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['list_menu'] = 'commission';
        $data['commission'] = Commission::getAll()->first();
        $data['orderStatuses'] = OrderStatus::getAll()->where('is_default', '!=', 1)->sortBy('order_by');

        return view('commission::index', $data);
    }

    /**
     * commission store or update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Commission::storeOrUpdateValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request['is_active'] = isset($request->is_commission_active) && $request->is_commission_active == 'on' ? 1 : 0;
        $request['is_category_based'] = isset($request->is_category_based) && $request->is_category_based == 'on' ? 1 : 0;
        if ((new Commission())->storeOrUpdate($request->only('amount', 'is_active', 'is_category_based', 'order_status_id'))) {
            $data = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Commission')]), 'success');
        } else {
            $data = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        }
        $this->setSessionValue($data);

        return redirect()->route('commission.index');
    }
}
