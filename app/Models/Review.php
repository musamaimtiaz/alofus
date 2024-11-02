<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 25-07-2021
 */

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Validator;

class Review extends Model
{
    use HasFactory;
    use hasFiles;
    use ModelTrait;

    public $timestamps = false;

    /**
     * Foreign key with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Foreign key with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required',
            'rating' => 'required|numeric',
            'comments' => 'nullable|max:500',
            'status' => 'required|in:Active,Inactive',
            'is_public'  => 'required|in:1,0',
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'status' => 'required|in:Active,Inactive',
        ]);

        return $validator;
    }

    /**
     * User Review Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function userUpdateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'rating' => 'required|numeric',
            'comments' => 'nullable|max:500',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);
        $this->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);

        if (! empty($id)) {
            return $id;
        }

        return false;
    }

    /**
     * Update Brand
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateReview($data = [], $id = null)
    {
        $result = parent::where('id', $id);

        if ($result->exists()) {
            $result->update($data);
            $result->first()->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);

            return true;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);

        if (! empty($record)) {
            try {
                $record->delete();

                //delete file region
                $record->deleteFiles(['thumbnail' => false]);

                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Review')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * Get specific vendor review
     *
     * @return bool|object
     */
    public static function getVendorReviews($vendorId = null, $product = null)
    {
        if (empty($vendorId)) {
            return false;
        }

        $data = parent::select('id', 'comments', 'rating', 'is_public', 'status', 'product_id', 'user_id')
            ->whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with(['product:id,name', 'user:id,name']);

        if (empty($product)) {
            return $data;
        }

        return $data->where('product_id', $product);
    }

    /**
     * Check verified user
     *
     * @return bool
     */
    public function verifiedUser($userId, $productId)
    {
        return \DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'orders.user_id')
            ->where('order_details.product_id', $productId)
            ->where('orders.user_id', $userId)
            ->count() > 0 ? true : false;
    }

    /**
     * is review editable or not
     */
    public function isEditable(): bool
    {
        return isset(auth()->guard('api')->user()->id) && auth()->guard('api')->user()->id == $this->user_id || isset(auth()->user()->id) && auth()->user()->id == $this->user_id;
    }

    public function reviewImages()
    {
        return $this->objectFile()->get()->isNotEmpty() ? $this->filesUrlold() : [];
    }
}
