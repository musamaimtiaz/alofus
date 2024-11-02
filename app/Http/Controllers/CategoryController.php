<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 29-07-2021
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Modules\Commission\Http\Models\Commission;

class CategoryController extends Controller
{
    /**
     * Category List
     *
     * @param  CategoryListDataTable  $dataTable
     * @return mixed
     */
    public function index()
    {
        $data['vendors'] = Vendor::getAll()->where('status', 'Active')->all();
        $data['commission'] = Commission::getAll()->first();

        return view('admin.category.index', $data);
    }

    /**
     * return data for jstree
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $data = [];
        $children = [];
        $subChildren = [];
        $categories = Category::parents('admin')->where('id', '!=', 1)->sortBy('order_by');

        foreach ($categories as $category) {
            $categoriesChild = $category->childrenCategories->sortBy('order_by');

            foreach ($categoriesChild as $child) {
                $subChilds = $child->childrenCategories->sortBy('order_by');

                foreach ($subChilds as $subChild) {
                    $subChildren[$subChild->parent_id][] = [
                        'text' => $subChild->name,
                        'id' => $subChild->id,
                        'parent_id' => $subChild->parent_id,
                        'create_child' => 0,
                    ];
                }

                $children[$child->parent_id][] = [
                    'text' =>  $child->name,
                    'id' => $child->id,
                    'state' => [
                        'opened' => false,
                    ],
                    'parent_id' =>  $child->parent_id,
                    'create_child' => 1,
                    'children' => isset($subChildren[$child->id]) ? $subChildren[$child->id] : null,
                ];
            }

            $data[] = [
                'text' => $category->name,
                'id' => $category->id,
                'state' => [
                    'opened' => true,
                    'disabled' => $category->id == 1,
                ],
                'create_child' => $category->id != 1 ? 1 : '',
                'children' => isset($children[$category->id]) ? $children[$category->id] : null,
            ];
        }

        return response()->json($data);
    }

    /**
     * Store Category
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $response = ['status' => 0];
        if ($request->isMethod('post')) {

            if (isset($request->parent_id) && $request->parent_id == 1) {
                $response['error'] = __('Not Permitted');

                return $response;
            }

            $maxValue = 1;

            if (! isset($request->parent_id)) {
                $maxValue += Category::getAll()->whereNull('parent_id')->max('order_by');
            } else {
                $maxValue += Category::getAll()->where('parent_id', $request->parent_id)->max('order_by');
            }

            $request['order_by'] = $maxValue;
            $request['is_global'] = $request->is_global ?? 1;
            $validator = Category::storeValidation($request->all());

            if ($validator->fails()) {
                $response['status'] = 0;
                $response['error'] = $validator->errors()->first();

                return $response;
            }

            $categoryId = (new Category())->store(
                $request->only('name', 'parent_id', 'status', 'is_searchable', 'is_featured', 'slug', 'order_by', 'sell_commissions', 'is_global')
            );
        }
        $response['status'] = 1;
        $response['category_id'] = $categoryId;

        return $response;
    }

    /**
     * Edit Category
     *
     * @param  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        $category = Category::getAll()->where('id', $request->id)->first();

        if (! empty($category)) {
            $data = [
                'name' => $category->name,
                'slug' => $category->slug,
                'status' => $category->status,
                'is_searchable' => $category->is_searchable,
                'is_featured' => $category->is_featured,
                'sell_commissions' => $category->sell_commissions,
                'parent_id' => $category->parent_id,
                'parent_name' => $category->category->name ?? null,
                'image_path' => $category->fileUrl(),
            ];

            return json_encode($data);
        }
    }

    /**
     * Update Category
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $response = ['status' => 0];

        if ($request->isMethod('post')) {
            $id = $request->edit_id;

            if ($id != 1) {
                $validator = Category::updateValidation($request->all(), $id);

                if ($validator->fails()) {
                    $response['status'] = 0;
                    $response['error'] = $validator->errors()->first();

                    return $response;
                }

                if ((new Category())->updateCategory(
                    $request->only('name', 'parent_id', 'status', 'is_searchable', 'is_featured', 'slug', 'sell_commissions'),
                    $id
                )) {
                    $response['status'] = 1;
                }
            }
        }

        return $response;
    }

    /**
     * Remove Category
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $response = ['status' => 0];
        $id = $request->id;

        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'categories');

            if ($result['status'] === true && $id != 1) {
                $response = (new Category())->remove($id);
                $response['status'] = isset($response['status']) && $response['status'] == 'success' ? 1 : 0;

                if ($response['status'] == 0) {
                    $response['error'] = $response['message'];
                }
            }
        }

        return $response;
    }

    /**
     * return parent data
     *
     * @return false|int|string
     */
    public function getParentData(Request $request)
    {
        if ($request->create_child == 1) {
            $cateInfo = Category::getAll()->where('id', $request->id)->first();
            $parentInfo = Category::getAll()->where('id', $cateInfo->parent_id)->first();

            return json_encode($parentInfo);
        }

        return 0;

    }

    /**
     * drag and drop js tree
     *
     * @return int[]
     */
    public function moveNode(Request $request)
    {
        $response = ['status' => 0];

        if ($request->data['parent'] != 1) {
            $request['id'] = $request->data['id'];
            $request['parent_id'] = $request->data['parent'];
            $request['old_parent_id'] = $request->data['old_parent'];
            $request['position'] = $request->data['position'];
            $request['old_position'] = $request->data['old_position'];

            if ((new Category())->nodeUpdate($request->only('id', 'parent_id', 'old_parent_id', 'position', 'old_position'))) {
                $response['status'] = 1;
            }
        }

        if ($response['status'] == 0) {
            $response['error'] = __('Not Permitted');
        }

        return $response;
    }
}
