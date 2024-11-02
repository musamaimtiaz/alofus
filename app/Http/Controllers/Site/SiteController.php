<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Models\{Address, Brand, Category, File, OrderMeta, Product, Review, Search};
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Modules\Blog\Http\Models\{
    Blog,
    BlogCategory
};
use Modules\CMS\Entities\Page as HomePage;
use Modules\Gateway\Entities\GatewayModule;
use Modules\CMS\Http\Models\{
    Slide,
    Page
};
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use App\Services\SearchService;
use Modules\CMS\Entities\Component;
use Modules\CMS\Service\HomepageService;
use Modules\Coupon\Http\Models\Coupon;

class SiteController extends Controller
{
    /**
     * Homepage
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['displayPrice'] = preference('display_price_in_shop');
        $data['slides'] = Slide::whereHas('slider', function ($query) {
             $query->where(['slug' => option('default_template_page', 'home-slider')['slider'], 'status' => 'Active']);
            // $query->where('slug','home-page')->where('status','Active');
        })->get();
        $data['recentView'] = Product::recentView();
        $data['homeService'] = $homeService = new \Modules\CMS\Service\HomepageService();
        $data['page'] = $homeService->home();

        if (! auth()->check() && isActive('Affiliate')) {
            \Modules\Affiliate\Entities\Referral::userClickUpdate();
        }

        return view('site.home.index', $data);
    }

    /**
     * Product Details
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function productDetails(Request $request)
    {
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);

        if (! $product) {
            abort(404);
        }

        $data = (new ProductDetailResource($product))->toArray(null);

        if (
            ! empty($data) && $data['status'] == 'Published' && $product->availability() ||
            ! empty($data) && ! empty($data['vendor_id']) && $data['vendor_id'] == session()->get('vendorId') ||
            ! empty($data) && isset(Auth::user()->id) && isset(Auth::user()->role()->type) && Auth::user()->role()->slug == 'super-admin'
        ) {
            $data['vendorDetails'] = $product->vendor;
            $data['groupProducts'] = $product->groupProducts();
            $data['relatedProducts'] = $product->getRelatedProducts();
            $data['avg'] = $product->review()->where('status', 'Active')->avg('rating');
            $data['reviewCount'] = $product->review->where('status', 'Active')->count('rating');
            $data['sameShop'] = $product->sameShop();
            $data['reviews'] = $product->review()->where('status', 'Active')->paginate(5);
            $data['product'] = $product;
            $data['displayPrice'] = preference('display_price_in_shop');
            $data['categoryPath'] = $product->categoryPath();
            $data['filterVariation'] = $product->filterVariation();
            $data['defaultAddresses'] = isset(Auth::user()->id) ? Address::getAll()->where('user_id', Auth::user()->id)->where('is_default', 1)->first() : null;
            $data['gateways'] = (new GatewayModule())->payableGateways();
            $data['offerFlag'] = $product->offerCheck();
            $data['vendorReview'] = $product->vendorReview();
            $product->recentView();
            $product->updateViewCount();

            if (isActive('Affiliate')) {
                \Modules\Affiliate\Entities\Referral::userClickUpdate($product->id);
            }

            return view('site.product.details', $data);
        }

        abort(404);
    }

    /**
     * Blog all list
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function allBlogs()
    {
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->where(['status' => 'Active'])->archiveFilter(request(['year']))->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }

        $data['blogCategory'] = null;

        $data['popularBlogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->orderBy('total_views', 'DESC')->get()->take(3);

        $data['blogCategories'] = BlogCategory::whereHas('blog', function ($query) {
            $query->activePost();
        })->where('status', 'Active')->get();

        $data['archives'] = Blog::archives();

        return view('site.blog.blog-post', $data);
    }

    /**
     * search blog list
     *
     * @return array
     */
    public function blogSearch(Request $request)
    {
        $value = $request->search;
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->WhereLike('title', $value)
            ->orWhereLike('description', $value)->activePost()->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }

        $data['blogCategory'] = null;

        $data['popularBlogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->orderBy('total_views', 'DESC')->get()->take(3);

        $data['blogCategories'] = BlogCategory::whereHas('blog', function ($query) {
            $query->activePost();
        })->where('status', 'Active')->get();

        $data['archives'] = Blog::archives();

        return view('site.blog.blog-post', $data);
    }

    /**
     * Blog Details
     */
    public function blogDetails($slug)
    {
        $query = Blog::with('user:id,name')->whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost();
        $data['blog'] = $query = $query->where('slug', $slug)->first();

        if (empty($data['blog'])) {
            return redirect()->back();
        }

        $blogKey = 'blog_' . $data['blog']->id;
        if (! Session::has($blogKey)) {
            $data['blog']->increment('total_views');
            Session::put($blogKey, 1);
        }

        $nextId = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->where('id', '>', $data['blog']->id)->min('id');
        $data['nextUrl'] = Blog::find($nextId);

        $previousId = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->where('id', '<', $data['blog']->id)->max('id');
        $data['previousUrl'] = Blog::find($previousId);

        $data['popularBlogs'] = $query->whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->orderBy('total_views', 'DESC')->get()->take(3);

        $data['blogCategories'] = BlogCategory::whereHas('blog', function ($query) {
            $query->activePost();
        })->where('status', 'Active')->get();

        $data['relatedPosts'] = $query->with('user:id,name')->where('category_id', $data['blog']->category_id)->activePost()->where('id', '!=', $data['blog']->id)->orderBy('id', 'DESC')->get()->take(3);

        $data['archives'] = Blog::archives();

        return view('site.blog.blog-details', $data);
    }

