<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 24-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Product\AddToCartService;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    private $cartService;

    /**
     * CartController Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->cartService = AddToCartService::getInstance();
    }

    /**
     * cart view page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->cartService->cartList();
    }

    /**
     * cart store & increment quantity
     *
     * @return array
     */
    public function store(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = __('Failed to added to cart! please try again.');

        if ((int) $request->is_group_product == 1 && is_array($request->group_products) && count($request->group_products) > 0) {
            foreach ($request->group_products as $product) {
                $request['code'] = $product['code'];
                $request['qty'] = $product['qty'];
                $response = $this->cartService->add($request);
                if ($response['status'] == 0) {
                    return $response;
                }
            }
        } elseif ($request->is_group_product != 1) {
            return $this->cartService->add($request);
        }

        return $response;
    }

    /**
     * remove cart by cart index
     *
     * @return array
     */
    public function destroy(Request $request)
    {
        return $this->cartService->delete($request);
    }

    /**
     * remove cart by cart index
     *
     * @return array
     */
    public function destroyAll(Request $request)
    {
        return $this->cartService->deleteAll($request);
    }

    /**
     * cart quantity reduce
     *
     * @return array
     */
    public function reduceQuantity(Request $request)
    {
        return $this->cartService->decrement($request);
    }

    /**
     * check coupon
     *
     * @return array
     */
    public function checkCoupon(Request $request)
    {
        return $this->cartService->checkCoupon($request);
    }

    /**
     * destroy selected
     *
     * @return array
     */
    public function destroySelected(Request $request)
    {
        return $this->cartService->deleteSelected($request);
    }

    /**
     * selected index store
     *
     * @return array
     */
    public function storeSelected(Request $request)
    {
        return $this->cartService->addSelected($request);
    }

    /**
     * select shipping
     *
     * @return array
     */
    public function selectShipping(Request $request)
    {
        return $this->cartService->selectShipping($request);
    }

    /**
     * delete coupon
     *
     * @return void
     */
    public function deleteCoupon(Request $request)
    {
        return $this->cartService->deleteCoupon($request);
    }
}
