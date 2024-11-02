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
use App\Http\Requests\Site\WishlistStoreRequest;
use App\Http\Resources\{
    WishlistResource
};
use App\Models\{
    Wishlist,
};
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * User wishlist
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $wishlist = Wishlist::where('user_id', auth()->guard('api')->user()->id);
        if ($wishlist->count() == 0) {
            return $this->notFoundResponse();
        }
        $itemName = isset($request->item_name) ? $request->item_name : null;
        if (! empty($itemName)) {
            $wishlist->whereHas('item', function ($q) use ($itemName) {
                $q->where('name', strtolower($itemName));
            })->with('item');
        }

        $filter = isset($request->filter) ? $request->filter : null;
        if (! empty($filter)) {
            $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
            if (isset($filter) && array_key_exists($filter, $filterDay)) {
                $wishlist->whereDate('created_at', '>=', $filterDay[$filter]);
            }
        }

        $date = isset($request->date) ? $request->date : null;
        if (! empty($date)) {
            $wishlist->where('created_at', $date);
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (is_int($keyword)) {
                $wishlist->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orwhere('created_at', $keyword);
                });
            } elseif (strlen($keyword) >= 2) {
                $wishlist->where(function ($query) use ($keyword) {
                    $query->whereHas('item', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', '%' . $keyword . '%');
                    })->with('item')
                        ->orwhere('created_at', $keyword);
                });
            }
        }

        return $this->response([
            'data' => WishlistResource::collection($wishlist->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($wishlist->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store Wishlist
     *
     *
     * @return array $response
     */
    public function store(WishlistStoreRequest $request)
    {
        $request['user_id'] = auth()->user()->id;
        $data = (new Wishlist())->store($request->all());

        return $this->successResponse([
            'status' => 1,
            'message' => __('Product added to your wishlist.'),
            'data' => new WishlistResource(Wishlist::find($data['id'])),
        ]);
    }

    /**
     * Delete wishlist
     *
     * @param  int  $id
     * @return json $response
     */
    public function destroy($id, Request $request)
    {
        if (is_null($id) && empty($request->ids)) {
            return $this->unprocessableResponse([], __('Wishlist id is required.'));
        }

        $ids = [$id];

        if (! empty($request->ids)) {
            $ids = [$request->ids];

            if (is_array($request->ids)) {
                $ids = $request->ids;
            }
        }

        if (Wishlist::where('user_id', auth()->guard('api')->user()->id)->whereIn('id', $ids)->delete()) {
            return $this->okResponse([], __('The :x has been successfully deleted.', ['x' => __('Wishlist')]));
        }

        return $this->unprocessableResponse([], __('Wishlist id is invalid.'));
    }
}
