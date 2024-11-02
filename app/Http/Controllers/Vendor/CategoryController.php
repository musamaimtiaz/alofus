<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 25-10-2023
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\{Category, VendorCategory};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(\App\Http\Controllers\CategoryController $category)
    {
        $isAllowed = preference('vendor_category');

        if ($isAllowed == 1) {
            $this->category = $category;
        } else {
            abort(403);
        }
    }

    /**
     * category view
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('vendor.category.index');
    }

    /**
     * category data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $vendorId = auth()->user()->vendor()->vendor_id;
        $data = [];
        $children = [];
        $subChildren = [];

        $categories = Category::whereNull('parent_id')->where('id', '!=', 1)->whereHas('vendorCategory', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->orderBy('order_by', 'ASC')->with('childrenCategories')->get();

        foreach ($categories as $category) {

            $categoriesChild = $category->childrenCategories->sortBy('order_by');

            foreach ($categoriesChild as $child) {

                $subChilds = $child->childrenCategories->sortBy('order_by');

                $vendorCategory = VendorCategory::where('category_id', $child->id)->where('vendor_id', $vendorId);

                if ($vendorCategory->exists()) {

                    foreach ($subChilds as $subChild) {

                        $vendorCategory = VendorCategory::where('category_id', $subChild->id)->where('vendor_id', $vendorId);

                        if ($vendorCategory->exists()) {
                            $subChildren[$subChild->parent_id][] = [
                                'text' => $subChild->name,
                                'id' => $subChild->id,
                                'parent_id' => $subChild->parent_id,
                                'create_child' => 0,
                            ];
                        }
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
     * store category
     *
     * @return \Illuminate\Http\RedirectResponse|int[]
     */
    public function store(Request $request)
    {
        $request['is_global'] = 0;
        $request['sell_commissions'] = preference('vendor_cat_commission') ?? null;
        $response =  $this->category->store($request);

        if ($response['status'] == 1) {
            VendorCategory::store($response);
        }

        return $response;
    }

    /**
     * category edit
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        return $this->category->edit($request);
    }

    /**
     * category update
     *
     * @return array|\Illuminate\Http\RedirectResponse|int[]
     */
    public function update(Request $request)
    {
        $response['status'] = 0;
        $vendorId = auth()->user()->vendor()->vendor_id;

        if ($request->edit_id) {
            $category = Category::where('id', $request->edit_id)->whereHas('vendorCategory', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })->first();

            if (! empty($category) && $category->is_global == 0) {
                return $this->category->update($request);
            } elseif (! empty($category) && $category->is_global == 1) {
                $response['status'] = 0;
                $response['error'] = __('Permission denied for System Category');
            }
        }

        return $response;
    }

    /**
     * category destroy
     *
     * @return array|\Illuminate\Http\RedirectResponse|int[]
     */
    public function destroy(Request $request)
    {

        $response['status'] = 0;
        $vendorId = auth()->user()->vendor()->vendor_id;

        if ($request->id) {
            $category = Category::where('id', $request->id)->whereHas('vendorCategory', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })->first();

            if (! empty($category) && $category->is_global == 0) {
                return $this->category->destroy($request);
            } elseif (! empty($category) && $category->is_global == 1) {
                $vendorCategory = VendorCategory::destroy($category->id);

                if ($vendorCategory) {
                    $response['status'] = 1;
                } else {
                    $response['error'] = __('Something went wrong, please try again.');
                }
            }
        }

        return $response;
    }

    /**
     * get parent data
     *
     * @return false|int|string
     */
    public function getParentData(Request $request)
    {
        return $this->category->getParentData($request);
    }

    /**
     * move node
     *
     * @return int[]
     */
    public function moveNode(Request $request)
    {
        return $this->category->moveNode($request);
    }

    /**
     * suggestion
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestion(Request $request)
    {

        $isAllowed = preference('system_suggestion') && preference('access_system_category');

        if ($isAllowed == 1) {
            if (isset($request->parnet_id)) {
                $category = Category::whereLike('name', $request->name)->where('parent_id', $request->parnet_id)->where('is_global', 1)->first();
            } else {
                $category = Category::whereLike('name', $request->name)->whereNull('parent_id')->where('is_global', 1)->first();
            }

            if (! empty($category)) {

                $vendorCategory = VendorCategory::where('category_id', $category->id);

                if (! $vendorCategory->exists()) {
                    return response()->json([
                        'status' => 1,
                        'name' => $category->name,
                        'id' => $category->id,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 0,
        ]);
    }

    /**
     * assign category
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function assignCategory(Request $request)
    {
        $isAllowed = preference('system_suggestion') && preference('access_system_category');

        if (isset($request->category_id) && $isAllowed == 1) {

            $category = Category::getAll()->where('id', $request->category_id)->first();

            if ($category->is_global == 1) {
                $vendorCategory = VendorCategory::store(['category_id' => $request->category_id]);

                if (! empty($vendorCategory)) {
                    return response()->json(['status' => 1]);
                }
            }

            return response()->json(['status' => 0]);
        }
    }
}
