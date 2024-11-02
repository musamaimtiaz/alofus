<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-07-2022
 */

namespace Modules\Tax\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Tax\Entities\TaxRate;
use Modules\Tax\Http\Requests\TaxRateStoreRequest;
use Modules\Tax\Http\Requests\TaxRateUpdateRequest;
use Modules\Tax\Http\Resources\TaxRateDetailResource;
use Modules\Tax\Http\Resources\TaxRateResource;

class TaxRateController extends Controller
{
    /**
     * TaxClass List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $taxRate = TaxRate::select('*')->with('taxClass');

        $shipping = isset($request->shipping) ? trim(xss_clean($request->shipping)) : null;
        if (! empty($shipping)) {
            $taxRate->where('shipping', strtolower($shipping));
        }

        $compound = isset($request->compound) ? trim(xss_clean($request->compound)) : null;
        if (! empty($compound)) {
            $taxRate->where('compound', strtolower($compound));
        }

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $taxRate->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $taxRate->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('country', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('state', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('postcode', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => TaxRateResource::collection($taxRate->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($taxRate->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Shop
     *
     * @param  Request  $request
     * @return json $data
     */
    public function store(TaxRateStoreRequest $request)
    {
        $response = (new TaxRate())->store($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }

    /**
     * Detail Tax Rate
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'tax_rates');
        $data = TaxRate::getAll()->where('id', $id)->first();
        if ($response['status'] === true && ! empty($data)) {
            return $this->response(['data' => new TaxRateDetailResource($data)]);
        }

        return $this->notFoundResponse([], __('Tax rate not found.'));
    }

    /**
     * Update Tax rate Information
     *
     * @param  Request  $request
     */
    public function update(TaxRateUpdateRequest $request, $id)
    {
        $response = $this->checkExistence($id, 'tax_rates');
        if ($response['status'] === true) {
            if ((new TaxRate())->updateTaxRate($request->all(), $id)) {
                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Tax Rate')]));
            } else {
                return $this->okResponse([], __('No changes found.'));
            }
        }

        return $this->notFoundResponse([], $response['message']);
    }

    /**
     * Remove the specified Shop from db.
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = (new TaxRate())->remove($id);
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->notFoundResponse([], $response['message']);
    }
}
