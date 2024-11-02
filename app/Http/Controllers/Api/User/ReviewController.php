<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 26-01-2022
 */

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\{
    ProductReviewResource,
    ReviewResource,
};
use App\Models\{
    File,
    Review,
};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * User Review
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $review = Review::where('user_id', auth()->guard('api')->user()->id);
        if ($review->count() == 0) {
            return $this->notFoundResponse();
        }
        $item = isset($request->item_name) ? $request->item_name : null;
        if (! empty($item)) {
            $review->whereHas('item', function ($q) use ($item) {
                $q->where('name', strtolower($item))->orWhere('id', $item);
            })->with('item');
        }

        $filter = isset($request->filter) ? $request->filter : null;
        if (! empty($filter)) {
            $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
            if (isset($filter) && array_key_exists($filter, $filterDay)) {
                $review->whereDate('created_at', '>=', $filterDay[$filter]);
            }
        }

        $comment = isset($request->comment) ? $request->comment : null;
        if (! empty($comment)) {
            $review->where('comments', strtolower($comment));
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $review->where('status', $status);
        }

        if (isset($request->is_public)) {
            $review->where('is_public', $request->is_public);
        }

        $rating = isset($request->rating) ? $request->rating : null;
        if (! empty($rating)) {
            $review->where('rating', $rating);
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $review->where('id', $keyword);
            } elseif (strlen($keyword) >= 2) {
                $review->where(function ($query) use ($keyword) {
                    $query->whereHas('item', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', '%' . $keyword . '%');
                    })->with('item')
                        ->orwhere('comments', 'LIKE', '%' . $keyword . '%')
                        ->orwhere('status', $keyword);
                });
            }
        }

        return $this->response([
            'data' => ReviewResource::collection($review->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($review->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * review store
     *
     * @return json $response
     */
    public function store(Request $request)
    {
        $response = ['status' => 'fail', 'message' => __('Oops! Something went wrong, please try again.')];
        $request['user_id'] = auth()->guard('api')->user()->id ?? null;
        if (Review::where('user_id', $request['user_id'])->where('product_id', $request->product_id)->count() > 0) {
            $response['status'] = 'fail';
            $response['message'] = __('You have already done your review.');

            return $this->unprocessableResponse($response);
        }
        $request['status'] = 'Active';
        $request['is_public'] = 1;
        $validator = Review::storeValidation($request->all());
        if ($validator->fails()) {
            $response['status'] = 'fail';
            $response['message'] = $validator->errors()->first();

            return $this->unprocessableResponse($response);
        }
        $id = (new Review())->store($request->only('comments', 'user_id', 'status', 'is_public', 'rating', 'product_id'));
        if (! empty($id)) {
            $response['status'] = 'success';
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }

    /**
     * Update review
     *
     * @return json $response
     */
    public function update(Request $request, $id)
    {
        $response = ['status' => 'fail', 'message' => __('Oops! Something went wrong, please try again.')];

        $validator = Review::userUpdateValidation($request->all());
        if ($validator->fails()) {
            $response['status'] = 'fail';
            $response['message'] = $validator->errors()->first();

            return $this->unprocessableResponse($response);
        }
        if ((new Review())->updateReview($request->only('comments', 'rating'), $id)) {
            $response['status'] = 'success';
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }

    /**
     * delete review image
     *
     * @param  $file
     * @return response
     */
    public function deleteFile(Request $request)
    {
        $response = ['status' => 'fail', 'message' => __('Oops! Something went wrong, please try again.')];
        if (empty($request->path)) {
            return $this->errorResponse($response);
        }

        $fileExplode = explode(DIRECTORY_SEPARATOR, $request->path);
        $count = DIRECTORY_SEPARATOR == '/' ? 2 : 3;
        $fileName = $fileExplode[count($fileExplode) - $count] . DIRECTORY_SEPARATOR . end($fileExplode);
        if (File::where('file_name', $fileName)->delete()) {
            if (file_exists(public_path('/uploads/' . $fileName))) {
                unlink(public_path('/uploads/' . $fileName));
            }
            $response['status'] = 'success';
            $response['message'] = __('File remove successfully.');

            return $this->successResponse($response);
        }

        return $this->errorResponse($response);
    }

    /**
     * Product Review
     *
     * @param  int  $productId
     * @return json $data
     */
    public function productReview(Request $request, $productId)
    {
        $configs = $this->initialize([], $request->all());
        $review = Review::where('product_id', $productId)->where('status', 'Active');
        if ($review->count() == 0) {
            return $this->notFoundResponse([], __('Review not found.'));
        }

        if ($request->has('rating')) {
            $review->where('rating', $request->rating);
        }

        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
        if ($request->has('filter_day') && array_key_exists($request->filter_day, $filterDay)) {
            $review->whereDate('created_at', '>=', $filterDay[$request->filter_day]);
        }

        if ($request->has('keyword')) {
            if (is_int($request->keyword)) {
                $review->where('id', $request->keyword);
            } elseif (strlen($request->keyword) >= 2) {
                $review->where(function ($query) use ($request) {
                    $query->where('comments', 'LIKE', '%' . $request->keyword . '%');
                });
            }
        }

        return $this->response([
            'data' => ProductReviewResource::collection($review->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($review->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * delete review
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = Review::where('user_id', auth()->guard('api')->user()->id)->where('id', $request->id);

        if ($result->exists()) {
            $response = (new Review())->remove($request->id);

            return $this->successResponse($response['message']);
        } else {
            $response['message'] = __('Reviews does not exist.');
        }

        return $this->errorResponse($response['message']);
    }
}
