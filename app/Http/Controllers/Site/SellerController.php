<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-01-2022
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index($alias = null)
    {
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)
            || (request('homepage') && (! auth()->user() || (auth()->user()->role()->type == 'global' && ! isSuperAdmin())
            || (auth()->user()->role()->type == 'vendor' && auth()->user()->vendor()->vendor_id != $data['shop']->vendor_id)))) {
            abort(404);
        }

        $data['allProducts'] = Product::where('vendor_id', $data['shop']->vendor_id)->paginate(25);
        $data['displayPrice'] = preference('display_price_in_shop');
        $data['topSellerIds'] = Vendor::topSeller()->pluck('vendor_id')->toArray();
        $data['vendor'] = Vendor::with('reviews', 'shops')->where('id', $data['shop']->vendor_id)->first();
        $data['reviewCount'] = $data['vendor']->reviews->where('status', 'Active')->count();
        $data['avg'] = $data['vendor']->reviews->where('status', 'Active')->avg('rating');
        $data['positiveRating'] = Product::positiveRating($data['shop']->vendor_id);

        $data['displayPrice'] = preference('display_price_in_shop');
        $data['homeService'] = $homeService = new \Modules\CMS\Service\HomepageService();
        $data['vendorPage'] = $homeService->home($data['shop']->vendor_id);

        return view('site.shop.index', $data);
    }

    public function vendorProfile($alias = null)
    {
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)) {
            abort(404);
        }

        $data['vendor'] = Vendor::with('reviews', 'shops')->where('id', $data['shop']->vendor_id)->first();
        $data['reviewCount'] = $data['vendor']->reviews->where('status', 'Active')->count();
        $data['avg'] = $data['vendor']->reviews->where('status', 'Active')->avg('rating');
        $data['positiveRating'] = Product::positiveRating($data['shop']->vendor_id);
        $data['reviews'] = $data['vendor']->reviews()->where('reviews.status', 'Active')->orderBy('created_at', 'desc')->with('user')->paginate(5);
        $data['progessBarRating'] = $data['vendor']->reviews()->where('reviews.status', 'Active')->select(\DB::raw('count("rating") as total_rating, rating'))->groupBy('rating')->orderBy('rating', 'desc')->get()->toArray();
        $data['topSellerIds'] = Vendor::topSeller()->pluck('vendor_id')->toArray();

        $data['homeService'] = $homeService = new \Modules\CMS\Service\HomepageService();
        $data['vendorPage'] = $homeService->home($data['shop']->vendor_id);

        return view('site.shop.vendorProfile', $data);
    }

    /**
     * Review filter
     *
     * @return render view
     */
    public function searchReview(Request $request)
    {
        if ($request->ajax()) {
            $vendor = Vendor::with('reviews')->where('id', $request->vendor_id)->first();
            $reviews = $vendor->reviews()->where('reviews.status', 'Active');
            if ($request->rating) {
                $reviews = $reviews->where('rating', $request->rating);
            }

            $reviews = $reviews->orderBy('created_at', 'desc')->with('user:id,name')->paginate(5);
            $html = view('site.shop.review', compact('reviews', 'vendor'))->render();

            return $this->successResponse(['data' => $html]);
        }
        abort(403);
    }
}
