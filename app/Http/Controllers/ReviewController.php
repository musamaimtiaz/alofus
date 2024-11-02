<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 15-11-2021
 */

namespace App\Http\Controllers;

use App\DataTables\ReviewListDataTable;
use App\Exports\ReviewListExport;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Excel;

class ReviewController extends Controller
{
    /**
     * Review List
     *
     * @return mixed
     */
    public function index(ReviewListDataTable $dataTable)
    {
        return $dataTable->render('admin.reviews.index');
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

        return view('admin.reviews.view', $data);
    }

    /**
     * Update Review
     *
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $response             = [];
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
    public function destroy(Request $request, $id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        if ($request->isMethod('post')) {
            $result = $this->checkExistence($id, 'reviews');
            if ($result['status'] === true) {
                $response = (new Review())->remove($id);
            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->route('review.index');
    }

    /**
     * Review list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['reviews'] = Review::all();

        return printPDF(
            $data,
            'reviews_lists' . time() . '.pdf',
            'admin.reviews.list_pdf',
            view('admin.reviews.list_pdf', $data),
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
        return Excel::download(new ReviewListExport(), 'reviews_lists' . time() . '.csv');
    }
}
