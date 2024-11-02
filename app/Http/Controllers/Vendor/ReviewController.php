<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-12-2021
 */

namespace App\Http\Controllers\Vendor;

use App\DataTables\VendorReviewListDataTable;
use App\Exports\VendorReviewListExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    File,
    Review,
    Vendor
};
use Excel;

class ReviewController extends Controller
{
    /**
     * Review List
     *
     * @param  ReviewListDataTable  $dataTable
     * @return mixed
     */
    public function index(VendorReviewListDataTable $dataTable)
    {
        return $dataTable->render('vendor.review.index');
    }

    /**
     * Edit Review
     *
     * @param  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {
        if (! empty($request->id)) {
            $review = Review::where('id', $request->id)->first();
            $return_rev['id'] = $review->id;
            $return_rev['status'] = $review->status;
            $return_rev['is_public'] = $review->is_public;

            return json_encode($return_rev);
        }
    }

    public function view($id)
    {
        $review = Review::with('product:id,name,vendor_id,slug', 'user:id,name', 'product.vendor:id,name')->where('id', $id)->first();
        if (empty($review)) {
            $response = $this->messageArray(__(':x does not exist.', ['x' => __('Review')]), 'fail');
            $this->setSessionValue($response);

            return redirect()->route('review.index');
        }

        $data['review'] = $review;
        $data['topSellerIds'] = Vendor::topSeller()->pluck('vendor_id')->toArray();

        return view('vendor.review.view', $data);
    }

    /**
     * Update Review
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $response = [];
        $response = $this->messageArray(__('Something went wrong, please try again.'), 'fail');
        $validator = Review::updateValidation($request->all(), $request->review_id);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ((new Review())->updateReview($request->only('status', 'is_public'), $request->review_id)) {
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('Review')]), 'success');
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Remove Review
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'reviews');
        if ($result['status'] === true) {
            $response = (new Review())->remove($id);
        } else {
            $response['message'] = $result['message'];
        }

        $this->setSessionValue($response);

        return redirect()->route('vendor.reviews');
    }

    /**
     * Review list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['reviews'] = Review::getVendorReviews(session()->get('vendorId'))->get();

        return printPDF(
            $data,
            'reviews_lists' . time() . '.pdf',
            'vendor.review.list_pdf',
            view('vendor.review.list_pdf', $data),
            'pdf'
        );
    }

    /**
     * Review list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new VendorReviewListExport(), 'reviews_lists' . time() . '.csv');
    }
}