    /**
     * Blog Category
     */
    public function blogCategory($id)
    {
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->where(['category_id' => $id, 'status' => 'Active'])->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }
        $data['blogCategory'] = BlogCategory::find($id);
        $data['popularBlogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost()->orderBy('total_views', 'DESC')->get()->take(3);

        $data['blogCategories'] = BlogCategory::whereHas('blog', function ($query) {
            $query->activePost();
        })->where('status', 'Active')->get();

        $data['archives'] = Blog::archives();

        return view('site.blog.blog-post', $data);
    }

    /**
     * Pages
     */
    public function page($slug)
    {
        $data['page'] = Page::getAll()->where('slug', $slug)->where('status', 'Active')->first();
        if (isset($data['page'])) {
            if ($data['page']->type == 'home') {
                $data['displayPrice'] = preference('display_price_in_shop');
                $data['slides'] = Slide::whereHas('slider', function ($query) {
                    $query->where(['slug' => 'home-page', 'status' => 'Active']);
                })->get();
                $data['recentView'] = Product::recentView();
                if (isActive('CMS')) {
                    $data['homeService'] = new \Modules\CMS\Service\HomepageService();
                    $data['page'] = HomePage::where('slug', $slug)->with(['components' => function ($q) {
                        $q->with(['properties', 'layout:id,file'])->orderBy('level', 'asc');
                    }])->first();
                    if ($data['page']) {
                        return view('site.home.index', $data);
                    }
                }
            }

            return view('site.pages.page', $data);
        }

        abort(404);
    }

    /**
     * Review Store
     *
     * @return array
     */
    public function reviewStore(Request $request)
    {
        $response = ['status' => 0, 'message' => __('Oops! Something went wrong, please try again.')];
        $request['user_id'] = Auth::user()->id ?? null;
        if (Review::where('user_id', $request['user_id'])->where('product_id', $request->product_id)->count() > 0) {
            $response['message'] = __('You have already done your review.');

            return $response;
        }

        if (preference('review_left') == 1 && ! auth()->user()->isPurchaseProduct($request->product_id)) {
            $response['message'] = __('To give a review you need to purchase the product first.');

            return $response;
        }

        $request['status'] = 'Active';
        $request['is_public'] = 1;
        $validator = Review::storeValidation($request->all());
        if ($validator->fails()) {
            $response['status'] = 0;
            $response['message'] = $validator->errors()->first();

            return $response;
        }
        $id = (new Review())->store($request->only('comments', 'user_id', 'status', 'is_public', 'rating', 'product_id'));
        if (! empty($id)) {
            $response['status'] = 1;
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $response;
        }

        return $response;
    }

    /**
     * Review fetch
     *
     * @return render view
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::where('product_id', $request->product_id)->where('status', 'Active')->where('is_public', 1)->paginate(5);

            return view('site.product.review', compact('reviews'))->render();
        }
    }

    /**
     * Edit review
     *
     * @return view
     */
    public function updateReview(Request $request)
    {
        $response = ['status' => 0, 'message' => __('Oops! Something went wrong, please try again.')];

        $validator = Review::userUpdateValidation($request->all());
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();

            return $response;
        }
        if ((new Review())->updateReview($request->only('comments', 'rating'), $request->id)) {
            $response['status'] = 1;
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $response;
        }

