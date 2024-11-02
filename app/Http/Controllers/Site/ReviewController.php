<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Auth;

class ReviewController extends Controller
{
    /**
     * Review
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];

        $review = Auth::user()->review()->has('product');

        if (isset($request->filter_day) && array_key_exists($request->filter_day, $filterDay)) {
            $review = $review->whereDate('created_at', '>=', $filterDay[$request->filter_day]);
        }

        if (isset($request->filter_status)) {
            $status = $request->filter_status == 'approve' ? 'Active' : 'Inactive';
            $review->where('status', $status);
        }
        $data['reviews'] = $review->paginate(preference('row_per_page'));

        return view('site.review.index', $data);
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
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

        return redirect()->back();
    }
}
