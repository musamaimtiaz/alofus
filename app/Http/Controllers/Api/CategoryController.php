<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 27-10-2021
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    CategoryDetailResource,
    CategoryResource
};
use App\Models\{
    Category,
    File
};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Category List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $category = Category::select('categories.*');
        $name = isset($request->name) ? $request->name : null;
        if (! empty($name)) {
            $category->where('name', strtolower($name));
        }

        $slug = isset($request->slug) ? $request->slug : null;
        if (! empty($slug)) {
            $category->where('slug', strtolower($slug));
        }

        $parent = isset($request->parent) ? $request->parent : null;
        if (! empty($parent)) {
            $category->whereHas('category', function ($q) use ($parent) {
                $q->where('name', strtolower($parent));
            })->with('category');
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $category->where('status', strtolower($status));
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $category->where('id', $keyword);
            } else {
                if (strlen($keyword) >= 3) {
                    $category->where(function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%')
                            ->where('slug', 'LIKE', '%' . $keyword . '%')
                            ->orwhereHas('category', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', '%' . $keyword . '%');
                            })->with('category')
                            ->orwhere('status', $keyword);
                    });
                }
            }
        }

        return $this->response([
            'data' => CategoryResource::collection($category->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($category->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Category
     *
     * @return json $data
     */
    public function store(Request $request)
    {
        $maxValue = 1;
        if (! isset($request->parent_id)) {
            $maxValue += Category::getAll()->whereNull('parent_id')->max('order_by');
        } else {
            $maxValue += Category::getAll()->where('parent_id', $request->parent_id)->max('order_by');
        }
        $request['order_by'] = $maxValue;
        $validator = Category::storeValidation($request->all());
        if ($validator->fails()) {
            return $this->unprocessableResponse($validator->messages());
        }
        $categoryId = (new Category())->store(
            $request->only('name', 'parent_id', 'status', 'is_searchable', 'slug', 'order_by')
        );
        if (! empty($categoryId)) {
            // File Upload
            if (isset($request->image) && ! empty($request->image) && $request->hasFile('image')) {
                $path = createDirectory('public/uploads/category');
                (new File())->store(
                    [$request->image],
                    $path,
                    'CATEGORY',
                    $categoryId,
                    ['isUploaded' => false, 'isOriginalNameRequired' => true]
                );
            }

            // File Upload End
            return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Category')]));
        }

        return $this->errorResponse();
    }

    /**
     * Detail Category
     *
     * @param  Request  $request
     * @return json $data
     */
    public function detail($id)
    {
        $response = $this->checkExistence($id, 'categories');
        if ($response['status']) {
            return $this->response([
                'data' => new CategoryDetailResource(Category::getAll()->where('id', $id)->first()),
            ]);
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Update Category Information
     *
     * @return json $data
     */
    public function update(Request $request, $id)
    {
        $response = $this->checkExistence($id, 'categories');
        if ($response['status']) {
            $validator = Category::updateValidation($request->all(), $id);
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }
            if ((new Category())->updateCategory(
                $request->only('name', 'parent_id', 'status', 'is_searchable', 'slug'),
                $id
            )) {
                if (isset($request->image) && ! empty($request->image)) {
                    //delete file region
                    $fileIds = array_column(
                        json_decode(
                            json_encode(File::Where(['object_type' => 'CATEGORY', 'object_id' => $id])->get(['id'])),
                            true
                        ),
                        'id'
                    );
                    $oldFileName = isset($fileIds) && ! empty($fileIds) ? File::find($fileIds[0])->file_name : null;
                    if (isset($fileIds) && ! empty($fileIds)) {
                        (new File())->deleteFiles(
                            'CATEGORY',
                            $id,
                            ['ids' => [$fileIds], 'isExceptId' => false],
                            $path = 'public/uploads/category'
                        );
                    }
                    //end region

                    //region store files
                    if (isset($id) && ! empty($id) && $request->hasFile('image')) {
                        $path = createDirectory('public/uploads/category');
                        $fileIdList = (new File())->store(
                            [$request->image],
                            $path,
                            'CATEGORY',
                            $id,
                            ['isUploaded' => false, 'isOriginalNameRequired' => true, 'resize' => false]
                        );
                        Cache::forget(config('cache.prefix') . '-category-image-' . $id);
                    }
                    //end region
                }

                return $this->okResponse([], __('The :x has been successfully saved.', ['x' => __('Category')]));
            }

            return $this->okResponse([], __('No changes found.'));
        }

        return $this->response([], 204, $response['message']);
    }

    /**
     * Remove the specified Category from db.
     *
     * @param  int  $id
     * @return json $data
     */
    public function destroy($id)
    {
        $response = $this->checkExistence($id, 'categories');
        if ($response['status']) {
            $result = (new Category())->remove($id);

            return $this->okResponse([], $result['message']);
        }

        return $this->response([], 204, $response['message']);
    }
}