        return $response;
    }

    /**
     * delete review image
     *
     * @param  $file
     * @return response
     */
    public function deleteReview(Request $request)
    {
        $fileExplode = explode(DIRECTORY_SEPARATOR, $request->path);
        $fileName = $fileExplode[count($fileExplode) - 2] . DIRECTORY_SEPARATOR . end($fileExplode);
        if (File::where('file_name', $fileName)->delete()) {
            if (file_exists(public_path('/uploads/' . $fileName))) {
                unlink(public_path('/uploads/' . $fileName));
            }

            return response()->json('success');
        }

        return response()->json('error');
    }

    /**
     * Review filter
     *
     * @return render view
     */
    public function filterReview(Request $request)
    {
        if ($request->ajax()) {
            $reviews = Review::where('product_id', $request->product_id)->where('status', 'Active')->where('is_public', 1);

            if ($request->rating) {
                $reviews = $reviews->where('rating', $request->rating);
            }

            $reviews = $reviews->paginate(5);

            return view('site.product.review', compact('reviews'))->render();
        }
    }

    /** products by brand
     *
     * @param  $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function brandProducts($id)
    {
        $brand = Brand::getAll()->where('id', $id)->first();
        if (! empty($brand)) {
            $data['brand'] = $brand;

            return view('site.filter.index', $data);
        }

        return redirect()->back();
    }

    /**
     * product search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $data['page_title'] = __('Products');

        if (! empty($request->all())) {
            return view('site.filter.index', $data);
        } else {
            return redirect()->back();
        }
    }

    /**
     * get searchable data
     *
     * @return array
     */
    public function getSearchData(Request $request, SearchService $search)
    {
        if (! filled($request->search)) {
            return [
                'status' => 0,
                'message' => __('No Data Found'),
            ];
        }

        return [
            'status' => 1,
            'searchData' => json_encode([
                'popularSuggestion' => $search->getPopularSuggestion($request->search),
                'popularCategories' => $search->getPopularCategories($request->search),
                'products' => $search->getProducts($request->search),
                'shops' => $search->getShops($request->search),
            ]),
        ];
    }

    /**
     * Product Quick view
     *
     * @return string|void
     */
    public function quickView(Request $request, $code)
    {
        $request['code'] = $code;
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);
        if (! $product) {
            abort(404);
        }
        $data = (new ProductDetailResource($product))->toArray(null);
        $data['product'] = $product;
        $data['displayPrice'] = preference('display_price_in_shop');
        $data['productView'] = true;
        $data['filterVariation'] = $product->filterVariation();
        $data['offerFlag'] = $product->offerCheck();
        $data['avg'] = $product->review()->where('status', 'Active')->avg('rating');
        $data['reviewCount'] = $product->review->where('status', 'Active')->count('rating');
        if (! empty($data)) {
            if ($request->ajax()) {
                return view('site.layouts.includes.product_view', $data)->render();
            }
        }
    }

    /**
     * Coupon
     *
     * @return render view
     */
    public function coupon()
    {
        $data = Coupon::getCoupons(true, true);

        return view('site.coupon.index', $data);
    }

    public function getComponentProduct(Request $request)
    {
        if (! $request->get('component')) {
            return $this->notFoundResponse([], __('Invalid component'));
        }
        $data['displayPrice'] = preference('display_price_in_shop');
        $data['component'] = Component::whereId($request->get('component'))
            ->with(['layout:id,file', 'properties', 'page:id,layout'])->first();
        $data['homeService'] = new HomepageService();

        // $html = $data;
        $html = view('cms::templates.blocks.sub.' . $data['component']->layout->file . '-data', $data)->render();

        return $this->successResponse(['html' => $html]);
    }

    /**
     * get shipping
     *
     * @return array
     */
    public function getShipping(Request $request)
    {
        $address = [
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'post_code' => null,
        ];

        return Product::getMaxShipping($request->product_id, $address);
    }

    /**
     * download file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        try {
            $fileArray = explode(',', $request->file);
            $isDownloadable = false;
            $fileName = \Str::random(10);
            $orderMeta = OrderMeta::where('order_id', $fileArray[1] ?? null)->where('key', 'download_data')->first();

            if (! empty($orderMeta)) {
                $downloadArray = [];

                foreach ($orderMeta->value as $download) {
                    $downloadTimes = $download['download_times'];

                    if (isset($fileArray[0]) && $download['id'] == $fileArray[0] && $download['is_accessible'] == 1) {
                        if ($orderMeta->order->checkValidFile($download)) {
                            $downloadTimes  = $downloadTimes + 1;
                            $isDownloadable = true;
                            $fileName = $download['f_name'];
                        }
                    }

                    $downloadArray[] = [
                        'id' => $download['id'],
                        'download_limit' => $download['download_limit'],
                        'download_expiry' => $download['download_expiry'],
                        'link' => $download['link'],
                        'download_times' => $downloadTimes,
                        'is_accessible' => $download['is_accessible'],
                        'vendor_id' => $download['vendor_id'],
                        'name' => $download['name'],
                        'f_name' => $download['f_name'],
                    ];
                }

                if ($isDownloadable) {
                    OrderMeta::updateOrCreate(
                        ['order_id' => $fileArray[1], 'key' => 'download_data'],
                        ['type' => 'string', 'value' => $downloadArray]
                    );
                    $link = Crypt::decrypt($request->link);
                    $ext = pathinfo($link, PATHINFO_EXTENSION);
                    $fileName = str_contains($fileName, '.') ? substr($fileName, 0, strpos($fileName, '.')) : $fileName;
                    $fileName =  $fileName . '.' . $ext;
                    $tempImage = tempnam(sys_get_temp_dir(), $fileName);
                    copy($link, $tempImage);

                    return response()->download($tempImage, $fileName);
                }
            }
        } catch (DecryptException $e) {
            abort(404);
        }

        abort(404);
    }

    /**
     * All Categories
     *
     * @return render view
     */
    public function allCategories()
    {
        $data['homeService'] = $homeService = new \Modules\CMS\Service\HomepageService();
        $data['page'] = $homeService->home();

        return view('site.all_categories.all_categories', $data);
    }
}
