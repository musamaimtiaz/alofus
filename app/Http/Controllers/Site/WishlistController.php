<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Auth;

class WishlistController extends Controller
{
    /**
     * Wishlist
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];

        $wishlist = Auth::user()->wishlist()->whereHas('product');
        if (isset($request->filter_day) && array_key_exists($request->filter_day, $filterDay)) {
            $wishlist = Auth::user()->wishlist()->whereHas('product')->whereDate('created_at', '>=', $filterDay[$request->filter_day]);
        }

        $data['wishlists'] = $wishlist->paginate(preference('row_per_page'));

        return view('site.wishlist.index', $data);
    }

    /**
     * Store
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = ['status' => 0, 'message' => __('Oops! Something went wrong, please try again.')];
        $request['user_id'] = Auth::user()->id ?? null;

        if ((new Wishlist())->checkExistence($request['user_id'], $request->product_id)) {
            if (! isset($request->store_only)) {
                if (Wishlist::where('user_id', \Auth::user()->id)->where('product_id', $request->product_id)->delete()) {
                    return ['status' => 1, 'message' => __('The :x has been successfully deleted.', ['x' => __('Wishlist')])];
                }

                return $response;
            }

            return true;
        }

        return (new Wishlist())->store($request->all());
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($productId)
    {
        if (Wishlist::where('user_id', \Auth::user()->id)->where('product_id', $productId)->delete()) {
            return back()->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Wishlist')]));
        }

        return back()->withFail(__('Something went wrong, please try again.'));
    }
}
