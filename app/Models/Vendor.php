<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-08-2021
 *
 * @modified 29-09-2021
 */

namespace App\Models;

use App\Notifications\AcceptSellerRequestNotification;
use App\Notifications\ChangeSellerRequestNotification;
use App\Notifications\Notification;
use App\Traits\ModelTraits\hasFiles;
use App\Traits\ModelTraits\Metable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Modules\Shop\Http\Models\Shop;

class Vendor extends Model
{
    use hasFiles;
    use Metable;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    protected $metaTable = 'vendors_meta';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function ($vendor) {
            if ($vendor->isDirty('status') && $vendor->status != $vendor->getOriginal('status')) {
                $notificationClasses = [
                    'Active' => AcceptSellerRequestNotification::class,
                    'Pending' => ChangeSellerRequestNotification::class,
                    'Inactive' => ChangeSellerRequestNotification::class,
                ];

                if (array_key_exists($vendor->status, $notificationClasses)) {
                    $notificationClass = $notificationClasses[$vendor->status];
                    $vendor->notify(new $notificationClass($vendor));
                }
            }
        });
    }

    /**
     * Relation with AttributeGroup model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeGroups()
    {
        return $this->hasMany('App\Models\AttributeGroup', 'vendor_id', 'id');
    }

    /**
     * Relation with Brand model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands()
    {
        return $this->hasMany('App\Models\Brand', 'vendor_id', 'id');
    }

    /**
     * Relation with FlashSale model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flashSales()
    {
        return $this->hasMany('App\Models\FlashSale', 'vendor_id', 'id');
    }

    /**
     * Relation with Product model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'vendor_id', 'id');
    }

    /**
     * Relation with OptionGroup model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionGroups()
    {
        return $this->hasMany('App\Models\OptionGroup', 'vendor_id', 'id');
    }

    /**
     * Relation with StockManagement model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockManagements()
    {
        return $this->hasMany('App\Models\StockManagement', 'vendor_id', 'id');
    }

    /**
     * Relation with VendorUser model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\VendorUser', 'vendor_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatarFile()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'VENDOR');
    }

    /**
     * Relation with coupon model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupons()
    {
        return $this->hasMany('Modules\Coupon\Http\Models\Coupon', 'vendor_id', 'id');
    }

    /**
     * Relation with shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shops()
    {
        return $this->hasMany('Modules\Shop\Http\Models\Shop', 'vendor_id', 'id');
    }

    /**
     * Relation with shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shop()
    {
        return $this->hasOne('Modules\Shop\Http\Models\Shop', 'vendor_id', 'id')->latestOfMany();
    }

    /**
     * Relation with Transaction model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relation with user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userList()
    {
        return $this->belongsToMany(User::class, 'vendor_users');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        $vendor = parent::create($data['vendorData']);

        if (isset($data['vendorMetaData']) && ! empty($data['vendorMetaData'])) {
            $vendor->setMeta($data['vendorMetaData']);
            $vendor->save();
            $arr = ['vendor_logo', 'cover_photo'];

            foreach ($data['vendorMetaData'] as $key => $value) {

                if (! in_array($key, $arr)) {
                    continue;
                }

                request()->file_id = [$value];
                $vendorMeta = $vendor->metas()->where('key', $key)->first();

                $vendorMeta->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
            }
        }

        self::forgetCache();

        return $vendor->id;
    }

    /**
     * Update Vendor
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateVendor($data = [], $id = null)
    {
        $vendor = Vendor::where('id', $id)->first();

        if (! $vendor) {
            return false;
        }

        do_action('before_vendor_update', [$vendor, $data]);

        $vendor->update($data['vendorData']);
        $vendor = Vendor::where('id', $id)->first();
        $vendor->setMeta($data['vendorMetaData']);
        $vendor->save();
        $arr = ['vendor_logo', 'cover_photo'];

        foreach ($data['vendorMetaData'] as $key => $value) {
            if (! in_array($key, $arr)) {
                continue;
            }

            request()->file_id = [$value];
            $vendor = Vendor::where('id', $id)->first()->metas()->where('key', $key)->first();
            $vendor->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
        }

        self::forgetCache(['vendors', 'categories', 'brands']);

        do_action('after_vendor_update', $vendor);

        return true;
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data   = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);

        do_action('before_vendor_delete', $record);

        if (! empty($record)) {
            $record->deleteFiles(['thumbnail' => true]);
            $record->delete();
            self::forgetCache(['vendors', 'brands', 'attribute_groups', 'attributes', 'attribute_values']);
            $data['status']  = 'success';
            $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Vendor')]);
        }

        do_action('after_vendor_delete', $record);

        return $data;
    }

    /**
     * shop id to vendor id
     *
     * @return int $id
     */
    public static function shopToVendor($id)
    {
        return Shop::where('id', $id)->first()->vendor_id ?? null;
    }

    /**
     * find shop rating and review count
     *
     * @return object
     */
    public function shopReview()
    {
        $productReview = $this->hasManyThrough(Review::class, Product::class)->where('reviews.status', 'Active');

        return (object) ['count' => $productReview->count(), 'rating' => $productReview->avg('rating')];
    }

    /**
     * Get all of the review for the vendor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Product::class);
    }

    /**
     * Top seller
     *
     * @return mixed
     */
    public static function topSeller()
    {
        $vendors = OrderDetail::select(DB::raw('count("vendor_id") as total_vendor_id, vendor_id'))->groupBy('vendor_id')->orderBy('total_vendor_id', 'desc')->take(20)->get();

        return $vendors;
    }

    /**
     * Get the vendor cover photo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getCoverAttribute()
    {
        return $this->metas()->where('key', 'cover_photo')->first();
    }

    /**
     * Get the vendor logo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getLogoAttribute()
    {
        return $this->metas()->where('key', 'vendor_logo')->first();
    }

    /**
     * calculate ship on time
     *
     * @param  $vendorId
     * @return float|int
     */
    public function onTimeShipment()
    {
        $onTimeProducts = OrderDetail::where('vendor_id', $this->id)->where('is_delivery', 1);

        if (! $onTimeProducts->exists()) {
            return 100;
        } else {
            $totalVendorProducts = $onTimeProducts->count();
            $onTimeProducts = $onTimeProducts->where('is_on_time', 1)->count();

            if ($totalVendorProducts > 0) {
                return round(($onTimeProducts * 100) / $totalVendorProducts);
            }

            return 100;
        }
    }

    /**
     * calculate order cancelation in percent
     *
     * @return float|int
     */
    public function orderCancel()
    {
        $query = OrderDetail::select('order_id', 'order_status_id')->where('vendor_id', $this->id)->get();

        if (! $query) {
            return 0;
        }

        $orderStatus =  OrderStatus::whereSlug('cancelled')->first();
        $totalVendorOrder = $query->groupBy('order_id')->count();
        $keep = $query->where('order_status_id', '!=', $orderStatus->id)->groupBy('order_id')->count();
        $totalCancelOrder = $totalVendorOrder - $keep;

        if ($totalVendorOrder > 0) {
            return round(($totalCancelOrder / $totalVendorOrder) * 100);
        }

        return 0;
    }

    /**
     * check vendor exist or not
     *
     * @return bool
     */
    public static function isVendorExist($vendorId = null)
    {

        $vendor = parent::find($vendorId);
        if (! empty($vendor)) {
            return true;
        }

        return false;
    }

    /**
     * Route Notification For Mail
     */
    public function routeNotificationForMail(Notification $notification)
    {
        return false;
    }
}
