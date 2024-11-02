<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-01-2022
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    BrandResource,
};
use App\Models\{
    Brand,
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Category list
     *
     * @return json $data
     */
    public function index(Request $request, $params = null)
    {
        $configs = $this->initialize([], $request->all());
        $brand = Brand::select('id', 'name', 'status', 'created_at', 'vendor_id')->where('status', 'Active')->with('vendor:id,name');
        if ($params == 'top') {
            $brands = $brand->whereHas('product', function (Builder $query) {
                $query->whereNotNull('total_sales');
            })->withSum('product', 'total_sales')->orderByDesc('product_sum_total_sales');
        } else {
            $brands = $brand;
        }
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $brands->where('name', strtolower($name));
        }

        $vendor = isset($request->vendor) ? $request->vendor : null;
        if (! empty($vendor)) {
            $brands->whereHas('vendor', function ($q) use ($vendor) {
                $q->where('name', strtolower($vendor));
            })->with('vendor');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $brands->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $brands->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $brands->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orwhereHas('vendor', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('vendor');
                    });
                }
            }
        }

        return $this->response([
            'data' => BrandResource::collection($brands->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($brands->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }
}
