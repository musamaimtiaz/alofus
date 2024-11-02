<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-08-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    CurrencyDetailResource,
    CurrencyResource
};
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Currency List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs        = $this->initialize([], $request->all());
        $currency       = Currency::select('id', 'name', 'symbol', 'exchange_rate');
        $name           = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $currency->where('name', strtolower($name));
        }

        $symbol = isset($request->symbol) ? $request->symbol : null;
        if (! empty($symbol)) {
            $currency->where('symbol', strtolower($symbol));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $currency->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orwhere('exchange_rate', $keyword);
                });
            } elseif (strlen($keyword) >= 1) {
                $currency->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('symbol', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => CurrencyResource::collection($currency->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($currency->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);

    }

    /**
     * Store currency
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $validator = Currency::storeValidation($request->all());

        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }

        if ((new Currency())->store($request->all())) {
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Currency')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail currency
     *
     * @param  int  $id
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'currencies');

        if ($response['status']) {
            return $this->response([
                'data' => new CurrencyDetailResource(Currency::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Currency Information
     *
     * @param  int  $id
     * @return json $data
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'currencies');

        if ($response['status']) {

            $validator = Currency::updateValidation($request->all(), $id);

            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            $request['exchange_rate'] = validateNumbers($request->exchange_rate);

            if ((new Currency())->currencyUpdate($request->all(), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Currency')]));
            }

            return $this->okResponse([], __('No changes found.'));

        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Currency from db.
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'currencies');

        if ($response['status']) {

            $result  = (new Currency())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->errorResponse([], $response['message']);
    }
}
