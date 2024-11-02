<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Models;

use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Rules\{
    CheckValidFile,
    CheckValidEmail,
    CheckValidPhone,
    StrengthPassword
};
use Modules\MediaManager\Http\Models\ObjectFile;
use Spatie\Activitylog\LogOptions;
use App\Models\{
    Wishlist,
    Review
};
use Validator;
use DB;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\Cachable;
use Laravel\Passport\HasApiTokens;
use App\Traits\ModelTraits\Metable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Modules\Blog\Http\Models\Blog;
use Modules\Shop\Http\Models\Shop;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable
{
    use Cachable;
    use CausesActivity;
    use HasApiTokens;
    use HasFactory;
    use hasFiles;
    use LogsActivity;
    use Metable;
    use ModelTrait;
    use Notifiable;

    protected $guard = 'web';

    protected $metaTable = 'users_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthday',
        'address',
        'gender',
        'status',
        'activation_code',
        'activation_otp',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Attributes to log.
     * Alternatively $logAttributesToIgnore can be used.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * Attributes (when updated) that don't trigger an activity being logged
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [];

    /**
     * Events that will get logged automatically
     * Accepted => 'created', 'updated', 'deleted'
     *
     * @var array
     */
    protected static $recordEvents = [];

    /**
     * Customized log name
     *
     * @var string
     */
    protected static $logName = 'USER EVENT';

    /**
     * Log only changed attributes on update event
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * Allow empty logs
     * Storing empty logs can happen when you only want to log a certain attribute but only another changes
     *
     * @var bool
     */
    protected static $submitEmptyLogs = false;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($user) {
            $activities = Activity::where('causer_type', '=', User::class)
                ->where('causer_id', '=', $user->id)->get();

            if (count($activities) > 0) {
                foreach ($activities as $activity) {
                    $activity->delete();
                }
            }
        });
    }

    /**
     * Relation with Role model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    /**
     * Get latest role
     *
     * @return App\Model\Role
     */
    public function role()
    {
        return $this->roles()->latest()->first();
    }

    /**
     * Relation with RoleUser model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function roleUser()
    {
        return $this->hasOne(RoleUser::class);
    }

    /**
     * Relation with Review model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relation with Order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relation with StockManagement model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockManagement()
    {
        return $this->hasMany(StockManagement::class);
    }

    /**
     * Relation with Favorite model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Relation with Wishlist model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Relation with VendorUser model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vendorUser()
    {
        return $this->hasOne('App\Models\VendorUser', 'user_id', 'id');
    }

    /**
     * Relation with File model
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function avatarFile()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'USER');
    }

    /**
     * Relation with CouponRedeem model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function couponRedeem()
    {
        return $this->hasMany(\Modules\Coupon\Http\Models\CouponRedeem::class);
    }

    /**
     * Relation with Address model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Relation with Wallet model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
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
     * Relation with Refund model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refunds()
    {
        return $this->hasMany(\Modules\Refund\Entities\Refund::class);
    }

    /**
     * Relation with RefundProcess model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refundProcesses()
    {
        return $this->hasMany(\Modules\Refund\Entities\RefundProcess::class);
    }

    /**
     * User single wallet
     *
     * @param  mixed  $currency
     *                           return mixed
     */
    public function wallet($currency = null)
    {
        if (optional($this->userWallet($currency))->count() == null && optional($this->createWallet($currency))) {
            return optional($this->userWallet($currency));
        }

        return optional($this->userWallet($currency));
    }

    /**
     * Relation with User withdrawal setting model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function withdrawalSettings()
    {
        return $this->hasMany(UserWithdrawalSetting::class);
    }

    /**
     * Relation with Order note history model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderNoteHistories()
    {
        return $this->hasMany(OrderNoteHistory::class);
    }

    /**
     * Relation with Blog model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Relation with Thread model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany('Modules\Ticket\Http\Models\Thread', 'assigned_member_id', 'id');
    }

    /**
     * relation with affiliate user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function affiliateUser()
    {
        return $this->hasOne('Modules\Affiliate\Entities\AffiliateUser', 'user_id', 'id');
    }

    /**
     * User wallet
     *
     * @param  mixed  $currency
     *                           return collection
     */
    private function userWallet($currency)
    {
        if (is_null($currency)) {
            return $this->wallets()->where('currency_id', preference('dflt_currency_id'))->first();
        }

        if (is_numeric($currency)) {
            return $this->wallets()->where('currency_id', $currency)->first();
        }

        if (is_string($currency)) {
            return $this->wallets()->whereHas('currency', function ($q) use ($currency) {
                return $q->where('name', $currency);
            })->first();
        }

        return collection();
    }

    /**
     * Create user wallet
     *
     * @param  mixed  $currency
     * @return bool
     */
    private function createWallet($currency)
    {
        $data['currency_id'] = preference('dflt_currency_id');
        $data['user_id'] = $this->id;
        $data['is_default'] = 1;

        if (is_numeric($currency)) {
            $data['currency_id'] = $currency;
        }

        return (new Wallet())->store($data);
    }

    /**
     * Relation with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_users');
    }

    /**
     * Vendor User Pivot Data
     *
     * @return collection
     */
    public function vendor()
    {
        return VendorUser::where('user_id', auth()->user()->id)->first();
    }

    /**
     * Vendor User Pivot Data
     *
     * @return collection
     */
    public function vendorApi()
    {
        return VendorUser::where('user_id', auth()->guard('api')->user()->id)->first();
    }

    /**
     * User Store Validation from frontend
     *
     * @param  array  $data
     * @param  bool  $captchaAction
     * @return mixed
     */
    protected static function siteStoreValidation($data = [], $captchaAction = true)
    {
        $captchaRule = 'nullable';
        if (isRecaptchaActive() && $captchaAction) {
            $data['gCaptcha'] = $data['g-recaptcha-response'] ?? null;
            $captchaRule = 'required|captcha';
        }
        $sendMail = isset($data['send_mail']) && strtolower($data['send_mail']) == 'on' ? 'on' : false;
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:191',
            'email' => ['required', 'max:191', 'unique:users,email', new CheckValidEmail()],
            'phone' => ['required', 'min:7', 'max:15', 'unique:users,phone', new CheckValidPhone()],
            'password' => ['required', 'max:191', 'confirmed', new StrengthPassword()],
            'status' => 'required|in:Pending,Active,Inactive,Deleted',
            'send_mail' => 'in:' . $sendMail,
            'attachment'  => [new CheckValidFile(getFileExtensions(2))],
            'gCaptcha' => $captchaRule,
        ]);

        return $validator;
    }

    /**
     * User Update Validation from frontend
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function siteUpdateValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:191',
            'email' => ['required', 'max:191', 'unique:users,email,' . $id, new CheckValidEmail()],
            'phone' => ['nullable', 'min:7', 'max:45', 'unique:users,phone,' . $id, new CheckValidPhone()],
            'birthday' => ['nullable', 'regex:/^[0-9]{1,4}[\/\-\.]{1}[0-9]{1,2}[\/\-\.]{1}[0-9]{1,4}$/'],
            'address' => 'nullable|max:200',
            'gender' => 'required|max:6|in:Male,Female',
            'image'  => ['nullable', new CheckValidFile(getFileExtensions(2)), 'max:' . preference('file_size') * 1024],
        ], [
            'gender.in' => __('Gender must be either Male or Female'),
            'image.max' => __('Maximum File Size :x MB.', ['x' => preference('file_size')]),
        ]);

        return $validator;
    }

    /**
     * User Password Update Validation from frontend
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function siteUpdatePasswordValidation($data = [])
    {
        $validator = Validator::make($data, [
            'old_password' => 'required|min:5|max:191',
            'new_password' => ['required', 'max:191', new StrengthPassword()],
            'confirm_password' => 'required|min:5|max:191|same:new_password',

        ]);

        return $validator;
    }

    /**
     * Update password validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updatePasswordValidation($data = [])
    {
        $sendMail = isset($data['send_mail']) && strtolower($data['send_mail']) == 'on' ? 'on' : false;
        $validator = Validator::make($data, [
            'password'    => ['required', new StrengthPassword()],
            'confirm_password' => 'required|same:password',
            'send_mail' => 'in:' . $sendMail,
        ]);

        return $validator;
    }

    /**
     * Update validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => ['required', 'unique:users,email,' . $id, new CheckValidEmail()],
            'phone' => ['nullable', 'min:7', 'max:15', 'unique:users,phone,' . $id, new CheckValidPhone()],
        ];

        if (Auth::user()->role()->slug != 'super-admin') {
            $rules['status'] = 'required|in:Pending,Active,Inactive,Deleted';
            $rules['role_ids'] = 'required';
        }
        $validator = Validator::make($data, $rules);

        return $validator;
    }

    /**
     * Update password validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateProfileValidation($data, $id)
    {
        $validator = Validator::make($data, [
            'name'        => 'required|min:3|max:191',
            'email'       => ['required', 'max:191', 'unique:users,email,' . $id, new CheckValidEmail()],
            'phone'       => ['required', 'max:15', 'unique:users,phone,' . $id, new CheckValidPhone()],
            'designation' => 'nullable|min:3|max:90',
            'description' => 'nullable|min:3|max:191',
            'facebook'    => 'nullable|url',
            'twitter'     => 'nullable|url',
            'instagram'   => 'nullable|url',
        ]);

        return $validator;
    }

    /**
     * Import validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function importValidation($data = [])
    {
        $validator = Validator::make($data, [
            'file' => 'required|mimes:csv,txt|max:1024',
        ], [
            'file.mimes' => __('The file must be a file of type: :x', ['x' => __('CSV')]),
        ]);

        return $validator;
    }

    /**
     * Store User data
     *
     * @param  array  $data
     * @return int|bool
     */
    public function store($data = [], $from = null, $url = null)
    {
        do_action('before_user_create', ['data' => $data, 'from' => $from, 'url' => $url]);

        $id = parent::insertGetId($data);
        if ($from == 'url') {
            $this->uploadFilesFromUrl($url, ['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => false, 'isSavedInObjectFiles' => true]);
        } else {
            $fileIds = [];
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
            }
            ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
        }
        if (! empty($id)) {
            self::forgetCache();
            do_action('after_user_create', $id);

            return $id;
        }

        return false;
    }

    /**
     * Update User
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updateUser($data = [], $id = null)
    {
        $result = parent::where('id', $id)->first();

        do_action('before_user_update', $result);

        if (is_null($result)) {
            return false;
        }

        if ($id == 1 && isset($data['userData']) && isset($data['userData']['status']) && $data['userData']['status'] == 'Deleted') {
            $data['userData']['status'] = 'Active';
        }

        $result->update($data['userData'] ?? $data);
        $result->updateFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);

        if (isset($data['userMetaData'])) {
            $result->setMeta($data['userMetaData']);
            $result->save();
        }

        self::forgetCache();

        do_action('after_user_update', $result);

        return true;
    }

    /**
     * Site Update User
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function siteUpdatePassword($data = [], $id = null)
    {
        $result = parent::where('id', $id);
        if ($result->exists()) {
            $result->update($data);
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Delete User
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];

        $checkSlugs = DB::table('roles')
            ->join('role_users', 'roles.id', '=', 'role_users.role_id')
            ->join('users', 'users.id', '=', 'role_users.user_id')
            ->select('roles.slug')
            ->where('users.id', $id)
            ->get();

        foreach ($checkSlugs as $key => $value) {
            if ($value->slug == 'super-admin') {
                $data['message'] = __("Admin account can't be deleted.");

                return $data;
            }
        }

        $user = parent::find($id);

        do_action('before_user_delete', $user);

        if (! empty($user)) {
            try {
                $user->delete();
                $user->deleteFiles(['thumbnail' => true]);

                DB::commit();

                do_action('after_user_delete', $user);

                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('User')]);
            } catch (Exception $e) {
                DB::rollBack();
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    /**
     * Get user data
     *
     * @param  array  $data
     * @return collection|bool
     */
    public function getData($token)
    {
        $reset = PasswordReset::where('otp', $token)->orWhere('token', $token)->first();
        $user = null;
        if (! empty($reset)) {
            $user = parent::where('email', $reset->email)->first();
        }

        return ! empty($user) ? $user : false;
    }

    /**
     * @return mixed
     */
    public static function totalWishlist()
    {
        return Wishlist::where('user_id', optional(\Auth::user())->id)->count();
    }

    /**
     * @return mixed
     */
    public static function totalReview()
    {
        return Review::where('user_id', optional(\Auth::user())->id)->count();
    }

    /**
     * @return mixed
     */
    public static function totalOrder()
    {
        return Order::where('user_id', optional(\Auth::user())->id)->count();
    }

    /**
     * Get user role slug
     *
     * @param  int  $userId
     * @return array
     */
    public static function getSlug($userId)
    {
        $roles = Role::select('slug')->whereIn('id', parent::getRoleIdsByUserId($userId))->get();
        $array = [];
        foreach ($roles as $key => $value) {
            $array[] = $value->slug;
        }

        return $array;
    }

    /**
     * Check verified user
     *
     * @param  int  $itemId
     * @return bool
     */
    public function verifiedUser($itemId)
    {
        return \DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'order_details.order_status_id', 'orders.user_id')
            ->where('order_details.product_id', $itemId)
            ->where('orders.user_id', $this->id)
            ->where('order_details.is_delivery', 1)
            ->count() > 0 ? true : false;
    }

    /**
     * Vendor Commission
     *
     * @param  int  $currencyId
     * @return float
     */
    public function vendorCommission($currencyId = null)
    {
        if (is_null($currencyId)) {
            $currencyId = preference('dflt_currency_id');
        }

        $commission = Transaction::where('vendor_id', session()->get('vendorId'))
            ->where('transaction_type', 'Commission')
            ->where('currency_id', $currencyId)
            ->where('status', 'Accepted')
            ->sum('total_amount');
        $refund = Transaction::where('vendor_id', session()->get('vendorId'))
            ->where('transaction_type', 'Refund Commission')
            ->where('currency_id', $currencyId)
            ->where('status', 'Accepted')
            ->sum('total_amount');

        return $commission - $refund;
    }

    /**
     * Check user verification type
     *
     * @param  string  $type
     * @return bool
     */
    public static function userVerification($type = null)
    {
        $verificationType = ['otp', 'token', 'both'];
        $preference = preference('email');

        if (is_null($type) || ! in_array($type, $verificationType)) {
            return false;
        }

        foreach ($verificationType as $key => $value) {
            if ($value == $type) {
                return $preference == 'both' || $preference == $value;
            }
        }
    }

    /**
     * Check user refund balance
     *
     * @return float $balance
     */
    public function refundBalance()
    {
        $refunds = static::refunds()->where('status', 'Accepted')->withSum('orderDetail as item_price', 'price')->get();
        $balance = 0;
        foreach ($refunds as $refund) {
            $balance += $refund->item_price * $refund->quantity_sent;
        }

        return $balance;
    }

    /**
     * Remove user profile picture
     *
     * @return bool
     */
    public function removeProfileImage()
    {
        if (parent::find(auth()->user()->id)->deleteFiles(['thumbnail' => false])) {
            return true;
        }

        return false;
    }

    /**
     * User Email Validation
     *
     * @param  array  $data
     * @return mixed
     */
    public function userEmailValidation($data = [])
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'max:191', 'unique:users,email', new CheckValidEmail()],
        ]);

        return $validator;
    }

    /**
     * Gets event description for activity model event logging
     * Used by spatie/laravel-activitylog
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    /**
     * Is user purchase the product
     *
     * @param  int  $productId
     * @return bool
     */
    public function isPurchaseProduct($productId)
    {
        return Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('order_details.product_id', 'order_details.order_status_id', 'orders.user_id')
            ->where('order_details.product_id', $productId)
            ->where('orders.user_id', $this->id)
            ->count() > 0 ? true : false;
    }

    /**
     * Get of the shop for the user.
     */
    public function shop()
    {
        return Shop::where('vendor_id', $this->vendor()->vendor_id)->first();
    }

    /**
     * Implements the getActivitylogOptions abstract method
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName(self::$logName)
            ->logOnly(self::$logAttributes)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => "User model has been {$eventName}");
    }

    public function routeNotificationForMail(Notification $notification)
    {
        return false;
    }
}
