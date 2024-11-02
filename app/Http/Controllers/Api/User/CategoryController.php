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
use App\Http\Resources\{CategoryDetailResource, CategoryResource};
use App\Models\{
    Category,
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Category list
     *
     * @return json $data
     */
    public function index(Request $request, $param = null)
    {
        $configs = $this->initialize([], $request->all());
        if ($param == 'top') {
            $category = Category::whereHas('products', function (Builder $query) {
                $query->whereNotNull('total_sales');
            })->withSum('products', 'total_sales')->orderByDesc('products_sum_total_sales');
        } elseif (auth()->guard('api')->user()?->role()->type == 'vendor') {
            $category = Category::select('*')->whereHas('products', function ($query) {
                $query->where('vendor_id', auth()->guard('api')->user()?->vendors()->first()->id);
            });
        } else {
            $category = Category::select('*')->whereHas('products');
        }

        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $category->where('name', strtolower($name));
        }

        $slug = isset($request->slug) ? $request->slug : null;
        if (! empty($slug)) {
            $category->where('slug', strtolower($slug));
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $category->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $category->where('id', $keyword);
            } elseif (strlen($keyword) >= 2) {
                $category->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('slug', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => CategoryResource::collection($category->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($category->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Detail Category
     *
     * @return json $data
     */
    public function subCategory(Request $request, $parentId)
    {
        $configs = $this->initialize([], $request->all());
        $response = $this->checkExistence($parentId, 'categories');
        if ($response['status']) {
            $category = Category::select('*')->where('parent_id', $parentId);
            $name = isset($request->name) ? $request->name : null;
            if (! empty($name)) {
                $category->where('name', strtolower($name));
            }

            $slug = isset($request->slug) ? $request->slug : null;
            if (! empty($slug)) {
                $category->where('slug', strtolower($slug));
            }

            $status = isset($request->status) ? $request->status : null;
            if (! empty($status)) {
                $category->where('status', strtolower($status));
            }

            $keyword = isset($request->keyword) ? $request->keyword : null;
            if (! empty($keyword)) {
                if (is_int($keyword)) {
                    $category->where('id', $keyword);
                } elseif (strlen($keyword) >= 2) {
                    $category->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->orwhere('slug', 'LIKE', '%' . $keyword . '%');
                    });
                }
            }

            return $this->response([
                'data' => CategoryDetailResource::collection($category->get()),
            ]);
        }
    }
}
