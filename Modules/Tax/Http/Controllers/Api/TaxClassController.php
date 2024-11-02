<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-07-2022
 */

namespace Modules\Tax\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Tax\Entities\TaxClass;
use Modules\Tax\Http\Requests\TaxClassStoreRequest;
use Modules\Tax\Http\Resources\TaxClassResource;

class TaxClassController extends Controller
{
    /**
     * TaxClass List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $taxClass = TaxClass::select('id', 'name', 'slug');

        $keyword = isset($request->keyword) ? trim(xss_clean($request->keyword)) : null;
        if (! empty($keyword)) {
            if (preg_match('/^[1-9]+[0-9]*$/', $keyword)) {
                $taxClass->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $taxClass->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('slug', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => TaxClassResource::collection($taxClass->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($taxClass->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Tax class
     *
     * @return json $response
     */
    public function store(TaxClassStoreRequest $request)
    {
        $response = (new TaxClass())->store($request->validated());
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }

    /**
     * Remove the specified tax class from db.
     *
     * @param  string  $slug
     * @return json $response
     */
    public function destroy($slug)
    {
        $response = (new TaxClass())->remove($slug);
        if ($response['status'] == 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }
}
