<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-08-2021
 */

namespace App\Http\Controllers;

use App\Http\Resources\AjaxCurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Currency List
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['list_menu']         = 'currency';
        $data['currencyData']      = Currency::getAll();

        return view('admin.currency.index', $data);
    }

    /**
     * Currency Store
     */
    public function store(Request $request)
    {
        $response             = [];
        $response = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        $validator = Currency::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ((new Currency())->store($request->only('name', 'symbol', 'exchange_rate', 'exchange_from'))) {
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Currency')]), 'success');
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Currency edit
     */
    public function edit(Request $request)
    {
        $result = [];
        if (isset($request->id) && ! empty($request->id)) {
            $currData = Currency::getAll()->where('id', $request->id)->first();
            $result['name']          = $currData->name;
            $result['symbol']        = $currData->symbol;
            $result['exchange_rate'] = $currData->exchange_rate;
            $result['id']            = $currData->id;
            $result['exchange_from'] = $currData->exchange_from;
        }
        echo json_encode($result);
    }

    /**
     * Currency Update
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $response             = [];
        $response = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        $validator = Currency::updateValidation($request->all(), $request->curr_id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ((new Currency())->currencyUpdate($request->only('name', 'symbol', 'exchange_rate', 'exchange_from'), $request->curr_id)) {
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Currency')]), 'success');
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Currency destroy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $requsest)
    {
        $id = $requsest->id;
        $language = (new Currency())->remove($id);
        $response = $this->messageArray($language['message'], $language['type']);
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Currency Validate
     */
    public function validCurrencyName(Request $request)
    {
        $query = Currency::where('name', $request->name);
        if (isset($request->currency_id) && ! empty($request->currency_id)) {
            $query->where('id', '!=', $request->currency_id);
        }
        $result = $query->first();

        if (! empty($result)) {
            echo json_encode(__('Currency name is already taken.'));
        } else {
            echo 'true';
        }
    }

    /**
     * currency List
     *
     * @return json $data
     */
    public function findCurrencyAjaxQuery(Request $request)
    {
        $currencies = Currency::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")
            ->limit(10)->get();

        return AjaxCurrencyResource::collection($currencies);
    }
}
